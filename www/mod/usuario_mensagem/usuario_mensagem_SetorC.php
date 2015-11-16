<?php
class usuario_mensagem_SetorControle extends usuario_mensagem_Controle
{
    /**
    * Construtor
    * 
    * @name __construct
    * @access public
    * 
    * @uses usuario_mensagem_rede_PerfilModelo::Carrega Rede Modelo
    * @uses usuario_mensagem_rede_PerfilVisual::Carrega Rede Visual
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 0.4.2
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
    * @version 0.4.2
    */
    public function Main() {
        \Framework\App\Sistema_Funcoes::Redirect(URL_PATH.'usuario_mensagem/Setor/Setores/');
        return FALSE;
    }
    static function Endereco_Setor($true= TRUE ) {
        $Registro = &\Framework\App\Registro::getInstacia();
        $_Controle = $Registro->_Controle;
        $titulo = __('Setores');
        $link = 'usuario_mensagem/Setor/Setores';
        if ($true === TRUE) {
            $_Controle->Tema_Endereco($titulo, $link);
        } else {
            $_Controle->Tema_Endereco($titulo);
        }
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Setores($export = FALSE) {
        self::Endereco_Setor(FALSE);
        
        $table = Array(
            'Grupo', 'Nome', 'Email do Setor', 'Funções'
        );
        $this->_Visual->Show_Tabela_DataTable_Massiva($table,'usuario_mensagem/Setor/Setores');
        $titulo = __('Listagem de Setores').' (<span id="DataTable_Contador">0</span>)';  //
        $this->_Visual->Bloco_Unico_CriaJanela($titulo, '',10,Array("link"=>"usuario_mensagem/Setor/Setores_Add",'icon'=>'add', 'nome'=>'Adicionar Setor'));
        
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Administrar Setores'));
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Setores_Add() {
        self::Endereco_Setor(TRUE);
        // Carrega Config
        $titulo1    = __('Adicionar Setor');
        $titulo2    = __('Salvar Setor');
        $formid     = 'form_Sistema_Admin_Setores';
        $formbt     = __('Salvar');
        $formlink   = 'usuario_mensagem/Setor/Setores_Add2/';
        $campos = Usuario_Mensagem_Setor_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1, $titulo2, $formlink, $formid, $formbt, $campos);
    }
    /**
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Setores_Edit($id) {
        self::Endereco_Setor(TRUE);
        $id = (int) $id;
        // Carrega campos e retira os que nao precisam
        $campos = Usuario_Mensagem_Setor_DAO::Get_Colunas();
        // recupera setor
        $setor = $this->_Modelo->db->Sql_Select('Usuario_Mensagem_Setor', Array('id'=>$id));
        self::mysql_AtualizaValores($campos, $setor);

        // edicao de setores
        $form = new \Framework\Classes\Form('form_Sistema_AdminC_SetorEdit', 'usuario_mensagem/Setor/Setores_Edit2/'.$id.'/', 'formajax');
        \Framework\App\Controle::Gerador_Formulario($campos, $form);
        $formulario = $form->retorna_form('Alterar Setor');
        $this->_Visual->Blocar($formulario);
        $this->_Visual->Bloco_Unico_CriaJanela(__('Alteração de Setor'));
        // Json
        $this->_Visual->Json_Info_Update('Titulo', 'Editar Setor (#'.$id.')');
        
    }
    /**
     * 
     * 
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Setores_Add2() {
        $titulo     = __('Setor Adicionado com Sucesso');
        $dao        = 'Usuario_Mensagem_Setor';
        $function     = '$this->Setores();';
        $sucesso1   = __('Inserção bem sucedida');
        $sucesso2   = __('Setor cadastrado com sucesso.');
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo, $dao, $function, $sucesso1, $sucesso2, $alterar);
    }
    /**
     * 
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Setores_Edit2($id) {
        
        $id = (int) $id;
        // Puxa o setor, e altera seus valores, depois salva novamente
        $setor = $this->_Modelo->db->Sql_Select('Usuario_Mensagem_Setor', Array('id'=>$id));
        self::mysql_AtualizaValores($setor);
        $sucesso =  $this->_Modelo->db->Sql_Update($setor);
        // Atualiza
        $this->Setores();
        // Mensagem
        if ($sucesso === TRUE) {
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Setor Alterado com Sucesso'),
                "mgs_secundaria" => ''.$_POST["nome"].' teve a alteração bem sucedida'
            );
        } else {
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Erro')
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens', $mensagens);  
        //Json
        $this->_Visual->Json_Info_Update('Titulo', __('Setor Editado com Sucesso'));  
        $this->_Visual->Json_Info_Update('Historico', FALSE);    
    }
    /**
     * 
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Setores_Del($id) {
        
        
    	$id = (int) $id;
        // Puxa setor e deleta
        $setor = $this->_Modelo->db->Sql_Select('Usuario_Mensagem_Setor', Array('id'=>$id));
        $sucesso =  $this->_Modelo->db->Sql_Delete($setor);
        // Mensagem
    	if ($sucesso === TRUE) {
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Deletado'),
                "mgs_secundaria" => __('Setor Deletado com sucesso')
            );
    	} else {
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Erro')
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens', $mensagens);
        
        $this->Setores();
        
        $this->_Visual->Json_Info_Update('Titulo', __('Setor deletado com Sucesso'));  
        $this->_Visual->Json_Info_Update('Historico', FALSE);  
    }
}
?>
