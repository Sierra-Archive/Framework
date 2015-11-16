<?php
class usuario_mensagem_Principal implements \Framework\PrincipalInterface
{
    /**
    * Função Home para o modulo mensagem aparecer na pagina HOME
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
    * @uses usuario_mensagem_Controle::$num_Indicados
    * 
    * @return void 
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 0.4.2
    */
    static function Home(&$controle, &$Modelo, &$Visual) {
        usuario_mensagem_Controle::MensagensWidgets();
        //usuario_mensagem_Controle::Mensagenslistar_naolidas($Modelo, $Visual, \Framework\App\Acl::Usuario_GetID_Static(),0);
    }
    static function Widget(&$_Controle) {
        $_Controle->Widget_Add('Superior',
        '<li class="dropdown mtop5">'.
            '<a class="dropdown-toggle element lajax" data-acao="" data-placement="bottom" data-toggle="tooltip" href="'.URL_PATH.'usuario_mensagem/Suporte/Mensagem_formulario" data-original-title="Novo Chamado">'.
                '<i class="fa fa-file"></i>'.
            '</a>'.
        '</li>');
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