<?php
class usuario_AdminModelo extends usuario_Modelo
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
    public function usuario_cnh_pendente(&$usuarios,$ativado=1){
        $i = 0;
        $mysqlwhere = '';
        $sql = $this->db->query('SELECT id,nome,email,nivel_usuario,nivel_admin
        FROM '.MYSQL_USUARIOS.' WHERE deletado=0 AND foto_cnh_apv=0 AND foto_cnh!=\'\' AND ativado='.$ativado.' ORDER BY nome'); //P.categoria
        while ($campo = $sql->fetch_object()) {
            $usuarios[$i]['id'] = $campo->id;
            $usuarios[$i]['nome'] = $campo->nome;
            $usuarios[$i]['email'] = $campo->email;
            $usuarios[$i]['nivel_usuario'] = $campo->nivel_usuario;
            $usuarios[$i]['nivel_admin'] = $campo->nivel_admin;

            $saldo = Financeiro_Modelo::Carregar_Saldo($this, $campo->id);

            if($saldo<0){
                $usuarios[$i]['saldo'] = '<font style="color:#FF0000;">- R$ '.number_format(abs($saldo), 2, ',', '.').'</font>';
            }else{
                $usuarios[$i]['saldo'] = 'R$ '.number_format($saldo, 2, ',', '.');
            }
            ++$i;
        }
        return $i;
    }
    public function usuario_cnh_aprovar($id,$aprovar='sim'){
        if($aprovar=='sim') $cnh_apv = 2;
        else                $cnh_apv = 1;
        
        $this->db->query('UPDATE '.MYSQL_USUARIOS.' SET foto_cnh_apv='.$cnh_apv.' WHERE deletado!=1 AND id='.$id);
        
        return 1;
    }
    public function usuario_res_aprovar($id,$aprovar='sim'){
        if($aprovar=='sim') $res_apv = 2;
        else                $res_apv = 1;
        
        $this->db->query('UPDATE '.MYSQL_USUARIOS.' SET foto_res_apv='.$res_apv.' WHERE deletado!=1 AND id='.$id);
        
        return 1;
    }
    public function usuario_res_pendente(&$usuarios,$ativado=1){
        $i = 0;
        $mysqlwhere = '';
        $sql = $this->db->query('SELECT id,nome,email,nivel_usuario,nivel_admin
        FROM '.MYSQL_USUARIOS.' WHERE deletado=0 AND foto_res_apv=0 AND foto_res!=\'\' AND ativado='.$ativado.' ORDER BY nome'); //P.categoria
        while ($campo = $sql->fetch_object()) {
            $usuarios[$i]['id'] = $campo->id;
            $usuarios[$i]['nome'] = $campo->nome;
            $usuarios[$i]['email'] = $campo->email;
            $usuarios[$i]['nivel_usuario'] = $campo->nivel_usuario;
            $usuarios[$i]['nivel_admin'] = $campo->nivel_admin;

            $saldo = Financeiro_Modelo::Carregar_Saldo($this, $campo->id);

            if($saldo<0){
                $usuarios[$i]['saldo'] = '<font style="color:#FF0000;">- R$ '.number_format(abs($saldo), 2, ',', '.').'</font>';
            }else{
                $usuarios[$i]['saldo'] = 'R$ '.number_format($saldo, 2, ',', '.');
            }
            ++$i;
        }
        return $i;
    }
}
?>