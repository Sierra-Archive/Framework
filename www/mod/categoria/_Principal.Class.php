<?php
class categoria_Principal implements \Framework\PrincipalInterface
{
    /**
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 3.1.1
    */
    static function Home(&$controle, &$modelo, &$Visual){
        return false;
    }
    static function Busca(&$controle, &$modelo, &$Visual,$busca){
        return false;
    }
    static function Config(){
        return false;
    }
    
    static function Relatorio($data_inicio,$data_final,$filtro=false){
        return false;
    }
    
    static function Estatistica($data_inicio,$data_final,$filtro=false){
        return false;
    }
}
?>