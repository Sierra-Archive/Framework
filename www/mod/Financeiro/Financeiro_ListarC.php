<?php
/**
 * SERVE PARA CONTROLE ENTRE USUARIOS...
 * 
 * TRANSFERIR QUANTIAS PARA OUTROS USUARIOS, PEDIR O SAQUE DO SEU DINHEIRO.
 * DEPOSITAR QUANTIAS>>> etc...
 * 
 * 
 * Condicoes:
 * -> COnfig Funcional -> Financeiro_User_Saldo = true
 */




class Financeiro_ListarControle extends Financeiro_Controle
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
    * Função Main, Principal
    * 
    * @name Main
    * @access public
     * 
    * @return void 
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 0.4.2
    */
    public function Main() {
        Financeiro_Controle::Saldo_Carregar($this->_Modelo, $this->_Visual, $this->_Acl->Usuario_GetID());
        $this->Listar_Dividas();
        $this->Listar_MovimentacaoFin();
        $this->sacar_carregajanelaadd();
        $this->transferencia_carregajanelaadd();
        // ORGANIZA E MANDA CONTEUDO
        $this->_Visual->Json_Info_Update('Titulo', __('Dividas a Pagar'));
    }
    
    
    
    
    
    public function Listar_MovimentacaoFin() {
        $movimentacoes = Array();
        $this->_Modelo->MovFin_Carregar($movimentacoes,  $this->_Acl->Usuario_GetID());
        if (!empty($movimentacoes)) {
            reset($movimentacoes);
            $i = 0;
            foreach ($movimentacoes as $indice=>&$valor) {
                $table['Referência'][$i] = $valor['nome'];
                $table['Data'][$i] = date_replace($valor['log_date_add'], "d/m/y | H:m");
                if ($valor['positivo']==1) {
                    $table['Valor'][$i] = '<font color="#0000FF">+ R$ '.number_format($valor['valor'], 2, ', ', '.').'</font>';
                } else {
                    $table['Valor'][$i] = '<font color="#FF0000">- RR$$ '.number_format($valor['valor'], 2, ', ', '.').'</font>';
                }
                ++$i;
            }
            $this->_Visual->Show_Tabela_DataTable($table);
            $this->_Visual->Bloco_Maior_CriaJanela('Todas as Atividades Financeiras ('.$i.')');
            unset($table);
        } else {          
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">Infelizmente você nunca movimentou dinheiro com a gente.</font></b></center>');
            $this->_Visual->Bloco_Maior_CriaJanela('Todas as Atividades Financeiras (0)');
        }
    }
    public function Listar_Dividas() {
        $movimentacoes = Array();
        $this->_Modelo->Dividas_Carregar($movimentacoes,  $this->_Acl->Usuario_GetID());
        if (!empty($movimentacoes)) {
            reset($movimentacoes);
            $i = 0;
            foreach ($movimentacoes as $indice=>&$valor) {
                $table['Referência'][$i] = $valor['nome'];
                $table['Situação'][$i] = $valor['situacao'];
                $table['Data Venc'][$i] = date_replace($valor['dt_vencimento'], "d/m/y");
                $table['Data Pgto'][$i] = date_replace($valor['dt_pago'], "d/m/y");
                $table['Valor'][$i] = $valor['valor'];
                if ($valor['situacao']!='Pago') {
                    $table['Boleto'][$i] = '<a href="'.LIBS_URL.'boleto/boleto_itau.php?clientenome='.$this->_Acl->logado_usuario->nome.
                    '&endereco='.$this->_Acl->logado_usuario->endereco.
                    '&numero='.$this->_Acl->logado_usuario->numero.
                    '&complemento='.$this->_Acl->logado_usuario->complemento.
                    '&cpf='.$this->_Acl->logado_usuario->cpf.
                    '&cidade='.$this->_Acl->logado_usuario->cidade.
                    '&bairro='.$this->_Acl->logado_usuario->bairro.
                    '&cep='.$this->_Acl->logado_usuario->cep.
                    '&valor='.$valor['valor'].'" target="_BLANK">Abrir Boleto</a>';
                } else {
                    $table['Boleto'][$i] = '';
                }
                ++$i;
            }
            $this->_Visual->Show_Tabela_DataTable($table);
            $this->_Visual->Bloco_Maior_CriaJanela('Pagamentos ('.$i.')');
            unset($table);
        } else {  
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">Infelizmente você nunca fez um pagamento com a gente.</font></b></center>');
            $this->_Visual->Bloco_Maior_CriaJanela('Pagamentos (0)');
        }
    }
    
    function sacar_carregajanelaadd() {
        // cadastro de marcas
        $formulario = Financeiro_ListarControle::sacar_formcadastro();
        $this->_Visual->Blocar($formulario);
        $this->_Visual->Bloco_Menor_CriaJanela(__('Realizar Saque'));
        
    }
    static function sacar_formcadastro() {
        $form = new \Framework\Classes\Form('financeiro_sacar_form', 'Financeiro/Listar/sacar_inserir/', 'formajax');
        $form->Input_Novo(__('Quantia a Sacar (Em Reais)'),'sacar_quantia', '', 'text', 30, 'obrigatorio', '', FALSE, '', '', 'Numero', '', FALSE);
        
        $formulario = $form->retorna_form('Realizar Saque');

        return $formulario;
    }
    /**
     * Inserir Saque
     * @global type $config
     * 
     * #update
     */
    public function sacar_inserir() {
        global $config;
        
        if (!isset($_POST["sacar_quantia"])) {
            return FALSE;
        }
        
        // Para verificar erro
        $erro = 1;
        // Carrega quantia e saldo do usuario
        $quantia = \Framework\App\Conexao::anti_injection($_POST["sacar_quantia"]);
        $saldo = Financeiro_Modelo::Carregar_Saldo($this->_Modelo, $this->_Acl->Usuario_GetID());
        // faz verificações de erros
        if ($quantia<500) {
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => 'Saque Minimo: R$ 500,00'
            );
            $this->_Visual->Json_IncluiTipo('Mensagens', $mensagens); 
            $this->_Visual->Javascript_Executar('$("#quantia").css(\'border\', \'2px solid #FFAEB0\').focus();');
        } else if ($saldo<$quantia) {
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Saldo Insuficiente')
            );
            $this->_Visual->Json_IncluiTipo('Mensagens', $mensagens); 
            $this->_Visual->Javascript_Executar('$("#quantia").css(\'border\', \'2px solid #FFAEB0\').focus();');
        } else {
            $sucesso =  $this->_Modelo->sacar_inserir($quantia);
            // mostra mensagem de sucesso
            if ($sucesso === TRUE) {
                $mgm = 'Usuario Realizou um saque no sistema, com saldo suficiente e ja descontado de seu saldo<br>'.
                        '<br><br>#Id: #'.$this->_Acl->Usuario_GetID().
                        '<br>Nome: '.$this->_Acl->logado_usuario->nome.
                        '<br>Email: '.$this->_Acl->logado_usuario->email.
                        '<br>Valor do Saque: R$'.$quantia.
                        '<br>Saldo Restante do Usuario: R$'.($saldo-$quantia);
                $mgm .= '<br>Datetime: '.APP_HORA;
                $email = Mail_Send($this->_Acl->logado_usuario->nome, $this->_Acl->logado_usuario->email,SISTEMA_EMAIL,SISTEMA_NOME.' - Saque de Usuario do Sistema', $mgm);
                if ($email==1) {
                    $mensagens = array(
                        "tipo" => 'sucesso',
                        "mgs_principal" => __('Saque realizado com sucesso.'),
                        "mgs_secundaria" => 'Espere a quantia entrar na sua conta: R$'.$quantia.',00.'
                    );
                    $erro=0;
                } else {
                    $mensagens = array(
                        "tipo" => 'sucesso',
                        "mgs_principal" => __('Informe a Administração'),
                        "mgs_secundaria" => 'do sistema que houve um erro ao fazer o saque. R$'.$quantia.',00.'
                    );
                }
            } else {
                $mensagens = array(
                    "tipo" => 'erro',
                    "mgs_principal" => __('Erro'),
                    "mgs_secundaria" => __('Erro')
                );
            }
            $this->_Visual->Json_IncluiTipo('Mensagens', $mensagens);
        }
        $this->Main();
        if ($erro==0) $this->_Visual->Json_Info_Update('Titulo', __('Saque Realizado com Sucesso'));
        else         $this->_Visual->Json_Info_Update('Titulo', __('Erro ao Realizar Saque'));
    }
    function transferencia_carregajanelaadd() {
        // cadastro de marcas
        $formulario = Financeiro_ListarControle::transferencia_formcadastro();
        $this->_Visual->Blocar($formulario);
        $this->_Visual->Bloco_Menor_CriaJanela(__('Transferir Quantia'));
        
    }
    static function transferencia_formcadastro() {
        $form = new \Framework\Classes\Form('financeiro_transferencia_form', 'Financeiro/Listar/transferencia_inserir/', 'formajax');
        $form->Input_Novo('Login do Usuario', 'login', '', 'text', 30, 'obrigatorio');
        $form->Input_Novo('Quantia a Transferir (Em Reais)', 'transferir_quantia', '', 'text', 30, 'obrigatorio', '', FALSE, '', '', 'Numero', '', FALSE);
        
        $formulario = $form->retorna_form('Transferir Quantia');

        return $formulario;
    }
    public function transferencia_inserir() {
        if (!isset($_POST["login"]) || !isset($_POST["transferir_quantia"])) {
            return FALSE;
        }
        $erro = 1;
        // captura variaveis
        $login = \Framework\App\Conexao::anti_injection($_POST["login"]);
        $quantia = \Framework\App\Conexao::anti_injection($_POST["transferir_quantia"]);
        // carrega saldo e verifica se login existe
        $saldo = Financeiro_Modelo::Carregar_Saldo($this->_Modelo, $this->_Acl->Usuario_GetID());
        $existelogin = usuario_Modelo::VerificaExtLogin($this->_Modelo, $login);
        // verifica erros
        if ($quantia<50) {
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => 'Transferência Minima: R$ 50,00'
            );
            $this->_Visual->Json_IncluiTipo('Mensagens', $mensagens); 
            $this->_Visual->Javascript_Executar('$("#quantia").css(\'border\', \'2px solid #FFAEB0\').focus();');
        } else if ($saldo<$quantia) {
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Saldo Insuficiente')
            );
            $this->_Visual->Json_IncluiTipo('Mensagens', $mensagens); 
            $this->_Visual->Javascript_Executar('$("#quantia").css(\'border\', \'2px solid #FFAEB0\').focus();');
        } else if ($existelogin === FALSE) {
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Login não existe')
            );
            $this->_Visual->Json_IncluiTipo('Mensagens', $mensagens); 
            $this->_Visual->Javascript_Executar('$("#login").css(\'border\', \'2px solid #FFAEB0\').focus();');
        } else {
            $sucesso =  $this->_Modelo->transferencia_inserir($login, $quantia);
            // mostra mensagem de sucesso
            if ($sucesso === TRUE) {
                $mensagens = array(
                    "tipo" => 'sucesso',
                    "mgs_principal" => __('Transferência Realizada'),
                    "mgs_secundaria" => ''.$quantia.' foi transferida com sucesso.'
                );
                $erro = 0;
            } else {
                $mensagens = array(
                    "tipo" => 'erro',
                    "mgs_principal" => __('Erro'),
                    "mgs_secundaria" => __('Erro')
                );
            }
            $this->_Visual->Json_IncluiTipo('Mensagens', $mensagens);
        }
        
        $this->Main();
        if ($erro==0) $this->_Visual->Json_Info_Update('Titulo', __('Transferência Realizada com Sucesso'));
        else         $this->_Visual->Json_Info_Update('Titulo', __('Erro ao Realizar Transferência'));
    }
}

