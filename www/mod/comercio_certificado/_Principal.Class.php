<?php
class comercio_certificado_Principal implements \Framework\PrincipalInterface
{
    /**
    * Função Home
    * 
    * @name Home
    * @access public
    * @static
    * 
    * @return void 
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 0.4.24
    */
    static function Home(&$controle, &$Modelo, &$Visual) {
        return false;
    }
    static function Busca(&$controle, &$Modelo, &$Visual, $busca) {
        return false;
    }
    static function Config() {
        return false;
    }
    
    static function Relatorio($data_inicio, $data_final, $filtro = false) {
        return false;
    }
    
    static function Estatistica($data_inicio, $data_final, $filtro = false) {
        return false;
    }
}
?>