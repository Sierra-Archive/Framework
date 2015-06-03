<?php
class banner_AdminControle extends banner_Controle
{
    /**
    * Construtor
    * 
    * @name __construct
    * @access public
    * 
    * @uses banners_ListarModelo Carrega banners Modelo
    * @uses banners_ListarVisual Carrega banners Visual
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 2.0
    */
    public function __construct(){
        // construct
        parent::__construct();
    }
    /**
    * Função Main, Principal
    * 
    * @name Main
    * @access public
    * 
    * @uses banners_AdminControle::$banners_lista
    * @uses banners_AdminControle::$marcas_carregajanelaadd
    * @uses \Framework\App\Visual::$Json_Start
    * 
    * @return void 
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 2.0
    */
    public function Main(){
        // carrega lista de banners
        $this->Banners_Listar(0,1);
        // carrega lista de banners
        $this->Banners_Listar(0,0);
        // carrega form de cadastro de banners
        $this->Banners_Add();
        // ORGANIZA E MANDA CONTEUDO
        $this->_Visual->Json_Info_Update('Titulo', __('Administração de Banners'));         
    }
    /**
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 2.0
    */
    public function Banners_Listar($categoria=0,$ativado=1){
        $banners = Array();
        $i = 0;
        $this->_Modelo->retorna_banners($banners,$categoria,$ativado);
        if(!empty($banners)){
            reset($banners);
            
            foreach ($banners as $indice=>&$valor) {                
                $tabela['Id'][$i]        = $valor['id'];
                $tabela['Foto'][$i]      = $this->_Visual->Show_Upload('banner','Admin','Banner','BannerImagem'.$valor['id'],$valor['foto'],'banner'.DS,$valor['id']);
                $tabela['Categoria'][$i] = $valor['categoria'];
                $tabela['Nome'][$i]    = $valor['nome'];
                $tabela['Url'][$i]       = $valor['url'];
                $tabela['Ixibições'][$i] = $valor['ixi'].' / '.$valor['limite_ixi'];
                $tabela['Cliques'][$i]   = $valor['cliq'].' / '.$valor['limite_cliq'];
                $tabela['Funções'][$i]   = '<a title="Editar Banner" class="lajax explicar-titulo" acao="" href="'.URL_PATH.'banner/Admin/Banners_Edit/'.$valor['id'].'/"><img border="0" src="'.WEB_URL.'img/icons/icon_edit.png"></a> '.
                '<a confirma="Deseja realmente deletar esse banner?" title="Deletar Banner" class="lajax explicar-titulo" acao="" href="'.URL_PATH.'banner/Admin/Banners_Del/'.$valor['id'].'/"><img border="0" src="'.WEB_URL.'img/icons/icon_bad.png"></a>';
                ++$i;
            }
            $this->_Visual->Show_Tabela_DataTable($tabela);
            unset($tabela);
        }else{           
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhum Banner</font></b></center>');
        }
        if($ativado==0){
            $titulo = 'Todos os Banners Desativados ('.$i.')';
        }else{
            $titulo = 'Todos os Banners Ativados ('.$i.')';
        }
        $this->_Visual->Bloco_Maior_CriaJanela($titulo);
    }
    /**
    * Cria Janela Do Formulario de Cadastro de banners
    * 
    * @name Banners_Add
    * @access public
    * 
    * @param Class &$controle Classe Controle Atual passada por Ponteiro
    * @param Class &$modelo Modelo Passado por Ponteiro
    * @param Class &$Visual Visual Passado por Ponteiro
    * 
    * @uses banner_socialModelo Carrega Persona Modelo
    * @uses banner_socialModelo::$retorna_banner_social Retorna Pessoas
    * @uses financeiroControle::$banners_formcadastro retorna Formulario de Cadastro de banners
    * @uses \Framework\App\Visual::$blocar Add html ao bloco de conteudo
    * @uses \Framework\App\Visual::$Bloco_Menor_CriaJanela Add html do bloco a uma Janela Lateral Direita
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 2.0
    */
    public function Banners_Add(){
        // Carrega Config
        $titulo1    = 'Adicionar Banner';
        $titulo2    = 'Salvar Banner';
        $formid     = 'form_Sistema_Banner_Admin';
        $formbt     = 'Salvar';
        $formlink   = 'banner/Admin/Banners_Add2/';
        $campos     = Banner_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos,false,'right');
    }
    /**
     * 
     * @global Array $language
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Banners_Add2(){
        $titulo     = 'Banner Adicionado com Sucesso';
        $dao        = 'Banner';
        $funcao     = '$this->Main();';
        $sucesso1   = 'Inserção bem sucedida';
        $sucesso2   = 'Banner cadastrada com sucesso.';
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);
    }
    /**
     * 
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Banners_Edit($id){
        // Carrega Config
        $titulo1    = 'Editar Banner (#'.$id.')';
        $titulo2    = 'Alteração de Banner';
        $formid     = 'form_Sistema_AdminC_BannerEdit';
        $formbt     = 'Alterar Banner';
        $formlink   = 'predial/Banner/Banners_Edit2/'.$id;
        $editar     = Array('Banner',$id);
        $campos = Predial_Banner_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos,$editar);
    }
    /**
     * 
     * @global Array $language
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Banners_Edit2($id){
        $titulo     = 'Banner Editado com Sucesso';
        $dao        = Array('Banner',$id);
        $funcao     = '$this->Main();';
        $sucesso1   = 'Banner Alterado com Sucesso.';
        $sucesso2   = ''.$_POST["nome"].' teve a alteração bem sucedida';
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);   
    }
    /**
    * Deleta banner
    * 
    * @name Banners_Del
    * @access public
    * 
    * @uses banners_AdminModelo::$Banners_Del
    * @uses \Framework\App\Visual::$Json_IncluiTipo
    * @uses banners_AdminControle::$banners_lista
    * 
    * @return void 
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 2.0
    */
    public function Banners_Del($id){
        global $language;
        
    	$id = (int) $id;
    	$sucesso = $this->_Modelo->Banners_Del($id);
    	if($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => 'Deletado',
                "mgs_secundaria" => 'Deletado com sucesso'
            );
    	}else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => $language['mens_erro']['erro'],
                "mgs_secundaria" => $language['mens_erro']['erro']
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        
        $this->Main();
        
        $this->_Visual->Json_Info_Update('Titulo', __('Banner deletado com Sucesso'));  
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
    /**
     * 
     */
    public function Banner_UploadVer($camada,$id){
        $camada = (string) \anti_injection($camada);
        $id = (int) \anti_injection($id);
       
        
    }
    /**
     * 
     */
    public function Banner_Upload($id){
        $id = (int) $id;
        $fileTypes = array('jpg','jpeg','gif','png'); // File extensions
        $dir = 'banner'.DS;
        $ext = $this->Upload($dir,$fileTypes,$id);
        if($ext!='falso'){
            $this->_Modelo->Banner_Upload_Alterar($id,$ext); 
        }
    }
}
?>
