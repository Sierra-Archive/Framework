<?php

class usuario_mensagem_AssuntoModelo extends usuario_mensagem_Modelo
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
    public function Assuntos() {
        
        // Table's primary key
        $primaryKey = 'id';
        $table = 'Usuario_Mensagem_Assunto';
        
        $permissionEdit = $this->_Registro->_Acl->Get_Permissao_Url('usuario_mensagem/Assunto/Assuntos_Edit');
        $permissionDelete = $this->_Registro->_Acl->Get_Permissao_Url('usuario_mensagem/Assunto/Assuntos_Del');
        
        if ($permissionEdit && $permissionDelete) {
            $function = function( $d, $row ) {
                return Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn('Editar'     ,Array(__('Editar Assunto')        ,'usuario_mensagem/Assunto/Assuntos_Edit/'.$d.'/'    , ''),true).
                       Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn('Deletar'    ,Array(__('Deletar Assunto')       ,'usuario_mensagem/Assunto/Assuntos_Del/'.$d.'/'     , __('Deseja realmente deletar essa Assunto ?')),true);
            };
        } else if ($permissionEdit) {
            $function = function( $d, $row ) {
                return Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn('Editar'     ,Array(__('Editar Assunto')        ,'usuario_mensagem/Assunto/Assuntos_Edit/'.$d.'/'    , ''),true);
            };
        } else if ($permissionDelete) {
            $function = function( $d, $row ) {
                return Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn('Deletar'    ,Array(__('Deletar Assunto')       ,'usuario_mensagem/Assunto/Assuntos_Del/'.$d.'/'     , __('Deseja realmente deletar essa Assunto ?')),true);
            };
        } else {
            $function = function( $d, $row ) {
                return '';
            };
        }
        
        $columns = array(
            array( 'db' => 'setor2', 'dt' => 0),
            array( 'db' => 'nome', 'dt' => 1),
            array( 'db' => 'tempocli', 'dt' => 2 ,
                'formatter' => function($d, $row) {
                    return $d.' horas';
                }
            ),
            array( 'db' => 'id', 'dt' => 3,
                'formatter' => $function
            )
        );

        echo json_encode(
            \Framework\Classes\Datatable::complex( $_GET, Framework\App\Registro::getInstacia()->_Conexao, $table, $primaryKey, $columns, null )
        );
    }
}
?>