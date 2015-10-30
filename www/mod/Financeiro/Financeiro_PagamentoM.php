<?php

class Financeiro_PagamentoModelo extends Financeiro_Modelo
{
    /**
     * __construct
     * 
     * @name __construct
     * @access public
     * 
     * @return void
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     * 
     */
    public function __construct() {
      parent::__construct();
    }
    public function Condicoes($forma=0) {
        
        $forma = (int) $forma;
        $i = 0;
        if ($forma===0) {
            $where      = NULL;
        } else {
            $where      = 'forma_pagar=\''.$forma.'\'';
        }
        
        
        // Table's primary key
        $primaryKey = 'id';
        $tabela = 'Financeiro_Pagamento_Forma_Condicao';
        
        $perm_editar = $this->_Registro->_Acl->Get_Permissao_Url('Financeiro/Pagamento/Condicoes_Edit');
        $perm_del = $this->_Registro->_Acl->Get_Permissao_Url('Financeiro/Pagamento/Condicoes_Del');
        
        if ($perm_editar && $perm_del) {
            $funcao = function( $d, $row ) {
                return Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Condição de Pagamento'        ,'Financeiro/Pagamento/Condicoes_Edit/'.$d.'/'    ,''),true).
                       Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Condição de Pagamento'       ,'Financeiro/Pagamento/Condicoes_Del/'.$d.'/'     ,'Deseja realmente deletar essa Condiçao de Pagamento ?'),true);
            };
        } else if ($perm_editar) {
            $funcao = function( $d, $row ) {
                return Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Condição de Pagamento'        ,'Financeiro/Pagamento/Condicoes_Edit/'.$d.'/'    ,''),true);
            };
        } else if ($perm_del) {
            $funcao = function( $d, $row ) {
                return Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Condição de Pagamento'       ,'Financeiro/Pagamento/Condicoes_Del/'.$d.'/'     ,'Deseja realmente deletar essa Condição de Pagamento ?'),true);
            };
        } else {
            $funcao = function( $d, $row ) {
                return '';
            };
        }
        
        $columns = array(
            //Forma de Pagamento
            array( 'db' => 'forma_pagar2', 'dt' => 0),
            //Nome
            array( 'db' => 'nome',    'dt' => 1 ),
            //Entrada
            array( 'db' => 'entrada',  'dt' => 2 ),
            //Qnt de Parcelas
            array( 'db' => 'parcelas', 'dt' => 3,
                'formatter' => function( $d, $row ) {
                    if ($d==1) {
                        return $d.' parcela';
                    } else {
                        return $d.' parcelas';
                    }
                }),
            // Funcoes
            array( 'db' => 'id',      'dt' => 4,
                'formatter' => $funcao)
        );

        echo json_encode(
            \Framework\Classes\Datatable::complex( $_GET, Framework\App\Registro::getInstacia()->_Conexao, $tabela, $primaryKey, $columns, null, $where )
        );
    }
    public function Formas() {
        
        // Table's primary key
        $primaryKey = 'id';
        $tabela = 'Financeiro_Pagamento_Forma';
        
        $perm_condicoes = $this->_Registro->_Acl->Get_Permissao_Url('Financeiro/Pagamento/Condicoes');
        $perm_editar = $this->_Registro->_Acl->Get_Permissao_Url('Financeiro/Pagamento/Formas_Edit');
        $perm_del = $this->_Registro->_Acl->Get_Permissao_Url('Financeiro/Pagamento/Formas_Del');
        
        $function = '';
        if ($perm_condicoes) {
            $function .= ' $html .= Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn(\'Visualizar\'     ,Array(\'Visualizar Condições de Pagamento\'        ,\'Financeiro/Pagamento/Condicoes/\'.$d.\'/\'    ,\'\'),true);';
        }
        if ($perm_editar) {
            $function .= ' $html .= Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn(\'Editar\'     ,Array(\'Editar Forma de Pagamento\'        ,\'Financeiro/Pagamento/Formas_Edit/\'.$d.\'/\'    ,\'\'),true);';
        }
        if ($perm_del) {
            $function .= ' $html .= Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn(\'Deletar\'    ,Array(\'Deletar Forma de Pagamento\'       ,\'Financeiro/Pagamento/Formas_Del/\'.$d.\'/\'     ,\'Deseja realmente deletar essa Forma de Pagamento ?\'),true);';
        }
        
        $columns = array();
        $numero = 0;
        $columns[] = array( 'db' => 'nome', 'dt' => $numero);  //'Nome';
        
        ++$numero;
        eval('$function = function( $d, $row ) { $html = \'\'; '.$function.' return $html; };');       
        $columns[] = array( 'db' => 'id',            'dt' => $numero,
            'formatter' => $function
        ); //'Funções';

        echo json_encode(
            \Framework\Classes\Datatable::complex( $_GET, Framework\App\Registro::getInstacia()->_Conexao, $tabela, $primaryKey, $columns, null )
        );
    }
    public function Pagar() {
        $where  = 'entrada_motivo=\'Servidor\' AND entrada_motivoid=\''.SRV_NAME_SQL.'\' AND pago = 0';
        $this->Movimentacao_Interna($where,'Mini');
    }
    public function Receber() {
        $where  = 'saida_motivo=\'Servidor\' AND saida_motivoid=\''.SRV_NAME_SQL.'\' AND pago = 0';
        $this->Movimentacao_Interna($where,'Mini');
    }
    public function Pago() {
        $where  = 'entrada_motivo=\'Servidor\' AND entrada_motivoid=\''.SRV_NAME_SQL.'\' AND pago = 1';
        $this->Movimentacao_Interna_Pago($where,'Mini');
    }
    public function Recebido() {
        $where  = 'saida_motivo=\'Servidor\' AND saida_motivoid=\''.SRV_NAME_SQL.'\' AND pago = 1';
        $this->Movimentacao_Interna_Pago($where,'Mini');
    }
}
?>