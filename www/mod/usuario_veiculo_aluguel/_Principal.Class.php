<?php
class usuario_veiculo_aluguel_Principal implements \Framework\PrincipalInterface
{
    /**
    * Função Home para o modulo aluguel aparecer na pagina HOME
    * 
    * @name Home
    * @access public
    * @static
    * 
    * @param Class &$controle Classe Controle Atual passada por Ponteiro
    * @param Class &$Modelo Modelo Passado por Ponteiro
    * @param Class &$Visual Visual Passado por Ponteiro
    *
    * @uses \Framework\App\Controle::$usuario
    * @uses usuario_veiculo_aluguelControle::$num_Indicados
    * 
    * @return void 
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 0.4.2
    */
    static function Home(&$controle, &$Modelo, &$Visual) {
        //usuario_veiculo_aluguel_Controle::num_Indicados($Modelo, $Visual, \Framework\App\Acl::Usuario_GetID_Static());
    }
    static function Busca(&$controle, &$Modelo, &$Visual,$busca) {
        return false;
    }
    static function Config() {
        return false;
    }
    
    static function Relatorio($data_inicio,$data_final,$filtro=false) {
        return false;
    }
    
    static function Estatistica($data_inicio,$data_final,$filtro=false) {
        return false;
    }
}
?>