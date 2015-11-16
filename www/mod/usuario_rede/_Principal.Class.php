<?php
class usuario_rede_Principal implements \Framework\PrincipalInterface
{
    /**
    * Função Home para o modulo rede aparecer na pagina HOME
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
    * @uses usuario_rede_Controle::$num_Indicados
    * 
    * @return void 
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 0.4.2
    */
    static function Home(&$controle, &$Modelo, &$Visual) {
        if (\Framework\App\Acl::Usuario_GetLogado_Static() !== FALSE) {
            usuario_rede_Controle::num_Indicados($Modelo, $Visual, \Framework\App\Acl::Usuario_GetID_Static());
        }
        usuario_rede_Controle::Ranking_listar($Modelo, $Visual);
        
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