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
        
        /*$i = 0;
        $ordem = 0;
        $comercio_Produto_Cod       = \Framework\App\Acl::Sistema_Modulos_Configs_Funcional('comercio_Produto_Cod');
        $comercio_Produto_Familia   = \Framework\App\Acl::Sistema_Modulos_Configs_Funcional('comercio_Produto_Familia');
        $comercio_Estoque           = \Framework\App\Acl::Sistema_Modulos_Configs_Funcional('comercio_Estoque');
        $comercio_Unidade           = \Framework\App\Acl::Sistema_Modulos_Configs_Funcional('comercio_Unidade');
        $comercio_marca             = \Framework\App\Acl::Sistema_Modulos_Configs_Funcional('comercio_Marca');
        if($comercio_Produto_Cod)   $ordem = 1;
        if($comercio_Produto_Cod)   $ordem = $ordem+1;
        else                        $ordem = $ordem+2;
        // Add
        // BOTAO IMPRIMIR / ADD
        $this->_Visual->Blocar($this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            Array(
                'Adicionar Produto',
                'comercio/Produto/Produtos_Add',
                ''
            ),
            Array(
                'Print'     => true,
                'Pdf'       => true,
                'Excel'     => true,
                'Link'      => 'comercio/Produto/Produtos',
            )
        )));
        $produto = $this->_Modelo->db->Sql_Select('Comercio_Produto');
        if($produto!==false && !empty($produto)){
            if(is_object($produto)) $produto = Array(0=>$produto);
            reset($produto);
            $perm_view = $this->_Registro->_Acl->Get_Permissao_Url('comercio/Estoque/Estoques');
            $perm_reduzir = $this->_Registro->_Acl->Get_Permissao_Url('comercio/Produto/Estoque_Reduzir');
            $perm_editar = $this->_Registro->_Acl->Get_Permissao_Url('comercio/Produto/Produtos_Edit');
            $perm_del = $this->_Registro->_Acl->Get_Permissao_Url('comercio/Produto/Produtos_Del');
            
            foreach ($produto as &$valor) {
                if($comercio_Produto_Cod){
                    $tabela['#Cod'][$i]      = '#'.$valor->cod;
                }
                if($comercio_marca===true){
                    if($comercio_Produto_Familia=='Familia'){
                        $tabela['Familia'][$i]   = $valor->familia2;
                    }else{
                        $tabela['Marca'][$i]     = $valor->marca2;
                        $tabela['Linha'][$i]     = $valor->linha2;
                    }
                }
                $tabela['Nome'][$i]      = $valor->nome;
        
                // Coloca Preco
                if(\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('comercio_Vendas')){
                    $tabela['Preço'][$i]   = $valor->preco;
                }
                
                if($comercio_Estoque){
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
                }
                $tabela['Funções'][$i]   .= $this->_Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Produto'        ,'comercio/Produto/Produtos_Edit/'.$valor->id.'/'    ,''),$perm_editar).
                                            $this->_Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Produto'       ,'comercio/Produto/Produtos_Del/'.$valor->id.'/'     ,'Deseja realmente deletar esse Produto ?'),$perm_del);
                ++$i;
            }
            $ordem = Array($ordem,'asc');
            if($export!==false){
                self::Export_Todos($export,$tabela, 'Comercio - Produtos');
            }else{
                $this->_Visual->Show_Tabela_DataTable($tabela,'',true,false,Array($ordem));
            }
            unset($tabela);
        }else{            
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhum Produto</font></b></center>');
        }*/
        // Table's primary key
        $primaryKey = 'id';
        
        
        $perm_editar = $this->_Registro->_Acl->Get_Permissao_Url('Seguranca/Senha/Senhas_Edit');
        $perm_del = $this->_Registro->_Acl->Get_Permissao_Url('Seguranca/Senha/Senhas_Del');
        $perm_status = $this->_Registro->_Acl->Get_Permissao_Url('Seguranca/Senha/Status');
        $perm_destaque = $this->_Registro->_Acl->Get_Permissao_Url('Seguranca/Senha/Destaque');
        
        if($perm_editar && $perm_del){
            $funcao = function( $d, $row ) {
                return Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Senha'        ,'Seguranca/Senha/Senhas_Edit/'.$d.'/'    ,''),true).
                       Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Senha'       ,'Seguranca/Senha/Senhas_Del/'.$d.'/'     ,'Deseja realmente deletar essa Senha ?'),true);
            };
        }else if($perm_editar){
            $funcao = function( $d, $row ) {
                return Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Senha'        ,'Seguranca/Senha/Senhas_Edit/'.$d.'/'    ,''),true);
            };
        }else if($perm_del){
            $funcao = function( $d, $row ) {
                return Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Senha'       ,'Seguranca/Senha/Senhas_Del/'.$d.'/'     ,'Deseja realmente deletar essa Senha ?'),true);
            };
        }else{
            $funcao = function( $d, $row ) {
                return '';
            };
        }
        
        if($perm_status){
            $funcao_status = function( $d, $row ) {
                
                if($d=='0'){
                    $nometipo = 'Ultrapassada';
                }
                else{
                    $nometipo = 'Em Uso';
                }
                return $nometipo;
            };
        }else{
            $funcao_status = function( $d, $row ) {
                
                if($d=='0'){
                    $nometipo = 'Ultrapassada';
                }
                else{
                    $nometipo = 'Em Uso';
                }
                return $nometipo;
            };
        }
        if($perm_destaque){
            $funcao_destaque = function( $d, $row ) {
                
                if($d=='0'){
                    $nometipo = 'Não Destaque';
                }
                else{
                    $nometipo = 'Destaque';
                }
                return $nometipo;
            };
        }else{
            $funcao_destaque = function( $d, $row ) {
                
                if($d=='0'){
                    $nometipo = 'Não Destaque';
                }
                else{
                    $nometipo = 'Destaque';
                }
                return $nometipo;
            };
        }

        $columns = array(
            array( 'db' => 'id', 'dt' => 0,
                'formatter' => function( $d, $row ) {
                    return '#'.$d;
                }),
            array( 'db' => 'categoria2',    'dt' => 1 ),
            array( 'db' => 'url',           'dt' => 2 ),
            array( 'db' => 'login',         'dt' => 3 ),
            array( 'db' => 'senha',         'dt' => 4 ),
            array( 'db' => 'destaque'    ,  'dt' => 5 ,
                'formatter' => $funcao_destaque),
            array( 'db' => 'status'      ,  'dt' => 6 ,
                'formatter' => $funcao_status,
                'search' => function( $search ) {
                    if(strpos(strtolower($url), strtolower($objeto->end))!=false){
                        
                    }
                    return '#'.$d;
                }),
            array( 'db' => 'log_date_add',  'dt' => 7 ),
            array( 'db' => 'id',            'dt' => 8,
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
            \Framework\Classes\Datatable::complex( $_GET, Framework\App\Registro::getInstacia()->_Conexao, 'Seguranca_Senha', $primaryKey, $columns, null,'status=1' )
        );
    }
}
?>