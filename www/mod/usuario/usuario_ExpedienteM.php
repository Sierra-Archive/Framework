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
    * @version 3.1.1
    */
    public function __construct(){
        parent::__construct();
    }
    public function Expedientes(){
        // Table's primary key
        $primaryKey = 'id';
        $tabela = 'Usuario_Expediente';
        
        
        $perm_view = $this->_Registro->_Acl->Get_Permissao_Url('usuario/Estoque/Estoques');
        $perm_reduzir = $this->_Registro->_Acl->Get_Permissao_Url('usuario/Expediente/Estoque_Reduzir');
        $perm_editar = $this->_Registro->_Acl->Get_Permissao_Url('usuario/Expediente/Expedientes_Edit');
        $perm_del = $this->_Registro->_Acl->Get_Permissao_Url('usuario/Expediente/Expedientes_Del');
        
        $function = '';
        if($perm_editar){
            $function .= ' $html .= Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn(\'Editar\'     ,Array(__(\'Editar Expediente\')        ,\'usuario/Expediente/Expedientes_Edit/\'.$d.\'/\'    ,\'\'),true);';
        }
        if($perm_del){
            $function .= ' $html .= Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn(\'Deletar\'    ,Array(__(\'Deletar Expediente\')       ,\'usuario/Expediente/Expedientes_Del/\'.$d.\'/\'     ,\'Deseja realmente deletar essa Expediente ?\'),true);';
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
            'dt' => $numero); //'Nome';
        
        ++$numero;
        $columns[] = array( 
            'db' => 'inicio', 
            'dt' => $numero); //'Nome';
        
        ++$numero;
        $columns[] = array( 
            'db' => 'fim', 
            'dt' => $numero); //'Nome';
        
        ++$numero;
        eval('$function = function( $d, $row ) { $html = \'\'; '.$function.' return $html; };');       
        $columns[] = array( 'db' => 'id',            'dt' => $numero,
            'formatter' => $function
        ); //'Funções';
                
        echo json_encode(
            \Framework\Classes\Datatable::complex( $_GET, Framework\App\Registro::getInstacia()->_Conexao, $tabela, $primaryKey, $columns, null)
        );
    }
}
?>