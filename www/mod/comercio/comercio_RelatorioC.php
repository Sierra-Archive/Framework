<?php
class comercio_RelatorioControle extends comercio_Controle
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
    * @version 0.4.24
    */
    public function __construct() {
        parent::__construct();
    }
    static function enderecoRelatorioProposta($true= true ) {
        $Registro = &\Framework\App\Registro::getInstacia();
        $_Controle = $Registro->_Controle;
        $titulo = __('Relatório de Propostas/Ordem de Serviços');
        $link = 'comercio/Relatorio/relatorioProposta';
        if ($true === true) {
            $_Controle->Tema_Endereco($titulo, $link);
        } else {
            $_Controle->Tema_Endereco($titulo);
        }
    }
    static function enderecoGraficoProposta($true= true ) {
        $Registro = &\Framework\App\Registro::getInstacia();
        $_Controle = $Registro->_Controle;
        $titulo = __('Gráfico de Propostas/Ordem de Serviços');
        $link = 'comercio/Relatorio/graficoProposta';
        if ($true === true) {
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
    * @uses comercio_Controle::$financeiroPerfil
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 0.4.24
    */
    public function Main() {
        $this->Relatorio();
        // ORGANIZA E MANDA CONTEUDO
        $this->_Visual->Json_Info_Update('Titulo', 'Relatório comercio'); 
    }
    public function relatorio($data_inicial = '2014-01-01', $data_final = APP_DATA, $status = 'todas', $cliente = false, $cuidados = false)
    {
        
        self::enderecoRelatorioProposta(false);
        
        if ($cliente=='0') $cliente = false;
        if ($cuidados=='0') $cuidados = false;
        
        // Começa e Cria Formulario
        $form = new \Framework\Classes\Form('comercioRelatorioProposta', 'comercio/Relatorio/relatorioReceber', 'formajax', 'mini', 'vertical');
        
        $form->Select_Novo(__('Status'), 'status', 'status', '', '', '', false, false, '', __('Escolha um Status'));
        $form->Select_Opcao(__('Todas'), 'todas', ($status=='todas'?1:0));
        $form->Select_Opcao(__('Aprovado'), '1', ($status==1?1:0));
        $form->Select_Opcao(__('Pendente'), '0', ($status==0?1:0));
        $form->Select_Opcao(__('Em Execução'), '2', ($status==2?1:0));
        $form->Select_Opcao(__('Finalizado'), '3', ($status==3?1:0));
        $form->Select_Opcao(__('Recusado'), '4', ($status==4?1:0));
        $form->Select_Fim();
        
        // Vendedores
        $cuidados_selecionadas = $this->_Modelo->db->Sql_Select('Usuario','{sigla}grupo=\''.CFG_TEC_IDVENDEDOR.'\'');
        if (is_object($cuidados_selecionadas)) $cuidados_selecionadas = Array($cuidados_selecionadas);
        if (!empty($cuidados_selecionadas)) {
            $form->Select_Novo(__('Vendedor'), 'cuidados', 'cuidados', '', '', '', false, false, '', __('Escolha um Vendedor'));
            $form->Select_Opcao(__('Todos'), '0',($cuidados === false?1:0));
            foreach ($cuidados_selecionadas as &$valor) {
                $form->Select_Opcao($valor->nome, $valor->id,($cuidados==$valor->id?1:0));
            }
            $form->Select_Fim();
        }
        
        // Clientes
        $clientes_selecionadas = $this->_Modelo->db->Sql_Select('Usuario','EXTB.categoria='.CFG_TEC_CAT_ID_CLIENTES);
        if (is_object($clientes_selecionadas)) $clientes_selecionadas = Array($clientes_selecionadas);
        if (!empty($clientes_selecionadas)) {
            $form->Select_Novo(__('Cliente'), 'cliente', 'cliente', '', '', '', false, false, '', __('Escolha um Cliente'));
            $form->Select_Opcao(__('Todos'), '0',($cliente === false?1:0));
            foreach ($clientes_selecionadas as &$valor) {
                $form->Select_Opcao($valor->nome, $valor->id,($cliente==$valor->id?1:0));
            }
            $form->Select_Fim();
        }

        $form->Input_Novo(__('Data Inicial'), 'data_inicial', data_eua_brasil($data_inicial), 'text', 10, '', 'Data do Começo do Relatório', false, '', '', 'Data', '', false);
        $form->Input_Novo(__('Data Final'), 'data_final', data_eua_brasil($data_final), 'text', 10, '', 'Data do Final do Relatório', false, '', '', 'Data', '', false);
        
        /*$form->Select_Novo('Retorno', 'tipo_visual', 'tipo_visual', '', '', '', false, false, '', 'Escolha um Retorno');
        $form->Select_Opcao('Visualizar', 'normal',1);
        $form->Select_Opcao('Imprimir', 'imprimir',0);
        $form->Select_Opcao('Download em Excell', 'excell',0);
        $form->Select_Opcao('Visualizar em PDF', 'pdf',0);
        $form->Select_Opcao('Download em PDF', 'pdfdownload',0);
        $form->Select_Fim();*/
        // Bloca Conteudo e Cria Janela de COnfiguração
        $this->_Visual->Blocar($form->retorna_form('Atualizar')); // Relatório
        $this->_Visual->Bloco_Menor_CriaJanela(__('Configuração do Relatório'), '', 0, false);
        
        // Cria Segunda Janela com Parametros pré selecionados
        $tipo_visual = false;
        $html = $this->relatorioProposta($data_inicial, $data_final, $cliente, $cuidados, $tipo_visual);
        $titulo = __('Relatório de Status de Propostas/O.S');
        $this->_Visual->Blocar('<span id="relatorio_tabela">'.$html.'</span>');
        $this->_Visual->Bloco_Maior_CriaJanela('<span id="relatorio_titulo">'.$titulo.'</span>', '', 0, false);
        
        // ORGANIZA E MANDA CONTEUDO
        $this->_Visual->Json_Info_Update('Titulo', 'Relatório comercio'); 
    }
    public function relatorioReceber()
    {
        // Trata Parametros
        if (isset($_POST['status'])) {
            $status = data_brasil_eua(\Framework\App\Conexao::anti_injection($_POST['status']));
        } else {
            $status = 'todas';
        }
        if (isset($_POST['data_inicial'])) {
            $data_inicial = data_brasil_eua(\Framework\App\Conexao::anti_injection($_POST['data_inicial']));
        } else {
            $data_inicial = '2014-01-01';
        }
        if (isset($_POST['data_final'])) {
            $data_final = data_brasil_eua(\Framework\App\Conexao::anti_injection($_POST['data_final']));
        } else {
            $data_final = APP_DATA;
        }
        if (isset($_POST['cliente'])) {
            $cliente = \Framework\App\Conexao::anti_injection($_POST['cliente']);
            if ($cliente==0) $cliente = false;
        } else {
            $cliente = false;
        }
        if (isset($_POST['cuidados'])) {
            $cuidados = \Framework\App\Conexao::anti_injection($_POST['cuidados']);
            if ($cuidados==0) $cuidados = false;
        } else {
            $cuidados = false;
        }
        $titulo = __('Relatório de Status de Propostas/O.S');
        
        if (isset($_POST['tipo_visual'])) {
            $tipo_visual = \Framework\App\Conexao::anti_injection($_POST['tipo_visual']);
            if ($tipo_visual==='imprimir') {
                $tipo_visual = 'Imprimir';
            } else if ($tipo_visual==='pdf') {
                $tipo_visual = 'Pdf';
            } else if ($tipo_visual==='pdfdownload') {
                $tipo_visual = 'Pdf_Download';
            } else if ($tipo_visual==='excell') {
                $tipo_visual = 'Excel';
            } else {
                $tipo_visual = false;
            }
        } else {
            $tipo_visual = false;
        }
        
        // Chama Funcao Correspondente e Imprime Resultado
        $html = $this->relatorioProposta($data_inicial, $data_final, $status, $cliente, $cuidados, $tipo_visual);
        $conteudo = array(
            'location' => '#relatorio_tabela',
            'js' => '',
            'html' =>  $html
        );
        $this->_Visual->Json_IncluiTipo('Conteudo', $conteudo);
        
        // Imprimir Titulo
        $conteudo = array(
            'location' => '#relatorio_titulo',
            'js' => '',
            'html' =>  $titulo
        );
        $this->_Visual->Json_IncluiTipo('Conteudo', $conteudo);
        
        // IMpede Historico
        $this->_Visual->Json_Info_Update('Historico', false); 
    }
    
    public function relatorioProposta($datainicial = '2014-01-01', $data_final = APP_DATA, $status = 'todas', $cliente='false', $cuidados='false', $export = false)
    {
        
        $tableColumns = Array();
        //$tableColumns[] = __('Proposta ID');
        $tableColumns[] = __('Proposta');
        $tableColumns[] = __('Cliente');
        $tableColumns[] = __('Vendedor');
        $tableColumns[] = __('Status');
        $tableColumns[] = __('Data');
        
        if ($cliente===false) {
            $cliente = 'false';
        }
        if ($cuidados===false) {
            $cuidados = 'false';
        }
        return $this->_Visual->Show_Tabela_DataTable_Massiva($tableColumns,'comercio/Relatorio/relatorioProposta/'.$datainicial.'/'.$data_final.'/'.$status.'/'.$cliente.'/'.$cuidados,'',false);

    }
    
    
    
    public function grafico($data_inicial = '2014-01-01', $data_final = APP_DATA, $status = 'todas', $cliente = false, $cuidados = false, $tipo_grafico = 'mes')
    {
        
        self::enderecoGraficoProposta(false);
        
        if ($cliente=='0') $cliente = false;
        
        // Começa e Cria Formulario
        $form = new \Framework\Classes\Form('Grafico_Relatorio_comercio', 'comercio/Relatorio/Grafico_Relatorio_Receber', 'formajax', 'mini', 'vertical');
        
        $form->Select_Novo(__('Status'), 'status', 'status', '', '', '', false, false, '', __('Escolha um Status'));
        $form->Select_Opcao(__('Todas'), 'todas', ($status=='todas'?1:0));
        $form->Select_Opcao(__('Aprovado'), '1', ($status==1?1:0));
        $form->Select_Opcao(__('Pendente'), '0', ($status==0?1:0));
        $form->Select_Opcao(__('Em Execução'), '2', ($status==2?1:0));
        $form->Select_Opcao(__('Finalizado'), '3', ($status==3?1:0));
        $form->Select_Opcao(__('Recusado'), '4', ($status==4?1:0));
        $form->Select_Fim();
        
        // Vendedores
        $cuidados_selecionadas = $this->_Modelo->db->Sql_Select('Usuario','{sigla}grupo=\''.CFG_TEC_IDVENDEDOR.'\'');
        if (is_object($cuidados_selecionadas)) $cuidados_selecionadas = Array($cuidados_selecionadas);
        if (!empty($cuidados_selecionadas)) {
            $form->Select_Novo(__('Vendedor'), 'cuidados', 'cuidados', '', '', '', false, false, '', __('Escolha um Vendedor'));
            $form->Select_Opcao(__('Todos'), '0',($cuidados === false?1:0));
            foreach ($cuidados_selecionadas as &$valor) {
                $form->Select_Opcao($valor->nome, $valor->id,($cuidados==$valor->id?1:0));
            }
            $form->Select_Fim();
        }
        
        // Clientes
        $clientes_selecionadas = $this->_Modelo->db->Sql_Select('Usuario','EXTB.categoria='.CFG_TEC_CAT_ID_CLIENTES);
        if (is_object($clientes_selecionadas)) $clientes_selecionadas = Array($clientes_selecionadas);
        if (!empty($clientes_selecionadas)) {
            $form->Select_Novo(__('Cliente'), 'cliente', 'cliente', '', '', '', false, false, '', __('Escolha um Cliente'));
            $form->Select_Opcao(__('Todos'), '0',($cliente === false?1:0));
            foreach ($clientes_selecionadas as &$valor) {
                $form->Select_Opcao($valor->nome, $valor->id,($cliente==$valor->id?1:0));
            }
            $form->Select_Fim();
        }
        
        $form->Input_Novo(__('Data Inicial'), 'data_inicial', data_eua_brasil($data_inicial), 'text', 10, '', 'Data do Começo do Relatório', false, '', '', 'Data', '', false);
        $form->Input_Novo(__('Data Final'), 'data_final', data_eua_brasil($data_final), 'text', 10, '', 'Data do Final do Relatório', false, '', '', 'Data', '', false);
        
        /*$form->Select_Novo('Retorno', 'tipo_visual', 'tipo_visual', '', '', '', false, false, '', 'Escolha um Retorno');
        $form->Select_Opcao('Visualizar', 'normal',1);
        $form->Select_Opcao('Imprimir', 'imprimir',0);
        $form->Select_Opcao('Download em Excell', 'excell',0);
        $form->Select_Opcao('Visualizar em PDF', 'pdf',0);
        $form->Select_Opcao('Download em PDF', 'pdfdownload',0);
        $form->Select_Fim();*/
        
        // Tipo de Grafico
        $form->Select_Novo('Tipo de Gráfico', 'tipo_grafico', 'tipo_grafico', '', '', '', false, false, '', 'Escolha um Tipo de Gráfico');
        $form->Select_Opcao('Mensal', 'mes',1);
        $form->Select_Opcao('Diário', 'dia',0);
        $form->Select_Opcao('Semanal', 'semana',0);
        $form->Select_Fim();
        
        // Bloca Conteudo e Cria Janela de COnfiguração
        $this->_Visual->Blocar($form->retorna_form('Atualizar')); // Relatório
        $this->_Visual->Bloco_Menor_CriaJanela(__('Configuração do Relatório'), '', 0, false);
        
        // Cria Segunda Janela com Parametros pré selecionados
        $tipo_visual = false;
        
        // Chama Funcao
        $html = $this->graficoProposta($data_inicial, $data_final, $status, $cliente, $cuidados, $tipo_grafico, $tipo_visual);
        $titulo = __('Relatório de Status de Propostas/O.S');
        $this->_Visual->Blocar('<span id="Grafico_relatorio_tabela">'.$html.'</span>');
        $this->_Visual->Bloco_Maior_CriaJanela('<span id="Grafico_relatorio_titulo">'.$titulo.'</span>', '', 0, false);
        
        // ORGANIZA E MANDA CONTEUDO
        $this->_Visual->Json_Info_Update('Titulo', 'Relatório de Status de Propostas/O.S'); 
    }
    
    public function graficoProposta (
        $datainicial = '2014-01-01',
        $data_final = APP_DATA,
        $status = 'todas',
        $cliente='false',
        $cuidados='false',
        $tipo_grafico = 'mes',
        $export = false
    )
    {
        $total = 0;
        //WHERE
        $where = 'CPROSt.data>=\''.$datainicial.' 00:00:00\' AND CPROSt.data<=\''.$data_final.' 23:59:59\'';
        
        //Status
        if ($status!='todas' && $status!==false) {
            if ($where !== '') {
                $where .= ' AND ';
            }
            $where .= 'CPROSt.status=\''.$status.'\'';
        }  else if ($status===false || $status==0) {
            if ($where !== '') {
                $where .= ' AND ';
            }
            $where .= 'CPROSt.status=\'0\'';
        }  
        
        if($cliente!=='false'){
            if ($where !== '') {
                $where .= ' AND ';
            }
            $where .= 'CPROSt.cliente=\''.$cliente.'\'';
        }   
        if($cuidados!=='false'){
            if ($where !== '') {
                $where .= ' AND ';
            }
            $where .= 'CPROSt.cuidados=\''.$cuidados.'\'';
        }
        
        // Valores Padroes
        $i = 0;
        $table = Array();
        
        $titulo = __('Relatório de Status de Propostas/O.S');
        
        if ($tipo_grafico==='mes') {
            $mes = Array(
                0=>'0.0',
                1=>'0.0',
                2=>'0.0',
                3=>'0.0',
                4=>'0.0',
                5=>'0.0',
                6=>'0.0',
                7=>'0.0',
                8=>'0.0',
                9=>'0.0',
                10=>'0.0',
                11=>'0.0',
            );
        } else if ($tipo_grafico==='semana') {
            $semana = Array(
                0=>'0.0',
                1=>'0.0',
                2=>'0.0',
                3=>'0.0',
                4=>'0.0',
                5=>'0.0',
                6=>'0.0'
            );
        } else {
            $dia = Array(
                0=>'0.0',
                1=>'0.0',
                2=>'0.0',
                3=>'0.0',
                4=>'0.0',
                5=>'0.0',
                6=>'0.0',
                7=>'0.0',
                8=>'0.0',
                9=>'0.0',
                10=>'0.0',
                11=>'0.0',
                12=>'0.0',
                13=>'0.0',
                14=>'0.0',
                15=>'0.0',
                16=>'0.0',
                17=>'0.0',
                18=>'0.0',
                19=>'0.0',
                20=>'0.0',
                21=>'0.0',
                22=>'0.0',
                23=>'0.0',
                24=>'0.0',
                25=>'0.0',
                26=>'0.0',
                27=>'0.0',
                28=>'0.0',
                29=>'0.0',
                30=>'0.0'
            );
        }        
        
        $propostas = $this->_Modelo->db->Sql_Select(
            'Comercio_Proposta_Status', 
            $where,
             0,
             '',
             'id,data,status,cliente,cuidados'
        );
        if ($propostas !== false && !empty($propostas)) {
            if (is_object($propostas)) $propostas = Array(0=>$propostas);
            reset($propostas);
            foreach ($propostas as &$valor) {
                if ($tipo_grafico==='mes') {
                    $mes[(Framework\App\Sistema_Funcoes::Get_Info_Data('mes', $valor->dt_vencimento)-1)] += 1;
                } else if ($tipo_grafico==='semana') {
                    $semana[Framework\App\Sistema_Funcoes::Get_Info_Data('semana', $valor->dt_vencimento)] += 1;
                } else {
                    $dia[(Framework\App\Sistema_Funcoes::Get_Info_Data('dia', $valor->dt_vencimento)-1)] += 1;
                }

                
                $total = $total + 1;
                ++$i;
            }
        }
        
        # Definimos os dados do gráfico
        
        if ($tipo_grafico==='mes') {
            $dados = array(
                array('Jan', $mes[0]),
                array('Fev', $mes[1]),
                array('Mar', $mes[2]),
                array('Abr', $mes[3]),
                array('Mai', $mes[4]),
                array('Jun', $mes[5]),
                array('Jul', $mes[6]),
                array('Ago', $mes[7]),
                array('Set', $mes[8]),
                array('Out', $mes[9]),
                array('Nov', $mes[10]),
                array('Dez', $mes[11]),
            );
        } else if ($tipo_grafico==='semana') {;
            $dados = array(
                array('Dom', $semana[0]),
                array('Seg', $semana[1]),
                array('Ter', $semana[2]),
                array('Qua', $semana[3]),
                array('Qui', $semana[4]),
                array('Sex', $semana[5]),
                array('Sab', $semana[6]),
            );
        } else {
            $dados = Array();
            foreach ($dia as $indice=>$valor) {
                $dados[] = array($indice, $valor);
            }
        }
        $html = '<img alt="'.__('Gráfico de Movimentação de Status').'" src="'.$this->Gerador_Grafico_Padrao($titulo, __('Mês'), __('Qnt'), $dados).'" />';
        
        
        // ADiciona Total
        $html_total = '<br><table class="table">
    <tbody>'./*<tr>
        <td width="100" class="text-error"><b>'.__('Total à pagar').'</b></td>
        <td class="text-error"><b>R$6.702.000,00</b></td>
    </tr>
    <tr>
        <td class="text-success"><b>'.__('Pago').'</b></td>
        <td class="text-success"><b>R$366.000,00</b></td>
    </tr><tr>
        <td class="text-info"><b>'.__('Total Movimentado').'</b></td>
        <td class="text-info"><b>'.Framework\App\Sistema_Funcoes::Tranf_Float_Real($total).'</b></td>
    </tr>*/
    '<tr>
        <td class="text-success"><b>'.__('Total de Movimentações').'</b></td>
        <td class="text-success"><b>'.$total.'</b></td>
    </tr>
    </tbody>
</table>';
        
        if ($i==0 ) {
            return '<center><b><font color="#FF0000" size="5">'.__('Nenhuma Proposta/O.S Movimentada').'</font></b></center>';
        } else {
            if ($export !== false) {
                self::Export_Todos($export, $table, __('Contas Recebidas'));
            } else {
                return $html.$html_total;
            }
            unset($table);
        }
        return false;

    }
    public function graficoReceber()
    {
        // Trata Parametros
        if (isset($_POST['status'])) {
            $status = data_brasil_eua(\Framework\App\Conexao::anti_injection($_POST['status']));
        } else {
            $status = 'todas';
        }
        if (isset($_POST['data_inicial'])) {
            $data_inicial = data_brasil_eua(\Framework\App\Conexao::anti_injection($_POST['data_inicial']));
        } else {
            $data_inicial = '2014-01-01';
        }
        if (isset($_POST['data_final'])) {
            $data_final = data_brasil_eua(\Framework\App\Conexao::anti_injection($_POST['data_final']));
        } else {
            $data_final = APP_DATA;
        }
        if (isset($_POST['cliente'])) {
            $cliente = \Framework\App\Conexao::anti_injection($_POST['cliente']);
            if ($cliente==0) $cliente = false;
        } else {
            $cliente = false;
        }
        if (isset($_POST['cuidados'])) {
            $cuidados = \Framework\App\Conexao::anti_injection($_POST['cuidados']);
            if ($cuidados==0) $cuidados = false;
        } else {
            $cuidados = false;
        }
        
        $titulo = __('Relatório de Status de Propostas/O.S');
        
        if (isset($_POST['tipo_grafico'])) {
            $tipo_grafico = \Framework\App\Conexao::anti_injection($_POST['tipo_grafico']);
            if ($tipo_grafico!=='mes' && $tipo_grafico!=='semana' && $tipo_grafico!=='dia') {
                $tipo_grafico = 'mes';
            }
        } else {
            $tipo_grafico = 'mes';
        }
        if (isset($_POST['tipo_visual'])) {
            $tipo_visual = \Framework\App\Conexao::anti_injection($_POST['tipo_visual']);
            if ($tipo_visual==='imprimir') {
                $tipo_visual = 'Imprimir';
            } else if ($tipo_visual==='pdf') {
                $tipo_visual = 'Pdf';
            } else if ($tipo_visual==='pdfdownload') {
                $tipo_visual = 'Pdf_Download';
            } else if ($tipo_visual==='excell') {
                $tipo_visual = 'Excel';
            } else {
                $tipo_visual = false;
            }
        } else {
            $tipo_visual = false;
        }
        // Chama Funcao Correspondente e Imprime Resultado
        $html = $this->graficoProposta($data_inicial, $data_final, $status, $cliente, $cuidados, $tipo_visual);
        $conteudo = array(
            'location' => '#Grafico_relatorio_tabela',
            'js' => '',
            'html' =>  $html
        );
        $this->_Visual->Json_IncluiTipo('Conteudo', $conteudo);
        
        // Imprimir Titulo
        $conteudo = array(
            'location' => '#Grafico_relatorio_titulo',
            'js' => '',
            'html' =>  $titulo
        );
        $this->_Visual->Json_IncluiTipo('Conteudo', $conteudo);
        
        
        // IMpede Historico
        $this->_Visual->Json_Info_Update('Historico', false); 
    }

}

