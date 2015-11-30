<?php

class comercio_RelatorioModelo extends comercio_Modelo
{
    /**
     * __construct
     * 
     * @name __construct
     * @access public
     * 
     * @return void
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.24
     * 
     */
    public function __construct() {
      parent::__construct();
    }
    public function relatorioProposta($datainicial = '2014-01-01', $data_final = APP_DATA, $status = 'todas', $cliente='false', $cuidados='false')
    {
        // Table's primary key
        $primaryKey = 'id';
        $table = 'Comercio_Proposta_Status';
        /*$datainicial = '2014-01-01', $data_final = APP_DATA*/
        $where = 'CPROSt.data>=\''.$datainicial.' 00:00:00\' AND CPROSt.data<=\''.$data_final.' 23:59:59\'';
        
        //Status
        if ($status!='todas' && $status!==false) {
            if ($where !== '') {
                $where .= ' AND ';
            }
            $where .= 'CPROSt.status=\''.$status.'\'';
        }  else if ($status===false || $status==0) {
            if ($where !== '') {
                $where .= ' AND ';
            }
            $where .= 'CPROSt.status=\'0\'';
        }  
        
        if($cliente!=='false'){
            if ($where !== '') {
                $where .= ' AND ';
            }
            $where .= 'CPROSt.cliente=\''.$cliente.'\'';
        }   
        if($cuidados!=='false'){
            if ($where !== '') {
                $where .= ' AND ';
            }
            $where .= 'CPROSt.cuidados=\''.$cuidados.'\'';
        }
        
        $columns = Array();
        $numero = -1;

        /*//'Proposta Id';
        ++$numero;
        $columns[] = array( 'db' => 'proposta', 'dt' => $numero);*/

        //'Proposta';
        ++$numero;
        $columns[] = array( 'db' => 'proposta', 'dt' => $numero);


        //'Cliente';
        ++$numero;
        $columns[] = array( 'db' => 'cliente2', 'dt' => $numero);


        //'Vendedor';
        ++$numero;
        $columns[] = array( 'db' => 'cuidados2', 'dt' => $numero);

        //'Status';
        ++$numero;
        $columns[] = array(
            'db' => 'status',
            'dt' => $numero,
            'formatter' => function( $d, $row ) {
                if ($d==4) {
                    return __('Recusado');
                }else if ($d==3) {
                    return __('Finalizado');
                }else if ($d==2) {
                    return __('Em Execução');
                }else if ($d==1) {
                    return __('Aprovado');
                }
                return __('Pendente');
            }
        );

        //'Status';
        ++$numero;
        $columns[] = array(
            'db' => 'data',
            'dt' => $numero
        );

        echo json_encode(
            \Framework\Classes\Datatable::complex( $_GET, Framework\App\Registro::getInstacia()->_Conexao, $table, $primaryKey, $columns, null, $where)
        );
    }
}
