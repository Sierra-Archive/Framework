<?php
class usuario_mensagem_OrigemControle extends usuario_mensagem_Controle
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
    * @uses usuario_mensagem_Controle::$comercioPerfil
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 0.4.2
    */
    public function Main() {
        \Framework\App\Sistema_Funcoes::Redirect(URL_PATH.'usuario_mensagem/Origem/Origens/');
        return FALSE;
    }
    static function Endereco_Origem($true= TRUE ) {
        $Registro = &\Framework\App\Registro::getInstacia();
        $_Controle = $Registro->_Controle;
        $titulo = __('Origens');
        $link = 'usuario_mensagem/Origem/Origens';
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
    public function Origens($export = FALSE) {
        self::Endereco_Origem(FALSE);
       
        $tabela = Array(
            'Id', 'Nome', 'Funções'
        );
        $this->_Visual->Show_Tabela_DataTable_Massiva($tabela,'usuario_mensagem/Origem/Origens');
        $titulo = __('Listagem de Origens').' (<span id="DataTable_Contador">0</span>)';  //
        $this->_Visual->Bloco_Unico_CriaJanela($titulo, '',10,Array("link"=>"usuario_mensagem/Origem/Origens_Add",'icon'=>'add', 'nome'=>'Adicionar Origem'));
        
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Administrar Origens'));
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Origens_Add() {
        self::Endereco_Origem(TRUE);
        // Carrega Config
        $titulo1    = __('Adicionar Origem');
        $titulo2    = __('Salvar Origem');
        $formid     = 'form_Sistema_Admin_Origens';
        $formbt     = __('Salvar');
        $formlink   = 'usuario_mensagem/Origem/Origens_Add2/';
        $campos = Usuario_Mensagem_Origem_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1, $titulo2, $formlink, $formid, $formbt, $campos);
    }
    /**
     * 
     * 
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Origens_Add2() {
        $titulo     = __('Origem Adicionada com Sucesso');
        $dao        = 'Usuario_Mensagem_Origem';
        $funcao     = '$this->Origens();';
        $sucesso1   = __('Inserção bem sucedida');
        $sucesso2   = __('Origem cadastrada com sucesso.');
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo, $dao, $funcao, $sucesso1, $sucesso2, $alterar);
    }
    /**
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Origens_Edit($id) {
        self::Endereco_Origem(TRUE);
        // Carrega Config
        $titulo1    = 'Editar Origem (#'.$id.')';
        $titulo2    = __('Alteração de Origem');
        $formid     = 'form_Sistema_AdminC_OrigemEdit';
        $formbt     = __('Alterar Origem');
        $formlink   = 'usuario_mensagem/Origem/Origens_Edit2/'.$id;
        $editar     = Array('Usuario_Mensagem_Origem', $id);
        $campos = Usuario_Mensagem_Origem_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1, $titulo2, $formlink, $formid, $formbt, $campos, $editar);
    }
    /**
     * 
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Origens_Edit2($id) {
        $titulo     = __('Origem Editada com Sucesso');
        $dao        = Array('Usuario_Mensagem_Origem', $id);
        $funcao     = '$this->Origens();';
        $sucesso1   = __('Origem Alterado com Sucesso.');
        $sucesso2   = ''.$_POST["nome"].' teve a alteração bem sucedida';
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo, $dao, $funcao, $sucesso1, $sucesso2, $alterar);   
    }
    /**
     * 
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Origens_Del($id) {
        
        
    	$id = (int) $id;
        // Puxa setor e deleta
        $setor = $this->_Modelo->db->Sql_Select('Usuario_Mensagem_Origem', Array('id'=>$id));
        $sucesso =  $this->_Modelo->db->Sql_Delete($setor);
        // Mensagem
    	if ($sucesso === TRUE) {
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Deletado'),
                "mgs_secundaria" => __('Origem deletada com sucesso')
            );
    	} else {
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Erro')
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens', $mensagens);
        
        $this->Origens();
        
        $this->_Visual->Json_Info_Update('Titulo', __('Origem deletada com Sucesso'));  
        $this->_Visual->Json_Info_Update('Historico', FALSE);  
    }
}
?>
