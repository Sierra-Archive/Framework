<?php
class usuario_veiculo_Principal implements \Framework\PrincipalInterface
{
    /**
    * Função Home para o modulo usuario_veiculo aparecer na pagina HOME
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
    * @uses usuario_veiculoControle::$num_Indicados
    * 
    * @return void 
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 0.4.2
    */
    static function Home(&$controle, &$modelo, &$Visual){
        //usuario_veiculo_Controle::num_Indicados($modelo, $Visual, \Framework\App\Acl::Usuario_GetID_Static());
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
        $Modelo = &$Registro->_Modelo;
        $Visual = &$Registro->_Visual;
        // Widget Equipamento
        if(\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('usuario_veiculo_Equipamento')){
            // Calcula Equipamento
            $equipamento_qnt = $Modelo->db->Sql_Contar('Usuario_Veiculo_Equipamento');
            // Chama Widgets
            \Framework\App\Visual::Layoult_Home_Widgets_Add(
               'Equipamentos', 
               'usuario_veiculo/Equipamento/Equipamentos/', 
               'laptop', 
               $equipamento_qnt, 
               'block-red', 
               false, 
               110
            );
        }
        // Calcula Veiculo
        $veiculo_qnt = $Modelo->db->Sql_Contar('Usuario_Veiculo');
        \Framework\App\Visual::Layoult_Home_Widgets_Add(
            'Veiculos', 
            'usuario_veiculo/Veiculo/Veiculos/', 
            'road', 
            $veiculo_qnt, 
            'block-green', 
            true, 
            100
        );
    }
}
?>
