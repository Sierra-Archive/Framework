<?php
class Agenda_AtividadesControle extends Agenda_Controle
{
    /**
    * Construtor
    * 
    * @name __construct
    * @access public
    * 
    * @uses Agenda_AtividadesModelo Carrega Atividades Modelo
    * @uses Agenda_AtividadesVisual Carrega Atividades Visual
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
    * Função Main, Principal, é a tela inicial quando clica em Atividades.
    * 
    * @name Main
    * @access public
    * 
    * @uses Agenda_AtividadesModelo::$Atividades_retorna Carrega Todas as Atividades Referentes
    * @uses Agenda_AtividadesVisual::$Show_Atividades Exibe Todas as Atividades Referentes
    * @uses \Framework\App\Visual::$blocar
    * @uses \Framework\App\Visual::$novajanela
    * @uses Agenda_AtividadesControle::$Atividades_formcadastro Carrega Formulario de Cadastro de Atividade
    * 
    * @return void 
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 2.0
    */
    public function Main(){
        // CARREGA ATIVIDADES
        $atividades = array();
        $this->_Modelo->Atividades_retorna($atividades, $this->config_ano.'-'.$this->config_mes.'-'.$this->config_dia.' 00:00:00', $this->config_ano.'-'.$this->config_mes.'-'.$this->config_dia.' 23:59:59');
        $this->_Visual->Blocar(Agenda_AtividadesVisual::Show_Atividades($atividades));   
        $this->_Visual->Bloco_Maior_CriaJanela('Atividades');
        unset($atividades); // LIMPA MEMÓRIA

        // cadastro de local
        self::Atividades_formcadastro($this, $this->_Modelo, $this->_Visual, $this->config_dataixi);

        // ORGANIZA E MANDA CONTEUDO
        $this->_Visual->Json_Info_Update('Titulo','Atividades');        
    }
    /**
    * Função para Retornar Formulario de Cadastro de Atividades
    * 
    * @name Atividades_formcadastro
    * @access public
    * @static
    * 
    * @param Class $controle Classe Controle Atual passada por Ponteiro
    * @param Class $modelo Classe Modelo Atual passada por Ponteiro
    * @param Class $Visual Classe Visual Atual passada por Ponteiro
    * @param date $data Data para Cadastro de Atividade
    * 
    * @uses $language
    * @uses locais_locaisModelo::$local_retorna Carrega Locais para o Select do Formulario
    * @uses usuario_social_Modelo Carrega Persona Modelo
    * @uses usuario_social_Modelo::$retorna_usuario_social Retorna Pessoas
    * @uses Form Carrega Novo Formulário
    * @uses \Framework\Classes\Form::$Input_Novo Coloca os Novos Inputs
    * @uses \Framework\Classes\Form::$Select_Novo Add Novo Select
    * @uses \Framework\Classes\Form::$Select_Opcao Coloca os option do Select
    * @uses \Framework\Classes\Form::$retorna_form Retorna Formulario
    * @uses \Framework\Classes\Form::$addtexto Add html div para novas Usuario_social no Formulario
    * @uses \Framework\App\Visual::$blocar Add html ao bloco de conteudo
    * @uses \Framework\App\Visual::$novajaneladir Add html do bloco a uma Janela Lateral Direita
    * @uses Control::$Categorias_ShowSelect Retorna Formulario
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 2.0
    */
    static function Atividades_formcadastro(&$controle, &$modelo, &$Visual, $data){
        global $language;
        $registro = \Framework\App\Registro::getInstacia();
        $_Acl = $registro->_Acl();

        // CARREGA LOCALIDADES
        $selectlocais = array();
        locais_locaisModelo::local_retorna($modelo, $selectlocais);

        // CARREGA USUARIO_SOCIAL
        $usuario_socialM = new usuario_social_Modelo();
        $usuario_social = array();
        $qnt = 0;
        $qnt = $usuario_socialM->retorna_usuario_social($usuario_social, $_Acl->logado_usuario->id);
        
        // FORMULARIO DE CADASTRO DE ATIVIDADES
        $form = new \Framework\Classes\Form('AtividadesFormEnvio','Agenda/Atividades/Atividade_inserir/','formajax');
        $form->Input_Novo('Data Inicio','dt_inicio',$data,'text', 10,'obrigatorio', '', false,'','','Data','', false);   
        $form->Input_Novo('Hora Inicio','hr_inicio','','text', 8,'obrigatorio masc_hora');   
        $form->Input_Novo('Data Fim','dt_fim',$data,'text', 10,'obrigatorio', '', false,'','','Data','', false);    
        $form->Input_Novo('Hora Fim','hr_fim','','text', 8,'obrigatorio masc_hora');  
                
	// select de categorias
        $controle->Categorias_ShowSelect($form, 'financas');
        
        // COMEÇO DOS SELECT DE LOCALIDADES
        $form->Select_Novo($language['palavras']['locais'],'local','selectlocais');
        $tamanho = sizeof($selectlocais);
        for($i=0;$i<$tamanho;++$i){
            if($selectlocais[$i]['valor']==1) $select = 1; else  $select = 0;
            $form->Select_Opcao($selectlocais[$i]['nome'],$selectlocais[$i]['id'],$select);
        }
        $form->Select_Fim();
        
        // select de pessoas
        $form->addtexto('<div id="molde_usuario_social">');
        $form->Select_Novo($language['financas']['pers'],'selectusuario_social[]','', '', '', 'var novohtml = $(\'#molde_usuario_social\').html().split(\'<!--Comeca Select-->\'); $(\'#novas_usuario_social\').append(\'<label class=form>\'+novohtml[2]+\'</label>\'); return false;');
        usuario_social_Visual::Usuario_social_ShowSelect($usuario_social,$form);
        $form->Select_Fim();
        $form->addtexto('</div><div id="novas_usuario_social"></div>');
        
        $form->Input_Novo($language['Agenda']['Atividades']['Obs'],'obs','','text', 1000);  
        // FINAL DOS SELECT DE LOCALIDADES
        $formulario = $form->retorna_form($language['formularios']['cadastrar']);
 
        $Visual->Blocar($formulario);
        $Visual->Bloco_Maior_CriaJanela($language['Agenda']['Atividades']['Cadastro']);

        $Visual->Javascript_Executar('Sierra.Control_Layoult_Calendario(\'dt_inicio\',\''.$data.'\');Sierra.Control_Layoult_Calendario(\'dt_fim\',\''.$data.'\');');

    }
    /**
    /*
     * 
     * 
     *                 A FAZERRRRRRRRRRRRRRRR
     * 
     * 
     * 
     * 
    * Função para gravar Relações entre tabelas e usuario_social, é uma funcao static e é chamada por diversos oturos modulos
    * 
    * @name Atividade_inserir
    * @access public
    * 
    * @post $_POST["nome"]
    * @post $_POST["dt_inicio"]
    * @post $_POST["hr_inicio"]
    * @post $_POST["dt_fim"]
    * @post $_POST["hr_fim"]
    * @post $_POST["descricao"]
    * @post $_POST["local"]
    * 
    * @uses $language
    * @uses Agenda_AtividadesModelo::$Atividade_inserir Inseri Atividade    
    * @uses Agenda_AtividadesModelo::$Atividades_retorna Carrega Todas as Atividades Referentes
    * @uses Agenda_AtividadesVisual::$Show_Atividades Exibe Todas as Atividades Referentes
    * @uses usuario_social_Modelo::$Inserir_Pers_Relacao Add Usuario_social Referentes
    * @uses \Framework\App\Visual::$blocar
    * @uses \Framework\App\Visual::$novajanela
    * 
    * @return int Retorna 1 se insercao for concluida com sucesso. 
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version
    */
    public function Atividade_inserir(){
        global $language;
        $nome = \anti_injection($_POST["nome"]);
        $dt_inicio = data_hora_brasil_eua(\anti_injection($_POST["dt_inicio"].' '.$_POST["hr_inicio"]));
        $dt_fim = data_hora_brasil_eua(\anti_injection($_POST["dt_fim"].' '.$_POST["hr_fim"]));
        //data_hora_brasil_eua()
        $obs = \anti_injection($_POST["obs"]);
        $local = (int) $_POST["local"];
        $categoria = \anti_injection($_POST["categoria"]);
        
        // ADD USUARIO_SOCIAL
        $idinserido =  $this->_Modelo->Atividade_inserir($dt_inicio,$dt_fim,$obs,$local, $categoria);
        foreach ($_POST["selectusuario_social"] as $personaid) {
            if($personaid!=0) usuario_social_Modelo::Inserir_Pers_Relacao($this->_Modelo, $this->_Acl->Usuario_GetID(), MYSQL_USUARIO_AGENDA_ATIVIDADES, $idinserido, $personaid);
        }

        // CARREGA ATIVIDADES
        $atividades = array();
        $this->_Modelo->Atividades_retorna($atividades, $this->config_ano.'-'.$this->config_mes.'-'.$this->config_dia.' 00:00:00', $this->config_ano.'-'.$this->config_mes.'-'.$this->config_dia.' 23:59:59');
        $this->_Visual->Blocar(Agenda_AtividadesVisual::Show_Atividades($atividades));   
        $this->_Visual->Bloco_Maior_CriaJanela('Atividades');
        unset($atividades); // LIMPA MEMÓRIA
        
        // Mostra Mensagem para o Usuario
        if($sucesso===true){
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => 'Atividade inserida com Sucesso',
                "mgs_secundaria" => $nome.' foi add a base de dados...'
            );
        }else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => $language['mens_erro']['erro'],
                "mgs_secundaria" => $language['mens_erro']['erro']
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        echo $this->_Visual->Json_Retorna();
    
    }
}
?>
