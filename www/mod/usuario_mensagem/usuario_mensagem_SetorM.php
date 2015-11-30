<?php

class usuario_mensagem_SetorModelo extends usuario_mensagem_Modelo
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
    public function Setores() {
        
        // Table's primary key
        $primaryKey = 'id';
        $table = 'Usuario_Mensagem_Setor';
        
        $permissionEdit = $this->_Registro->_Acl->Get_Permissao_Url('usuario_mensagem/Setor/Setores_Edit');
        $permissionDelete = $this->_Registro->_Acl->Get_Permissao_Url('usuario_mensagem/Setor/Setores_Del');
        
        if ($permissionEdit && $permissionDelete) {
            $function = function( $d, $row ) {
                return Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn('Editar'     ,Array(__('Editar Setor')        ,'usuario_mensagem/Setor/Setores_Edit/'.$d.'/'    , ''),true).
                       Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn('Deletar'    ,Array(__('Deletar Setor')       ,'usuario_mensagem/Setor/Setores_Del/'.$d.'/'     , __('Deseja realmente deletar essa Setor ?')),true);
            };
        } else if ($permissionEdit) {
            $function = function( $d, $row ) {
                return Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn('Editar'     ,Array(__('Editar Setor')        ,'usuario_mensagem/Setor/Setores_Edit/'.$d.'/'    , ''),true);
            };
        } else if ($permissionDelete) {
            $function = function( $d, $row ) {
                return Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn('Deletar'    ,Array(__('Deletar Setor')       ,'usuario_mensagem/Setor/Setores_Del/'.$d.'/'     , __('Deseja realmente deletar essa Setor ?')),true);
            };
        } else {
            $function = function( $d, $row ) {
                return '';
            };
        }
        
        $columns = array(
            /*array( 'db' => 'id', 'dt' => 0,
                'formatter' => function( $d, $row ) {
                    return '#'.$d;
                }),*/
            array( 'db' => 'grupo2', 'dt' => 0 ),
            array( 'db' => 'nome', 'dt' => 1 ),
            array( 'db' => 'email', 'dt' => 2 ),
            array( 'db' => 'id', 'dt' => 3,
                'formatter' => $function)
        );

        echo json_encode(
            \Framework\Classes\Datatable::complex( $_GET, Framework\App\Registro::getInstacia()->_Conexao, $table, $primaryKey, $columns, null )
        );
    }
}
?>