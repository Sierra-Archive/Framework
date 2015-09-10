<?php
error_reporting(-1);

define('DS',DIRECTORY_SEPARATOR);
define('US', '/'); // Divisor de URL
define('ROOT_PADRAO'    , str_replace('test'.DS, 'www'.DS, realpath(dirname(__FILE__)). DS));
define('APP_PATH', ROOT_PADRAO.'App'.DS);
define("SIS_PHPVERSION" , phpversion());
define("APP_DATA"       , date("Y-m-d"));
define("APP_HORA"       , date("Y-m-d H:i:s"));
define("APP_DATA_BR"    , date("d/m/Y"));
define("APP_HORA_BR"    , date("d/m/Y H:i:s"));

include_once('AutoLoader.php');
// Register the directory to your include files
AutoLoader::registerDirectory('../www');