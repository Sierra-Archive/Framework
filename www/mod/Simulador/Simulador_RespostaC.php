<?php
class Simulador_RespostaControle extends Simulador_Controle
{
    public function __construct() {
        parent::__construct();
    }
    /**
    * Main
    * 
    * @name Main
    * @access public
    * 
    * @uses resposta_Controle::$comercioPerfil
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 0.4.2
    */
    public function Main($simulador = false,$pergunta=false) {
        \Framework\App\Sistema_Funcoes::Redirect(URL_PATH.'Simulador/Resposta/Respostas');
        return false;
    }
    static function Endereco_Resposta($true=true,$simulador=false, $pergunta=false) {
        $Registro = &\Framework\App\Registro::getInstacia();
        $_Controle = $Registro->_Controle;
        if ($simulador===false) {
            $titulo = __('Todas as Respostas');
            $link   = 'Simulador/Resposta/Respostas';
        } else {
            $titulo = $simulador->nome;
            $link   = 'Simulador/Pergunta/Perguntas/'.$simulador->id;
            if ($pergunta!==false) {
                Simulador_PerguntaControle::Endereco_Pergunta(true, $simulador);
                $_Controle->Tema_Endereco($titulo,$link);
                $titulo = $pergunta->nome;
                $link   = 'Simulador/Resposta/Respostas/'.$simulador->id.'/'.$pergunta->id;
            } else {
                Simulador_SimuladorControle::Endereco_Simulador();
            }
        }
        if ($true===true) {
            $_Controle->Tema_Endereco($titulo,$link);
        } else {
            $_Controle->Tema_Endereco($titulo);
        }
    }
    static function Respostas_Tabela(&$respostas,$simulador=false,$pergunta=false) {
        $Registro   = &\Framework\App\Registro::getInstacia();
        $Modelo     = &$Registro->_Modelo;
        $Visual     = &$Registro->_Visual;
        $tabela = Array();
        $i = 0;
        if (is_object($respostas)) $respostas = Array(0=>$respostas);
        reset($respostas);
        foreach ($respostas as &$valor) {
            if ($simulador===false || $simulador==0) {
                $tabela['Simulador'][$i]   = $valor->simulador2;
                $tabela['Pergunta'][$i]   = $valor->pergunta2;
                $view_url   = 'Simulador/Video/Videos/'.$valor->simulador.'/';
                $edit_url   = 'Simulador/Resposta/Respostas_Edit/'.$valor->id.'/';
                $del_url    = 'Simulador/Resposta/Respostas_Del/'.$valor->id.'/';
            } else {
                if ($pergunta===false || $pergunta==0) {
                    $tabela['Pergunta'][$i]   = $valor->pergunta2;
                    //$view_url   = 'Simulador/Video/Videos/'.$valor->simulador.'/'.$valor->pergunta.'/';
                    $edit_url   = 'Simulador/Resposta/Respostas_Edit/'.$valor->id.'/'.$valor->simulador.'/';
                    $del_url    = 'Simulador/Resposta/Respostas_Del/'.$valor->id.'/'.$valor->simulador.'/';
                } else {
                    //$view_url   = 'Simulador/Video/Videos/'.$valor->simulador.'/'.$valor->pergunta.'/'.$valor->id.'/';
                    $edit_url   = 'Simulador/Resposta/Respostas_Edit/'.$valor->id.'/'.$valor->simulador.'/'.$valor->pergunta.'/';
                    $del_url    = 'Simulador/Resposta/Respostas_Del/'.$valor->id.'/'.$valor->simulador.'/'.$valor->pergunta.'/'.$valor->i.'/';
                }
            }
            $tabela['Resposta'][$i]           = $valor->nome;
            $tabela['Data Registrada no Sistema'][$i]  = $valor->log_date_add;
            $status                                 = $valor->status;
            if ($status!=1) {
                $status = 0;
                $texto = __('Desativado');
            } else {
                $status = 1;
                $texto = __('Ativado');
            }
            $tabela['Funções'][$i]          = //$Visual->Tema_Elementos_Btn('Visualizar' ,Array('Visualizar Videos da Resposta'    ,$view_url    ,'')).
                                              '<span id="status'.$valor->id.'">'.$Visual->Tema_Elementos_Btn('Status'.$status     ,Array($texto        ,'Simulador/Resposta/Status/'.$valor->id.'/'    ,'')).'</span>'.
                                              $Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Resposta'        ,$edit_url    ,'')).
                                              $Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Resposta'       ,$del_url     ,'Deseja realmente deletar essa Resposta ?'));
            ++$i;
        }
        return Array($tabela,$i);
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Respostas($simulador=false,$pergunta=false,$export=false) {
        if ($simulador ==='false' || $simulador ===0)  $simulador    = false;
        if ($pergunta ==='false' || $pergunta ===0)  $pergunta      = false;
        if ($simulador!==false) {
            $simulador = (int) $simulador;
            if ($simulador==0) {
                $resposta_registro = $this->_Modelo->db->Sql_Select('Simulador',Array(),1,'id DESC');
                if ($resposta_registro===false) {
                    return _Sistema_erroControle::Erro_Fluxo('Essa resposta não existe',404);
                }
                $simulador_registro = $this->_Modelo->db->Sql_Select('Simulador_Pergunta',Array('id'=>$resposta_registro->simulador),1);
                if ($simulador_registro===false) {
                    return _Sistema_erroControle::Erro_Fluxo('Não existe nenhum simulador com esse id:',404);
                }
                $simulador = $simulador_registro->id;
            } else {
                $simulador_registro = $this->_Modelo->db->Sql_Select('Simulador',Array('id'=>$simulador),1);
                if ($simulador_registro===false) {
                    return _Sistema_erroControle::Erro_Fluxo('Esse Simulador não existe:',404);
                }
            }
            $where = Array(
                'simulador'   => $simulador,
            );
            if ($pergunta!==false) {
                $pergunta = (int) $pergunta;
                if ($pergunta==0) {
                    $resposta_registro = $this->_Modelo->db->Sql_Select('Simulador_Pergunta_Resposta',Array(),1,'id DESC');
                    if ($resposta_registro===false) {
                        return _Sistema_erroControle::Erro_Fluxo('Essa Resposta não existe',404);
                    }
                    $pergunta_registro = $this->_Modelo->db->Sql_Select('Simulador_Pergunta',Array('id'=>$resposta_registro->pergunta,'simulador'=>$simulador),1);
                    if ($pergunta_registro===false) {
                        return _Sistema_erroControle::Erro_Fluxo('Não existe nenhum pergunta com esse id nesse Simulador',404);
                    }
                    $pergunta = $pergunta_registro->id;
                } else {
                    $pergunta_registro = $this->_Modelo->db->Sql_Select('Simulador_Pergunta',Array('id'=>$pergunta,'simulador'=>$simulador),1);
                    if ($pergunta_registro===false) {
                        return _Sistema_erroControle::Erro_Fluxo('Esse Pergunta não existe.',404);
                    }
                }
                $where['pergunta'] = $pergunta;
                self::Endereco_Resposta(false, $simulador_registro, $pergunta_registro);
                $titulo_add = __('Adicionar nova Resposta desse Pergunta');
                $url_add = '/'.$simulador.'/'.$pergunta;
                $titulo = 'Listagem de Respostas do Pergunta '.$pergunta_registro->nome;
                $erro = __('Nenhuma Resposta nesse Pergunta');
            } else {
                $where = Array();
                self::Endereco_Resposta(false, $simulador_registro, false);
                $titulo_add = 'Adicionar nova Resposta ao Simulador: '.$simulador_registro->nome;
                $url_add = '/'.$simulador.'/false';
                $titulo = 'Listagem de Respostas: '.$simulador_registro->nome;
                $erro = __('Nenhuma Resposta desse Simulador');
            }
        } else {
            $where = Array();
            self::Endereco_Resposta(false, false, false);
            $titulo_add = __('Adicionar nova Resposta');
            $url_add = '/false/false';
            $titulo = __('Listagem de Respostas em Todos os Simuladores');
            $erro = __('Nenhuma Resposta nos Simuladores');
        }
        $add_url = 'Simulador/Resposta/Respostas_Add'.$url_add;
        $i = 0;
        $this->_Visual->Blocar($this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            Array(
                $titulo_add,
                $add_url,
                ''
            ),
            Array(
                'Print'     => TRUE,
                'Pdf'       => TRUE,
                'Excel'     => TRUE,
                'Link'      => 'Simulador/Resposta/Respostas'.$url_add,
            )
        )));
        $respostas = $this->_Modelo->db->Sql_Select('Simulador_Pergunta_Resposta',$where);
        if ($respostas!==false && !empty($respostas)) {
            list($tabela,$i) = self::Respostas_Tabela($respostas,$simulador,$pergunta);
            $titulo = $titulo.' ('.$i.')';
            if ($export!==false) {
                self::Export_Todos($export,$tabela, $titulo);
            } else {
                $this->_Visual->Show_Tabela_DataTable(
                    $tabela,     // Array Com a Tabela
                    '',          // style extra
                    true,        // true -> Add ao Bloco, false => Retorna html
                    false,        // Apagar primeira coluna ?
                    Array(       // Ordenacao
                        Array(
                            0,'desc'
                        )
                    )
                );
            }
            unset($tabela);
        } else {
            $titulo = $titulo.' ('.$i.')';
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">'.$erro.'</font></b></center>');
        }
        $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo',$titulo);
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Respostas_Add($simulador = false,$pergunta=false) {
        if ($simulador==='false') $simulador = false;
        if ($pergunta==='false') $pergunta = false;
        
        // Carrega Config
        $formid     = 'form_Simulador_Resposta_Respostas';
        $formbt     = __('Salvar');
        $campos     = Simulador_Pergunta_Resposta_DAO::Get_Colunas();
        if ($simulador===false) {
            $formlink   = 'Simulador/Resposta/Respostas_Add2';
            $titulo1    = __('Adicionar Resposta');
            $titulo2    = __('Salvar Resposta');
            self::Endereco_Resposta(true, false, false);
        } else {
            $simulador = (int) $simulador;
            if ($simulador==0) {
                $resposta_registro = $this->_Modelo->db->Sql_Select('Simulador_Pergunta_Resposta',Array(),1,'id DESC');
                if ($resposta_registro===false) {
                    return _Sistema_erroControle::Erro_Fluxo('Essa resposta não existe',404);
                }
                $simulador_registro = $this->_Modelo->db->Sql_Select('Simulador',Array('id'=>$resposta_registro->simulador),1);
                if ($simulador_registro===false) {
                    return _Sistema_erroControle::Erro_Fluxo('Não existe nenhuma simulador:',404);
                }
                $simulador = $simulador_registro->id;
            } else {
                $simulador_registro = $this->_Modelo->db->Sql_Select('Simulador',Array('id'=>$simulador),1);
                if ($simulador_registro===false) {
                    return _Sistema_erroControle::Erro_Fluxo('Esse Simulador não existe:',404);
                }
            }
            self::DAO_Campos_Retira($campos,'simulador');
            if ($pergunta===false) {
                self::DAO_Ext_Alterar($campos,'pergunta',$simulador);
                $formlink   = 'Simulador/Resposta/Respostas_Add2/'.$simulador;
                $titulo1    = 'Adicionar Resposta ao Simulador: '.$simulador_registro->nome ;
                $titulo2    = 'Salvar Resposta ao Simulador: '.$simulador_registro->nome ;
                self::Endereco_Resposta(true, $simulador_registro, false);
            } else {
                $pergunta = (int) $pergunta;
                if ($pergunta==0) {
                    $resposta_registro = $this->_Modelo->db->Sql_Select('Simulador_Pergunta_Resposta',Array(),1,'id DESC');
                    if ($resposta_registro===false) {
                        return _Sistema_erroControle::Erro_Fluxo('Essa resposta não existe',404);
                    }
                    $pergunta_registro = $this->_Modelo->db->Sql_Select('Simulador_Pergunta',Array('id'=>$resposta_registro->pergunta,'simulador'=>$simulador),1);
                    if ($pergunta_registro===false) {
                        return _Sistema_erroControle::Erro_Fluxo('Não existe nenhum Pergunta:',404);
                    }
                    $pergunta = $pergunta_registro->id;
                } else {
                    $pergunta_registro = $this->_Modelo->db->Sql_Select('Simulador_Pergunta',Array('id'=>$pergunta,'simulador'=>$simulador),1);
                    if ($pergunta_registro===false) {
                        return _Sistema_erroControle::Erro_Fluxo('Esse Pergunta não existe:',404);
                    }
                }
                $formlink   = 'Simulador/Resposta/Respostas_Add2/'.$simulador.'/'.$pergunta;
                self::DAO_Campos_Retira($campos,'pergunta');
                $titulo1    = 'Adicionar Resposta para a Pergunta '.$pergunta_registro->nome ;
                $titulo2    = 'Salvar Resposta para a Pergunta '.$pergunta_registro->nome ;
                self::Endereco_Resposta(true, $simulador_registro, $pergunta_registro);
            }
        }
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos);
    }
    /**
     * 
     * 
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Respostas_Add2($simulador=false,$pergunta=false) {
        if ($simulador==='false') $simulador = false;
        if ($pergunta==='false') $pergunta = false;
        
        $titulo     = __('Resposta Adicionada com Sucesso');
        $dao        = 'Simulador_Pergunta_Resposta';
        $sucesso1   = __('Inserção bem sucedida');
        $sucesso2   = __('Resposta cadastrada com sucesso.');
        // Recupera Respostas
        if ($simulador!==false) {
            $simulador = (int) $simulador;
            $alterar    = Array('simulador'=>$simulador);
            if ($pergunta!==false) {
                $pergunta = (int) $pergunta;
                $funcao     = '$this->Respostas('.$simulador.', '.$pergunta.');';
                $alterar['pergunta'] = $pergunta;
            } else {
                $funcao     = '$this->Respostas('.$simulador.');';
            }
        } else {
            $alterar    = Array();
            $funcao     = '$this->Respostas(0,0);';
        }
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);
    }
    /**
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Respostas_Edit($id,$simulador = false,$pergunta=false) {
        if ($simulador==='false') $simulador = false;
        if ($pergunta==='false') $pergunta = false;
        if ($id===false) {
            return _Sistema_erroControle::Erro_Fluxo('Resposta não existe:'. $id,404);
        }
        $id         = (int) $id;
        if ($simulador!==false) {
            $simulador    = (int) $simulador;
        }
        // Carrega Config
        $titulo1    = 'Editar Resposta (#'.$id.')';
        $titulo2    = __('Alteração de Resposta');
        $formid     = 'form_Simulador_RespostaC_RespostaEdit';
        $formbt     = __('Alterar Resposta');
        $campos = Simulador_Pergunta_Resposta_DAO::Get_Colunas();
        if ($simulador!==false) {
            $simulador_registro = $this->_Modelo->db->Sql_Select('Simulador',Array('id'=>$simulador),1);
            if ($simulador_registro===false) {
                return _Sistema_erroControle::Erro_Fluxo('Esse Simulador não existe:',404);
            }
            if ($pergunta!==false) {
                $pergunta_registro = $this->_Modelo->db->Sql_Select('Simulador_Pergunta',Array('id'=>$simulador,'simulador'=>$simulador_registro->id),1);
                if ($pergunta_registro===false) {
                    return _Sistema_erroControle::Erro_Fluxo('Esse Simulador não existe:',404);
                }
                $formlink   = 'Simulador/Resposta/Respostas_Edit2/'.$id.'/'.$simulador.'/'.$pergunta;
                self::DAO_Campos_Retira($campos,'simulador');
                self::DAO_Campos_Retira($campos,'pergunta');
                self::Endereco_Resposta(true, $simulador_registro);
            } else {
                self::DAO_Ext_Alterar($campos,'pergunta',$simulador);
                $formlink   = 'Simulador/Resposta/Respostas_Edit2/'.$id.'/'.$simulador;
                self::DAO_Campos_Retira($campos,'simulador');
                self::Endereco_Resposta(true, $simulador_registro);
            }
        } else {
            $formlink   = 'Simulador/Resposta/Respostas_Edit2/'.$id;
            self::Endereco_Resposta(true, false);
        }
        $editar     = Array('Simulador_Pergunta_Resposta',$id);
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos,$editar);
    }
    /**
     * 
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Respostas_Edit2($id,$simulador = false,$pergunta=false) {
        if ($simulador==='false') $simulador = false;
        if ($pergunta==='false') $pergunta = false;
        if ($id===false) {
            return _Sistema_erroControle::Erro_Fluxo('Resposta não existe:'. $id,404);
        }
        $id         = (int) $id;
        if ($simulador!==false) {
            $simulador    = (int) $simulador;
        }
        if ($pergunta!==false) {
            $pergunta    = (int) $pergunta;
        }
        $titulo     = __('Resposta Editada com Sucesso');
        $dao        = Array('Simulador_Pergunta_Resposta',$id);
        // Recupera Respostas
        if ($simulador!==false) {
            if ($pergunta!==false) {
                $funcao     = '$this->Respostas('.$simulador.', '.$pergunta.');';
            } else {
                $funcao     = '$this->Respostas('.$simulador.');';
            }
        } else {
            $funcao     = '$this->Respostas();';
        }
        $sucesso1   = __('Resposta Alterada com Sucesso.');
        $sucesso2   = ''.$_POST["nome"].' teve a alteração bem sucedida';
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);   
    }
    /**
     * 
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Respostas_Del($id = false,$simulador=false,$pergunta=false) {
        if ($simulador==='false') $simulador = false;
        if ($pergunta==='false') $pergunta = false;
        
        if ($id===false) {
            return _Sistema_erroControle::Erro_Fluxo('Resposta não existe:'. $id,404);
        }
        // Antiinjection
    	$id = (int) $id;
        if ($simulador!==false) {
            $simulador    = (int) $simulador;
            $where = Array('simulador'=>$simulador,'id'=>$id);
        } else {
            $where = Array('id'=>$id);
        }
        // Puxa resposta e deleta
        $resposta = $this->_Modelo->db->Sql_Select('Simulador_Pergunta_Resposta', $where);
        $sucesso =  $this->_Modelo->db->Sql_Delete($resposta);
        // Mensagem
    	if ($sucesso===true) {
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Deletado'),
                "mgs_secundaria" => __('Resposta deletada com sucesso')
            );
    	} else {
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Erro')
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        // Recupera Respostas
        if ($simulador!==false) {
            if ($pergunta!==false) {
                $this->Respostas($simulador,$pergunta);
            } else {
                $this->Respostas($simulador);
            }
        } else {
            $this->Respostas();
        }
        
        $this->_Visual->Json_Info_Update('Titulo', __('Resposta deletada com Sucesso'));
        $this->_Visual->Json_Info_Update('Historico', false);
    }
    public function Status($id=false) {
        if ($id===false) {
            return false;
        }
        $resultado = $this->_Modelo->db->Sql_Select('Simulador_Pergunta_Resposta', Array('id'=>$id),1);
        if ($resultado===false || !is_object($resultado)) {
            return false;
        }
        if ($resultado->status=='1') {
            $resultado->status='0';
        } else {
            $resultado->status='1';
        }
        $sucesso = $this->_Modelo->db->Sql_Update($resultado);
        if ($sucesso) {
            if ($resultado->status==1) {
                $texto = __('Ativado');
            } else {
                $texto = __('Desativado');
            }
            $conteudo = array(
                'location' => '#status'.$resultado->id,
                'js' => '',
                'html' =>  $this->_Visual->Tema_Elementos_Btn('Status'.$resultado->status     ,Array($texto        ,'Simulador/Resposta/Status/'.$resultado->id.'/'    ,''))
            );
            $this->_Visual->Json_IncluiTipo('Conteudo',$conteudo);
            $this->_Visual->Json_Info_Update('Titulo', __('Status Alterado')); 
        } else {
            $mensagens = array(
                "tipo"              => 'erro',
                "mgs_principal"     => __('Erro'),
                "mgs_secundaria"    => __('Ocorreu um Erro.')
            );
            $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);

            $this->_Visual->Json_Info_Update('Titulo', __('Erro')); 
        }
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
}
?>
