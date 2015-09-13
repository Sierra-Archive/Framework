
<?php
class usuario_PerfilControle extends usuario_Controle
{
    /**
    * Construtor
    * 
    * @name __construct
    * @access public
    * 
    * @uses usuario_rede_PerfilModelo::Carrega Rede Modelo
    * @uses usuario_rede_PerfilVisual::Carrega Rede Visual
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 3.1.1
    */
    public function __construct(){
        parent::__construct();
    }
    public function Perfil_Show($usuarioid,$tipo='Cliente'){
        // GAmbiarra Para Consertar erro de acento em url
        if($tipo=='Funcionrio' || $tipo=="Funcionario") $tipo = "Funcionário";
        if($tipo=="Usurio" || $tipo=="Usuario")         $tipo = __('Usuário');
        // Verifica Permissao e Puxa Usuário
        $usuario = $this->_Modelo->db->Sql_Select('Usuario',Array('id'=>$usuarioid),1); // Banco DAO, Condicao e LIMITE
        // Resgata DAdos e Manda pra View
        if($usuario===false)            throw new \Exception('Usuario não Existe',404);
        $id = $usuario->id;
        // Carrega Mensagens
        /*if(\Framework\App\Sistema_Funcoes::Perm_Modulos('usuario_mensagem')){
            usuario_mensagem_SuporteControle::MensagensdeCliente($id,'Menor');
            $this->_Visual->Show_Perfil($tipo,$usuario,'Maior');
        }else{*/
            $this->_Visual->Show_Perfil($tipo,$usuario);
        //}
    }
    /**
    * Main
    * 
    * @name Main
    * @access public
    * 
    * @uses usuario_Controle::$usuarioPerfil
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 3.1.1
    */
    public function Main(){
        $this->Usuarios_Edit(0,'Cliente');
        self::usuarios_carregaAlterarSenha($this,$this->_Modelo,$this->_Visual,Usuario_DAO::Get_Colunas());
        if(\Framework\App\Sistema_Funcoes::Perm_Modulos('usuario_veiculo')){
            self::usuarios_Upload_Residencia($this,$this->_Modelo,$this->_Visual);
            self::usuarios_Upload_Cnh($this,$this->_Modelo,$this->_Visual);
        }
        
        if(\Framework\App\Sistema_Funcoes::Perm_Modulos('Financeiro')){
            usuario_Controle::PlanoStatus($this->_Modelo, $this->_Visual, $this->_Acl->Usuario_GetID());
        }
        // ORGANIZA E MANDA CONTEUDO
        $this->_Visual->Json_Info_Update('Titulo', __('Meu Perfil')); 
    }
    public function PerfilFoto_UploadVer($camada,$id){
        $camada = (string) \anti_injection($camada);
        $id = (int) \anti_injection($id);
       
        
    }
    /**
     * 
     */
    public function PerfilFoto_Upload($id){
        $id = (int) $id;
        $fileTypes = array('jpg','jpeg','gif','png'); // File extensions
        $dir = 'usuario'.DS;
        $ext = $this->Upload($dir,$fileTypes,$id);
        if($ext!='falso'){
            $this->_Modelo->Perfilfoto_Upload_Alterar($id,$ext);  
        }
    }
    /**
     * 
     */
    public function RESFoto_Upload($id){
        $id = (int) $id;
        $fileTypes = array('jpg','jpeg','gif','png'); // File extensions
        $dir = 'usuario'.DS;
        $ext = $this->Upload($dir,$fileTypes,$id.'_res');
        if($ext!='falso'){
            $this->_Modelo->RESfoto_Upload_Alterar($id,$ext);  
        }
    }
    public function RESFoto_UploadVer($camada,$id){
        $camada = (string) \anti_injection($camada);
        $id = (int) \anti_injection($id);
       
        
    }
    static function usuarios_Upload_Residencia(&$controle,&$modelo,&$Visual){
        $Registro = &\Framework\App\Registro::getInstacia();
        $_Acl = $Registro->_Acl();
        if($_Acl->logado_usuario->foto_res==''){
            $Visual->Blocar('<font color="#FF0000"><b>Você ainda não subiu seu comprovante de Residencia</b></font><br>');
        }else{
            if($_Acl->logado_usuario->foto_res_apv==0) $Visual->Blocar('<font color="#FF0000"><b>Aguardando Aprovação</b></font><br>');
            else if($_Acl->logado_usuario->foto_res_apv==2) $Visual->Blocar('<b>Aprovado</b><br>');
            else                                             $Visual->Blocar('<font color="#FF0000"><b>Negado</b></font><br>');
        }
        $Visual->Blocar($Visual->Show_Upload('usuario','Perfil','RESFoto','User_RES_Imagem'.$_Acl->logado_usuario->id,$_Acl->logado_usuario->foto_res,'usuario'.DS,$_Acl->logado_usuario->id));
        $Visual->Bloco_Menor_CriaJanela(__('Fazer upload de Comprovante de Residência')); 
    }
    /**
     * 
     */
    public function CNHFoto_Upload($id){
        $id = (int) $id;
        $fileTypes = array('jpg','jpeg','gif','png'); // File extensions
        $dir = 'usuario'.DS;
        $ext = $this->Upload($dir,$fileTypes,$id.'_cnh');
        if($ext!='falso'){
            $this->_Modelo->CNHfoto_Upload_Alterar($id,$ext);  
        }
    }
    public function CNHFoto_UploadVer($camada,$id){
        $camada = (string) \anti_injection($camada);
        $id = (int) \anti_injection($id);
       
        
    }
    static function usuarios_Upload_Cnh(&$controle,&$modelo,&$Visual){
        $Registro = &\Framework\App\Registro::getInstacia();
        $_Acl = $Registro->_Acl();
        if($_Acl->logado_usuario->foto_cnh==''){
            $Visual->Blocar('<font color="#FF0000"><b>Você ainda não subiu sua CNH</b></font><br>');
        }else{
            if($_Acl->logado_usuario->foto_cnh_apv==0) $Visual->Blocar('<font color="#FF0000"><b>Aguardando Aprovação da CNH</b></font><br>');
            else if($_Acl->logado_usuario->foto_cnh_apv==2) $Visual->Blocar('<b>CNH Aprovada</b><br>');
            else                                             $Visual->Blocar('<font color="#FF0000"><b>CNH Negada</b></font><br>');
        }
        $Visual->Blocar($Visual->Show_Upload('usuario','Perfil','CNHFoto','User_CNH_Imagem'.$_Acl->logado_usuario->id,$_Acl->logado_usuario->foto_cnh,'usuario'.DS,$_Acl->logado_usuario->id));
        $Visual->Bloco_Menor_CriaJanela(__('Fazer Upload da CNH')); 
    }
    static function usuarios_carregaAlterarSenha(&$controle,&$modelo,&$Visual,$campos){
        $id = \Framework\App\Acl::Usuario_GetID_Static();
        // Carrega Config
        $titulo1    = 'Alterar Senha (#'.$id.')';
        $titulo2    = __('Alterar Senha');
        $formid     = 'form_perfil_senha';
        $formbt     = __('Alterar Grupo');
        $formlink   = 'usuario/Perfil/usuarios_carregaAlterarSenha2/';
        $editar     = Array('Usuario',$id);
        $campos = Usuario_DAO::Get_Colunas();
        self::DAO_Campos_Retira($campos, 'senha',1);
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos,$editar); 
    }
    public function usuarios_carregaAlterarSenha2(){
        $id = (int) $this->_Acl->Usuario_GetID();
        $titulo     = __('Senha editada com Sucesso');
        $dao        = Array('Usuario',$id);
        $funcao     = '$this->Main();';
        $sucesso1   = __('Senha Alterada com Sucesso.');
        $sucesso2   = __('Guarde sua senha com carinho.');
        $alterar    = Array();
        $sucesso = $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);   
        
        if($sucesso===true){
            $this->_Modelo->Usuario_Logar('',$usuario->senha,'');
        }
    }
    /**
     * 
     */
    public function Plano_Popup(){
        if($this->_Acl->Usuario_GetLogado()){
            $html = $this->Show_ConhecaOsPlanos();
            // Gera formulario
            $campos = Usuario_DAO::Gerar_Colunas();
            $form = new \Framework\Classes\Form('usuario_Perfil_AlterarPlano','usuario/perfil/Plano_Alterar/','formajax','full');
            self::DAO_Campos_Retira($campos,'grupo',1);
            \Framework\App\Controle::form_gerador($campos, $form);
            $html .= $form->retorna_form();
            $conteudo = array(
                'id' => 'popup',
                'title' => 'Alterar Plano de Associado',
                'botoes' => array(
                    array(
                        'text' => 'Alterar Plano',
                        'clique' => '$(\'#adminformveiculosagenda\').submit();'
                    ),
                    array(
                        'text' => 'Cancelar',
                        'clique' => '$( this ).dialog( "close" );'
                    )
                ),
                'html' => $html
            );
            $this->_Visual->Json_IncluiTipo('Popup',$conteudo);
            //$this->_Visual->Json_IncluiTipo('JavascriptInterno',$this->_Visual->Javascript_Executar());
            //$this->_Visual->Javascript_Executar() = '';
        }else{
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('É necessário se logar para continuar')
            );
            $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        }
    }
     /**
     * Inserir
     * 
     * @name agendamento_inserir
     * @access public
     * 
     * 
     * 
     * @return void
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public function Plano_Alterar(){
        
        if($_POST['nivel_usuario']<=$this->_Acl->logado_usuario->nivel_usuario || ($_POST['nivel_usuario']!=0 && $_POST['nivel_usuario']!=1 && $_POST['nivel_usuario']!=2 && $_POST['nivel_usuario']!=3 && $_POST['nivel_usuario']!=4)){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Tipo de Usuário Inválido')
            );
            $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens); 
            $this->_Visual->Javascript_Executar('$("#nivel_usuario").css(\'border\', \'2px solid #FFAEB0\').focus();');
        } else {
            $nivel_usuario = (int) \anti_injection($_POST['nivel_usuario']);
            $sucesso =  $this->_Modelo->PlanoAlterar($nivel_usuario);
            // inseri e mostra mensagem
            if($sucesso==1){
                $mensagens = array(
                    "tipo" => 'sucesso',
                    "mgs_principal" => __('Alteração bem sucedida'),
                    "mgs_secundaria" => __('Plano alterado com sucesso.')
                );
                $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
                // fecha popup e atualiza dados
                $this->_Visual->Javascript_Executar('$(\'#popup\').dialog( "close" );');
            }else{
                $mensagens = array(
                    "tipo" => 'erro',
                    "mgs_principal" => __('Erro'),
                    "mgs_secundaria" => __('Erro')
                );
                $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens); 
            }
        } 
    }
    public function Perfil_Edit($tipo=false){
        $id = (int) $this->_Acl->Usuario_GetID();
        $usuario = $this->_Modelo->db->Sql_Select('Usuario', Array('id'=>$id));
        if($tipo===false){
            if($usuario->grupo==CFG_TEC_IDCLIENTE){
                $tipo   = __('Cliente');
                $tipo2  = 'cliente';
            }else if($usuario->grupo==CFG_TEC_IDFUNCIONARIO){
                $tipo   = __('Funcionário');
                $tipo2  = 'funcionario';
            }else{
                $tipo   = __('Usuário');
                $tipo2  = __('usuario');
            }
        }else{
            // Primeira Letra Maiuscula
            $tipo = ucfirst($tipo);
        }
        // GAmbiarra Para Consertar erro de acento em url
        if($tipo=='Funcionrio' || $tipo=="Funcionario") $tipo = "Funcionário";
        if($tipo=="Usurio" || $tipo=="Usuario")         $tipo = __('Usuário');
        // Cria Tipo 2:
        if($tipo=='Cliente'){
            $tipo2      = 'cliente';
            $tipo_pass  = CFG_TEC_CAT_ID_CLIENTES;
            $tipo   = Framework\Classes\Texto::Transformar_Plural_Singular(\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('usuario_Cliente_nome'));
        }else if($tipo=='Funcionário'){
            $tipo2  = 'funcionario';
            $tipo_pass  = CFG_TEC_CAT_ID_FUNCIONARIOS;
        }else{
            $tipo_pass  = CFG_TEC_CAT_ID_ADMIN;
        }
        // Carrega Config
        $titulo1    = __('Meu Perfil');
        $titulo2    = __('Alterar meu Perfil');
        $formid     = 'form_usuario_PerfilEdit';
        $formbt     = __('Alterar meu Perfil');
        $formlink   = 'usuario/Perfil/Perfil_Edit2/'.$id;
        $editar     = Array('Usuario',$id);
        $campos = Usuario_DAO::Get_Colunas();
        usuario_Controle::Campos_Deletar($tipo_pass, $campos,$usuario);
        self::DAO_Campos_Retira($campos, 'login');
        self::DAO_Campos_Retira($campos, 'senha');
        self::DAO_Campos_Retira($campos, 'grupo');
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos,$editar);
    }
    /**
     * 
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public function Perfil_Edit2($tipo=false){
        if(isset($_POST["nome"])){
            $nome = $_POST["nome"];
        }else{
            $nome = __('Perfil');
        }
        $id = (int) $this->_Acl->Usuario_GetID();
        $titulo     = __('Perfil Editado com Sucesso');
        $dao        = Array('Usuario',$id);
        $funcao     = '$this->Perfil_Edit();';
        $sucesso1   = __('Perfil Alterado com Sucesso.');
        $sucesso2   = ''.$nome.' teve a alteração bem sucedida';
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);      
    }
}

/*<?php
class usuario_PerfilControle extends usuario_Controle
{
    /**
    * Construtor
    * 
    * @name __construct
    * @access public
    * 
    * @uses usuario_rede_PerfilModelo::Carrega Rede Modelo
    * @uses usuario_rede_PerfilVisual::Carrega Rede Visual
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 3.1.1
    *//*
    public function __construct(){
        parent::__construct();
    }
    public function Perfil_Show($usuarioid,$tipo='Cliente'){
        // GAmbiarra Para Consertar erro de acento em url
        if($tipo=='Funcionrio' || $tipo=="Funcionario") $tipo = "Funcionário";
        if($tipo=="Usurio" || $tipo=="Usuario")         $tipo = __('Usuário');
        // Verifica Permissao e Puxa Usuário
        $usuario = $this->_Modelo->db->Sql_Select('Usuario',Array('id'=>$usuarioid),1); // Banco DAO, Condicao e LIMITE
        // Resgata DAdos e Manda pra View
        if($usuario===false)            throw new \Exception(404,'Usuario não Existe');
        $id = $usuario->id;
        // Carrega Mensagens
        /*if(\Framework\App\Sistema_Funcoes::Perm_Modulos('usuario_mensagem')){
            usuario_mensagem_SuporteControle::MensagensdeCliente($id,'Menor');
            $this->_Visual->Show_Perfil($tipo,$usuario,'Maior');
        }else{*//*
            $this->_Visual->Show_Perfil($tipo,$usuario);
        //}
    }/*
    /**
    * Main
    * 
    * @name Main
    * @access public
    * 
    * @uses usuario_Controle::$usuarioPerfil
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 3.1.1
    *//*
    public function Main(){
        return false;
    }
    public function Perfil(){
        $this->Usuarios_Edit(0,'Cliente');
        self::usuarios_carregaAlterarSenha($this,$this->_Modelo,$this->_Visual,Usuario_DAO::Get_Colunas());
        if(\Framework\App\Sistema_Funcoes::Perm_Modulos('usuario_veiculo')){
            self::usuarios_Upload_Residencia($this,$this->_Modelo,$this->_Visual);
            self::usuarios_Upload_Cnh($this,$this->_Modelo,$this->_Visual);
        }
        
        if(\Framework\App\Sistema_Funcoes::Perm_Modulos('Financeiro')){
            usuario_Controle::PlanoStatus($this->_Modelo, $this->_Visual, $this->get_usuarioid());
        }
        // ORGANIZA E MANDA CONTEUDO
        $this->_Visual->Json_Info_Update('Titulo', __('Meu Perfil')); 
    }
    public function PerfilFoto_UploadVer($camada,$id){
        $camada = (string) \anti_injection($camada);
        $id = (int) \anti_injection($id);
    }
    /**
     * 
     *//*
    public function PerfilFoto_Upload($id){
        $id = (int) $id;
        $fileTypes = array('jpg','jpeg','gif','png'); // File extensions
        $dir = 'usuario'.DS;
        $ext = $this->Upload($dir,$fileTypes,$id);
        if($ext!='falso'){
            $this->_Modelo->Perfilfoto_Upload_Alterar($id,$ext);  
        }
    }
    /**
     * 
     *//*
    public function RESFoto_Upload($id){
        $id = (int) $id;
        $fileTypes = array('jpg','jpeg','gif','png'); // File extensions
        $dir = 'usuario'.DS;
        $ext = $this->Upload($dir,$fileTypes,$id.'_res');
        if($ext!='falso'){
            $this->_Modelo->RESfoto_Upload_Alterar($id,$ext);  
        }
    }
    public function RESFoto_UploadVer($camada,$id){
        $camada = (string) \anti_injection($camada);
        $id = (int) \anti_injection($id);
       
        
    }
    static function usuarios_Upload_Residencia(&$controle,&$modelo,&$Visual){
        if($controle->usuario->foto_res==''){
            $Visual->Blocar('<font color="#FF0000"><b>Você ainda não subiu seu comprovante de Residencia</b></font><br>');
        }else{
            if($controle->usuario->foto_res_apv==0) $Visual->Blocar('<font color="#FF0000"><b>Aguardando Aprovação</b></font><br>');
            else if($controle->usuario->foto_res_apv==2) $Visual->Blocar('<b>Aprovado</b><br>');
            else                                             $Visual->Blocar('<font color="#FF0000"><b>Negado</b></font><br>');
        }
        $Visual->Blocar($Visual->Show_Upload('usuario','Perfil','RESFoto','User_RES_Imagem'.$controle->usuario->id,$controle->usuario->foto_res,'usuario'.DS,$controle->usuario->id));
        $Visual->Bloco_Menor_CriaJanela(__('Fazer upload de Comprovante de Residência')); 
    }
    /**
     * 
     *//*
    public function CNHFoto_Upload($id){
        $id = (int) $id;
        $fileTypes = array('jpg','jpeg','gif','png'); // File extensions
        $dir = 'usuario'.DS;
        $ext = $this->Upload($dir,$fileTypes,$id.'_cnh');
        if($ext!='falso'){
            $this->_Modelo->CNHfoto_Upload_Alterar($id,$ext);  
        }
    }
    public function CNHFoto_UploadVer($camada,$id){
        $camada = (string) \anti_injection($camada);
        $id = (int) \anti_injection($id);
       
        
    }
    static function usuarios_Upload_Cnh(&$controle,&$modelo,&$Visual){
        if($controle->usuario->foto_cnh==''){
            $Visual->Blocar('<font color="#FF0000"><b>Você ainda não subiu sua CNH</b></font><br>');
        }else{
            if($controle->usuario->foto_cnh_apv==0) $Visual->Blocar('<font color="#FF0000"><b>Aguardando Aprovação da CNH</b></font><br>');
            else if($controle->usuario->foto_cnh_apv==2) $Visual->Blocar('<b>CNH Aprovada</b><br>');
            else                                             $Visual->Blocar('<font color="#FF0000"><b>CNH Negada</b></font><br>');
        }
        $Visual->Blocar($Visual->Show_Upload('usuario','Perfil','CNHFoto','User_CNH_Imagem'.$controle->usuario->id,$controle->usuario->foto_cnh,'usuario'.DS,$controle->usuario->id));
        $Visual->Bloco_Menor_CriaJanela(__('Fazer Upload da CNH')); 
    }
    static function usuarios_carregaAlterarSenha(&$controle,&$modelo,&$Visual,$campos){
        $id = \Framework\App\Acl::Usuario_GetID_Static();
        // Carrega Config
        $titulo1    = 'Alterar Senha (#'.$id.')';
        $titulo2    = __('Alterar Senha');
        $formid     = 'form_perfil_senha';
        $formbt     = __('Alterar Grupo');
        $formlink   = 'usuario/Perfil/usuarios_carregaAlterarSenha2/';
        $editar     = Array('Usuario',$id);
        $campos = Usuario_DAO::Get_Colunas();
        self::DAO_Campos_Retira($campos, 'senha',1);
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos,$editar); 
    }
    public function usuarios_carregaAlterarSenha2(){
        $id = (int) $this->get_usuarioid();
        $titulo     = __('Senha editada com Sucesso');
        $dao        = Array('Usuario',$id);
        $funcao     = '$this->Main();';
        $sucesso1   = __('Senha Alterada com Sucesso.');
        $sucesso2   = __('Guarde sua senha com carinho.');
        $alterar    = Array();
        $sucesso = $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);   
        
        if($sucesso===true){
            $this->_Modelo->Usuario_Logar('',$usuario->senha,'');
        }
    }
    /**
     * 
     *//*
    public function Plano_Popup(){
        if($this->get_logado()){
            $html = $this->Show_ConhecaOsPlanos();
            // Gera formulario
            $campos = Usuario_DAO::Gerar_Colunas();
            $form = new \Framework\Classes\Form('usuario_Perfil_AlterarPlano','usuario/perfil/Plano_Alterar/','formajax','full');
            self::DAO_Campos_Retira($campos,'grupo',1);
            \Framework\App\Controle::form_gerador($campos, $form);
            $html .= $form->retorna_form();
            $conteudo = array(
                'id' => 'popup',
                'title' => 'Alterar Plano de Associado',
                'botoes' => array(
                    array(
                        'text' => 'Alterar Plano',
                        'clique' => '$(\'#adminformveiculosagenda\').submit();'
                    ),
                    array(
                        'text' => 'Cancelar',
                        'clique' => '$( this ).dialog( "close" );'
                    )
                ),
                'html' => $html
            );
            $this->_Visual->Json_IncluiTipo('Popup',$conteudo);
            //$this->_Visual->Json_IncluiTipo('JavascriptInterno',$this->_Visual->Javascript_Executar());
            //$this->_Visual->Javascript_Executar() = '';
        }else{
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('É necessário se logar para continuar')
            );
            $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        }
    }
     /**
     * Inserir
     * 
     * @name agendamento_inserir
     * @access public
     * 
     * 
     * 
     * @return void
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     *//*
    public function Plano_Alterar(){
        
        if($_POST['nivel_usuario']<=$this->_Acl->logado_usuario->nivel_usuario || ($_POST['nivel_usuario']!=0 && $_POST['nivel_usuario']!=1 && $_POST['nivel_usuario']!=2 && $_POST['nivel_usuario']!=3 && $_POST['nivel_usuario']!=4)){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Tipo de Usuário Inválido')
            );
            $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens); 
            $this->_Visual->Javascript_Executar('$("#nivel_usuario").css(\'border\', \'2px solid #FFAEB0\').focus();');
        } else {
            $nivel_usuario = (int) \anti_injection($_POST['nivel_usuario']);
            $sucesso =  $this->_Modelo->PlanoAlterar($nivel_usuario);
            // inseri e mostra mensagem
            if($sucesso===true){
                $mensagens = array(
                    "tipo" => 'sucesso',
                    "mgs_principal" => __('Alteração bem sucedida'),
                    "mgs_secundaria" => __('Plano alterado com sucesso.')
                );
                $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
                // fecha popup e atualiza dados
                $this->_Visual->Javascript_Executar('$(\'#popup\').dialog( "close" );');
            }else{
                $mensagens = array(
                    "tipo" => 'erro',
                    "mgs_principal" => __('Erro'),
                    "mgs_secundaria" => __('Erro')
                );
                $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens); 
            }
        } 
    }
    public function Perfil_Edit($tipo=false){
        $id = (int) $this->get_usuarioid();
        $usuario = $this->_Modelo->db->Sql_Select('Usuario', Array('id'=>$id));
        if($tipo===false){
            if($usuario->grupo==CFG_TEC_IDCLIENTE){
                $tipo   = __('Cliente');
                $tipo2  = 'cliente';
            }else if($usuario->grupo==CFG_TEC_IDFUNCIONARIO){
                $tipo   = __('Funcionário');
                $tipo2  = 'funcionario';
            }else{
                $tipo   = __('Usuário');
                $tipo2  = 'usuario';
            }
        }else{
            // Primeira Letra Maiuscula
            $tipo = ucfirst($tipo);
        }
        // GAmbiarra Para Consertar erro de acento em url
        if($tipo=='Funcionrio' || $tipo=="Funcionario") $tipo = "Funcionário";
        if($tipo=="Usurio" || $tipo=="Usuario")         $tipo = __('Usuário');
        // Cria Tipo 2:
        if($tipo=='Cliente'){
            $tipo2  = 'cliente';
            $tipo   = Framework\Classes\Texto::Transformar_Plural_Singular(\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('usuario_Cliente_nome'));
        }else if($tipo=='Funcionário'){
            $tipo2  = 'funcionario';
        }
        // Carrega Config
        $titulo1    = __('Meu Perfil');
        $titulo2    = __('Alterar meu Perfil');
        $formid     = 'form_usuario_PerfilEdit';
        $formbt     = __('Alterar meu Perfil');
        $formlink   = 'usuario/Perfil/Perfil_Edit2/'.$id;
        $editar     = Array('Usuario',$id);
        $campos = Usuario_DAO::Get_Colunas();
        usuario_Controle::Campos_Deletar($tipo2, $campos,$usuario);
        self::DAO_Campos_Retira($campos, 'login');
        self::DAO_Campos_Retira($campos, 'senha');
        self::DAO_Campos_Retira($campos, 'grupo');
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos,$editar);
    }
    /**
     * 
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     *//*
    public function Perfil_Edit2($tipo=false){
        $id = (int) $this->get_usuarioid();
        $titulo     = __('Perfil Editado com Sucesso');
        $dao        = Array('Usuario',$id);
        $funcao     = '$this->Perfil_Edit();';
        $sucesso1   = __('Perfil Alterado com Sucesso.');
        $sucesso2   = ''.$_POST["nome"].' teve a alteração bem sucedida';
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);      
    }
}
?>*/