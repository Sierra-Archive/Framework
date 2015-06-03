<?php
class usuario_Controle extends \Framework\App\Controle
{
    /**
    * Construtor
    * 
    * @name __construct
    * @access public
    *
    * @uses \Framework\App\Visual::$usuario
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 2.0
    */
    public function __construct(){
        // construct
        parent::__construct();
    }
    
    static function Usuarios_Tabela(&$usuarios,$nomedisplay_sing,$linkextra, $grupo=false, $url_ver='usuario/Perfil/Perfil_Show', $url_editar='usuario/Admin/Usuarios_Edit', $url_deletar='usuario/Admin/Usuarios_Del'){
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
        return Array($tabela,$i);
    }
    /**
    * usuariolistar
     * 
     * Esta sendo Substituida pela Usuario_Listagem
    * 
    * @name usuariolistar
    * @access protected
     * @param type $grupo 
     * @param type $ativado 
     * @param type $gravidade 
     * @param type $inverter 
     * @param type $export 
     * @return type
    * 
    * @uses usuario_ListarModelo::$retorna_usuarios
    * @uses \Framework\App\Visual::$Show_Tabela_DataTable
    * @uses \Framework\App\Visual::$Bloco_Maior_CriaTitulo
    * @uses \Framework\App\Visual::$bloco_maior_criaconteudo
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 2.0
     */
    protected function usuariolistar($grupo=false,$ativado=false,$gravidade=0,$inverter=false,$export=false){
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
            list($tabela,$i) = self::Usuarios_Tabela($usuario,$nomedisplay_sing,$linkextra,$grupo,'usuario/Perfil/Perfil_Show', $link_editar, $link_deletar);
            
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
    }
   /**
    * Description
    * @return type
    */
    public function Show_ConhecaOsPlanos(){
        // Cria Tabela
        $tabela = new \Framework\Classes\Tabela();
        $tabela->addcabecario(array(' ',CONFIG_CLI_1_NOME,CONFIG_CLI_2_NOME,CONFIG_CLI_3_NOME,CONFIG_CLI_4_NOME/*,CONFIG_CLI_5_NOME*/));   
        $tabela->addcorpo(array(
            array("nome" => 'Preço', "class" => 'tbold tleft'),
            array("nome" => 'R$'.number_format(CONFIG_CLI_1_PRECO, 2, ',', '.')),
            array("nome" => 'R$'.number_format(CONFIG_CLI_2_PRECO, 2, ',', '.')),
            array("nome" => 'R$'.number_format(CONFIG_CLI_3_PRECO, 2, ',', '.')),
            array("nome" => 'R$'.number_format(CONFIG_CLI_4_PRECO, 2, ',', '.'))/*,
            array("nome" => 'R$'.number_format(CONFIG_CLI_5_PRECO, 2, ',', '.'))*/
        ));
        $tabela->addcorpo(array(
            array("nome" => 'Porcentagem Sobre Primários', "class" => 'tbold tleft'),
            array("nome" => CONFIG_CLI_1_PORC1.'%'),
            array("nome" => CONFIG_CLI_2_PORC1.'%'),
            array("nome" => CONFIG_CLI_3_PORC1.'%'),
            array("nome" => CONFIG_CLI_4_PORC1.'%')/*,
            array("nome" => CONFIG_CLI_5_PORC1.'%')*/
        ));
        $tabela->addcorpo(array(
            array("nome" => 'Porcentagem Sobre Secundários', "class" => 'tbold tleft'),
            array("nome" => CONFIG_CLI_1_PORC2.'%'),
            array("nome" => CONFIG_CLI_2_PORC2.'%'),
            array("nome" => CONFIG_CLI_3_PORC2.'%'),
            array("nome" => CONFIG_CLI_4_PORC2.'%')/*,
            array("nome" => CONFIG_CLI_5_PORC2.'%')*/
        ));
        $tabela->addcorpo(array(
            array("nome" => 'Porcentagem Sobre Terciários', "class" => 'tbold tleft'),
            array("nome" => CONFIG_CLI_1_PORC3.'%'),
            array("nome" => CONFIG_CLI_2_PORC3.'%'),
            array("nome" => CONFIG_CLI_3_PORC3.'%'),
            array("nome" => CONFIG_CLI_4_PORC3.'%')/*,
            array("nome" => CONFIG_CLI_5_PORC3.'%')*/
        ));
        return $tabela->retornatabela();
    }
    static function Usuarios_Email_Ver($id = 0,$tipo=false, $tema='Cliente'){
        $registro   = \Framework\App\Registro::getInstacia();
        $Controle   = $registro->_Controle;
        $Acl   = $registro->_Acl;
        $Modelo     = $registro->_Modelo;
        $Visual     = $registro->_Visual;
        $id = (int) $id;
        $i = 0;
        // Puxa Usuario
        if($id==0 || !isset($id)){
            $id = (int) $Acl->Usuario_GetID();
        }else{
            $id = (int) $id;
        }
        $usuario = $Modelo->db->Sql_Select('Usuario', Array('id'=>$id));
        if($usuario===false)            throw new \Exception('Usuario não Existe',404);
        // Pre
        $linkextra = '';
        
        // Pega Tipo
        if($tipo===false){
            if($usuario->grupo==CFG_TEC_CAT_ID_CLIENTES){
                $tipo   = 'Cliente';
                $tipo2  = 'cliente';
            }else if($usuario->grupo==CFG_TEC_CAT_ID_FUNCIONARIOS){
                $tipo   = 'Funcionário';
                $tipo2  = 'funcionario';
            }else{
                $tipo   = 'Usuário';
                $tipo2  = 'usuario';
            }
        }
        // GAmbiarra Para Consertar erro de acento em url
        if($tipo=='Funcionrio' || $tipo=="Funcionario") $tipo = "Funcionário";
        if($tipo=="Usurio" || $tipo=="Usuario")         $tipo = 'Usuário';
        // Cria Tipo 2:
        if($tipo=='Cliente' || $tipo=='cliente'){
            $tipo2  = 'cliente';
        }else if($tipo=='Funcionário' || $tipo=='funcionário' || $tipo=='Funcionario' || $tipo=='funcionario'){
            $tipo2  = 'funcionario';
        }
        if($tipo2=='usuario'){
            $nomedisplay        = 'Usuários ';
            $nomedisplay_sing   = 'Usuário ';
            $nomedisplay_tipo   = 'Usuario';
        }else if($tipo2=='funcionario'){
            $nome = \Framework\App\Acl::Sistema_Modulos_Configs_Funcional('usuario_Funcionario_nome');
            $nomedisplay        = $nome.' ';
            $nomedisplay_sing   = Framework\Classes\Texto::Transformar_Plural_Singular($nome);
            $nomedisplay_tipo   = Framework\Classes\Texto::Transformar_Plural_Singular($nome);
            $linkextra = '/funcionario';
        }else{
            $linkextra = '/cliente';
            $nome = \Framework\App\Acl::Sistema_Modulos_Configs_Funcional('usuario_Cliente_nome');
            $nomedisplay        = $nome.' ';
            $nomedisplay_sing   = Framework\Classes\Texto::Transformar_Plural_Singular($nome);
            $nomedisplay_tipo   = Framework\Classes\Texto::Transformar_Plural_Singular($nome);
        }
        // Enviar Email
        //$Visual->Blocar('<a title="Enviar email para '.$nomedisplay_sing.'" class="btn btn-success lajax explicar-titulo" acao="" href="'.URL_PATH.'usuario/Admin/Usuarios_Email/'.$id.$linkextra.'">Enviar email para '.$nomedisplay_sing.'</a><div class="space15"></div>');
        $emails = $Modelo->db->Sql_Select('Usuario_Historico_Email',Array('cliente'=>$id));
        if($emails!==false && !empty($emails)){
            if(is_object($emails)) $emails = Array(0=>$emails);
            reset($emails);
            foreach ($emails as $indice=>&$valor) {
                $tabela['Cliente'][$i]              = $valor->nome_usuario;
                $email = '';
                
                if($tema!='Setor'){
                    if($valor->email_usuario2!=''){
                        if($email!=''){
                            $email .= '<br>';
                        }
                        $email .= $valor->email_usuario2;
                    }
                    if($valor->email_usuario!=''){
                        if($email!=''){
                            $email .= '<br>';
                        }
                        $email .= $valor->email_usuario;
                    }
                    $tabela['Email Cliente'][$i]        = $email;
                }
                $tabela['Titulo da Mensagem'][$i]   = $valor->titulo;
                $tabela['Mensagem'][$i]             = $valor->mensagem;
                ++$i;
            }
            $Visual->Show_Tabela_DataTable($tabela);
            unset($tabela);
        }else{
            if($tema=='Setor'){
                $Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhum Email enviado para o Setor</font></b></center>');            
            }else{
                $Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhum Email enviado para o Usuário</font></b></center>');            
            }
        }
        if($tema=='Setor'){
            $titulo = 'Histórico de Envio de Email para Setor ('.$i.')';
        }else{
            $titulo = 'Histórico de Envio de Email para Cliente ('.$i.')';
        }
        $Visual->Bloco_Unico_CriaJanela($titulo);
        
        //Carrega Json
        $Visual->Json_Info_Update('Titulo','Histórico de Email');
    }
    public function Usuarios_Email($id = 0,$tipo=false,$tema='Cliente'){
        if($id==0 || !isset($id)){
            $id = (int) $this->_Acl->Usuario_GetID();
        }else{
            $id = (int) $id;
        }
        if($tipo===false){
            if($usuario->grupo==CFG_TEC_IDCLIENTE){
                $tipo   = 'Cliente';
                $tipo2  = 'cliente';
            }else if($usuario->grupo==CFG_TEC_IDFUNCIONARIO){
                $tipo   = 'Funcionário';
                $tipo2  = 'funcionario';
            }
        }
        // GAmbiarra Para Consertar erro de acento em url
        if($tipo=='Funcionrio' || $tipo=="Funcionario") $tipo = "Funcionário";
        if($tipo=="Usurio" || $tipo=="Usuario")         $tipo = 'Usuário';
        // Cria Tipo 2:
        if($tipo=='Cliente' || $tipo=='cliente'){
            $tipo2  = 'cliente';
            $this->Tema_Endereco('Clientes','usuario/Admin/ListarCliente');
        }else if($tipo=='Funcionário' || $tipo=='Funcionario' || $tipo=='funcionário' || $tipo=='funcionario'){
            $tipo2  = 'funcionario';
            $this->Tema_Endereco('Funcionários','usuario/Admin/ListarFuncionario');
        }else{
            $this->Tema_Endereco('Usuários','usuario/Admin/Main');
        }
        if($tema=='Setor'){
            $this->Tema_Endereco('Enviar Email para Setor');
        }else{
            $this->Tema_Endereco('Enviar Email');
        }
        // Retira os de clientes
        $linkextra = '';
        if($tipo!==false){
            $linkextra = $tipo.'/';
        }
        // Carrega formulario
        $form = new \Framework\Classes\Form('form_Sistema_Admin_Usuarios','usuario/Admin/Usuarios_Email2/'.$id.'/'.$linkextra,'formajax');
        $form->Input_Novo(
            'Titulo da Mensagem',
            'titulo',
            '',
            'text', 
             250,
            'obrigatorio',
            '',
            false,
            ''
        ); 
        if($tema=='Setor'){
            $form->Input_Novo(
                'Nome Opcional',
                'nome_opcional',
                '',
                'text', 
                250,
                '',
                '',
                false,
                ''
            ); 
            $form->Input_Novo(
                'Email Opcional',
                'email_opcional',
                '',
                'text', 
                50,
                '',
                '',
                false,
                ''
            ); 
        }else{
            $form->Input_Novo(
                'Nome do Email Setor',
                'nome_opcional',
                '',
                'text', 
                50,
                '',
                '',
                false,
                ''
            ); 
            $form->Input_Novo(
                'Email Setor',
                'email_opcional',
                '',
                'text', 
                50,
                '',
                '',
                false,
                ''
            ); 
        }
        $form->TextArea_Novo(
            'Mensagem',
            'mensagem',
            'mensagem',
            '',
            'editor',
            false,
            'obrigatorio',
            ''
        ); 
        if($tema!='Setor'){
            $formulario = $form->retorna_form('Enviar Email para Usuário');
            $this->_Visual->Blocar($formulario);
            $this->_Visual->Bloco_Unico_CriaJanela(__('Enviar Email para Usuário'),'',10);
        }else{
            $formulario = $form->retorna_form('Enviar Email para o Setor');
            $this->_Visual->Blocar($formulario);
            $this->_Visual->Bloco_Unico_CriaJanela(__('Enviar Email para o Setor'),'',10);
        }
        // Usuario ver emails
        usuario_Controle::Usuarios_Email_Ver($id, $tipo2,$tema);
        // Titulo
        $this->_Visual->Json_Info_Update('Titulo','Enviar Email para Usuário');
    }
    public function Usuarios_Email2($id = 0,$tipo=false, $tema='Cliente'){
        if($id==0 || !isset($id)){
            $id = (int) $this->_Acl->Usuario_GetID();
        }else{
            $id = (int) $id;
        }
        // Envia Email
        $mailer = new \Framework\Classes\Email();
        $usuario = $this->_Modelo->db->Sql_Select('Usuario',Array('id'=>$id),1);
        $nome = $usuario->nome;
        // Add Email normal e alternativo para enviar 
        $enviar = '';
        if($tema=='Cliente'){
            if($usuario->email!='' && \Framework\App\Sistema_Funcoes::Control_Layoult_Valida_Email($usuario->email)){
                $enviar .= '->setTo(\''.$usuario->email.'\', \''.$nome.'\')';
            }
            if($usuario->email2!='' && \Framework\App\Sistema_Funcoes::Control_Layoult_Valida_Email($usuario->email2)){
                $enviar .= '->setTo(\''.$usuario->email2.'\', \''.$nome.'\')';
            }
        }
        // Envia Se tiver Email Opcional
        $email_opcional = \anti_injection($_POST['email_opcional']);
        $nome_opcional  = \anti_injection($_POST['nome_opcional']);
        if($email_opcional!='' && \Framework\App\Sistema_Funcoes::Control_Layoult_Valida_Email($email_opcional)){
            $enviar .= '->setTo(\''.$email_opcional.'\', \''.$nome_opcional.'\')';
        }
        if($enviar==''){
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => 'Erro',
                "mgs_secundaria" => 'Nenhum Email válido para enviar !'
            );
            $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens); 
            $this->_Visual->Json_Info_Update('Historico', false);
            $this->Json_Definir_zerar(false);
        }else{
            $amensagem = '<strong><b>Mensagem:</b> '.  \anti_injection($_POST['mensagem']).'</strong><br><strong>'.usuario_PerfilVisual::Show_HTML($usuario,$tipo).'</strong>';
            // Enviar Email 
            eval('$send	= $mailer'.$enviar.'->setSubject(\''.\anti_injection($_POST['titulo']).' - '.SISTEMA_NOME.'\')'.
            '->setFrom(SISTEMA_EMAIL, SISTEMA_NOME)'.
            '->addGenericHeader(\'X-Mailer\', \'PHP/\' . phpversion())'.
            '->addGenericHeader(\'Content-Type\', \'text/html; charset="utf-8"\')'.
            '->setMessage(\''.$amensagem.'\')'.
            '->setWrap(78)->send();');
            if($send){
                $registro = new \Usuario_Historico_Email_DAO();
                $registro->cliente          = $id;
                $registro->titulo           = \anti_injection($_POST['titulo']);
                $registro->email_opcional   = $email_opcional;
                $registro->nome_opcional    = $nome_opcional;
                $registro->mensagem         = \anti_injection($_POST['mensagem']);
                $registro->email_usuario    = $usuario->email;
                $registro->email_usuario2   = $usuario->email2;
                $registro->nome_usuario     = $nome;
                $this->_Modelo->db->Sql_Inserir($registro);
                $mensagens = array(
                    "tipo" => 'sucesso',
                    "mgs_principal" => 'Email enviado com Sucesso',
                    "mgs_secundaria" => 'Voce enviou com sucesso.'
                );
                $this->_Visual->Json_Info_Update('Titulo','Enviado com Sucesso.');
            }else{
                $mensagens = array(
                    "tipo" => 'erro',
                    "mgs_principal" => 'Erro',
                    "mgs_secundaria" => 'Email não foi enviado !'
                );
            }
            // Recarrega Main
            /*if($tipo=='cliente'){
                $this->ListarCliente();
            }else if($tipo=='funcionario'){
                $this->ListarFuncionario();
            }else{
                $this->Main();
            }*/
            $this->Usuarios_Email($id,$tipo,$tema);
            $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens); 
            $this->_Visual->Json_Info_Update('Historico', false);
        }
    }
    static function PlanoStatus(&$modelo, &$Visual, $usuario){
        $valores = usuario_Modelo::PlanoStatus($modelo, $usuario);
        $Visual->Blocar(usuario_Visual::Show_TabStatusPlano($valores));   
        $Visual->Bloco_Menor_CriaConteudo(60);
    }
    
    static function Static_usuariolistar($grupo=false,$ativado=false,$inverter=false, $export=false){
        
        
        $registro   = &\Framework\App\Registro::getInstacia();
        $Controle   = $registro->_Controle;
        $Modelo     = $registro->_Modelo;
        $Visual     = $registro->_Visual;
        $i          = 0;
        
        
        
        
        
        
        
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
            $Controle->Tema_Endereco('Usuários');
        }else{
            $categoria = (int) $grupo[0];
            
            // Pega GRUPOS VALIDOS
            $sql_grupos = $Modelo->db->Sql_Select('Sistema_Grupo',Array('categoria'=>$categoria));
            $grupos_id = Array();
            if(is_object($sql_grupos)) $sql_grupos = Array(0=>$sql_grupos);
            if($sql_grupos!==false && !empty($sql_grupos)){
                foreach ($sql_grupos as &$valor) {
                    $grupos_id[] = $valor->id;
                }
            }
            
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
            $Controle->Tema_Endereco($grupo[1]);
        }
        
        $linkextra = '';
        if($grupo!==false && $grupo[0]==CFG_TEC_CAT_ID_CLIENTES && $inverter===false){
            $linkextra = '/cliente';
            $link = 'usuario/Admin/ListarCliente';
            $link_ver = 'comercio_certificado/Proposta/Usuarios_Produtos';    
            $link_editar = 'comercio_certificado/Proposta/Usuarios_Mostrar';
            $link_deletar = 'comercio_certificado/Proposta/Usuarios_Del';
            $link_add = 'comercio_certificado/Proposta/Usuarios_Mostrar';
        }
        else if($grupo!==false && $grupo[0]==CFG_TEC_CAT_ID_FUNCIONARIOS && $inverter===false){
            $linkextra = '/funcionario';
            $link = 'usuario/Admin/ListarFuncionario';
            $link_ver = 'comercio_certificado/Proposta/Usuarios_Produtos';    
            $link_editar = 'comercio_certificado/Proposta/Usuarios_Mostrar';
            $link_deletar = 'comercio_certificado/Proposta/Usuarios_Del';
            $link_add = 'comercio_certificado/Proposta/Usuarios_Mostrar';
        }else{
            $link = 'usuario/Admin/Main';
            $link_editar = 'comercio_certificado/Proposta/Usuarios_Mostrar';
            $link_ver = 'comercio_certificado/Proposta/Usuarios_Produtos';    
            $link_deletar = 'comercio_certificado/Proposta/Usuarios_Del';
            $link_add = 'comercio_certificado/Proposta/Usuarios_Mostrar';
        }
        
        // add botao
        $html = $Visual->Tema_Elementos_Btn('Superior'     ,Array(
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
        ));
        // Continua Resto
        //$this->_Visual->Blocar('<a title="Adicionar " class="btn btn-success lajax explicar-titulo" acao="" href="'.URL_PATH.'usuario/Admin/Usuarios_Add'.$linkextra.'">Adicionar novo '.Framework\Classes\Texto::Transformar_Plural_Singular($nomedisplay).'</a><div class="space15"></div>');
        $usuario = $Modelo->db->Sql_Select('Usuario',$where,0,'','id,grupo,foto,nome,razao_social,email,email2,telefone,telefone2,celular,celular1,celular2,celular3,ativado,log_date_add');
        if(is_object($usuario)) $usuario = Array(0=>$usuario);
        if($usuario!==false && !empty($usuario)){
            list($tabela,$i) = self::Usuarios_Tabela($usuario,$nomedisplay_sing,$linkextra, $grupo,$link_ver, $link_editar, $link_deletar);
            if($export!==false){
                self::Export_Todos($export,$tabela, $nomedisplay);
            }else{
                $html .= $Visual->Show_Tabela_DataTable(
                    $tabela,     // Array Com a Tabela
                    '',          // style extra
                    false,        // true -> Add ao Bloco, false => Retorna html
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
            $html = '<center><b><font color="#FF0000" size="5">Nenhum '.$nomedisplay_sing.'</font></b></center>';            
        }
        return $html;
    }
    /**
     * 
     * @param type $tipo
     * @param type $campos
     * @param type $form
     */
    public static function Campos_Deletar_Juridica($tipo, &$campos,&$usuario = false){
            // Retira JURIFICA / CNPJ
            self::DAO_Campos_Retira($campos, 'fisica');
            self::DAO_Campos_RetiraAlternados($campos);
            self::DAO_Campos_Retira($campos, 'nome_contato');
            self::DAO_Campos_Retira($campos, 'cnpj');
            self::DAO_Campos_Retira($campos, 'cnpj_insc');
            self::DAO_Campos_Retira($campos, 'nomefantasia');
            self::DAO_Campos_Retira($campos, 'razao_social');
    }
    /**
     * 
     * @param type $tipo
     * @param type $campos
     * @param type $form
     */
    public static function Campos_Deletar_Fisica($tipo, &$campos,&$usuario = false){
            // Retira Fisica / CPF
            self::DAO_Campos_Retira($campos, 'fisica');
            self::DAO_Campos_RetiraAlternados($campos);
            self::DAO_Campos_Retira($campos, 'nome');
            self::DAO_Campos_Retira($campos, 'cpf');
            self::DAO_Campos_Retira($campos, 'rg');
            self::DAO_Campos_Retira($campos, 'orgao');
            self::DAO_Campos_Retira($campos, 'perfil_nascimento');
            self::DAO_Campos_Retira($campos, 'perfil_sexo');
    }
    /**
     * 
     * @param type $tipo
     * @param type $campos
     * @param type $form
     */
    public static function Campos_Deletar_Localizacao($tipo, &$campos,&$usuario = false){
            // Retira Fisica / CPF
            self::DAO_Campos_Retira($campos, 'cep');
            self::DAO_Campos_Retira($campos, 'endereco');
            self::DAO_Campos_Retira($campos, 'pais');
            self::DAO_Campos_Retira($campos, 'estado');
            self::DAO_Campos_Retira($campos, 'cidade');
            self::DAO_Campos_Retira($campos, 'bairro');
            self::DAO_Campos_Retira($campos, 'numero');
            self::DAO_Campos_Retira($campos, 'complemento');
    }
    /**
     * 
     * @param type $tipo
     * @param type $campos
     * @param type $form
     */
    public static function Campos_Deletar($tipo = false, &$campos,&$usuario = false){
        // Captura Instancias e 
        $registro = &\Framework\App\Registro::getInstacia();
        $_Modelo  = &$registro->_Modelo;
        
        if($usuario!==false && isset($usuario->grupo)){
            $sql_grupo = $_Modelo->db->Sql_Select('Sistema_Grupo',Array('id'=>$usuario->grupo),1);
            $sql_grupo = $sql_grupo->categoria;
        }else{
            $sql_grupo = $tipo;
        }
            
            
        if(CFG_TEC_PAISES_EXTRAGEIROS===false){
            self::DAO_RemoveLinkExtra($campos, Array('pais','estado','cidade','bairro'));
        }
        // LOGIN
        $usuario_Admin_Login = \Framework\App\Acl::Sistema_Modulos_Configs_Funcional('usuario_Login');
        if(is_array($usuario_Admin_Login)){
            // SE categoria nao existir
            if(!($sql_grupo===false || in_array($sql_grupo, $usuario_Admin_Login))){
                self::DAO_Campos_Retira($campos, 'login');
                self::DAO_Campos_Retira($campos, 'senha');
            }
        }else{
            if($usuario_Admin_Login===false){
                self::DAO_Campos_Retira($campos, 'login');
                self::DAO_Campos_Retira($campos, 'senha');
            }
        }
        
        // GRUPO
        $usuario_Admin_Grupo = \Framework\App\Acl::Sistema_Modulos_Configs_Funcional('usuario_Grupo_Mostrar');
        if(is_array($usuario_Admin_Grupo)){
            // SE categoria nao existir
            if(!($sql_grupo===false || in_array($sql_grupo, $usuario_Admin_Grupo))){
                self::DAO_Campos_Retira($campos, 'grupo');
            }
        }else{
            if($usuario_Admin_Grupo===false){
                self::DAO_Campos_Retira($campos, 'grupo');
            }
        }
        
        // FOTO
        $usuario_Admin_Foto = \Framework\App\Acl::Sistema_Modulos_Configs_Funcional('usuario_Admin_Foto');
        if(is_array($usuario_Admin_Foto)){
            // SE categoria nao existir
            if(!($sql_grupo===false || in_array($sql_grupo, $usuario_Admin_Foto))){
                self::DAO_Campos_Retira($campos, 'foto');
            }
        }else{
            if($usuario_Admin_Foto===false){
                self::DAO_Campos_Retira($campos, 'foto');
            }
        }
        
        // CONTINUA
        if(!\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('usuario_Admin_Ativado')){
            self::DAO_Campos_Retira($campos, 'ativado');
        }
        if(!\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('usuario_Admin_Site')){
            self::DAO_Campos_Retira($campos, 'site');
        }
        // Tira resto 
        self::DAO_Campos_Retira($campos, 'Permissões do Usuário');
        self::DAO_Campos_Retira($campos, 'perfil_sexo');
        // Retira se nao for Engenharia
        if(!(\Framework\App\Sistema_Funcoes::Perm_Modulos('Engenharia')) || $tipo!='cliente'){
            self::DAO_Campos_Retira($campos, 'eng_clienteinvestidor');
            //self::DAO_Campos_Retira($campos, 'empreendimento');
            //self::DAO_Campos_Retira($campos, 'unidade');
        }
        // Caso seja Cliente
        if($tipo=='cliente'){
            self::DAO_Campos_Retira($campos, 'banco');
            self::DAO_Campos_Retira($campos, 'agencia');
            self::DAO_Campos_Retira($campos, 'conta');
        }else{
            self::DAO_Campos_Retira($campos, 'telefone2');
            self::DAO_Campos_Retira($campos, 'email2');
        }
        // Caso seja Funcionario 
        if($tipo=='funcionario'){
            // Retira Fisica / CNPJ
            self::Campos_Deletar_Juridica($tipo, $campos, $usuario);
            if(!\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('usuario_Cliente_PrecoDiferenciado')){
                self::DAO_Campos_Retira($campos, 'precoespecial');
            }
        }else{
            self::DAO_Campos_Retira($campos, 'precoespecial');
            self::DAO_Campos_Retira($campos, 'funcao');
            self::DAO_Campos_Retira($campos, 'emergencia');
            self::DAO_Campos_Retira($campos, 'data_admissao');
            self::DAO_Campos_Retira($campos, 'data_demissao');
            self::DAO_Campos_Retira($campos, 'vale_transporte');
            self::DAO_Campos_Retira($campos, 'vale_refeicao');
            self::DAO_Campos_Retira($campos, 'hora_entrada');
            self::DAO_Campos_Retira($campos, 'hora_saida');
            self::DAO_Campos_Retira($campos, 'salariobase');
            self::DAO_Campos_Retira($campos, 'tipocontrato');
            self::DAO_Campos_Retira($campos, 'cnh');
            self::DAO_Campos_Retira($campos, 'cnh_valida');
        }
        
        // SE esta no modulo predial
        if((\Framework\App\Sistema_Funcoes::Perm_Modulos('predial'))){
            self::DAO_Campos_Retira($campos, 'site');
            self::DAO_Campos_Retira($campos, 'email2');
            self::DAO_Campos_Retira($campos, 'telefone2');
            if($tipo=='funcionario'){
                self::Campos_Deletar_Juridica($tipo, $campos, $usuario);
            }
            else{
                // Retira JURIDICA E CPF
                self::Campos_Deletar_Juridica($tipo, $campos, $usuario);
                self::DAO_Campos_Retira($campos, 'cpf');
                self::DAO_Campos_Retira($campos, 'rg');
                self::Campos_Deletar_Localizacao($tipo, $campos, $usuario);
            }
        }
        // SE nao esta no modulo usuario_rede
        if(!(\Framework\App\Sistema_Funcoes::Perm_Modulos('usuario_rede'))){
            self::DAO_Campos_Retira($campos, 'indicado_por');
        }
        // SE nao esta no modulo comercio_certificado
        if(!(\Framework\App\Sistema_Funcoes::Perm_Modulos('comercio_certificado'))){
            self::DAO_Campos_Retira($campos, 'fax');
            
            self::DAO_Campos_Retira($campos, 'selo_liberar');
            self::DAO_Campos_Retira($campos, 'resp_empresa');
            self::DAO_Campos_Retira($campos, 'resp_fatura');
            
            self::DAO_Campos_Retira($campos, 'entrega_cep');
            self::DAO_Campos_Retira($campos, 'entrega_endereco');
            self::DAO_Campos_Retira($campos, 'entrega_pais');
            self::DAO_Campos_Retira($campos, 'entrega_estado');
            self::DAO_Campos_Retira($campos, 'entrega_cidade');
            self::DAO_Campos_Retira($campos, 'entrega_bairro');
            self::DAO_Campos_Retira($campos, 'entrega_numero');
            self::DAO_Campos_Retira($campos, 'entrega_complemento');
            if($tipo=='cliente'){
                
            }else if($tipo=='funcionario'){
                self::DAO_Campos_Retira($campos, 'site');
            }
        }else{
            // Retira Fisica / CPF
            self::DAO_Campos_Retira($campos, 'site');
            self::DAO_Campos_Retira($campos, 'telefone2');
            self::DAO_Campos_Retira($campos, 'email2');
            if($tipo=='cliente'){
                self::Campos_Deletar_Fisica($tipo, $campos, $usuario);
                self::DAO_Campos_Retira($campos, 'obs');
            }else{
                self::Campos_Deletar_Juridica($tipo, $campos, $usuario);
                
                self::DAO_Campos_Retira($campos, 'selo_liberar');
                self::DAO_Campos_Retira($campos, 'resp_empresa');
                self::DAO_Campos_Retira($campos, 'resp_fatura');

                self::DAO_Campos_Retira($campos, 'entrega_cep');
                self::DAO_Campos_Retira($campos, 'entrega_endereco');
                self::DAO_Campos_Retira($campos, 'entrega_pais');
                self::DAO_Campos_Retira($campos, 'entrega_estado');
                self::DAO_Campos_Retira($campos, 'entrega_cidade');
                self::DAO_Campos_Retira($campos, 'entrega_bairro');
                self::DAO_Campos_Retira($campos, 'entrega_numero');
                self::DAO_Campos_Retira($campos, 'entrega_complemento');
            }
        }
        self::DAO_Campos_Retira($campos, 'foto_cnh');
        self::DAO_Campos_Retira($campos, 'foto_cnh_apv');
        self::DAO_Campos_Retira($campos, 'foto_res');
        self::DAO_Campos_Retira($campos, 'foto_res_apv');
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
            $link_add = 'usuario/Admin/Cliente_Add/'.$categoria;
        }
        else if($grupo!==false && $grupo[0]==CFG_TEC_CAT_ID_FUNCIONARIOS && $inverter===false){
            $linkextra = '/funcionario';
            $link = 'usuario/Admin/ListarFuncionario';
            $link_add = 'usuario/Admin/Funcionario_Add/'.$categoria;
        }else{
            $link = 'usuario/Admin/ListarUsuario';
            $link_add = 'usuario/Admin/Usuarios_Add/'.$categoria;
        }

        // Permissoes (Fora Do LOOPING por performace)
        $usuario_Admin_Foto             = \Framework\App\Acl::Sistema_Modulos_Configs_Funcional('usuario_Admin_Foto');
        $Financeiro_User_Saldo          = \Framework\App\Acl::Sistema_Modulos_Configs_Funcional('Financeiro_User_Saldo');
        $usuario_Admin_Grupo            = \Framework\App\Acl::Sistema_Modulos_Configs_Funcional('usuario_Grupo_Mostrar');


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
        
        $tabela_colunas = Array();
        $tabela_colunas[] = 'Id';
        if($Ativado_Grupo===true){
            $tabela_colunas[] = 'Grupo';
        }
        if($Ativado_Foto===true){
            $tabela_colunas[] = 'Foto';
        }
        // Mostra Nome
        $tabela_colunas[] = 'Nome';

        $tabela_colunas[] = 'Contato';

        $tabela_colunas[] = 'Email';

        // para MOdulos que contem banco
        if(\Framework\App\Sistema_Funcoes::Perm_Modulos('Financeiro') && $Financeiro_User_Saldo){
            $tabela_colunas[] = 'Saldo';
        }

        $tabela_colunas[] = 'Data de Cadastro';
        $tabela_colunas[] = 'Funções';

        $this->_Visual->Show_Tabela_DataTable_Massiva($tabela_colunas,$link);
        
        if($ativado===false){
            $titulo = 'Todos os '.$nomedisplay.' (<span id="DataTable_Contador">Carregando...</span>)';
        }elseif($ativado==0){
            $titulo = 'Todos os '.$nomedisplay.' Desativados (<span id="DataTable_Contador">Carregando...</span>)';
        }else{
            $titulo = 'Todos os '.$nomedisplay.' Ativados (<span id="DataTable_Contador">Carregando...</span>)';
        }
                
        $this->_Visual->Bloco_Unico_CriaJanela($titulo,'',$gravidade,Array("link"=>$link_add,'icon'=>'add','nome'=>'Adicionar '.Framework\Classes\Texto::Transformar_Plural_Singular($nomedisplay)));
    }
}
?>
