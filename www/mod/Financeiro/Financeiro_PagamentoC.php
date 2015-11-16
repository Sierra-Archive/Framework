<?php
class Financeiro_PagamentoControle extends Financeiro_Controle
{
    /**
     * 
     * Classe Para Ver oq Foi pago e oq precisa pagar no sistema
     * 
    * Construtor
    * 
    * @name __construct
    * @access public
    * 
    * @uses financeiro_ListarModelo Carrega financeiro Modelo
    * @uses financeiro_ListarVisual Carrega financeiro Visual
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 0.4.2
    */
    public function __construct() {
        parent::__construct();
    }
    static function Endereco_Financeiro($true= TRUE ) {
        $Registro = &\Framework\App\Registro::getInstacia();
        $_Controle = $Registro->_Controle;
        $titulo = __('Financeiro');
        $link = '_Sistema/Principal/Home';
        if ($true === TRUE) {
            $_Controle->Tema_Endereco($titulo, $link);
        } else {
            $_Controle->Tema_Endereco($titulo);
        }
    }
    static function Endereco_Pagar($true= TRUE ) {
        self::Endereco_Financeiro();
        $Registro = &\Framework\App\Registro::getInstacia();
        $_Controle = $Registro->_Controle;
        $titulo = __('À Pagar');
        $link = 'Financeiro/Pagamento/Pagar';
        if ($true === TRUE) {
            $_Controle->Tema_Endereco($titulo, $link);
        } else {
            $_Controle->Tema_Endereco($titulo);
        }
    }
    static function Endereco_Receber($true= TRUE ) {
        self::Endereco_Financeiro();
        $Registro = &\Framework\App\Registro::getInstacia();
        $_Controle = $Registro->_Controle;
        $titulo = __('À Receber');
        $link = 'Financeiro/Pagamento/Receber';
        if ($true === TRUE) {
            $_Controle->Tema_Endereco($titulo, $link);
        } else {
            $_Controle->Tema_Endereco($titulo);
        }
    }
    static function Endereco_Pago($true= TRUE ) {
        self::Endereco_Financeiro();
        $Registro = &\Framework\App\Registro::getInstacia();
        $_Controle = $Registro->_Controle;
        $titulo = __('Pagas');
        $link = 'Financeiro/Pagamento/Pago';
        if ($true === TRUE) {
            $_Controle->Tema_Endereco($titulo, $link);
        } else {
            $_Controle->Tema_Endereco($titulo);
        }
    }
    static function Endereco_Recebido($true= TRUE ) {
        self::Endereco_Financeiro();
        $Registro = &\Framework\App\Registro::getInstacia();
        $_Controle = $Registro->_Controle;
        $titulo = __('Recebidos');
        $link = 'Financeiro/Pagamento/Recebido';
        if ($true === TRUE) {
            $_Controle->Tema_Endereco($titulo, $link);
        } else {
            $_Controle->Tema_Endereco($titulo);
        }
    }
    static function Endereco_Forma($true= TRUE ) {
        self::Endereco_Financeiro();
        $Registro = &\Framework\App\Registro::getInstacia();
        $_Controle = $Registro->_Controle;
        $titulo = __('Forma de Pagamento');
        $link = 'Financeiro/Pagamento/Formas';
        if ($true === TRUE) {
            $_Controle->Tema_Endereco($titulo, $link);
        } else {
            $_Controle->Tema_Endereco($titulo);
        }
    }
    static function Endereco_Forma_Condicao($true= TRUE, $forma = 0) {
        self::Endereco_Forma();
        $Registro = &\Framework\App\Registro::getInstacia();
        $_Controle = $Registro->_Controle;
        $titulo = __('Condições de Pagamento');
        $link = 'Financeiro/Pagamento/Condicoes';
        if (is_object($forma)) {
            $titulo = $titulo.' em '.$forma->nome;
            $link = $link.'/'.$forma->id;
        }
        if ($true === TRUE) {
            $_Controle->Tema_Endereco($titulo, $link);
        } else {
            $_Controle->Tema_Endereco($titulo);
        }
    }
    /**
    * Main
    * 
    * @name Main
    * @access public
    * 
    * @uses Financeiro_Controle::$financeiroPerfil
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 0.4.2
    */
    public function Main() {
        $this->Formas();
        // ORGANIZA E MANDA CONTEUDO
        $this->_Visual->Json_Info_Update('Titulo', __('Formas de Pagamento')); 
    }
    /**
     * Contas a Pagar
     */
    public function Pagar() {
        self::Endereco_Pagar(FALSE);
        
        // Parametros
        $titulo = __('Listagem de Contas à pagar');
        /*$where  = Array(
            'entrada_motivo'     => 'Servidor',
            'entrada_motivoid'   => SRV_NAME_SQL,
        );
        list($tabela, $i) = $this->Movimentacao_Interna($where,'Mini');*/
        
        $tabela = Array(
            __('Id'),__('Parcela'),__('Motivo'),__('Valor'),__('Vencimento'),__('Funções')
        );
        $this->_Visual->Show_Tabela_DataTable_Massiva($tabela,'Financeiro/Pagamento/Pagar');
        $titulo = __('Listagem de Contas à pagar').' (<span id="DataTable_Contador">0</span>)';  //
        $this->_Visual->Bloco_Unico_CriaJanela($titulo, '',10);
        
        
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', $titulo); 
    }
    /**
     * Contas a Receber
     */
    public function Receber($export = FALSE) {
        self::Endereco_Receber(FALSE);
        
        // Exportar
        $this->_Visual->Blocar($this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            FALSE,
            Array(
                'Print'     => TRUE,
                'Pdf'       => TRUE,
                'Excel'     => TRUE,
                'Link'      => 'Financeiro/Pagamento/Receber',
            )
        )));
        
        $titulo = __('Listagem de Contas à Receber');
        $where  = Array(
            'saida_motivo'     => 'Servidor',
            'saida_motivoid'   => SRV_NAME_SQL,
        );
        
        list($tabela, $i) = $this->Movimentacao_Interna($where,'Mini');
        $titulo = $titulo.' ('.$i.')';
        if ($i==0 ) {
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhuma Conta à Receber</font></b></center>');
        } else {
            if ($export !== FALSE) {
                self::Export_Todos($export, $tabela, 'Contas à Receber');
            } else {
                $this->_Visual->Show_Tabela_DataTable($tabela);
            }
            unset($tabela);
        }
        $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        $this->_Visual->Json_Info_Update('Titulo', $titulo); 
    }
    public function Pago($export = FALSE) {
        self::Endereco_Pago(FALSE);
        
        // Exportar
        $this->_Visual->Blocar($this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            FALSE,
            Array(
                'Print'     => TRUE,
                'Pdf'       => TRUE,
                'Excel'     => TRUE,
                'Link'      => 'Financeiro/Pagamento/Pago',
            )
        )));
        
        // Parametros
        $titulo = __('Listagem de Contas Pagas');
        $where  = Array(
            'entrada_motivo'     => 'Servidor',
            'entrada_motivoid'   => SRV_NAME_SQL,
        );
        list($tabela, $i) = $this->Movimentacao_Interna_Pago($where,'Mini');
        $titulo = $titulo.' ('.$i.')';
        if ($i==0) {          
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhuma Conta Paga</font></b></center>');
        } else {
            if ($export !== FALSE) {
                self::Export_Todos($export, $tabela, 'Contas Pagas');
            } else {
                $this->_Visual->Show_Tabela_DataTable($tabela);
            }
            unset($tabela);
        }
        $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        $this->_Visual->Json_Info_Update('Titulo', $titulo); 
    }
    /**
     * Contas a Receber
     */
    public function Recebido($export = FALSE) {
        self::Endereco_Recebido(FALSE);
        
        // Exportar
        $this->_Visual->Blocar($this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            FALSE,
            Array(
                'Print'     => TRUE,
                'Pdf'       => TRUE,
                'Excel'     => TRUE,
                'Link'      => 'Financeiro/Pagamento/Recebido',
            )
        )));
        
        $titulo = __('Listagem de Contas Recebidas');
        $where  = Array(
            'saida_motivo'     => 'Servidor',
            'saida_motivoid'   => SRV_NAME_SQL,
        );
        
        list($tabela, $i) = $this->Movimentacao_Interna_Pago($where,'Mini');
        $titulo = $titulo.' ('.$i.')';
        if ($i==0 ) {
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhuma Conta Recebida</font></b></center>');
        } else {
            if ($export !== FALSE) {
                self::Export_Todos($export, $tabela, 'Contas Recebidas');
            } else {
                $this->_Visual->Show_Tabela_DataTable($tabela);
            }
            unset($tabela);
        }
        $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        $this->_Visual->Json_Info_Update('Titulo', $titulo); 
    }
    
    static function Financeiros_Campos_Retirar(&$campos) {
        //self::DAO_Campos_Retira($campos, 'dt_pago');
        
        self::DAO_Campos_Retira($campos, 'categoria');
        self::DAO_Campos_Retira($campos, 'pago');
        self::DAO_Campos_Retira($campos, 'motivo');
        self::DAO_Campos_Retira($campos, 'motivoid');
        self::DAO_Campos_Retira($campos, 'entrada_motivo');
        self::DAO_Campos_Retira($campos, 'entrada_motivoid');
        self::DAO_Campos_Retira($campos, 'saida_motivo');
        self::DAO_Campos_Retira($campos, 'saida_motivoid');
        self::DAO_Campos_Retira($campos, 'forma_pagar');
        self::DAO_Campos_Retira($campos, 'forma_condicao');
        self::mysql_MudaLeitura($campos, Array('valor', 'dt_vencimento', 'num_parcela'));
        return TRUE;
    }
    /**
     * Altera Pagamento pra Pago ou pra Nao pago !
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    static function Financeiro_Pagamento($motivo, $motivo_id, $pago) {
        // Carrega Modelo
        $Registro = &\Framework\App\Registro::getInstacia();
        $_Modelo = &$Registro->_Modelo;
        // Prepara Update ClasseDAO|SET|WHERE
        $string = 'Financeiro_Pagamento_Interno|pago=\''.$pago.'\'| motivo=\''.$motivo.'\' AND motivoid=\''.$motivo_id.'\'';
        $_Modelo->db->Sql_Update($string);
    }
    public function Financeiros_NaoPagar($id = FALSE, $localizacao = FALSE, $dataini = FALSE, $datafin = FALSE) {
        // Verifica Existencia
        if ($id === FALSE) {
            return _Sistema_erroControle::Erro_Fluxo('Financeiro não especificado: '.$id,404);
        }
        $where = Array('id'=>  $id);
        $financeiros = $this->_Modelo->db->Sql_Select('Financeiro_Pagamento_Interno', $where);
        if ($financeiros === FALSE) {
            return _Sistema_erroControle::Erro_Fluxo('Financeiro não existe: '.$id,404);
        }
        if ($financeiros->saida_motivo==='Servidor' && $financeiros->saida_motivoid===SRV_NAME_SQL) {
            $pago = __('Recebido');
        } else {
            $pago = __('Pago');
        }
        // Captura Valores
        //$valor_juros    = \Framework\App\Sistema_Funcoes::Tranf_Real_Float(\Framework\App\Conexao::anti_injection($_POST['valor_juros']));
        //$dt_pago        = \Framework\App\Conexao::anti_injection($_POST['dt_pago']);
        //$forma_pagar    = (int) $_POST['forma_pagar'];
        //$obs            = \Framework\App\Conexao::anti_injection($_POST['obs']);
        // Mensagens
        $titulo     = 'Declarado não '.$pago.' com Sucesso';
        $dao        = Array('Financeiro_Pagamento_Interno', $id);
        $sucesso1   = $titulo;
        $sucesso2   = __('Voltou a não estar pago com sucesso.');
        // Altera Valores Manualmente e grava
        $financeiros->valor = \Framework\App\Sistema_Funcoes::Tranf_Float_Real(\Framework\App\Sistema_Funcoes::Tranf_Real_Float($financeiros->valor)-\Framework\App\Sistema_Funcoes::Tranf_Real_Float($financeiros->valor_juros));
        $financeiros->pago = '0';

        $sucesso = $this->_Modelo->db->Sql_Update($financeiros);
        if ($sucesso) {
            $mensagens = array(
                "tipo"              => 'sucesso',
                "mgs_principal"     => $sucesso1,
                "mgs_secundaria"    => $sucesso2
            ); 
            $this->_Visual->Json_Info_Update('Titulo', $titulo);
            // SE vier do Relatorio, volta pra la
            if ($localizacao !== FALSE) {
                \Framework\App\Sistema_Funcoes::Redirect(URL_PATH.'Financeiro/Relatorio/Relatorio/'.$localizacao.'/'.$dataini.'/'.$datafin);
            } else if ($financeiros->saida_motivo==='Servidor' && $financeiros->saida_motivoid===SRV_NAME_SQL) {
                $this->Receber();
            } else {
                $this->Pagar();
            }
        } else {
            $mensagens = array(
                "tipo"              => 'erro',
                "mgs_principal"     => __('Ocorreu um Erro'),
                "mgs_secundaria"    => __('Tente Novamente, algo deu errado.')
            );
            $this->_Visual->Json_Info_Update('Titulo', __('Erro'));
        }
        $this->_Visual->Json_IncluiTipo('Mensagens', $mensagens);
        $this->_Visual->Json_Info_Update('Historico', FALSE);
        $this->layoult_zerar = FALSE;
    }
    public function Financeiros_Pagar($id = FALSE, $localizacao = FALSE, $dataini = FALSE, $datafin = FALSE) {
        // Faz Protecao, e Linguagem apropriada
        if ($id === FALSE) {
            return _Sistema_erroControle::Erro_Fluxo('Financeiro não especificado: '.$id,404);
        }
        $where = Array('id'=>  $id, 'pago'=>'0');
        $editar = $this->_Modelo->db->Sql_Select('Financeiro_Pagamento_Interno', $where);
        if ($editar === FALSE) {
            return _Sistema_erroControle::Erro_Fluxo('Financeiro não existe: '.$id,404);
        }
        if ($localizacao !== FALSE) {
            Financeiro_RelatorioControle::Endereco_Financeiro();
            if ($editar->saida_motivo==='Servidor' && $editar->saida_motivoid===SRV_NAME_SQL) {
                $pago = __('Recebido');
            } else {
                $pago = __('Pago');
            }
            $link_extra = '/'.$localizacao.'/'.$dataini.'/'.$datafin;
        } else if ($editar->saida_motivo==='Servidor' && $editar->saida_motivoid===SRV_NAME_SQL) {
            $pago = __('Recebido');
            self::Endereco_Receber();
            $link_extra = '';
        } else {
            $pago = 'Pago';
            self::Endereco_Pagar();
            $link_extra = '';
        }
        // Carrega Config
        $titulo1    = 'Declarar '.$pago.' (#'.$id.')';
        $titulo2    = $titulo1;
        $formid     = 'form_Sistema_AdminC_PagamentoEdit';
        $formbt     = $titulo1;
        $formlink   = 'Financeiro/Pagamento/Financeiros_Pagar2/'.$id.$link_extra;
        $campos = Financeiro_Pagamento_Interno_DAO::Get_Colunas();
        // Retira Desnecessarios
        self::Financeiros_Campos_Retirar($campos);
        // Modifica Resultados
        if ($editar->num_parcela=='0' || $editar->num_parcela==0) {
            $editar->num_parcela = __('Parcela Unica');
        } else {
            $editar->num_parcela = $editar->num_parcela.'º Parcela';
        }
        $editar->valor_juros = $editar->valor;
        $editar->dt_pago = APP_DATA_BR;
        // Puxa controler
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1, $titulo2, $formlink, $formid, $formbt, $campos, $editar);
    }
    /**
     * 
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Financeiros_Pagar2($id = FALSE, $localizacao = FALSE, $dataini = FALSE, $datafin = FALSE) {
        // Verifica Existencia
        if ($id === FALSE) {
            return _Sistema_erroControle::Erro_Fluxo('Financeiro não especificado: '.$id,404);
        }
        $where = Array('id'=>  $id);
        $financeiros = $this->_Modelo->db->Sql_Select('Financeiro_Pagamento_Interno', $where);
        if ($financeiros === FALSE) {
            return _Sistema_erroControle::Erro_Fluxo('Financeiro não existe: '.$id,404);
        }
        if ($financeiros->saida_motivo==='Servidor' && $financeiros->saida_motivoid===SRV_NAME_SQL) {
            $pago = __('Recebido');
        } else {
            $pago = __('Pago');
        }
        if (!isset($_POST['valor_juros']) || !isset($_POST['dt_pago'])|| !isset($_POST['obs'])) {
            return _Sistema_erroControle::Erro_Fluxo('Campos Imcompletos: ',404);
        }
        // Captura Valores
        $valor_juros    = \Framework\App\Sistema_Funcoes::Tranf_Real_Float(\Framework\App\Conexao::anti_injection($_POST['valor_juros']));
        $dt_pago        = \Framework\App\Conexao::anti_injection($_POST['dt_pago']);
        //$forma_pagar    = (int) $_POST['forma_pagar'];
        $obs            = \Framework\App\Conexao::anti_injection($_POST['obs']);
        // Mensagens
        $titulo     = 'Declarado '.$pago.' com Sucesso';
        $dao        = Array('Financeiro_Pagamento_Interno', $id);
        $sucesso1   = $titulo;
        $sucesso2   = ''.$_POST["valor"].' '.$pago.' com sucesso.';
        // Verificação e Atualizacao
        $financeiros->valor = \Framework\App\Sistema_Funcoes::Tranf_Real_Float($financeiros->valor);
        /*if ($financeiros->valor>$valor_juros) {
            $mensagens = array(
                "tipo"              => 'erro',
                "mgs_principal"     => __('Valor Pago Incorreto'),
                "mgs_secundaria"    => __('O valor pago é inferior ao valor do Pagamento')
            );
            $this->_Visual->Json_IncluiTipo('Mensagens', $mensagens);
            $this->_Visual->Json_Info_Update('Titulo', __('Erro'));
        } else {*/
            // Altera Valores Manualmente e grava
            $financeiros->pago = '1';
            //$financeiros->forma_pagar = $forma_pagar;
            $financeiros->dt_pago = $dt_pago;
            $financeiros->obs = $obs;
            $financeiros->valor_juros = \Framework\App\Sistema_Funcoes::Tranf_Float_Real($valor_juros-$financeiros->valor);
            
            $financeiros->valor = \Framework\App\Sistema_Funcoes::Tranf_Float_Real($valor_juros);

            $sucesso = $this->_Modelo->db->Sql_Update($financeiros);
            if ($sucesso) {
                $mensagens = array(
                    "tipo"              => 'sucesso',
                    "mgs_principal"     => $sucesso1,
                    "mgs_secundaria"    => $sucesso2
                ); 
                $this->_Visual->Json_Info_Update('Titulo', $titulo);
                // SE vier do Relatorio, volta pra la
                if ($localizacao !== FALSE) {
                    \Framework\App\Sistema_Funcoes::Redirect(URL_PATH.'Financeiro/Relatorio/Relatorio/'.$localizacao.'/'.$dataini.'/'.$datafin);
                } else if ($financeiros->saida_motivo==='Servidor' && $financeiros->saida_motivoid===SRV_NAME_SQL) {
                    $this->Receber();
                } else {
                    $this->Pagar();
                }
            } else {
                $mensagens = array(
                    "tipo"              => 'erro',
                    "mgs_principal"     => __('Ocorreu um Erro'),
                    "mgs_secundaria"    => __('Tente Novamente, algo deu errado.')
                );
                $this->_Visual->Json_Info_Update('Titulo', __('Erro'));
            }
            $this->_Visual->Json_IncluiTipo('Mensagens', $mensagens);
        //}
        $this->_Visual->Json_Info_Update('Historico', FALSE);
        $this->layoult_zerar = FALSE;
        //
    }
    /**
     * Listagem de Formas de Pagamento
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Formas() {
        self::Endereco_Forma(FALSE);
        
        $tabela = Array(
            'Nome', 'Funções'
        );
        $this->_Visual->Show_Tabela_DataTable_Massiva($tabela,'Financeiro/Pagamento/Formas');
        $titulo = __('Listagem de Formas de Pagamento').' (<span id="DataTable_Contador">0</span>)';  //
        $this->_Visual->Bloco_Unico_CriaJanela($titulo, '',10,Array("link"=>"Financeiro/Pagamento/Formas_Add",'icon'=>'add', 'nome'=>'Adicionar Forma de Pagamento'));
        
        
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Administrar Formas de Pagamento'));
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Formas_Add() {
        self::Endereco_Forma();
        // Carrega Config
        $titulo1    = __('Adicionar Forma de Pagamento');
        $titulo2    = __('Salvar Forma de Pagamento');
        $formid     = 'form_Sistema_Admin_Forma_Pagamentos';
        $formbt     = __('Salvar');
        $formlink   = 'Financeiro/Pagamento/Formas_Add2/';
        $campos = Financeiro_Pagamento_Forma_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1, $titulo2, $formlink, $formid, $formbt, $campos);
    }
    /**
     * 
     * 
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Formas_Add2() {
        $titulo     = __('Forma de Pagamento Adicionada com Sucesso');
        $dao        = 'Financeiro_Pagamento_Forma';
        $funcao     = '$this->Formas();';
        $sucesso1   = __('Inserção bem sucedida');
        $sucesso2   = __('Forma de Pagamento cadastrada com sucesso.');
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo, $dao, $funcao, $sucesso1, $sucesso2, $alterar);
    }
    /**
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Formas_Edit($id) {
        self::Endereco_Forma();
        // Carrega Config
        $titulo1    = 'Editar Forma de Pagamento (#'.$id.')';
        $titulo2    = __('Alteração de Forma de Pagamento');
        $formid     = 'form_Sistema_AdminC_PagamentoEdit';
        $formbt     = __('Alterar Forma de Pagamento');
        $formlink   = 'Financeiro/Pagamento/Formas_Edit2/'.$id;
        $editar     = Array('Financeiro_Pagamento_Forma', $id);
        $campos = Financeiro_Pagamento_Forma_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1, $titulo2, $formlink, $formid, $formbt, $campos, $editar);
    }
    /**
     * 
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Formas_Edit2($id) {
        $titulo     = __('Forma de Pagamento Editada com Sucesso');
        $dao        = Array('Financeiro_Pagamento_Forma', $id);
        $funcao     = '$this->Formas();';
        $sucesso1   = __('Forma de Pagamento Alterado com Sucesso.');
        $sucesso2   = ''.$_POST["nome"].' teve a alteração bem sucedida';
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo, $dao, $funcao, $sucesso1, $sucesso2, $alterar);      
    }
    /**
     * 
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Formas_Del($id) {
        
        
    	$id = (int) $id;
        // Puxa forma e deleta
        $forma = $this->_Modelo->db->Sql_Select('Financeiro_Pagamento_Forma', Array('id'=>$id));
        $sucesso =  $this->_Modelo->db->Sql_Delete($forma);
        // Mensagem
    	if ($sucesso === TRUE) {
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Deletado'),
                "mgs_secundaria" => __('Forma de Pagamento Deletada com sucesso')
            );
    	} else {
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Erro')
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens', $mensagens);
        
        $this->Formas();
        
        $this->_Visual->Json_Info_Update('Titulo', __('Forma de Pagamento deletada com Sucesso'));  
        $this->_Visual->Json_Info_Update('Historico', FALSE);  
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Condicoes($forma=0) {
        $forma = (int) $forma;
        $i = 0;
        if ($forma===0) {
            $link_extra = '/0';
            $nenhum     = __('Nenhuma Condição de Pagamento');
            $titulo     = __('Condição de Pagamento');
            $titulo2    = __('Condições de Pagamento');
        } else {
            $link_extra = '/'.$forma;
            $forma = $this->_Modelo->db->Sql_Select('Financeiro_Pagamento_Forma',Array('id'=>$forma),1);
            if ($forma === FALSE)                return _Sistema_erroControle::Erro_Fluxo('Forma de Pagamento não existe.'.$forma,404);
            $nenhum     = 'Nenhuma Condição de Pagamento em '.$forma->nome;
            $titulo     = 'Condição de Pagamento em '.$forma->nome;
            $titulo2    = 'Condições de Pagamento em '.$forma->nome;
        }
        self::Endereco_Forma_Condicao(FALSE, $forma);
        
        $tabela = Array(
            'Forma de Pagamento', 'Nome', 'Entrada', 'Qnt de Parcelas', 'Funções'
        );
        $this->_Visual->Show_Tabela_DataTable_Massiva($tabela,'Financeiro/Pagamento/Condicoes'.$link_extra);
        $this->_Visual->Bloco_Unico_CriaJanela('Listagem de '.$titulo2.' (<span id="DataTable_Contador">0</span>)', '',10,Array("link"=>"Financeiro/Pagamento/Condicoes_Add",'icon'=>'add', 'nome'=>'Adicionar '.$titulo.''));
        
        
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Administrar ').$titulo2);
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Condicoes_Add($forma = 0) {
        $forma      = (int)$forma;
        if ($forma!==0) {
            $formaid = $forma;
            $forma = $this->_Modelo->db->Sql_Select('Financeiro_Pagamento_Forma',Array('id'=>$forma),1);
            if ($forma === FALSE)                return _Sistema_erroControle::Erro_Fluxo('Forma de Pagamento não existe.'.$forma,404);
        } else {
            $formaid = 0;
        }
        self::Endereco_Forma_Condicao(true, $forma);
        // Carrega Config
        $titulo1    = __('Adicionar Condição de Pagamento');
        $titulo2    = __('Salvar Condição de Pagamento');
        $formid     = 'form_Sistema_Admin_Condicao_Pagamentos';
        $formbt     = __('Salvar');
        $formlink   = 'Financeiro/Pagamento/Condicoes_Add2/'.$formaid;
        $campos = Financeiro_Pagamento_Forma_Condicao_DAO::Get_Colunas();
        if (is_object($forma)) {
            self::DAO_Campos_Retira($campos,'forma');
        }
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1, $titulo2, $formlink, $formid, $formbt, $campos);
    }
    /**
     * 
     * 
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Condicoes_Add2($forma = 0) {
        $forma      = (int)$forma;
        if ($forma!==0) {
            $formaid = $forma;
            $forma = $this->_Modelo->db->Sql_Select('Financeiro_Pagamento_Forma',Array('id'=>$forma),1);
            if ($forma === FALSE)                return _Sistema_erroControle::Erro_Fluxo('Forma de Pagamento não existe.'.$forma,404);
        } else {
            $formaid = 0;
        }
        $titulo     = __('Condição de Pagamento Adicionada com Sucesso');
        $dao        = 'Financeiro_Pagamento_Forma_Condicao';
        $sucesso1   = __('Inserção bem sucedida');
        $sucesso2   = __('Condição de Pagamento cadastrada com sucesso.');
        if ($formaid===0) {
            $alterar    = Array();
        } else {
            $alterar    = Array('forma'=>$formaid);
        }
        $funcao     = '$this->Condicoes('.$formaid.');';
        $this->Gerador_Formulario_Janela2($titulo, $dao, $funcao, $sucesso1, $sucesso2, $alterar);
    }
    /**
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Condicoes_Edit($id, $forma=0) {
        $forma      = (int)$forma;
        if ($forma!==0) {
            $formaid = $forma;
            $forma = $this->_Modelo->db->Sql_Select('Financeiro_Pagamento_Forma',Array('id'=>$forma),1);
            if ($forma === FALSE)                return _Sistema_erroControle::Erro_Fluxo('Forma de Pagamento não existe.'.$forma,404);
        } else {
            $formaid = 0;
        }
        self::Endereco_Forma_Condicao(true, $forma);
        // Carrega Config
        $titulo1    = 'Editar Condição de Pagamento (#'.$id.')';
        $titulo2    = __('Alteração de Condição de Pagamento');
        $formid     = 'form_Sistema_AdminC_PagamentoEdit';
        $formbt     = __('Alterar Condicao de Pagamento');
        $formlink   = 'Financeiro/Pagamento/Condicoes_Edit2/'.$id.'/'.$formaid;
        $editar     = Array('Financeiro_Pagamento_Forma_Condicao', $id);
        $campos = Financeiro_Pagamento_Forma_Condicao_DAO::Get_Colunas();
        if (is_object($forma)) {
            self::DAO_Campos_Retira($campos,'forma');
        }
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1, $titulo2, $formlink, $formid, $formbt, $campos, $editar);
    }
    /**
     * 
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Condicoes_Edit2($id, $forma=0) {
        $forma      = (int)$forma;
        if ($forma!==0) {
            $formaid = $forma;
            $forma = $this->_Modelo->db->Sql_Select('Financeiro_Pagamento_Forma',Array('id'=>$forma),1);
            if ($forma === FALSE)                return _Sistema_erroControle::Erro_Fluxo('Forma de Pagamento não existe.'.$forma,404);
        } else {
            $formaid = 0;
        }
        $titulo     = __('Condição de Pagamento Editada com Sucesso');
        $dao        = Array('Financeiro_Pagamento_Forma_Condicao', $id);
        $funcao     = '$this->Condicoes('.$formaid.');';
        $sucesso1   = __('Condicao de Pagamento Alterado com Sucesso.');
        $sucesso2   = ''.$_POST["nome"].' teve a alteração bem sucedida';
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo, $dao, $funcao, $sucesso1, $sucesso2, $alterar);      
    }
    /**
     * 
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Condicoes_Del($id, $forma=0) {
        
        $forma      = (int)$forma;
        
    	$id = (int) $id;
        // Puxa condicao e deleta
        $condicao = $this->_Modelo->db->Sql_Select('Financeiro_Pagamento_Forma_Condicao', Array('id'=>$id));
        $sucesso =  $this->_Modelo->db->Sql_Delete($condicao);
        // Mensagem
    	if ($sucesso === TRUE) {
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Deletado'),
                "mgs_secundaria" => __('Condição de Pagamento Deletada com sucesso')
            );
    	} else {
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Erro')
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens', $mensagens);
        
        $this->Condicoes($forma);
        
        $this->_Visual->Json_Info_Update('Titulo', __('Condição de Pagamento deletada com Sucesso'));  
        $this->_Visual->Json_Info_Update('Historico', FALSE);  
    }
    /**
     * Gera Parcelas de Acordo com a Condição de Pagamento
     * 
     * @param type $condicaoid
     * @param type $motivo
     * @param type $motivoid
     * @param type $entrada_motivo
     * @param type $entrada_motivoid
     * @param type $saida_motivo
     * @param type $saida_motivoid
     * @param type $valor
     * @param type $data
     */
    static function Condicao_GerarPagamento($condicaoid, $motivo, $motivoid, $entrada_motivo, $entrada_motivoid, $saida_motivo, $saida_motivoid, $valor, $data = FALSE, $categoria=0, $pago=0) {
        $Registro = &\Framework\App\Registro::getInstacia();
        $_Modelo = &$Registro->_Modelo;
        //Valores Iniciais
        $num            = 1; // Parcelas
        $condicaoid     = (int) $condicaoid; // AntiInjection
        if ($data === FALSE) {
            $data = APP_DATA_BR;
        }
        // Pega Condicao do Banco de Dados
        $condicao           = $_Modelo->db->Sql_Select('Financeiro_Pagamento_Forma_Condicao',Array('id'=>$condicaoid),1);
        if ($condicao === FALSE) {
            return FALSE;
        }
        // Transforma Real e Porcentagem em Decimal
        $valor              = \Framework\App\Sistema_Funcoes::Tranf_Real_Float($valor);
        $condicao_entrada    = \Framework\App\Sistema_Funcoes::Tranf_Porc_Float($condicao->entrada);
        // Pega Parcelas por Referencia
        $condicao_parcelas  = $condicao->parcelas;
        // Insere Entrada caso necessario
        if ($condicao_entrada>0.0 && $valor>0) {
            $entrada = $condicao_entrada*$valor;
            $valor = $valor-$entrada;
            // Insere Entrada
            Financeiro_Controle::FinanceiroInt($motivo, $motivoid, $entrada_motivo, $entrada_motivoid, $saida_motivo, $saida_motivoid, $entrada, $data,0, $categoria, $condicao->forma_pagar, $condicaoid, $pago);
        }
        // Insere Parcelas caso necesario
        if ($condicao_parcelas>0 && $valor>0) {
            $valor = round($valor/$condicao_parcelas,2);
            // Insere Um a um
            for(;$num<=$condicao_parcelas;$num++) {
                $data = \Framework\App\Sistema_Funcoes::Modelo_Data_Soma($data,0,1);
                Financeiro_Controle::FinanceiroInt($motivo, $motivoid, $entrada_motivo, $entrada_motivoid, $saida_motivo, $saida_motivoid, $valor, $data, $num, $categoria, $condicao->forma_pagar, $condicaoid, $pago);
            }
        }
        return TRUE;
    }
    public function Financeiros_VencimentoEdit($id = FALSE) {
        // Faz Protecao, e Linguagem apropriada
        if ($id === FALSE) {
            return _Sistema_erroControle::Erro_Fluxo('Financeiro não especificado: '.$id,404);
        }
        $where = Array('id'=>  $id);
        $editar = $this->_Modelo->db->Sql_Select('Financeiro_Pagamento_Interno', $where);
        if ($editar === FALSE) {
            return _Sistema_erroControle::Erro_Fluxo('Financeiro não existe: '.$id,404);
        }
        // Carrega Config
        $titulo1    = 'Mudar Vencimento (#'.$id.')';
        $titulo2    = $titulo1;
        $formid     = 'form_Sistema_AdminC_Financeiros_VencimentoEdit';
        $formbt     = $titulo1;
        $formlink   = 'Financeiro/Pagamento/Financeiros_VencimentoEdit2/'.$id;
        $campos = Financeiro_Pagamento_Interno_DAO::Get_Colunas();
        // Retira Outros
        self::DAO_Campos_Retira($campos, 'dt_vencimento',1);
        // Puxa controler
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1, $titulo2, $formlink, $formid, $formbt, $campos, $editar,'Popup');
    }
    /**
     * 
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Financeiros_VencimentoEdit2($id = FALSE) {
        // Verifica Existencia
        if ($id === FALSE) {
            return _Sistema_erroControle::Erro_Fluxo('Financeiro não especificado: '.$id,404);
        }
        $id = (int) $id;
        $where = Array('id'=>  $id);
        $financeiros = $this->_Modelo->db->Sql_Select('Financeiro_Pagamento_Interno', $where);
        if ($financeiros === FALSE) {
            return _Sistema_erroControle::Erro_Fluxo('Financeiro não existe: '.$id,404);
        }
        // Mensagens
        $titulo     = __('Vencimento alterado com Sucesso');
        $dao        = Array('Financeiro_Pagamento_Interno', $id);
        $sucesso1   = $titulo;
        $sucesso2   = $titulo;
        
        $financeiros->dt_vencimento    = \Framework\App\Conexao::anti_injection($_POST['dt_vencimento']);
        // Verificação e Atualizacao
        $sucesso = $this->_Modelo->db->Sql_Update($financeiros);
        if ($sucesso) {
            $mensagens = array(
                "tipo"              => 'sucesso',
                "mgs_principal"     => $sucesso1,
                "mgs_secundaria"    => $sucesso2
            ); 
            $this->_Visual->Json_Info_Update('Titulo', $titulo);
            // Atualiza Vencimento
            $conteudo = array(
                'location' => '#financeirovenc'.$id,
                'js' => '',
                'html' =>  $_POST['dt_vencimento']
            );
            $this->_Visual->Json_IncluiTipo('Conteudo', $conteudo);
        } else {
            $mensagens = array(
                "tipo"              => 'erro',
                "mgs_principal"     => __('Ocorreu um Erro'),
                "mgs_secundaria"    => __('Tente Novamente, algo deu errado.')
            );
            $this->_Visual->Json_Info_Update('Titulo', __('Erro'));
        }
        $this->_Visual->Json_IncluiTipo('Mensagens', $mensagens);
        $this->_Visual->Json_Info_Update('Historico', FALSE);
        $this->layoult_zerar = FALSE;
        //
    }
    /**
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @param type $tema (Pagar,Pago,Receber,Recebido)
     * @param type $layoult
     * @throws Exception
     */
    public function Financeiro_View($id, $layoult='Unico') {
        $html = '<span style="text-transform:uppercase;">';


        // Puxca Financeiro
        $identificador = $this->_Modelo->db->Sql_Select('Financeiro_Pagamento_Interno',Array('id'=>(int) $id),1); // Banco DAO, Condicao e LIMITE
        // Verifica se Existe e Continua
        if ($identificador === FALSE) {
            return _Sistema_erroControle::Erro_Fluxo('Pagamento não Existe',404);
        }
        $id = $identificador->id;
        
        
        if ($identificador->entrada_motivo==='Servidor' && $identificador->entrada_motivoid===SRV_NAME_SQL) {
            if ($identificador->pago==1) {
                $tema = 'Pago';
            } else {
                $tema = 'Pagar';
            }
        } else {            
            if ($identificador->pago==1) {
                $tema = 'Receber';
            } else {
                $tema = 'Recebido';
            }
        }
        
        // Nomes
        if ($tema==='Pagar') {
            $titulo             = __('Conta a Pagar');
            $titulo_plural      = __('Contas a Pagar');
            $titulo_unico       = 'contasapagar';
        } else if ($tema==='Pago') {
            $titulo             = __('Conta Paga');
            $titulo_plural      = __('Contas Pagas');
            $titulo_unico       = 'contaspagas';
        } else if ($tema==='Receber') {
            $titulo             = __('Conta a Pagar');
            $titulo_plural      = __('Contas a Pagar');
            $titulo_unico       = 'contasareceber';
        } else {
            $tema               = 'Recebido';
            $titulo             = __('Conta Recebida');
            $titulo_plural      = __('Contas Recebidas');
            $titulo_unico       = 'contasrecebidas';
        }
        
        
        
        /*$cliente = $this->_Modelo->db->Sql_Select('Usuario',Array('id'=>$identificador->cliente),1); // Banco DAO, Condicao e LIMITE
        // Verifica se Existe e Continua
        if ($identificador === FALSE) {
            return _Sistema_erroControle::Erro_Fluxo('Proposta não Existe',404);
        }
        if ($cliente === FALSE) {
            return _Sistema_erroControle::Erro_Fluxo('Cliente não existe',404);
        }
        */
        
        
        if ($layoult!=='Imprimir') {            
            $html .= $this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
                FALSE,
                Array(
                    'Print'     => TRUE,
                    'Pdf'       => FALSE,
                    'Excel'     => FALSE,
                    'Link'      => 'Financeiro/Pagamento/Financeiro_View/'.$id.'/'.$tema,
                )
            ));
        }
        
        //DADOS
        if ($identificador->valor!='')  $html .= '<p><label style="width:250px; float:left; margin-right:5px;">Valor:</label>'.$identificador->valor.'</p>';
        if ($identificador->obs!='')  $html .= '<p><label style="width:250px; float:left; margin-right:5px;">Observação:</label>'.$identificador->obs.'</p>';
        
        // Bota Espaço
        $html .= '<div class="space15"></div>';
        
        $html .= '</span>';
        // Caso seja pra Imprimir
        if ($layoult==='Imprimir') {
            self::Export_Todos($layoult, $html, $titulo.' #'.$identificador->id);
        } else {
            // Identifica tipo e cria conteudo
            if (LAYOULT_IMPRIMIR=='AJAX') {
                // Coloca Conteudo em Popup
                $popup = array(
                    'id'        => 'popup',
                    'title'     => $titulo.' #'.$identificador->id,
                    /*'botoes'    => array(
                        '0'         => array(
                            'text'      => 'Fechar Janela',
                            'clique'    => '$(this).dialog(\'close\');'
                        )
                    ),*/
                    'html'      => $html
                );
                $this->_Visual->Json_IncluiTipo('Popup', $popup);
            } else {
                // Coloca Endereco
                $funcao = 'Endereco_'.$tema;
                self::$funcao(TRUE);
                $this->Tema_Endereco('Visualizar '.$titulo);
                // Coloca COnteudo em Janela
                $this->_Visual->Blocar($html);
                if ($layoult==='Unico') {
                    $this->_Visual->Bloco_Unico_CriaJanela($titulo.' #'.$identificador->id);
                } else if ($layoult==='Maior') {
                    $this->_Visual->Bloco_Maior_CriaJanela($titulo.' #'.$identificador->id);
                } else {
                    $this->_Visual->Bloco_Menor_CriaJanela($titulo.' #'.$identificador->id);
                }
            }
            //Carrega Json
            $this->_Visual->Json_Info_Update('Titulo', $titulo.' #'.$identificador->id);
        }
    }
}
?>
