<?php  
/**
 *  SISTEMA DE AUTO LOAD
 * @param type $class
 */
// SISTEMA CONFIG
define('INI_PATH_TEMP'  , ROOT_PADRAO      .'Ini'      .DS);
define('DAO_PATH'       , ROOT_PADRAO.'DAO'.DS);

// AUTOLOAD
function __autoload($class){
    $original = $class;
    
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
            throw new \Exception('Classe não encontrada'.CLASS_PATH . $class.DS.$class.'.php'.$class, 2802);
        }
    }
    
    // Carrega Dao
    if(strpos($class, '_DAO')!==false){
        $class = str_replace(Array('_'), Array('.'), $class);
        if( file_exists  (DAO_PATH . $class.'.php')){
            require_once (DAO_PATH . $class.'.php');
        }else{
            throw new \Exception('Classe Dao não encontrada'.$class, 2802);
            return true;
        }
    }
    
    // Principal
    if(substr($class, -10)==='_Principal'){
        $class = str_replace('_Principal', '', $class);
        if( file_exists  (MOD_PATH.$class.DS.'_Principal.Class.php')){
            require_once(MOD_PATH.$class.DS.'_Principal.Class.php');
            return true;
        }else{
            throw new \Exception('Classe Principal não encontrada: '.$class, 2802);
        }
    }

    // Interface
    if(strpos($class, 'Interface')!==false){
        $class = str_replace(Array('Interface'), Array(''), $class);
        if( file_exists  (INTER_PATH.$class.'.Interface.php')){
            require_once (INTER_PATH.$class.'.Interface.php');
            return true;
        }else{
            throw new \Exception('Interface não encontrada'.$class, 2802);
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
        throw new \Exception('Classe Modulo não encontrada'.$class, 2802);
    }*/
    if($submodulo!=''){
        if( file_exists  (MOD_PATH . $modulo.DS.$modulo.'_'.$submodulo.$tipo[0].'.php')){
            require_once (MOD_PATH . $modulo.DS.$modulo.'_'.$submodulo.$tipo[0].'.php');
        }else{
            throw new \Exception('Classe Submodulo não encontrada: '.MOD_PATH . $modulo.DS.$modulo.'_'.$submodulo.$tipo[0].'.php', 2802);
        }
    }
}

// Carrega Autoloads
spl_autoload_register('__autoload'      );




// Continua Configurações
define('SRV_NAME', \Framework\App\Sistema_Funcoes::Url_Limpeza($_SERVER['SERVER_NAME']));
// CArrega Config
if(
        file_exists(INI_PATH_TEMP.SRV_NAME.'/config.php') &&
        file_exists(INI_PATH_TEMP.SRV_NAME.'/config_modulos.php')
  ){
    require_once (INI_PATH_TEMP.SRV_NAME.'/config.php');
    require_once (INI_PATH_TEMP.SRV_NAME.'/config_modulos.php');
}else{
    
    // SISTEMA CONFIG
    define('INI_PATH'       , ROOT_PADRAO      .'Ini'      .DS);
    define('LIB_PATH'       , ROOT_PADRAO      .'libs'     .DS);
    define('CLASS_PATH'     , ROOT_PADRAO      .'Classes'  .DS);
    define('INTER_PATH'     , ROOT_PADRAO      .'Interface'.DS);
    define('MOD_PATH'       , ROOT_PADRAO      .'mod'      .DS);
    throw new \Exception('Config não encontrado', 2828); //
}
require_once (INI_PATH_TEMP.'config.php');

    
// SISTEMA CONFIG
define('INI_PATH'       , ROOT      .'Ini'      .DS);
define('LIB_PATH'       , ROOT      .'libs'     .DS);
define('CLASS_PATH'     , ROOT      .'Classes'  .DS);
define('INTER_PATH'     , ROOT      .'Interface'.DS);
define('MOD_PATH'       , ROOT      .'mod'      .DS);

/***********************************************************
 * CONTROLE DE ERROS
 */



// Fuder tudo com Variavies nao inicializadas, afim de nao deixar ter perda de performace
function Erro_Get_Leve($error, $message,$_1,$_2)
{
    echo var_dump($message.'<br>Arquivo: '.$_1.'<br>Linha:'.$_2,3100);
    if(SISTEMA_DEBUG===true){
        if($error == 8)
        {
            throw new \Exception($message.'<br>Arquivo: '.$_1.'<br>Linha:'.$_2,3100);
            //trigger_error($message.'<br>Arquivo: '.$_1.'<br>Linha: '.$_2, E_USER_ERROR);
        }else{
            throw new \Exception($message.'<br>Erro:'.$error.'<br>Arquivo: '.$_1.'<br>Linha:'.$_2,3100);
        }
    }else{
        // Enviar Email de Erro
        Erro_Email( $error, $message, $_1, $_2);
    }

    return false;
}

function Erro_Get_Fatal() {
    if(SISTEMA_DEBUG!==true){
        $errfile = "unknown file";
        $errstr  = "shutdown";
        $errno   = E_CORE_ERROR;
        $errline = 0;
        $error = error_get_last();
        if( $error !== NULL) {
            $errno   = $error["type"];
            $errfile = $error["file"];
            $errline = $error["line"];
            $errstr  = $error["message"];
            // Enviar Email
            Erro_Email($errno, $errstr, $errfile, $errline);
        }
    }
}
function Erro_Formatar( $errno, $errstr, $errfile, $errline, $previ = '', $trace = false) {
    require_once APP_PATH . 'Funcao'.'.php';
    if($trace===false) $trace = debug_backtrace( false );
    
    
    if(isset($_GET['url'])){
        $url = htmlspecialchars($_GET['url']);
    }else{
        $url = '';
    }

    $content  = '<table><thead bgcolor=\'#c8c8c8\'><th>Item</th><th>Descrição</th></thead><tbody>';
    $content .= '<tr valign=\'top\'><td><b>Error</b></td><td><pre>'.htmlspecialchars($errstr, ENT_QUOTES).'</pre></td></tr>';
    $content .= '<tr valign=\'top\'><td><b>Errno</b></td><td><pre>'.htmlspecialchars($errno, ENT_QUOTES).'</pre></td></tr>';
    $content .= '<tr valign=\'top\'><td><b>Arquivo</b></td><td>'.htmlspecialchars($errfile, ENT_QUOTES).'</td></tr>';
    $content .= '<tr valign=\'top\'><td><b>Linha</b></td><td>'.htmlspecialchars($errline, ENT_QUOTES).'</td></tr>';
    $content .= '<tr valign=\'top\'><td><b>Previa</b></td><td><pre>'.htmlspecialchars($previ, ENT_QUOTES).'</pre></td></tr>';
    $content .= '<tr valign=\'top\'><td><b>Extra</b></td><td><pre>-----------</pre></td></tr>';
    $content .= '<tr valign=\'top\'><td><b>Logado</b></td><td><pre>'.SESSION_ADMIN_LOG.'</pre></td></tr>';
    $content .= '<tr valign=\'top\'><td><b>Url</b></td><td><pre>'.htmlspecialchars($url).'</pre></td></tr>';
    $content .= '<tr valign=\'top\'><td><b>POST</b></td><td><pre>'.htmlspecialchars(print_r($_POST,true)).'</pre></td></tr>';
    $content .= '</tbody></table>';
    
    
    if(is_array($trace)){
        $content .= '<h2>Traço</h2>';
        $content .= '<table><thead bgcolor=\'#c8c8c8\'><th>Arquivo/Linha</th><th>Função</th><th>Argumentos</th></thead><tbody>';
        while(!empty($trace)){
            $linha = array_pop($trace);
            if(isset($linha['file'])){
                $file = $linha['file'];
            }else{
                $file = 'Nao Reconhecido';
            }
            if(isset($linha['line'])){
                $line = $linha['line'];
            }else{
                $line = 'Nao Reconhecido';
            }
            if(isset($linha['function'])){
                $function = $linha['function'];
            }else{
                $function = 'Nao Reconhecido';
            }
            $content .= '<tr valign=\'top\'><td><b>'.$file.':'.$line.'</b></td>'.
                    '<td><pre>'.$function.'</pre></td>';
            
            $content .= '<td>';
            $i = 1;
            foreach($linha['args'] as &$valor){
                if($i>1) $content .= '<br>';
                $content .= '<b>'.$i.':</b> '.htmlspecialchars(print_r($valor,true), ENT_QUOTES);
                ++$i;
            }
            $content .= '</td>';
            
            $content .= '</tr>';
        }
        $content .= '</tbody></table>';
    }
    

    return $content;
}
function Erro_Email($errno, $errstr, $errfile, $errline, $previos = '', $trace = false){
    $mensagem = Erro_Formatar( $errno, $errstr, $errfile, $errline, $previos, $trace);
    
    // Verifica Existencia das Constantes
    if (!defined('CLASS_PATH')) {
        if (!defined('ROOT')) {
            define('ROOT',  ROOT_PADRAO);
        } 
        define('CLASS_PATH',  ROOT      .'Classes'  .DS);
    }   
    
    // Carrega se Nao tiver carregado
    require_once CLASS_PATH . 'Email'.DS.'Email'.'.php';
    $mailer = new \Framework\Classes\Email();
    $send	= $mailer->setTo('sierra.csi@gmail.com', 'Ricardo Sierra')
                ->setSubject('Erro - '.$errno.' - '.SISTEMA_NOME)
                ->setFrom(SISTEMA_EMAIL, SISTEMA_NOME)
                ->addGenericHeader('X-Mailer', 'PHP/' . phpversion())
                ->addGenericHeader('Content-Type', 'text/html; charset="utf-8"')
                ->setMessage($mensagem)
                ->setWrap(78)->send();
}
set_error_handler("Erro_Get_Leve"); 
register_shutdown_function( "Erro_Get_Fatal" );
/***********************************************************
 * FIM DE CONTROLE DE ERROS
 */














// Carrega Config de Maniputação de Layoult
define('LAY_CONF', ROOT_PADRAO.'layoult'.DS.TEMA_PADRAO.DS.'config'.DS);
if( file_exists  (LAY_CONF.'config.php')){
    require_once (LAY_CONF.'config.php');
}else{
    throw new \Exception('Config do Layoult não Encontrado', 404);
}


// Mais Constantes para Manipulação do Sistema
define('URL_PATH',          SISTEMA_URL.SISTEMA_DIR);
define('WEB_URL',           URL_PATH.'web'.US);
define('WEB_PATH',          ROOT.'web'.US);
define('LIBS_URL',          URL_PATH.'libs'.US);
define('LIBS_PATH',         ROOT.'libs'.DS);
// Carrega Diretorios de Arquivos de acordo com o Servidor
define('ARQ_URL',           URL_PATH.'arq'.US.SRV_NAME_SQL.US);
define('ARQ_PATH',          ROOT.'arq'.DS.SRV_NAME_SQL.DS);
define('CACHE_PATH',        ROOT.'Cache'.DS.SRV_NAME_SQL.DS);
define('LANG_PATH',         ROOT.'i18n'.DS);

/**
 * Endereço de Pasta de Temnporarios no Servidor
 */
define('TEMP_PATH',         ROOT.'Temp'.DS.SRV_NAME_SQL.DS);
/**
 * Endereço de Pasta de Temnporarios para o Cliente
 */
define('TEMP_URL',          URL_PATH.'Temp'.US.SRV_NAME_SQL.US);
// Cria e da Permissao na Pasta de Arquivos principal
if(!is_dir(ROOT.'arq'.DS)){
    mkdir (ROOT.'arq'.DS, 0777 );
}
if(!is_dir(ROOT.'Cache'.DS)){
    mkdir (ROOT.'Cache'.DS, 0777 );
}
//chmod (URL_PATH.'arq'.DS, 0777 );
// Permissao de Pasta do Servidor
if(!is_dir(ARQ_PATH)){
    mkdir (ARQ_PATH, 0777 );
}
if(!is_dir(CACHE_PATH)){
    mkdir (CACHE_PATH, 0777 );
}

// Linguagem e Pacote de Funcoes
require_once    APP_PATH . 'Funcao.php';
  
define('SERVER_URL',           $_SERVER['REQUEST_URI']);



/**
 * Carrega Funções de Internaciolização
 */
$textdomain = "Framework";
if (isset($_GET['locale']) && !empty($_GET['locale'])){
    $locale = \anti_injection($_GET['locale']);
}else{
    $locale = SISTEMA_LINGUAGEM_PADRAO;
}

// Faz Tratamento
if (strlen($locale)==4) {
    $locale = $locale[0].$locale[1].'_'.$locale[2].$locale[3];
}
//Verifica Se os Arquivos Existem
if (!is_file(LANG_PATH.$locale.DS.'Linguagem.js')) {
    throw new \Exception('Javascript da Linguagem não Encontrado: '.$locale,404);
}

// Carrega Internacionalização I18N
define('SISTEMA_LINGUAGEM',  $locale);
putenv('LANGUAGE=' . SISTEMA_LINGUAGEM);
putenv('LANG=' . SISTEMA_LINGUAGEM);
putenv('LC_ALL=' . SISTEMA_LINGUAGEM);
putenv('LC_MESSAGES=' . SISTEMA_LINGUAGEM);
require_once(LIBS_PATH.'i18n'.DS.'gettext.inc');
_setlocale(LC_ALL, SISTEMA_LINGUAGEM);
_setlocale(LC_CTYPE, SISTEMA_LINGUAGEM);
_bindtextdomain($textdomain, LANG_PATH);
_bind_textdomain_codeset($textdomain, 'UTF-8');
_textdomain($textdomain);
/**
 * Além de Traduzir o Texto, ele da um Echo Automaticamente
 * 
 * @param string $string Texto a Ser Traduzido
 * 
 * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
 * @version 3.1.1
 */
function _e($string) {
  echo __($string);
}


?>
