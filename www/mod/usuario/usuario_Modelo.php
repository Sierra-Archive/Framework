<?php
class usuario_Modelo extends \Framework\App\Modelo
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
    * Retorna todos os usuarios
    * 
    * @name retorna_usuarios
    * @access public
    * 
    * @uses MYSQL_USUARIOS
    * @uses \Framework\App\Modelo::$usuario
    * @uses \Framework\App\Modelo::$db
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 2.0
     * #update
    */
    /*public function retorna_usuarios(&$usuarios,$ativado=1){
        $i = 0;
        $mysqlwhere = '';
        $sql = $this->db->query('SELECT id,nome,email,nivel_usuario,nivel_admin
        FROM '.MYSQL_USUARIOS.' WHERE deletado=0 AND ativado='.$ativado.' ORDER BY nome'); //P.categoria
        while ($campo = $sql->fetch_object()) {
            $usuarios[$i]['id'] = $campo->id;
            $usuarios[$i]['nome'] = $campo->nome;
            $usuarios[$i]['email'] = $campo->email;
            $usuarios[$i]['nivel_usuario'] = $campo->nivel_usuario;
            $usuarios[$i]['nivel_admin'] = $campo->nivel_admin;
            
            if(file_exists(MOD_PATH.'Financeiro'.DS.'Financeiro_Controle.php')){
                $saldo = Financeiro_Modelo::Carregar_Saldo($this, $campo->id);

                if($saldo<0){
                    $usuarios[$i]['saldo'] = '<font style="color:#FF0000;">- R$ '.number_format(abs($saldo), 2, ',', '.').'</font>';
                }else{
                    $usuarios[$i]['saldo'] = 'R$ '.number_format($saldo, 2, ',', '.');
                }
            }else{
                $usuarios[$i]['saldo'] = 'R$ 0,00';
            }
            ++$i;
        }
        return $i;
    }*/
    
    /**
     * Insere usuarios no Banco de Dados
     * 
     * @name usuarios_inserir
     * @access public
     * 
     * @return int
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    /*public function usuarios_inserir($tipo = 'cliente'){
        GLOBAL $config;
        if($tipo=='cliente')   $pago=0;
        else                           $pago=1;
        $this->campos[] = array(
            'Nome' =>  'nivel_usuario_pago',
            'mysql' => 'nivel_usuario_pago',
            'valorpadrao' => $pago
        );
        $this->campos[] = array(
            'Nome' =>  'data_cadastro',
            'mysql' => 'data_cadastro',
            'valorpadrao' => APP_HORA
        );
        $this->db->query('INSERT INTO '.MYSQL_USUARIOS.' '.$this->mysqlInsertCampos($this->campos));

        
       if($tipo!='cliente'){
            $sql = $this->db->query('SELECT id FROM '.MYSQL_USUARIOS.' WHERE email=\''.\anti_injection($_POST['email']).'\' ORDER BY id DESC LIMIT 1');
            while ($campo = $sql->fetch_object()) {
               $id = $campo->id;
            }
            eval('$valor = CONFIG_CLI_'.\anti_injection($_POST['nivel_usuario']).'_PRECO;');
            $dt_vencimento = date("Y-m-d", time() + (FINANCEIRO_DIASVENCIMENTO * 86400));
            Financeiro_Modelo::MovInt_Inserir($this,$id,$valor,0,'usuario',\anti_injection($_POST['nivel_usuario']),$dt_vencimento);
        }
        return 1;
    }
    /**
     * 
     * @param type $id
     * @return int
     */
    /*public function usuarios_alterar($id){
        $id = (int) $id;
        if(!isset($id) || !is_int($id) || $id==0) return 0;
        $this->db->query('UPDATE '.MYSQL_USUARIOS.' SET '.$this->mysqlUpdateCampos($this->campos).' WHERE id='.$id);
        
        return 1;
    }
    /**
     * 
     * @param type $id
     * @return string
     */
    /*public function retorna_usuario($id){
        $id = (int) $id;
        if(!isset($id) || !is_int($id) || $id==0) return 0;
        $sql = $this->db->query(' SELECT '.$this->mysqlSelectCampos($this->campos).'
        FROM '.MYSQL_USUARIOS.'
        WHERE id='.$id.' LIMIT 1'); //P.categoria
        while ($campo = $sql->fetch_object()) {
            $this->mysqlRetornaCampos($usuario,$this->campos,$campo);
            
            if(file_exists(MOD_PATH.'Financeiro'.DS.'Financeiro_Controle.php')){
                $saldo = Financeiro_Modelo::Carregar_Saldo($this, $campo->id);

                if($saldo<0){
                    $usuario->saldo = '<font style="color:#FF0000;">- R$ '.number_format(abs($saldo), 2, ',', '.').'</font>';
                }else{
                    $usuario->saldo = 'R$ '.number_format($saldo, 2, ',', '.');
                }
            }else{
                $usuario->saldo = 'R$ 0,00';
            }
        }
        return $usuario;
        
    }
    /**
     * 
     * @param type $modelo
     * @param type $email
     * @return int
     */
    static function VerificaExtEmail(&$modelo, $email){
        $sql = $modelo->db->query(' SELECT id
        FROM '.MYSQL_USUARIOS.'
        WHERE deletado!=1 AND email=\''.$email.'\''); //P.categoria
        while ($campo = $sql->fetch_object()) {
            return true;
        }
        return false;
    }
    /**
     * 
     * @param type $modelo
     * @param type $login
     * @return int
     */
    static function VerificaExtLogin(&$modelo, $login){
        $sql = $modelo->db->query(' SELECT id
        FROM '.MYSQL_USUARIOS.'
        WHERE deletado!=1 AND login=\''.$login.'\''); //P.categoria
        while ($campo = $sql->fetch_object()) {
            return true;
        }
        return false;
    }
    /**
     * 
     * @param type $modelo
     * @param type $user
     * @return string
     */
    static function PlanoStatus($modelo, $user){
        // Carrega e Inicializa Variavies
        $registro = \Framework\App\Registro::getInstacia();
        $acl = $registro->_Acl;
        $usuarioid = $acl->Usuario_GetID();
        $planostatus = Array();
        
        // Executa
        if(file_exists(MOD_PATH.'Financeiro'.DS.'Financeiro_Controle.php')){
            // CONSULTA SE TEM DEBIDOS NO MODO USUARIO
            $planopendente = Financeiro_Modelo::MovInt_VerificaDebito($modelo,$usuarioid,'usuario');
            if($planopendente!=0){
                $planostatus['status'] = '<font color="#FF0000">Pendente</font>';
                eval('$planostatus[\'plano\'] = CONFIG_CLI_'.$planopendente.'_NOME;');
                $planostatus['alterar'] = '';
            }else{
                $planostatus['status'] = 'Pago';
                eval('$planostatus[\'plano\'] = CONFIG_CLI_'.$acl->logado_usuario->nivel_usuario.'_NOME;');
                if($acl->logado_usuario->nivel_usuario<4){
                    $planostatus['alterar'] = '<a confirma="Deseja realmente alterar o seu plano?" title="Alterar Plano de Associado" class="lajax explicar-titulo" href="'.URL_PATH.'usuario/Perfil/Plano_Popup/" acao="">Clique Aqui</a>';
                }else{
                    $planostatus['alterar'] = '';
                }
            }
            return $planostatus;
        }else{
            return 0;
        }
    }
    /**
     * 
     * @param type $modelo
     * @param type $usuarioid
     * @param type $motivoid
     * @return int
     */
    static function Financeiro($usuarioid,$motivoid){
        $usuarioid = (int) $usuarioid;
        $registro = \Framework\App\Registro::getInstacia();
        $modelo = $registro->_Modelo;
        if(!isset($usuarioid) || !is_int($usuarioid) || $usuarioid==0) return 0;
        $modelo->db->query('UPDATE '.MYSQL_USUARIOS.' SET nivel_usuario_pago=1 WHERE deletado!=1 AND id='.$usuarioid);
        return 1;
    }
    /**
     * 
     * @param type $modelo
     * @param type $usuarioid
     * @param type $motivoid
     */
    static function Financeiro_Motivo_Exibir($motivoid){
        $registro = \Framework\App\Registro::getInstacia();
        $modelo = $registro->_Modelo;
        $text = 'CONFIG_CLI_'.$motivoid.'_NOME';
        return Array('Pagamento do Plano',$text);
    }
    
    
    
    
    
    
    
    
    protected function Usuario_Listagem($grupo=false,$ativado=false,$gravidade=0,$inverter=false,$export=false){
        $i = 0;
        if($grupo===false){
            $categoria = 0;
            if($inverter){
                $where = 'ativado!='.$ativado;
            }else{
                $where = 'ativado='.$ativado;
            }
            if($ativado===false){
                $where = '';
            }
            $nomedisplay        = 'Usuários ';
            $nomedisplay_sing   = 'Usuário ';
            $nomedisplay_tipo   = 'Usuario';
            // Link
            $this->Tema_Endereco('Usuários');
        }else{
            $categoria = (int) $grupo[0];
            
            // Pega GRUPOS VALIDOS
            $sql_grupos = $this->_Modelo->db->Sql_Select('Sistema_Grupo','categoria='.$categoria,0,'','id');
            $grupos_id = Array();
            if(is_object($sql_grupos)) $sql_grupos = Array(0=>$sql_grupos);
            if($sql_grupos!==false && !empty($sql_grupos)){
                foreach ($sql_grupos as &$valor) {
                    $grupos_id[] = $valor->id;
                }
            }
            
            if(empty($grupos_id)) throw new \Exception('Grupos não existe', 404);
            
            // cria where de acordo com parametros
            if($inverter){
                $where = 'grupo NOT IN ('.implode(',',$grupos_id).') AND ativado='.$ativado;
            }else{
                $where = 'grupo IN ('.implode(',',$grupos_id).') AND ativado='.$ativado;
            }
            
            if($ativado===false){
                $where = explode(' AND ', $where);
                $where = $where[0];
            }
        
            $nomedisplay        = $grupo[1].' ';
            $nomedisplay_sing   = Framework\Classes\Texto::Transformar_Plural_Singular($grupo[1]);
            $nomedisplay_tipo   = Framework\Classes\Texto::Transformar_Plural_Singular($grupo[1]);
            // Link
            $this->Tema_Endereco($grupo[1]);
        }
        
        $linkextra = '';
        if($grupo!==false && $grupo[0]==CFG_TEC_CAT_ID_CLIENTES && $inverter===false){
            $linkextra = '/cliente';
            $link = 'usuario/Admin/ListarCliente';
            $link_editar = 'usuario/Admin/Cliente_Edit';
            $link_deletar = 'usuario/Admin/Cliente_Del';
            $link_add = 'usuario/Admin/Cliente_Add/'.$categoria;
        }
        else if($grupo!==false && $grupo[0]==CFG_TEC_CAT_ID_FUNCIONARIOS && $inverter===false){
            $linkextra = '/funcionario';
            $link = 'usuario/Admin/ListarFuncionario';
            $link_editar = 'usuario/Admin/Funcionario_Edit';
            $link_deletar = 'usuario/Admin/Funcionario_Del';
            $link_add = 'usuario/Admin/Funcionario_Add/'.$categoria;
        }else{
            $link = 'usuario/Admin/ListarUsuario';
            $link_editar = 'usuario/Admin/Usuarios_Edit';
            $link_deletar = 'usuario/Admin/Usuarios_Del';
            $link_add = 'usuario/Admin/Usuarios_Add/'.$categoria;
        }
        
        // add botao
        $this->_Visual->Blocar($this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            Array(
                'Adicionar '.Framework\Classes\Texto::Transformar_Plural_Singular($nomedisplay),
                $link_add,
                ''
            ),
            Array(
                'Print'     => true,
                'Pdf'       => true,
                'Excel'     => true,
                'Link'      => $link,
            )
        )));
        // Continua Resto
        //$this->_Visual->Blocar('<a title="Adicionar " class="btn btn-success lajax explicar-titulo" acao="" href="'.URL_PATH.'usuario/Admin/Usuarios_Add'.$linkextra.'">Adicionar novo '.Framework\Classes\Texto::Transformar_Plural_Singular($nomedisplay).'</a><div class="space15"></div>');
        $usuario = $this->_Modelo->db->Sql_Select('Usuario',$where,0,'','id,grupo,foto,nome,razao_social,email,email2,telefone,telefone2,celular,celular1,celular2,celular3,ativado,log_date_add');
        if(is_object($usuario)){
            $usuario = Array(0=>$usuario);
        }
        if($usuario!==false && !empty($usuario)){
            
            // Puxa Tabela e qnt de registro
            $registro   = \Framework\App\Registro::getInstacia();
            $Modelo     = &$registro->_Modelo;
            $Visual     = &$registro->_Visual;
            $tabela = Array();
            $i = 0;
            if(is_object($usuarios)){
                $usuarios = Array(0=>$usuarios);
            }
            reset($usuarios);

            // Permissoes (Fora Do LOOPING por performace)
            $usuario_Admin_Ativado_Listar   = \Framework\App\Acl::Sistema_Modulos_Configs_Funcional('usuario_Admin_Ativado_Listar');
            $usuario_Admin_Foto             = \Framework\App\Acl::Sistema_Modulos_Configs_Funcional('usuario_Admin_Foto');
            $Financeiro_User_Saldo          = \Framework\App\Acl::Sistema_Modulos_Configs_Funcional('Financeiro_User_Saldo');
            $usuario_mensagem_EmailSetor    = \Framework\App\Acl::Sistema_Modulos_Configs_Funcional('usuario_mensagem_EmailSetor');
            $usuario_Admin_Grupo            = \Framework\App\Acl::Sistema_Modulos_Configs_Funcional('usuario_Grupo_Mostrar');

            // Get Permissoes (Fora Do LOOPING por performace)
            $perm_view          = $registro->_Acl->Get_Permissao_Url($url_ver);
            $perm_comentario    = $registro->_Acl->Get_Permissao_Url('usuario/Admin/Usuarios_Comentario');
            $perm_anexo         = $registro->_Acl->Get_Permissao_Url('usuario/Anexo/Anexar');
            $perm_email         = $registro->_Acl->Get_Permissao_Url('usuario/Admin/Usuarios_Email');
            $perm_status        = $registro->_Acl->Get_Permissao_Url('usuario/Admin/Status');
            $perm_editar        = $registro->_Acl->Get_Permissao_Url($url_editar);
            $perm_del           = $registro->_Acl->Get_Permissao_Url($url_deletar);

            // Verifica Grupo
            $Ativado_Grupo = false;
            if(is_array($usuario_Admin_Grupo)){
                if($grupo===false || (is_array($grupo) && in_array($grupo[0], $usuario_Admin_Grupo))){
                    $Ativado_Grupo = true;
                }
            }else{
                if($usuario_Admin_Grupo===true){
                    $Ativado_Grupo = true;
                }
            }

            // Verifica foto
            $Ativado_Foto = false;
            if(is_array($usuario_Admin_Foto)){
                if($grupo===false || (is_array($grupo) && in_array($grupo[0], $usuario_Admin_Foto))){
                    $Ativado_Foto = true;
                }
            }else{
                if($usuario_Admin_Foto===true){
                    $Ativado_Foto = true;
                }
            }
            // Faz Looping Escrevendo Tabelas
            foreach ($usuarios as &$valor) {
                $tabela['Id'][$i]         = $valor->id;
                if($Ativado_Grupo===true){
                    $tabela['Grupo'][$i]      = $valor->grupo2;
                }
                if($Ativado_Foto===true){
                    if($valor->foto==='' || $valor->foto===false){
                        $foto = WEB_URL.'img'.US.'icons'.US.'clientes.png';
                    }else{
                        $foto = $valor->foto;
                    }
                    $tabela['Foto'][$i]             = '<img src="'.$foto.'" style="max-width:100px;" />';
                }
                //$tabela['#Id'][$i]               = '#'.$valor->id;
                $nome = '';
                // Atualiza Nome
                if($valor->nome!=''){
                    $nome .= $valor->nome;
                }
                // Atualiza Razao Social
                if($valor->razao_social!=''){
                    if($nome!='') $nome .= '<br>';
                    $nome .= $valor->razao_social;
                }
                // Se tiver Mensagens
                if(\Framework\App\Sistema_Funcoes::Perm_Modulos('usuario_mensagem')){
                    $nome = '<a href="'.URL_PATH.'usuario_mensagem/Suporte/Mostrar_Cliente/'.$valor->id.'/">'.$nome.' ('.usuario_mensagem_SuporteModelo::Suporte_MensagensCliente_Qnt($valor->id).')</a>';
                }
                // Mostra Nome
                $tabela['Nome'][$i]             = $nome;
                $telefone = '';
                if($valor->telefone!=''){
                    $telefone .= $valor->telefone;
                }
                if($valor->telefone2!=''){
                    if($telefone!='') $telefone .= '<br>';
                    $telefone .= $valor->telefone1;
                }
                if($valor->celular!=''){
                    if($telefone!='') $telefone .= '<br>';
                    $telefone .= $valor->celular;
                }
                if($valor->celular1!=''){
                    if($telefone!='') $telefone .= '<br>';
                    $telefone .= $valor->celular1;
                }
                if($valor->celular2!=''){
                    if($telefone!='') $telefone .= '<br>';
                    $telefone .= $valor->celular2;
                }
                if($valor->celular3!=''){
                    if($telefone!='') $telefone .= '<br>';
                    $telefone .= $valor->celular3;
                }

                $tabela['Contato'][$i]         = $telefone;
                $email = '';
                if($valor->email!=''){
                    $email .= $valor->email;
                }
                if($valor->email2!=''){
                    if($email!='') $email .= '<br>';
                    $email .= $valor->email2;
                }


                $tabela['Email'][$i]      =  $email;
                //$tabela['Nivel de Usuário'][$i] = $niveluser;
                //$tabela['Nivel de Admin'][$i]   = $niveladmin;
                // para MOdulos que contem banco
                if(\Framework\App\Sistema_Funcoes::Perm_Modulos('Financeiro') && $Financeiro_User_Saldo){
                    $tabela['Saldo'][$i]        = Financeiro_Modelo::Carregar_Saldo($Modelo, $valor->id, true);
                }
                // Funcoes

                if(strpos($valor->log_date_add, APP_DATA_BR)!==false){
                    $data_add = '<b>'.$valor->log_date_add.'</b>';
                }else{
                    $data_add = $valor->log_date_add;
                }
                $tabela['Data de Cadastro'][$i] = $data_add;

                // Visualizar
                $funcoes_qnt = 1;
                $tabela['Funções'][$i]          = $Visual->Tema_Elementos_Btn('Visualizar'     ,Array('Visualizar '.$nomedisplay_sing        ,$url_ver.'/'.$valor->id.'/'.$linkextra    ,''),$perm_view);



                // Financeiro Especifico
                /*if(\Framework\App\Sistema_Funcoes::Perm_Modulos('Financeiro') && $Financeiro_User_Saldo){
                    $tabela['Funções'][$i]     .=   '<a confirma="O '.$nomedisplay_sing.' realizou um deposito para a empresa?" title="Add quantia ao Saldo do '.$nomedisplay_sing.'" class="btn lajax explicar-titulo" acao="" href="'.URL_PATH.'Financeiro/Admin/financeiro_deposito/'.$valor->id.$linkextra.'"><img border="0" src="'.WEB_URL.'img/icons/cifrao_16x16.png" alt="Depositar"></a>'.
                                                    '<a confirma="O '.$nomedisplay_sing.' confirmou o saque?" title="Remover Quantia do Saldo do '.$nomedisplay_sing.'" class="btn lajax explicar-titulo" acao="" href="'.URL_PATH.'Financeiro/Admin/financeiro_retirar/'.$valor->id.$linkextra.'"><img border="0" src="'.WEB_URL.'img/icons/cifrao_16x16.png" alt="Retirar"></a>';
                    $funcoes_qnt = 3;
                }*/



                // Comentario de Usuario
                if(\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('usuario_Comentarios')){
                    if($funcoes_qnt>2){
                        $tabela['Funções'][$i]     .=   '<br>';
                        $funcoes_qnt = 0;
                    }
                    ++$funcoes_qnt;
                    $tabela['Funções'][$i]     .=   $Visual->Tema_Elementos_Btn('Personalizado'   ,Array('Histórico'    ,'usuario/Admin/Usuarios_Comentario/'.$valor->id.$linkextra    ,'','file','inverse'),$perm_comentario);
                }
                // Anexo de Usuario
                if(\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('usuario_Anexo')){
                    if($funcoes_qnt>2){
                        $tabela['Funções'][$i]     .=   '<br>';
                        $funcoes_qnt = 0;
                    }
                    ++$funcoes_qnt;
                    $tabela['Funções'][$i]     .=   $Visual->Tema_Elementos_Btn('Personalizado'   ,Array('Anexos'    ,'usuario/Anexo/Anexar/'.$valor->id.$linkextra    ,'','file','inverse'),$perm_anexo);
                }
                // Email para Usuario
                if(\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('usuario_Admin_Email')){
                    if($funcoes_qnt>2){
                        $tabela['Funções'][$i]     .=   '<br>';
                        $funcoes_qnt = 0;
                    }
                    ++$funcoes_qnt;
                    $tabela['Funções'][$i]     .=   $Visual->Tema_Elementos_Btn('Email'      ,Array('Enviar email para '.$nomedisplay_sing        ,'usuario/Admin/Usuarios_Email/'.$valor->id.$linkextra    ,''),$perm_email);
                }
                // Email para Setor
                if(\Framework\App\Sistema_Funcoes::Perm_Modulos('usuario_mensagem') && $usuario_mensagem_EmailSetor){
                    if($funcoes_qnt>2){
                        $tabela['Funções'][$i]     .=   '<br>';
                        $funcoes_qnt = 0;
                    }
                    ++$funcoes_qnt;
                    $tabela['Funções'][$i]     .=   $Visual->Tema_Elementos_Btn('Personalizado'   ,Array('Enviar email para Setor'    ,'usuario/Admin/Usuarios_Email/'.$valor->id.$linkextra.'/Setor/'    ,'','envelope','danger'),$perm_email);
                }
                // Verifica se Possue Status e Mostra
                if($usuario_Admin_Ativado_Listar!==false){
                    if($valor->ativado===1 || $valor->ativado==='1'){
                        $texto = $usuario_Admin_Ativado_Listar[1];
                        $valor->ativado='1';
                    }else{
                        $valor->ativado = '0';
                        $texto = $usuario_Admin_Ativado_Listar[0];
                    }
                    if($funcoes_qnt>2){
                        $tabela['Funções'][$i]     .=   '<br>';
                        $funcoes_qnt = 0;
                    }
                    ++$funcoes_qnt;
                    $tabela['Funções'][$i]     .=   '<span id="status'.$valor->id.'">'.$Visual->Tema_Elementos_Btn('Status'.$valor->ativado     ,Array($texto        ,'usuario/Admin/Status/'.$valor->id.'/'    ,''),$perm_status).'</span>';
                }
                if($funcoes_qnt>2){
                    $tabela['Funções'][$i]     .=   '<br>';
                    $funcoes_qnt = 0;
                }
                $funcoes_qnt = $funcoes_qnt+2;
                $tabela['Funções'][$i]         .=   $Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar '.$nomedisplay_sing        ,$url_editar.'/'.$valor->id.$linkextra.'/'    ,''),$perm_editar).
                                                    $Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar '.$nomedisplay_sing       ,$url_deletar.'/'.$valor->id.$linkextra     ,'Deseja realmente deletar esse '.$nomedisplay_sing.'?'),$perm_del);
                ++$i;
            }
            
            // SE tiver opcao de exportar, exporta e trava o sistema
            if($export!==false){
                self::Export_Todos($export,$tabela, $nomedisplay);
            }else{
                // Imprime a tabela
                $this->_Visual->Show_Tabela_DataTable(
                    $tabela,     // Array Com a Tabela
                    '',          // style extra
                    true,        // true -> Add ao Bloco, false => Retorna html
                    true,        // Apagar primeira coluna ?
                    Array(       // Ordenacao
                        Array(
                            0,'desc'
                        )
                    )
                );
            }
            unset($tabela);
        }else{          
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhum '.$nomedisplay_sing.'</font></b></center>');
        }
        if($ativado===false){
            $titulo = 'Todos os '.$nomedisplay.' ('.$i.')';
        }elseif($ativado==0){
            $titulo = 'Todos os '.$nomedisplay.' Desativados ('.$i.')';
        }else{
            $titulo = 'Todos os '.$nomedisplay.' Ativados ('.$i.')';
        }
        $this->_Visual->Bloco_Unico_CriaJanela($titulo,'',$gravidade);
        
        
        // Table's primary key
        $primaryKey = 'id';
        
        
        $perm_editar = $this->_Registro->_Acl->Get_Permissao_Url('Seguranca/Senha/Senhas_Edit');
        $perm_del = $this->_Registro->_Acl->Get_Permissao_Url('Seguranca/Senha/Senhas_Del');
        $perm_status = $this->_Registro->_Acl->Get_Permissao_Url('Seguranca/Senha/Status');
        $perm_destaque = $this->_Registro->_Acl->Get_Permissao_Url('Seguranca/Senha/Destaque');
        
        if($perm_editar && $perm_del){
            $funcao = function( $d, $row ) {
                return Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Senha'        ,'Seguranca/Senha/Senhas_Edit/'.$d.'/'    ,''),true).
                       Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Senha'       ,'Seguranca/Senha/Senhas_Del/'.$d.'/'     ,'Deseja realmente deletar essa Senha ?'),true);
            };
        }else if($perm_editar){
            $funcao = function( $d, $row ) {
                return Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Senha'        ,'Seguranca/Senha/Senhas_Edit/'.$d.'/'    ,''),true);
            };
        }else if($perm_del){
            $funcao = function( $d, $row ) {
                return Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Senha'       ,'Seguranca/Senha/Senhas_Del/'.$d.'/'     ,'Deseja realmente deletar essa Senha ?'),true);
            };
        }else{
            $funcao = function( $d, $row ) {
                return '';
            };
        }
        
        if($perm_status){
            $funcao_status = function( $d, $row ) {
                
                if($d=='0'){
                    $nometipo = 'Ultrapassada';
                }
                else{
                    $nometipo = 'Em Uso';
                }
                return $nometipo;
            };
        }else{
            $funcao_status = function( $d, $row ) {
                
                if($d=='0'){
                    $nometipo = 'Ultrapassada';
                }
                else{
                    $nometipo = 'Em Uso';
                }
                return $nometipo;
            };
        }
        if($perm_destaque){
            $funcao_destaque = function( $d, $row ) {
                
                if($d=='0'){
                    $nometipo = 'Não Destaque';
                }
                else{
                    $nometipo = 'Destaque';
                }
                return $nometipo;
            };
        }else{
            $funcao_destaque = function( $d, $row ) {
                
                if($d=='0'){
                    $nometipo = 'Não Destaque';
                }
                else{
                    $nometipo = 'Destaque';
                }
                return $nometipo;
            };
        }

        $columns = array(
            array( 'db' => 'id', 'dt' => 0,
                'formatter' => function( $d, $row ) {
                    return '#'.$d;
                }),
            array( 'db' => 'categoria2',    'dt' => 1 ),
            array( 'db' => 'url',           'dt' => 2 ),
            array( 'db' => 'login',         'dt' => 3 ),
            array( 'db' => 'senha',         'dt' => 4 ),
            array( 'db' => 'destaque'    ,  'dt' => 5 ,
                'formatter' => $funcao_destaque),
            array( 'db' => 'status'      ,  'dt' => 6 ,
                'formatter' => $funcao_status,
                'search' => function( $search ) {
                    if(strpos(strtolower($url), strtolower($objeto->end))!=false){
                        
                    }
                    return '#'.$d;
                }),
            array( 'db' => 'log_date_add',  'dt' => 7 ),
            array( 'db' => 'id',            'dt' => 8,
                'formatter' => $funcao)
            /*array(
                'db'        => 'start_date',
                'dt'        => 4,
                'formatter' => function( $d, $row ) {
                    return date( 'jS M y', strtotime($d));
                }
            ),
            array(
                'db'        => 'salary',
                'dt'        => 5,
                'formatter' => function( $d, $row ) {
                    return '$'.number_format($d);
                }
            )*/
        );

        echo json_encode(
            \Framework\Classes\Datatable::complex( $_GET, Framework\App\Registro::getInstacia()->_Conexao, 'Seguranca_Senha', $primaryKey, $columns, null,'status=1' )
        );
    }
}
?>
