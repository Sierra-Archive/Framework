<?php
class comercio_certificado_Visual extends \Framework\App\Visual
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
    public function ErroShow() {
        return '<center><font color="#FF0000">Primeiro escolha um cliente</font></center>';
    }
}
?>