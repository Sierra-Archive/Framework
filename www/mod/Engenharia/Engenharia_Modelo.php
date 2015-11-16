<?php
class Engenharia_Modelo extends \Framework\App\Modelo
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
    /**
     * 
     * @param type $Modelo
     * @param type $usuarioid
     * @param type $motivoid
     */
    static function Estoque_Exibir($produtoid, $motivoid) {
        $produtoid = (int) $produtoid;
        $motivoid = (int) $motivoid;
        $Registro = &\Framework\App\Registro::getInstacia();
        $_Modelo = &$Registro->_Modelo;
        $retirada = $_Modelo->db->Sql_Select('Engenharia_Estoque_Retirada',Array('id'=>$motivoid),1);
        return Array('Gasto com Empreendimento', 'Empreendimento'.$retirada->idempreendimento2);
    }
    static function Financeiro_Motivo_Exibir($motivoid) {
        $motivoid = (int) $motivoid;
        $Registro = &\Framework\App\Registro::getInstacia();
        $_Modelo = &$Registro->_Modelo;
        $retirada = $_Modelo->db->Sql_Select('Engenharia_Empreendimento_Custo',Array('id'=>$motivoid),1);
        return Array('<b>Gasto com Empreendimento / Unidade:</b><br> '.$retirada->empreendimento2.' / '.$retirada->unidade2,cliente);
    }
}
?>