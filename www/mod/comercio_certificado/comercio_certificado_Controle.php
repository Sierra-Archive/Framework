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
    * @version 0.4.2
    */
    public function __construct() {
        // construct
        parent::__construct();
    }
    /**
     * 3º ABA (produtos)
     * Mostra o Editar ou Add Usuario em Tab
     * @param int $id Chave Primária (Id do Registro)
     */
    public function Usuarios_Produtos($id = 0) {
        if ($id==0) {
            \Framework\App\Visual::Layoult_Abas_Carregar('2',self::Usuarios_Add('cliente')     ,true);
            \Framework\App\Visual::Layoult_Abas_Carregar('3',$this->_Visual->ErroShow()        ,false);
            \Framework\App\Visual::Layoult_Abas_Carregar('4',$this->_Visual->ErroShow()        ,false);
            \Framework\App\Visual::Layoult_Abas_Carregar('5',$this->_Visual->ErroShow()        ,false);
            $this->_Visual->Json_Info_Update('Titulo', __('Listagem de Usuários'));
            $this->_Visual->Json_Info_Update('Historico',0);
        } else {
            \Framework\App\Visual::Layoult_Abas_Carregar('2',self::Usuarios_Edit('cliente',$id),false);
            \Framework\App\Visual::Layoult_Abas_Carregar('3',$this->Propostas_DashBoard($id)   ,true);
            \Framework\App\Visual::Layoult_Abas_Carregar('4',$this->Periodicas($id)   ,false);
            // Editar Aba 5
            $this->Usuario_UpdateInfo($id);
            // Joga pro Json se nao for o caso de popup
            $this->_Visual->Json_Info_Update('Titulo', __('Visualizar Usuário'));
            $this->_Visual->Json_Info_Update('Historico',0);
        }
    }
    /**
     * 2 ABA CLIENTE
     * Mostra o Editar ou Add Usuario em Tab
     * @param int $id Chave Primária (Id do Registro)
     */
    public function Usuarios_Mostrar($id = 0) {
        if ($id==0) {
            \Framework\App\Visual::Layoult_Abas_Carregar('2',self::Usuarios_Add('cliente')     ,true);
            \Framework\App\Visual::Layoult_Abas_Carregar('3',$this->_Visual->ErroShow()        ,false);
            \Framework\App\Visual::Layoult_Abas_Carregar('4',$this->_Visual->ErroShow()        ,false);
            \Framework\App\Visual::Layoult_Abas_Carregar('5',$this->_Visual->ErroShow()        ,false);
            $this->_Visual->Json_Info_Update('Titulo', __('Listagem de Usuários'));
        } else {
            \Framework\App\Visual::Layoult_Abas_Carregar('2',self::Usuarios_Edit('cliente',$id),true);
            \Framework\App\Visual::Layoult_Abas_Carregar('3',$this->Propostas_DashBoard($id)   ,false);
            \Framework\App\Visual::Layoult_Abas_Carregar('4',$this->Periodicas($id)   ,false);
            // Editar Aba 5
            $this->Usuario_UpdateInfo($id);
            // Titulo
            $this->_Visual->Json_Info_Update('Titulo', __('Visualizar Usuário'));
        }
        // Joga pro Json se nao for o caso de popup
        $this->_Visual->Json_Info_Update('Historico',0);
    }
    public static function Usuario_UpdateInfo($id = 0) {
        $Registro   = &\Framework\App\Registro::getInstacia();
        $Modelo     = $Registro->_Modelo;
        $Visual     = $Registro->_Visual;
        $abas_id    = &$Visual->config_template['plugins']['abas_id'];
        if ($id==0 || !isset($id)) {
            $id = (int) $this->_Acl->Usuario_GetID();
        } else {
            $id = (int) $id;
        }
        // Carrega campos e retira os que nao precisam
        $campos = Usuario_DAO::Get_Colunas();
        self::DAO_Campos_Retira($campos, 'obs',1);
        $usuario = $Modelo->db->Sql_Select('Usuario', Array('id'=>$id));
        if ($usuario===false) {
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
    
    public static function Usuario_UpdateInfo2($id) {
        
        $Registro   = &\Framework\App\Registro::getInstacia();
        $Controle   = $Registro->_Controle;
        $Modelo     = $Registro->_Modelo;
        $Visual     = $Registro->_Visual;
        $id = (int) $id;
        // Puxa o usuario, e altera seus valores, depois salva novamente
        $usuario = $Modelo->db->Sql_Select('Usuario', Array('id'=>$id));
        self::mysql_AtualizaValores($usuario);
        $sucesso =  $Modelo->db->Sql_Update($usuario);
        
        if ($sucesso===true) {
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Alteração bem sucedida'),
                "mgs_secundaria" => $_POST["nome"].' foi alterado com sucesso.'
            );
        } else {
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Erro')
            );
        }
        $Controle->Json_Definir_zerar(false);
        $Visual->Json_IncluiTipo('Mensagens',$mensagens);    
    }
    public static function Usuarios_Add($tipo=false) {
        // Carrega campos e retira os que nao precisam
        $campos = Usuario_DAO::Get_Colunas();
        // Retira os de clientes
        $linkextra = '';
        if ($tipo=='cliente') {
            $linkextra = $tipo.'/';
        }
        // Carrega formulario
        $form = new \Framework\Classes\Form('form_Sistema_Admin_Usuarios','comercio_certificado/Proposta/Usuarios_Add2/'.$linkextra,'formajax');
        // Retira os campos invalidos
        usuario_Controle::Campos_Deletar($tipo, $campos, $form);
        // Chama Formulario
        \Framework\App\Controle::Gerador_Formulario($campos, $form);

        if ($tipo=='cliente') {
            $formulario = $form->retorna_form('Cadastrar Cliente');
        } else {
            $formulario = $form->retorna_form('Cadastrar Usuário');
        }
        return $formulario;
    }
    public static function Usuarios_Edit($tipo='usuario',$id = 0) {
        $Registro   = &\Framework\App\Registro::getInstacia();
        $Modelo     = $Registro->_Modelo;
        if ($id==0 || !isset($id)) {
            $id = (int) $this->_Acl->Usuario_GetID();
        } else {
            $id = (int) $id;
        }
        // Carrega campos e retira os que nao precisam
        $campos = Usuario_DAO::Get_Colunas();
        self::DAO_Campos_Retira($campos, 'senha');
        $usuario = $Modelo->db->Sql_Select('Usuario', Array('id'=>$id));
        if ($usuario===false) throw new \Exception('Usuário não existe', 8010);
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
     * @access public static
     * 
     * 
     * 
     * @return void
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Usuarios_Add2($tipo=false) {
        
        $Registro   = &\Framework\App\Registro::getInstacia();
        $Modelo     = &$Registro->_Modelo;
        $Visual     = &$Registro->_Visual;
       
        if (isset($_POST['email'])) {
            $email = \Framework\App\Conexao::anti_injection($_POST['email']);
        } else {
            $email = '';
        }
        if (isset($_POST['login'])) {
            $login = \Framework\App\Conexao::anti_injection($_POST['login']);
        } else {
            $login = '';
        }
        $existeemail = usuario_Modelo::VerificaExtEmail($Modelo,$email);
        $existelogin = usuario_Modelo::VerificaExtLogin($Modelo,$login);
        if (\Framework\App\Sistema_Funcoes::Control_Layoult_Valida_Email($email)===false && $tipo!='cliente') {
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Email Inválido')
            );
            $Visual->Json_IncluiTipo('Mensagens',$mensagens);
            $this->layoult_zerar = false;
            $Visual->Javascript_Executar('$("#email").css(\'border\', \'2px solid #FFAEB0\').focus();');
         } else if ($existeemail===true && ($tipo!='cliente' || $email!='')) {
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Email Ja Existe')
            );
            $Visual->Json_IncluiTipo('Mensagens',$mensagens); 
            $this->layoult_zerar = false;
            $Visual->Javascript_Executar('$("#email").css(\'border\', \'2px solid #FFAEB0\').focus();');
        } else if ($existelogin===true && $tipo!='cliente') {
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Login ja existe')
            );
            $Visual->Json_IncluiTipo('Mensagens',$mensagens); 
            $this->layoult_zerar = false;
            $Visual->Javascript_Executar('$("#login").css(\'border\', \'2px solid #FFAEB0\').focus();');
        } else {
            $tipousuario = \Framework\App\Conexao::anti_injection($tipo);

            // atualiza todos os valores por get, retirando o nivel admin
            //self::mysql_AtualizaValores($usuario);

            

            // Cria novo Usuario
            $usuario = new Usuario_DAO;
            self::mysql_AtualizaValores($usuario);
        
            // confere senha
            if (isset($_POST['senha'])) {
                if ($_POST['senha']=='') {
                    $mensagens = array(
                        "tipo" => 'erro',
                        "mgs_principal" => __('Erro'),
                        "mgs_secundaria" => __('Senha Inválida')
                    );
                    $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
                    $this->layoult_zerar = false;
                    return;
                }
            }

            // captura indicado;
            if (!isset($_COOKIE['indicativo_id'])) $_COOKIE['indicativo_id'] = 0;
            self::mysql_AtualizaValor($usuario,'indicado_por', $_COOKIE['indicativo_id']);

            
            //insere usuario
            $sucesso =  $Modelo->db->Sql_Insert($usuario);

            // Recarrega Main
            $idusuario = $Modelo->db->Sql_Select('Usuario', Array(),1,'id DESC');
            $this->Usuarios_Produtos($idusuario->id);
            comercio_certificado_PropostaControle::RecarregaLocalizar();

            if ($sucesso===true) {
                $mensagens = array(
                    "tipo" => 'sucesso',
                    "mgs_principal" => __('Inserção bem sucedida'),
                    "mgs_secundaria" => __('Voce foi cadastrado com sucesso.')
                );                
            } else {
                $mensagens = array(
                    "tipo" => 'erro',
                    "mgs_principal" => __('Erro'),
                    "mgs_secundaria" => __('Erro')
                );
            }
            $Visual->Json_IncluiTipo('Mensagens',$mensagens); 
        }
    }
    /**
     * 
     * 
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Usuarios_Edit2($tipo='usuario',$id) {
        
        $id = (int) $id;
        // Puxa o usuario, e altera seus valores, depois salva novamente
        $usuario = $this->_Modelo->db->Sql_Select('Usuario', Array('id'=>$id));
        self::mysql_AtualizaValores($usuario);
        $sucesso =  $this->_Modelo->db->Sql_Update($usuario);
        
        $this->Usuarios_Produtos($id);
        comercio_certificado_PropostaControle::RecarregaLocalizar();
        
        if ($sucesso===true) {
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Alteração bem sucedida'),
                "mgs_secundaria" => $_POST["nome"].' foi alterado com sucesso.'
            );
        } else {
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Erro')
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);    
    }
}
?>
