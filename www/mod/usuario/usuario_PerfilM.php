<?php

class usuario_PerfilModelo extends usuario_Modelo
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
    //#update
    public function __construct() {
        parent::__construct();
    }
    public function Perfilfoto_Upload_Alterar($id,$ext) {
        $this->db->query('UPDATE '.MYSQL_USUARIOS.' SET foto=\''.$ext.'\' WHERE deletado!=1 AND id='.$id);
        
        return 1;
    }
    public function RESfoto_Upload_Alterar($id,$ext) {
        $this->db->query('UPDATE '.MYSQL_USUARIOS.' SET foto_res=\''.$ext.'\', foto_res_apv=0 WHERE deletado!=1 AND id='.$id);
        
        return 1;
    }
    public function CNHfoto_Upload_Alterar($id,$ext) {
        $this->db->query('UPDATE '.MYSQL_USUARIOS.' SET foto_cnh=\''.$ext.'\', foto_cnh_apv=0 WHERE deletado!=1 AND id='.$id);
        
        return 1;
    }
}
?>
