<?php

class comercio_EstoqueModelo extends comercio_Modelo
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
     * @param type $produtoid
     * @param type $motivoid
     */
    static function Estoque_Exibir($produtoid,$motivoid){
        $produtoid = (int) $produtoid;
        $motivoid = (int) $motivoid;
        $registro = \Framework\App\Registro::getInstacia();
        $_Modelo = $registro->_Modelo;
        $retirada = $_Modelo->db->Sql_Select('Comercio_Fornecedor_Material',Array('id'=>$motivoid),1);
        if($retirada===false){
            return Array('Entrada Não existente','Não existe');
        }
        return Array('Entrada de Nota Fiscal','Fornecedor '.$retirada->fornecedor2);
    }
    /**
     * 
     * @param type $modelo
     * @param type $usuarioid
     * @param type $motivoid
     */
    static function Financeiro_Motivo_Exibir($motivoid){
        $motivoid = (int) $motivoid;
        if($motivoid===0){
            return Array('Compra não existe no banco de dados.','Não existe');
        }
        $registro = \Framework\App\Registro::getInstacia();
        $_Modelo = $registro->_Modelo;
        $material = $_Modelo->db->Sql_Select('Comercio_Fornecedor_Material',Array('id'=>$motivoid),1);
        if($material===false){
            return Array('Compra não existe no banco de dados.','Não existe');
        }
        return Array('Compra de Nota Fiscal '.$material->documento,'Fornecedor '.$material->fornecedor2);
    }
}
?>