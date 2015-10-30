<?php
class comercio_MarcaControle extends comercio_Controle
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
    * @version 0.4.2
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
    * @version 0.4.2
    */
    public function Main(){
        \Framework\App\Sistema_Funcoes::Redirect(URL_PATH.'comercio/Marca/Marcas');
        return false;
    }
    static function Endereco_Marca($true=true){
        $Registro = &\Framework\App\Registro::getInstacia();
        $_Controle = $Registro->_Controle;
        $titulo = __('Marcas');
        $link = 'comercio/Marca/Marcas';
        if ($true===true){
            $_Controle->Tema_Endereco($titulo,$link);
        } else {
            $_Controle->Tema_Endereco($titulo);
        }
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Marcas(){
        self::Endereco_Marca(false);
        
        $tabela = Array(
            'Id','Nome','Funções'
        );
        $this->_Visual->Show_Tabela_DataTable_Massiva($tabela,'comercio/Marca/Marcas');
        $titulo = __('Listagem de Marcas').' (<span id="DataTable_Contador">0</span>)';  //
        $this->_Visual->Bloco_Unico_CriaJanela($titulo,'',10,Array("link"=>"comercio/Marca/Marcas_Add",'icon'=>'add','nome'=>'Adicionar Marca'));
        
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Administrar Marcas'));
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Marcas_Add(){
        self::Endereco_Marca(true);
        // Carrega Config
        $titulo1    = __('Adicionar Marca');
        $titulo2    = __('Salvar Marca');
        $formid     = 'form_Sistema_Admin_Marcas';
        $formbt     = __('Salvar');
        $formlink   = 'comercio/Marca/Marcas_Add2/';
        $campos = Comercio_Marca_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos);
    }
    /**
     * 
     * 
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Marcas_Add2(){
        $titulo     = __('Marca Adicionada com Sucesso');
        $dao        = 'Comercio_Marca';
        $funcao     = '$this->Marcas();';
        $sucesso1   = __('Inserção bem sucedida');
        $sucesso2   = __('Marca cadastrada com sucesso.');
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);
    }
    /**
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Marcas_Edit($id){
        self::Endereco_Marca(true);
        // Carrega Config
        $titulo1    = 'Editar Marca (#'.$id.')';
        $titulo2    = __('Alteração de Marca');
        $formid     = 'form_Sistema_AdminC_MarcaEdit';
        $formbt     = __('Alterar Marca');
        $formlink   = 'comercio/Marca/Marcas_Edit2/'.$id;
        $editar     = Array('Comercio_Marca',$id);
        $campos = Comercio_Marca_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos,$editar);
    }
    /**
     * 
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Marcas_Edit2($id){
        $titulo     = __('Marca Editada com Sucesso');
        $dao        = Array('Comercio_Marca',$id);
        $funcao     = '$this->Marcas();';
        $sucesso1   = __('Marca Alterada com Sucesso.');
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
    public function Marcas_Del($id){
        
        
    	$id = (int) $id;
        // Puxa linha e deleta
        $linha = $this->_Modelo->db->Sql_Select('Comercio_Marca', Array('id'=>$id));
        $sucesso =  $this->_Modelo->db->Sql_Delete($linha);
        // Mensagem
    	if ($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Deletada'),
                "mgs_secundaria" => __('Marca Deletada com sucesso')
            );
    	} else {
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Erro')
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        
        $this->Marcas();
        
        $this->_Visual->Json_Info_Update('Titulo', __('Marca deletada com Sucesso'));  
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
}
?>
