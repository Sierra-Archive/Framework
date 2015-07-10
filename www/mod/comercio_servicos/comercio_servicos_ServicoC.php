<?php
class comercio_servicos_ServicoControle extends comercio_servicos_Controle
{
    /**
    * Construtor
    * 
    * @name __construct
    * @access public
    * 
    * @uses comercio_servicos_rede_PerfilModelo::Carrega Rede Modelo
    * @uses comercio_servicos_rede_PerfilVisual::Carrega Rede Visual
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 3.1.1
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
    * @uses comercio_servicos_Controle::$servicosPerfil
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 3.1.1
    */
    public function Main(){
        \Framework\App\Sistema_Funcoes::Redirect(URL_PATH.'comercio_servicos/Servico/Servico');
        return false;
    }
    static function Endereco_Servico($true=true){
        $registro = \Framework\App\Registro::getInstacia();
        $_Controle = $registro->_Controle;
        if($true===true){
            $_Controle->Tema_Endereco(\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('comercio_servicos_Titulo'),'comercio_servicos/Servico/Servico');
        }else{
            $_Controle->Tema_Endereco(\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('comercio_servicos_Titulo'));
        }
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public function Servico($export=false){
        self::Endereco_Servico(false);
        $titulo = \Framework\App\Acl::Sistema_Modulos_Configs_Funcional('comercio_servicos_Titulo');
        $titulo2 = Framework\Classes\Texto::Transformar_Plural_Singular($titulo);
        if(Framework\Classes\Texto::Captura_Palavra_Masculina($titulo2)===true){
            $titulo_com_sexo        = 'o '.Framework\Classes\Texto::Transformar_Plural_Singular($titulo);
            $titulo_com_sexo_mudo   = ' '.Framework\Classes\Texto::Transformar_Plural_Singular($titulo);
        }else{
            $titulo_com_sexo        = 'a '.Framework\Classes\Texto::Transformar_Plural_Singular($titulo);
            $titulo_com_sexo_mudo   = 'a '.Framework\Classes\Texto::Transformar_Plural_Singular($titulo);
        }
        
        $tabela_colunas = Array();

        if(\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('comercio_servicos_ServicoTipo')){
            $tabela_colunas[] = 'Tipo d'.$titulo_com_sexo;
        }
        if(\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('comercio_servicos_nome')){
            $tabela_colunas[] = __('Nome');
        }
        
        $tabela_colunas[] = __('Descriçao');
        $tabela_colunas[] = __('Preço');
        $tabela_colunas[] = __('Funções');

        $this->_Visual->Show_Tabela_DataTable_Massiva($tabela_colunas,'comercio_servicos/Servico/Servico');
        $titulo = 'Listagem de '.$titulo;
        $this->_Visual->Bloco_Unico_CriaJanela($titulo.' (<span id="DataTable_Contador">0</span>)','',10,Array("link"=>"comercio_servicos/Servico/Servicos_Add",'icon'=>'add','nome'=>'Adicionar nov'.$titulo_com_sexo));
        
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Administrar ').$titulo);
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public function Servicos_Add(){
        self::Endereco_Servico();
        // Titulos
        $titulo             = \Framework\App\Acl::Sistema_Modulos_Configs_Funcional('comercio_servicos_Titulo');
        $titulo2            = Framework\Classes\Texto::Transformar_Plural_Singular($titulo);
        // Carrega Config
        $titulo1    = 'Adicionar '.$titulo2;
        $titulo2    = 'Salvar '.$titulo2;
        $formid     = 'form_Sistema_Servico_Servicos';
        $formbt     = __('Salvar');
        $formlink   = 'comercio_servicos/Servico/Servicos_Add2/';
        $campos = Comercio_Servicos_Servico_DAO::Get_Colunas();
        self::Campos_Deletar($campos);
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos);
    }
    /**
     * 
     * 
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public function Servicos_Add2(){
        $titulo     = __('Adicionado com Sucesso');
        $dao        = 'Comercio_Servicos_Servico';
        $funcao     = '$this->Servico();';
        $sucesso1   = __('Inserção bem sucedida');
        $sucesso2   = __('Cadastrado com sucesso.');
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);
    }
    /**
     * 
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public function Servicos_Edit($id){
        self::Endereco_Servico();
        // Titulos
        $titulo             = \Framework\App\Acl::Sistema_Modulos_Configs_Funcional('comercio_servicos_Titulo');
        $titulo2            = Framework\Classes\Texto::Transformar_Plural_Singular($titulo);
        // Carrega Config
        $titulo1    = 'Editar Serviço (#'.$id.')';
        $titulo2    = 'Alteração de '.$titulo2;
        $formid     = 'form_Sistema_ServicoC_ServiçoEdit';
        $formbt     = 'Alterar '.$titulo2;
        $formlink   = 'comercio_servicos/Servico/Servicos_Edit2/'.$id;
        $editar     = Array('Comercio_Servicos_Servico',$id);
        $campos = Comercio_Servicos_Servico_DAO::Get_Colunas();
        self::Campos_Deletar($campos);
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos,$editar);
    }
    /**
     * 
     * 
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public function Servicos_Edit2($id){
        $titulo     = __('Editado com Sucesso');
        $dao        = Array('Comercio_Servicos_Servico',$id);
        $funcao     = '$this->Servico();';
        $sucesso1   = __('Alterado com Sucesso.');
        $sucesso2   = ''.$_POST["nome"].' teve a alteração bem sucedida';
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);   
    }
    /**
     * 
     * 
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public function Servicos_Del($id){
        
    	$id = (int) $id;
        // Puxa setor e deleta
        $setor = $this->_Modelo->db->Sql_Select('Comercio_Servicos_Servico', Array('id'=>$id));
        $sucesso =  $this->_Modelo->db->Sql_Delete($setor);
        // Mensagem
    	if($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Deletado'),
                "mgs_secundaria" => __('Deletado com sucesso')
            );
    	}else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Erro')
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        
        $this->Servico();
        
        $this->_Visual->Json_Info_Update('Titulo', __('Deletado com Sucesso'));  
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
    /**
     * 
     * @param type $tipo
     * @param type $campos
     * @param type $form
     */
    public static function Campos_Deletar(&$campos){
        // SE nao tiver Foto tira foto
        if(!\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('comercio_servicos_ServicoTipo')){
            self::DAO_Campos_Retira($campos, 'tipo');
        }
        if(!\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('comercio_servicos_nome')){
            self::DAO_Campos_Retira($campos, 'nome');
        }
    }
}
?>
