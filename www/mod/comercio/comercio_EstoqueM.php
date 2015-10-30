<?php

class comercio_EstoqueModelo extends comercio_Modelo
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
    /**
     * 
     * @param type $Modelo
     * @param type $produtoid
     * @param type $motivoid
     */
    static function Estoque_Exibir($produtoid,$motivoid) {
        $produtoid = (int) $produtoid;
        $motivoid = (int) $motivoid;
        $Registro = &\Framework\App\Registro::getInstacia();
        $_Modelo = &$Registro->_Modelo;
        $retirada = $_Modelo->db->Sql_Select('Comercio_Fornecedor_Material',Array('id'=>$motivoid),1);
        if ($retirada===false) {
            return Array('Entrada Não existente','Não existe');
        }
        return Array('Entrada de Nota Fiscal','Fornecedor '.$retirada->fornecedor2);
    }
    /**
     * 
     * @param type $Modelo
     * @param type $usuarioid
     * @param type $motivoid
     */
    static function Financeiro_Motivo_Exibir($motivoid) {
        $motivoid = (int) $motivoid;
        if ($motivoid===0) {
            return Array('Compra não existe no banco de dados.','Não existe');
        }
        $Registro = &\Framework\App\Registro::getInstacia();
        $_Modelo = &$Registro->_Modelo;
        $material = $_Modelo->db->Sql_Select('Comercio_Fornecedor_Material',Array('id'=>$motivoid),1);
        if ($material===false) {
            return Array('Compra não existe no banco de dados.','Não existe');
        }
        return Array('Compra de Nota Fiscal '.$material->documento,'Fornecedor '.$material->fornecedor2);
    }
    
    public function Material_Entrada() {
        
        // Table's primary key
        $primaryKey = 'id';
        
        
        $perm_editar = $this->_Registro->_Acl->Get_Permissao_Url('comercio/Estoque/Material_Entrada_Edit');
        $perm_del = $this->_Registro->_Acl->Get_Permissao_Url('comercio/Estoque/Material_Entrada_Del');
        
        if ($perm_editar && $perm_del) {
            $funcao = function( $d, $row ) {
                return Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Entrada de NFE'        ,'comercio/Estoque/Material_Entrada_Edit/'.$d.'/'    ,''),true).
                       Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Entrada de NFE'       ,'comercio/Estoque/Material_Entrada_Del/'.$d.'/'     ,'Deseja realmente deletar essa Entrada de NFE ?'),true);
            };
        } else if ($perm_editar) {
            $funcao = function( $d, $row ) {
                return Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Entrada de NFE'        ,'comercio/Estoque/Material_Entrada_Edit/'.$d.'/'    ,''),true);
            };
        } else if ($perm_del) {
            $funcao = function( $d, $row ) {
                return Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Entrada de NFE'       ,'comercio/Estoque/Material_Entrada_Del/'.$d.'/'     ,'Deseja realmente deletar essa Entrada de NFE ?'),true);
            };
        } else {
            $funcao = function( $d, $row ) {
                return '';
            };
        }

        // Array of database columns which should be read and sent back to DataTables.
        // The `db` parameter represents the column name in the database, while the `dt`
        // parameter represents the DataTables column identifier. In this case simple
        // indexes
              /*  if ($valor->documento==0) {
                    $documento = __('Nfe');
                } else if ($valor->documento==1) {
                    $documento = __('Boleto');
                } else {
                    $documento = __('Recibo');
                }
                $tabela['Número'][$i]           = $valor->numero;
                $tabela['Documento'][$i]        = $documento;
                $tabela['Fornecedor'][$i]       = $valor->fornecedor2;
                $tabela['Data'][$i]             = $valor->data;
                $tabela['Valor'][$i]            = $valor->valor;
                $tabela['Funções'][$i]   = $this->_Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Entrada de NFE'        ,'comercio/Estoque/Material_Entrada_Edit/'.$valor->id.'/'    ,''),$perm_editar).
                                           $this->_Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Entrada de NFE'       ,'comercio/Estoque/Material_Entrada_Del/'.$valor->id.'/'     ,'Deseja realmente deletar essa Entrada de NFE ?'),$perm_del);
                ++$i;*/
        $columns = array(
            array( 'db' => 'numero', 'dt' => 0 ),
            array( 'db' => 'documento',  'dt' => 1 ,
                'formatter' => function( $d, $row ) {
                    if ($d==0) {
                        return 'Nfe';
                    } else if ($d==1) {
                        return 'Boleto';
                    } else {
                        return 'Recibo';
                    }
                }),
            array( 'db' => 'fornecedor2',   'dt' => 2 ),
            array( 'db' => 'data',     'dt' => 3 ),
            array( 'db' => 'valor',     'dt' => 4 ),
            array( 'db' => 'id',     'dt' => 5,
                'formatter' => $funcao)
            /*array(
                'db'        => 'start_date',
                'dt'        => 4,
                'formatter' => function( $d, $row ) {
                    return date( 'jS M y', strtotime($d));
                }
            ),
            array(
                'db'        => 'salary',
                'dt'        => 5,
                'formatter' => function( $d, $row ) {
                    return '$'.number_format($d);
                }
            )*/
        );

        echo json_encode(
            \Framework\Classes\Datatable::complex( $_GET, Framework\App\Registro::getInstacia()->_Conexao, 'Comercio_Fornecedor_Material', $primaryKey, $columns )
        );
    }
}
?>