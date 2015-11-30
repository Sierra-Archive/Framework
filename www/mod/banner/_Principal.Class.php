<?php
class banner_Principal implements \Framework\PrincipalInterface
{
    /**
    * Função Home para o modulo banner aparecer na pagina HOME
    * 
    * @name Home
    * @access public
    * @static
    * 
    * @param Class &$controle Classe Controle Atual passada por Ponteiro
    * @param Class &$Modelo Modelo Passado por Ponteiro
    * @param Class &$Visual Visual Passado por Ponteiro
    *
    * @uses \Framework\App\Controle::$banner
    * 
    * @return void 
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 0.4.24
    */
    static function Home(&$controle, &$Modelo, &$Visual) {
        $Visual->Blocar(banner_Controle::Banners_Mostrar($Modelo,7));
        $Visual->Bloco_Menor_CriaJanela(__('Publicidade'));
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