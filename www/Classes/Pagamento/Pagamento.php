<?php
namespace Framework\Classes;

/**
* Classe para Pagamentos
*
* @author Ricardo Sierra http://ricardosierra.com.br
* @package Simple
* @version 1.0
* @copyright 2015
* @license Free http://unlicense.org/
*/

class Pagamento
{
    /**
     * @var object $_instancia 
     */
    protected $_instancia = false;
    protected $_usuario   = false;


    /**
     * __construct.
     */
    public function __construct($modulo)
    {
        $class = '\Framework\Classes\Pagamento\\'.$modulo;
        $this->_instancia = $class();
    }

    /**
     * Retorna os Modulos de Pagamento Disponiveis
     *
     * @return Simple_Mail
     */
    public function getModulos()
    {
        return array(
            'Pagseguro'
        );
    }

    public function _Pagar(&$pagamento) {
        return '<a title=\"URL do pagamento\" href=\"'.$this->_instancia->Pagamento($pagamento).'\">Ir para URL do pagamento.</a>';
    }

    public function _Retornar(&$pagamento) {
        
    }
}
