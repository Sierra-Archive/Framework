<?php
class comercio_certificado_Controle extends \Framework\App\Controle
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
    /**
     * 3º ABA (produtos)
     * Mostra o Editar ou Add Usuario em Tab
     * @param type $id
     */
    public function Usuarios_Produtos($id = 0){
        if($id==0){
            \Framework\App\Visual::Layoult_Abas_Carregar('2',self::Usuarios_Add('cliente')     ,true);
            \Framework\App\Visual::Layoult_Abas_Carregar('3',$this->_Visual->ErroShow()        ,false);
            \Framework\App\Visual::Layoult_Abas_Carregar('4',$this->_Visual->ErroShow()        ,false);
            \Framework\App\Visual::Layoult_Abas_Carregar('5',$this->_Visual->ErroShow()        ,false);
            $this->_Visual->Json_Info_Update('Titulo','Listagem de Usuários');
            $this->_Visual->Json_Info_Update('Historico',0);
        }else{
            \Framework\App\Visual::Layoult_Abas_Carregar('2',self::Usuarios_Edit('cliente',$id),false);
            \Framework\App\Visual::Layoult_Abas_Carregar('3',$this->Propostas_DashBoard($id)   ,true);
            \Framework\App\Visual::Layoult_Abas_Carregar('4',$this->Periodicas($id)   ,false);
            // Editar Aba 5
            $this->Usuario_UpdateInfo($id);
            // Joga pro Json se nao for o caso de popup
            $this->_Visual->Json_Info_Update('Titulo','Visualizar Usuário');
            $this->_Visual->Json_Info_Update('Historico',0);
        }
    }
    /**
     * 2 ABA CLIENTE
     * Mostra o Editar ou Add Usuario em Tab
     * @param type $id
     */
    public function Usuarios_Mostrar($id = 0){
        if($id==0){
            \Framework\App\Visual::Layoult_Abas_Carregar('2',self::Usuarios_Add('cliente')     ,true);
            \Framework\App\Visual::Layoult_Abas_Carregar('3',$this->_Visual->ErroShow()        ,false);
            \Framework\App\Visual::Layoult_Abas_Carregar('4',$this->_Visual->ErroShow()        ,false);
            \Framework\App\Visual::Layoult_Abas_Carregar('5',$this->_Visual->ErroShow()        ,false);
            $this->_Visual->Json_Info_Update('Titulo','Listagem de Usuários');
        }else{
            \Framework\App\Visual::Layoult_Abas_Carregar('2',self::Usuarios_Edit('cliente',$id),true);
            \Framework\App\Visual::Layoult_Abas_Carregar('3',$this->Propostas_DashBoard($id)   ,false);
            \Framework\App\Visual::Layoult_Abas_Carregar('4',$this->Periodicas($id)   ,false);
            // Editar Aba 5
            $this->Usuario_UpdateInfo($id);
            // Titulo
            $this->_Visual->Json_Info_Update('Titulo','Visualizar Usuário');
        }
        // Joga pro Json se nao for o caso de popup
        $this->_Visual->Json_Info_Update('Historico',0);
    }
    public static function Usuario_UpdateInfo($id = 0){
        $registro   = &\Framework\App\Registro::getInstacia();
        $Modelo     = $registro->_Modelo;
        $Visual     = $registro->_Visual;
        $abas_id    = &\Framework\App\Visual::$config_template['plugins']['abas_id'];
        if($id==0 || !isset($id)){
            $id = (int) $this->_Acl->Usuario_GetID();
        }else{
            $id = (int) $id;
        }
        // Carrega campos e retira os que nao precisam
        $campos = Usuario_DAO::Get_Colunas();
        self::DAO_Campos_Retira($campos, 'obs',1);
        $usuario = $Modelo->db->Sql_Select('Usuario', Array('id'=>$id));
        if($usuario===false){
            throw new \Exception('Usuário não existe', 8010);
        }
        self::mysql_AtualizaValores($campos, $usuario);
        
        // cadastro de usuario
        $form = new \Framework\Classes\Form('form_Usuario_Update_Info','comercio_certificado/Proposta/Usuario_UpdateInfo2/'.$id.'/','formajax');
        \Framework\App\Controle::Gerador_Formulario($campos, $form);

        $formulario = $form->retorna_form('Modificar Observação');
        $conteudo = array(
            'location'  =>  '#'.$abas_id.'5',
            'js'        =>  '',
            'html'      =>  $formulario
        );
        // Joga pro Json se nao for o caso de popup
        $Visual->Json_IncluiTipo('Conteudo',$conteudo);        
    }
    
    public static function Usuario_UpdateInfo2($id){
        global $language;
        $registro   = &\Framework\App\Registro::getInstacia();
        $Controle   = $registro->_Controle;
        $Modelo     = $registro->_Modelo;
        $Visual     = $registro->_Visual;
        $id = (int) $id;
        if(!isset($_POST["nome"])){
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => $language['mens_erro']['erro'],
                "mgs_secundaria" => $language['mens_erro']['erro']
            );
            $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens); 


            //Json
            $this->_Visual->Json_Info_Update('Titulo', 'Erro');  
            $this->_Visual->Json_Info_Update('Historico', false);   
            return false;
        }
        // Puxa o usuario, e altera seus valores, depois salva novamente
        $usuario = $Modelo->db->Sql_Select('Usuario', Array('id'=>$id));
        self::mysql_AtualizaValores($usuario);
        $sucesso =  $Modelo->db->Sql_Update($usuario);
        
        if($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => 'Alteração bem sucedida',
                "mgs_secundaria" => $_POST["nome"].' foi alterado com sucesso.'
            );
        }else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => $language['mens_erro']['erro'],
                "mgs_secundaria" => $language['mens_erro']['erro']
            );
        }
        $Controle->Json_Definir_zerar(false);
        $Visual->Json_IncluiTipo('Mensagens',$mensagens);    
    }
    public static function Usuarios_Add($tipo=false){
        // Carrega campos e retira os que nao precisam
        $campos = Usuario_DAO::Get_Colunas();
        // Retira os de clientes
        $linkextra = '';
        if($tipo=='cliente'){
            $linkextra = $tipo.'/';
        }
        // Carrega formulario
        $form = new \Framework\Classes\Form('form_Sistema_Admin_Usuarios','comercio_certificado/Proposta/Usuarios_Add2/'.$linkextra,'formajax');
        // Retira os campos invalidos
        usuario_Controle::Campos_Deletar($tipo, $campos, $form);
        // Chama Formulario
        \Framework\App\Controle::Gerador_Formulario($campos, $form);

        if($tipo=='cliente'){
            $formulario = $form->retorna_form('Cadastrar Cliente');
        }else{
            $formulario = $form->retorna_form('Cadastrar Usuário');
        }
        return $formulario;
    }
    public static function Usuarios_Edit($tipo='usuario',$id = 0){
        $registro   = &\Framework\App\Registro::getInstacia();
        $Modelo     = $registro->_Modelo;
        if($id==0 || !isset($id)){
            $id = (int) $this->_Acl->Usuario_GetID();
        }else{
            $id = (int) $id;
        }
        // Carrega campos e retira os que nao precisam
        $campos = Usuario_DAO::Get_Colunas();
        self::DAO_Campos_Retira($campos, 'senha');
        $usuario = $Modelo->db->Sql_Select('Usuario', Array('id'=>$id));
        if($usuario===false) throw new \Exception('Usuário não existe', 8010);
        self::mysql_AtualizaValores($campos, $usuario);
        // Cria Formulario
        $form = new \Framework\Classes\Form('form_Sistema_AdminC_UsuarioEdit','comercio_certificado/Proposta/Usuarios_Edit2/'.$tipo.'/'.$id.'/','formajax');
        // Remove desnecessarios
        usuario_Controle::Campos_Deletar($tipo, $campos, $form);
        // cadastro de usuario
        \Framework\App\Controle::Gerador_Formulario($campos, $form);

        $formulario = $form->retorna_form('Alterar');
        return $formulario;  
        
    }
    /**
     * Inseri usuarios no Banco de dados
     * 
     * @name usuarios_inserir
     * @access public static
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
     * @uses usuarios_AdminControl::$usuarios_inserir
     * 
     * @return void
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Usuarios_Add2($tipo=false){
        global $language;
        $registro   = &\Framework\App\Registro::getInstacia();
        $Modelo     = &$registro->_Modelo;
        $Visual     = &$registro->_Visual;
       
        if(isset($_POST['email'])){
            $email = \anti_injection($_POST['email']);
        }else{
            $email = '';
        }
        if(isset($_POST['login'])){
            $login = \anti_injection($_POST['login']);
        }else{
            $login = '';
        }
        $existeemail = usuario_Modelo::VerificaExtEmail($Modelo,$email);
        $existelogin = usuario_Modelo::VerificaExtLogin($Modelo,$login);
        if(\Framework\App\Sistema_Funcoes::Control_Layoult_Valida_Email($email)===false && $tipo!='cliente'){
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => $language['mens_erro']['erro'],
                "mgs_secundaria" => 'Email Inválido'
            );
            $Visual->Json_IncluiTipo('Mensagens',$mensagens);
            $this->layoult_zerar = false;
            $Visual->Javascript_Executar('$("#email").css(\'border\', \'2px solid #FFAEB0\').focus();');
         }else if($existeemail===true && ($tipo!='cliente' || $email!='')){
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => $language['mens_erro']['erro'],
                "mgs_secundaria" => 'Email Ja Existe'
            );
            $Visual->Json_IncluiTipo('Mensagens',$mensagens); 
            $this->layoult_zerar = false;
            $Visual->Javascript_Executar('$("#email").css(\'border\', \'2px solid #FFAEB0\').focus();');
        }else if($existelogin===true && $tipo!='cliente'){
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => $language['mens_erro']['erro'],
                "mgs_secundaria" => 'Login ja existe'
            );
            $Visual->Json_IncluiTipo('Mensagens',$mensagens); 
            $this->layoult_zerar = false;
            $Visual->Javascript_Executar('$("#login").css(\'border\', \'2px solid #FFAEB0\').focus();');
        }else{
            $tipousuario = \anti_injection($tipo);

            // atualiza todos os valores por get, retirando o nivel admin
            //self::mysql_AtualizaValores($usuario);

            global $language;

            // Cria novo Usuario
            $usuario = new Usuario_DAO;
            self::mysql_AtualizaValores($usuario);
        
            // confere senha
            if($tipousuario!='cliente' && (!isset($_POST['senha']) || $_POST['senha']=='')){
                $mensagens = array(
                    "tipo" => 'erro',
                    "mgs_principal" => $language['mens_erro']['erro'],
                    "mgs_secundaria" => 'Senha Inválida'
                );
                $Visual->Json_IncluiTipo('Mensagens',$mensagens);
                $this->layoult_zerar = false;
                return;
            }

            // captura indicado;
            if(!isset($_COOKIE['indicativo_id'])) $_COOKIE['indicativo_id'] = 0;
            self::mysql_AtualizaValor($usuario,'indicado_por', $_COOKIE['indicativo_id']);

            
            //insere usuario
            $usuario->grupo = CFG_TEC_IDCLIENTE;
            $sucesso =  $Modelo->db->Sql_Inserir($usuario);

            // Recarrega Main
            $idusuario = $Modelo->db->Sql_Select('Usuario', Array(),1,'id DESC');
            $this->Usuarios_Produtos($idusuario->id);
            comercio_certificado_PropostaControle::RecarregaLocalizar();

            if($sucesso===true){
                $mensagens = array(
                    "tipo" => 'sucesso',
                    "mgs_principal" => 'Inserção bem sucedida',
                    "mgs_secundaria" => 'Voce foi cadastrado com sucesso.'
                );                
            }else{
                $mensagens = array(
                    "tipo" => 'erro',
                    "mgs_principal" => $language['mens_erro']['erro'],
                    "mgs_secundaria" => $language['mens_erro']['erro']
                );
            }
            $Visual->Json_IncluiTipo('Mensagens',$mensagens); 
        }
    }
    /**
     * 
     * @global Array $language
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Usuarios_Edit2($tipo='usuario',$id){
        global $language;
        $id = (int) $id;
        if(!isset($_POST["nome"])){
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => $language['mens_erro']['erro'],
                "mgs_secundaria" => $language['mens_erro']['erro']
            );
            $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens); 


            //Json
            $this->_Visual->Json_Info_Update('Titulo', 'Erro');  
            $this->_Visual->Json_Info_Update('Historico', false);   
            return false;
        }
        // Puxa o usuario, e altera seus valores, depois salva novamente
        $usuario = $this->_Modelo->db->Sql_Select('Usuario', Array('id'=>$id));
        self::mysql_AtualizaValores($usuario);
        $sucesso =  $this->_Modelo->db->Sql_Update($usuario);
        
        $this->Usuarios_Produtos($id);
        comercio_certificado_PropostaControle::RecarregaLocalizar();
        
        if($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => 'Alteração bem sucedida',
                "mgs_secundaria" => $_POST["nome"].' foi alterado com sucesso.'
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
