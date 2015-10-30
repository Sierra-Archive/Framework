<?php

namespace Framework\Classes;
/************************************************************************************************************************
*                                                                                                                       *
*                                                                                                                       *
*                                    CLASSES E FUNCTIONS ADICIONAIS FORA DA POO                                         *
*                                                                                                                       *
*                                                                                                                       *
************************************************************************************************************************/
class Tabela
{
    private $cabeca = '';
    private $corpo = '';
    private $_Registro;
    private $_Visual;
    public function __construct() {
        $this->_Registro = &\Framework\App\Registro::getInstacia();
        $this->_Visual     = &$this->_Registro->_Visual;
    }
    /**
    * Add Cabecario de uma tabela
    * 
    * @name addcabecario
    * @access public
    * 
    * @param Array $array Array com o Cabecario da Tabela
    *
    * @uses Tabela::$cabeca
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 0.4.2
    */
    public function addcabecario($array){
        $config = Array(
            'Tipo'      => 'Head',
            'Opcao'     => Array(
                'Campos'          => $array
            )
        );
        $this->cabeca .= $this->_Visual->renderizar_bloco('template_tabela',$config);
    }
    /**
    * Add Corpo de uma tabela
    * 
    * @name addcorpo
    * @access public
    * 
    * @param Array $array Array com o corpo da Tabela
    *
    * @uses Tabela::$corpo
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 0.4.2
    */
    public function addcorpo($array){
        if (!is_array($array)){
            return false;
        }
        // Percorre Array
        reset($array);
        while (key($array) !== null) {
            $current = current($array);
            if (!isset($current["class"]) || $current["class"]===false){
                $array[key($array)]["class"] = '';
            }
            next($array);
        }
        $config = Array(
            'Tipo'      => 'Body',
            'Opcao'     => Array(
                'Campos'        => $array,
                //'Classes'       => $class,
            )
        );
        $this->corpo .= $this->_Visual->renderizar_bloco('template_tabela',$config);
    }
    /**
    * Retorna a tabela
    * 
    * @name retornatabela
    * @access public
    * 
    * @uses Tabela::$cabeca
    * @uses Tabela::$corpo
    * 
    * @return string Retorna Toda a Tabela
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 0.4.2
    */
    public function retornatabela(){
        $config = Array(
            'Tipo'      => 'Escopo',
            'Opcao'     => Array(
                'head'          => $this->cabeca,
                'body'          => $this->corpo
            )
        );
        return $this->_Visual->renderizar_bloco('template_tabela',$config);
    }
}
?>
