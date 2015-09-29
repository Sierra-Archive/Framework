<?php
class usuario_mensagem_RelatorioControle extends usuario_mensagem_Controle
{
    /**
    * Construtor
    * 
    * @name __construct
    * @access public
    * 
    * @uses ticket_ListarModelo Carrega ticket Modelo
    * @uses ticket_ListarVisual Carrega ticket Visual
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 0.4.2
    */
    public function __construct(){
        // construct
        parent::__construct();
    }
    static function Endereco_Relatorio($true=true){
        $Registro = &\Framework\App\Registro::getInstacia();
        $_Controle = $Registro->_Controle;
        $titulo = __('Relatório');
        $link = 'Financeiro/Relatorio/Relatorio';
        if($true===true){
            $_Controle->Tema_Endereco($titulo,$link);
        }else{
            $_Controle->Tema_Endereco($titulo);
        }
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
    public function Main(){
        \Framework\App\Sistema_Funcoes::Redirect(URL_PATH.'usuario_mensagem/Relatorio/Relatorio/');
        return false;
    }
    public function Relatorio($tipo_relatorio = 'Aberto', $data_inicial = '2014-01-01', $data_final = APP_DATA){
        
        self::Endereco_Relatorio(false);
        
        if($tipo_relatorio!='Aberto' && $tipo_relatorio!='Assunto' && $tipo_relatorio!='Esgotado' && $tipo_relatorio!='Finalizado' && $tipo_relatorio!='Origem' && $tipo_relatorio!='Produto' && $tipo_relatorio!='Qtd_Cidade' && $tipo_relatorio!='Qtd_Uf'){
            $tipo_relatorio='Aberto';
        }
        
        // Começa e Cria Formulario
        $form = new \Framework\Classes\Form('Relatorio_Financeiro', 'usuario_mensagem/Relatorio/Relatorio_Receber', 'formajax','mini','vertical');
        
        $form->Select_Novo('Relatórios', 'tipo_relatorio', 'tipo_relatorio', '', '', '', false, false, '', 'Escolha um Relatório');
        $form->Select_Opcao('Chamados Abertos','Aberto',    ($tipo_relatorio==='Aberto'?1:0));
        $form->Select_Opcao('Chamados por Assunto','Assunto',   ($tipo_relatorio==='Assunto'?1:0));
        $form->Select_Opcao('Chamados Esgotados','Esgotado',  ($tipo_relatorio==='Esgotado'?1:0));
        $form->Select_Opcao('Chamados Finalizados','Finalizado',($tipo_relatorio==='Finalizado'?1:0));
        $form->Select_Opcao('Chamados por Origem','Origem',    ($tipo_relatorio==='Origem'?1:0));
        $form->Select_Opcao('Chamados por Produtos','Produto',   ($tipo_relatorio==='Produto'?1:0));
        $form->Select_Opcao('Chamados por Cidade','Qtd_Cidade',($tipo_relatorio==='Qtd_Cidade'?1:0));
        $form->Select_Opcao('Chamados por Uf','Qtd_Uf',   ($tipo_relatorio==='Qtd_Uf'?1:0));
        $form->Select_Fim();
        
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
        $html = $this->$tipo_relatorio($data_inicial, $data_final);
        $titulo = __('Relatório de Chamados');
        $this->_Visual->Blocar('<span id="relatorio_tabela">'.$html.'</span>');
        $this->_Visual->Bloco_Maior_CriaJanela('<span id="relatorio_titulo">'.$titulo.'</span>','', 0, false);
        
        // ORGANIZA E MANDA CONTEUDO
        $this->_Visual->Json_Info_Update('Titulo',$titulo); 
    }
    public function Relatorio_Receber(){
        // Trata Parametros
        if(isset($_POST['data_inicial'])){
            $data_inicial = data_brasil_eua(\Framework\App\Conexao::anti_injection($_POST['data_inicial']));
        }else{
            $data_inicial = '2014-01-01';
        }
        if(isset($_POST['data_final'])){
            $data_final = data_brasil_eua(\Framework\App\Conexao::anti_injection($_POST['data_final']));
        }else{
            $data_final = APP_DATA;
        }
        
        if(isset($_POST['tipo_relatorio'])){
            $tipo_relatorio = \Framework\App\Conexao::anti_injection($_POST['tipo_relatorio']);
            if($tipo_relatorio==='Aberto'){
                $titulo = __('Relatório de Chamados Abertos');
                $tipo_relatorio = 'Aberto';
            }else if($tipo_relatorio==='Assunto'){
                $titulo = __('Relatório Agrupado por Assuntos');
                $tipo_relatorio = 'Assunto';
            }else if($tipo_relatorio==='Esgotado'){
                $titulo = __('Relatório de Esgotados');
                $tipo_relatorio = 'Esgotado';
            }else if($tipo_relatorio==='Finalizado'){
                $titulo = __('Relatório de Finalizados');
                $tipo_relatorio = __('Finalizado');
            }else if($tipo_relatorio==='Origem'){
                $titulo = __('Relatório Agrupado por Origens');
                $tipo_relatorio = __('Origem');
            }else if($tipo_relatorio==='Produto'){
                $titulo = __('Relatório Agrupado por Produtos');
                $tipo_relatorio = 'Produto';
            }else if($tipo_relatorio==='Qtd_Cidade'){
                $titulo = __('Relatório de Chamados Quantitativos Agrupados por Cidade');
                $tipo_relatorio = 'Qtd_Cidade';
            }else{
                $titulo = __('Relatório de Chamados Quantitativos Agrupados por Estado');
                $tipo_relatorio = 'Qtd_Uf';
            }
        }else{
            $tipo_relatorio = 'Aberto';
            $titulo = __('Relatório de Chamados Abertos');
        }
        /*if(isset($_POST['tipo_visual'])){
            $tipo_visual = \Framework\App\Conexao::anti_injection($_POST['tipo_visual']);
            if($tipo_visual==='imprimir'){
                $tipo_visual = 'Imprimir';
            }else if($tipo_visual==='pdf'){
                $tipo_visual = 'Pdf';
            }else if($tipo_visual==='pdfdownload'){
                $tipo_visual = 'Pdf_Download';
            }else if($tipo_visual==='excell'){
                $tipo_visual = 'Excel';
            }else{
                $tipo_visual = false;
            }
        }else{
            $tipo_visual = false;
        }*/
        
        // Chama Funcao Correspondente e Imprime Resultado
        $html = $this->$tipo_relatorio($data_inicial, $data_final);
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
            'html' =>  $titulo.' (<span id="DataTable_Contador">0</span>)'
        );
        $this->_Visual->Json_IncluiTipo('Conteudo',$conteudo);
        
        // IMpede Historico
        $this->_Visual->Json_Info_Update('Historico',false); 
    }
    /**
     * Chamados Abertos
     */
    public function Aberto($datainicial, $datafinal){
        
        
        $tabela = Array(
            'Protocolo','Cliente','Assunto','Mensagem','Data Criação','Data Ult. Mod.'/*,'Funções'*/
        );
        return $this->_Visual->Show_Tabela_DataTable_Massiva($tabela,'usuario_mensagem/Relatorio/Aberto/'.$datainicial.'/'.$datafinal,'',false);
        

//$titulo = __('Listagem de Senhas');  //(<span id="DataTable_Contador">0</span>)
        return false;
    }
    /**
     * Chamados Assuntos
     */
    public function Assunto($datainicial, $datafinal){
        $tabela = Array(
            'Protocolo','Cliente','Assunto','Mensagem','Tipo','Data Criação','Data Ult. Mod.'/*,'Funções'*/
        );
        return $this->_Visual->Show_Tabela_DataTable_Massiva($tabela,'usuario_mensagem/Relatorio/Assunto/'.$datainicial.'/'.$datafinal,'',false);
        //$titulo = __('Listagem de Senhas');  //(<span id="DataTable_Contador">0</span>)
        return false;
    }
    /**
     * Chamados Esgotados
     */
    public function Esgotado($datainicial, $datafinal){
        $tabela = Array(
            'Protocolo','Cliente','Assunto','Mensagem','Data Criação','Data Ult. Mod.'/*,'Funções'*/
        );
        return $this->_Visual->Show_Tabela_DataTable_Massiva($tabela,'usuario_mensagem/Relatorio/Esgotado/'.$datainicial.'/'.$datafinal,'',false);
        //$titulo = __('Listagem de Senhas');  //(<span id="DataTable_Contador">0</span>)
        return false;
    }
    /**
     * Chamados Finalizados
     */
    public function Finalizado($datainicial, $datafinal){
        $tabela = Array(
            'Protocolo','Cliente','Assunto','Mensagem','Data Criação','Data Ult. Mod.'/*,'Funções'*/
        );
        return $this->_Visual->Show_Tabela_DataTable_Massiva($tabela,'usuario_mensagem/Relatorio/Finalizado/'.$datainicial.'/'.$datafinal,'',false);
        //$titulo = __('Listagem de Senhas');  //(<span id="DataTable_Contador">0</span>)
        return false;
    }
    /**
     * Chamados Origens
     */
    public function Origem($datainicial, $datafinal){
        // EM uso
        $tabela = Array(
            'Protocolo','Cliente','Assunto','Mensagem','Data Criação','Data Ult. Mod.'/*,'Funções'*/
        );
        return $this->_Visual->Show_Tabela_DataTable_Massiva($tabela,'usuario_mensagem/Relatorio/Origem/'.$datainicial.'/'.$datafinal,'',false);
        //$titulo = __('Listagem de Senhas');  //(<span id="DataTable_Contador">0</span>)
        return false;
    }
    /**
     * Chamados Produtos
     */
    public function Produto($datainicial, $datafinal){
        $tabela = Array(
            'Marca','Linha','Produto','Mensagem','Data Criação','Data Ult. Mod.'/*,'Funções'*/
        );
        return $this->_Visual->Show_Tabela_DataTable_Massiva($tabela,'usuario_mensagem/Relatorio/Produto/'.$datainicial.'/'.$datafinal,'',false);
        //$titulo = __('Listagem de Senhas');  //(<span id="DataTable_Contador">0</span>)
        return false;
    }
    /**
     * Qtd_Cidade
     */
    public function Qtd_Cidade($datainicial, $datafinal){
        $tabela = Array(
            'Cidade / UF','No. de Chamados','Data Criação','Data Ult. Mod.'/*,'Funções'*/
        );
        return $this->_Visual->Show_Tabela_DataTable_Massiva($tabela,'usuario_mensagem/Relatorio/Qtd_Cidade/'.$datainicial.'/'.$datafinal,'',false);
        //$titulo = __('Listagem de Senhas');  //(<span id="DataTable_Contador">0</span>)
        return false;
    }
    /**
     * Qtd_Uf
     */
    public function Qtd_Uf($datainicial, $datafinal){
        $tabela = Array(
            'Estado','No. de Chamados','Data Criação','Data Ult. Mod.'/*,'Funções'*/
        );
        return $this->_Visual->Show_Tabela_DataTable_Massiva($tabela,'usuario_mensagem/Relatorio/Qtd_Uf/'.$datainicial.'/'.$datafinal,'',false);
        //$titulo = __('Listagem de Senhas');  //(<span id="DataTable_Contador">0</span>)
        return false;
    }
}
?>
