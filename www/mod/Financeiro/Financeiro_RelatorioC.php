<?php
class Financeiro_RelatorioControle extends Financeiro_Controle
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
    static function Endereco_Financeiro($true=true) {
        $Registro = &\Framework\App\Registro::getInstacia();
        $_Controle = $Registro->_Controle;
        $titulo = __('Relatório Financeiro');
        $link = 'Financeiro/Relatorio/Relatorio';
        if ($true===true) {
            $_Controle->Tema_Endereco($titulo,$link);
        } else {
            $_Controle->Tema_Endereco($titulo);
        }
    }
    static function Endereco_Grafico_Financeiro($true=true) {
        $Registro = &\Framework\App\Registro::getInstacia();
        $_Controle = $Registro->_Controle;
        $titulo = __('Relatório Gráfico Financeiro');
        $link = 'Financeiro/Relatorio/Grafico_Relatorio';
        if ($true===true) {
            $_Controle->Tema_Endereco($titulo,$link);
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
        $this->Relatorio();
        // ORGANIZA E MANDA CONTEUDO
        $this->_Visual->Json_Info_Update('Titulo','Relatório Financeiro'); 
    }
    public function Relatorio($tipo_relatorio = 'Pagar', $data_inicial = '2014-01-01', $data_final = APP_DATA, $categoria = false) {
        
        self::Endereco_Financeiro(false);
        
        if ($categoria=='0') $categoria = false;
        if ($tipo_relatorio!='Pagar' && $tipo_relatorio!='Pago' && $tipo_relatorio!='Receber' && $tipo_relatorio!='Recebido') {
            $tipo_relatorio=__('Recebido');
        }
        
        // Começa e Cria Formulario
        $form = new \Framework\Classes\Form('Relatorio_Financeiro', 'Financeiro/Relatorio/Relatorio_Receber', 'formajax','mini','vertical');
        
        $form->Select_Novo('Relatórios', 'tipo_relatorio', 'tipo_relatorio', '', '', '', false, false, '', 'Escolha um Relatório');
        $form->Select_Opcao('Contas à Pagar','pagar',($tipo_relatorio==='Pagar'?1:0));
        $form->Select_Opcao('Contas Pagas','pago',($tipo_relatorio==='Pago'?1:0));
        $form->Select_Opcao('Contas à Receber','receber',($tipo_relatorio==='Receber'?1:0));
        $form->Select_Opcao('Contas Recebidas','recebido',($tipo_relatorio==='Recebido'?1:0));
        $form->Select_Fim();
        
        // Categorias
        $categorias_selecionadas = $this->_Modelo->db->Sql_Select('Categoria',Array('CA.mod_acc'=>'Financeiro_Financa'));
        if (is_object($categorias_selecionadas)) $categorias_selecionadas = Array($categorias_selecionadas);
        if (!empty($categorias_selecionadas)) {
            $form->Select_Novo('Centro de Custo', 'categoria', 'categoria', '', '', '', false, false, '', 'Escolha um Centro de Custo');
            $form->Select_Opcao('Todos','0',($categoria===false?1:0));
            foreach($categorias_selecionadas as &$valor) {
                $form->Select_Opcao($valor->nome,$valor->id,($categoria==$valor->id?1:0));
            }
            $form->Select_Fim();
        }

        $form->Input_Novo('Data Inicial', 'data_inicial', data_eua_brasil($data_inicial), 'text', 10, '', 'Data do Começo do Relatório', false, '', '','Data','', false);
        $form->Input_Novo('Data Final', 'data_final', data_eua_brasil($data_final), 'text', 10, '', 'Data do Final do Relatório', false, '', '','Data','', false);
        
        /*$form->Select_Novo('Retorno', 'tipo_visual', 'tipo_visual', '', '', '', false, false, '', 'Escolha um Retorno');
        $form->Select_Opcao('Visualizar','normal',1);
        $form->Select_Opcao('Imprimir','imprimir',0);
        $form->Select_Opcao('Download em Excell','excell',0);
        $form->Select_Opcao('Visualizar em PDF','pdf',0);
        $form->Select_Opcao('Download em PDF','pdfdownload',0);
        $form->Select_Fim();*/
        // Bloca Conteudo e Cria Janela de COnfiguração
        $this->_Visual->Blocar($form->retorna_form('Atualizar')); // Relatório
        $this->_Visual->Bloco_Menor_CriaJanela(__('Configuração do Relatório'),'', 0, false);
        
        // Cria Segunda Janela com Parametros pré selecionados
        $tipo_visual = false;
        $html = $this->$tipo_relatorio($data_inicial, $data_final,$categoria, $tipo_visual);
        $titulo = __('Relatório de Contas à Pagar');
        $this->_Visual->Blocar('<span id="relatorio_tabela">'.$html.'</span>');
        $this->_Visual->Bloco_Maior_CriaJanela('<span id="relatorio_titulo">'.$titulo.'</span>','', 0, false);
        
        // ORGANIZA E MANDA CONTEUDO
        $this->_Visual->Json_Info_Update('Titulo','Relatório Financeiro'); 
    }
    public function Relatorio_Receber() {
        // Trata Parametros
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
        if (isset($_POST['categoria'])) {
            $categoria = \Framework\App\Conexao::anti_injection($_POST['categoria']);
            if ($categoria==0) $categoria = false;
        } else {
            $categoria = false;
        }
        
        if (isset($_POST['tipo_relatorio'])) {
            $tipo_relatorio = \Framework\App\Conexao::anti_injection($_POST['tipo_relatorio']);
            if ($tipo_relatorio==='recebido') {
                $titulo = __('Relatório de Contas Recebidas');
                $tipo_relatorio = 'Recebido';
            } else if ($tipo_relatorio==='receber') {
                $titulo = __('Relatório de Contas à Receber');
                $tipo_relatorio = 'Receber';
            } else if ($tipo_relatorio==='pago') {
                $titulo = __('Relatório de Contas Pagas');
                $tipo_relatorio = 'Pago';
            } else {
                $titulo = __('Relatório de Contas à Pagar');
                $tipo_relatorio = 'Pagar';
            }
        } else {
            $tipo_relatorio = 'Pagar';
            $titulo = __('Relatório de Contas à Pagar');
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
        $html = $this->$tipo_relatorio($data_inicial, $data_final, $categoria,$tipo_visual);
        $conteudo = array(
            'location' => '#relatorio_tabela',
            'js' => '',
            'html' =>  $html
        );
        $this->_Visual->Json_IncluiTipo('Conteudo',$conteudo);
        
        // Imprimir Titulo
        $conteudo = array(
            'location' => '#relatorio_titulo',
            'js' => '',
            'html' =>  $titulo
        );
        $this->_Visual->Json_IncluiTipo('Conteudo',$conteudo);
        
        // IMpede Historico
        $this->_Visual->Json_Info_Update('Historico',false); 
    }
    /**
     * Contas a Pagar
     */
    public function Pagar($datainicial, $datafinal,$categoria='false',$export = false) {
        
        // Parametros
        $where  = '{sigla}entrada_motivo = \'Servidor\' AND {sigla}entrada_motivoid = \''.SRV_NAME_SQL.'\' AND {sigla}dt_vencimento >= \''.$datainicial.'\' AND {sigla}dt_vencimento <= \''.$datafinal.'\'';
        // Verifica Categoria
        if ($categoria=='false') {
            $categoria = false;
        } else {
            $categoria = (int) $categoria;
            if ($categoria==0) $categoria = false;
            if ($categoria!==false) {
                $where .= ' AND {sigla}categoria='.$categoria;
            }   
        }
        
        // Exportar
        $html = $this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            false,
            Array(
                'Print'     => TRUE,
                'Pdf'       => TRUE,
                'Excel'     => TRUE,
                'Link'      => 'Financeiro/Relatorio/Pagar/'.$datainicial.'/'.$datafinal.'/'.($categoria===false?'false':$categoria),
            )
        ));
        
        // Chama
        list($tabela,$i,$total) = $this->Movimentacao_Interna($where,'Mini', true, 'Pagar/'.$datainicial.'/'.$datafinal);
        
        // ADiciona Total
        $html_total = '<br><table class="table">
    <tbody>'./*<tr>
        <td width="100" class="text-error"><b>Total à pagar</b></td>
        <td class="text-error"><b>R$6.702.000,00</b></td>
    </tr>
    <tr>
        <td class="text-success"><b>Pago</b></td>
        <td class="text-success"><b>R$366.000,00</b></td>
    </tr><tr>
        <td class="text-info"><b>Total</b></td>
        <td class="text-info"><b>'.Framework\App\Sistema_Funcoes::Tranf_Float_Real($total).'</b></td>
    </tr>*/
    '<tr>
        <td class="text-error"><b>Total</b></td>
        <td class="text-error"><b>'.Framework\App\Sistema_Funcoes::Tranf_Float_Real($total).'</b></td>
    </tr>
    </tbody>
</table>';
        
        if ($i==0) {          
            return '<center><b><font color=\"#FF0000\" size="5">Nenhuma Conta à pagar</font></b></center>';
        } else {
            if ($export!==false) {
                self::Export_Todos($export,$tabela, 'Contas à pagar');
            } else {
                return $html.$this->_Visual->Show_Tabela_DataTable($tabela,'',false).$html_total;
            }
            unset($tabela);
        }
        return false;
    }
    /**
     * Contas a Receber
     */
    public function Receber($datainicial, $datafinal,$categoria='false',$export = false) {
        
        // Parametros
        $where  = '{sigla}saida_motivo = \'Servidor\' AND {sigla}saida_motivoid = \''.SRV_NAME_SQL.'\' AND {sigla}dt_vencimento >= \''.$datainicial.'\' AND {sigla}dt_vencimento <= \''.$datafinal.'\'';
        
        // Verifica Categoria
        if ($categoria=='false') {
            $categoria = false;
        } else {
            $categoria = (int) $categoria;
            if ($categoria==0) $categoria = false;
            if ($categoria!==false) {
                $where .= ' AND {sigla}categoria='.$categoria;
            }   
        }
        
        // Exportar
        $html = $this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            false,
            Array(
                'Print'     => TRUE,
                'Pdf'       => TRUE,
                'Excel'     => TRUE,
                'Link'      => 'Financeiro/Relatorio/Receber/'.$datainicial.'/'.$datafinal.'/'.($categoria===false?'false':$categoria),
            )
        ));
        
        // Chama
        list($tabela,$i,$total) = $this->Movimentacao_Interna($where,'Mini',true, 'Receber/'.$datainicial.'/'.$datafinal);
        
        
        // ADiciona Total
        $html_total = '<br><table class="table">
    <tbody>'./*<tr>
        <td width="100" class="text-error"><b>Total à pagar</b></td>
        <td class="text-error"><b>R$6.702.000,00</b></td>
    </tr>
    <tr>
        <td class="text-success"><b>Pago</b></td>
        <td class="text-success"><b>R$366.000,00</b></td>
    </tr><tr>
        <td class="text-info"><b>Total</b></td>
        <td class="text-info"><b>'.Framework\App\Sistema_Funcoes::Tranf_Float_Real($total).'</b></td>
    </tr>*/
    '<tr>
        <td class="text-success"><b>Total</b></td>
        <td class="text-success"><b>'.Framework\App\Sistema_Funcoes::Tranf_Float_Real($total).'</b></td>
    </tr>
    </tbody>
</table>';
        
        if ($i==0 ) {
            return '<center><b><font color="#FF0000" size="5">Nenhuma Conta à Receber</font></b></center>';
        } else {
            if ($export!==false) {
                self::Export_Todos($export,$tabela, 'Contas à Receber');
            } else {
                return $html.$this->_Visual->Show_Tabela_DataTable($tabela,'',false).$html_total;
            }
            unset($tabela);
        }
        return false;
    }
    public function Pago($datainicial, $datafinal,$categoria='false',$export = false) {
        
        // Parametros
        $where  = '{sigla}entrada_motivo = \'Servidor\' AND {sigla}entrada_motivoid = \''.SRV_NAME_SQL.'\' AND {sigla}dt_vencimento >= \''.$datainicial.'\' AND {sigla}dt_vencimento <= \''.$datafinal.'\'';
        
        // Verifica Categoria
        if ($categoria=='false') {
            $categoria = false;
        } else {
            $categoria = (int) $categoria;
            if ($categoria==0) $categoria = false;
            if ($categoria!==false) {
                $where .= ' AND {sigla}categoria='.$categoria;
            }   
        }
        
        
        // Exportar
        $html = $this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            false,
            Array(
                'Print'     => TRUE,
                'Pdf'       => TRUE,
                'Excel'     => TRUE,
                'Link'      => 'Financeiro/Relatorio/Pago/'.$datainicial.'/'.$datafinal.'/'.($categoria===false?'false':$categoria),
            )
        ));
        // Chama
        list($tabela,$i,$total) = $this->Movimentacao_Interna_Pago($where,'Mini',true, 'Pago/'.$datainicial.'/'.$datafinal);  
        
        // ADiciona Total
        $html_total = '<br><table class="table">
    <tbody>'./*<tr>
        <td width="100" class="text-error"><b>Total à pagar</b></td>
        <td class="text-error"><b>R$6.702.000,00</b></td>
    </tr>
    <tr>
        <td class="text-success"><b>Pago</b></td>
        <td class="text-success"><b>R$366.000,00</b></td>
    </tr><tr>
        <td class="text-info"><b>Total</b></td>
        <td class="text-info"><b>'.Framework\App\Sistema_Funcoes::Tranf_Float_Real($total).'</b></td>
    </tr>*/
    '<tr>
        <td class="text-error"><b>Total</b></td>
        <td class="text-error"><b>'.Framework\App\Sistema_Funcoes::Tranf_Float_Real($total).'</b></td>
    </tr>
    </tbody>
</table>';
        
        if ($i==0) {          
            return '<center><b><font color="#FF0000" size="5">Nenhuma Conta Paga</font></b></center>';
        } else {
            if ($export!==false) {
                self::Export_Todos($export,$tabela, 'Contas Pagas');
            } else {
                return $html.$this->_Visual->Show_Tabela_DataTable($tabela,'',false).$html_total;
            }
            unset($tabela);
        }
        return false;
    }
    /**
     * Contas a Receber
     */
    public function Recebido($datainicial, $datafinal,$categoria='false',$export = false) {   
        
        // Parametros    
        $where  = '{sigla}dt_vencimento >= \''.$datainicial.'\' AND {sigla}dt_vencimento <= \''.$datafinal.'\' AND saida_motivo = \'Servidor\' AND saida_motivoid = \''.SRV_NAME_SQL.'\'';
        
        // Verifica Categoria
        if ($categoria=='false') {
            $categoria = false;
        } else {
            $categoria = (int) $categoria;
            if ($categoria==0) $categoria = false;
            if ($categoria!==false) {
                $where .= ' AND {sigla}categoria='.$categoria;
            }   
        }
        
        // Exportar
        $html = $this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            false,
            Array(
                'Print'     => TRUE,
                'Pdf'       => TRUE,
                'Excel'     => TRUE,
                'Link'      => 'Financeiro/Relatorio/Recebido/'.$datainicial.'/'.$datafinal.'/'.($categoria===false?'false':$categoria),
            )
        ));
        
        // Chama
        list($tabela,$i,$total) = $this->Movimentacao_Interna_Pago($where,'Mini',true, 'Recebido/'.$datainicial.'/'.$datafinal);
        
        // ADiciona Total
        $html_total = '<br><table class="table">
    <tbody>'./*<tr>
        <td width="100" class="text-error"><b>Total à pagar</b></td>
        <td class="text-error"><b>R$6.702.000,00</b></td>
    </tr>
    <tr>
        <td class="text-success"><b>Pago</b></td>
        <td class="text-success"><b>R$366.000,00</b></td>
    </tr><tr>
        <td class="text-info"><b>Total</b></td>
        <td class="text-info"><b>'.Framework\App\Sistema_Funcoes::Tranf_Float_Real($total).'</b></td>
    </tr>*/
    '<tr>
        <td class="text-success"><b>Total</b></td>
        <td class="text-success"><b>'.Framework\App\Sistema_Funcoes::Tranf_Float_Real($total).'</b></td>
    </tr>
    </tbody>
</table>';
        
        if ($i==0 ) {
            return '<center><b><font color="#FF0000" size="5">Nenhuma Conta Recebida</font></b></center>';
        } else {
            if ($export!==false) {
                self::Export_Todos($export,$tabela, 'Contas Recebidas');
            } else {
                return $html.$this->_Visual->Show_Tabela_DataTable($tabela,'',false).$html_total;
            }
            unset($tabela);
        }
        return false;
    }
    
    
    
    
    
    public function Grafico_Relatorio($tipo_relatorio_Grafico = 'Pagar', $data_inicial = '2014-01-01', $data_final = APP_DATA, $categoria = false, $tipo_grafico = 'mes') {
        
        self::Endereco_Grafico_Financeiro(false);
        
        if ($categoria=='0') $categoria = false;
        if ($tipo_relatorio_Grafico!='Pagar' && $tipo_relatorio_Grafico!='Pago' && $tipo_relatorio_Grafico!='Receber' && $tipo_relatorio_Grafico!='Recebido') {
            $tipo_relatorio_Grafico='Recebido';
        }
        
        // Começa e Cria Formulario
        $form = new \Framework\Classes\Form('Grafico_Relatorio_Financeiro', 'Financeiro/Relatorio/Grafico_Relatorio_Receber', 'formajax','mini','vertical');
        
        $form->Select_Novo('Relatórios', 'tipo_relatorio_Grafico', 'tipo_relatorio_Grafico', '', '', '', false, false, '', 'Escolha um Relatório');
        $form->Select_Opcao('Contas à Pagar','pagar',($tipo_relatorio_Grafico==='Pagar'?1:0));
        $form->Select_Opcao('Contas Pagas','pago',($tipo_relatorio_Grafico==='Pago'?1:0));
        $form->Select_Opcao('Contas à Receber','receber',($tipo_relatorio_Grafico==='Receber'?1:0));
        $form->Select_Opcao('Contas Recebidas','recebido',($tipo_relatorio_Grafico==='Recebido'?1:0));
        $form->Select_Fim();
        
        // Categorias
        $categorias_selecionadas = $this->_Modelo->db->Sql_Select('Categoria',Array('CA.mod_acc'=>'Financeiro_Financa'));
        if (!empty($categorias_selecionadas)) {
            $form->Select_Novo('Centro de Custo', 'categoria', 'categoria', '', '', '', false, false, '', 'Escolha um Centro de Custo');
            $form->Select_Opcao('Todos','0',($categoria===false?1:0));
            foreach($categorias_selecionadas as &$valor) {
                $form->Select_Opcao($valor->nome,$valor->id,($categoria==$valor->id?1:0));
            }
            $form->Select_Fim();
        }
        
        $form->Input_Novo('Data Inicial', 'data_inicial', data_eua_brasil($data_inicial), 'text', 10, '', 'Data do Começo do Relatório', false, '', '','Data','', false);
        $form->Input_Novo('Data Final', 'data_final', data_eua_brasil($data_final), 'text', 10, '', 'Data do Final do Relatório', false, '', '','Data','', false);
        
        /*$form->Select_Novo('Retorno', 'tipo_visual', 'tipo_visual', '', '', '', false, false, '', 'Escolha um Retorno');
        $form->Select_Opcao('Visualizar','normal',1);
        $form->Select_Opcao('Imprimir','imprimir',0);
        $form->Select_Opcao('Download em Excell','excell',0);
        $form->Select_Opcao('Visualizar em PDF','pdf',0);
        $form->Select_Opcao('Download em PDF','pdfdownload',0);
        $form->Select_Fim();*/
        
        // Tipo de Grafico
        $form->Select_Novo('Tipo de Gráfico', 'tipo_grafico', 'tipo_grafico', '', '', '', false, false, '', 'Escolha um Tipo de Gráfico');
        $form->Select_Opcao('Mensal','mes',1);
        $form->Select_Opcao('Diário','dia',0);
        $form->Select_Opcao('Semanal','semana',0);
        $form->Select_Fim();
        
        // Bloca Conteudo e Cria Janela de COnfiguração
        $this->_Visual->Blocar($form->retorna_form('Atualizar')); // Relatório
        $this->_Visual->Bloco_Menor_CriaJanela(__('Configuração do Relatório'),'', 0, false);
        
        // Cria Segunda Janela com Parametros pré selecionados
        $tipo_visual = false;
        
        // Chama Funcao
        $tipo_relatorio_Grafico = 'Grafico_'.$tipo_relatorio_Grafico;
        $html = $this->$tipo_relatorio_Grafico($data_inicial, $data_final,$categoria, $tipo_grafico, $tipo_visual);
        $titulo = __('Relatório de Contas à Pagar');
        $this->_Visual->Blocar('<span id="Grafico_relatorio_tabela">'.$html.'</span>');
        $this->_Visual->Bloco_Maior_CriaJanela('<span id="Grafico_relatorio_titulo">'.$titulo.'</span>','', 0, false);
        
        // ORGANIZA E MANDA CONTEUDO
        $this->_Visual->Json_Info_Update('Titulo','Relatório Financeiro'); 
    }
    public function Grafico_Relatorio_Receber() {
        // Trata Parametros
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
        if (isset($_POST['categoria'])) {
            $categoria = \Framework\App\Conexao::anti_injection($_POST['categoria']);
            if ($categoria==0) $categoria = false;
        } else {
            $categoria = false;
        }
        
        if (isset($_POST['tipo_relatorio_Grafico'])) {
            $tipo_relatorio_Grafico = \Framework\App\Conexao::anti_injection($_POST['tipo_relatorio_Grafico']);
            if ($tipo_relatorio_Grafico==='recebido') {
                $titulo = __('Relatório de Contas Recebidas');
                $tipo_relatorio_Grafico = 'Recebido';
            } else if ($tipo_relatorio_Grafico==='receber') {
                $titulo = __('Relatório de Contas à Receber');
                $tipo_relatorio_Grafico = 'Receber';
            } else if ($tipo_relatorio_Grafico==='pago') {
                $titulo = __('Relatório de Contas Pagas');
                $tipo_relatorio_Grafico = 'Pago';
            } else {
                $titulo = __('Relatório de Contas à Pagar');
                $tipo_relatorio_Grafico = 'Pagar';
            }
        } else {
            $tipo_relatorio_Grafico = 'Pagar';
            $titulo = __('Relatório de Contas à Pagar');
        }
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
        $tipo_relatorio_Grafico = 'Grafico_'.$tipo_relatorio_Grafico;
        // Chama Funcao Correspondente e Imprime Resultado
        $html = $this->$tipo_relatorio_Grafico($data_inicial, $data_final, $categoria,$tipo_grafico,$tipo_visual);
        $conteudo = array(
            'location' => '#Grafico_relatorio_tabela',
            'js' => '',
            'html' =>  $html
        );
        $this->_Visual->Json_IncluiTipo('Conteudo',$conteudo);
        
        // Imprimir Titulo
        $conteudo = array(
            'location' => '#Grafico_relatorio_titulo',
            'js' => '',
            'html' =>  $titulo
        );
        $this->_Visual->Json_IncluiTipo('Conteudo',$conteudo);
        
        // IMpede Historico
        $this->_Visual->Json_Info_Update('Historico',false); 
    }
    /**
     * Contas a Pagar
     */
    public function Grafico_Pagar($datainicial, $datafinal,$categoria='false',$tipo_grafico='mes',$export = false) {
        
        // Parametros
        $where  = '{sigla}entrada_motivo = \'Servidor\' AND {sigla}entrada_motivoid = \''.SRV_NAME_SQL.'\' AND {sigla}dt_vencimento >= \''.$datainicial.'\' AND {sigla}dt_vencimento <= \''.$datafinal.'\'';
        // Verifica Categoria
        if ($categoria=='false') {
            $categoria = false;
        } else {
            $categoria = (int) $categoria;
            if ($categoria==0) $categoria = false;
            if ($categoria!==false) {
                $where .= ' AND {sigla}categoria='.$categoria;
            }   
        }
        
        // Exportar
        $html = ''/*.$this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            false,
            Array(
                'Print'     => TRUE,
                'Pdf'       => TRUE,
                'Excel'     => TRUE,
                'Link'      => 'Financeiro/Relatorio/Pagar/'.$datainicial.'/'.$datafinal.'/'.($categoria===false?'false':$categoria).'/'.$tipo_grafico,
            )
        ))*/;
        
        // Chama
        list($html,$i,$total) = $this->Movimentacao_Interna_Grafico('Contas à pagar',$where,$tipo_grafico, true, 'Pagar/'.$datainicial.'/'.$datafinal);
        
        // ADiciona Total
        $html_total = '<br><table class="table">
    <tbody>'./*<tr>
        <td width="100" class="text-error"><b>Total à pagar</b></td>
        <td class="text-error"><b>R$6.702.000,00</b></td>
    </tr>
    <tr>
        <td class="text-success"><b>Pago</b></td>
        <td class="text-success"><b>R$366.000,00</b></td>
    </tr><tr>
        <td class="text-info"><b>Total</b></td>
        <td class="text-info"><b>'.Framework\App\Sistema_Funcoes::Tranf_Float_Real($total).'</b></td>
    </tr>*/
    '<tr>
        <td class="text-error"><b>Total Movimentado</b></td>
        <td class="text-error"><b>'.Framework\App\Sistema_Funcoes::Tranf_Float_Real($total).'</b></td>
    </tr>
    </tbody>
</table>';
        
        if ($i==0) {          
            return '<center><b><font color=\"#FF0000\" size="5">Nenhuma Conta à pagar</font></b></center>';
        } else {
            if ($export!==false) {
                self::Export_Todos($export,$tabela, 'Contas à pagar');
            } else {
                return $html.$html_total;
            }
            unset($tabela);
        }
        return false;
    }
    /**
     * Contas a Receber
     */
    public function Grafico_Receber($datainicial, $datafinal,$categoria='false', $tipo_grafico = 'mes',$export = false) {
        
        // Parametros
        $where  = '{sigla}saida_motivo = \'Servidor\' AND {sigla}saida_motivoid = \''.SRV_NAME_SQL.'\' AND {sigla}dt_vencimento >= \''.$datainicial.'\' AND {sigla}dt_vencimento <= \''.$datafinal.'\'';
        
        // Verifica Categoria
        if ($categoria=='false') {
            $categoria = false;
        } else {
            $categoria = (int) $categoria;
            if ($categoria==0) $categoria = false;
            if ($categoria!==false) {
                $where .= ' AND {sigla}categoria='.$categoria;
            }   
        }
        
        // Exportar
        $html = ''/*.$this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            false,
            Array(
                'Print'     => TRUE,
                'Pdf'       => TRUE,
                'Excel'     => TRUE,
                'Link'      => 'Financeiro/Relatorio/Receber/'.$datainicial.'/'.$datafinal.'/'.($categoria===false?'false':$categoria),
            )
        ))*/;
        
        // Chama
        list($html,$i,$total) = $this->Movimentacao_Interna_Grafico('Contas à Receber',$where,$tipo_grafico, true, 'Receber/'.$datainicial.'/'.$datafinal);
        
        
        // ADiciona Total
        $html_total = '<br><table class="table">
    <tbody>'./*<tr>
        <td width="100" class="text-error"><b>Total à pagar</b></td>
        <td class="text-error"><b>R$6.702.000,00</b></td>
    </tr>
    <tr>
        <td class="text-success"><b>Pago</b></td>
        <td class="text-success"><b>R$366.000,00</b></td>
    </tr><tr>
        <td class="text-info"><b>Total Movimentado</b></td>
        <td class="text-info"><b>'.Framework\App\Sistema_Funcoes::Tranf_Float_Real($total).'</b></td>
    </tr>*/
    '<tr>
        <td class="text-success"><b>Total Movimentado</b></td>
        <td class="text-success"><b>'.Framework\App\Sistema_Funcoes::Tranf_Float_Real($total).'</b></td>
    </tr>
    </tbody>
</table>';
        
        if ($i==0 ) {
            return '<center><b><font color="#FF0000" size="5">Nenhuma Conta à Receber</font></b></center>';
        } else {
            if ($export!==false) {
                self::Export_Todos($export,$tabela, 'Contas à Receber');
            } else {
                return $html.$html_total;
            }
            unset($tabela);
        }
        return false;
    }
    public function Grafico_Pago($datainicial, $datafinal,$categoria='false', $tipo_grafico = 'mes',$export = false) {
        
        // Parametros
        $where  = '{sigla}entrada_motivo = \'Servidor\' AND {sigla}entrada_motivoid = \''.SRV_NAME_SQL.'\' AND {sigla}dt_vencimento >= \''.$datainicial.'\' AND {sigla}dt_vencimento <= \''.$datafinal.'\'';
        
        // Verifica Categoria
        if ($categoria=='false') {
            $categoria = false;
        } else {
            $categoria = (int) $categoria;
            if ($categoria==0) $categoria = false;
            if ($categoria!==false) {
                $where .= ' AND {sigla}categoria='.$categoria;
            }   
        }
        
        
        // Exportar
        $html = ''/*.$this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            false,
            Array(
                'Print'     => TRUE,
                'Pdf'       => TRUE,
                'Excel'     => TRUE,
                'Link'      => 'Financeiro/Relatorio/Pago/'.$datainicial.'/'.$datafinal.'/'.($categoria===false?'false':$categoria),
            )
        ))*/;
        // Chama
        list($html,$i,$total) = $this->Movimentacao_Interna_Grafico_Pago('Contas Pagas', $where,$tipo_grafico, true, 'Pago/'.$datainicial.'/'.$datafinal);  
        
        // ADiciona Total
        $html_total = '<br><table class="table">
    <tbody>'./*<tr>
        <td width="100" class="text-error"><b>Total à pagar</b></td>
        <td class="text-error"><b>R$6.702.000,00</b></td>
    </tr>
    <tr>
        <td class="text-success"><b>Pago</b></td>
        <td class="text-success"><b>R$366.000,00</b></td>
    </tr><tr>
        <td class="text-info"><b>Total Movimentado</b></td>
        <td class="text-info"><b>'.Framework\App\Sistema_Funcoes::Tranf_Float_Real($total).'</b></td>
    </tr>*/
    '<tr>
        <td class="text-error"><b>Total Movimentado</b></td>
        <td class="text-error"><b>'.Framework\App\Sistema_Funcoes::Tranf_Float_Real($total).'</b></td>
    </tr>
    </tbody>
</table>';
        
        if ($i==0) {          
            return '<center><b><font color="#FF0000" size="5">Nenhuma Conta Paga</font></b></center>';
        } else {
            if ($export!==false) {
                self::Export_Todos($export,$tabela, 'Contas Pagas');
            } else {
                return $html.$html_total;
            }
            unset($tabela);
        }
        return false;
    }
    /**
     * Contas a Receber
     */
    public function Grafico_Recebido($datainicial, $datafinal,$categoria='false', $tipo_grafico = 'mes',$export = false) {   
        
        // Parametros    
        $where  = '{sigla}dt_vencimento >= \''.$datainicial.'\' AND {sigla}dt_vencimento <= \''.$datafinal.'\' AND saida_motivo = \'Servidor\' AND saida_motivoid = \''.SRV_NAME_SQL.'\'';
        
        // Verifica Categoria
        if ($categoria=='false') {
            $categoria = false;
        } else {
            $categoria = (int) $categoria;
            if ($categoria==0) $categoria = false;
            if ($categoria!==false) {
                $where .= ' AND {sigla}categoria='.$categoria;
            }   
        }
        
        // Exportar
        $html = ''/*.$this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            false,
            Array(
                'Print'     => TRUE,
                'Pdf'       => TRUE,
                'Excel'     => TRUE,
                'Link'      => 'Financeiro/Relatorio/Recebido/'.$datainicial.'/'.$datafinal.'/'.($categoria===false?'false':$categoria),
            )
        ))*/;
        
        // Chama
        list($html,$i,$total) = $this->Movimentacao_Interna_Grafico_Pago('Contas Recebidas',$where,$tipo_grafico, true, 'Recebido/'.$datainicial.'/'.$datafinal);
        
        // ADiciona Total
        $html_total = '<br><table class="table">
    <tbody>'./*<tr>
        <td width="100" class="text-error"><b>Total à pagar</b></td>
        <td class="text-error"><b>R$6.702.000,00</b></td>
    </tr>
    <tr>
        <td class="text-success"><b>Pago</b></td>
        <td class="text-success"><b>R$366.000,00</b></td>
    </tr><tr>
        <td class="text-info"><b>Total Movimentado</b></td>
        <td class="text-info"><b>'.Framework\App\Sistema_Funcoes::Tranf_Float_Real($total).'</b></td>
    </tr>*/
    '<tr>
        <td class="text-success"><b>Total Movimentado</b></td>
        <td class="text-success"><b>'.Framework\App\Sistema_Funcoes::Tranf_Float_Real($total).'</b></td>
    </tr>
    </tbody>
</table>';
        
        if ($i==0 ) {
            return '<center><b><font color="#FF0000" size="5">Nenhuma Conta Recebida</font></b></center>';
        } else {
            if ($export!==false) {
                self::Export_Todos($export,$tabela, 'Contas Recebidas');
            } else {
                return $html.$html_total;
            }
            unset($tabela);
        }
        return false;
    }
}
?>
