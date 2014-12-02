<?php
namespace Framework\App;
final Class Session {
    private static $Iniciado = false;
    public static function init(){
        if(self::$Iniciado===true){
            return true;
        }
        self::$Iniciado = true;
        
        session_start();
    }
    public static function destroy($clave=false){
        if(self::$Iniciado!==true){
            self::init();
        }
        if($clave===false){
            session_destroy();
        }else{
            if(is_array($clave)){
                $clave_qnt = $count($clave);
                for($i=0; $i<$clave_qnt; ++$i){
                    if(isset($_SESSION[$clave[$i]])){
                        unset($_SESSION[$clave[$i]]);
                    }
                }
            }else{
                if(isset($_SESSION[$clave])){
                    unset($_SESSION[$clave]);
                }
            }
        }
    }
    public static function set($clave,$valor){
        if(self::$Iniciado!==true){
            self::init();
        }
        if(!empty($clave)){
            $_SESSION[$clave] = $valor;
        }
        return false;
    }
    public static function get($clave){
        if(self::$Iniciado!==true){
            self::init();
        }
        if(isset($_SESSION[$clave])){
            return \anti_injection($_SESSION[$clave]);
        }
        return false;
    }
}
?>
