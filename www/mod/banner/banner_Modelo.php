<?php
class banner_Modelo extends \Framework\App\Modelo
{
    /**
    * Construtor
    * 
    * @name __construct
    * @access public
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 0.4.2
    */
    public $campos = Array();
    public function __construct(){
        //GLOBAL $config;
        parent::__construct();
    } 
    /**
    * Retorna todos os banners
    * 
    * @name retorna_banners
    * @access public
    * 
    * @uses \Framework\App\Modelo::$banner
    * @uses \Framework\App\Modelo::$db
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 0.4.2
    */
    public function retorna_banners(&$banners,$categoria=0,$ativado=1){
        $i = 0;
        $mysqlwhere = '';
        if ($categoria==0) $EXTRA = '';
        else              $EXTRA = ' AND B.categoria='.$categoria;
        $sql = $this->db->query('SELECT B.id, B.ixi, B.cliq
        FROM '.MYSQL_BANNERS.' B, '.MYSQL_CAT.' C WHERE B.deletado=0 AND B.categoria=C.id AND B.status='.$ativado.$EXTRA.' ORDER BY rand()');
        while ($campo = $sql->fetch_object()) {
            $banners[$i]['id'] = $campo->id;
            $banners[$i]['ixi'] = $campo->ixi;
            $banners[$i]['cliq'] = $campo->cliq;
            ++$i;
        }
        return $i;
    }
    /**
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @return string
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function retorna_banner($id){
        $id = (int) $id;
        if (!isset($id) || !is_int($id) || $id==0) return 0;
        $banner = Array();
        $sql = $this->db->query(' SELECT B.id, B.ixi, B.cliq
        FROM '.MYSQL_BANNERS.' B, '.MYSQL_CAT.' C
        WHERE B.deletado=0 AND B.categoria=C.id AND B.id='.$id.' LIMIT 1'); //P.categoria
        while ($campo = $sql->fetch_object()) {
            $banner['id'] = $campo->id;
            $banner['ixi'] = $campo->ixi;
            $banner['cliq'] = $campo->cliq;
        }
        return $banner;
    }
    public function banner_contabiliza_cliq($id,$cliq){
        $id = (int) $id;
        if (!isset($id) || !is_int($id) || $id==0) return 0;
        $this->db->query('UPDATE '.MYSQL_BANNERS.' SET cliq='.$cliq.' WHERE id='.$id); //P.categoria
        return 1;
    }
    public static function banner_contabiliza_ixi(&$model, $id,$ixi){
        $id = (int) $id;
        if (!isset($id) || !is_int($id) || $id==0) return 0;
        $model->db->query('UPDATE '.MYSQL_BANNERS.' SET ixi='.$ixi.' WHERE id='.$id); //P.categoria
        return 1;
    }
    public static function retorna_banner_aleatorio(&$model, $cat){
        $cat = (int) $cat;
        if (!isset($cat) || !is_int($cat) || $cat=='') return 0;
        $banner = Array();
        $sql = $model->db->query(' SELECT B.id, B.ixi, B.cliq, B.url, B.foto
        FROM '.MYSQL_BANNERS.' B
        WHERE ((B.ixi<B.limite_ixi OR B.cliq<B.limite_cliq) or (B.limite_ixi=0 AND B.limite_cliq=0)) AND B.deletado=0 AND B.categoria='.$cat.' ORDER BY RAND() LIMIT 1'); //P.categoria
        while ($campo = $sql->fetch_object()) {
            $banner['id'] = $campo->id;
            $banner['ixi'] = $campo->ixi;
            $banner['cliq'] = $campo->cliq;
            $banner['url'] = $campo->url;
            $banner['foto'] = $campo->foto;
        }
        return $banner;
    }
}
?>