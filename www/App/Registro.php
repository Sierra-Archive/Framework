<?php
namespace Framework\App;
/**
 * Class singleton, ela garante a existencia de apenas uma instancia de cada classe
 * 
 * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
 * @version 0.4.2
 */
class Registro
{
    /**
     *
     * @var type 
     */
    private static $_instacia;
    /**
     *
     * @var type 
     */
    private $_data;
    
    /**
     * Para ninguem poder acessar a classe
     * 
     * @version 0.4.2
     * @author Ricardo Sierra <web@ricardosierra.com.br>
     */
    private function __construct() {
        
    }
    
    /**
     * singleton
     * @return type
     * 
     * @version 0.4.2
     * @author Ricardo Sierra <web@ricardosierra.com.br>
     */
    public static function &getInstacia() {
        if (!self::$_instacia instanceof self) {
            self::$_instacia = new Registro();
        }
        return self::$_instacia;
    }
    /**
     * 
     * @param type $sessao
     * 
     * @version 0.4.2
     * @author Ricardo Sierra <web@ricardosierra.com.br>
     */
    public function destruir($sessao) {
        if (isset($this->_data[$sessao])) {
            $this->_data[$sessao] = FALSE;
            unset($this->_data[$sessao]);
        }/*else{
            echo $sessao;
        }*/
    }
    /**
     * 
     * @param type $nome
     * @param type $valor
     * 
     * @version 0.4.2
     * @author Ricardo Sierra <web@ricardosierra.com.br>
     */
    public function __set($nome, $valor) {
        //var_dump($nome, $valor);
        $this->_data[$nome] = $valor;
    }
    /**
     * 
     * @param type $nome
     * @return type
     * 
     * @version 0.4.2
     * @author Ricardo Sierra <web@ricardosierra.com.br>
     */
    public function &__get($nome) {
        if (isset($this->_data[$nome])) {
            return $this->_data[$nome];
        } else {
            $this->_data[$nome] = FALSE;
            return $this->_data[$nome];
        }
    }
}

?>
