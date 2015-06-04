<?php
class comercio_LinhaControle extends comercio_Controle
{
    /**
    * Construtor
    * 
    * @name __construct
    * @access public
    * 
    * @uses comercio_rede_PerfilModelo::Carrega Rede Modelo
    * @uses comercio_rede_PerfilVisual::Carrega Rede Visual
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 2.0
    */
    public function __construct(){
        parent::__construct();
    }
    /**
    * Main
    * 
    * @name Main
    * @access public
    * 
    * @uses comercio_Controle::$comercioPerfil
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 2.0
    */
    public function Main(){
        \Framework\App\Sistema_Funcoes::Redirect(URL_PATH.'comercio/Linha/Linhas');
        return false;
    }
    static function Endereco_Linha($true=true){
        $registro = \Framework\App\Registro::getInstacia();
        $_Controle = $registro->_Controle;
        $titulo = __('Linhas');
        $link = 'comercio/Linha/Linhas';
        if($true===true){
            $_Controle->Tema_Endereco($titulo,$link);
        }else{
            $_Controle->Tema_Endereco($titulo);
        }
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Linhas($export=false){
        self::Endereco_Linha(false);
        
        $tabela = Array(
            'Id','Nome','Linha','Funções'
        );
        $this->_Visual->Show_Tabela_DataTable_Massiva($tabela,'comercio/Linha/Linhas');
        $titulo = __('Listagem de Linhas').' (<span id="DataTable_Contador">'.__('Carregando...').'</span>)';  //
        $this->_Visual->Bloco_Unico_CriaJanela($titulo,'',10,Array("link"=>"comercio/Linha/Linhas_Add",'icon'=>'add','nome'=>'Adicionar Linha'));
        
        
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Administrar Linhas'));
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Linhas_Add(){
        self::Endereco_Linha(true);
        // Carrega Config
        $titulo1    = __('Adicionar Linha');
        $titulo2    = __('Salvar Linha');
        $formid     = 'form_Sistema_Admin_Linhas';
        $formbt     = __('Salvar');
        $formlink   = 'comercio/Linha/Linhas_Add2/';
        $campos = Comercio_Linha_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos);
    }
    /**
     * 
     * @global Array $language
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Linhas_Add2(){
        $titulo     = __('Linha Adicionada com Sucesso');
        $dao        = 'Comercio_Linha';
        $funcao     = '$this->Linhas();';
        $sucesso1   = __('Inserção bem sucedida');
        $sucesso2   = __('Linha cadastrada com sucesso.');
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);
    }
    /**
     * 
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Linhas_Edit($id){
        self::Endereco_Linha(true);
        // Carrega Config
        $titulo1    = 'Editar Linha (#'.$id.')';
        $titulo2    = __('Alteração de Linha');
        $formid     = 'form_Sistema_AdminC_LinhaEdit';
        $formbt     = __('Alterar Linha');
        $formlink   = 'comercio/Linha/Linhas_Edit2/'.$id;
        $editar     = Array('Comercio_Linha',$id);
        $campos = Comercio_Linha_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos,$editar);
    }
    /**
     * 
     * @global Array $language
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Linhas_Edit2($id){
        $titulo     = __('Linha Editada com Sucesso');
        $dao        = Array('Comercio_Linha',$id);
        $funcao     = '$this->Linhas();';
        $sucesso1   = __('Linha Alterada com Sucesso.');
        $sucesso2   = ''.$_POST["nome"].' teve a alteração bem sucedida';
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);      
    }
    /**
     * 
     * @global Array $language
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Linhas_Del($id){
        global $language;
        
    	$id = (int) $id;
        // Puxa linha e deleta
        $linha = $this->_Modelo->db->Sql_Select('Comercio_Linha', Array('id'=>$id));
        $sucesso =  $this->_Modelo->db->Sql_Delete($linha);
        // Mensagem
    	if($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Deletado'),
                "mgs_secundaria" => __('Linha Deletada com sucesso')
            );
    	}else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Erro')
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        
        $this->Linhas();
        
        $this->_Visual->Json_Info_Update('Titulo', __('Linha deletada com Sucesso'));  
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
}
?>
