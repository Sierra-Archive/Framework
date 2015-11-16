<?php

class usuario_mensagem_OrigemModelo extends usuario_mensagem_Modelo
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
    public function Origens() {
        
        // Table's primary key
        $primaryKey = 'id';
        $table = 'Usuario_Mensagem_Origem';
        
        $permissionEdit = $this->_Registro->_Acl->Get_Permissao_Url('usuario_mensagem/Origem/Origens_Edit');
        $permissionDelete = $this->_Registro->_Acl->Get_Permissao_Url('usuario_mensagem/Origem/Origens_Del');
        
        if ($permissionEdit && $permissionDelete) {
            $function = function( $d, $row ) {
                return Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Origem'        ,'usuario_mensagem/Origem/Origens_Edit/'.$d.'/'    , ''),TRUE).
                       Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Origem'       ,'usuario_mensagem/Origem/Origens_Del/'.$d.'/'     ,'Deseja realmente deletar essa Origem ?'),TRUE);
            };
        } else if ($permissionEdit) {
            $function = function( $d, $row ) {
                return Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Origem'        ,'usuario_mensagem/Origem/Origens_Edit/'.$d.'/'    , ''),TRUE);
            };
        } else if ($permissionDelete) {
            $function = function( $d, $row ) {
                return Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Origem'       ,'usuario_mensagem/Origem/Origens_Del/'.$d.'/'     ,'Deseja realmente deletar essa Origem ?'),TRUE);
            };
        } else {
            $function = function( $d, $row ) {
                return '';
            };
        }
        
        $columns = array(
            array( 'db' => 'id', 'dt' => 0,
                'formatter' => function( $d, $row ) {
                    return '#'.$d;
                }),
            array( 'db' => 'nome', 'dt' => 1 ),
            array( 'db' => 'id', 'dt' => 2,
                'formatter' => $function)
        );

        echo json_encode(
            \Framework\Classes\Datatable::complex( $_GET, Framework\App\Registro::getInstacia()->_Conexao, $table, $primaryKey, $columns, null )
        );
    }
}
?>