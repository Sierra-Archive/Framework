<?php

class usuario_ExpedienteModelo extends usuario_Modelo
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
    * @version 3.1.1
    */
    public function __construct(){
        parent::__construct();
    }
    public function Expedientes($status=0){
        // Table's primary key
        $primaryKey = 'id';
        $tabela = 'Usuario_Expediente';
        $where = 'status=\''.$status.'\'';
        
        
        $perm_statusalterar = $this->_Registro->_Acl->Get_Permissao_Url('usuario/Expediente/Expedientes_StatusAlterar');
        
        $function = '';
        if($perm_statusalterar){
            $function .= ' $html .= Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn(\'Personalizado\'     ,Array(__(\'Colocar em Almoço\')        ,\'usuario/Expediente/Expedientes_StatusAlterar/\'.$d.\'/1/\'    ,\'\',\'file\',\'inverse\'),true);';
            $function .= ' $html .= Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn(\'Personalizado\'     ,Array(__(\'Finalizar\')        ,\'usuario/Expediente/Expedientes_StatusAlterar/\'.$d.\'/2/\'    ,\'\',\'file\',\'inverse\'),true);';
        }

        $columns = Array();
        
        $numero = -1;

        //'#Id'
        ++$numero;
        $columns[] = array( 
            'db' => 'id', 
            'dt' => $numero,
            'formatter' => function( $d, $row ) {
                return '#'.$d;
            }
        );
        
        ++$numero;
        $columns[] = array( 
            'db' => 'usuario2', 
            'dt' => $numero); //'Funcionário';
        
        ++$numero;
        $columns[] = array( 
            'db' => 'inicio', 
            'dt' => $numero); //'Inicio';
        
        ++$numero;
        $columns[] = array( 
            'db' => 'fim', 
            'dt' => $numero); //'Fim';
        
        ++$numero;
        $columns[] = array( 
            'db' => 'status', 
            'dt' => $numero); //'Status';
        
        ++$numero;
        eval('$function = function( $d, $row ) { $html = \'\'; '.$function.' return $html; };');       
        $columns[] = array( 'db' => 'id',            'dt' => $numero,
            'formatter' => $function
        ); //'Funções';
                
        echo json_encode(
            \Framework\Classes\Datatable::complex( $_GET, Framework\App\Registro::getInstacia()->_Conexao, $tabela, $primaryKey, $columns, null,$where)
        );
    }
}
?>