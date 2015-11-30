<?php

class comercio_servicos_ServicoTipoModelo extends comercio_servicos_Modelo
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
    public function Servico_Tipo() {
        // Table's primary key
        $primaryKey = 'id';
        $table = 'Comercio_Servicos_Servico_Tipo';
        
        
        $permissionEdit = $this->_Registro->_Acl->Get_Permissao_Url('comercio_servicos/ServicoTipo/Servico_Tipo_Edit');
        $permissionDelete = $this->_Registro->_Acl->Get_Permissao_Url('comercio_servicos/ServicoTipo/Servico_Tipo_Del');
        
        $function = '';
        if ($permissionEdit) {
            $function .= ' $html .= Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn(\'Editar\'     ,Array(\'Editar Produto\'        ,\'comercio_servicos/ServicoTipo/Servico_Tipo_Edit/\'.$d.\'/\'    ,\'\'),true);';
        }
        if ($permissionDelete) {
            $function .= ' $html .= Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn(\'Deletar\'    ,Array(\'Deletar Produto\'       ,\'comercio_servicos/ServicoTipo/Servico_Tipo_Del/\'.$d.\'/\'     ,\'Deseja realmente deletar esse Tipo de Serviço ?\'),true);';
        }

        $columns = Array();
        
        $numero = -1;

        ++$numero;
        $columns[] = array( 'db' => 'nome', 'dt' => $numero); //'Nome';

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