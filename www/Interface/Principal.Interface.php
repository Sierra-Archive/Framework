<?php
interface PrincipalInterface
{
    static function Home(&$controle, &$modelo, &$Visual);
    static function Busca(&$controle, &$modelo, &$Visual, $busca);
    static function Config();
    static function Relatorio($data_inicio, $data_final, $filtro=false);
    static function Estatistica($data_inicio,$data_final,$filtro=false);
}
?>
