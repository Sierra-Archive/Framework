<?php

class Agenda_PastaModelo extends Agenda_Modelo
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
     * @version 0.4.2
     * 
     */
    public function __construct() {
      parent::__construct();
    }
    public function Pastas() {
        // Table's primary key
        $primaryKey = 'id';
        $tabela = 'Usuario_Agenda_Pasta';
        $where = '';
        
        $perm_editar = $this->_Registro->_Acl->Get_Permissao_Url('Agenda/Pasta/Pastas_Edit');
        $perm_del = $this->_Registro->_Acl->Get_Permissao_Url('Agenda/Pasta/Pastas_Del');
        
        $function = '';
        if ($perm_editar) $function .= ' $html .= Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn(\'Editar\'     ,Array(__(\'Editar Pasta\')        ,\'Agenda/Pasta/Pastas_Edit/\'.$d    ,\'\'),TRUE);';
        if ($perm_del) $function .= ' $html .= Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn(\'Deletar\'    ,Array(__(\'Deletar Pasta\')       ,\'Agenda/Pasta/Pastas_Del/\'.$d     ,__(\'Deseja realmente deletar essa Pasta ?\')),TRUE);';
        $columns = Array();
        
        $numero = -1;
        
        ++$numero;
        $columns[] = array( 'db' => 'categoria2', 'dt' => $numero); //'Categoria';
        
        ++$numero;
        $columns[] = array( 'db' => 'cor2', 'dt' => $numero); //'Cor';
        
        ++$numero;
        $columns[] = array( 'db' => 'num', 'dt' => $numero); //'Numero';
        
        ++$numero;
        $columns[] = array( 'db' => 'nome', 'dt' => $numero); //'Nome';
        
        ++$numero;
        $columns[] = array( 'db' => 'obs', 'dt' => $numero); //'Obs';

        
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