<?php 
class AutoLoader {
 
    static private $classNames = array();
 
    /**
     * Store the filename (sans extension) & full path of all ".php" files found
     */
    public static function registerDirectory($dirName) {
 
        $di = new DirectoryIterator($dirName);
        foreach ($di as $file) {
 
            if ($file->isDir() && !$file->isLink() && !$file->isDot()) {
                // recurse into directories other than a few special ones
                self::registerDirectory($file->getPathname());
            } elseif (substr($file->getFilename(), -4) === '.php') {
                // save the class name / path of a .php file found
                $className = substr($file->getFilename(), 0, -4);
                AutoLoader::registerClass($className, $file->getPathname());
                var_dump($className, $file->getPathname());
            }
        }
    }
 
    public static function registerClass($className, $fileName) {
        AutoLoader::$classNames[$className] = $fileName;
    }
 
    public static function loadClass($className) {
        if (isset(AutoLoader::$classNames[$className])) {
            require_once(AutoLoader::$classNames[$className]);
        }
     }
 
}
 
spl_autoload_register(array('AutoLoader', 'loadClass'));

// O meu Particular

define('INI_PATH_TEMP'  , ROOT_PADRAO      .'Ini'      .DS);
define('DAO_PATH'       , ROOT_PADRAO.'DAO'.DS);
/**
 * AUTOLOAD
 * Da Include Automaticamente Dependendo da Classe que vai ser Executada
 * 
 * @param string $class Class a Ser Executada
 * @return boolean
 * @throws \Exception
 * 
 * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
 * @version 3.1.1
 */
function __autoload($class){
    $original = $class;
    
    // Carrega Dao
    if(strpos($class, '_DAO')!==false){
        $class = str_replace(Array('_'), Array('.'), $class);
        if( file_exists  (DAO_PATH . $class.'.php')){
            require_once (DAO_PATH . $class.'.php');
        }else{
            throw new \Exception('Classe Dao não encontrada'.$class."\n\n<br><Br>Original: ".$original, 2802);
            return true;
        }
    }
    
    // Se for Classe App
    if(strpos($class, 'Framework\App')!==false){
        $class_partes = explode('\\',$class);
        $class = $class_partes[sizeof($class_partes)-1];
        $class = ucfirst($class);
        if( file_exists  (APP_PATH . $class.'.php')){
            require_once (APP_PATH . $class.'.php');
            return true;
        }else{
            throw new \Exception('Classe Nativa do Framework não encontrada: '.$class."\n\n<br><Br>Original: ".$original, 2802);
        }
    }
    
    // Classes
    if(strpos($class, 'Framework\Classes')!==false){
        $class_partes = explode('\\',$class);
        $class = $class_partes[sizeof($class_partes)-1];
        $class = ucfirst($class);
        if( file_exists  (CLASS_PATH . $class.DS.$class.'.php')){
            require_once (CLASS_PATH . $class.DS.$class.'.php');
            return true;
        }else{
            throw new \Exception('Classe não encontrada'.CLASS_PATH . $class.DS.$class.'.php'.$class."\n\n<br><Br>Original: ".$original, 2802);
        }
    }
    
    // Principal
    if(substr($class, -10)==='_Principal'){
        $class = str_replace('_Principal', '', $class);
        if( file_exists  (MOD_PATH.$class.DS.'_Principal.Class.php')){
            require_once(MOD_PATH.$class.DS.'_Principal.Class.php');
            return true;
        }else{
            throw new \Exception('Classe Principal não encontrada: '.$class."\n\n<br><Br>Original: ".$original, 2802);
        }
    }

    // Interface
    if(strpos($class, 'Framework\\')!==false && strpos($class, 'Interface')!==false){
        $class = str_replace(Array('Framework\\'), Array(''), $class);
        $class = str_replace(Array('Interface'), Array(''), $class);
        if( file_exists  (INTER_PATH.$class.'.Interface.php')){
            require_once (INTER_PATH.$class.'.Interface.php');
            return true;
        }else{
            throw new \Exception('Interface não encontrada: '.$class."\n\n<br><Br>Original: ".$original, 2802);
        }
    }
    
    // Se nao passar por Nenhum dos de cima vai Pro Modulo
    // Modulos
    if(         substr($class, -8)=='Controle'){
        $tipo = 'Controle';
    }else if (  substr($class, -6)=='Modelo'){
        $tipo = 'Modelo';
    }else if (  substr($class, -6)=='Visual'){
        $tipo = 'Visual';
    }else{
        return false;
    }
    $class = explode('_',$class);
    $modulo = '';
    $class_qnt = count($class);
    $submodulo = $class[$class_qnt-1];
    for($i=0;$i<($class_qnt-1);++$i){
        if($i==0) $modulo .= $class[$i];
        else            $modulo .= '_'.$class[$i];
    }
    $contador = 0;
    if($modulo==''){
        // Invez de Substituir, tira só a ultima ocorrencia e sobra oq ta antes
        $modulo = str_replace(Array($tipo), Array(''), $submodulo, $contador);
        if($contador==2) $modulo = $tipo;
        $submodulo = '';
    }else{
        // Invez de Substituir, tira só a ultima ocorrencia e sobra oq ta antes
        $submodulo = str_replace(Array($tipo), Array(''), $submodulo, $contador);
        if($contador==2) $submodulo = $tipo;
    }
    // Verifica se Modulo é permitido
    
    // Carrega Modulo
    if( file_exists  (MOD_PATH . $modulo.DS.$modulo.'_'.$tipo.'.php')){
        if(!\Framework\App\Sistema_Funcoes::Perm_Modulos($modulo)){
            throw new \Exception('Modulo não permitido para este servidor (AutoLoad): '.$modulo,404);
        }
        require_once (MOD_PATH . $modulo.DS.$modulo.'_'.$tipo.'.php');
    }/*else{
        throw new \Exception('Classe Modulo não encontrada'.$class."\n\n<br><Br>Original: ".$original, 2802);
    }*/
    if($submodulo!=''){
        if( file_exists  (MOD_PATH . $modulo.DS.$modulo.'_'.$submodulo.$tipo[0].'.php')){
            require_once (MOD_PATH . $modulo.DS.$modulo.'_'.$submodulo.$tipo[0].'.php');
        }else if( file_exists  (MOD_PATH . $modulo.DS.$modulo.'_'.ucwords($submodulo).$tipo[0].'.php')){
            require_once (MOD_PATH . $modulo.DS.$modulo.'_'.ucwords($submodulo).$tipo[0].'.php');
        }else{
            throw new \Exception('Classe Submodulo não encontrada: '.MOD_PATH . $modulo.DS.$modulo.'_'.$submodulo.$tipo[0].'.php'."\n\n<br><Br>Original: ".$original, 2802);
        }
    }
    
    return false;
}

// Carrega Autoloads
spl_autoload_register('__autoload'      );







// Continua Configurações
//define('SRV_NAME', \Framework\App\Sistema_Funcoes::Url_Limpeza($_SERVER['SERVER_NAME']));
// SISTEMA CONFIG
/**
 * Endereço de Pasta de Configurações no Servidor
 */
define('INI_PATH'       , ROOT_PADRAO      .'Ini'      .DS);
/**
 * Endereço de Pasta de Classes no Servidor
 */
define('CLASS_PATH'     , ROOT_PADRAO      .'Classes'  .DS);
/**
 * Endereço de Pasta de Interfaces no Servidor
 */
define('INTER_PATH'     , ROOT_PADRAO      .'Interface'.DS);
/**
 * Endereço de Pasta de Modulos no Servidor
 */
define('MOD_PATH'       , ROOT_PADRAO      .'mod'      .DS);
?>