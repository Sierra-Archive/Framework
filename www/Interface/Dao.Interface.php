<?php
interface DaoInterface
{
    
    // Abstrata Podem (algumas devem) serem recriadas na dao
    static function Get_Nome();
    static function Get_Sigla();
    static function Get_Engine();
    static function Get_Charset();
    static function Get_Autoadd();
    static function Get_Class();
    static function Get_StaticTable();
    
    
    static function Gerar_Colunas();
    
    // Abstrata -> Finais
    static function Get_Colunas();
    function Get_CarregaMYSQL();
    function Get_Primaria();
    function Get_Extrangeiras();
    function __set($nome,$resultado);
    function __get($nome);
    function bd_set($nome);
    function bd_get($nome,$resultado);
    
    function Get_Object_Vars();
}
?>
