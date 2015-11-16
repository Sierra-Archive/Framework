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
    * @version 0.4.2
    */
    public function __construct() {
        parent::__construct();
    }
    /**
     * Listagem de Expedientes 
     * @param type $status
     * @param type $almoco
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Expedientes($status=0, $almoco = FALSE) {
        // Table's primary key
        $primaryKey = 'id';
        $tabela = 'Usuario_Expediente';
        $where = 'status=\''.$status.'\'';
        
        
        $perm_statusalterar = $this->_Registro->_Acl->Get_Permissao_Url('usuario/Expediente/Expedientes_StatusAlterar');
        
        $function = '';
        if ($perm_statusalterar) {
            if ($status==0) {
                $function .= ' $html .= Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn(\'Personalizado\'     ,Array(__(\'Colocar em Almoço\')        ,\'usuario/Expediente/Expedientes_StatusAlterar/\'.$d.\'/1/\'    ,\'\',\'cutlery\',\'success\'),TRUE);';
                $function .= ' $html .= \' \'.Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn(\'Personalizado\'     ,Array(__(\'Finalizar\')        ,\'usuario/Expediente/Expedientes_StatusAlterar/\'.$d.\'/2/\'    ,\'\',\'home\',\'warning\'),TRUE);';
            } else {
                $function .= ' $html .= Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn(\'Personalizado\'     ,Array(__(\'Sair do Almoço\')        ,\'usuario/Expediente/Expedientes_StatusAlterar/\'.$d.\'/0/\'    ,\'\',\'random\',\'primary\'),TRUE);';
            }
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
        
        
        if ($almoco !== FALSE) {
            ++$numero;
            $columns[] = array( 
                'db' => 'log_date_edit', 
                'dt' => $numero); //'ULt Alteracao';
        } else {            
            ++$numero;
            $columns[] = array( 
                'db' => 'inicio', 
                'dt' => $numero); //'Inicio';

            ++$numero;
            $columns[] = array( 
                'db' => 'fim', 
                'dt' => $numero); //'Fim';
        }
        
        ++$numero;
        eval('$function = function( $d, $row ) { $html = \'\'; '.$function.' return $html; };');       
        $columns[] = array( 'db' => 'id', 'dt' => $numero,
            'formatter' => $function
        ); //'Funções';
                
        echo json_encode(
            \Framework\Classes\Datatable::complex( $_GET, Framework\App\Registro::getInstacia()->_Conexao, $tabela, $primaryKey, $columns, null, $where)
        );
    }
}
?>