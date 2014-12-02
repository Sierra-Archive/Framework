<?php

namespace Framework\Classes;
/************************************************************************************************************************
*                                                                                                                       *
*                                                                                                                       *
*                                    CLASSES E FUNCTIONS ADICIONAIS FORA DA POO                                         *
*                                                                                                                       *
*                                                                                                                       *
************************************************************************************************************************/
class Texto
{
    private $texto = '';
    public function __construct($texto=false) {
        $this->texto = $texto;
    }
    public static function Transformar_Plural_Singular($nome){
        $nome = str_replace(Array('res ','s ','ões '), Array('r','','ão'), $nome.' ');
        return $nome;
    }
    public static function Captura_Palavra_Masculina($palavra){
        
    }
}




/*
        
        
        // PREPOSICOES
        
        /*$array = 'a, ante, após, até, com, contra, de, desde, em, entre, para, por, perante, sem, sob, sobre, trás';
        $array = explode(', ', $array);
        reset($array);
        while(key($array)!==NULL){
            $objeto = new \Gramatica_Preposicao_DAO();
            $objeto->palavra = current($array);
            $objeto->tipo    = 0;
            $this->_Modelo->db->Sql_Inserir($objeto);
            next($array);
        }*/
        /*$array = 'afora, como, conforme, consoante, durante, exceto, feito, fora, mediante, menos, salvo, segundo, tirante, visto';
        $array = explode(', ', $array);
        reset($array);
        while(key($array)!==NULL){
            $objeto = new \Gramatica_Preposicao_DAO();
            $objeto->palavra = current($array);
            $objeto->tipo    = 1;
            $this->_Modelo->db->Sql_Inserir($objeto);
            next($array);
        }*/
        /*$array = 'do, neste, à, duma, na';
        $array = explode(', ', $array);
        reset($array);
        while(key($array)!==NULL){
            $objeto = new \Gramatica_Preposicao_DAO();
            $objeto->palavra = current($array);
            $objeto->tipo    = 2;
            $this->_Modelo->db->Sql_Inserir($objeto);
            next($array);
        }*/
?>
