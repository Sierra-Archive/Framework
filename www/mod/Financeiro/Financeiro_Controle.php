<?php
class Financeiro_Controle extends \Framework\App\Controle
{
    /**
    * Construtor
    * 
    * @name __construct
    * @access public
    *
    * @uses \Framework\App\Visual::$menu
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 2.0
    */
    public function __construct(){
        // construct
        parent::__construct();
    } 
    
    static function Saldo_Carregar(&$modelo, &$Visual, $usuarioid){
        $registro = \Framework\App\Registro::getInstacia();
        $acl = $registro->_Acl;
        $html = '';
        if($usuarioid!=0 && $usuarioid!='' && isset($usuarioid)){
            // Mostra a Porrra Toda
            if($acl->logado_usuario->nome!=''){
                $html .= '<b>Nome:</b> '.$acl->logado_usuario->nome;
            }if($acl->logado_usuario->email!=''){
                $html .= '<br><b>Email:</b> '.$acl->logado_usuario->email;
            }if($acl->logado_usuario->cpf!=''){
                $html .= '<br><b>Cpf:</b> '.$acl->logado_usuario->cpf;
            }if($acl->logado_usuario->telefone!=''){
                $html .= '<br><b>Telefone:</b> '.$acl->logado_usuario->telefone;
            }if($acl->logado_usuario->celular!=''){
                $html .= '<br><b>Celular:</b> '.$acl->logado_usuario->celular;
            }
            // Se tiver saldo próprio Mostra
            if(\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('Financeiro_User_Saldo')){
                $saldo = Financeiro_Modelo::Carregar_Saldo($modelo, $usuarioid);
                if($saldo<0){
                    $saldo = '<p class="text-error">- R$ '.number_format(abs($saldo), 2, ',', '.').'</p>';
                }else{
                    $saldo = 'R$ '.number_format($saldo, 2, ',', '.');
                }
                $html .= '<hr>Saldo em conta: '.$saldo;
            }
            // Bloca Conteudo
            $Visual->Blocar($html);   
            $Visual->Bloco_Maior_CriaJanela('Meus Dados Básicos','',80);
            unset($valores); // LIMPA MEM�RIA
        }
    }
    /**
     * Movimentação Interna
     * @param type $motivo
     * @param type $motivoid
     * @param type $usuario
     * @param type $valor
     * @param type $vencimento
     * @param type $parcela
     * @return boolean
     */
    public static function FinanceiroInt($motivo,$motivoid,$entrada_motivo,$entrada_motivoid,$saida_motivo,$saida_motivoid,$valor,$vencimento,$parcela='0',$categoria=0,$forma=0,$condicao=0,$pago=0){
        $registro = \Framework\App\Registro::getInstacia();
        $_Modelo = $registro->_Modelo;
        $financeiro = new \Financeiro_Pagamento_Interno_DAO();
        $financeiro->categoria          = $categoria;
        $financeiro->motivo             = $motivo;
        $financeiro->motivoid           = $motivoid;
        $financeiro->entrada_motivo     = $entrada_motivo;
        $financeiro->entrada_motivoid   = $entrada_motivoid;
        $financeiro->saida_motivo       = $saida_motivo;
        $financeiro->saida_motivoid     = $saida_motivoid;
        $financeiro->valor              = $valor;
        $financeiro->dt_vencimento      = $vencimento;
        $financeiro->num_parcela        = $parcela;
        $financeiro->forma_pagar        = $forma;
        $financeiro->forma_condicao     = $condicao;
        $financeiro->pago     = $pago;
        $_Modelo->db->Sql_Inserir($financeiro);
        return true;
    }
    protected function Movimentacao_Interna($where=Array(),$tipo='Mini',$total=false,$endereco=''){
        if(is_array($where)){
            $where['pago']='0';
        }else if($where!==''){
            $where .= ' AND pago = 0';
        }else{
            $where = 'pago = 0';
        }
        // Valores Padroes
        $i = 0;
        $total_qnt = 0;
        $tabela = Array();
        
        // SElect
        $financeiros = $this->_Modelo->db->Sql_Select('Financeiro_Pagamento_Interno',$where);
        if($financeiros!==false && !empty($financeiros)){
            if(is_object($financeiros)) $financeiros = Array(0=>$financeiros);
            reset($financeiros);
            foreach ($financeiros as &$valor) {
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
                    $tabela['Parcela'][$i]                  = $parcela;
                    list(
                            $motivo,
                            $responsavel
                    )                                       = $chamar::Financeiro_Motivo_Exibir($valor->motivoid);
                    $tabela['Motivo'][$i]                   = $motivo;
                    $tabela['Responsável'][$i]              = $responsavel;
                    $tabela['Valor'][$i]                    = $valor->valor;                    
                    $tabela['Data do Vencimento'][$i]       = '<span id="financeirovenc'.$valor->id.'">'.$valor->dt_vencimento.'</span>';
                    $tabela['Funções'][$i]                  = //$this->_Visual->Tema_Elementos_Btn('Visualizar' ,Array('Visualizar'         ,'Financeiro/Pagamento/Financeiro_View/'.$valor->id.'/'    ,'')).
                                                              $this->_Visual->Tema_Elementos_Btn('Editar'          ,Array('Editar Vencimento'        ,'Financeiro/Pagamento/Financeiros_VencimentoEdit/'.$valor->id.'/'    ,'')).
                                                              $this->_Visual->Tema_Elementos_Btn(
                                                                'Personalizado',
                                                                Array(
                                                                    'Declarar Pago'        ,
                                                                    'Financeiro/Pagamento/Financeiros_Pagar/'.$valor->id.'/'.$endereco    ,
                                                                    '',
                                                                    'download',
                                                                    'inverse',
                                                                )
                                                            );
                    if($total!==false){
                        $total_qnt = $total_qnt + \Framework\App\Sistema_Funcoes::Tranf_Real_Float($valor->valor);
                    }
                    ++$i;
                }
            }
        }
        if($total!==false){
            return Array($tabela,$i,$total_qnt);
        }else{
            return Array($tabela,$i);
        }
    }
    protected function Movimentacao_Interna_Pago($where=Array(),$tipo='Mini',$total=false,$endereco=''){
        if(is_array($where)){
            $where['pago']='1';
        }else if($where!==''){
            $where .= ' AND pago = 1';
        }else{
            $where = 'pago = 1';
        }
        
        // Valores Padroes
        $i = 0;
        $tabela = Array();
        $total_qnt = 0;
        
        $financeiros = $this->_Modelo->db->Sql_Select('Financeiro_Pagamento_Interno',$where);
        if($financeiros!==false && !empty($financeiros)){
            if(is_object($financeiros)) $financeiros = Array(0=>$financeiros);
            reset($financeiros);
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
                    $tabela['Parcela'][$i]                  = $parcela;
                    list(
                            $motivo,
                            $responsavel
                    )                                       = $chamar::Financeiro_Motivo_Exibir($valor->motivoid);
                    $tabela['Motivo'][$i]                   = $motivo;
                    $tabela['Responsável'][$i]              = $responsavel;
                    $tabela['Valor'][$i]                    = $valor->valor;
                    //$tabela['Data do Vencimento'][$i]       = '<a href="'.URL_PATH.'Financeiro/Pagamento/Financeiros_VencimentoEdit/'.$valor->id.'" class="lajax" acao=""><span id="financeirovenc'.$valor->id.'">'.$valor->dt_vencimento.'</span></a>';
                    $tabela['Data do Vencimento'][$i]       = $valor->dt_vencimento;
                    $tabela['Funções'][$i]                  = $this->_Visual->Tema_Elementos_Btn('Visualizar' ,Array('Visualizar'         ,'Financeiro/Pagamento/Financeiro_View/'.$valor->id.'/'    ,'')).
                                                              $this->_Visual->Tema_Elementos_Btn(
                                                                'Personalizado',
                                                                Array(
                                                                    'Desfazer Pagamento'        ,
                                                                    'Financeiro/Pagamento/Financeiros_NaoPagar/'.$valor->id.'/'.$endereco    ,
                                                                    '',
                                                                    'download',
                                                                    'default',
                                                                )
                                                            );
                    if($total!==false){
                        $total_qnt = $total_qnt + \Framework\App\Sistema_Funcoes::Tranf_Real_Float($valor->valor);
                    }
                    ++$i;
                }
            }
        }
        if($total!==false){
            return Array($tabela,$i,$total_qnt);
        }else{
            return Array($tabela,$i);
        }
    }
}
?>
