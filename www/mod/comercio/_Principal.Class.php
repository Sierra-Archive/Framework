<?php
class comercio_Principal implements \Framework\PrincipalInterface
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
    * @version 0.4.2
    */
    static function Home(&$controle,    &$Modelo, &$Visual) {
        self::Widgets();
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
    public static function Widgets() {
        $Registro = &\Framework\App\Registro::getInstacia();
        $Modelo = &$Registro->_Modelo;
        $Visual = &$Registro->_Visual;
        
        // Fornecedor
        if (\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('comercio_Fornecedor')) {
            $fornecedor_qnt = $Modelo->db->Sql_Contar('Comercio_Fornecedor');
            // Adiciona Widget a Pagina Inicial
            \Framework\App\Visual::Layoult_Home_Widgets_Add(
                'Fornecedores', 
                'comercio/Fornecedor/Fornecedores', 
                'truck', 
                $fornecedor_qnt, 
                'block-yellow', 
                FALSE, 
                150
            );
        }
        
        
        // Produto
        if (\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('comercio_Produto')) {
            // Calculo Produto
            $produto_qnt = $Modelo->db->Sql_Contar('Comercio_Produto');
            // Adiciona Widget a Pagina Inicial
            \Framework\App\Visual::Layoult_Home_Widgets_Add(
               'Produtos',
               'comercio/Produto/Produtos/',
               'tags',
               $produto_qnt,
               'block-azulescuro',
               FALSE,
               113
            );
            if (\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('comercio_Linha_Widget')) {
                // Calculo Linha
                $linha_qnt = $Modelo->db->Sql_Contar('Comercio_Linha');
               // Adiciona Widget a Pagina Inicial
                \Framework\App\Visual::Layoult_Home_Widgets_Add(
                    'Linhas',
                    'comercio/Linha/Linhas/',
                    'tag',
                    $linha_qnt,
                    'light-green',
                    FALSE,
                    112
                );
            }
        }
        
        
        
    }
}
?>