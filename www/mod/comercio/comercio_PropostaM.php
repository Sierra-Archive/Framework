<?php

class comercio_PropostaModelo extends comercio_Modelo
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
    static function Financeiro_Motivo_Exibir($motivoid){
        $motivoid = (int) $motivoid;
        $registro = \Framework\App\Registro::getInstacia();
        $_Modelo = $registro->_Modelo;
        $proposta = $_Modelo->db->Sql_Select('Comercio_Proposta',Array('id'=>$motivoid),1);
        if($proposta===false) return 'Proposta não Encontrada';
        return Array('Proposta: #'.$motivoid,$proposta->cliente2);
    }
}
?>