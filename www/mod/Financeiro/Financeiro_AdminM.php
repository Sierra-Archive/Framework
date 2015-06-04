<?php

class Financeiro_AdminModelo extends Financeiro_Modelo
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
    * @version 2.0
    */
    public function __construct(){
      parent::__construct();
    }
    public function MovExt_Inserir($user,$valor,$obs,$positivo){
        GLOBAL $config;
        $admin = (int) \Framework\App\Acl::Usuario_GetID_Static();
        if(!is_int($admin) || $admin==0) return 0;
        $this->db->query('INSERT INTO '.MYSQL_FINANCEIRO_MOV_EXT.' (user,valor,positivo,obs,log_date_add,admin) VALUES (\''.$user.'\',\''.$valor.'\',\''.$positivo.'\',\''.$obs.'\',\''.APP_HORA.'\','.$admin.')');
        // Atualiza Dividas pagas sem mostrar nada na tela
        $financas = Array();
        $this->Dividas_Carregar($financas, $user);
        return 1;
    }
    public function Usuarios_devendo(&$usuarios){
        $i = 0;
        // Query
        $sql = $this->db->query('SELECT id,nome,email
        FROM '.MYSQL_USUARIOS.' WHERE deletado=0 ORDER BY nome'); //P.categoria
        while ($campo = $sql->fetch_object()) {
            $saldo = Financeiro_Modelo::Carregar_Saldo($this, $campo->id);
            if($saldo<0){
                $usuarios[$i]['saldo'] = '<font style="color:#FF0000;">- R$ '.number_format(abs($saldo), 2, ',', '.').'</font>';
                $usuarios[$i]['id'] = $campo->id;
                $usuarios[$i]['nome'] = $campo->nome;
                $usuarios[$i]['email'] = $campo->email;
                //$usuarios[$i]['nivel_usuario'] = $campo->nivel_usuario;
                //$usuarios[$i]['nivel_admin'] = $campo->nivel_admin;
                ++$i;
            }
        }
        return $i;
    }
    public function Usuarios_naodevendo(&$usuarios){
        $i = 0;
        // Query
        $sql = $this->db->query('SELECT id,nome,email,nivel_usuario,nivel_admin
        FROM '.MYSQL_USUARIOS.' WHERE deletado=0 ORDER BY nome'); //P.categoria
        while ($campo = $sql->fetch_object()) {
            $saldo = Financeiro_Modelo::Carregar_Saldo($this, $campo->id);
            if($saldo>=0){
                $usuarios[$i]['saldo'] = 'R$ '.number_format(abs($saldo), 2, ',', '.').'';
                $usuarios[$i]['id'] = $campo->id;
                $usuarios[$i]['nome'] = $campo->nome;
                $usuarios[$i]['email'] = $campo->email;
                $usuarios[$i]['nivel_usuario'] = $campo->nivel_usuario;
                $usuarios[$i]['nivel_admin'] = $campo->nivel_admin;
                ++$i;
            }
        }
        return $i;
    }
}
?>