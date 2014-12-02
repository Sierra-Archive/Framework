<?php
class banner_ListarControle extends banner_Controle
{
    /**
    * Construtor
    * 
    * @name __construct
    * @access public
    * 
    * @uses banner_rede_PerfilModelo::Carrega Rede Modelo
    * @uses banner_rede_PerfilVisual::Carrega Rede Visual
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
    * @uses banner_Controle::$bannerPerfil
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 2.0
    */
    public function Main(){
        $this->Banners_Listar();
        // ORGANIZA E MANDA CONTEUDO
        $this->_Visual->Json_Info_Update('Titulo','Banners'); 
    }
    public function Banner_Redirecionar($id = 0){
        $id = (int) $id;
        if($id == 0)            return;
        
        /*$banner = $this->_Modelo->db->Sql_Select('Banner',Array('id'=>$id));
        $banner->cliq = $banner->cliq+1;
        $this->_Modelo->db->Sql_Update($banner);*/
        $banner = $this->_Modelo->retorna_banner($id);
        $this->_Modelo->banner_contabiliza_cliq($id,$banner['cliq']+1);
        
        
        
        \Framework\App\Sistema_Funcoes::Redirect($banner['url']);
    }
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
}
?>