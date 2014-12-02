<?php

class comercio_venda_CarrinhoModelo extends comercio_vendaModelo
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
        $retirada = $_Modelo->db->Sql_Select('Comercio_Venda_Carrinho',Array('id'=>$motivoid),1);
        if($retirada===false){
            return Array('Caixa Não existente','Não existe');
        }
        if($retirada->cliente2=='' || $retirada->cliente2==NULL){
            $cliente = 'Não Cadastrado';
        }else{
            $cliente = $retirada->cliente2;
        }
        return Array('Caixa:'.$motivoid,'Cliente '.$cliente);
    }
    /**
     * 
     * @param type $modelo
     * @param type $usuarioid
     * @param type $motivoid
     */
    static function Financeiro_Motivo_Exibir($motivoid){
        $motivoid = (int) $motivoid;
        $registro = \Framework\App\Registro::getInstacia();
        $_Modelo = $registro->_Modelo;
        $caixa = $_Modelo->db->Sql_Select('Comercio_Venda_Carrinho',Array('id'=>$motivoid),1);
        if($caixa===false) return 'Caixa não Encontrado';
        return Array('Caixa: #'.$motivoid,$caixa->cliente2);
    }
}
?>