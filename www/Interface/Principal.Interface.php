<?php
namespace Framework;
#update -> Implementar COnfig, Relatorio, Estatistica e Manutencao no MOdulo _Sistema
interface PrincipalInterface
{
    static function Home(&$controle, &$modelo, &$Visual);
    
    static function Busca(&$controle, &$modelo, &$Visual, $busca);
    
    
    //Ainda nao Implementado
    // Vai Ser Responsavel pela Configuracao do Modulo de Forma Genérica
    static function Config();
    //Ainda nao Implementado
    // Vai Ser Responsavel pelo Relatório do Modulo de Forma Genérica
    static function Relatorio($data_inicio, $data_final, $filtro = FALSE);
    //Ainda nao Implementado
    // Vai Ser Responsavel pela Estatistica do Modulo de Forma Genérica
    static function Estatistica($data_inicio, $data_final, $filtro = FALSE);
    
    //Ainda nao Implementado
    // Opcional
    //static function Manutencao(&$log);
}
?>
