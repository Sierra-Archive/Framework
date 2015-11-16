<?php

class comercio_LinhaModelo extends comercio_Modelo
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
    public function Linhas() {
        
        // Table's primary key
        $primaryKey = 'id';
        $table = 'Comercio_Linha';
        
        $permissionEdit = $this->_Registro->_Acl->Get_Permissao_Url('comercio/Linha/Linhas_Edit');
        $permissionDelete = $this->_Registro->_Acl->Get_Permissao_Url('comercio/Linha/Linhas_Del');
        
        if ($permissionEdit && $permissionDelete) {
            $function = function( $d, $row ) {
                return Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Linha'        ,'comercio/Linha/Linhas_Edit/'.$d.'/'    , ''),TRUE).
                       Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Linha'       ,'comercio/Linha/Linhas_Del/'.$d.'/'     ,'Deseja realmente deletar essa Linha ?'),TRUE);
            };
        } else if ($permissionEdit) {
            $function = function( $d, $row ) {
                return Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Linha'        ,'comercio/Linha/Linhas_Edit/'.$d.'/'    , ''),TRUE);
            };
        } else if ($permissionDelete) {
            $function = function( $d, $row ) {
                return Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Linha'       ,'comercio/Linha/Linhas_Del/'.$d.'/'     ,'Deseja realmente deletar essa Linha ?'),TRUE);
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
            array( 'db' => 'marca2', 'dt' => 2 ),
            array( 'db' => 'id', 'dt' => 3,
                'formatter' => $function)
        );

        echo json_encode(
            \Framework\Classes\Datatable::complex( $_GET, Framework\App\Registro::getInstacia()->_Conexao, $table, $primaryKey, $columns, null )
        );
    }
}
?>