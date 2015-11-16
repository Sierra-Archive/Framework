<?php
class banner_Controle extends \Framework\App\Controle
{
    /**
    * Construtor
    * 
    * @name __construct
    * @access public
    *
    * @uses \Framework\App\Visual::$menu
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 0.4.2
    */
    public function __construct() {
        // construct
        parent::__construct();
    }
    /**
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 0.4.2
    */
    public static function Banners_Mostrar($model, $categoria=0) {
        /*$banner = $this->_Modelo->db->Sql_Select('Banner',Array(),1,'rand()');
        $banner->ixi = $banner->ixi + 1;*/
        //$banner = banner_Modelo::retorna_banner_aleatorio($model, $categoria);
        //banner_Modelo::banner_contabiliza_ixi($model, $id, $banner['ixi']+1);
        return '<a href="'.URL_PATH.'banner'.US.'Listar'.US.'Banner_Redirecionar'.US.$banner['id'].'/"><img alt'.__('Visualizar Banner').' src="'.ARQ_URL.'banner'.US.$banner['id'].'.'.$banner['foto'].'"></a>';
    }
}
?>