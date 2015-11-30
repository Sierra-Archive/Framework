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
    * @version 0.4.24
    */
    public function __construct() {
        parent::__construct();
    }
    /**
     * 
     * @param type $Modelo
     * @param type $produtoid
     * @param type $motivoid
     */
    static function Estoque_Exibir($produtoid, $motivoid) {
        $produtoid = (int) $produtoid;
        $motivoid = (int) $motivoid;
        $Registro = &\Framework\App\Registro::getInstacia();
        $_Modelo = &$Registro->_Modelo;
        $retirada = $_Modelo->db->Sql_Select('Comercio_Venda_Carrinho',Array('id'=>$motivoid),1);
        if ($retirada === false) {
            return Array(__('Caixa Não existente'), __('Não existe'));
        }
        if ($retirada->cliente2=='' || $retirada->cliente2==NULL) {
            $cliente = __('Não Cadastrado');
        } else {
            $cliente = $retirada->cliente2;
        }
        return Array(__('Caixa:').$motivoid,'Cliente '.$cliente);
    }
    /**
     * 
     * @param type $Modelo
     * @param type $usuarioid
     * @param type $motivoid
     */
    static function Financeiro_Motivo_Exibir($motivoid) {
        $motivoid = (int) $motivoid;
        $Registro = &\Framework\App\Registro::getInstacia();
        $_Modelo = &$Registro->_Modelo;
        $caixa = $_Modelo->db->Sql_Select('Comercio_Venda_Carrinho',Array('id'=>$motivoid),1);
        if ($caixa === false) return 'Caixa não Encontrado';
        return Array('Caixa: #'.$motivoid, $caixa->cliente2);
    }
}
?>