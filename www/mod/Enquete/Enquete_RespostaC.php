<?php
class Enquete_RespostaControle extends Enquete_Controle
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
    public function Main($enquete = false) {
        return false; 
    }
    static function Endereco_Resposta($enquete=false,$true=true) {
        Enquete_EnqueteControle::Endereco_Enquete();
        $Registro = &\Framework\App\Registro::getInstacia();
        $_Controle = $Registro->_Controle;
        
        $link_extra = '';
        if ($enquete!==false) {
            $link_extra = '/'.$enquete;
        }
        
        if ($true===true) {
            $_Controle->Tema_Endereco(__('Respostas'),'Enquete/Resposta/Respostas'.$link_extra);
        } else {
            $_Controle->Tema_Endereco(__('Respostas'));
        }
    }
    static function Respostas_Tabela(&$respostas) {
        $Registro   = &\Framework\App\Registro::getInstacia();
        $Modelo     = &$Registro->_Modelo;
        $Visual     = &$Registro->_Visual;
        $tabela = Array();
        $i = 0;
        if (is_object($respostas)) $respostas = Array(0=>$respostas);
        reset($respostas);
        $qnt_votos_totais = 0;
        $perm_editar = $Registro->_Acl->Get_Permissao_Url('Enquete/Resposta/Respostas_Edit');
        $perm_del = $Registro->_Acl->Get_Permissao_Url('Enquete/Resposta/Respostas_Del');

        foreach ($respostas as &$valor) {
            $resp_votos = $Modelo->db->Sql_Select('Enquete_Voto',Array(
                'enquete'   =>  $valor->enquete,
                'resposta'  =>  $valor->id
            ),0,'','enquete,resposta');
            if ($resp_votos===false) {
                $valor->qnt_votos = 0;
            } else if (is_object($resp_votos)) {
                $valor->qnt_votos = 1;
            } else {
                $valor->qnt_votos = count($resp_votos);
            }
            $qnt_votos_totais += $valor->qnt_votos;
        }
        reset($respostas);
        foreach ($respostas as &$valor) {
            $tabela['Nome'][$i]             = $valor->nome;
            $tabela['Votos'][$i]            = $valor->qnt_votos.' / '.$qnt_votos_totais;
            $tabela['Data Registrado'][$i]  = $valor->log_date_add;
            $tabela['Funções'][$i]          = $Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Resposta'        ,'Enquete/Resposta/Respostas_Edit/'.$valor->enquete.'/'.$valor->id.'/'    ,''),$perm_editar).
                                              $Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Resposta'       ,'Enquete/Resposta/Respostas_Del/'.$valor->enquete.'/'.$valor->id.'/'     ,'Deseja realmente deletar essa Resposta ?'),$perm_del);
            ++$i;
        }
        return Array($tabela,$i);
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Respostas($enquete=false, $export=false) {
        if ($enquete===false) {
            return _Sistema_erroControle::Erro_Fluxo('Enquete não existe:'. $enquete,404);
        }
        $enquete = (int) $enquete;
        if ($enquete==0) {
            $enquete_registro = $this->_Modelo->db->Sql_Select('Enquete',Array(),1,'id DESC');
            if ($enquete_registro===false) {
                return _Sistema_erroControle::Erro_Fluxo('Não existe nenhuma enquete:',404);
            }
            $enquete = $enquete_registro->id;
        } else {
            $enquete_registro = $this->_Modelo->db->Sql_Select('Enquete',Array('id'=>$enquete),1);
            if ($enquete_registro===false) {
                return _Sistema_erroControle::Erro_Fluxo('Essa Enquete não existe:',404);
            }
        }
        self::Endereco_Resposta($enquete,false);
        $where = Array(
            'enquete'   => $enquete,
        );
        $i = 0;
        // Botao Add
        $this->_Visual->Blocar($this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            Array(
                'Adicionar Resposta',
                'Enquete/Resposta/Respostas_Add/'.$enquete,
                ''
            ),
            Array(
                'Print'     => TRUE,
                'Pdf'       => TRUE,
                'Excel'     => TRUE,
                'Link'      => 'Enquete/Resposta/Respostas/'.$enquete,
            )
        )));
        // Conexao
        $respostas = $this->_Modelo->db->Sql_Select('Enquete_Resposta',$where);
        if ($respostas!==false && !empty($respostas)) {
            list($tabela,$i) = self::Respostas_Tabela($respostas);
            $titulo = 'Listagem de Respostas: '.$enquete_registro->nome.' ('.$i.')';
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
            $titulo = 'Listagem de Respostas: '.$enquete_registro->nome.' ('.$i.')';  
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhuma Resposta</font></b></center>');
        }
        $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Administrar Respostas'));
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Respostas_Add($enquete = false) {
        self::Endereco_Resposta($enquete);
        // Carrega Config
        $titulo1    = __('Adicionar Resposta');
        $titulo2    = __('Salvar Resposta');
        $formid     = 'form_Sistema_Admin_Respostas';
        $formbt     = __('Salvar');
        $campos     = Enquete_Resposta_DAO::Get_Colunas();
        if ($enquete===false) {
            $formlink   = 'Enquete/Resposta/Respostas_Add2';
        } else {
            $enquete = (int) $enquete;
            $formlink   = 'Enquete/Resposta/Respostas_Add2/'.$enquete;
            self::DAO_Campos_Retira($campos,'enquete');
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
    public function Respostas_Add2($enquete=false) {
        $titulo     = __('Resposta Adicionada com Sucesso');
        $dao        = 'Enquete_Resposta';
        $sucesso1   = __('Inserção bem sucedida');
        $sucesso2   = __('Resposta cadastrada com sucesso.');
        if ($enquete===false) {
            $funcao     = '$this->Respostas(0);';
            $alterar    = Array();
        } else {
            $enquete = (int) $enquete;
            $alterar    = Array('enquete'=>$enquete);
            $funcao     = '$this->Respostas('.$enquete.');';
        }
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);
    }
    /**
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Respostas_Edit($enquete = false,$id) {
        if ($enquete===false) {
            return _Sistema_erroControle::Erro_Fluxo('Enquete não existe:'. $enquete,404);
        }
        if ($id===false) {
            return _Sistema_erroControle::Erro_Fluxo('Resposta não existe:'. $id,404);
        }
        self::Endereco_Resposta($enquete);
        $id         = (int) $id;
        $enquete    = (int) $enquete;
        // Carrega Config
        $titulo1    = 'Editar Resposta (#'.$id.')';
        $titulo2    = __('Alteração de Resposta');
        $formid     = 'form_Sistema_AdminC_RespostaEdit';
        $formbt     = __('Alterar Resposta');
        $formlink   = 'Enquete/Resposta/Respostas_Edit2/'.$enquete.'/'.$id;
        $editar     = Array('Enquete_Resposta',$id);
        $campos = Enquete_Resposta_DAO::Get_Colunas();
        self::DAO_Campos_Retira($campos,'enquete');
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos,$editar);
    }
    /**
     * 
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Respostas_Edit2($enquete = false,$id) {
        if ($enquete===false) {
            return _Sistema_erroControle::Erro_Fluxo('Enquete não existe:'. $enquete,404);
        }
        if ($id===false) {
            return _Sistema_erroControle::Erro_Fluxo('Resposta não existe:'. $id,404);
        }
        $id         = (int) $id;
        $enquete    = (int) $enquete;
        $titulo     = __('Resposta Editada com Sucesso');
        $dao        = Array('Enquete_Resposta',$id);
        $funcao     = '$this->Respostas('.$enquete.');';
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
    public function Respostas_Del($enquete=false,$id = false) {
        
        if ($enquete===false) {
            return _Sistema_erroControle::Erro_Fluxo('Enquete não existe:'. $enquete,404);
        }
        if ($id===false) {
            return _Sistema_erroControle::Erro_Fluxo('Resposta não existe:'. $id,404);
        }
        // Antiinjection
    	$id = (int) $id;
        $enquete = (int) $enquete;
        // Puxa resposta e deleta
        $resposta = $this->_Modelo->db->Sql_Select('Enquete_Resposta', Array('enquete'=>$enquete,'id'=>$id));
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
        $this->Respostas($enquete);
        
        $this->_Visual->Json_Info_Update('Titulo', __('Resposta deletada com Sucesso'));
        $this->_Visual->Json_Info_Update('Historico', false);
    }
}
?>
