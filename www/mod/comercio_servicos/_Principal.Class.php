<?php
class comercio_servicos_Principal implements PrincipalInterface
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
    * @version 2.0
    */
    static function Home(&$controle, &$modelo, &$Visual){
        self::Widgets();
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
    public static function Widgets(){
        $Registro = &\Framework\App\Registro::getInstacia();
        $modelo = $Registro->_Modelo;
        $Visual = $Registro->_Visual;
        // Titulos
        $titulo             = \Framework\App\Acl::Sistema_Modulos_Configs_Funcional('comercio_servicos_Titulo');
        $titulo2            = Framework\Classes\Texto::Transformar_Plural_Singular($titulo);
        // Calcula Serviço
        $servico = $modelo->db->Sql_Select('Comercio_Servicos_Servico',Array());
        if(is_object($servico)) $servico = Array(0=>$servico);
        if($servico!==false && !empty($servico)){reset($servico);$servico_qnt = count($servico);}else{$servico_qnt = 0;}
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
        
        
        if(\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('comercio_servicos_ServicoTipo')===true){
            // Calcula Tipo de Serviço
            $tiposervico = $modelo->db->Sql_Select('Comercio_Servicos_Servico_Tipo',Array());
            if(is_object($tiposervico)) $tiposervico = Array(0=>$tiposervico);
            if($tiposervico!==false && !empty($tiposervico)){reset($tiposervico);$tiposervico_qnt = count($tiposervico);}else{$tiposervico_qnt = 0;}

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