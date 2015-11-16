<?php

class comercio_FornecedorModelo extends comercio_Modelo
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
    public function Fornecedores() {
        // Table's primary key
        $primaryKey = 'id';
        $tabela = 'Comercio_Fornecedor';
        
        
        $perm_view = $this->_Registro->_Acl->Get_Permissao_Url('comercio/Fornecedor/Fornecedores_View');
        $perm_editar = $this->_Registro->_Acl->Get_Permissao_Url('comercio/Fornecedor/Fornecedores_Edit');
        $perm_del = $this->_Registro->_Acl->Get_Permissao_Url('comercio/Fornecedor/Fornecedores_Del');
        
        $function = '';
        if ($perm_view) {
            $function .= ' $html .= Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn(\'Zoom\'     ,Array(\'Visualizar Comentários do Fornecedor\'        ,\'comercio/Fornecedor/Fornecedores_View/\'.$d.\'/\'    ,\'\'),true);';
        }
        if ($perm_editar) {
            $function .= ' $html .= Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn(\'Editar\'     ,Array(\'Editar Fornecedor\'        ,\'comercio/Fornecedor/Fornecedores_Edit/\'.$d.\'/\'    ,\'\'),true);';
        }
        if ($perm_del) {
            $function .= ' $html .= Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn(\'Deletar\'    ,Array(\'Deletar Fornecedor\'       ,\'comercio/Fornecedor/Fornecedores_Del/\'.$d.\'/\'     ,\'Deseja realmente deletar esse Fornecedor ?\'),true);';
        }

        
        $columns = Array();
        $numero = -1;

        // nome e razaosocial #update
        ++$numero;
        $columns[] = array( 'db' => 'nome', 'dt' => $numero); //'#Nome';
        if (\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('comercio_Fornecedor_Categoria')) {
            ++$numero;
            $columns[] = array( 'db' => 'categoria2', 'dt' => $numero); //'Tipo de Fornecimento';
        }
        
        // Telefone, acresentar telefone2 #update
        ++$numero;
        $columns[] = array( 'db' => 'telefone', 'dt' => $numero); //'Telefone';
        
        // Email, acresentar Email2 #update
        ++$numero;
        $columns[] = array( 'db' => 'email', 'dt' => $numero); //'Email';
        
        // Funcoes        
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