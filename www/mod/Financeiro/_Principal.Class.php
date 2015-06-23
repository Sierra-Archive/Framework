<?php
class Financeiro_Principal implements \Framework\PrincipalInterface
{
    /**
    * Função Home para o modulo financeiro aparecer na pagina HOME
    * 
    * @name Home
    * @access public
    * @static
    * 
    * @param Class &$controle Classe Controle Atual passada por Ponteiro
    * @param Class &$modelo Modelo Passado por Ponteiro
    * @param Class &$Visual Visual Passado por Ponteiro
    *
    * @uses \Framework\App\Controle::$usuario
    * @uses Financeiro_Controle::$num_Indicados
    * 
    * @return void 
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 2.0
    */
    static function Home(&$controle, &$modelo, &$Visual){
        Financeiro_Controle::Saldo_Carregar($modelo, $Visual, \Framework\App\Acl::Usuario_GetID_Static());
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