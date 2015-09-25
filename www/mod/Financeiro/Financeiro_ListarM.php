<?php

class Financeiro_ListarModelo extends Financeiro_Modelo
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
    public function __construct(){
      parent::__construct();
    }
    public function transferencia_inserir($login,$quantia){
        GLOBAL $config;
        $i = 0;
        $sql = $this->db->query('SELECT id
        FROM '.MYSQL_USUARIOS.' WHERE deletado!=1 AND login=\''.$login.'\' ORDER BY nome limit 1'); //P.categoria
        while ($campo = $sql->fetch_object()) {
            $userreceptor = $campo->id;
            ++$i;
        }
        if($i==0) return 0;
        // Retira saldo do usuario atual   $userreceptor
        Financeiro_Modelo::MovInt_Inserir($this,\Framework\App\Acl::Usuario_GetID_Static(),$quantia,0,'Financeiro',$userreceptor,APP_DATA,APP_HORA);
        // Acrescenta no novo usuario
        Financeiro_Modelo::MovInt_Inserir($this,$userreceptor,$quantia,1,'Financeiro',\Framework\App\Acl::Usuario_GetID_Static(),APP_DATA,APP_HORA);
        return 1;
    }
    public function sacar_inserir($quantia){
        GLOBAL $config;
        $user = (int) \Framework\App\Acl::Usuario_GetID_Static();
        if(!is_int($user) || $user==0) return 0;
        $this->db->query('INSERT INTO '.MYSQL_FINANCEIRO_MOV_EXT.' (user,valor,positivo,obs,log_date_add,log_user_add) VALUES (\''.$user.'\',\''.$quantia.'\',\'0\',\'Pedido de Saque Realizado pelo Sistema\',\''.APP_HORA.'\','.$user.')');
        return 1;
    }
}
?>