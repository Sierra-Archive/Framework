<?php

namespace Framework\Classes;
/************************************************************************************************************************
*                                                                                                                       *
*                                                                                                                       *
*                                    CLASSES E FUNCTIONS ADICIONAIS FORA DA POO                                         *
*                                                                                                                       *
*                                                                                                                       *
************************************************************************************************************************/
/**
 * Classe Utilizada para o Tratamento de Textos em Portugues
 */
class Texto
{
    /**
     *Armazena o Texto quando é Iniciada a Classe e Desejamos trablahar com Todo o tempo
     * @var type 
     */
    private $texto = '';
    public function __construct($texto=false) {
        $this->texto = $texto;
    }
    /**
     * Pega um Texto no Plural e Transforma todo ele em singular
     * @param type $nome
     * @return type
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.2
     */
    public static function Transformar_Plural_Singular($nome) {
        $nome = str_replace(Array('res ','s ','ões '), Array('r','','ão'), $nome.' ');
        return $nome;
    }
    /**
     * Verifica se Uma palavra está no masculino ou feminino
     * @param varchar $palavra
     * @return boolean
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.2
     */
    public static function Captura_Palavra_Masculina($palavra) {
        $palavra = (string) $palavra;
        $tam = strlen($palavra);
        
        if ($tam>1 && $palavra[$tam-1]=='a') {
            return false;
        }else if ($tam>2 && $palavra[$tam-2]=='a' && $palavra[$tam-1]=='s') {
            return false;
        }else if ($tam>2 && $palavra[$tam-2]=='e' && $palavra[$tam-1]=='s') {
            return false;
        }
        
        return true;
        
    }
}




/*
        
        
        // PREPOSICOES
        
        /*$array = 'a, ante, após, até, com, contra, de, desde, em, entre, para, por, perante, sem, sob, sobre, trás';
        $array = explode(', ', $array);
        reset($array);
        while(key($array)!==NULL) {
            $objeto = new \Gramatica_Preposicao_DAO();
            $objeto->palavra = current($array);
            $objeto->tipo    = 0;
            $this->_Modelo->db->Sql_Insert($objeto);
            next($array);
        }*/
        /*$array = 'afora, como, conforme, consoante, durante, exceto, feito, fora, mediante, menos, salvo, segundo, tirante, visto';
        $array = explode(', ', $array);
        reset($array);
        while(key($array)!==NULL) {
            $objeto = new \Gramatica_Preposicao_DAO();
            $objeto->palavra = current($array);
            $objeto->tipo    = 1;
            $this->_Modelo->db->Sql_Insert($objeto);
            next($array);
        }*/
        /*$array = 'do, neste, à, duma, na';
        $array = explode(', ', $array);
        reset($array);
        while(key($array)!==NULL) {
            $objeto = new \Gramatica_Preposicao_DAO();
            $objeto->palavra = current($array);
            $objeto->tipo    = 2;
            $this->_Modelo->db->Sql_Insert($objeto);
            next($array);
        }*/
?>
