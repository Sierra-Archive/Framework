<?php
namespace Framework\App;
/**
 * Tratamento de Sessão
 * 
 * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
 * @version 0.4.2
 */
final Class Session {
    /**
     *
     * @var type 
     */
    private static $Iniciado = false;
    /**
     * 
     * @return boolean
     * 
     * @version 0.4.2
     * @author Ricardo Sierra <web@ricardosierra.com.br>
     */
    public static function init() {
        if (self::$Iniciado===true) {
            return true;
        }
        self::$Iniciado = true;
        
        session_start();
        
        return true;
    }
    /**
     * 
     * @param type $clave
     * 
     * @version 0.4.2
     * @author Ricardo Sierra <web@ricardosierra.com.br>
     */
    public static function destroy($clave=false) {
        if (self::$Iniciado!==true) {
            self::init();
        }
        if ($clave===false) {
            session_destroy();
        } else {
            if (is_array($clave)) {
                $clave_qnt = $count($clave);
                for($i=0; $i<$clave_qnt; ++$i) {
                    if (isset($_SESSION[$clave[$i]])) {
                        unset($_SESSION[$clave[$i]]);
                    }
                }
            } else {
                if (isset($_SESSION[$clave])) {
                    unset($_SESSION[$clave]);
                }
            }
        }
    }
    /**
     * 
     * @param type $clave
     * @param type $valor
     * @return boolean
     * 
     * @version 0.4.2
     * @author Ricardo Sierra <web@ricardosierra.com.br>
     */
    public static function set($clave,$valor) {
        if (self::$Iniciado!==true) {
            self::init();
        }
        if (!empty($clave)) {
            $_SESSION[$clave] = $valor;
        }
        return false;
    }
    /**
     * 
     * @param type $clave
     * @return boolean
     * 
     * @version 0.4.2
     * @author Ricardo Sierra <web@ricardosierra.com.br>
     */
    public static function get($clave) {
        if (self::$Iniciado!==true) {
            self::init();
        }
        if (isset($_SESSION[$clave])) {
            return \Framework\App\Conexao::anti_injection($_SESSION[$clave]);
        }
        return false;
    }
}
?>
