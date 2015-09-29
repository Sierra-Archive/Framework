<?php  
$tempo = new \Framework\App\Tempo('AutoLoad');
// SISTEMA CONFIG
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
 * @version 0.4.2
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
if(isset($_SERVER['SERVER_NAME'])){
    define('SRV_NAME', \Framework\App\Sistema_Funcoes::Url_Limpeza($_SERVER['SERVER_NAME']));
}else{
    define('SRV_NAME', 'localhost');
}
// CArrega Config
if(
        file_exists(INI_PATH_TEMP.SRV_NAME.'/config.php') &&
        file_exists(INI_PATH_TEMP.SRV_NAME.'/config_modulos.php')
  ){
    require_once (INI_PATH_TEMP.SRV_NAME.'/config.php');
    require_once (INI_PATH_TEMP.SRV_NAME.'/config_modulos.php');
    
    require_once (INI_PATH_TEMP.'config.php');
}else{
    require_once (INI_PATH_TEMP.'config.php');
    throw new \Exception('Config não encontrado', 2828); //
}
// SISTEMA CONFIG
/**
 * Endereço de Pasta de Configurações no Servidor
 */
define('INI_PATH'       , ROOT      .'Ini'      .DS);
/**
 * Endereço de Pasta de Classes no Servidor
 */
define('CLASS_PATH'     , ROOT      .'Classes'  .DS);
/**
 * Endereço de Pasta de Interfaces no Servidor
 */
define('INTER_PATH'     , ROOT      .'Interface'.DS);
/**
 * Endereço de Pasta de Modulos no Servidor
 */
define('MOD_PATH'       , ROOT      .'mod'      .DS);



/**
 * Trata Erro de Notice - Pega o Erro do Sistema e os Trata como Excessoes
 * 
 * @param type $error
 * @param type $message
 * @param type $_1
 * @param type $_2
 * @return boolean
 * @throws \Exception
 * 
 * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
 * @version 0.4.2
 */
function Erro_Get_Leve($error, $message,$_1,$_2)
{
    //echo var_dump($message.'<br>Arquivo: '.$_1.'<br>Linha:'.$_2,3100);
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
/**
 * Trata Erros Fatais - Pega o Erro do Sistema e os Trata como Excessoes
 * 
 * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
 * @version 0.4.2
 */
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
/**
 * Formata Um Erro para Envia*lo por Email
 * 
 * @param type $errno
 * @param type $errstr
 * @param type $errfile
 * @param type $errline
 * @param type $previ
 * @param type $trace
 * @return string
 * 
 * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
 * @version 0.4.2
 */
function Erro_Formatar( $errno, $errstr, $errfile, $errline, $previ = '', $trace = false) {
    require_once APP_PATH . 'Funcao'.'.php';
    if($trace===false) $trace = debug_backtrace( false );
    
    
    if(isset($_GET['url'])){
        $url = \Framework\App\Conexao::anti_injection($_GET['url']);
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
    $content .= '<tr valign=\'top\'><td><b>Logado</b></td><td><pre>'.\Framework\App\Session::get(SESSION_ADMIN_LOG).'</pre></td></tr>';
    $content .= '<tr valign=\'top\'><td><b>Url</b></td><td><pre>'.\Framework\App\Conexao::anti_injection($url).'</pre></td></tr>';
    $content .= '<tr valign=\'top\'><td><b>POST</b></td><td><pre>'.htmlspecialchars(print_r($_POST,true)).'</pre></td></tr>';
    $content .= '</tbody></table>';
    
    
    if(is_array($trace)){
        $content .= '<h2>Traço</h2>';
        $content  = '<table><thead bgcolor=\'#c8c8c8\'><th>Arquivo/Linha</th><th>Função</th><th>Argumentos</th></thead><tbody>';
        while(!empty($trace)){
            $linha = array_pop($trace);
            $content .= '<tr valign=\'top\'><td><b>'.$linha['file'].':'.$linha['line'].'</b></td>'.
                    '<td><pre>'.$linha['function'].'</pre></td>';
            
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
/**
 * Envia um Erro por Email
 * 
 * @param type $errno
 * @param type $errstr
 * @param type $errfile
 * @param type $errline
 * 
 * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
 * @version 0.4.2
 */
function Erro_Email($errno, $errstr, $errfile, $errline){
    $mensagem = Erro_Formatar( $errno, $errstr, $errfile, $errline);
    
    // Verifica Existencia das Constantes
    if(!defined('CLASS_PATH')){
        if(!defined('ROOT')){
            define('ROOT', ROOT_PADRAO);
        } 
        define('CLASS_PATH', ROOT      .'Classes'  .DS);
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














/**
 * Carrega Config de Maniputação de Layoult
 */
define('LAY_CONF', ROOT_PADRAO.'templates'.DS.TEMA_PADRAO.DS.'config'.DS);
if( file_exists  (LAY_CONF.'config.php')){
    require_once (LAY_CONF.'config.php');
}else{
    throw new \Exception('Config do Layoult não Encontrado', 404);
}


/**
 * URL DO SISTEMA
 */
define('URL_PATH',          SISTEMA_URL.SISTEMA_DIR);
/**
 * Endereço da Pasta Web para o Cliente
 */
define('WEB_URL',           URL_PATH.'static'.US);
/**
 * Endereço de Pasta Web no Servidor
 */
define('WEB_PATH',          ROOT.'static'.US);
/**
 * Endereço da Bibliotecas Web para o Cliente
 */
define('LIBS_URL',          URL_PATH.'libs'.US);
/**
 * Endereço de Pasta de Bibliotecas no Servidor
 */
define('LIBS_PATH',         ROOT.'libs'.DS);
/**
 * Endereço de Pasta de Arquivos desse Servidor para o Cliente
 */
define('ARQ_URL',           URL_PATH.'media'.US.SRV_NAME_SQL.US);
/**
 * Endereço de Pasta de Arquivos desse Servidor no Servidor
 */
define('ARQ_PATH',          ROOT.'media'.DS.SRV_NAME_SQL.DS);
/**
 * Endereço de Pasta de Cache desse Servidor no Servidor
 */
define('CACHE_PATH',        ROOT.'Cache'.DS.SRV_NAME_SQL.DS);
/**
 * Endereço de Pasta de Idiomas no Servidor
 */
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
if(!is_dir(ROOT.'media'.DS)){
    mkdir (ROOT.'media'.DS, 0777 );
}
if(!is_dir(ROOT.'Temp'.DS)){
    mkdir (ROOT.'Temp'.DS, 0777 );
}
//chmod (URL_PATH.'media'.DS, 0777 );
// Permissao de Pasta do Servidor
if(!is_dir(ARQ_PATH)){
    mkdir (ARQ_PATH, 0777 );
}
if(!is_dir(CACHE_PATH)){
    mkdir (CACHE_PATH, 0777 );
}
if(!is_dir(TEMP_PATH)){
    mkdir (TEMP_PATH, 0777 );
}



/**
 * Linguagem e Pacote de Funcoes
 */
require_once    APP_PATH . 'Funcao.php';
/**
 * URL DO SERVIDOR
 */
if(isset($_SERVER['REQUEST_URI'])){
    define('SERVER_URL',           $_SERVER['REQUEST_URI']);
}else{
    define('SERVER_URL',           'localhost');
}

// SE TIVER CONFIGURACAO GERADA PELO FRAMEWORK ABRE
if(file_exists(INI_PATH.SRV_NAME.DS.'_temp.php')){
    require_once(INI_PATH.SRV_NAME.DS.'_temp.php');
}




unset($tempo);


/**
 * Carrega Funções de Internaciolização
 */
$textdomain = "Framework";
if (isset($_GET['locale']) && !empty($_GET['locale'])){
    $locale = \Framework\App\Conexao::anti_injection($_GET['locale']);
}else{
    $locale = SISTEMA_LINGUAGEM_PADRAO;
}

// Faz Tratamento
if(strlen($locale)==4){
    $locale = $locale[0].$locale[1].'_'.$locale[2].$locale[3];
}
//Verifica Se os Arquivos Existem
if(!is_file(LANG_PATH.$locale.DS.'Linguagem.js')){
    throw new \Exception('Javascript da Linguagem não Encontrado: '.$locale,404);
}

// Carrega Internacionalização I18N
define('SISTEMA_LINGUAGEM', $locale);
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
 * @version 0.4.2
 */
function _e($string) {
  echo __($string);
}







/*
$tempo = new \Framework\App\Tempo('Teeste1');
$i = 0;
$config = Array();
while($i<1000){
    $config_Modulo = function (){
        return Array(
            'Nome'                      => __('Agenda'),
            'Descrição'                 =>  '',
            'System_Require'            =>  '3.1.0',
            'Version'                   =>  '3.1.1',
            'Dependencias'              =>  false,
        );
    };
    ++$i;
    $config    = array_merge_recursive($config,$config_Modulo()   );
}
unset($tempo);

$tempo = new \Framework\App\Tempo('Teeste2');
$i = 0;
$config = Array();
while($i<1000){
    $config_Modulo = Array(
        'Nome'                      => __('Agenda'),
        'Descrição'                 =>  '',
        'System_Require'            =>  '3.1.0',
        'Version'                   =>  '3.1.1',
        'Dependencias'              =>  false,
    );
    ++$i;
    $config    = array_merge_recursive($config,$config_Modulo   );
}
unset($tempo);

$tempo = new \Framework\App\Tempo('Teeste3');
$i = 0;
$config = Array();
while($i<1000){
    $config['Nome']= __('Agenda');
    $config['Descrição']                 =  '';
     $config['System_Require']            =  '3.1.0';
     $config['Version']                   =  '3.1.1';
    $config['Dependencias']              =  false;
    ++$i;
}
unset($tempo);*/
?>
