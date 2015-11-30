<?php

class _Sistema_PrincipalModelo extends _Sistema_Modelo
{
    public function __construct() {
        parent::__construct();
    }
    public function userActive()
    {
        // Table's primary key
        $primaryKey = 'id';
        $table = 'Log_Login';
        $where = 'LL.dt_saida is null OR LL.dt_saida=\'0000-00-00 00:00:00\'';

        $columns = Array();
        
        $numero = -1;

        //id
        ++$numero;
        $columns[] = array( 'db' => 'login', 'dt' => $numero);

        //Usuario
        ++$numero;
        $columns[] = array( 'db' => 'login2', 'dt' => $numero);

        // Logado Desde
        ++$numero;
        $columns[] = array( 'db' => 'dt_entrada', 'dt' => $numero);

        // Ultima Movimentação
        ++$numero;
        $columns[] = array( 'db' => 'dt_atualizado', 'dt' => $numero);

        echo json_encode(
            \Framework\Classes\Datatable::complex(
                $_GET,
                Framework\App\Registro::getInstacia()->_Conexao,
                $table,
                $primaryKey,
                $columns,
                null,
                $where
            )
        );
    }
}
?>