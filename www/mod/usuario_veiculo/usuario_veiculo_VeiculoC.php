<?php
class usuario_veiculo_VeiculoControle extends usuario_veiculo_Controle
{
    /**
    * Construtor
    * 
    * @name __construct
    * @access public
    * 
    * @uses usuario_veiculo_ListarModelo Carrega usuario_veiculo Modelo
    * @uses usuario_veiculo_ListarVisual Carrega usuario_veiculo Visual
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 0.4.24
    */
    public function __construct() {
        parent::__construct();
    }
    static function Campos_Deletar(&$campos) {
        self::DAO_Campos_Retira($campos, 'franquia');
        if (!\Framework\App\Sistema_Funcoes::Perm_Modulos('usuario_veiculo_aluguel')) {
            self::DAO_Campos_Retira($campos, 'cc');
            self::DAO_Campos_Retira($campos, 'aluguel_disponivel');
            self::DAO_Campos_Retira($campos, 'valor1');
            self::DAO_Campos_Retira($campos, 'valor2');
            self::DAO_Campos_Retira($campos, 'valor3');
        }
        if (!\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('usuario_veiculo_VeiculoIPVA')) {
            self::DAO_Campos_Retira($campos, 'ipva');
            self::DAO_Campos_Retira($campos, 'ipva_valor');
            self::DAO_Campos_Retira($campos, 'ipva_data');
        }
        if (!\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('usuario_veiculo_VeiculoREVISAO')) {
            self::DAO_Campos_Retira($campos, 'revisao');
        }
        if (!\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('usuario_veiculo_VeiculoAVALIACAO')) {
            self::DAO_Campos_Retira($campos, 'data_avaliacao');
        }
        if (!\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('usuario_veiculo_VeiculoVALOR')) {
            self::DAO_Campos_Retira($campos, 'valor');
        }
        if (!\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('usuario_veiculo_VeiculoVISTORIA')) {
            self::DAO_Campos_Retira($campos, 'data_vistoria');
            self::DAO_Campos_Retira($campos, 'data_vistoria2');
        }
        if (!\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('usuario_veiculo_VeiculoRENAVAN')) {
            self::DAO_Campos_Retira($campos, 'renavan');
        }
        if (!\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('usuario_veiculo_VeiculoOBS')) {
            self::DAO_Campos_Retira($campos, 'obs');
        }
    }
    /**
    * Main
    * 
    * @name Main
    * @access public
    * 
    * @uses usuario_veiculo_Controle::$usuario_veiculoPerfil
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 0.4.24
    */
    public function Main() {
        return false; 
    }
    static function Endereco_Veiculo($true= true ) {
        $Registro = &\Framework\App\Registro::getInstacia();
        $_Controle = $Registro->_Controle;
        $titulo = __('Veiculos');
        $link   = 'usuario_veiculo/Veiculo/Veiculos';
        if ($true === true) {
            $_Controle->Tema_Endereco($titulo, $link);
        } else {
            $_Controle->Tema_Endereco($titulo);
        }
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.24
     */
    public function Veiculos($export = false) {
        self::Endereco_Veiculo(false);
        $i = 0;
        $this->_Visual->Blocar($this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            Array(
                'Adicionar Veiculo',
                'usuario_veiculo/Veiculo/Veiculos_Add',
                ''
            ),
            Array(
                'Print'     => true,
                'Pdf'       => true,
                'Excel'     => true,
                'Link'      => 'usuario_veiculo/Veiculo/Veiculos',
            )
        )));
        $linhas = $this->_Modelo->db->Sql_Select('Usuario_Veiculo');
        if ($linhas !== false && !empty($linhas)) {
            if (is_object($linhas)) $linhas = Array(0=>$linhas);
            reset($linhas);
            foreach ($linhas as $indice=>&$valor) {
                //$table[__('#Id')][$i]       = '#'.$valor->id;
                $table[__('Tipo de Veiculo')][$i]            = $valor->categoria2;
                $table[__('Marca')][$i]                = $valor->marca2;
                $table[__('Modelo')][$i]               = $valor->modelo2;
                $table[__('Ano')][$i]                  = $valor->ano;
                if (\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('usuario_veiculo_VeiculoIPVA')) {
                    $table[__('IPVA')][$i]                 = $valor->ipva;
                }
                if (\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('usuario_veiculo_VeiculoVALOR')) {
                    $table[__('Valor do Veiculo')][$i]     = $valor->valor;
                }
                $table[__('Funções')][$i]   = /*$this->_Visual->Tema_Elementos_Btn('Visualizar'      ,Array(__('Visualizar Veiculo')    ,'usuario_veiculo/Veiculo/Veiculos_Popup/'.$valor->id.'/'    , '')).*/
                                           $this->_Visual->Tema_Elementos_Btn('Zoom'            ,Array(__('Visualizar Veiculo')                     ,'usuario_veiculo/Veiculo/Veiculos_View/'.$valor->id.'/'    , '')).
                                           $this->_Visual->Tema_Elementos_Btn('Editar'          ,Array(__('Editar Veiculo')                         ,'usuario_veiculo/Veiculo/Veiculos_Edit/'.$valor->id.'/'    , '')).
                                           $this->_Visual->Tema_Elementos_Btn('Deletar'         ,Array(__('Deletar Veiculo')                        ,'usuario_veiculo/Veiculo/Veiculos_Del/'.$valor->id.'/'     , __('Deseja realmente deletar esse Veiculo ?')));
                ++$i;
            }
            if ($export !== false) {
                self::Export_Todos($export, $table, 'Veiculos');
            } else {
                $this->_Visual->Show_Tabela_DataTable($table);
            }
            unset($table);
        } else {     
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhum Veiculo</font></b></center>');
        }
        $titulo = __('Listagem de Veiculos').' ('.$i.')';
        $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Administrar Veiculos'));
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.24
     */
    public function Veiculos_Add() {
        self::Endereco_Veiculo(true);
        // Carrega Config
        $titulo1    = __('Adicionar Veiculo');
        $titulo2    = __('Salvar Veiculo');
        $formid     = 'form_Sistema_Admin_Veiculos';
        $formbt     = __('Salvar');
        $formlink   = 'usuario_veiculo/Veiculo/Veiculos_Add2/';
        $campos = Usuario_Veiculo_DAO::Get_Colunas();
        self::Campos_Deletar($campos);
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1, $titulo2, $formlink, $formid, $formbt, $campos);
    }
    /**
     * 
     * 
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.24
     */
    public function Veiculos_Add2() {
        $titulo     = __('Veiculo Adicionado com Sucesso');
        $dao        = 'Usuario_Veiculo';
        $function     = '$this->Veiculos();';
        $sucesso1   = __('Inserção bem sucedida');
        $sucesso2   = __('Veiculo cadastrado com sucesso.');
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo, $dao, $function, $sucesso1, $sucesso2, $alterar);
    }
    /**
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.24
     */
    public function Veiculos_Edit($id) {
        self::Endereco_Veiculo(true);
        // Carrega Config
        $titulo1    = 'Editar Veiculo (#'.$id.')';
        $titulo2    = __('Alteração de Veiculo');
        $formid     = 'form_Sistema_AdminC_VeiculoEdit';
        $formbt     = __('Alterar Veiculo');
        $formlink   = 'usuario_veiculo/Veiculo/Veiculos_Edit2/'.$id;
        $editar     = Array('Usuario_Veiculo', $id);
        $campos = Usuario_Veiculo_DAO::Get_Colunas();
        self::Campos_Deletar($campos);
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1, $titulo2, $formlink, $formid, $formbt, $campos, $editar);
    }
    /**
     * 
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.24
     */
    public function Veiculos_Edit2($id) {
        $titulo     = __('Veiculo Editado com Sucesso');
        $dao        = Array('Usuario_Veiculo', $id);
        $function     = '$this->Veiculos();';
        $sucesso1   = __('Veiculo Alterado com Sucesso.');
        $sucesso2   = ''.$_POST["placa"].' teve a alteração bem sucedida';
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo, $dao, $function, $sucesso1, $sucesso2, $alterar);      
    }
    /**
     * 
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.24
     */
    public function Veiculos_Del($id) {
        
        
    	$id = (int) $id;
        // Puxa linha e deleta
        $linha = $this->_Modelo->db->Sql_Select('Usuario_Veiculo', Array('id'=>$id));
        $sucesso =  $this->_Modelo->db->Sql_Delete($linha);
        // Mensagem
    	if ($sucesso === true) {
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Deletado'),
                "mgs_secundaria" => __('Veiculo Deletado com sucesso')
            );
    	} else {
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Erro')
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens', $mensagens);
        
        $this->Veiculos();
        
        $this->_Visual->Json_Info_Update('Titulo', __('Veiculo deletado com Sucesso'));  
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
    public function Veiculos_View($veiculo_id = false) {
        if ($veiculo_id === false || $veiculo_id==0 || !isset($veiculo_id)) return _Sistema_erroControle::Erro_Fluxo('Veiculo não informado',404);
        $this->Veiculos_Popup(      $veiculo_id  , false );
        if (\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('usuario_veiculo_Comentario')) {
            $this->Veiculos_Comentario( $veiculo_id          );
        }
        if (\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('usuario_veiculo_Evento')) {
            $this->Veiculos_Evento( $veiculo_id          );
        }
        $this->_Visual->Json_Info_Update('Titulo', __('Visualizar Comentários do Veiculo'));
    }
    public function Veiculos_Popup($veiculo_id = false, $popup= true ) {
        if ($veiculo_id === false || $veiculo_id==0 || !isset($veiculo_id)) return _Sistema_erroControle::Erro_Fluxo('Veiculo não informado',404);
        // mostra todas as suas mensagens
        $where = Array(
            'id'    =>  $veiculo_id,
        );
        $veiculo = $this->_Modelo->db->Sql_Select('Usuario_Veiculo', $where, 1);
        $html  = '<div class="col-6">';
        $html .= '<b>'.__('Tipo de Veiculo:').'</b> '.$veiculo->categoria2.'<br>';  
        $html .= '<b>'.__('Marca:').'</b> '.$veiculo->marca2.'<br>';  
        $html .= '<b>'.__('Modelo:').'</b> '.$veiculo->modelo2.'<br>';  
        $html .= '<b>'.__('Ano:').'</b> '.$veiculo->ano.'<br>';
        if (\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('usuario_veiculo_VeiculoVALOR')) {
            $html .= '<b>'.__('Valor do Veiculo:').'</b> '.$veiculo->valor;
        }
        $html .= '</div><div class="col-6">'; 
        if (\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('usuario_veiculo_VeiculoIPVA')) {
            $html .= '<b>Nº Ipva:</b> '.$veiculo->ipva; 
            $html .= '<b>'.__('Data Ipva:').'</b> '.$veiculo->ipva_data; 
            $html .= '<b>'.__('Valor Ipva:').'</b> '.$veiculo->ipva_valor;
        } 
        if (\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('usuario_veiculo_VeiculoRENAVAN')) {
            $html .= '<b>'.__('Renavan:').'</b> '.$veiculo->renavan.'<br>';  
        }
        if (\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('usuario_veiculo_VeiculoVISTORIA')) {
            $html .= '<b>'.__('Data Vistoria:').'</b> '.$veiculo->data_vistoria.'<br>';  
            $html .= '<b>'.__('Data da Próxima Vistoria:').'</b> '.$veiculo->data_vistoria2.'<br>';  
        }
        if (\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('usuario_veiculo_VeiculoREVISAO')) {
            $html .= '<b>'.__('Revisão:').'</b> '.$veiculo->revisao.'<br>';  
        }
        if (\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('usuario_veiculo_VeiculoOBS')) {
            $html .= '<b>'.__('Observação:').'</b> '.$veiculo->obs; 
        }
        
        
        $html .= '</div>';    
        $titulo = __('Informações do Veiculo');
        if ($popup) {
            $conteudo = array(
                'id' => 'popup',
                'title' => $titulo,
                'botoes' => array(
                    array(
                        'text' => 'Fechar',
                        'clique' => '$( this ).dialog( "close" );'
                    )
                ),
                'html' => $html
            );
            $this->_Visual->Json_IncluiTipo('Popup', $conteudo);
        } else {
            $this->_Visual->Blocar('<div class="row">'.$html.'</div>');
            $this->_Visual->Bloco_Unico_CriaJanela($titulo, '',20);
            $this->_Visual->Json_Info_Update('Titulo', __('Visualizar Veiculo'));
        }
    }
    /**
     * Comentarios dos Veiculos
     */
    
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.24
     */
    public function Veiculos_Comentario($veiculo_id = false, $export = false) {
        $i = 0;
        $this->_Visual->Blocar($this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            Array(
                'Adicionar Comentário de Veiculo',
                'usuario_veiculo/Veiculo/Veiculos_Comentario_Add/'.$veiculo_id,
                ''
            ),
            Array(
                'Print'     => true,
                'Pdf'       => true,
                'Excel'     => true,
                'Link'      => 'usuario_veiculo/Veiculo/Veiculos_Comentario/'.$veiculo_id,
            )
        )));
        if ($veiculo_id === false) {
            $where = Array();
        } else {
            $where = Array('veiculo'=>$veiculo_id);
        }
        $linhas = $this->_Modelo->db->Sql_Select('Usuario_Veiculo_Comentario', $where);
        if ($linhas !== false && !empty($linhas)) {
            if (is_object($linhas)) $linhas = Array(0=>$linhas);
            reset($linhas);
            foreach ($linhas as $indice=>&$valor) {
                //$table[__('#Id')][$i]        = '#'.$valor->id;
                $table[__('Comentário')][$i]   =   $valor->comentario;
                $table[__('Data')][$i]         =   $valor->log_date_add;
                $table[__('Funções')][$i]      =   $this->_Visual->Tema_Elementos_Btn('Editar'          ,Array(__('Editar Comentário de Veiculo')        ,'usuario_veiculo/Veiculo/Veiculos_Comentario_Edit/'.$veiculo_id.'/'.$valor->id.'/'    , '')).
                                                $this->_Visual->Tema_Elementos_Btn('Deletar'         ,Array(__('Deletar Comentário de Veiculo')       ,'usuario_veiculo/Veiculo/Veiculos_Comentario_Del/'.$veiculo_id.'/'.$valor->id.'/'     , __('Deseja realmente deletar esse Comentário desse Veiculo ?')));
                ++$i;
            }
            if ($export !== false) {
                self::Export_Todos($export, $table, 'Veiculos (Comentários)');
            } else {
                $this->_Visual->Show_Tabela_DataTable($table);
            }
            unset($table);
        } else {          
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhum Comentário do Veiculo</font></b></center>');
        }
        $titulo = __('Comentários do Veiculo').' ('.$i.')';
        $this->_Visual->Bloco_Unico_CriaJanela($titulo, '',10);
        
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Administrar Comentários do Veiculo'));
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.24
     */
    public function Veiculos_Comentario_Add($veiculo_id = false) {
        if ($veiculo_id === false) return _Sistema_erroControle::Erro_Fluxo('Veiculo não informado',404);
        // Carrega Config
        $titulo1    = __('Adicionar Comentário de Veiculo');
        $titulo2    = __('Salvar Comentário de Veiculo');
        $formid     = 'form_Sistema_Admin_Veiculos_Comentario';
        $formbt     = __('Salvar');
        $formlink   = 'usuario_veiculo/Veiculo/Veiculos_Comentario_Add2/'.$veiculo_id.'/';
        $campos = Usuario_Veiculo_Comentario_DAO::Get_Colunas();
        self::DAO_Campos_Retira($campos, 'veiculo');
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1, $titulo2, $formlink, $formid, $formbt, $campos);
    }
    /**
     * 
     * 
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.24
     */
    public function Veiculos_Comentario_Add2($veiculo_id = false) {
        if ($veiculo_id === false) return _Sistema_erroControle::Erro_Fluxo('Veiculo não informado',404);
        $titulo     = __('Comentário do Veiculo Adicionado com Sucesso');
        $dao        = 'Usuario_Veiculo_Comentario';
        $function     = '$this->Veiculos_View('.$veiculo_id.');';
        $sucesso1   = __('Inserção bem sucedida');
        $sucesso2   = __('Comentário de Veiculo cadastrado com sucesso.');
        $alterar    = Array('veiculo'=>$veiculo_id);
        $this->Gerador_Formulario_Janela2($titulo, $dao, $function, $sucesso1, $sucesso2, $alterar);
    }
    /**
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.24
     */
    public function Veiculos_Comentario_Edit($veiculo_id = false, $id = 0) {
        if ($veiculo_id === false) return _Sistema_erroControle::Erro_Fluxo('Veiculo não informado',404);
        if ($id         == 0   ) return _Sistema_erroControle::Erro_Fluxo('Comentário não informado',404);
        // Carrega Config
        $titulo1    = 'Editar Comentário do Veiculo (#'.$id.')';
        $titulo2    = __('Alteração de Comentário do Veiculo');
        $formid     = 'form_Sistema_AdminC_VeiculoEdit';
        $formbt     = __('Alterar Comentário de Veiculo');
        $formlink   = 'usuario_veiculo/Veiculo/Veiculos_Comentario_Edit2/'.$veiculo_id.'/'.$id;
        $editar     = Array('Usuario_Veiculo_Comentario', $id);
        $campos = Usuario_Veiculo_Comentario_DAO::Get_Colunas();
        self::DAO_Campos_Retira($campos, 'veiculo');
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1, $titulo2, $formlink, $formid, $formbt, $campos, $editar);
    }
    /**
     * 
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.24
     */
    public function Veiculos_Comentario_Edit2($veiculo_id = false, $id = 0) {
        if ($veiculo_id === false) return _Sistema_erroControle::Erro_Fluxo('Veiculo não informado',404);
        if ($id         == 0   ) return _Sistema_erroControle::Erro_Fluxo('Comentário não informado',404);
        $titulo     = __('Comentário de Veiculo Editado com Sucesso');
        $dao        = Array('Usuario_Veiculo_Comentario', $id);
        $function     = '$this->Veiculos_View('.$veiculo_id.');';
        $sucesso1   = __('Comentário de Veiculo Alterado com Sucesso.');
        $sucesso2   = ''.$_POST["nome"].' teve a alteração bem sucedida';
        $alterar    = Array('veiculo'=>$veiculo_id);
        $this->Gerador_Formulario_Janela2($titulo, $dao, $function, $sucesso1, $sucesso2, $alterar);      
    }
    /**
     * 
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.24
     */
    public function Veiculos_Comentario_Del($veiculo_id = false, $id = 0) {
        if ($veiculo_id === false) return _Sistema_erroControle::Erro_Fluxo('Veiculo não informado',404);
        if ($id         == 0   ) return _Sistema_erroControle::Erro_Fluxo('Comentário não informado',404);
        
        
    	$id = (int) $id;
        // Puxa linha e deleta
        $where = Array('id'=>$id);
        $comentario = $this->_Modelo->db->Sql_Select('Usuario_Veiculo_Comentario', $where);
        $sucesso =  $this->_Modelo->db->Sql_Delete($comentario);
        // Mensagem
    	if ($sucesso === true) {
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Deletado'),
                "mgs_secundaria" => __('Comentário do Veiculo Deletado com sucesso')
            );
    	} else {
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Erro')
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens', $mensagens);
        
        $this->Veiculos_View($veiculo_id);
        
        $this->_Visual->Json_Info_Update('Titulo', __('Comentário de Veiculo deletado com Sucesso'));  
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.24
     */
    public function Veiculos_Evento($veiculo_id = false) {
        if ($veiculo_id === false) {
            $where = Array();
        } else {
            $where = Array('veiculo'=>$veiculo_id);
        }
        $i = 0;
        $this->_Visual->Blocar('<a title="Adicionar Evento de Veiculo" class="btn btn-success lajax explicar-titulo" data-acao="" href="'.URL_PATH.'usuario_veiculo/Veiculo/Veiculos_Evento_Add/'.$veiculo_id.'">Adicionar novo evento nesse Veiculo</a><div class="space15"></div>');
        $linhas = $this->_Modelo->db->Sql_Select('Usuario_Veiculo_Evento');
        if ($linhas !== false && !empty($linhas)) {
            if (is_object($linhas)) $linhas = Array(0=>$linhas);
            reset($linhas);
            foreach ($linhas as $indice=>&$valor) {
                $table[__('Acontecimento')][$i]        =   $valor->nome;
                $table[__('Data do Acontecimento')][$i]=   $valor->data;
                $table[__('Data Registrado')][$i]      =   $valor->log_date_add;
                $table[__('Funções')][$i]      =   $this->_Visual->Tema_Elementos_Btn('Editar'          ,Array(__('Editar Evento de Veiculo')        ,'usuario_veiculo/Veiculo/Veiculos_Evento_Edit/'.$veiculo_id.'/'.$valor->id.'/'    , '')).
                                                $this->_Visual->Tema_Elementos_Btn('Deletar'         ,Array(__('Deletar Evento de Veiculo')       ,'usuario_veiculo/Veiculo/Veiculos_Evento_Del/'.$veiculo_id.'/'.$valor->id.'/'     , __('Deseja realmente deletar esse Evento de desse Veiculo ?')));
                ++$i;
            }
            $this->_Visual->Show_Tabela_DataTable($table);
            unset($table);
        } else {          
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhum Evento do Veiculo</font></b></center>');
        }
        $titulo = __('Eventos do Veiculo').' ('.$i.')';
        $this->_Visual->Bloco_Unico_CriaJanela($titulo, '',10);
        
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Administrar Eventos do Veiculo'));
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.24
     */
    public function Veiculos_Evento_Add($veiculo_id = false) {
        if ($veiculo_id === false) return _Sistema_erroControle::Erro_Fluxo('Veiculo não informado',404);
        // Carrega Config
        $titulo1    = __('Adicionar Evento de Veiculo');
        $titulo2    = __('Salvar Evento de Veiculo');
        $formid     = 'form_Sistema_Admin_Veiculos_Evento';
        $formbt     = __('Salvar');
        $formlink   = 'usuario_veiculo/Veiculo/Veiculos_Evento_Add2/'.$veiculo_id.'/';
        $campos = Usuario_Veiculo_Evento_DAO::Get_Colunas();
        self::DAO_Campos_Retira($campos, 'veiculo');
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1, $titulo2, $formlink, $formid, $formbt, $campos);
    }
    /**
     * 
     * 
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.24
     */
    public function Veiculos_Evento_Add2($veiculo_id = false) {
        if ($veiculo_id === false) return _Sistema_erroControle::Erro_Fluxo('Veiculo não informado',404);
        $titulo     = __('Evento do Veiculo Adicionado com Sucesso');
        $dao        = 'Usuario_Veiculo_Evento';
        $function     = '$this->Veiculos_View('.$veiculo_id.');';
        $sucesso1   = __('Inserção bem sucedida');
        $sucesso2   = __('Evento de Veiculo cadastrado com sucesso.');
        $alterar    = Array('veiculo'=>$veiculo_id);
        $this->Gerador_Formulario_Janela2($titulo, $dao, $function, $sucesso1, $sucesso2, $alterar);
    }
    /**
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.24
     */
    public function Veiculos_Evento_Edit($veiculo_id = false, $id = 0) {
        if ($veiculo_id === false) return _Sistema_erroControle::Erro_Fluxo('Veiculo não informado',404);
        if ($id         == 0   ) return _Sistema_erroControle::Erro_Fluxo('Evento não informado',404);
        // Carrega Config
        $titulo1    = 'Editar Evento do Veiculo (#'.$id.')';
        $titulo2    = __('Alteração de Evento do Veiculo');
        $formid     = 'form_Sistema_AdminC_VeiculoEdit';
        $formbt     = __('Alterar Evento de Veiculo');
        $formlink   = 'usuario_veiculo/Veiculo/Veiculos_Evento_Edit2/'.$veiculo_id.'/'.$id;
        $editar     = Array('Usuario_Veiculo_Evento', $id);
        $campos = Usuario_Veiculo_Evento_DAO::Get_Colunas();
        self::DAO_Campos_Retira($campos, 'veiculo');
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1, $titulo2, $formlink, $formid, $formbt, $campos, $editar);
    }
    /**
     * 
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.24
     */
    public function Veiculos_Evento_Edit2($veiculo_id = false, $id = 0) {
        if ($veiculo_id === false) return _Sistema_erroControle::Erro_Fluxo('Veiculo não informado',404);
        if ($id         == 0   ) return _Sistema_erroControle::Erro_Fluxo('Evento não informado',404);
        $titulo     = __('Evento de Veiculo Editado com Sucesso');
        $dao        = Array('Usuario_Veiculo_Evento', $id);
        $function     = '$this->Veiculos_View('.$veiculo_id.');';
        $sucesso1   = __('Evento de Veiculo Alterado com Sucesso.');
        $sucesso2   = ''.$_POST["nome"].' teve a alteração bem sucedida';
        $alterar    = Array('veiculo'=>$veiculo_id);
        $this->Gerador_Formulario_Janela2($titulo, $dao, $function, $sucesso1, $sucesso2, $alterar);      
    }
    /**
     * 
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.24
     */
    public function Veiculos_Evento_Del($veiculo_id = false, $id = 0) {
        if ($veiculo_id === false) return _Sistema_erroControle::Erro_Fluxo('Veiculo não informado',404);
        if ($id         == 0   ) return _Sistema_erroControle::Erro_Fluxo('Evento não informado',404);
        
        
    	$id = (int) $id;
        // Puxa linha e deleta
        $where = Array('id'=>$id);
        $evento = $this->_Modelo->db->Sql_Select('Usuario_Veiculo_Evento', $where);
        $sucesso =  $this->_Modelo->db->Sql_Delete($evento);
        // Mensagem
    	if ($sucesso === true) {
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Deletado'),
                "mgs_secundaria" => __('Evento do Veiculo Deletado com sucesso')
            );
    	} else {
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Erro')
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens', $mensagens);
        
        $this->Veiculos_View($veiculo_id);
        
        $this->_Visual->Json_Info_Update('Titulo', __('Evento de Veiculo deletado com Sucesso'));  
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
}
?>
