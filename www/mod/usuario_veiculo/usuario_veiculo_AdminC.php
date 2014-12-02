<?php
class usuario_veiculo_AdminControle extends usuario_veiculo_Controle
{
    /**
    * Construtor
    * 
    * @name __construct
    * @access public
    * 
    * @uses usuario_veiculo_ListarModelo Carrega usuario_veiculo Modelo
    * @uses usuario_veiculo_ListarVisual Carrega usuario_veiculo Visual
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
     */
    public function Veiculos_UploadVer($camada,$id){
        $camada = (string) \anti_injection($camada);
        $id = (int) \anti_injection($id);
       
        
    }
    /**
     * 
     */
    public function Veiculos_Upload($id){
        $id = (int) $id;
        $fileTypes = array('jpg','jpeg','gif','png'); // File extensions
        $dir = 'usuario_veiculo'.DS;
        $ext = $this->Upload($dir,$fileTypes,$id);
        if($ext!='falso'){
            $this->_Modelo->Veiculos_Upload_Alterar($id,$ext); 
        }
    }
    /**
    * Função Main, Principal
    * 
    * @name Main
    * @access public
    * 
    * @uses usuario_veiculo_AdminControle::$veiculos_lista
    * @uses usuario_veiculo_AdminControle::$marcas_carregajanelaadd
    * @uses \Framework\App\Visual::$Json_Start
    * 
    * @return void 
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 2.0
    */
    public function Main(){
        // carrega lista de veiculos
        $this->veiculos_lista();
        // carrega form de cadastro de marcas
        $this->marcas_carregajanelaadd();
        // carrega form de cadastro de veiculos
        $this->veiculos_carregajanelaadd();
        // ORGANIZA E MANDA CONTEUDO
        $this->_Visual->Json_Info_Update('Titulo','Veiculos');         
    }
    /**
    * Printa todos os Veiculos na tela
    * 
    * @name veiculos_lista
    * @access public
    * 
    * @uses veiculos_ListarModelo::$retorna_veiculos
    * @uses \Framework\App\Visual::$Show_Tabela_DataTable
    * @uses \Framework\App\Visual::$Bloco_Maior_CriaTitulo
    * @uses \Framework\App\Visual::$bloco_maior_criaconteudo
    * 
    * @return void 
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 2.0
    */
    public function veiculos_lista(){
        $veiculos = Array();
        $this->_Modelo->retorna_veiculos($veiculos);
        if(!empty($veiculos)){
            reset($veiculos);
            $i = 0;           
            
            foreach ($veiculos as $indice=>&$valor) {
                $tabela['Id'][$i] = $valor['id'];
                $tabela['Foto'][$i] = $this->_Visual->Show_Upload('usuario_veiculo','Admin','Veiculos','VeiculoImagem'.$valor['id'],$valor['foto'],'usuario_veiculo'.DS,$valor['id']);
                $tabela['Categoria'][$i] = $valor['categoria'];
                $tabela['Ano'][$i] = $valor['ano'];
                $tabela['Moto'][$i] = $valor['marca'].' '.$valor['modelo'];
                $tabela['CC'][$i] = $valor['cc'];
                $tabela['Até 3 dias<br>Entre 3 e 10 dias<br>+10 dias'][$i] = 'R$'.number_format($valor['valor1'], 2, ',', '.').
                '<br>R$'.number_format($valor['valor2'], 2, ',', '.').
                '<br>R$'.number_format($valor['valor3'], 2, ',', '.');
                $tabela['Franquia'][$i] = 'R$'.number_format($valor['franquia'], 2, ',', '.');
                $tabela['Funções'][$i] = '
                <a title="Editar" class="lajax explicar-titulo" href="'.URL_PATH.'usuario_veiculo/Admin/veiculos_carregajanelaEdit/'.$valor['id'].'/" acao="">
                <img alt="Editar" src="'.WEB_URL.'img/turboadmin/icon_edit.png">
                </a>
                <a confirma="Deseja realmente deletar esse veiculo?" title="Deletar" class="lajax explicar-titulo" href="'.URL_PATH.'usuario_veiculo/Admin/veiculos_Del/'.$valor['id'].'/" acao="">
                <img alt="Deletar" src="'.WEB_URL.'img/turboadmin/icon_bad.png">
                </a>';
                ++$i;
            }
            $this->_Visual->Show_Tabela_DataTable($tabela);
            $this->_Visual->Bloco_Maior_CriaJanela('Veiculos ('.$i.')');
            unset($tabela);
        }else{     
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">Não há nenhum veiculo cadastrado.</font></b></center>');
            $this->_Visual->Bloco_Maior_CriaJanela('Veiculos (0)');
        } 
    }
    /**
    * Deleta Veiculo
    * 
    * @name veiculos_Del
    * @access public
    * 
    * @uses usuario_veiculo_AdminModelo::$veiculos_Del
    * @uses \Framework\App\Visual::$Json_IncluiTipo
    * @uses usuario_veiculo_AdminControle::$veiculos_lista
    * 
    * @return void 
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 2.0
    */
    public function veiculos_Del($id){
        global $language;
        
    	$id = (int) $id;
    	$sucesso = $this->_Modelo->veiculos_Del($id);
    	if($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => 'Deletado',
                "mgs_secundaria" => 'Deletado com sucesso.'
            );
    	}else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => $language['mens_erro']['erro'],
                "mgs_secundaria" => $language['mens_erro']['erro']
            );
    	}
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        
        $this->Main();
    }
    /**
    * Cria Janela Do Formulario de Cadastro de Veiculos
    * 
    * @name veiculos_carregajanelaadd
    * @access public
    * 
    * @param Class &$controle Classe Controle Atual passada por Ponteiro
    * @param Class &$modelo Modelo Passado por Ponteiro
    * @param Class &$Visual Visual Passado por Ponteiro
    * 
    * @uses usuario_social_Modelo Carrega Persona Modelo
    * @uses usuario_social_Modelo::$retorna_usuario_social Retorna Pessoas
    * @uses financeiroControle::$veiculos_formcadastro retorna Formulario de Cadastro de Veiculos
    * @uses \Framework\App\Visual::$blocar Add html ao bloco de conteudo
    * @uses \Framework\App\Visual::$Bloco_Menor_CriaJanela Add html do bloco a uma Janela Lateral Direita
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 2.0
    */
    public function veiculos_carregajanelaadd(){
        // carrega marcas
        $marcas = Array();
        $qnt = $this->_Modelo->retorna_marcas($marcas);
        // cadastro de veiculos
        $form = new \Framework\Classes\Form('adminformveiculossend','usuario_veiculo/Admin/veiculos_inserir/','formajax');
        usuario_veiculo_AdminControle::veiculos_form($this, $this->_Visual, $form, $marcas);
        $formulario = $form->retorna_form('Cadastrar');
        $this->_Visual->Blocar($formulario);
        $this->_Visual->Bloco_Menor_CriaJanela('Cadastro de Veiculo');
        
    }
    public function veiculos_carregajanelaEdit($id){
        $id = (int) $id;
        // carrega marcas
        $marcas = Array();
        $qnt = $this->_Modelo->retorna_marcas($marcas);
        // recupera veiculo
        $veiculo = $this->_Modelo->retorna_veiculo($id);
        // cadastro de veiculos
        $form = new \Framework\Classes\Form('adminformveiculossend','usuario_veiculo/Admin/veiculos_alterar/'.$id.'/','formajax');
        usuario_veiculo_AdminControle::veiculos_form($this, $this->_Visual, $form, $marcas, $veiculo['categoria'], $veiculo['ano'], $veiculo['modelo'], $veiculo['marcaid'], $veiculo['cc'], $veiculo['valor1'], $veiculo['valor2'], $veiculo['valor3'], $veiculo['franquia'], $veiculo['obs']);
        $formulario = $form->retorna_form('Alterar');
        $this->_Visual->Blocar($formulario);
        $this->_Visual->Bloco_Menor_CriaJanela('Alteração de Veiculo');
        $this->_Visual->Json_Info_Update('Titulo','Editar Veiculo (#'.$id.')');
        
    }
    /**
     * Cria Janela Do Formulario de Cadastro/Edicao de Veiculos
     * 
     * @name veiculos_form
     * @access public
     * 
     * @param Class &$controle Controlle Passado por Ponteiro
     * @param Class &$Visual Visual Passado por Ponteiro
     * @param Array &$selectmarcas
     * 
     * @uses $language
     * @uses Form Carrega Novo Formulário
     * @uses \Framework\Classes\Form::$Input_Novo Coloca os Novos Inputs
     * @uses \Framework\Classes\Form::$Select_Novo Add Novo Select
     * @uses \Framework\Classes\Form::$Select_Opcao Coloca os option do Select
     * @uses \Framework\Classes\Form::$retorna_form Retorna Formulario
     * @uses Control::$Categorias_ShowSelect Retorna Formulario
     * 
     * @return void
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
    */
    static function veiculos_form(&$controle, &$Visual, &$form, &$selectmarcas,$categoria = 0,$ano = '',$modelo = '',$marca = '',$cc = '',$valor1 = '',$valor2 = '',$valor3 = '',$franquia = '',$obs = ''){
        global $language;
       

	// select de categorias
        $controle->Categorias_ShowSelect($form, 'objetos', $categoria);
        
        $form->Input_Novo('Ano do Veiculo','ano',$ano,'text', 4, 'obrigatorio', '', false,'','','Ano','', false); 
        $form->Input_Novo('Modelo do Veiculo','modelo',$modelo,'text', 30, 'obrigatorio'); 
        // select de pessoas
        $form->Select_Novo('Marca','selectmarcas','selectmarcas');
        $Visual->Marcas_ShowSelect($selectmarcas,$form,$marca);
        $form->Select_Fim();
        $form->Input_Novo('Cilindradas','cc',$cc,'text', 11, 'obrigatorio', '', false,'','','Numero','', false); 
        $form->Input_Novo('Valor da Diária até 3 Dias','valor1',$valor1,'text', 30, 'obrigatorio', '', false,'','','Numero','', false); 
        $form->Input_Novo('Valor da Diária de 3 a 9 Dias','valor2',$valor2,'text', 30, 'obrigatorio', '', false,'','','Numero','', false); 
        $form->Input_Novo('Valor Acima de 10 dias','valor3',$valor3,'text', 30, 'obrigatorio', '', false,'','','Numero','', false); 
        $form->Input_Novo('Valor da Franquia','franquia',$franquia,'text', 30, 'obrigatorio', '', false,'','','Numero','', false); 


        $form->Input_Novo($language['formularios']['obs'],'obs',$obs,'text', 1000);
    }
    /**
     * Inseri Veiculos no Banco de dados
     * 
     * @name veiculos_inserir
     * @access public
     * 
     * @global Array $language
     * 
     * @post $_POST["categoria"]
     * @post int $_POST["ano"]
     * @post $_POST["modelo"]
     * @post int $_POST["marca"]
     * @post $_POST["cc"]
     * @post $_POST["valor1"]
     * @post $_POST["valor2"]
     * @post $_POST["valor3"]
     * @post $_POST["franquia"]
     * 
     * @uses veiculos_AdminControl::$veiculos_inserir
     * 
     * @return void
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function veiculos_inserir(){
        global $language;
        $categoria = \anti_injection($_POST["categoria"]);
        $ano = (int) $_POST["ano"];
        $modelo = \anti_injection($_POST["modelo"]);
        $marca = (int) $_POST["selectmarcas"];
        $cc = \anti_injection($_POST["cc"]);
        $valor1 = \anti_injection($_POST["valor1"]);
        $valor2 = \anti_injection($_POST["valor2"]);
        $valor3 = \anti_injection($_POST["valor3"]);
        $franquia = \anti_injection($_POST["franquia"]);
        $obs = \anti_injection($_POST["obs"]);
        
        $sucesso =  $this->_Modelo->veiculos_inserir($categoria,$ano,$modelo,$marca,$cc,$valor1,$valor2,$valor3,$franquia,$obs);
        
        $this->veiculos_lista();
        
        if($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => 'Inserção bem sucedida',
                "mgs_secundaria" => ''.$modelo.''.$ano.''.$marca.' foi inserido com sucesso.'
            );
        }else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => $language['mens_erro']['erro'],
                "mgs_secundaria" => $language['mens_erro']['erro']
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);    
    }
    /**
     * 
     * @global Array $language
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function veiculos_alterar($id){
        global $language;
        
        $id = (int) $id;
        
        $categoria = \anti_injection($_POST["categoria"]);
        $ano = (int) $_POST["ano"];
        $modelo = \anti_injection($_POST["modelo"]);
        $marca = (int) $_POST["selectmarcas"];
        $cc = \anti_injection($_POST["cc"]);
        $valor1 = \anti_injection($_POST["valor1"]);
        $valor2 = \anti_injection($_POST["valor2"]);
        $valor3 = \anti_injection($_POST["valor3"]);
        $franquia = \anti_injection($_POST["franquia"]);
        $obs = \anti_injection($_POST["obs"]);
        
        $sucesso =  $this->_Modelo->veiculos_alterar($id,$categoria,$ano,$modelo,$marca,$cc,$valor1,$valor2,$valor3,$franquia,$obs);
        
        $this->Main();
        
        if($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => 'Alteração bem sucedida',
                "mgs_secundaria" => ''.$modelo.''.$ano.''.$marca.' foi alterado com sucesso.'
            );
        }else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => $language['mens_erro']['erro'],
                "mgs_secundaria" => $language['mens_erro']['erro']
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);    
    }
    /**
    * Cria Janela Do Formulario de Cadastro de Marcas
    * 
    * @name marcas_carregajanelaadd
    * @access public
    * 
    * @param Class &$controle Classe Controle Atual passada por Ponteiro
    * @param Class &$modelo Modelo Passado por Ponteiro
    * @param Class &$Visual Visual Passado por Ponteiro
    * 
    * @uses $language
    * @uses usuario_social_Modelo Carrega Persona Modelo
    * @uses usuario_social_Modelo::$retorna_usuario_social Retorna Pessoas
    * @uses financeiroControle::$marcas_formcadastro retorna Formulario de Cadastro de Marcas
    * @uses \Framework\App\Visual::$blocar Add html ao bloco de conteudo
    * @uses \Framework\App\Visual::$Bloco_Menor_CriaJanela Add html do bloco a uma Janela Lateral Direita
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 2.0
    */
    public function marcas_carregajanelaadd(){
        global $language;
        
        // cadastro de marcas
        $formulario = usuario_veiculo_AdminControle::marcas_formcadastro();
        $this->_Visual->Blocar($formulario);
        $this->_Visual->Bloco_Menor_CriaJanela('Cadastro de Marcas');
        
    }
    /**
    * Cria Janela Do Formulario de Cadastro de Marcas
    * 
    * @name marcas_formcadastro
    * @access public
    * 
    * @uses $language
    * @uses Form Carrega Novo Formulário
    * @uses \Framework\Classes\Form::$Input_Novo Coloca os Novos Inputs
    * @uses \Framework\Classes\Form::$retorna_form Retorna Formulario
    * 
    * @return int $i Quantidades de Registros Retornada
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 2.0
    */
    static function marcas_formcadastro(){
        global $language;
       
        $form = new \Framework\Classes\Form('adminformmarcassend','usuario_veiculo/Admin/marcas_inserir/','formajax');
        $form->Input_Novo('Nome da Marca','nome','','text', 30, 'obrigatorio'); 
        
        $formulario = $form->retorna_form($language['formularios']['cadastrar']);

        return $formulario;
    }
    /**
     * Inseri Marcas no Banco de dados
     * 
     * @name marcas_inserir
     * @access public
     * 
     * @global Array $language
     */
    public function marcas_inserir(){
        global $language;
        $nome = \anti_injection($_POST["nome"]);
        $sucesso =  $this->_Modelo->marcas_inserir($nome);
        // atualiza marcas
        $marcas = Array();
        $this->_Modelo->retorna_marcas($marcas);
        $html = $this->_Visual->Marcas_ShowSelectAjax($marcas);
        $conteudo = array(
            'location' => "#selectmarcas",
            'js' => '',
            'html' => $html
        );
        $this->_Visual->Json_IncluiTipo('Conteudo',$conteudo);
        // mostra mensagem de sucesso
        if($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => 'Inserção bem sucedida',
                "mgs_secundaria" => ''.$nome.' foi inserido com sucesso.'
            );
        }else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => $language['mens_erro']['erro'],
                "mgs_secundaria" => $language['mens_erro']['erro']
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);    
    }
}
?>
