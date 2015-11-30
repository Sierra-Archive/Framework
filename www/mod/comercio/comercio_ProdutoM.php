<?php

class comercio_ProdutoModelo extends comercio_Modelo
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
    /**
     * 
     * @param type $modelo
     * @param type $usuarioid
     * @param type $motivoid
     */
    static function Estoque_Exibir($produtoid,$motivoid){
        $produtoid = (int) $produtoid;
        $motivoid = (int) $motivoid;
        $registro = \Framework\App\Registro::getInstacia();
        $_Modelo = $registro->_Modelo;
        $retirada = $_Modelo->db->Sql_Select('Comercio_Produto_Estoque_Reduzir',Array('id'=>$motivoid),1);
        if($retirada===false){
            return Array('Redução Não existente','Não existe');
        }
        return Array('Redução de Estoque','Cadastrado por #'.$retirada->log_user_add);
    }
}
?>