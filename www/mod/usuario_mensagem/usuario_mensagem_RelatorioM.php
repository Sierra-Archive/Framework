<?php

class usuario_mensagem_RelatorioModelo extends usuario_mensagem_Modelo
{
    /**
    * Construtor
    * 
    * @name __construct
    * @access public
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 0.4.2
    */
    public function __construct() {
      parent::__construct();
    }
    public function Aberto($datainicial, $datafinal) {
        // Table's primary key
        $primaryKey = 'id';
        $tabela = 'Usuario_Mensagem';
        $where = 'UM.finalizado<>1 AND UM.log_date_add BETWEEN \''.$datainicial.'\' AND \''.$datafinal.'\'';

        $columns = array(
            array( 'db' => 'id', 'dt' => 0,
                'formatter' => function( $d, $row ) {
                    return '#'.$d;
                }),
            array( 'db' => 'cliente2',      'dt' => 1 ),
            array( 'db' => 'assunto2',      'dt' => 2 ),
            array( 'db' => 'mensagem',      'dt' => 3 ,
                'formatter' => function( $d, $row ) {
                return str_replace ( array("\n", "\r", '<br />'), '', $d);
            }),
            array( 'db' => 'log_date_add',  'dt' => 4 ),
            array( 'db' => 'log_date_edit', 'dt' => 5 )/*,
            array( 'db' => 'id',            'dt' => 6,
                'formatter' => $funcao)*/
        );

        echo json_encode(
            \Framework\Classes\Datatable::complex( $_GET, Framework\App\Registro::getInstacia()->_Conexao, $tabela, $primaryKey, $columns, null,$where )
        );
    }
    public function Assunto($datainicial, $datafinal) {
        // Table's primary key
        $primaryKey = 'id';
        $tabela = 'Usuario_Mensagem';
        $where = 'UM.log_date_add BETWEEN \''.$datainicial.'\' AND \''.$datafinal.'\'';
        

        $columns = array(
            array( 'db' => 'id', 'dt' => 0,
                'formatter' => function( $d, $row ) {
                    return '#'.$d;
                }),
            array( 'db' => 'cliente2',      'dt' => 1 ),
            array( 'db' => 'assunto2',      'dt' => 2 ),
            array( 'db' => 'mensagem',      'dt' => 3 ,
                'formatter' => function( $d, $row ) {
                return str_replace ( array("\n", "\r", '<br />'), '', $d);
            }),
            array( 'db' => 'finalizado',    'dt' => 4 ,
                'formatter' => function( $d, $row ) {
                    if ($d=='1') {
                        return 'Finalizado';
                    } else {
                        return 'Novos Chamados';
                    }
                    return false;
                },
                'search' => function( $search ) {
                    if (strpos(strtolower('Finalizado'), strtolower($search))!=false) {
                        return '1';
                    } else if (strpos(strtolower('Novos Chamados'), strtolower($search))!=false) {
                        return '0';
                    }
                    return false;
                }),
            array( 'db' => 'log_date_add',  'dt' => 5 ),
            array( 'db' => 'log_date_edit', 'dt' => 6 )/*,
            array( 'db' => 'id',            'dt' => 7,
                'formatter' => $funcao)*/
        );

        echo json_encode(
            \Framework\Classes\Datatable::complex( $_GET, Framework\App\Registro::getInstacia()->_Conexao, $tabela, $primaryKey, $columns, null,$where )
        );
    }
    public function Esgotado($datainicial, $datafinal) {
        // Table's primary key
        $primaryKey = 'id';
        $tabela = 'Usuario_Mensagem';
        $where = 'DATEDIFF(CURDATE(), UM.log_date_add) > EXTA.tempocli AND UM.finalizado<>1 AND UM.log_date_add BETWEEN \''.$datainicial.'\' AND \''.$datafinal.'\'';
        
        

        $columns = array(
            array( 'db' => 'id', 'dt' => 0,
                'formatter' => function( $d, $row ) {
                    return '#'.$d;
                }),
            array( 'db' => 'cliente2',      'dt' => 1 ),
            array( 'db' => 'assunto2',      'dt' => 2 ),
            array( 'db' => 'mensagem',      'dt' => 3 ,
                'formatter' => function( $d, $row ) {
                return str_replace ( array("\n", "\r", '<br />'), '', $d);
            }),
            array( 'db' => 'log_date_add',  'dt' => 4 ),
            array( 'db' => 'log_date_edit', 'dt' => 5 )/*,
            array( 'db' => 'id',            'dt' => 6,
                'formatter' => $funcao)*/
        );

        echo json_encode(
            \Framework\Classes\Datatable::complex( $_GET, Framework\App\Registro::getInstacia()->_Conexao, $tabela, $primaryKey, $columns, null,$where )
        );
    }
    public function Finalizado($datainicial, $datafinal) {
        // Table's primary key
        $primaryKey = 'id';
        $tabela = 'Usuario_Mensagem';
        $where = 'UM.finalizado=1 AND UM.log_date_add BETWEEN \''.$datainicial.'\' AND \''.$datafinal.'\'';
        
        
        $columns = array(
            array( 'db' => 'id', 'dt' => 0,
                'formatter' => function( $d, $row ) {
                    return '#'.$d;
                }),
            array( 'db' => 'cliente2',      'dt' => 1 ),
            array( 'db' => 'assunto2',      'dt' => 2 ),
            array( 'db' => 'mensagem',      'dt' => 3 ,
                'formatter' => function( $d, $row ) {
                return str_replace ( array("\n", "\r", '<br />'), '', $d);
            }),
            array( 'db' => 'log_date_add',  'dt' => 4 ),
            array( 'db' => 'log_date_edit', 'dt' => 5 )/*,
            array( 'db' => 'id',            'dt' => 6,
                'formatter' => $funcao)*/
        );

        echo json_encode(
            \Framework\Classes\Datatable::complex( $_GET, Framework\App\Registro::getInstacia()->_Conexao, $tabela, $primaryKey, $columns, null,$where )
        );
    }
    public function Origem($datainicial, $datafinal) {
        // Table's primary key
        $primaryKey = 'id';
        $tabela = 'Usuario_Mensagem';
        $where = 'UM.log_date_add BETWEEN \''.$datainicial.'\' AND \''.$datafinal.'\' GROUP BY UM.origem, UM.id, UM.log_date_add, UM.log_date_edit, UM.mensagem';
        
        
        $columns = array(
            array( 'db' => 'id', 'dt' => 0,
                'formatter' => function( $d, $row ) {
                    return '#'.$d;
                }),
            array( 'db' => 'cliente2',      'dt' => 1 ),
            array( 'db' => 'origem2',       'dt' => 2 ),
            array( 'db' => 'mensagem',      'dt' => 3 ,
                'formatter' => function( $d, $row ) {
                return str_replace ( array("\n", "\r", '<br />'), '', $d);
            }),
            array( 'db' => 'finalizado',    'dt' => 4 ,
                'formatter' => function( $d, $row ) {
                if ($d=='1') {
                    return 'Finalizado';
                } else {
                    return 'Novos Chamados';
                }
            }),
            array( 'db' => 'log_date_add',  'dt' => 4 ),
            array( 'db' => 'log_date_edit', 'dt' => 5 )/*,
            array( 'db' => 'id',            'dt' => 6,
                'formatter' => $funcao)*/
        );

        echo json_encode(
            \Framework\Classes\Datatable::complex( $_GET, Framework\App\Registro::getInstacia()->_Conexao, $tabela, $primaryKey, $columns, null,$where )
        );
    }
    public function Produto($datainicial, $datafinal) {
        // Table's primary key
        $primaryKey = 'id';
        $tabela = 'Usuario_Mensagem';
        $where = 'UM.log_date_add BETWEEN \''.$datainicial.'\' AND \''.$datafinal.'\' GROUP BY UM.marca, UM.linha, EXTC.nome';
        
        
        $columns = array(
            array( 'db' => 'marca2',        'dt' => 0 ),
            array( 'db' => 'linha2',        'dt' => 1 ),
            array( 'db' => 'produto2',      'dt' => 2 ),
            array( 'db' => 'mensagem',      'dt' => 3 ,
                'formatter' => function( $d, $row ) {
                return str_replace ( array("\n", "\r", '<br />'), '', $d);
            }),
            array( 'db' => 'log_date_add',  'dt' => 4 ),
            array( 'db' => 'log_date_edit', 'dt' => 5 )
        );

        echo json_encode(
            \Framework\Classes\Datatable::complex( $_GET, Framework\App\Registro::getInstacia()->_Conexao, $tabela, $primaryKey, $columns, null,$where )
        );
    }
    public function Qtd_Cidade($datainicial, $datafinal) {
        // Table's primary key
        $primaryKey = 'id';
        $tabela = 'Usuario_Mensagem';
        $where = 'UM.log_date_add BETWEEN \''.$datainicial.'\' AND \''.$datafinal.'\' GROUP BY cidade_estado';
        $select_Extra = 'CONCAT( SLC.nome, \' / \',  SLE.sigla ) cidade_estado, COUNT(UM.id) as nr_chamados, MAX(UM.log_date_add) AS ult_add, MAX(UM.log_date_edit) AS ult_edit';
        $innerjoin_Extra = 'INNER JOIN '.MYSQL_USUARIOS.' AS U ON UM.cliente = U.id LEFT JOIN '.MYSQL_SIS_LOCALIZACAO_ESTADOS.' AS SLE ON U.estado = SLE.id LEFT JOIN '.MYSQL_SIS_LOCALIZACAO_CIDADES.' AS SLC ON U.cidade = SLC.id';
        
        $columns = array(
            array( 'db' => 'cidade_estado',     'dt' => 0 ),
            array( 'db' => 'nr_chamados',       'dt' => 1 ),
            array( 'db' => 'log_date_add',      'dt' => 2,
                'formatter' => function( $d, $row ) {
                return data_hora_eua_brasil($d);
            }),
            array( 'db' => 'log_date_edit',     'dt' => 3 ,
                'formatter' => function( $d, $row ) {
                return data_hora_eua_brasil($d);
            }),
        );

        echo json_encode(
            \Framework\Classes\Datatable::complex( $_GET, Framework\App\Registro::getInstacia()->_Conexao, $tabela, $primaryKey, $columns, null,$where, $select_Extra, $innerjoin_Extra )
        );
    }
    public function Qtd_Uf($datainicial, $datafinal) {
        // Table's primary key
        $primaryKey = 'id';
        $tabela = 'Usuario_Mensagem';
        $where = 'SLE.sigla IS NOT NULL AND UM.log_date_add BETWEEN \''.$datainicial.'\' AND \''.$datafinal.'\' GROUP BY U.estado';
        $select_Extra = 'COUNT(UM.id) AS nr_chamados, SLE.nome AS estado_nome, MAX(UM.log_date_add) AS ult_add, MAX(UM.log_date_edit) AS ult_edit';
        $innerjoin_Extra = 'INNER JOIN '.MYSQL_USUARIOS.' AS U ON UM.cliente = U.id LEFT JOIN '.MYSQL_SIS_LOCALIZACAO_ESTADOS.' AS SLE ON U.estado = SLE.id';
        
        $columns = array(
            array( 'db' => 'estado_nome',       'dt' => 0 ),
            array( 'db' => 'nr_chamados',       'dt' => 1 ),
            array( 'db' => 'ult_add',           'dt' => 2 ,
                'formatter' => function( $d, $row ) {
                return data_hora_eua_brasil($d);
            }),
            array( 'db' => 'ult_edit',          'dt' => 3 ,
                'formatter' => function( $d, $row ) {
                return data_hora_eua_brasil($d);
            }),
        );

        echo json_encode(
            \Framework\Classes\Datatable::complex( $_GET, Framework\App\Registro::getInstacia()->_Conexao, $tabela, $primaryKey, $columns, null,$where, $select_Extra, $innerjoin_Extra )
        );
    }
}
?>