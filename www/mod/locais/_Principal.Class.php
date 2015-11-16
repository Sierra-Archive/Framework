<?php
class locais_Principal implements \Framework\PrincipalInterface
{
    /**
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 0.4.2
    */
    static function Home(&$controle, &$Modelo, &$Visual) {
        return FALSE;
    }
    static function Busca(&$controle, &$Modelo, &$Visual, $busca) {
        return FALSE;
    }
    static function Config() {
        return FALSE;
    }
    
    static function Relatorio($data_inicio, $data_final, $filtro = FALSE) {
        return FALSE;
    }
    
    static function Estatistica($data_inicio, $data_final, $filtro = FALSE) {
        return FALSE;
    }
}
?>