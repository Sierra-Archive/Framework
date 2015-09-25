<?php
class categoria_Controle extends \Framework\App\Controle
{
    public function __construct(){
        // construct
        parent::__construct();
   }
    /**
     * Retorna Todos os Modulos Ativos
     * 
     * @name Categorias_CarregaModulosTotais
     * @return type
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public static function Categorias_CarregaModulosTotais(){
        return Categoria_Acesso_DAO::Mod_Acesso_Get();
    } 
}
?>