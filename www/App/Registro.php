<?php
namespace Framework\App;
class Registro
{
    private static $_instacia;
    private $_data;
    
    // Para ninguem poder acessar a classe
    private function __construct(){
        
    }
    
    // singleton
    public static function &getInstacia(){
        if(!self::$_instacia instanceof self){
            self::$_instacia = new Registro();
        }
        return self::$_instacia;
    }
    public function destruir($sessao){
        if(isset($this->_data[$sessao])){
            $this->_data[$sessao] = '';
            unset($this->_data[$sessao]);
        }/*else{
            echo $sessao;
        }*/
    }
    public function __set($nome,$valor){
        $this->_data[$nome] = $valor;
    }
    public function &__get($nome){
        if(isset($this->_data[$nome])){
            return $this->_data[$nome];
        }else{
            $this->_data[$nome] = false;
            return $this->_data[$nome];
        }
    }
}

?>
