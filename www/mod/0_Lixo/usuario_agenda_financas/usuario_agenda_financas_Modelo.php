<?php
class Agenda_financas_Modelo extends \Framework\App\Modelo
{
   public function __construct(){
      parent::__construct();
   } 
    public function financas_inserir($data,$valor,$positivo,$categoria,$usuario_social,$obs){
        global $tabsql, $config;

        // verifica se contem subcategoria
        if(stripos($categoria, '-')){
            $categoria = explode('-',$categoria);
            $subcat = $categoria[1];
            $categoria = $categoria[0];
        }else{
            $subcat = 0;
        }

        $this->db->query('INSERT INTO '.$tabsql['Agenda_financas'].' (user,categoria,categoria_sub,persona,valor,positivo,data,obs,log_date_add) VALUES (\''.\Framework\App\Acl::Usuario_GetID_Static().'\',\''.$categoria.'\',\''.$subcat.'\',\''.$usuario_social.'\',\''.$valor.'\',\''.$positivo.'\',\''.$data.'\',\''.$obs.'\',\''.APP_HORA.'\')');
        return 1;
    }
}
?>