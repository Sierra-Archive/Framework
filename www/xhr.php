<?php
 
    define('TEMPO_COMECO', microtime(true));
    define('TEMPO_IMPRIMIR', false);
    define('DS', DIRECTORY_SEPARATOR);
    define('US', '/'); // Divisor de URL
    define('ROOT_PADRAO'    , realpath(dirname(__FILE__)). DS);
    define('APP_PATH', ROOT_PADRAO.'App'.DS);
    define("SIS_PHPVERSION" , phpversion());
    define("APP_DATA"       , date("Y-m-d"));
    define("APP_HORA"       , date("Y-m-d H:i:s"));
    define("APP_DATA_BR"    , date("d/m/Y"));
    define("APP_HORA_BR"    , date("d/m/Y H:i:s"));
    require_once APP_PATH . 'AutoLoad.php';
    
        $registro = &\Framework\App\Registro::getInstacia();
        $registro->_Cache   = new \Framework\App\Cache(CACHE_PATH);
        \Framework\App\Session::init();
        $registro->_Conexao = new \Framework\App\Conexao();
/*
 * DataTables example server-side processing script.
 *
 * Please note that this script is intentionally extremely simply to show how
 * server-side processing can be implemented, and probably shouldn't be used as
 * the basis for a large complex system. It is suitable for simple use cases as
 * for learning.
 *
 * See http://datatables.net/usage/server-side for full details on the server-
 * side processing requirements of DataTables.
 *
 * @license MIT - http://datatables.net/license_mit
 */
 
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Easy set variables
 */
 
// DB table to use
$table = MYSQL_COMERCIO_FORNECEDOR_MATERIAL;
 
// Table's primary key
$primaryKey = 'id';
 
// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
    array( 'db' => 'data', 'dt' => 0 ),
    array( 'db' => 'documento',  'dt' => 1 ),
    array( 'db' => 'fornecedor',   'dt' => 2 ),
    array( 'db' => 'data',     'dt' => 3 ),
    array( 'db' => 'valor',     'dt' => 4 ),
    array( 'db' => 'valor',     'dt' => 5 )
    /*array(
        'db'        => 'start_date',
        'dt'        => 4,
        'formatter' => function( $d, $row ) {
            return date( 'jS M y', strtotime($d));
        }
    ),
    array(
        'db'        => 'salary',
        'dt'        => 5,
        'formatter' => function( $d, $row ) {
            return '$'.number_format($d);
        }
    )*/
);
 
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */
 
require( 'Classes/Datatable/Datatable.php' );
 
echo json_encode(
    \Framework\Classes\Datatable::complex( $_GET, $registro->_Conexao, $table, $primaryKey, $columns )
);