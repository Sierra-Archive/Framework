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
     * @version 0.4.2
     * 
     */
    public function __construct() {
        parent::__construct();
    }
    /**
     * @name usuarios_Del
     * @param int $id Chave Primária (Id do Registro)
     * @return int
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     * 
     * #update
     */
    /*public function usuarios_Del($id) {

        $this->db->query('UPDATE '.MYSQL_USUARIOS.' SET deletado=1, ativado=0 WHERE id='.$id);
        
        return 1;
    }*/
    public function usuario_cnh_pendente(&$usuarios,$ativado=1) {
        $i = 0;
        $mysqlwhere = '';
        $sql = $this->db->query('SELECT id,nome,email,grupo
        FROM '.MYSQL_USUARIOS.' WHERE deletado=0 AND foto_cnh_apv=0 AND foto_cnh!=\'\' AND ativado='.$ativado.' ORDER BY nome'); //P.categoria
        while ($campo = $sql->fetch_object()) {
            $usuarios[$i]['id'] = $campo->id;
            $usuarios[$i]['nome'] = $campo->nome;
            $usuarios[$i]['email'] = $campo->email;
            $usuarios[$i]['grupo'] = $campo->grupo;

            $saldo = Financeiro_Modelo::Carregar_Saldo($this, $campo->id);

            if ($saldo<0) {
                $usuarios[$i]['saldo'] = '<font style="color:#FF0000;">- R$ '.number_format(abs($saldo), 2, ', ', '.').'</font>';
            } else {
                $usuarios[$i]['saldo'] = 'R$ '.number_format($saldo, 2, ', ', '.');
            }
            ++$i;
        }
        return $i;
    }
    public function usuario_cnh_aprovar($id,$aprovar='sim') {
        if ($aprovar=='sim') $cnh_apv = 2;
        else                $cnh_apv = 1;
        
        $this->db->query('UPDATE '.MYSQL_USUARIOS.' SET foto_cnh_apv='.$cnh_apv.' WHERE deletado!=1 AND id='.$id);
        
        return 1;
    }
    public function usuario_res_aprovar($id,$aprovar='sim') {
        if ($aprovar=='sim') $res_apv = 2;
        else                $res_apv = 1;
        
        $this->db->query('UPDATE '.MYSQL_USUARIOS.' SET foto_res_apv='.$res_apv.' WHERE deletado!=1 AND id='.$id);
        
        return 1;
    }
    public function usuario_res_pendente(&$usuarios,$ativado=1) {
        $i = 0;
        $mysqlwhere = '';
        $sql = $this->db->query('SELECT id,nome,email,grupo
        FROM '.MYSQL_USUARIOS.' WHERE deletado=0 AND foto_res_apv=0 AND foto_res!=\'\' AND ativado='.$ativado.' ORDER BY nome'); //P.categoria
        while ($campo = $sql->fetch_object()) {
            $usuarios[$i]['id'] = $campo->id;
            $usuarios[$i]['nome'] = $campo->nome;
            $usuarios[$i]['email'] = $campo->email;
            $usuarios[$i]['grupo'] = $campo->grupo;

            $saldo = Financeiro_Modelo::Carregar_Saldo($this, $campo->id);

            if ($saldo<0) {
                $usuarios[$i]['saldo'] = '<font style="color:#FF0000;">- R$ '.number_format(abs($saldo), 2, ', ', '.').'</font>';
            } else {
                $usuarios[$i]['saldo'] = 'R$ '.number_format($saldo, 2, ', ', '.');
            }
            ++$i;
        }
        return $i;
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    /**
     * DATA TABLE MASSIVA
     */
    
    public function ListarCliente() {
        $this->Usuario_Listagem(Array(CFG_TEC_CAT_ID_CLIENTES,\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('usuario_Cliente_nome')),false,20,false);
        return true;
    }
    public function ListarFuncionario() {
        $this->Usuario_Listagem(Array(CFG_TEC_CAT_ID_FUNCIONARIOS,\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('usuario_Funcionario_nome')),false,10,false,'Funcionario');
        return true;
    }
    public function ListarUsuario() {
        $this->Usuario_Listagem(Array(CFG_TEC_CAT_ID_ADMIN,'Usuários'),false,10,false);
        return true;
    }
    
}
?>