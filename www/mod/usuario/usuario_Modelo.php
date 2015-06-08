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
    public function usuarios_inserir($tipo = 'cliente'){
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
                $planostatus['status'] = __('Pago');
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
    
    
    
    
    
    
    /****
     * Funcoes mais Perfomaticas - 2015
     */
    
    /**
     * Listragem de Usuarios
     * @param type $grupo
     * @param type $ativado
     * @param type $gravidade
     * @param type $inverter
     * @param type $export
     * @throws \Exception
     */
    protected function Usuario_Listagem($grupo=false,$ativado=false,$gravidade=0,$inverter=false){
        $url_ver = 'usuario/Perfil/Perfil_Show';
        $url_editar='usuario/Admin/Usuarios_Edit';
        $url_deletar='usuario/Admin/Usuarios_Del';
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
            $nomedisplay        = __('Usuários ');
            $nomedisplay_sing   = __('Usuário ');
            $nomedisplay_tipo   = __('Usuario');
        }else{
            $categoria = (int) $grupo[0];
            
            // Pega GRUPOS VALIDOS
            //#update - Comer essa Query, nao há necessidade
            $sql_grupos = $this->db->Sql_Select('Sistema_Grupo','categoria='.$categoria,0,'','id');
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
        
        // Table's primary key
        $primaryKey = 'id';
        $tabela = 'Usuario';
        
        // Permissoes (Fora Do LOOPING por performace)
        $usuario_Admin_Ativado_Listar   = \Framework\App\Acl::Sistema_Modulos_Configs_Funcional('usuario_Admin_Ativado_Listar');
        $usuario_Admin_Foto             = \Framework\App\Acl::Sistema_Modulos_Configs_Funcional('usuario_Admin_Foto');
        $Financeiro_User_Saldo          = \Framework\App\Acl::Sistema_Modulos_Configs_Funcional('Financeiro_User_Saldo');
        $usuario_mensagem_EmailSetor    = \Framework\App\Acl::Sistema_Modulos_Configs_Funcional('usuario_mensagem_EmailSetor');
        $usuario_Admin_Grupo            = \Framework\App\Acl::Sistema_Modulos_Configs_Funcional('usuario_Grupo_Mostrar');

        // Get Permissoes (Fora Do LOOPING por performace)
        $perm_view          = $this->_Registro->_Acl->Get_Permissao_Url($url_ver);
        $perm_comentario    = $this->_Registro->_Acl->Get_Permissao_Url('usuario/Admin/Usuarios_Comentario');
        $perm_anexo         = $this->_Registro->_Acl->Get_Permissao_Url('usuario/Anexo/Anexar');
        $perm_email         = $this->_Registro->_Acl->Get_Permissao_Url('usuario/Admin/Usuarios_Email');
        $perm_status        = $this->_Registro->_Acl->Get_Permissao_Url('usuario/Admin/Status');
        $perm_editar        = $this->_Registro->_Acl->Get_Permissao_Url($url_editar);
        $perm_del           = $this->_Registro->_Acl->Get_Permissao_Url($url_deletar);

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
        
        $columns = Array();
        $numero = -1;
        
        
        
        
        
        
        
        
        
        //// ORIGINAL
        
        ++$numero;
        $columns[] = array( 'db' => 'id', 'dt' => $numero); //'Id';
        
        

        if($Ativado_Grupo===true){
            ++$numero;
            $columns[] = array( 'db' => 'grupo2', 'dt' => $numero); //'Grupo';
        }
        if($Ativado_Foto===true){
            ++$numero;
            $columns[] = array( 'db' => 'foto', 'dt' => $numero,
                'formatter' => function($d,$row){
                    if($d==='' || $d===false){
                        $foto = WEB_URL.'img'.US.'icons'.US.'clientes.png';
                    }else{
                        $foto = $d;
                    }
                    return '<img src="'.$foto.'" style="max-width:100px;" />';
                }
            ); //'Foto';
        }
        
        
        //NOME #UPDATE
        ++$numero;
        $columns[] = array( 'db' => 'nome', 'dt' => $numero); //'Nome';
        // Atualiza Nome
        /*if($valor->nome!=''){
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
         * 
         */
        
        // TELEFONE #UPDATE
        ++$numero;
        $columns[] = array( 'db' => 'telefone', 'dt' => $numero); //'Telefone';
        /*$telefone = '';
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
        $tabela['Contato'][$i]         = $telefone;*/
        
        // EMAIL #UPDATE
        
        ++$numero;
        $columns[] = array( 'db' => 'email', 'dt' => $numero); //'Email';
        /*
        $email = '';
        if($valor->email!=''){
            $email .= $valor->email;
        }
        if($valor->email2!=''){
            if($email!='') $email .= '<br>';
            $email .= $valor->email2;
        }
        $tabela['Email'][$i]      =  $email;*/
        
        
        
        // para MOdulos que contem banco
        if(\Framework\App\Sistema_Funcoes::Perm_Modulos('Financeiro') && $Financeiro_User_Saldo){
            ++$numero;
            $columns[] = array( 'db' => 'id', 'dt' => $numero,
                'formatter' => function($d,$row){
                    return Financeiro_Modelo::Carregar_Saldo(Framework\App\Registro::getInstacia()->_Modelo, $d, true);
                }
            ); //'Saldo';
        }
        
        
        
        // Data de Cadastro
        ++$numero;
        $columns[] = array( 'db' => 'log_date_add', 'dt' => $numero,
            'formatter' => function($d,$row){
                if(strpos($d, APP_DATA_BR)!==false){
                    return '<b>'.$d.'</b>';
                }else{
                    return $d;
                }
            }
        ); //'Data de Cadastro';

        
        
        
        
        // Funcoes
        $function = '';
        $funcoes_qnt = 0;
        
        // Visualizar
        if($perm_view){
            ++$funcoes_qnt;
            $function .= ' $html .= Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn(\'Visualizar\'     ,Array(\'Visualizar '.$nomedisplay_sing.'\'        ,\''.$url_ver.'/\'.$row[\'id\'].\''.$linkextra.'/\'    ,\'\'),true);';
        }
        
        // Comentario de Usuario
        if(\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('usuario_Comentarios') && $perm_comentario){
            if($funcoes_qnt>2){
                $tabela['Funções'][$i]     .=   '<br>';
                $funcoes_qnt = 0;
            }
            ++$funcoes_qnt;
            $function .= ' $html .= Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn(\'Personalizado\'     ,Array(\'Histórico\'        ,\'usuario/Admin/Usuarios_Comentario/\'.$row[\'id\'].\''.$linkextra.'/\'    ,\'\',\'file\',\'inverse\'),true);';
        }
        // Anexo de Usuario
        if(\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('usuario_Anexo') && $perm_anexo){
            if($funcoes_qnt>2){
                $tabela['Funções'][$i]     .=   '<br>';
                $funcoes_qnt = 0;
            }
            ++$funcoes_qnt;
            $function .= ' $html .= Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn(\'Personalizado\'     ,Array(\'Anexos\'        ,\'usuario/Anexo/Anexar/\'.$row[\'id\'].\''.$linkextra.'/\'    ,\'\',\'file\',\'inverse\'),true);';
        }
        // Email para Usuario
        if(\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('usuario_Admin_Email') && $perm_email){
            if($funcoes_qnt>2){
                $function .= ' $html .= \'<br>\';';
                $funcoes_qnt = 0;
            }
            ++$funcoes_qnt;
            $function .= ' $html .= Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn(\'Email\'     ,Array(\'Enviar email para '.$nomedisplay_sing.'\'        ,\'usuario/Admin/Usuarios_Email/\'.$row[\'id\'].\''.$linkextra.'/\'    ,\'\'),true);';
        }
        // Email para Setor
        if(\Framework\App\Sistema_Funcoes::Perm_Modulos('usuario_mensagem') && $usuario_mensagem_EmailSetor && $perm_email){
            if($funcoes_qnt>2){
                $function .= ' $html .= \'<br>\';';
                $funcoes_qnt = 0;
            }
            ++$funcoes_qnt;
            $function .= ' $html .= Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn(\'Email\'     ,Array(\'Enviar email para Setor\'        ,\'usuario/Admin/Usuarios_Email/\'.$row[\'id\'].\''.$linkextra.'/Setor/\'    ,\'\',\'envelope\',\'danger\'),true);';
        }
        // Verifica se Possue Status e Mostra
        if($usuario_Admin_Ativado_Listar!==false && $perm_status){
            if($funcoes_qnt>2){
                $function .= ' $html .= \'<br>\';';
                $funcoes_qnt = 0;
            }
            ++$funcoes_qnt;
            $function .= 'if($d===1 || $d===\'1\'){';
                $function .= '$texto = \''.$usuario_Admin_Ativado_Listar[1].'\';';
                $function .= '$ativado=\'1\';';
            $function .= ' }else{';
                $function .= ' $ativado = \'0\';';
                $function .= ' $texto = \''.$usuario_Admin_Ativado_Listar[0].'\';';
            $function .= ' }';
            $function .= ' $html .= \'<span id="status\'.$row[\'id\'].\'">\'.Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn(\'Status\'.$ativado     ,Array($texto        ,\'usuario/Admin/Status/\'.$row[\'id\'].\'/\'    ,\'\'),true).\'</span>\';';

        }
        if($funcoes_qnt>2){
            $function .= ' $html .= \'<br>\';';
            $funcoes_qnt = 0;
        }
        
        // Editar e Deletar
        $funcoes_qnt = $funcoes_qnt+2;
        if($perm_editar){
            $function .= ' $html .= Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn(\'Editar\'     ,Array(\'Editar '.$nomedisplay_sing.'\'        ,\''.$url_editar.'/\'.$row[\'id\'].\''.$linkextra.'/\'    ,\'\'),true);';
        }
        if($perm_del){
            $function .= ' $html .= Framework\App\Registro::getInstacia()->_Visual->Tema_Elementos_Btn(\'Deletar\'    ,Array(\'Deletar '.$nomedisplay_sing.'\'       ,\''.$url_deletar.'/\'.$row[\'id\'].\''.$linkextra.'/\'     ,\'Deseja realmente deletar essa '.$nomedisplay_sing.'?\'),true);';
        }

        ++$numero;
        eval('$function = function( $d, $row ) { $html = \'\'; '.$function.' return $html; };');       
        $columns[] = array( 'db' => 'ativado',            'dt' => $numero,
            'formatter' => $function
        ); //'Funções';
                
        echo json_encode(
            \Framework\Classes\Datatable::complex( $_GET, Framework\App\Registro::getInstacia()->_Conexao, $tabela, $primaryKey, $columns, null,$where)
        );
    }
}
?>
