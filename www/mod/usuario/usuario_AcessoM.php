<?php
class usuario_AcessoModelo extends usuario_Modelo
{
    /**
     * __construct
     * 
     * @name __construct
     * @access public
     * 
     * @return void
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     * 
     */
    public function __construct(){
        parent::__construct();
    }
    /**
     * @name usuarios_Del
     * @param type $id
     * @return int
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     * 
     * #update
     */
    /*public function usuarios_Del($id){

        $this->db->query('UPDATE '.MYSQL_USUARIOS.' SET deletado=1, ativado=0 WHERE id='.$id);
        
        return 1;
    }*/
}
?>