<?php
class Financeiro_Modelo extends \Framework\App\Modelo
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
    * @version 3.1.1
    */
    public function __construct(){
        parent::__construct();
    } /**
     * 
     * @global type $config
     * @param type $modelo
     * @param type $user
     * @param type $valor
     * @param type $positivo
     * @param type $motivo
     * @param type $motivoid
     * @param type $dt_vencimento
     * @param type $dt_pago
     */
    static function MovInt_Inserir(&$modelo,$user,$valor,$positivo,$motivo,$motivoid,$dt_vencimento,$dt_pago='0000-00-00 00:00:00'){
        GLOBAL $config;
        if($positivo==1){
            $Modelo->db->query('INSERT INTO '.MYSQL_FINANCEIRO_MOV_INT.' (saida_motivo,saida_motivoid,entrada_motivo,entrada_motivoid,valor,positivo,motivo,motivoid,dt_vencimento,log_date_add,dt_pago) VALUES (\'Servidor\',\''.SRV_NAME_SQL.'\',\'Usuario\',\''.$user.'\',\''.$valor.'\',\''.$positivo.'\',\''.$motivo.'\',\''.$motivoid.'\',\''.$dt_vencimento.'\',\''.APP_HORA.'\',\''.$dt_pago.'\')');
        }else{
            $Modelo->db->query('INSERT INTO '.MYSQL_FINANCEIRO_MOV_INT.' (entrada_motivo,entrada_motivoid,saida_motivo,saida_motivoid,valor,positivo,motivo,motivoid,dt_vencimento,log_date_add,dt_pago) VALUES (\'Servidor\',\''.SRV_NAME_SQL.'\',\'Usuario\',\''.$user.'\',\''.$valor.'\',\''.$positivo.'\',\''.$motivo.'\',\''.$motivoid.'\',\''.$dt_vencimento.'\',\''.APP_HORA.'\',\''.$dt_pago.'\')');
        }
    }
    /**
     *  Se tem debito devendo volta 1 se nao volta 0
     * @param type $motivo
     * @param type $usuarioid
     * @return int
     */
    static function MovInt_VerificaDebito(&$modelo,$usuarioid,$motivo){
        $i=0;
        $sql = $Modelo->db->query('
                SELECT motivoid
                FROM '.MYSQL_FINANCEIRO_MOV_INT.'
                WHERE deletado!=1 AND motivo = \''.$motivo.'\' AND saida_motivo = \'Usuario\' AND saida_motivoid = '.$usuarioid.' AND pago = 0 ORDER BY log_date_add DESC LIMIT 1');
        while($campo = $sql->fetch_object()){
            $i = $campo->motivoid;
        }
        return $i;
    }
    
    
    
    public function MovFin_Carregar(&$array,$usuarioid){
        $i = 0;
        // CONSULTA EXTERNOS E GANHOS EM CIMA DE OUTROS USUARIOS
        /*$sql = $this->db->query('SELECT * FROM (
                SELECT positivo, valor, obs, log_date_add
                FROM '.MYSQL_FINANCEIRO_MOV_EXT.'
                WHERE deletado!=1 AND user = '.$usuarioid.'
            UNION ALL
                SELECT positivo, valor, \'associado\' AS obs, log_date_add
                FROM '.MYSQL_FINANCEIRO_MOV_INT.'
                WHERE deletado!=1 AND user = '.$usuarioid.'
            )a
            ORDER BY log_date_add
        ');*/
        $sql = $this->db->query('SELECT * FROM (
                SELECT 1 as positivo, valor, obs, log_date_add
                FROM '.MYSQL_FINANCEIRO_MOV_INT.'
                WHERE deletado!=1 AND entrada_motivo = \'Usuario\' AND entrada_motivoid = '.$usuarioid.'
            UNION ALL
                SELECT 0 as positivo, valor, \'associado\' AS obs, log_date_add
                FROM '.MYSQL_FINANCEIRO_MOV_INT.'
                WHERE deletado!=1 AND saida_motivo = \'Usuario\' AND saida_motivoid = '.$usuarioid.'
            ) as U
            ORDER BY log_date_add
        ');
        while($campo = $sql->fetch_object()){
            $array[$i]['positivo'] = $campo->positivo;
            $array[$i]['valor'] = $campo->valor;
            $array[$i]['log_date_add'] = $campo->log_date_add;
            if($campo->motivo=='' || !isset($campo->motivo)){
                $array[$i]['nome'] = $campo->obs;
            }else{
                eval('$array[$i][\'nome\'] = '.$campo->motivo.'Modelo::Financeiro_Motivo_Exibir($campo->motivoid);');
            }
            ++$i;
        }
        return $i;
    }
    public function Dividas_Carregar(&$array,$usuarioid){
        GLOBAL $config;
        $usuarioid = (int) $usuarioid;
        if($usuarioid!=0 && $usuarioid!='' && isset($usuarioid) && is_int($usuarioid)){
            $valor = 0;
            // CONSULTA EXTERNOS E GANHOS EM CIMA DE OUTROS USUARIOS
            /*$sql = $this->db->query('SELECT * FROM (
                    SELECT positivo, valor, log_date_add
                    FROM '.MYSQL_FINANCEIRO_MOV_EXT.'
                    WHERE deletado!=1 AND user = '.$usuarioid.'
                UNION ALL
                    SELECT positivo, valor, log_date_add
                    FROM '.MYSQL_FINANCEIRO_MOV_INT.'
                    WHERE deletado!=1 AND user = '.$usuarioid.' AND positivo = 1
                )a
                ORDER BY log_date_add
            ');
            while($campo = $sql->fetch_object()){
                if($campo->positivo==1){
                    $valor = $valor + $campo->valor;
                }else{
                    $valor = $valor - $campo->valor;
                }
            }*/
            // CONSULTA SEUS GASTOS NO SISTEMA
            $i=0;
            /*$sql = $this->db->query('
                    SELECT id, valor, positivo, motivo, motivoid, dt_vencimento, dt_pago
                    FROM '.MYSQL_FINANCEIRO_MOV_INT.'
                    WHERE deletado!=1 AND user = '.$usuarioid.' AND positivo = 0 ORDER BY log_date_add');*/
            $sql = $this->db->query('
                    SELECT id, valor, positivo, motivo, motivoid, dt_vencimento, dt_pago
                    FROM '.MYSQL_FINANCEIRO_MOV_INT.'
                    WHERE deletado!=1 AND saida_motivo = \'Usuario\' AND saida_motivoid = '.$usuarioid.' ORDER BY pago,log_date_add');
            while($campo = $sql->fetch_object()){
                if($campo->pago==1){
                    $valor = $valor-$campo->valor;
                    $array[$i]['situacao'] = __('Pago');
                    if($campo->dt_pago=='0000-00-00 00:00:00'){
                        $this->db->query('UPDATE '.MYSQL_FINANCEIRO_MOV_INT.' SET dt_pago=\''.APP_HORA.'\' WHERE id='.$campo->id);
                        eval($campo->motivo.'Modelo::Financeiro($this,$usuarioid,$campo->motivoid);');
                    }
                }else{
                    $array[$i]['situacao'] = __('Pendente');
                }
                eval('$array[$i][\'nome\'] = '.$campo->motivo.'Modelo::Financeiro_Motivo_Exibir($campo->motivoid);');
                $array[$i]['valor'] = $campo->valor;
                $array[$i]['dt_vencimento'] = $campo->dt_vencimento;
                $array[$i]['dt_pago'] = $campo->dt_pago;
                ++$i;
            }
            return $i;
        }else{
            return 0;
        }
    }
    static function Carregar_Saldo($modelo,$usuarioid, $completo = false){
        // bloqueia se usuario nao existe
        if(!isset($usuarioid) || $usuarioid==0){
          return 0;
        }
        if(!is_int($usuarioid)) $usuarioid = (int) $usuarioid;
        $valor = 0;
        // CONSULTA EXTERNOS E GANHOS EM CIMA DE OUTROS USUARIOS
        /*$sql = $Modelo->db->query('SELECT * FROM (
                SELECT valor, log_date_add
                FROM '.MYSQL_FINANCEIRO_MOV_EXT.'
                WHERE deletado!=1 AND entrada_motivoid = '.$usuarioid.'
            UNION ALL
                SELECT positivo, valor, log_date_add
                FROM '.MYSQL_FINANCEIRO_MOV_INT.'
                WHERE deletado!=1 AND user = '.$usuarioid.'
            ) as U
            ORDER BY log_date_add
        ');*/
        $sql = $Modelo->db->query('SELECT U.valor, U.log_date_add, U.positivo FROM (
                SELECT G.valor, G.log_date_add, 0 as positivo
                FROM '.MYSQL_FINANCEIRO_MOV_INT.' as G
                WHERE G.deletado!=1 AND G.pago = \'0\' AND  G.entrada_motivo = \'Usuario\' AND G.entrada_motivoid = '.$usuarioid.'
            UNION ALL
                SELECT P.valor, P.log_date_add, 1 as positivo
                FROM '.MYSQL_FINANCEIRO_MOV_INT.' as P
                WHERE P.deletado!=1 AND P.pago = \'0\' AND P.saida_motivo = \'Usuario\' AND P.saida_motivoid = '.$usuarioid.'
            ) as U ORDER BY log_date_add
        ');
        while($campo = $sql->fetch_object()){
            if($campo->positivo=='1'){
                $valor = $valor + $campo->valor;
            }else{
                $valor = $valor - $campo->valor;
            }
        }
        if($completo===true){
            if($valor<0){
                $valor = '<font color="red">- R$ '.number_format($valor*-1, 2, ',', '.').'</font>';
            }else{
                $valor = 'R$ '.number_format($valor, 2, ',', '.');
            }
            return $valor;
        }else{
            return $valor;
        }
    }
    static function Financeiro(&$modelo,$usuarioid,$motivoid){
        /*$usuarioid = (int) $usuarioid;
        if(!isset($usuarioid) || !is_int($usuarioid) || $usuarioid==0) return 0;
        $Modelo->db->query('UPDATE '.MYSQL_USUARIOS.' SET nivel_usuario_pago=1 WHERE id='.$usuarioid);
        */return 1;
    }
    static function Financeiro_Motivo_Exibir($motivoid){
        /*$usuarioid = (int) $usuarioid;
        if(!isset($usuarioid) || !is_int($usuarioid) || $usuarioid==0) return 0;
        $Modelo->db->query('UPDATE '.MYSQL_USUARIOS.' SET nivel_usuario_pago=1 WHERE id='.$usuarioid);
        */
        $i = 0;
        $sql = $Modelo->db->query('SELECT nome
        FROM '.MYSQL_USUARIOS.' WHERE deletado!=1 AND id='.$motivoid.' ORDER BY nome limit 1'); //P.categoria
        while ($campo = $sql->fetch_object()) {
            $nome = $campo->nome;
            ++$i;
        }
        if($i==0) return 'Erro';
        return Array('Transferencia',$nome);
    }
    
    
    /**
     * Metodos de DAtaTable Dinamica
     */
    
    
    public function Movimentacao_Interna($where=false,$tipo='Mini',$total=false,$endereco=''){
        if(is_array($where)){
            $where['pago']='1';
        }else if($where!==''){
            $where .= ' AND {sigla}pago = 1';
        }else{
            $where = '{sigla}pago = 1';
        }
        
        // Valores Padroes
        $i = 0;
        $tabela = Array();
        $total_qnt = 0;
        
        $financeiros = $this->db->Sql_Select('Financeiro_Pagamento_Interno',$where,0,'','id,dt_vencimento,motivo,motivoid,valor,num_parcela');
        if($financeiros!==false && !empty($financeiros)){
            if(is_object($financeiros)) $financeiros = Array(0=>$financeiros);
            reset($financeiros);
            $perm_visualizar = $this->_Registro->_Acl->Get_Permissao_Url('Financeiro/Pagamento/Financeiro_View');
            $perm_naopagar = $this->_Registro->_Acl->Get_Permissao_Url('Financeiro/Pagamento/Financeiros_NaoPagar');
            
            foreach ($financeiros as &$valor) {
                if($valor->motivo==='') continue;
                //$tabela['#Id'][$i]       = '#'.$valor->id;
                // Chamar
                $chamar = $valor->motivo.'_Modelo';
                if(!class_exists($chamar)){
                    $chamar = $valor->motivo.'Modelo';
                }
                if(class_exists($chamar)){
                    if($valor->num_parcela!='0' && $valor->num_parcela!=0){
                        $parcela = $valor->num_parcela.'º parcela';
                    }else{
                        $parcela = 'Entrada/Unica';
                    }
                    $tabela['Parcela / Vencimento'][$i]     = $parcela. ' / '.$valor->dt_vencimento;
                    list(
                            $motivo,
                            $responsavel
                    )                                       = $chamar::Financeiro_Motivo_Exibir($valor->motivoid);
                    $tabela['Motivo'][$i]                   = $responsavel.' com '.$motivo;
                    $tabela['Valor'][$i]                    = $valor->valor;
                    //$tabela['Data do Vencimento'][$i]       = '<a href="'.URL_PATH.'Financeiro/Pagamento/Financeiros_VencimentoEdit/'.$valor->id.'" class="lajax" acao=""><span id="financeirovenc'.$valor->id.'">'.$valor->dt_vencimento.'</span></a>';
                    
                    $tabela['Funções'][$i]                  = $this->_Visual->Tema_Elementos_Btn('Visualizar' ,Array('Visualizar'         ,'Financeiro/Pagamento/Financeiro_View/'.$valor->id.'/'    ,''),$perm_visualizar).
                                                              $this->_Visual->Tema_Elementos_Btn(
                                                                'Personalizado',
                                                                Array(
                                                                    'Desfazer Pagamento'        ,
                                                                    'Financeiro/Pagamento/Financeiros_NaoPagar/'.$valor->id.'/'.$endereco    ,
                                                                    '',
                                                                    'download',
                                                                    'default',
                                                                ),
                                                                $perm_naopagar
                                                            );
                    if($total!==false){
                        $total_qnt = $total_qnt + \Framework\App\Sistema_Funcoes::Tranf_Real_Float($valor->valor);
                    }
                    ++$i;
                }
            }
        }
        // Table's primary key
        $primaryKey = 'id';
        $tabela = 'Comercio_Produto';
        
        
        $perm_view = $this->_Registro->_Acl->Get_Permissao_Url('comercio/Estoque/Estoques');
        $perm_reduzir = $this->_Registro->_Acl->Get_Permissao_Url('comercio/Produto/Estoque_Reduzir');
        $perm_editar = $this->_Registro->_Acl->Get_Permissao_Url('comercio/Produto/Produtos_Edit');
        $perm_del = $this->_Registro->_Acl->Get_Permissao_Url('comercio/Produto/Produtos_Del');
        
        $function = '';
        if($perm_editar){
            $function .= ' $html .= Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn(\'Editar\'     ,Array(\'Editar Produto\'        ,\'comercio/Produto/Produtos_Edit/\'.$d.\'/\'    ,\'\'),true);';
        }
        if($perm_del){
            $function .= ' $html .= Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn(\'Deletar\'    ,Array(\'Deletar Produto\'       ,\'comercio/Produto/Produtos_Del/\'.$d.\'/\'     ,\'Deseja realmente deletar essa Produto ?\'),true);';
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
            if($perm_view)      $function .= ' $html .= Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn(\'Visualizar\' ,Array(\'Visualizar Estoque\'    ,\'comercio/Estoque/Estoques/\'.$d.\'/\'    ,\'\'),true);';
            if($perm_reduzir)   $function .= ' $html .= Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn(\'Personalizado\'   ,Array(\'Reduzir Estoque\'  ,\'comercio/Produto/Estoque_Reduzir/\'.$d.\'/\'    ,\'\',\'long-arrow-down\',\'inverse\'),true);';
        }
        if($comercio_Unidade){
            ++$numero;
            $columns[] = array( 'db' => 'unidade2', 'dt' => $numero);  //'Unidade';
        }
        
        ++$numero;
        eval('$function = function( $d, $row ) { $html = \'\'; '.$function.' return $html; };');       
        $columns[] = array( 'db' => 'id',            'dt' => $numero,
            'formatter' => $function
        ); //'Funções';
                
        echo json_encode(
            \Framework\Classes\Datatable::complex( $_GET, Framework\App\Registro::getInstacia()->_Conexao, $tabela, $primaryKey, $columns, null)
        );
    }
}
?>