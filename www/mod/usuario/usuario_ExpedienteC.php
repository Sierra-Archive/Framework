<?php
class usuario_ExpedienteControle extends usuario_Controle
{
    /**
    * Construtor
    * 
    * @name __construct
    * @access public
    * 
    * @uses usuario_rede_PerfilModelo::Carrega Rede Modelo
    * @uses usuario_rede_PerfilVisual::Carrega Rede Visual
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 0.4.24
    */
    public function __construct() {
        parent::__construct();
    }
    /**
     * Main
     * 
     * @name Main
     * @access public
     * 
     * @return void
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.24
     */
    public function Main() {
        return false; 
    }
    /**
     * Escreve Link de Auxilio para o Usuário
     * 
     * @param bollean $true Se Adiciona Link ou nao ao Endereço
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.24
     */
    static function Endereco_Expediente($true= true ) {
        $Registro = &\Framework\App\Registro::getInstacia();
        $_Controle = $Registro->_Controle;
        if ($true === true) {
            $_Controle->Tema_Endereco(__('Expediente'),'usuario/Expediente/Expediente');
        } else {
            $_Controle->Tema_Endereco(__('Expediente'));
        }
    }
    /**
     * LIstagem de Todos os Expedientes
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.24
     */
    public function Expediente($export = false) {
        self::Endereco_Expediente(false);
        $i = 0;
        // add botao
        $this->_Visual->Blocar($this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            Array(
                'Adicionar Expediente',
                'usuario/Expediente/Expedientes_Add',
                ''
            ),
            Array(
                'Print'     => true,
                'Pdf'       => true,
                'Excel'     => true,
                'Link'      => 'usuario/Expediente/Expedientes',
            )
        )));
        $expedientes = $this->_Modelo->db->Sql_Select('Usuario_Expediente');
        if ($expedientes !== false && !empty($expedientes)) {
            if (is_object($expedientes)) $expedientes = Array(0=>$expedientes);
            reset($expedientes);
            foreach ($expedientes as $indice=>&$valor) {
                $table[__('Pessoa')][$i]           = $valor->persona2;
                $table[__('Numero')][$i]           = $valor->expediente;
                $table[__('Obs')][$i]              = $valor->obs;
                $table[__('Funções')][$i]          = $this->_Visual->Tema_Elementos_Btn('Editar'     ,Array(__('Editar Expediente')        ,'usuario/Expediente/Expedientes_Edit/'.$valor->id.'/'    , '')).
                                                  $this->_Visual->Tema_Elementos_Btn('Deletar'    ,Array(__('Deletar Expediente')       ,'usuario/Expediente/Expedientes_Del/'.$valor->id.'/'     , __('Deseja realmente deletar essa Expediente ?')));
                ++$i;
            }
            if ($export !== false) {
                self::Export_Todos($export, $table, 'Expedientes');
            } else {
                $this->_Visual->Show_Tabela_DataTable(
                    $table,     // Array Com a Tabela
                    '',          // style extra
                    true,        // true -> Add ao Bloco, false => Retorna html
                    true,        // Apagar primeira coluna ?
                    Array(       // Ordenacao
                        Array(
                            0,'desc'
                        )
                    )
                );
            }
            unset($table);
        } else {        
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhum Expediente</font></b></center>');
        }
        $titulo = __('Listagem de Expedientes').' ('.$i.')';
        $this->_Visual->Bloco_Unico_CriaJanela($titulo, '',10);

        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Administrar Expedientes'));
    }
    public static function Expedientes_Campos_Remover(&$campos) {
        self::DAO_Campos_Retira($campos, 'qnt');
        self::DAO_Campos_Retira($campos, 'status');
    }
    /**
     * Retorna Formulário para Cadastro de Expediente
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.24
     */
    public function Expedientes_Add() {
        self::Endereco_Expediente();
        // Carrega Config
        $titulo1    = __('Adicionar Expediente');
        $titulo2    = __('Salvar Expediente');
        $formid     = 'form_Sistema_Expediente_Expedientes';
        $formbt     = __('Salvar');
        $formlink   = 'usuario/Expediente/Expedientes_Add2/';
        $campos = Usuario_Expediente_DAO::Get_Colunas();
        self::Expedientes_Campos_Remover($campos);
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1, $titulo2, $formlink, $formid, $formbt, $campos);
    }
    /**
     * Cadastra Expediente no Banco de Dados, usado dados vindos do Formulário
     * 
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.24
     */
    public function Expedientes_Add2() {
        $titulo     = __('Expediente adicionada com Sucesso');
        $dao        = 'Usuario_Expediente';
        $function     = '$this->Expediente();';
        $sucesso1   = __('Inserção bem sucedida');
        $sucesso2   = __('Expediente cadastrado com sucesso.');
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo, $dao, $function, $sucesso1, $sucesso2, $alterar);
    }
    /**
     * Retorna Formulário para Edição de Expediente
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.24
     */
    public function Expedientes_Edit($id) {
        self::Endereco_Expediente();
        // Carrega Config
        $titulo1    = 'Editar Expediente (#'.$id.')';
        $titulo2    = __('Alteração de Expediente');
        $formid     = 'form_Sistema_ExpedienteC_ExpedienteEdit';
        $formbt     = __('Alterar Expediente');
        $formlink   = 'usuario/Expediente/Expedientes_Edit2/'.$id;
        $editar     = Array('Usuario_Expediente', $id);
        $campos = Usuario_Expediente_DAO::Get_Colunas();
        self::Expedientes_Campos_Remover($campos);
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1, $titulo2, $formlink, $formid, $formbt, $campos, $editar);
    }
    /**
     * 
     * 
     * @param int $id Chave Primária (Id do Registro)
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.24
     */
    public function Expedientes_Edit2($id) {
        $titulo     = __('Expediente editada com Sucesso');
        $dao        = Array('Usuario_Expediente', $id);
        $function     = '$this->Expediente();';
        $sucesso1   = __('Expediente Alterado com Sucesso.');
        $sucesso2   = ''.$_POST["nome"].' teve a alteração bem sucedida';
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo, $dao, $function, $sucesso1, $sucesso2, $alterar);   
    }
    /**
     * Deleta Expediente
     * 
     * @param int $id Registro do Expediente
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.24
     */
    public function Expedientes_Del($id) {
        
        
    	$id = (int) $id;
        // Puxa setor e deleta
        $setor = $this->_Modelo->db->Sql_Select('Usuario_Expediente', Array('id'=>$id));
        $sucesso =  $this->_Modelo->db->Sql_Delete($setor);
        // Mensagem
    	if ($sucesso === true) {
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Deletada'),
                "mgs_secundaria" => __('Expediente deletada com sucesso')
            );
    	} else {
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Erro')
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens', $mensagens);
        
        $this->Expediente();
        
        $this->_Visual->Json_Info_Update('Titulo', __('Expediente deletada com Sucesso'));  
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
    /**
     * Lista todos os Funcionários Disponiveis
     * @param type $tipobloco
     * @param boolean $span
     * @return boolean
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.24
     */
    public static function Disponivel($tipobloco='Unico', $span= true ) {
        $Registro = Framework\App\Registro::getInstacia();

        if ($span === true) {
            $html = '<span id="usuario_Expediente_Disponiveis">';
        } else {
            $html = '';
        }
        
        // Inserir Expediente
        $Registros_usuario = $Registro->_Modelo->db->Sql_Select('Usuario');
        $Registros_expediente = $Registro->_Modelo->db->Sql_Select('Usuario_Expediente', '{sigla}fim=\'0000-00-00 00:00:00\'');
        $usuarios_nao_podem = Array();
        if (is_object($Registros_expediente))$Registros_expediente = Array($Registros_expediente);
        if (is_array($Registros_expediente)) {
            foreach ($Registros_expediente as &$valor) {
                $usuarios_nao_podem[] = $valor->usuario;
            }
        }
        $form = new \Framework\Classes\Form('usuarioform_expediente_add', 'usuario/Expediente/Expediente_Add_Rapido', 'formajax',"mini",'horizontal', 'off');
        $form->Select_Novo(
            'Funcionário para Entrar no Expediente',
            'usuario',
            'usuario',
            '',
            '',
            '',
            false,
            false,
            'obrigatorio',
            __('Escolha um Funcionário')
        );
        /*if ($valor['edicao']['valor_padrao'] === false) {
            $html .= $form->Select_Opcao('', '',1);
        } else {
            $html .= $form->Select_Opcao('', '',0);
        }*/
        if (is_array($Registros_usuario)) {
            foreach ($Registros_usuario as &$valor) {
                if (array_search($valor->id, $usuarios_nao_podem) === false) {
                    $form->Select_Opcao($valor->nome, $valor->id,0);
                }
            }
        }
        $form->Select_Fim();
        $html .= $form->retorna_form('Abrir Expediente').'<br><br>';
        
        // Carrega Tabela
        $tableColumns = Array();
        $tableColumns[] = __('Id');
        $tableColumns[] = __('Funcionário');
        $tableColumns[] = __('Inicio');
        $tableColumns[] = __('Fim');
        $tableColumns[] = __('Funções');
        $html .= $Registro->_Visual->Show_Tabela_DataTable_Massiva($tableColumns,'usuario/Expediente/Expedientes', '', false);
        
        if ($span === true) {
            $html .= '</span>';
        }
        
        $titulo = __('Disponiveis'); //.' (<span id="DataTable_Contador">0</span>)';        
        if ($tipobloco==='Unico') {
            $Registro->_Visual->Blocar($html);
            $Registro->_Visual->Bloco_Unico_CriaJanela($titulo, '',100,Array("link"=>"usuario/Expediente/Expedientes_Add",'icon'=>'add', 'nome'=>__('Adicionar Expediente')));
        } else if ($tipobloco==='Maior') {
            $Registro->_Visual->Blocar($html);
            $Registro->_Visual->Bloco_Maior_CriaJanela($titulo, '',100,Array("link"=>"usuario/Expediente/Expedientes_Add",'icon'=>'add', 'nome'=>__('Adicionar Expediente')));
        } else if ($tipobloco==='Menor') {
            $Registro->_Visual->Blocar($html);
            $Registro->_Visual->Bloco_Menor_CriaJanela($titulo, '',100,Array("link"=>"usuario/Expediente/Expedientes_Add",'icon'=>'add', 'nome'=>__('Adicionar Expediente')));
        } else {
            return $html;
        }
        return true;
    }
    /**
     * Lista todos os Funcionários Disponiveis
     * @param type $tipobloco
     * @param boolean $span
     * @return boolean
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.24
     */
    public static function Almoco($tipobloco='Unico', $span= true ) {
        $Registro = Framework\App\Registro::getInstacia();

        if ($span === true) {
            $html = '<span id="usuario_Expediente_Almoco">';
        } else {
            $html = '';
        }
        
        
        
        // Carrega Tabela
        $tableColumns = Array();
        $tableColumns[] = __('Id');
        $tableColumns[] = __('Funcionário');
        $tableColumns[] = __('Horário de Saida');
        $tableColumns[] = __('Funções');
        $html .= $Registro->_Visual->Show_Tabela_DataTable_Massiva($tableColumns,'usuario/Expediente/Expedientes/1/sim', '', false);
        
        if ($span === true) {
            $html .= '</span>';
        }
        
        $titulo = __('Em Almoço'); //.' (<span id="DataTable_Contador">0</span>)';        
        if ($tipobloco==='Unico') {
            $Registro->_Visual->Blocar($html);
            $Registro->_Visual->Bloco_Unico_CriaJanela($titulo, '',100);
        } else if ($tipobloco==='Maior') {
            $Registro->_Visual->Blocar($html);
            $Registro->_Visual->Bloco_Maior_CriaJanela($titulo, '',100);
        } else if ($tipobloco==='Menor') {
            $Registro->_Visual->Blocar($html);
            $Registro->_Visual->Bloco_Menor_CriaJanela($titulo, '',100);
        } else {
            return $html;
        }
        return true;
    }
    /**
     * Pega um Usuario qualquer e Abre um Expediente Rapidamente pra Ele
     * 
     * @param int $usuario Id do Usuario
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.24
     */
    public function Expediente_Add_Rapido($usuario = false) {
        if ($usuario === false) {
            $usuario = (int) $_POST['usuario'];
        } else {
            $usuario = (int) $usuario;
        }
        $expediente = new Usuario_Expediente_DAO();
        $expediente->usuario = $usuario;
        $expediente->inicio = APP_HORA_BR;
        
        $sucesso =  $this->_Modelo->db->Sql_Insert($expediente);
    	if ($sucesso === true) {
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Iniciado'),
                "mgs_secundaria" => __('Expediente Iniciado com sucesso')
            );
    	} else {
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Erro')
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens', $mensagens);
        
        // Recarrega
        $tableColumns = Array(__('Id'),__('Funcionário'),__('Inicio'),__('Fim'),__('Status'),__('Funções'));
        $conteudo = array(
            'location'  =>  '#usuario_Expediente_Disponiveis',
            'js'        =>  '',
            'html'      => self::Disponivel(false, false)
        );
        $this->_Visual->Json_IncluiTipo('Conteudo', $conteudo);
        
        $this->_Visual->Json_Info_Update('Titulo', __('Expediente Iniciado com Sucesso'));  
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
    /**
     * Altera Status de um Expediente
     * 
     * @param type $id
     * @param type $status
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.24
     */
    public function Expedientes_StatusAlterar($id = false, $status=0) {
        $id = (int) $id;
        $expediente = $this->_Modelo->db->Sql_Select('Usuario_Expediente', '{sigla}id=\''.$id.'\'');
        
        if ($status==2) {
            $expediente->fim = APP_HORA_BR;
            $expediente->status = '2';
            $expediente->qnt = Data_CalculaDiferenca_Em_Segundos($expediente->inicio, $expediente->fim);
            $sucesso =  $this->_Modelo->db->Sql_Update($expediente);
            // Recarrega
            $conteudo = array(
                'location'  =>  '#usuario_Expediente_Disponiveis',
                'js'        =>  '',
                'html'      => self::Disponivel(false, false)
            );
            $this->_Visual->Json_IncluiTipo('Conteudo', $conteudo);
        } else if ($status==1) {
            $expediente->status = '1';
            $sucesso =  $this->_Modelo->db->Sql_Update($expediente);
            // Recarrega DIsponiveis
            $conteudo = array(
                'location'  =>  '#usuario_Expediente_Disponiveis',
                'js'        =>  '',
                'html'      => self::Disponivel(false, false)
            );
            $this->_Visual->Json_IncluiTipo('Conteudo', $conteudo);
            // Recarrega Almoco
            $conteudo = array(
                'location'  =>  '#usuario_Expediente_Almoco',
                'js'        =>  '',
                'html'      => self::Almoco(false, false)
            );
            $this->_Visual->Json_IncluiTipo('Conteudo', $conteudo);
        } else {
            $expediente->status = '0';
            $sucesso =  $this->_Modelo->db->Sql_Update($expediente);
            // Recarrega DIsponiveis
            $conteudo = array(
                'location'  =>  '#usuario_Expediente_Disponiveis',
                'js'        =>  '',
                'html'      => self::Disponivel(false, false)
            );
            $this->_Visual->Json_IncluiTipo('Conteudo', $conteudo);
            // Recarrega Almoco
            $conteudo = array(
                'location'  =>  '#usuario_Expediente_Almoco',
                'js'        =>  '',
                'html'      => self::Almoco(false, false)
            );
            $this->_Visual->Json_IncluiTipo('Conteudo', $conteudo);
        }
    	if ($sucesso === true) {
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Iniciado'),
                "mgs_secundaria" => __('Expediente Alterado com sucesso')
            );
    	} else {
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Erro')
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens', $mensagens);
        
        
        $this->_Visual->Json_Info_Update('Titulo', __('Expediente Iniciado com Sucesso'));  
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
}
?>
