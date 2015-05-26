<?php

class comercio_ProdutoModelo extends comercio_Modelo
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
    /**
     * 
     * @param type $modelo
     * @param type $usuarioid
     * @param type $motivoid
     */
    static function Estoque_Exibir($produtoid,$motivoid){
        $produtoid = (int) $produtoid;
        $motivoid = (int) $motivoid;
        $registro = \Framework\App\Registro::getInstacia();
        $_Modelo = $registro->_Modelo;
        $retirada = $_Modelo->db->Sql_Select('Comercio_Produto_Estoque_Reduzir',Array('id'=>$motivoid),1);
        if($retirada===false){
            return Array('Redução Não existente','Não existe');
        }
        return Array('Redução de Estoque','Cadastrado por #'.$retirada->log_user_add);
    }
    public function Produtos(){
        // Table's primary key
        $primaryKey = 'id';
        $tabela = 'Comercio_Produto';
        
        
        $perm_view = $this->_Registro->_Acl->Get_Permissao_Url('comercio/Estoque/Estoques');
        $perm_reduzir = $this->_Registro->_Acl->Get_Permissao_Url('comercio/Produto/Estoque_Reduzir');
        $perm_editar = $this->_Registro->_Acl->Get_Permissao_Url('comercio/Produto/Produtos_Edit');
        $perm_del = $this->_Registro->_Acl->Get_Permissao_Url('comercio/Produto/Produtos_Del');
        
        if($perm_editar && $perm_del){
            $funcao = function( $d, $row ) {
                return Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Produto'        ,'comercio/Produto/Produtos_Edit/'.$d.'/'    ,''),true).
                       Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Produto'       ,'comercio/Produto/Produtos_Del/'.$d.'/'     ,'Deseja realmente deletar essa Produto ?'),true);
            };
        }else if($perm_editar){
            $funcao = function( $d, $row ) {
                return Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Produto'        ,'comercio/Produto/Produtos_Edit/'.$d.'/'    ,''),true);
            };
        }else if($perm_del){
            $funcao = function( $d, $row ) {
                return Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Produto'       ,'comercio/Produto/Produtos_Del/'.$d.'/'     ,'Deseja realmente deletar essa Produto ?'),true);
            };
        }else{
            $funcao = function( $d, $row ) {
                return '';
            };
        }

        
        $comercio_Produto_Cod       = \Framework\App\Acl::Sistema_Modulos_Configs_Funcional('comercio_Produto_Cod');
        $comercio_Produto_Familia   = \Framework\App\Acl::Sistema_Modulos_Configs_Funcional('comercio_Produto_Familia');
        $comercio_Estoque           = \Framework\App\Acl::Sistema_Modulos_Configs_Funcional('comercio_Estoque');
        $comercio_Unidade           = \Framework\App\Acl::Sistema_Modulos_Configs_Funcional('comercio_Unidade');
        $comercio_marca             = \Framework\App\Acl::Sistema_Modulos_Configs_Funcional('comercio_Marca');

        $columns = Array();
        
        $numero = -1;

        if($comercio_Produto_Cod){
            ++$numero;
            $columns[] = array( 'db' => 'id', 'dt' => $numero,
                'formatter' => function( $d, $row ) {
                    return '#'.$d;
                }); //'#Cod';
        }
        if($comercio_marca===true){
            if($comercio_Produto_Familia=='Familia'){
                ++$numero;
                $columns[] = array( 'db' => 'familia2', 'dt' => $numero); //'Familia';
            }else{
                ++$numero;
                $columns[] = array( 'db' => 'marca2', 'dt' => $numero); //'Marca';
                ++$numero;
                $columns[] = array( 'db' => 'linha2', 'dt' => $numero); //'Linha';
            }
        }
        ++$numero;
        $columns[] = array( 'db' => 'nome', 'dt' => $numero); //'Nome';

        // Coloca Preco
        if(\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('comercio_Vendas')){
            ++$numero;
            $columns[] = array( 'db' => 'preco', 'dt' => $numero); //'Preço';
        }

        if($comercio_Estoque){
            ++$numero;
            
            $columns[] = array( 'db' => 'id', 'dt' => $numero,'formatter' => function( $d, $row ) { 
                $html = ''; 
                $html .= '<a class="lajax" acao="" href="'.URL_PATH.'comercio/Estoque/Estoques/'.$d.'">'.
                       ''.comercio_EstoqueControle::Estoque_Retorna($valor->id); 
                return $html; 
            });  //'Estoque';
        }
        if($comercio_Unidade){
            ++$numero;
            $columns[] = array( 'db' => 'unidade2', 'dt' => $numero);  //'Unidade';
        }
        /*if($comercio_Estoque){
                    $tabela['Estoque'][$i]   = '<a class="lajax" acao="" href="'.URL_PATH.'comercio/Estoque/Estoques/'.$valor->id.'">'.comercio_EstoqueControle::Estoque_Retorna($valor->id);
                    if($comercio_Unidade){
                        $tabela['Estoque'][$i]   .= ' '.$valor->unidade2;
                    }
                    $tabela['Estoque'][$i] .= '</a>';
                    $tabela['Funções'][$i]  = $this->_Visual->Tema_Elementos_Btn('Visualizar' ,Array('Visualizar Estoque'    ,'comercio/Estoque/Estoques/'.$valor->id.'/'    ,''),$perm_view).
                                            $this->_Visual->Tema_Elementos_Btn('Personalizado'   ,Array('Reduzir Estoque'  ,'comercio/Produto/Estoque_Reduzir/'.$valor->id.'/'    ,'','long-arrow-down','inverse'),$perm_reduzir);
                }else{
                    if($comercio_Unidade){
                        $tabela['Unidade'][$i]   = $valor->unidade2;
                    }
                    $tabela['Funções'][$i]   = '';
                }*/
        
        ++$numero;
        $columns[] = array( 'db' => 'id',            'dt' => $numero,
            'formatter' => $funcao
        ); //'Funções';
                /*
            $function = '$html .= \'<a class="lajax" acao="" href="\'.URL_PATH.\'comercio/Estoque/Estoques/\'.$d.\'">'.
                    '\'.comercio_EstoqueControle::Estoque_Retorna($valor->id);';
            eval('$function = function( $d, $row ) { $html = ''; '.$function.' return $html; });');*/
                
        echo json_encode(
            \Framework\Classes\Datatable::complex( $_GET, Framework\App\Registro::getInstacia()->_Conexao, $tabela, $primaryKey, $columns, null)
        );
    }
}
?>