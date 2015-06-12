<?php
class Financeiro_AdminControle extends Financeiro_Controle
{
    /**
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
    * @version 2.0
    */
    public function __construct(){
        parent::__construct();
    }
    /**
    * Função Main, Principal
    * 
    * @name Main
    * @access public
    * 
    * @uses Financeiro_AdminControle::$financeiros_lista
    * @uses \Framework\App\Visual::$Json_Start
    * 
    * @return void 
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 2.0
    */
    public function Main(){
        $this->usuarios_naodevendo();
        $this->usuarios_devendo();
        // ORGANIZA E MANDA CONTEUDO
        $this->_Visual->Json_Info_Update('Titulo', __('Pagamentos'));        
    }
    /**
    * Printa todos os financeiros na tela
    * 
    * @name financeiros_lista
    * @access public
    * 
    * @uses financeiros_ListarModelo::$retorna_financeiros
    * @uses \Framework\App\Visual::$Show_Tabela_DataTable
    * @uses \Framework\App\Visual::$Bloco_Maior_CriaTitulo
    * @uses \Framework\App\Visual::$bloco_maior_criaconteudo
    * 
    * @return void 
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 2.0
    */
    public function usuarios_devendo(){
        $usuarios = Array();
        $this->_Modelo->Usuarios_devendo($usuarios);
        
        if(!empty($usuarios)){
            $i = $this->usuario_formatab($usuarios);
        }else{         
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhum Usuário com Saldo Negativo</font></b></center>');
        }
        $titulo = __('Usuarios Devendo').' ('.$i.')';
        $this->_Visual->Bloco_Maior_CriaJanela($titulo);
    }
    public function usuarios_naodevendo(){
        $usuarios = Array();
        $this->_Modelo->Usuarios_naodevendo($usuarios);
        $i = 0;
        if(!empty($usuarios)){
            $i = $this->usuario_formatab($usuarios);
        }else{
            $html .= '<center><b><font color="#FF0000" size="5">Nenhum Usuário com Saldo Positivo</font></b></center>';
        }
        $titulo = __('Usuarios com Dinheiro').' ('.$i.')';
        $this->_Visual->Bloco_Maior_CriaJanela($titulo);
    }
    public function usuario_formatab(&$usuarios){
        $tabela = Array();
        $i = 0;
        reset($usuarios);
        foreach ($usuarios as $indice=>&$valor) {
            /*if($usuarios[$indice]['nivel_usuario']==1)     $niveluser = CONFIG_CLI_1_NOME;
            elseif($usuarios[$indice]['nivel_usuario']==2) $niveluser = CONFIG_CLI_2_NOME;
            elseif($usuarios[$indice]['nivel_usuario']==3) $niveluser = CONFIG_CLI_3_NOME;
            elseif($usuarios[$indice]['nivel_usuario']==4) $niveluser = CONFIG_CLI_4_NOME;
            elseif($usuarios[$indice]['nivel_usuario']==5) $niveluser = CONFIG_CLI_5_NOME;
            else                                           $niveluser = CONFIG_CLI_0_NOME;

            if($usuarios[$indice]['nivel_admin']==0)     $niveladmin = __('Usuario');
            elseif($usuarios[$indice]['nivel_admin']==1) $niveladmin = __('Admin');
            else                                         $niveladmin = __('Admin GOD');
*/

            $tabela['Id'][$i] = $usuarios[$indice]['id'];
            $tabela['Nome'][$i] = $usuarios[$indice]['nome'];
            $tabela['Email'][$i] = $usuarios[$indice]['email'];
            $tabela['Nivel de Usuário'][$i] = $niveluser;
            $tabela['Nivel de Admin'][$i] = $niveladmin;
            $tabela['Saldo'][$i] = $usuarios[$indice]['saldo'];
            $tabela['Funções'][$i] = '<a confirma="O cliente realizou um deposito para a empresa?" title="Add quantia ao Saldo do Usuário" class="lajax explicar-titulo" acao="" href="'.URL_PATH.'Financeiro/Admin/financeiro_deposito/'.$usuarios[$indice]['id'].'/"><img border="0" src="'.WEB_URL.'img/icons/cifrao_16x16.png"></a>'.
            '<a confirma="O cliente confirmou o saque?" title="Remover Quantia do Saldo do Usuário" class="lajax explicar-titulo" acao="" href="'.URL_PATH.'Financeiro/Admin/financeiro_retirar/'.$usuarios[$indice]['id'].'/"><img border="0" src="'.WEB_URL.'img/icons/cifrao_16x16.png"></a>'.
            '<a title="Editar Usuário" class="lajax explicar-titulo" acao="" href="'.URL_PATH.'usuario/Admin/usuarios_carregajanelaEdit/'.$usuarios[$indice]['id'].'/"><img border="0" src="'.WEB_URL.'img/icons/icon_edit.png"></a> '.
            '<a confirma="Deseja realmente deletar esse usuário?" title="Deletar Usuário" class="lajax explicar-titulo" acao="" href="'.URL_PATH.'usuario/Admin/usuarios_Del/'.$usuarios[$indice]['id'].'/"><img border="0" src="'.WEB_URL.'img/icons/icon_bad.png"></a>';
            ++$i;
        }
        $this->_Visual->Show_Tabela_DataTable($tabela);
        unset($tabela);
        return $i;
    }
    /**
    * Deleta Veiculo
    * 
    * @name pagamentos_Del
    * @access public
    * 
    * @uses pagamentos_AdminModelo::$pagamentos_Del
    * @uses \Framework\App\Visual::$Json_IncluiTipo
    * @uses pagamentos_AdminControle::$pagamentos_lista
    * 
    * @return void 
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 2.0
    */
    public function pagamentos_Del($id){
        global $language;
        
    	$id = (int) $id;
    	$sucesso = $this->_Modelo->pagamentos_Del($id);
    	if($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Deletado'),
                "mgs_secundaria" => __('Deletado com sucesso')
            );
    	}else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Erro')
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        
        $this->pagamentos_lista();
    }
    public function financeiro_deposito($usuario = 0){
        $usuario = (int) $usuario;
        Financeiro_AdminControle::financas_carregajanelaadd($this, $this->_Modelo, $this->_Visual, $usuario);
        $this->_Visual->Json_Info_Update('Titulo','Depositar para Usuário #'.$usuario);
    }
    public function financeiro_retirar($usuario = 0){
        $usuario = (int) $usuario;
        Financeiro_AdminControle::financas_carregajanelaretirar($this, $this->_Modelo, $this->_Visual, $usuario);
        $this->_Visual->Json_Info_Update('Titulo','Sacar de Usuário #'.$usuario);
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
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 2.0
    */
    static function financas_carregajanelaadd(&$controle, &$modelo, &$Visual, $usuario=0){
        global $language;
        if($usuario==0 || !is_int($usuario)) return 0;
       // cadastro de financas
        $formulario = Financeiro_AdminControle::financas_formcadastro($controle, $modelo, $Visual, $usuario);
        $Visual->Blocar($formulario);
        $Visual->Bloco_Menor_CriaJanela('Depositar para Usuário #'.$usuario);        
    }
    static function financas_carregajanelaretirar(&$controle, &$modelo, &$Visual, $usuario=0){
        global $language;
        if($usuario==0 || !is_int($usuario)) return 0;
       // cadastro de financas
        $formulario = Financeiro_AdminControle::financas_formretirar($controle, $modelo, $Visual, $usuario);
        $Visual->Blocar($formulario);
        $Visual->Bloco_Menor_CriaJanela('Retirar de Usuário #'.$usuario);        
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
    * @uses social_Visual::$Usuario_social_ShowSelect Exibe Select de Usuario_social
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
    static function financas_formcadastro(&$controle, &$modelo, &$Visual,$user){
        global $language;
       
        $form = new \Framework\Classes\Form('adminfinanceiroinserir','Financeiro/Admin/financas_inserir/','formajax');
        $form->Input_Novo('user','user',$user,'hidden', false, 'obrigatorio'); 
        $form->Input_Novo(__('Valor'),'valor','','text', 30, 'obrigatorio'); 

        $form->Input_Novo(__('Observação'),'obs','','text', 255);
        
        $formulario = $form->retorna_form('Depositar para Usuário');

        return $formulario;
    }
    static function financas_formretirar(&$controle, &$modelo, &$Visual,$user){
        global $language;
       
        $form = new \Framework\Classes\Form('adminfinanceiroinserir','Financeiro/Admin/financas_retirar/','formajax');
        $form->Input_Novo('user','user',$user,'hidden', false, 'obrigatorio'); 
        $form->Input_Novo(__('Valor'),'valor','','text', 30, 'obrigatorio'); 

        $form->Input_Novo(__('Observação'),'obs','','text', 255);
        
        $formulario = $form->retorna_form('Retirar de Usuário');

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
    * @uses financeiroControl::$financas Mostra Novas Financas na Tela
    * @uses financeiroModelo::$financas_inserir Inserir Financas
    * @uses financeiroVisual::$Json_IncluiTipo Mostra Novas Financas na Tela
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 2.0
    */
    public function financas_inserir(){
        global $language;
        //data_hora_brasil_eua()
        $valor = \anti_injection($_POST["valor"]);
        $user = (int) $_POST["user"];
        $obs = \anti_injection($_POST["obs"]);
        $sucesso =  $this->_Modelo->MovExt_Inserir($user,$valor,$obs,1);
        $this->Main();
        if($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Depositado com Sucesso'),
                "mgs_secundaria" => 'Valor: '.$valor
            );
            $this->_Visual->Json_Info_Update('Titulo', __('Depositado com Sucesso'));
        }else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Erro')
            );
            $this->_Visual->Json_Info_Update('Titulo', __('Erro ao Depositar'));
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens); 
        // ORGANIZA E MANDA CONTEUDO
        $this->_Visual->Json_Info_Update('Historico',0);    
    }
    public function financas_retirar(){
        global $language;
        //data_hora_brasil_eua()
        $valor = \anti_injection($_POST["valor"]);
        $user = (int) $_POST["user"];
        $obs = \anti_injection($_POST["obs"]);
        $sucesso =  $this->_Modelo->MovExt_Inserir($user,$valor,$obs,0);
        $this->Main();
        if($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Retirado com Sucesso'),
                "mgs_secundaria" => 'Valor: '.$valor
            );
            $this->_Visual->Json_Info_Update('Titulo', __('Retirado com Sucesso'));
        }else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Erro')
            );
            $this->_Visual->Json_Info_Update('Titulo', __('Erro ao Retirar'));
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens); 
        // ORGANIZA E MANDA CONTEUDO
        $this->_Visual->Json_Info_Update('Historico',0);    
    }
}
?>