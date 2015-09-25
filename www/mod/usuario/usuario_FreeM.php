<?php

class usuario_FreeModelo extends usuario_Modelo
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
     * @version 0.4.2
     * 
     */
    public function __construct(){
        parent::__construct();
        $this->retirar_campos_improprios();
    }
    public function retirar_campos_improprios(){
        unset($this->campos[1]['select']['opcoes'][0]);
        unset($this->campos[1]['select']['opcoes'][5]);     
    }
}
?>