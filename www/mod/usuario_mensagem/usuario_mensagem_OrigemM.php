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
        $tabela = 'Usuario_Mensagem_Origem';
        
        $perm_editar = $this->_Registro->_Acl->Get_Permissao_Url('usuario_mensagem/Origem/Origens_Edit');
        $perm_del = $this->_Registro->_Acl->Get_Permissao_Url('usuario_mensagem/Origem/Origens_Del');
        
        if ($perm_editar && $perm_del) {
            $funcao = function( $d, $row ) {
                return Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Origem'        ,'usuario_mensagem/Origem/Origens_Edit/'.$d.'/'    , ''),TRUE).
                       Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Origem'       ,'usuario_mensagem/Origem/Origens_Del/'.$d.'/'     ,'Deseja realmente deletar essa Origem ?'),TRUE);
            };
        } else if ($perm_editar) {
            $funcao = function( $d, $row ) {
                return Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Origem'        ,'usuario_mensagem/Origem/Origens_Edit/'.$d.'/'    , ''),TRUE);
            };
        } else if ($perm_del) {
            $funcao = function( $d, $row ) {
                return Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Origem'       ,'usuario_mensagem/Origem/Origens_Del/'.$d.'/'     ,'Deseja realmente deletar essa Origem ?'),TRUE);
            };
        } else {
            $funcao = function( $d, $row ) {
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
                'formatter' => $funcao)
        );

        echo json_encode(
            \Framework\Classes\Datatable::complex( $_GET, Framework\App\Registro::getInstacia()->_Conexao, $tabela, $primaryKey, $columns, null )
        );
    }
}
?>