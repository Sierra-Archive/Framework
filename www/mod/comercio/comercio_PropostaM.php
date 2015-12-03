<?php

class comercio_PropostaModelo extends comercio_Modelo
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
    /**
     * 
     * @param type $Modelo
     * @param type $usuarioid
     * @param type $motivoid
     */
    static function Financeiro_Motivo_Exibir($motivoid) {
        $motivoid = (int) $motivoid;
        $Registro = &\Framework\App\Registro::getInstacia();
        $_Modelo = &$Registro->_Modelo;
        $proposta = $_Modelo->db->Sql_Select('Comercio_Proposta',Array('id'=>$motivoid),1);
        if ($proposta === false) return 'Proposta não Encontrada';
        return Array('Proposta: #'.$motivoid, $proposta->cliente2);
    }
    public function Propostas() {
        // Table's primary key
        $primaryKey = 'id';
        $table = 'Comercio_Produto';
        
        $perm_view = $this->_Registro->_Acl->Get_Permissao_Url('comercio/Estoque/Estoques');
        $perm_reduzir = $this->_Registro->_Acl->Get_Permissao_Url('comercio/Produto/Estoque_Reduzir');
        $permissionEdit = $this->_Registro->_Acl->Get_Permissao_Url('comercio/Produto/Produtos_Edit');
        $permissionDelete = $this->_Registro->_Acl->Get_Permissao_Url('comercio/Produto/Produtos_Del');
        
        $function = '';
        if ($permissionEdit) {
            $function .= ' $html .= Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn(\'Editar\'     ,Array(\'Editar Produto\'        ,\'comercio/Produto/Produtos_Edit/\'.$d.\'/\'    ,\'\'),true);';
        }
        if ($permissionDelete) {
            $function .= ' $html .= Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn(\'Deletar\'    ,Array(\'Deletar Produto\'       ,\'comercio/Produto/Produtos_Del/\'.$d.\'/\'     ,\'Deseja realmente deletar essa Produto ?\'),true);';
        }

        
        $comercio_Produto_Cod       = \Framework\App\Acl::Sistema_Modulos_Configs_Funcional('comercio_Produto_Cod');
        $comercio_Produto_Familia   = \Framework\App\Acl::Sistema_Modulos_Configs_Funcional('comercio_Produto_Familia');
        $comercio_Estoque           = \Framework\App\Acl::Sistema_Modulos_Configs_Funcional('comercio_Estoque');
        $comercio_Unidade           = \Framework\App\Acl::Sistema_Modulos_Configs_Funcional('comercio_Unidade');
        $comercio_marca             = \Framework\App\Acl::Sistema_Modulos_Configs_Funcional('comercio_Marca');

        $columns = Array();
        
        $numero = -1;

        if ($comercio_Produto_Cod) {
            ++$numero;
            $columns[] = array( 'db' => 'id', 'dt' => $numero,
                'formatter' => function( $d, $row ) {
                    return '#'.$d;
                }); //'#Cod';
        }
        if ($comercio_marca === true) {
            if ($comercio_Produto_Familia=='Familia') {
                ++$numero;
                $columns[] = array( 'db' => 'familia2', 'dt' => $numero); //'Familia';
            } else {
                ++$numero;
                $columns[] = array( 'db' => 'marca2', 'dt' => $numero); //'Marca';
                ++$numero;
                $columns[] = array( 'db' => 'linha2', 'dt' => $numero); //'Linha';
            }
        }
        ++$numero;
        $columns[] = array( 'db' => 'nome', 'dt' => $numero); //'Nome';

        // Coloca Preco
        if (\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('comercio_Vendas')) {
            ++$numero;
            $columns[] = array( 'db' => 'preco', 'dt' => $numero); //'Preço';
        }

        if ($comercio_Estoque) {
            ++$numero;
            
            $columns[] = array( 'db' => 'id', 'dt' => $numero,'formatter' => function( $d, $row ) { 
                $html = ''; 
                $html .= '<a class="lajax" data-acao="" href="'.URL_PATH.'comercio/Estoque/Estoques/'.$d.'">'.
                       ''.comercio_EstoqueControle::Estoque_Retorna($d); 
                return $html; 
            });  //'Estoque';
            if ($perm_view)      $function .= ' $html .= Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn(\'Visualizar\' ,Array(\'Visualizar Estoque\'    ,\'comercio/Estoque/Estoques/\'.$d.\'/\'    ,\'\'),true);';
            if ($perm_reduzir)   $function .= ' $html .= Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn(\'Personalizado\'   ,Array(\'Reduzir Estoque\'  ,\'comercio/Produto/Estoque_Reduzir/\'.$d.\'/\'    ,\'\',\'long-arrow-down\',\'inverse\'),true);';
        }
        if ($comercio_Unidade) {
            ++$numero;
            $columns[] = array( 'db' => 'unidade2', 'dt' => $numero);  //'Unidade';
        }
        
        ++$numero;
        eval('$function = function( $d, $row ) { $html = \'\'; '.$function.' return $html; };');       
        $columns[] = array( 'db' => 'id', 'dt' => $numero,
            'formatter' => $function
        ); //'Funções';

        echo json_encode(
            \Framework\Classes\Datatable::complex( $_GET, Framework\App\Registro::getInstacia()->_Conexao, $table, $primaryKey, $columns, null)
        );
    }
    public function Outros($tema='Propostas') {
        // Table's primary key
        $primaryKey = 'id';
        $table = 'Comercio_Proposta';
        
        if ($tema!='Propostas') {
            $where = 'status NOT IN (1, 2, \'1\', \'2\')';
        } else {
            $where = 'status IN (1, 2, \'1\', \'2\')';
        }
        
        $permView = $this->_Registro->_Acl->Get_Permissao_Url('comercio/Estoque/Estoques');
        $perm_Comment = $this->_Registro->_Acl->Get_Permissao_Url('comercio/Proposta/Propostas_Comentario');
        
        $function = '';
        /*$permissionEdit = $this->_Registro->_Acl->Get_Permissao_Url('comercio/Produto/Produtos_Edit');
        $permissionDelete = $this->_Registro->_Acl->Get_Permissao_Url('comercio/Produto/Produtos_Del');
        if ($permissionEdit) {
            $function .= ' $html .= Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn(\'Editar\'     ,Array(\'Editar Produto\'        ,\'comercio/Produto/Produtos_Edit/\'.$d.\'/\'    ,\'\'),true);';
        }
        if ($permissionDelete) {
            $function .= ' $html .= Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn(\'Deletar\'    ,Array(\'Deletar Produto\'       ,\'comercio/Produto/Produtos_Del/\'.$d.\'/\'     ,\'Deseja realmente deletar essa Produto ?\'),true);';
        }*/

        $columns = Array();
        $numero = -1;
        
        //Numero
        ++$numero;
        $columns[] = array( 
            'db' => 'id',
            'dt' => $numero,
            'formatter' => function( $d, $row ) {
                return '#'.$d;
            }
        );
        
        // Retira de Instalação
        if (\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('comercio_servicos_Instalacao') || !(\Framework\App\Sistema_Funcoes::Perm_Modulos('comercio_servicos'))) {
            //Numero
            ++$numero;
            $columns[] = array( 
                'db' => 'propostatipo',
                'dt' => $numero,
                'formatter' => function( $d, $row ) {
                    if ($d===1 || $d==='1') {
                        if (SQL_MAIUSCULO === true) {
                            return __('INSTALAÇÃO');
                        } else {
                            return __('Instalação');
                        }
                    } else {
                        if (SQL_MAIUSCULO === true) {
                            return __('SERVIÇO');
                        } else {
                            return __('Serviço');
                        }
                    }
                }
            );
        }
        

        // Cliente
        ++$numero;
        $columns[] = array( 
            'db' => 'cliente2',
            'dt' => $numero,
        );
        
        // Vendedor
        ++$numero;
        $columns[] = array( 
            'db' => 'cuidados2',
            'dt' => $numero
        );

  
        //'#Cod';
                
        if ($tema == 'Propostas') {
            // Pagamento
            ++$numero;
            $columns[] = array( 
                'db' => 'condicao_pagar2',
                'dt' => $numero,
                'formatter' => function( $d, $row ) {
                    return '#'.$d;
                }
            );
            /*    if (SQL_MAIUSCULO === true) {
                        $pagamento = $valor->condicao_pagar2.' EM '.$valor->forma_pagar2;
                    } else {
                        $pagamento = $valor->condicao_pagar2.' em '.$valor->forma_pagar2;
                    }
                    $table[__('Pagamento')][$i]                    =  $pagamento;*/
                
            if (\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('comercio_Proposta_Lucro')) {
                $table[__('Lucro')][$i]                        =  $valor->pagar_lucro;
                // Pagamento
                ++$numero;
                $columns[] = array( 
                    'db' => 'condicao_pagar2',
                    'dt' => $numero,
                    'formatter' => function( $d, $row ) {
                        return '#'.$d;
                    }
                );
            }
            
            // Desconto
            ++$numero;
            $columns[] = array( 
                'db' => 'pagar_desconto',
                'dt' => $numero
            );
            
            // Valor Total
            ++$numero;
            $columns[] = array( 
                'db' => 'valor',
                'dt' => $numero
            );
        }


        // Status
        ++$numero;
        $columns[] = array( 
            'db' => 'valor',
            'dt' => $numero,
            'formatter' => function( $d, $row ) use ($tema) {
                return '<span class="status'.$row['id'].'">'.
                    self::label($row, $tema,($tema!='Propostas' && $d=='3'?true:false)).
                    '</span>';
            }
        );     
        
        // Criado
        ++$numero;
        $columns[] = array( 
            'db' => 'log_date_add',
            'dt' => $numero
        );    
        
        // Ult. Alteração
        ++$numero;
        $columns[] = array( 
            'db' => 'log_date_edit',
            'dt' => $numero
        );     
        
     
        if ($permView){
            $function .= ' $html .= Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn(\'Visualizar\' ,Array(\'Visualizar \'.$titulo    ,\'comercio/Proposta/Propostas_View/\'.$d.\'/\'    ,\'\'),true);';
        }
        if ($permComment){
            $function .= ' $html .= Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn(\'Personalizado\'   ,Array(\'Histórico da \'.$titulo  ,\'comercio/Proposta/Propostas_Comentario/\'.$d.\'/\'    ,\'\',\'file\',\'inverse\'),true);';
        }

        
        ++$numero;
        eval('$function = function( $d, $row ) { $html = \'\'; '.$function.' return $html; };');       
        $columns[] = array( 'db' => 'id', 'dt' => $numero,
            'formatter' => $function
        ); //'Funções';

        echo json_encode(
            \Framework\Classes\Datatable::complex(
                $_GET,
                Framework\App\Registro::getInstacia()->_Conexao,
                $table,
                $primaryKey,
                $columns,
                null,
                $where
            )
        );
    }
    
    public function propostasStatus($proposta) {
        // Table's primary key
        $primaryKey = 'id';
        $table = 'Comercio_Proposta_Status';
        $where = 'id = \''.( (int) $proposta ).'\'';

        $columns = Array();
        
        $numero = -1;

        //Status
        ++$numero;
        $columns[] = array(
            'db' => 'status',
            'dt' => $numero,
            'formatter' => function( $d, $row ) {
                if ($d=='0') {
                    return __('Pendente');
                } else if ($d=='1') {
                    return __('Aprovada');
                } else if ($d=='2') {
                    return __('Aprovada em Execução');
                } else if ($d=='3') {
                    return 'Finalizada';
                } else {
                    return __('Recusada');
                }
            }
        );

        //Data
        ++$numero;
        $columns[] = array( 'db' => 'log_date_add', 'dt' => $numero);

        echo json_encode(
            \Framework\Classes\Datatable::complex(
                $_GET,
                Framework\App\Registro::getInstacia()->_Conexao,
                $table,
                $primaryKey,
                $columns,
                null,
                $where
            )
        );
    }
}
?>