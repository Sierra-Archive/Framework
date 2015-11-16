<?php

class _Sistema_AdminModelo extends _Sistema_Modelo
{
    public function __construct() {
        parent::__construct();
    }
    public function Configs() {
        // Table's primary key
        $primaryKey = 'chave';
        $table = 'Sistema_Config';
        
        
        $permissionEdit = $this->_Registro->_Acl->Get_Permissao_Url('_Sistema/Admin/Configs_Edit');
        


        

        $columns = Array();
        
        $numero = -1;

        ++$numero;
        $columns[] = array( 'db' => 'chave', 'dt' => $numero); //'Chave';
        ++$numero;
        $columns[] = array( 'db' => 'nome', 'dt' => $numero); //'Descrição';
        ++$numero;
        $columns[] = array( 'db' => 'valor', 'dt' => $numero); //'Valor';


        $function = '';
        if ($permissionEdit) {
            $function .= ' $html .= Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn(\'Editar\'     ,Array(__(\'Editar Configuração\')        ,\'_Sistema/Admin/Configs_Edit/\'.$d.\'/\'    ,\'\'),TRUE);';
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
?>