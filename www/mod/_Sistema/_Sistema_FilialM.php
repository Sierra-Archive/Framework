<?php

class _Sistema_FilialModelo extends _Sistema_Modelo
{
    public function __construct() {
        parent::__construct();
    }
    public function Filiais() {
        // Table's primary key
        $primaryKey = 'id';
        $tabela = 'Sistema_Filial';
        
        
        $perm_editar = $this->_Registro->_Acl->Get_Permissao_Url('_Sistema/Filial/Filiais_Edit');
        $perm_deletar = $this->_Registro->_Acl->Get_Permissao_Url('_Sistema/Filial/Filiais_Del');
        


        

        $columns = Array();
        
        $numero = -1;

        ++$numero;
        $columns[] = array( 'db' => 'id', 'dt' => $numero); //'Chave';
        ++$numero;
        $columns[] = array( 'db' => 'nome', 'dt' => $numero); //'Descrição';
        ++$numero;
        $columns[] = array( 'db' => 'bairro2', 'dt' => $numero); //'Valor';
        ++$numero;
        $columns[] = array( 'db' => 'endereco', 'dt' => $numero); //'Valor';


        $function = '';
        if ($perm_editar) {
            $function .= ' $html .= Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn(\'Editar\'     ,Array(__(\'Editar Filial\')        ,\'_Sistema/Filial/Filiais_Edit/\'.$d.\'/\'    ,\'\'),true);';
        }
        if ($perm_deletar) {
            $function .= ' $html .= Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn(\'Deletar\'     ,Array(__(\'Deletar Filial\')        ,\'_Sistema/Filial/Filiais_Del/\'.$d.\'/\'    ,\'\'),true);';
        }
        
        ++$numero;
        eval('$function = function( $d, $row ) { $html = \'\'; '.$function.' return $html; };');       
        $columns[] = array( 'db' => 'id', 'dt' => $numero,
            'formatter' => $function
        ); //'Funções';
                
        echo json_encode(
            \Framework\Classes\Datatable::complex( $_GET, Framework\App\Registro::getInstacia()->_Conexao, $tabela, $primaryKey, $columns, null)
        );
    }
}
?>