<?php

class comercio_servicos_InstalacaoModelo extends comercio_servicos_Modelo
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
    public function Main() {
        return false;
    }
    public function Btu() {
        // Table's primary key
        $primaryKey = 'id';
        $table = 'Comercio_Servicos_Btu';
        
        
        $permissionEdit = $this->_Registro->_Acl->Get_Permissao_Url('comercio_servicos/Instalacao/Btu_Edit');
        $permissionDelete = $this->_Registro->_Acl->Get_Permissao_Url('comercio_servicos/Instalacao/Btu_Del');
        
        $function = '';
        if ($permissionEdit) {
            $function .= ' $html .= Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn(\'Editar\'     ,Array(\'Editar Btu\'        ,\'comercio_servicos/Instalacao/Btu_Edit/\'.$d.\'/\'    ,\'\'),true);';
        }
        if ($permissionDelete) {
            $function .= ' $html .= Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn(\'Deletar\'    ,Array(\'Deletar Btu\'       ,\'comercio_servicos/Instalacao/Btu_Del/\'.$d.\'/\'     ,\'Deseja realmente deletar essa Btu ?\'),true);';
        }

        
        $columns = Array();
        
        $numero = -1;

        ++$numero;
        $columns[] = array( 'db' => 'nome', 'dt' => $numero); //'Nome';
        ++$numero;
        $columns[] = array( 'db' => 'valor_ar', 'dt' => $numero); //'Valor Equipamento';
        ++$numero;
        $columns[] = array( 'db' => 'valor_gas', 'dt' => $numero); //'Valor Add de Gás';
        ++$numero;
        $columns[] = array( 'db' => 'valor_linha', 'dt' => $numero); //'Valor Add de Linha';

        ++$numero;
        eval('$function = function( $d, $row ) { $html = \'\'; '.$function.' return $html; };');       
        $columns[] = array( 'db' => 'id', 'dt' => $numero,
            'formatter' => $function
        ); //'Funções';
                
        echo json_encode(
            \Framework\Classes\Datatable::complex( $_GET, Framework\App\Registro::getInstacia()->_Conexao, $table, $primaryKey, $columns, null)
        );
    }
    public function Suporte() {
        // Table's primary key
        $primaryKey = 'id';
        $table = 'Comercio_Servicos_Suporte';
        
        
        $permissionEdit = $this->_Registro->_Acl->Get_Permissao_Url('comercio_servicos/Instalacao/Suporte_Edit');
        $permissionDelete = $this->_Registro->_Acl->Get_Permissao_Url('comercio_servicos/Instalacao/Suporte_Del');
        
        $function = '';
        if ($permissionEdit) {
            $function .= ' $html .= Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn(\'Editar\'     ,Array(\'Editar Suporte\'        ,\'comercio_servicos/Instalacao/Suporte_Edit/\'.$d.\'/\'    ,\'\'),true);';
        }
        if ($permissionDelete) {
            $function .= ' $html .= Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn(\'Deletar\'    ,Array(\'Deletar Suporte\'       ,\'comercio_servicos/Instalacao/Suporte_Del/\'.$d.\'/\'     ,\'Deseja realmente deletar esse Suporte ?\'),true);';
        }
        
        $columns = Array();
        $numero = -1;
        
        ++$numero;
        $columns[] = array( 'db' => 'nome', 'dt' => $numero); //'Tipo';
        ++$numero;
        $columns[] = array( 'db' => 'valor', 'dt' => $numero); //'Valor';
        
        ++$numero;
        eval('$function = function( $d, $row ) { $html = \'\'; '.$function.' return $html; };');       
        $columns[] = array( 'db' => 'id', 'dt' => $numero,
            'formatter' => $function
        ); //'Funções';
                
        echo json_encode(
            \Framework\Classes\Datatable::complex( $_GET, Framework\App\Registro::getInstacia()->_Conexao, $table, $primaryKey, $columns, null)
        );
    }
}
?>