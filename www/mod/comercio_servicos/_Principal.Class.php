<?php
class comercio_servicos_Principal implements \Framework\PrincipalInterface
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
        self::Widgets();
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
    public static function Widgets() {
        $Registro = &\Framework\App\Registro::getInstacia();
        $Modelo = &$Registro->_Modelo;
        $Visual = &$Registro->_Visual;
        // Titulos
        $titulo             = \Framework\App\Acl::Sistema_Modulos_Configs_Funcional('comercio_servicos_Titulo');
        $titulo2            = Framework\Classes\Texto::Transformar_Plural_Singular($titulo);
        // Calcula Serviço
        $servico_qnt = $Modelo->db->Sql_Contar('Comercio_Servicos_Servico');
        // Chama Widgets
        \Framework\App\Visual::Layoult_Home_Widgets_Add(
            $titulo, 
            'comercio_servicos/Servico/Servico/', 
            'archive', 
            $servico_qnt, 
            'olive', 
            true, 
            130
        );
        
        
        if (\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('comercio_servicos_ServicoTipo') === true) {
            // Calcula Tipo de Serviço
            $tiposervico_qnt = $Modelo->db->Sql_Contar('Comercio_Servicos_Servico_Tipo');

            \Framework\App\Visual::Layoult_Home_Widgets_Add(
                'Tipos de Serviços', 
                'comercio_servicos/ServicoTipo/Servico_Tipo/', 
                'tags', 
                $tiposervico_qnt, 
                'light-brown', 
                false, 
                120
            );
        }
    }
}
?>