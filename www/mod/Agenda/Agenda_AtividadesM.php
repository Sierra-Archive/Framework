<?php

class Agenda_AtividadesModelo extends Agenda_Modelo
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
    * @version 0.4.24
    */
    public function __construct() {
      parent::__construct();
    }
    public function Atividades() {
        // Table's primary key
        $primaryKey = 'id';
        $table = 'Agenda_Atividade';
        
        
        $permissionEdit = $this->_Registro->_Acl->Get_Permissao_Url('Agenda/Agenda/Atividades_Edit');
        $permissionDelete = $this->_Registro->_Acl->Get_Permissao_Url('Agenda/Agenda/Atividades_Del');
        


        

        $columns = Array();
        
        $numero = -1;

        ++$numero;
        $columns[] = array( 'db' => 'id', 'dt' => $numero); //'Id';
        ++$numero;
        $columns[] = array( 'db' => 'motivo', 'dt' => $numero); //'Motivo';
        ++$numero;
        $columns[] = array( 'db' => 'motivoid', 'dt' => $numero); //'MotidoID';
        ++$numero;
        $columns[] = array( 'db' => 'datainicio', 'dt' => $numero); //'Data Inicio';
        ++$numero;
        $columns[] = array( 'db' => 'datafim', 'dt' => $numero); //'Data Fim';


        $function = '';
        if ($permissionEdit) {
            $function .= ' $html .= Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn(\'Editar\'     ,Array(__(\'Editar Atividade\')        ,\'Agenda/Agenda/Atividades_Edit/\'.$d.\'/\'    ,\'\'),true);';
        }
        if ($permissionDelete) {
            $function .= ' $html .= Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn(\'Deletar\'     ,Array(__(\'Deletar Atividade\')        ,\'Agenda/Agenda/Atividades_Del/\'.$d.\'/\'    ,\'\'),true);';
        }
        
        ++$numero;
        eval('$function = function( $d, $row ) { $html = \'\'; '.$function.' return $html; };');       
        $columns[] = array( 'db' => 'chave', 'dt' => $numero,
            'formatter' => $function
        ); //'Funções';
                
        echo json_encode(
            \Framework\Classes\Datatable::complex( $_GET, Framework\App\Registro::getInstacia()->_Conexao, $table, $primaryKey, $columns, null)
        );
    }
}

