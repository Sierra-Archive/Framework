<?php

class comercio_venda_Principal implements PrincipalInterface
{
    /**
    * Função Home para o modulo comercio_venda aparecer na pagina HOME
    * 
    * @name Home
    * @access public
    * @static
    * 
    * @param Class &$controle Classe Controle Atual passada por Ponteiro
    * @param Class &$modelo Modelo Passado por Ponteiro
    * @param Class &$Visual Visual Passado por Ponteiro
    *
    * @uses \Framework\App\Controle::$comercio_venda
    * 
    * @return void 
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 2.0
    */
    static function Home(&$controle, &$modelo, &$Visual){
        return 0;
    }
    static function Busca(&$controle, &$modelo, &$Visual,$busca){
        return false;
    }
    static function Config(){
        return false;
    }

    public static function Estatistica($data_inicio, $data_final, $filtro = false) {
        return false;
    }

    public static function Relatorio($data_inicio, $data_final, $filtro = false) {
        return false;
    }

}
?>