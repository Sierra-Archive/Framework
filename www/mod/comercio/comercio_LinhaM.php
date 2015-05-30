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
    * @version 2.0
    */
    public function __construct(){
        parent::__construct();
    }
    public function Linhas(){
        
        // Table's primary key
        $primaryKey = 'id';
        $tabela = 'Comercio_Linha';
        
        $perm_editar = $this->_Registro->_Acl->Get_Permissao_Url('comercio/Linha/Linhas_Edit');
        $perm_del = $this->_Registro->_Acl->Get_Permissao_Url('comercio/Linha/Linhas_Del');
        
        if($perm_editar && $perm_del){
            $funcao = function( $d, $row ) {
                return Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Linha'        ,'comercio/Linha/Linhas_Edit/'.$d.'/'    ,''),true).
                       Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Linha'       ,'comercio/Linha/Linhas_Del/'.$d.'/'     ,'Deseja realmente deletar essa Linha ?'),true);
            };
        }else if($perm_editar){
            $funcao = function( $d, $row ) {
                return Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Linha'        ,'comercio/Linha/Linhas_Edit/'.$d.'/'    ,''),true);
            };
        }else if($perm_del){
            $funcao = function( $d, $row ) {
                return Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Linha'       ,'comercio/Linha/Linhas_Del/'.$d.'/'     ,'Deseja realmente deletar essa Linha ?'),true);
            };
        }else{
            $funcao = function( $d, $row ) {
                return '';
            };
        }
        
        $columns = array(
            array( 'db' => 'id', 'dt' => 0,
                'formatter' => function( $d, $row ) {
                    return '#'.$d;
                }),
            array( 'db' => 'nome',    'dt' => 1 ),
            array( 'db' => 'marca2',  'dt' => 2 ),
            array( 'db' => 'id',      'dt' => 3,
                'formatter' => $funcao)
        );

        echo json_encode(
            \Framework\Classes\Datatable::complex( $_GET, Framework\App\Registro::getInstacia()->_Conexao, $tabela, $primaryKey, $columns, null )
        );
    }
}
?>