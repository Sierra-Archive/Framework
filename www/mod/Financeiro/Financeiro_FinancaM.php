<?php

class Financeiro_FinancaModelo extends Financeiro_Modelo
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
    public function __construct() {
        parent::__construct();
    }
    static function Financeiro_Motivo_Exibir($motivoid) {
        $motivoid = (int) $motivoid;
        $Registro = &\Framework\App\Registro::getInstacia();
        $_Modelo = &$Registro->_Modelo;
        $retirada = $_Modelo->db->Sql_Select('Financeiro_Financa',Array('id'=>$motivoid),1);
        if ($retirada === FALSE) return '';
        return  Array('<b>Gasto com Finanças</b>', $retirada->categoria2);
    }
}
