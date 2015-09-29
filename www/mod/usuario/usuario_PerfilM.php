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
    public function __construct(){
        parent::__construct();
        /*$i = 0;
        while($i<=$this->_Acl->logado_usuario->nivel_usuario){
            unset($this->campos[1]['select']['opcoes'][$i]);
            ++$i;
        }
        unset($this->campos[1]['select']['opcoes'][5]); */
    }
    public function PlanoAlterar($plano){
        if(!is_int($plano)) $plano = (int) $plano;
        if($plano<=$this->_Acl->logado_usuario->nivel_usuario) return 0;
        if($plano<0 || $plano>5) return 0;
        $id = (int) \Framework\App\Acl::Usuario_GetID_Static();
        eval('$valor = CONFIG_CLI_'.\Framework\App\Conexao::anti_injection($_POST['nivel_usuario']).'_PRECO;');
        $dt_vencimento = date("Y-m-d", time() + (FINANCEIRO_DIASVENCIMENTO * 86400));
        Financeiro_Modelo::MovInt_Inserir($this,$id,$valor,0,'usuario',\Framework\App\Conexao::anti_injection($_POST['nivel_usuario']),$dt_vencimento);
        return 1;
    }
    public function Perfilfoto_Upload_Alterar($id,$ext){
        $this->db->query('UPDATE '.MYSQL_USUARIOS.' SET foto=\''.$ext.'\' WHERE deletado!=1 AND id='.$id);
        
        return 1;
    }
    public function RESfoto_Upload_Alterar($id,$ext){
        $this->db->query('UPDATE '.MYSQL_USUARIOS.' SET foto_res=\''.$ext.'\', foto_res_apv=0 WHERE deletado!=1 AND id='.$id);
        
        return 1;
    }
    public function CNHfoto_Upload_Alterar($id,$ext){
        $this->db->query('UPDATE '.MYSQL_USUARIOS.' SET foto_cnh=\''.$ext.'\', foto_cnh_apv=0 WHERE deletado!=1 AND id='.$id);
        
        return 1;
    }
}
?>
