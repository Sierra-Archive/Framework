<?php
class Agenda_financas_Controle extends \Framework\App\Controle
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
    * @version 2.0
    */
    public function __construct(){
        parent::__construct();
    }
    /**
    * Cria Janela Do Formulario de Cadastro de FInancas
    * 
    * @name financas_carregajanelaadd
    * @access public
    * 
    * @param Class &$controle Classe Controle Atual passada por Ponteiro
    * @param Class &$modelo Modelo Passado por Ponteiro
    * @param Class &$Visual Visual Passado por Ponteiro
    * 
    * @uses $language
    * @uses usuario_social_Modelo Carrega Persona Modelo
    * @uses usuario_social_Modelo::$retorna_usuario_social Retorna Pessoas
    * @uses Agenda_financas_Controle::$financas_formcadastro retorna Formulario de Cadastro de Financas
    * @uses \Framework\App\Visual::$blocar Add html ao bloco de conteudo
    * @uses \Framework\App\Visual::$novajaneladir Add html do bloco a uma Janela Lateral Direita
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 2.0
    */
    static function financas_carregajanelaadd(&$controle, &$modelo, &$Visual){
        global $language;
        $registro = \Framework\App\Registro::getInstacia();
        $_Acl = $registro->_Acl();

        // CARREGA USUARIO_SOCIAL
        $usuario_socialM = new usuario_social_Modelo();
        $usuario_social = array();
        $qnt = 0;
        $qnt = $usuario_socialM->retorna_usuario_social($usuario_social, $_Acl->logado_usuario->id);
        // cadastro de financas
        $formulario = Agenda_financas_Controle::financas_formcadastro($controle, $modelo, $Visual, $controle->config_dataixi,$usuario_social);
        $Visual->Blocar($formulario);
        $Visual->Bloco_Menor_CriaJanela($language['admin']['cadastro']['financas']);

        $Visual->Javascript_Executar('Sierra.Control_Layoult_Calendario(\'data\',\''.$controle->config_dataixi.'\');');
        
    }
    /**
    * Cria Janela Do Formulario de Cadastro de FInancas
    * 
    * @name financas_formcadastro
    * @access public
    * 
    * @param Class &$controle Classe Controle Atual passada por Ponteiro
    * @param Class &$modelo Modelo Passado por Ponteiro
    * @param Class &$Visual Visual Passado por Ponteiro
    * 
    * @uses $language
    * @uses usuario_social_Visual::$Usuario_social_ShowSelect Exibe Select de Usuario_social
    * @uses Form Carrega Novo Formulário
    * @uses \Framework\Classes\Form::$Input_Novo Coloca os Novos Inputs
    * @uses \Framework\Classes\Form::$Select_Novo Add Novo Select
    * @uses \Framework\Classes\Form::$Select_Opcao Coloca os option do Select
    * @uses \Framework\Classes\Form::$retorna_form Retorna Formulario
    * @uses Control::$Categorias_ShowSelect Retorna Formulario
    * 
    * @return int $i Quantidades de Registros Retornada
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 2.0
    */
    static function financas_formcadastro(&$controle, &$modelo, &$Visual, $data,&$selectusuario_social){
        global $language;
       
        $form = new \Framework\Classes\Form('adminformfinancassend','Agenda_financas/financas/financas_inserir/','formajax');
        $form->Input_Novo($language['formularios']['data'],'data',$data,'text', 10,'obrigatorio masc_data'); 
        $form->Input_Novo($language['formularios']['valor'],'valor','','text', 30, 'obrigatorio'); 
        
        // select Positivo ou negativo
        $form->Select_Novo($language['financas']['sinal'],'positivo','positivo');
        $form->Select_Opcao($language['financas']['negativo'],0,0);
        $form->Select_Opcao($language['financas']['positivo'],1,0);
        $form->Select_Fim();
        
	// select de categorias
        $controle->Categorias_ShowSelect($form, 'Agenda_financas');
        
        // select de pessoas
        $form->Select_Novo($language['financas']['pers'],'selectusuario_social','selectusuario_social');
        usuario_social_Visual::Usuario_social_ShowSelect($selectusuario_social,$form);
        $form->Select_Fim();

        $form->Input_Novo($language['formularios']['obs'],'obs','','text', 1000);
        
        $formulario = $form->retorna_form($language['formularios']['cadastrar']);

        return $formulario;
    }
    /**
    * Inseri Financas no Banco de dados
    * 
    * @name financas_inserir
    * @access public
    * 
    * @post $_POST["data"]
    * @post $_POST["valor"]
    * @post int $_POST["positivo"]
    * 
    * @uses $language
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 2.0
    */
    public function financas_inserir(){
        global $language;
        $data = data_brasil_eua(\anti_injection($_POST["data"]));
        //data_hora_brasil_eua()
        $valor = \anti_injection($_POST["valor"]);
        $positivo = (int) $_POST["positivo"];
        $categoria = \anti_injection($_POST["categoria"]);
        $usuario_social = (int) $_POST["selectusuario_social"];
        $obs = \anti_injection($_POST["obs"]);
        $sucesso =  $this->_Modelo->financas_inserir($data,$valor,$positivo,$categoria,$usuario_social,$obs);
        $this->financas();
        if($sucesso==1){
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => $language['financas']['formsucesso1'],
                "mgs_secundaria" => preg_replace(array('/{valor}/'), array($valor), $language['financas']['formsucesso2'])
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