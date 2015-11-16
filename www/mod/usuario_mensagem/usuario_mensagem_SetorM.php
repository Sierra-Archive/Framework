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
    * @version 0.4.2
    */
    public function __construct() {
        parent::__construct();
    }
    public function Setores() {
        
        // Table's primary key
        $primaryKey = 'id';
        $tabela = 'Usuario_Mensagem_Setor';
        
        $perm_editar = $this->_Registro->_Acl->Get_Permissao_Url('usuario_mensagem/Setor/Setores_Edit');
        $perm_del = $this->_Registro->_Acl->Get_Permissao_Url('usuario_mensagem/Setor/Setores_Del');
        
        if ($perm_editar && $perm_del) {
            $funcao = function( $d, $row ) {
                return Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Setor'        ,'usuario_mensagem/Setor/Setores_Edit/'.$d.'/'    , ''),TRUE).
                       Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Setor'       ,'usuario_mensagem/Setor/Setores_Del/'.$d.'/'     ,'Deseja realmente deletar essa Setor ?'),TRUE);
            };
        } else if ($perm_editar) {
            $funcao = function( $d, $row ) {
                return Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Setor'        ,'usuario_mensagem/Setor/Setores_Edit/'.$d.'/'    , ''),TRUE);
            };
        } else if ($perm_del) {
            $funcao = function( $d, $row ) {
                return Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Setor'       ,'usuario_mensagem/Setor/Setores_Del/'.$d.'/'     ,'Deseja realmente deletar essa Setor ?'),TRUE);
            };
        } else {
            $funcao = function( $d, $row ) {
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
                'formatter' => $funcao)
        );

        echo json_encode(
            \Framework\Classes\Datatable::complex( $_GET, Framework\App\Registro::getInstacia()->_Conexao, $tabela, $primaryKey, $columns, null )
        );
    }
}
?>