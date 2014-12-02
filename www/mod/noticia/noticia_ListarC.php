<?php
class noticia_ListarControle extends noticia_Controle
{
    /**
    * Construtor
    * 
    * @name __construct
    * @access public
    * 
    * @uses noticia_rede_PerfilModelo::Carrega Rede Modelo
    * @uses noticia_rede_PerfilVisual::Carrega Rede Visual
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
    * @uses noticia_Controle::$noticiaPerfil
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 2.0
    */
    public function Main(){
        $this->Noticias_Listar();
        // ORGANIZA E MANDA CONTEUDO
        $this->_Visual->Json_Info_Update('Titulo','Noticias'); 
    }
    /**
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 2.0
    */
    public function Noticias_Listar($categoria=0,$status=1){
        $i = 0;
        $where = Array();
        if($categoria!=0)       $where['categoria'] = $categoria;
        if($status  !==false)  $where['status']   = $status;
        $noticias = $this->_Modelo->db->Sql_Select('Noticia',$where);
        if(is_object($menus)) $menus = Array(0=>$menus);
        if($menu!==false && !empty($menu)){
            reset($menu);
            foreach ($menu as &$valor) {
                if($valor->destaque==0)     $destaque = 'Não';
                else                        $destaque = 'Sim';
                
                
                $tabela['Id'][$i]           = $valor->id;
                $tabela['Categoria'][$i]    = $valor->categoria2;
                $tabela['Titulo'][$i]       = $valor->titulo;
                $tabela['Destaque'][$i]     = $destaque;
                ++$i;
            }
            $this->_Visual->Show_Tabela_DataTable($tabela);
            unset($tabela);
        }else{           
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhuma Noticia</font></b></center>');
        }
        if($status==0){
            $titulo = 'Todas as Noticias Desativadas ('.$i.')';
        }else{
            $titulo = 'Todas as Noticias Ativadas ('.$i.')';
        }
        $this->_Visual->Bloco_Unico_CriaJanela($titulo);
    }
}
?>