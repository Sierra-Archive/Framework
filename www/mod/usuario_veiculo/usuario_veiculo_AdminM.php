<?php

class usuario_veiculo_AdminModelo extends usuario_veiculo_Modelo
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
     * @name veiculos_Del
     * @param type $id
     * @return int
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function veiculos_Del($id){

        $this->db->query('UPDATE '.MYSQL_USUARIO_VEICULO.' SET deletado=1 WHERE deletado!=1 AND id='.$id);
        
        return 1;
    }
    /**
     * Insere Veiculos no Banco de Dados
     * 
     * @name veiculos_inserir
     * @access public
     * 
     * @global type $config
     * @param type $categoria
     * @param type $ano
     * @param type $modelo
     * @param type $marca
     * @param type $cc
     * @param type $valor1
     * @param type $valor2
     * @param type $valor3
     * @param type $franquia
     * @param string $obs
     * @return int
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function veiculos_inserir($categoria,$ano,$modelo,$marca,$cc,$valor1,$valor2,$valor3,$franquia,$obs){
        global $config;

        // verifica se contem subcategoria
        if(stripos($categoria, '-')){
            $categoria = explode('-',$categoria);
            $subcat = $categoria[1];
            $categoria = $categoria[0];
        }else{
            $subcat = 0;
        }

        $this->db->query('INSERT INTO '.MYSQL_USUARIO_VEICULO.' (categoria,categoria_sub,ano,modelo,marca,cc,valor1,valor2,valor3,franquia,obs,criacao_user,criacao_data) VALUES (\''.$categoria.'\',\''.$subcat.'\',\''.$ano.'\',\''.$modelo.'\',\''.$marca.'\',\''.$cc.'\',\''.$valor1.'\',\''.$valor2.'\',\''.$valor3.'\',\''.$franquia.'\', \''.$obs.'\',\''.\Framework\App\Acl::Usuario_GetID_Static().'\',\''.APP_HORA.'\')');
        return 1;
    }
    /**
     * 
     * @global type $config
     * @param type $id
     * @param type $categoria
     * @param type $ano
     * @param type $modelo
     * @param type $marca
     * @param type $cc
     * @param type $valor1
     * @param type $valor2
     * @param type $valor3
     * @param type $franquia
     * @param type $obs
     * @return int
     */
    public function veiculos_alterar($id,$categoria,$ano,$modelo,$marca,$cc,$valor1,$valor2,$valor3,$franquia,$obs){
        global $config;

        // verifica se contem subcategoria
        if(stripos($categoria, '-')){
            $categoria = explode('-',$categoria);
            $subcat = $categoria[1];
            $categoria = $categoria[0];
        }else{
            $subcat = 0;
        }
        $this->db->query('UPDATE '.MYSQL_USUARIO_VEICULO.' SET categoria=\''.$categoria.'\', categoria_sub=\''.$subcat.'\', ano=\''.$ano.'\', modelo=\''.$modelo.'\', marca=\''.$marca.'\', cc=\''.$cc.'\', valor1=\''.$valor1.'\', valor2=\''.$valor2.'\', valor3=\''.$valor3.'\', franquia=\''.$franquia.'\', obs=\''.$obs.'\' WHERE deletado!=1 AND id='.$id);
        
        return 1;
    }
    public function Veiculos_Upload_Alterar($id,$ext){
        $id = (int) $id;
        if(!isset($id) || !is_int($id) || $id==0) return 0;
        $this->db->query('UPDATE '.MYSQL_USUARIO_VEICULO.' SET foto=\''.$ext.'\' WHERE deletado!=1 AND id='.$id);
        
        return 1;
    }
    /**
     * Inseri Marcas no Banco de dados
     * 
     * @name marcas_inserir
     * @access public
     * 
     * @global type $tabsql
     * @global type $config
     * @param type $nome
     * @return void|int
     * 
     * @uses \Framework\App\Modelo::$db
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function marcas_inserir($nome){
        global $config;

        $this->db->query('INSERT INTO '.MYSQL_USUARIO_VEICULO_MARCAS.' (nome,criacao_user,criacao_data) VALUES (\''.$nome.'\',\''.\Framework\App\Acl::Usuario_GetID_Static().'\',\''.APP_HORA.'\')');
        return 1;
    }
}
?>