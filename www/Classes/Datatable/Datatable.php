<?php
namespace Framework\Classes;
class Datatable {
    /**
    * Create the data output array for the DataTables rows
    *
    * @param array $columns Column information array
    * @param array $data Data from the SQL get
    * @return array Formatted data in a row based format
    */
    static function data_output ( $columns, $data )
    {
        $out = array();
        for ( $i=0, $ien=count($data) ; $i<$ien ; $i++ ) {
            $row = array();
            for ( $j=0, $jen=count($columns) ; $j<$jen ; $j++ ) {
                $column = $columns[$j];
                // Is there a formatter?
                if ( isset( $column['formatter'] ) ) {
                    $row[ $column['dt'] ] = $column['formatter']( $data[$i][ $column['db'] ], $data[$i] );
                }
                else {
                    $row[ $column['dt'] ] = $data[$i][ $columns[$j]['db'] ];
                }
            }
            $out[] = $row;
        }
        return $out;
    }
    /**
    * Database connection
    *
    * Obtain an PHP \PDO connection from a connection details array
    *
    * @param array $conn SQL connection details. The array should have
    * the following properties
    * * host - host name
    * * db - database name
    * * user - user name
    * * pass - user password
    * @return resource \PDO connection
    */
    static function db ( $conn )
    {
    if ( is_array( $conn ) ) {
    return self::sql_connect( $conn );
    }
    return $conn;
    }
    /**
    * Paging
    *
    * Construct the LIMIT clause for server-side processing SQL query
    *
    * @param array $request Data sent to server by DataTables
    * @param array $columns Column information array
    * @return string SQL limit clause
    */
    static function limit ( $request, $columns )
    {
    $limit = '';
    if ( isset($request['start']) && $request['length'] != -1 ) {
    $limit = "LIMIT ".intval($request['start']).", ".intval($request['length']);
    }
    return $limit;
    }
    /**
    * Ordering
    *
    * Construct the ORDER BY clause for server-side processing SQL query
    *
    * @param array $request Data sent to server by DataTables
    * @param array $columns Column information array
    * @return string SQL order by clause
    */
    static function order ( $request, $columns )
    {
        $cookie_ordenar = '';
        
        $order = '';
        if ( isset($request['order']) && count($request['order']) ) {
            $orderBy = array();
            $dtColumns = self::pluck( $columns, 'dt' );
            for ( $i=0, $ien=count($request['order']) ; $i<$ien ; $i++ ) {
                // Convert the column index into the column data property
                $columnIdx = intval($request['order'][$i]['column']);
                $requestColumn = $request['columns'][$columnIdx];
                $columnIdx = array_search( $requestColumn['data'], $dtColumns );
                $column = $columns[ $columnIdx ];
                if ( $requestColumn['orderable'] == 'true' ) {
                    $dir = $request['order'][$i]['dir'] === 'asc' ?
                    'ASC' :
                    'DESC';
                    $orderBy[] = '`'.$column['db'].'` '.$dir;
                }
                if($cookie_ordenar!=='') $cookie_ordenar .= ',';
                $cookie_ordenar .= '['.$columnIdx.',\''.$request['order'][$i]['dir'].'\']';
            }
            // Grava Cookie
            $url = filter_input(INPUT_GET, 'url', FILTER_SANITIZE_URL);
            \setcookie('TabelaOrdenar_'.$url, $cookie_ordenar, (time() + (70 * 24 * 3600)));
            //print_r($_COOKIE);

            $order = 'ORDER BY '.implode(', ', $orderBy);
        }
        return $order;
    }
    /**
    * Searching / Filtering
    *
    * Construct the WHERE clause for server-side processing SQL query.
    *
    * NOTE this does not match the built-in DataTables filtering which does it
    * word by word on any field. It's possible to do here performance on large
    * databases would be very poor
    *
    * @param array $request Data sent to server by DataTables
    * @param array $columns Column information array
    * sql_exec() function
    * @return string SQL where clause
    */
    static function filter ( $request, $columns, &$bindings, $class='' )
    {
        $globalSearch = array();
        $columnSearch = array();
        $dtColumns = self::pluck( $columns, 'dt' );
        
        $objeto = false;
        if($class!==''){
            $objeto = new $class();
        }
        
        if ( isset($request['search']) && $request['search']['value'] != '' ) {
            $str = $request['search']['value'];
            for ( $i=0, $ien=count($request['columns']) ; $i<$ien ; $i++ ) {
                $requestColumn = $request['columns'][$i];
                $columnIdx = array_search( $requestColumn['data'], $dtColumns );
                $column = $columns[ $columnIdx ];
                $column_db = $column["db"];
                if ( $requestColumn['searchable'] == 'true' ) {
                    if($objeto!==false) {
                        $str_temp = $objeto->bd_set($column_db,$str);
                    }else{
                        $str_temp = $str;
                    }
                    //var_dump( $column_db, $str, $str_temp);
                    $binding = self::bind( $bindings, '%'.$str_temp.'%', 's' );
                    $globalSearch[] = "`".$column['db']."` LIKE ".$binding;
                }
            }
        }
        // Individual column filtering
        for ( $i=0, $ien=count($request['columns']) ; $i<$ien ; $i++ ) {
            $requestColumn = $request['columns'][$i];
            $columnIdx = array_search( $requestColumn['data'], $dtColumns );
            $column = $columns[ $columnIdx ];
            $column_db = $column["db"];
            $str = $requestColumn['search']['value'];
            if ( $requestColumn['searchable'] == 'true' &&
            $str != '' ) {
                if($objeto!==false) {
                    $str_temp = $objeto->bd_set($column_db,$str);
                }else{
                    $str_temp = $str;
                }
                //var_dump( $column_db, $str, $str_temp);
                $binding = self::bind( $bindings, '%'.$str_temp.'%', 's' );
                $columnSearch[] = "`".$column['db']."` LIKE ".$binding;
            }
        }
        // Combine the filters into a single string
        $where = '';
        if ( count( $globalSearch ) ) {
            $where = '('.implode(' OR ', $globalSearch).')';
        }
        if ( count( $columnSearch ) ) {
            $where = $where === '' ?
            implode(' AND ', $columnSearch) :
            $where .' AND '. implode(' AND ', $columnSearch);
        }
        if ( $where !== '' ) {
            $where = 'WHERE '.$where;
        }
        return $where;
    }
    /**
    * Perform the SQL queries needed for an server-side processing requested,
    * utilising the helper functions of this class, limit(), order() and
    * filter() among others. The returned array is ready to be encoded as JSON
    * in response to an Datatable request, or can be modified if needed before
    * sending back to the client.
    *
    * @param array $request Data sent to server by DataTables
    * @param array|\PDO $conn \PDO connection resource or connection parameters array
    * @param string $table SQL table to query
    * @param string $primaryKey Primary key of the table
    * @param array $columns Column information array
    * @return array Server-side processing response array
    */
    static function simple ( $request, $conn, $table, $primaryKey, $columns )
    {
    $bindings = array();
    $db = self::db( $conn );
    // Build the SQL query string from the request
    $limit = self::limit( $request, $columns );
    $order = self::order( $request, $columns );
    $where = self::filter( $request, $columns, $bindings );
    
    // Main query to actually get the data
    $data = self::sql_exec( $db, $bindings,
    "SELECT SQL_CALC_FOUND_ROWS `".implode("`, `", self::pluck($columns, 'db'))."`
    FROM `$table`
    $where
    $order
    $limit"
    );
    // Data set length after filtering
    $resFilterLength = self::sql_exec( $db,
    "SELECT FOUND_ROWS()"
    );
    $recordsFiltered = $resFilterLength[0][0];
    // Total data set length
    $resTotalLength = self::sql_exec( $db,
    "SELECT COUNT(`{$primaryKey}`)
    FROM `$table`"
    );
    $recordsTotal = $resTotalLength[0][0];
    /*
    * Output
    */
    return array(
    "draw" => intval( $request['draw'] ),
    "recordsTotal" => intval( $recordsTotal ),
    "recordsFiltered" => intval( $recordsFiltered ),
    "data" => self::data_output( $columns, $data )
    );
    }
    /**
    * The difference between this method and the `simple` one, is that you can
    * apply additional `where` conditions to the SQL queries. These can be in
    * one of two forms:
    *
    * * 'Result condition' - This is applied to the result set, but not the
    * overall paging information query - i.e. it will not effect the number
    * of records that a user sees they can have access to. This should be
    * used when you want apply a filtering condition that the user has sent.
    * * 'All condition' - This is applied to all queries that are made and
    * reduces the number of records that the user can access. This should be
    * used in conditions where you don't want the user to ever have access to
    * particular records (for example, restricting by a login id).
    *
    * @param array $request Data sent to server by DataTables
    * @param array|\PDO $conn \PDO connection resource or connection parameters array
    * @param string $table SQL table to query
    * @param string $primaryKey Primary key of the table
    * @param array $columns Column information array
    * @param string $whereResult WHERE condition to apply to the result set
    * @param string $whereAll WHERE condition to apply to all queries
    * @return array Server-side processing response array
    */
    static function complex ( $request, $conn, $table_class, $primaryKey, $columns, $whereResult=null, $whereAll=null )
    {
        if($whereAll==null) $whereAll = 'servidor=\''.\SRV_NAME_SQL.'\' AND deletado=\'0\'';
        else $whereAll .= ' AND servidor=\''.\SRV_NAME_SQL.'\' AND deletado=\'0\'';
        $db = self::db( $conn );
        $bindings = array();
        $localWhereResult = array();
        $localWhereAll = array();
        
        $table_class = $table_class.'_DAO';      
        $table = \Framework\App\Conexao::$tabelas[$table_class]['nome'];
        $colunas = \Framework\App\Conexao::$tabelas[$table_class]['colunas'];

        // Build the SQL query string from the request
        $limit = self::limit( $request, $columns );
        $order = self::order( $request, $columns );
        $where = self::filter( $request, $columns, $bindings, $table_class );
        $whereResult = self::_flatten( $whereResult );
        $whereAll = self::_flatten( $whereAll );

        if ( $whereResult ) {
            $where = $where ?
            $where .' AND '.$whereResult :
            'WHERE '.$whereResult;
        }
        if ( $whereAll ) {
            $where = $where ?
            $where .' AND '.$whereAll :
            'WHERE '.$whereAll;
            $whereAllSql = 'WHERE '.$whereAll;
        }else{
            $whereAllSql = '';
        }
        // Main query to actually get the data
        $data = self::sql_exec( $db, $bindings,
            "SELECT SQL_CALC_FOUND_ROWS `".implode("`, `", self::pluck($columns, 'db'))."`
            FROM `$table`
            $where
            $order
            $limit",
            $colunas,
            $table_class
        );
        // Data set length after filtering
        $resFilterLength = self::sql_exec( $db,
            "SELECT FOUND_ROWS()"
        );
        $recordsFiltered = $resFilterLength[0]['FOUND_ROWS()'];
        // Total data set length
        $resTotalLength = self::sql_exec( $db,
            "SELECT COUNT(`{$primaryKey}`)
            FROM `$table` ".
            $whereAllSql
        );
        $recordsTotal = $resTotalLength[0]["COUNT(`{$primaryKey}`)"];
        /*
        * Output
        */
        return array(
            "draw" => intval( $request['draw'] ),
            "recordsTotal" => intval( $recordsTotal ),
            "recordsFiltered" => intval( $recordsFiltered ),
            "data" => self::data_output( $columns, $data )
        );
    }
    /**
    * Connect to the database
    *
    * @param array $sql_details SQL server connection details array, with the
    * properties:
    * * host - host name
    * * db - database name
    * * user - user name
    * * pass - user password
    * @return resource Database connection handle
    */
    static function sql_connect ( $sql_details )
    {
    try {
    $db = @new \PDO(
    "mysql:host={$sql_details['host']};dbname={$sql_details['db']}",
    $sql_details['user'],
    $sql_details['pass'],
    array( \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION )
    );
    }
    catch (\PDOException $e) {
    self::fatal(
    "An error occurred while connecting to the database. ".
    "The error reported by the server was: ".$e->getMessage()
    );
    }
    return $db;
    }
    /**
    * Execute an SQL query on the database
    *
    * @param resource $db Database handler
    * @param array $bindings Array of \PDO binding values from bind() to be
    * used for safely escaping strings. Note that this can be given as the
    * SQL query string if no bindings are required.
    * @param string $sql SQL query to execute.
    * @return array Result from the query (all rows)
    */
    static function sql_exec ( $db, $bindings, $sql=null, $colunas = Array(), $class = '' )
    {
        // Argument shifting
        if ( $sql === null ) {
            $sql = $bindings;
        }
        $stmt = $db->prepare( $sql );
        if($stmt===false) exit;
        //echo $sql;
        // Bind parameters
        if ( is_array( $bindings ) && !empty($bindings) ) {
            $tipo = '';
            $val = '';
            for ( $i=0, $ien=count($bindings) ; $i<$ien ; $i++ ) {
                $tipo = $tipo.$bindings[$i]['type'];
                if($val!=='') $val = $val.',';
                $val = $val.'$bindings['.$i.'][\'val\']';
            }
            eval('$stmt->bind_param( $tipo, '.$val.');');
        }
        // Execute
        try {
            $stmt->execute();
        }
        catch (\mysqli_sql_exception $e) {
            self::fatal( "An SQL error occurred: ".$e->getMessage() );
        }
        // Return all
        //var_dump($stmt); exit;
        $res = $stmt->get_result();
        $resu = Array();
        while($row = $res->fetch_array(MYSQLI_ASSOC)) {
            /*;
            $class = new $class;
            foreach($colunas as $valor){
                if(isset($row[$valor["mysql_titulo"]]) && isset($valor["mysql_outside"]) && $valor["mysql_outside"]!==false){
                    $row[$valor["mysql_titulo"] = $valor["mysql_outside"];
                }
            }*/
            
            if($class!==''){
                $objeto = new $class();
                foreach($row as $indice=>$valor){
                    if($valor==='' || $valor===NULL) continue;
                    $objeto->bd_get($indice,$valor);
                    $row[$indice] = $objeto->$indice;
                }
            }
            $resu[] = $row;
        }
        return $resu;
    }
    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
    * Internal methods
    */
    /**
    * Throw a fatal error.
    *
    * This writes out an error message in a JSON string which DataTables will
    * see and show to the user in the browser.
    *
    * @param string $msg Message to send to the client
    */
    static function fatal ( $msg )
    {
    echo json_encode( array(
    "error" => $msg
    ) );
    exit(0);
    }
    /**
    * Create a \PDO binding key which can be used for escaping variables safely
    * when executing a query with sql_exec()
    *
    * @param array &$a Array of bindings
    * @param * $val Value to bind
    * @param int $type \PDO field type
    * @return string Bound key to be used in the SQL where this parameter
    * would be used.
    */
    static function bind ( &$a, $val, $type )
    {
        $key = '?';
        $a[] = array(
        'key' => $key,
        'val' => \anti_injection($val),
        'type' => $type
        );
        return $key;
    }
    /**
    * Pull a particular property from each assoc. array in a numeric array,
    * returning and array of the property values from each item.
    *
    * @param array $a Array to get data from
    * @param string $prop Property to read
    * @return array Array of property values
    */
    static function pluck ( $a, $prop )
    {
    $out = array();
    for ( $i=0, $len=count($a) ; $i<$len ; $i++ ) {
    $out[] = $a[$i][$prop];
    }
    return $out;
    }
    /**
    * Return a string from an array or a string
    *
    * @param array|string $a Array to join
    * @param string $join Glue for the concatenation
    * @return string Joined string
    */
    static function _flatten ( $a, $join = ' AND ' )
    {
    if ( ! $a ) {
    return '';
    }
    else if ( $a && is_array($a) ) {
    return implode( $join, $a );
    }
    return $a;
    }
}
?>