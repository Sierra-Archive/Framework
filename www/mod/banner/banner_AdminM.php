<?php
class banner_AdminModelo extends banner_Modelo
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
     * @version 0.4.2
     * 
     */
    public function __construct(){
        parent::__construct();
    }
    /**
     * @name banners_Del
     * @param int $id Chave Primária (Id do Registro)
     * @return int
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    /*public function banners_Del($id){
        $this->db->query('UPDATE '.MYSQL_BANNERS.' SET deletado=1, status=0 WHERE id='.$id);
        
        return 1;
    }
    
    /**
     * Insere banners no Banco de Dados
     * 
     * @name banners_inserir
     * @access public
     * 
     * @return int
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    /*public function banners_inserir(){
        GLOBAL $config;
        $this->campos[] = array(
            'Nome' =>  'log_date_add',
            'mysql' => 'log_date_add',
            'valorpadrao' => APP_HORA
        );
        $this->campos[] = array(
            'Nome' =>  'user_criacao',
            'mysql' => 'user_criacao',
            'valorpadrao' => \Framework\App\Acl::Usuario_GetID_Static()
        );
        $this->db->query('INSERT INTO '.MYSQL_BANNERS.' '.$this->mysqlInsertCampos($this->campos));

        return 1;
    }
    /**
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @return int
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    /*public function banners_alterar($id){
        $id = (int) $id;
        if (!isset($id) || !is_int($id) || $id==0) return 0;
        $this->db->query('UPDATE '.MYSQL_BANNERS.' SET '.$this->mysqlUpdateCampos($this->campos).' WHERE id='.$id);
        
        return 1;
    }*/
    public function Banner_Upload_Alterar($id,$ext){
        $id = (int) $id;
        if (!isset($id) || !is_int($id) || $id==0) return 0;
        $this->db->query('UPDATE '.MYSQL_BANNERS.' SET foto=\''.$ext.'\' WHERE deletado!=1 AND id='.$id);
        
        return 1;
    }
}
?>