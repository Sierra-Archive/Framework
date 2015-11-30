<?php
class usuario_mensagem_AssuntoControle extends usuario_mensagem_Controle
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
        \Framework\App\Sistema_Funcoes::Redirect(URL_PATH.'usuario_mensagem/Assunto/Assuntos/');
        return false;
    }
    static function Endereco_Assunto($true= true ) {
        $Registro = &\Framework\App\Registro::getInstacia();
        $_Controle = $Registro->_Controle;
        $titulo = __('Assuntos');
        $link = 'usuario_mensagem/Assunto/Assuntos';
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
    public function Assuntos($export = false) {
        self::Endereco_Assunto(false);
        
        $table = Array(
            __('Setor'), __('Nome'), __('Tempo de Resposta'),__('Funções')
        );
        $this->_Visual->Show_Tabela_DataTable_Massiva($table,'usuario_mensagem/Assunto/Assuntos');
        $titulo = __('Listagem de Assuntos').' (<span id="DataTable_Contador">0</span>)';  //
        $this->_Visual->Bloco_Unico_CriaJanela($titulo, '',10,Array("link"=>"usuario_mensagem/Assunto/Assuntos_Add",'icon'=>'add', 'nome' => __('Adicionar Assunto')));
        
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Administrar Assuntos'));
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.24
     */
    public function Assuntos_Add() {
        self::Endereco_Assunto(true);
        // Carrega Config
        $titulo1    = __('Adicionar Assunto');
        $titulo2    = __('Salvar Assunto');
        $formid     = 'form_Sistema_Admin_Assuntos';
        $formbt     = __('Salvar');
        $formlink   = 'usuario_mensagem/Assunto/Assuntos_Add2/';
        $campos = Usuario_Mensagem_Assunto_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1, $titulo2, $formlink, $formid, $formbt, $campos);
    }
    /**
     * 
     * 
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.24
     */
    public function Assuntos_Add2() {
        $titulo     = __('Assunto Adicionado com Sucesso');
        $dao        = 'Usuario_Mensagem_Assunto';
        $function     = '$this->Assuntos();';
        $sucesso1   = __('Inserção bem sucedida');
        $sucesso2   = __('Assunto cadastrado com sucesso.');
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo, $dao, $function, $sucesso1, $sucesso2, $alterar);
    }
    /**
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.24
     */
    public function Assuntos_Edit($id) {
        self::Endereco_Assunto(true);
        $id = (int) $id;
        // Carrega campos e retira os que nao precisam
        $campos = Usuario_Mensagem_Assunto_DAO::Get_Colunas();
        // recupera assunto
        $assunto = $this->_Modelo->db->Sql_Select('Usuario_Mensagem_Assunto', Array('id'=>$id));
        self::mysql_AtualizaValores($campos, $assunto);

        // edicao de assuntos
        $form = new \Framework\Classes\Form('form_Sistema_AdminC_AssuntoEdit', 'usuario_mensagem/Assunto/Assuntos_Edit2/'.$id.'/', 'formajax');
        \Framework\App\Controle::Gerador_Formulario($campos, $form);
        $formulario = $form->retorna_form('Alterar Assunto');
        $this->_Visual->Blocar($formulario);
        $this->_Visual->Bloco_Unico_CriaJanela(__('Alteração de Assunto'));
        // Json
        $this->_Visual->Json_Info_Update('Titulo', 'Editar Assunto (#'.$id.')');
        
    }
    /**
     * 
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.24
     */
    public function Assuntos_Edit2($id) {
        
        $id = (int) $id;
        // Puxa o assunto, e altera seus valores, depois salva novamente
        $assunto = $this->_Modelo->db->Sql_Select('Usuario_Mensagem_Assunto', Array('id'=>$id));
        self::mysql_AtualizaValores($assunto);
        $sucesso =  $this->_Modelo->db->Sql_Update($assunto);
        // Atualiza
        $this->Assuntos();
        // Mensagem
        if ($sucesso === true) {
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Assunto Alterado com Sucesso'),
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
        $this->_Visual->Json_Info_Update('Titulo', __('Assunto Editado com Sucesso'));  
        $this->_Visual->Json_Info_Update('Historico', false);    
    }
    /**
     * 
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.24
     */
    public function Assuntos_Del($id) {
        
        
    	$id = (int) $id;
        // Puxa assunto e deleta
        $assunto = $this->_Modelo->db->Sql_Select('Usuario_Mensagem_Assunto', Array('id'=>$id));
        $sucesso =  $this->_Modelo->db->Sql_Delete($assunto);
        // Mensagem
    	if ($sucesso === true) {
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Deletado'),
                "mgs_secundaria" => __('Assunto Deletado com sucesso')
            );
    	} else {
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Erro')
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens', $mensagens);
        
        $this->Assuntos();
        
        $this->_Visual->Json_Info_Update('Titulo', __('Assunto deletado com Sucesso'));  
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
}
?>
