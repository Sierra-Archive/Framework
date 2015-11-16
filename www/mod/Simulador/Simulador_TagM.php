<?php

class Simulador_TagModelo extends Simulador_Modelo
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
    public function Tags() {
        // Table's primary key
        $primaryKey = 'id';
        $table = 'Simulador_Tag';
        $where = '';
        
    
        $permissionEdit = $this->_Registro->_Acl->Get_Permissao_Url('Simulador/Tag/Tags_Edit');
        $permissionDelete = $this->_Registro->_Acl->Get_Permissao_Url('Simulador/Tag/Tags_Del');
        
        $function = '';
        if ($permissionEdit) $function .= ' $html .= Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn(\'Editar\'     ,Array(__(\'Editar Pasta\')        ,\'Simulador/Tag/Tags_Edit/\'.$d    ,\'\'),TRUE);';
        if ($permissionDelete) $function .= ' $html .= Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn(\'Deletar\'    ,Array(__(\'Deletar Pasta\')       ,\'Simulador/Tag/Tags_Del/\'.$d     ,__(\'Deseja realmente deletar essa Caracteristica ?\')),TRUE);';

        $columns = Array();
        
        $numero = -1;
        
        //'Id';
        ++$numero;
        $columns[] = array( 'db' => 'id', 'dt' => $numero,
            'formatter' => function( $d, $row ) {
                return '#'.$d;
            }
        );
        
        // Nome
        ++$numero;
        $columns[] = array( 'db' => 'nome', 'dt' => $numero
        );
        
        // Resultado Tipo
        ++$numero;
        $columns[] = array( 'db' => 'resultado_tipo', 'dt' => $numero);
                
        // Obs
        ++$numero;
        $columns[] = array( 'db' => 'obs', 'dt' => $numero);        
        
        // Funcoes
        ++$numero;
        eval('$function = function( $d, $row ) { $html = \'\'; '.$function.' return $html; };');       
        $columns[] = array( 'db' => 'id', 'dt' => $numero,
            'formatter' => $function
        ); //'Funções';
                
        echo json_encode(
            \Framework\Classes\Datatable::complex( $_GET, Framework\App\Registro::getInstacia()->_Conexao, $table, $primaryKey, $columns, null, $where)
        );
    }
}
?>