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
    * @version 0.4.2
    */
    public function __construct() {
        // construct
        parent::__construct();
    }
    
    static function Usuarios_Tabela(&$usuarios, $nomedisplay_sing, $linkextra, $grupo = FALSE, $url_ver='usuario/Perfil/Perfil_Show', $url_editar='usuario/Admin/Usuarios_Edit', $url_deletar='usuario/Admin/Usuarios_Del') {
        $Registro   = &\Framework\App\Registro::getInstacia();
        $Modelo     = &$Registro->_Modelo;
        $Visual     = &$Registro->_Visual;
        $table = Array();
        $i = 0;
        if (is_object($usuarios)) {
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
        $perm_view          = $Registro->_Acl->Get_Permissao_Url($url_ver);
        $perm_comentario    = $Registro->_Acl->Get_Permissao_Url('usuario/Admin/Usuarios_Comentario');
        $perm_anexo         = $Registro->_Acl->Get_Permissao_Url('usuario/Anexo/Anexar');
        $perm_email         = $Registro->_Acl->Get_Permissao_Url('usuario/Admin/Usuarios_Email');
        $permissionStatus        = $Registro->_Acl->Get_Permissao_Url('usuario/Admin/Status');
        $permissionEdit        = $Registro->_Acl->Get_Permissao_Url($url_editar);
        $permissionDelete           = $Registro->_Acl->Get_Permissao_Url($url_deletar);
        
        // Verifica Grupo
        $Ativado_Grupo = FALSE;
        if (is_array($usuario_Admin_Grupo)) {
            if ($grupo === FALSE || (is_array($grupo) && in_array($grupo[0], $usuario_Admin_Grupo))) {
                $Ativado_Grupo = TRUE;
            }
        } else {
            if ($usuario_Admin_Grupo === TRUE) {
                $Ativado_Grupo = TRUE;
            }
        }
        
        // Verifica foto
        $Ativado_Foto = FALSE;
        if (is_array($usuario_Admin_Foto)) {
            if ($grupo === FALSE || (is_array($grupo) && in_array($grupo[0], $usuario_Admin_Foto))) {
                $Ativado_Foto = TRUE;
            }
        } else {
            if ($usuario_Admin_Foto === TRUE) {
                $Ativado_Foto = TRUE;
            }
        }
        // Faz Looping Escrevendo Tabelas
        foreach ($usuarios as &$valor) {
            $table['Id'][$i]         = $valor->id;
            if ($Ativado_Grupo === TRUE) {
                $table['Grupo'][$i]      = $valor->grupo2;
            }
            if ($Ativado_Foto === TRUE) {
                if ($valor->foto==='' || $valor->foto === FALSE) {
                    $foto = WEB_URL.'img'.US.'icons'.US.'clientes.png';
                } else {
                    $foto = $valor->foto;
                }
                $table['Foto'][$i]             = '<img src="'.$foto.'" style="max-width:100px;" />';
            }
            //$table['#Id'][$i]               = '#'.$valor->id;
            $nome = '';
            // Atualiza Nome
            if ($valor->nome!='') {
                $nome .= $valor->nome;
            }
            // Atualiza Razao Social
            if ($valor->razao_social!='') {
                if ($nome!='') $nome .= '<br>';
                $nome .= $valor->razao_social;
            }
            // Se tiver Mensagens
            if (\Framework\App\Sistema_Funcoes::Perm_Modulos('usuario_mensagem')) {
                $nome = '<a href="'.URL_PATH.'usuario_mensagem/Suporte/Mostrar_Cliente/'.$valor->id.'/">'.$nome.' ('.usuario_mensagem_SuporteModelo::Suporte_MensagensCliente_Qnt($valor->id).')</a>';
            }
            // Mostra Nome
            $table['Nome'][$i]             = $nome;
            $telefone = '';
            if ($valor->telefone!='') {
                $telefone .= $valor->telefone;
            }
            if ($valor->telefone2!='') {
                if ($telefone!='') $telefone .= '<br>';
                $telefone .= $valor->telefone1;
            }
            if ($valor->celular!='') {
                if ($telefone!='') $telefone .= '<br>';
                $telefone .= $valor->celular;
            }
            if ($valor->celular1!='') {
                if ($telefone!='') $telefone .= '<br>';
                $telefone .= $valor->celular1;
            }
            if ($valor->celular2!='') {
                if ($telefone!='') $telefone .= '<br>';
                $telefone .= $valor->celular2;
            }
            if ($valor->celular3!='') {
                if ($telefone!='') $telefone .= '<br>';
                $telefone .= $valor->celular3;
            }

            $table['Contato'][$i]         = $telefone;
            $email = '';
            if ($valor->email!='') {
                $email .= $valor->email;
            }
            if ($valor->email2!='') {
                if ($email!='') $email .= '<br>';
                $email .= $valor->email2;
            }
            
            
            $table['Email'][$i]      =  $email;
            //$table['Nivel de Usuário'][$i] = $niveluser;
            //$table['Nivel de Admin'][$i]   = $niveladmin;
            // para MOdulos que contem banco
            if (\Framework\App\Sistema_Funcoes::Perm_Modulos('Financeiro') && $Financeiro_User_Saldo) {
                $table['Saldo'][$i]        = Financeiro_Modelo::Carregar_Saldo($Modelo, $valor->id, TRUE);
            }
            // Funcoes

            if (strpos($valor->log_date_add, APP_DATA_BR) !== FALSE) {
                $data_add = '<b>'.$valor->log_date_add.'</b>';
            } else {
                $data_add = $valor->log_date_add;
            }
            $table['Data de Cadastro'][$i] = $data_add;

            // Visualizar
            $funcoes_qnt = 1;
            $table['Funções'][$i]          = $Visual->Tema_Elementos_Btn('Visualizar'     ,Array('Visualizar '.$nomedisplay_sing        , $url_ver.'/'.$valor->id.'/'.$linkextra    , ''), $perm_view);
            


            // Financeiro Especifico
            /*if (\Framework\App\Sistema_Funcoes::Perm_Modulos('Financeiro') && $Financeiro_User_Saldo) {
                $table['Funções'][$i]     .=   '<a data-confirma="O '.$nomedisplay_sing.' realizou um deposito para a empresa?" title="Add quantia ao Saldo do '.$nomedisplay_sing.'" class="btn lajax explicar-titulo" data-acao="" href="'.URL_PATH.'Financeiro/Admin/financeiro_deposito/'.$valor->id.$linkextra.'"><img src="'.WEB_URL.'img/icons/cifrao_16x16.png" alt="Depositar"></a>'.
                                                '<a data-confirma="O '.$nomedisplay_sing.' confirmou o saque?" title="Remover Quantia do Saldo do '.$nomedisplay_sing.'" class="btn lajax explicar-titulo" data-acao="" href="'.URL_PATH.'Financeiro/Admin/financeiro_retirar/'.$valor->id.$linkextra.'"><img src="'.WEB_URL.'img/icons/cifrao_16x16.png" alt="Retirar"></a>';
                $funcoes_qnt = 3;
            }*/
            
            
            
            // Comentario de Usuario
            if (\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('usuario_Comentarios')) {
                if ($funcoes_qnt>2) {
                    $table['Funções'][$i]     .=   '<br>';
                    $funcoes_qnt = 0;
                }
                ++$funcoes_qnt;
                $table['Funções'][$i]     .=   $Visual->Tema_Elementos_Btn('Personalizado'   ,Array('Histórico'    ,'usuario/Admin/Usuarios_Comentario/'.$valor->id.$linkextra    , '', 'file', 'inverse'), $perm_comentario);
            }
            // Anexo de Usuario
            if (\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('usuario_Anexo')) {
                if ($funcoes_qnt>2) {
                    $table['Funções'][$i]     .=   '<br>';
                    $funcoes_qnt = 0;
                }
                ++$funcoes_qnt;
                $table['Funções'][$i]     .=   $Visual->Tema_Elementos_Btn('Personalizado'   ,Array('Anexos'    ,'usuario/Anexo/Anexar/'.$valor->id.$linkextra    , '', 'file', 'inverse'), $perm_anexo);
            }
            // Email para Usuario
            if (\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('usuario_Admin_Email')) {
                if ($funcoes_qnt>2) {
                    $table['Funções'][$i]     .=   '<br>';
                    $funcoes_qnt = 0;
                }
                ++$funcoes_qnt;
                $table['Funções'][$i]     .=   $Visual->Tema_Elementos_Btn('Email'      ,Array('Enviar email para '.$nomedisplay_sing        ,'usuario/Admin/Usuarios_Email/'.$valor->id.$linkextra    , ''), $perm_email);
            }
            // Email para Setor
            if (\Framework\App\Sistema_Funcoes::Perm_Modulos('usuario_mensagem') && $usuario_mensagem_EmailSetor) {
                if ($funcoes_qnt>2) {
                    $table['Funções'][$i]     .=   '<br>';
                    $funcoes_qnt = 0;
                }
                ++$funcoes_qnt;
                $table['Funções'][$i]     .=   $Visual->Tema_Elementos_Btn('Personalizado'   ,Array('Enviar email para Setor'    ,'usuario/Admin/Usuarios_Email/'.$valor->id.$linkextra.'/Setor/'    , '', 'envelope', 'danger'), $perm_email);
            }
            // Verifica se Possue Status e Mostra
            if ($usuario_Admin_Ativado_Listar !== FALSE) {
                if ($valor->ativado===1 || $valor->ativado==='1') {
                    $texto = $usuario_Admin_Ativado_Listar[1];
                    $valor->ativado='1';
                } else {
                    $valor->ativado = '0';
                    $texto = $usuario_Admin_Ativado_Listar[0];
                }
                if ($funcoes_qnt>2) {
                    $table['Funções'][$i]     .=   '<br>';
                    $funcoes_qnt = 0;
                }
                ++$funcoes_qnt;
                $table['Funções'][$i]     .=   '<span id="status'.$valor->id.'">'.$Visual->Tema_Elementos_Btn('Status'.$valor->ativado     ,Array($texto        ,'usuario/Admin/Status/'.$valor->id.'/'    , ''), $permissionStatus).'</span>';
            }
            if ($funcoes_qnt>2) {
                $table['Funções'][$i]     .=   '<br>';
                $funcoes_qnt = 0;
            }
            $funcoes_qnt = $funcoes_qnt+2;
            $table['Funções'][$i]         .=   $Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar '.$nomedisplay_sing        , $url_editar.'/'.$valor->id.$linkextra.'/'    , ''), $permissionEdit).
                                                $Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar '.$nomedisplay_sing       , $url_deletar.'/'.$valor->id.$linkextra     ,'Deseja realmente deletar esse '.$nomedisplay_sing.'?'), $permissionDelete);
            ++$i;
        }
        return Array($table, $i);
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
    * @version 0.4.2
     */
    protected function usuariolistar($grupo = FALSE, $ativado = FALSE, $gravidade=0, $inverter = FALSE, $export = FALSE) {
        $i = 0;
        if ($grupo === FALSE) {
            $categoria = 0;
            if ($inverter) {
                $where = 'ativado!='.$ativado;
            } else {
                $where = 'ativado='.$ativado;
            }
            if ($ativado === FALSE) {
                $where = '';
            }
            $nomedisplay        = __('Usuários ');
            $nomedisplay_sing   = __('Usuário ');
            $nomedisplay_tipo   = __('Usuario');
            // Link
            $this->Tema_Endereco(__('Usuários'));
        } else {
            $categoria = (int) $grupo[0];
            
            // Pega GRUPOS VALIDOS
            $sql_grupos = $this->_Modelo->db->Sql_Select('Sistema_Grupo', 'categoria='.$categoria,0, '', 'id');
            $grupos_id = Array();
            if (is_object($sql_grupos)) $sql_grupos = Array(0=>$sql_grupos);
            if ($sql_grupos !== FALSE && !empty($sql_grupos)) {
                foreach ($sql_grupos as &$valor) {
                    $grupos_id[] = $valor->id;
                }
            }
            
            if (empty($grupos_id)) return _Sistema_erroControle::Erro_Fluxo('Grupos não existe',404);
            
            // cria where de acordo com parametros
            if ($inverter) {
                $where = 'grupo NOT IN ('.implode(', ', $grupos_id).') AND ativado='.$ativado;
            } else {
                $where = 'grupo IN ('.implode(', ', $grupos_id).') AND ativado='.$ativado;
            }
            
            if ($ativado === FALSE) {
                $where = explode(' AND ', $where);
                $where = $where[0];
            }
        
            $nomedisplay        = $grupo[1].' ';
            $nomedisplay_sing   = Framework\Classes\Texto::Transformar_Plural_Singular(__($grupo[1]));
            $nomedisplay_tipo   = Framework\Classes\Texto::Transformar_Plural_Singular(__($grupo[1]));
            // Link
            $this->Tema_Endereco(__($grupo[1]));
        }
        
        $linkextra = '';
        if ($grupo !== FALSE && $grupo[0]==CFG_TEC_CAT_ID_CLIENTES && $inverter === FALSE) {
            $linkextra = '/cliente';
            $link = 'usuario/Admin/ListarCliente';
            $link_editar = 'usuario/Admin/Cliente_Edit';
            $link_deletar = 'usuario/Admin/Cliente_Del';
            $link_add = 'usuario/Admin/Cliente_Add/'.$categoria;
        }
        else if ($grupo !== FALSE && $grupo[0]==CFG_TEC_CAT_ID_FUNCIONARIOS && $inverter === FALSE) {
            $linkextra = '/funcionario';
            $link = 'usuario/Admin/ListarFuncionario';
            $link_editar = 'usuario/Admin/Funcionario_Edit';
            $link_deletar = 'usuario/Admin/Funcionario_Del';
            $link_add = 'usuario/Admin/Funcionario_Add/'.$categoria;
        } else {
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
                'Print'     => TRUE,
                'Pdf'       => TRUE,
                'Excel'     => TRUE,
                'Link'      => $link,
            )
        )));
        // Continua Resto
        //$this->_Visual->Blocar('<a title="Adicionar " class="btn btn-success lajax explicar-titulo" data-acao="" href="'.URL_PATH.'usuario/Admin/Usuarios_Add'.$linkextra.'">Adicionar novo '.Framework\Classes\Texto::Transformar_Plural_Singular($nomedisplay).'</a><div class="space15"></div>');
        $usuario = $this->_Modelo->db->Sql_Select('Usuario', $where,0, '', 'id,grupo,foto,nome,razao_social,email,email2,telefone,telefone2,celular,celular1,celular2,celular3,ativado,log_date_add');
        if (is_object($usuario)) {
            $usuario = Array(0=>$usuario);
        }
        if ($usuario !== FALSE && !empty($usuario)) {
            
            // Puxa Tabela e qnt de registro
            list($table, $i) = self::Usuarios_Tabela($usuario, $nomedisplay_sing, $linkextra, $grupo,'usuario/Perfil/Perfil_Show', $link_editar, $link_deletar);
            
            // SE tiver opcao de exportar, exporta e trava o sistema
            if ($export !== FALSE) {
                self::Export_Todos($export, $table, $nomedisplay);
            } else {
                // Imprime a tabela
                $this->_Visual->Show_Tabela_DataTable(
                    $table,     // Array Com a Tabela
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
            unset($table);
        } else {          
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhum '.$nomedisplay_sing.'</font></b></center>');
        }
        if ($ativado === FALSE) {
            $titulo = 'Todos os '.$nomedisplay.' ('.$i.')';
        } elseif ($ativado==0) {
            $titulo = 'Todos os '.$nomedisplay.' Desativados ('.$i.')';
        } else {
            $titulo = 'Todos os '.$nomedisplay.' Ativados ('.$i.')';
        }
        $this->_Visual->Bloco_Unico_CriaJanela($titulo, '', $gravidade);
    }
    static function Usuarios_Email_Ver($id = 0, $tipo = FALSE, $tema='Cliente') {
        $Registro   = &\Framework\App\Registro::getInstacia();
        $Controle   = $Registro->_Controle;
        $Acl   = $Registro->_Acl;
        $Modelo     = $Registro->_Modelo;
        $Visual     = $Registro->_Visual;
        $id = (int) $id;
        $i = 0;
        // Puxa Usuario
        if ($id==0 || !isset($id)) {
            $id = (int) $Acl->Usuario_GetID();
        } else {
            $id = (int) $id;
        }
        $usuario = $Modelo->db->Sql_Select('Usuario', Array('id'=>$id));
        if ($usuario === FALSE)            return _Sistema_erroControle::Erro_Fluxo('Usuario não Existe',404);
        // Pre
        $linkextra = '';
        
        // Pega Tipo
        if ($tipo === FALSE) {
            if ($usuario->grupo==CFG_TEC_CAT_ID_CLIENTES) {
                $tipo   = __('Cliente');
                $tipo2  = 'cliente';
            } else if ($usuario->grupo==CFG_TEC_CAT_ID_FUNCIONARIOS) {
                $tipo   = __('Funcionário');
                $tipo2  = 'funcionario';
            } else {
                $tipo   = __('Usuário');
                $tipo2  = 'usuario';
            }
        }
        // GAmbiarra Para Consertar erro de acento em url
        if ($tipo=='Funcionrio' || $tipo=="Funcionario") $tipo = __("Funcionário");
        if ($tipo=="Usurio" || $tipo=="Usuario")         $tipo = __('Usuário');
        // Cria Tipo 2:
        if ($tipo==__('Cliente') || $tipo==__('cliente')) {
            $tipo2  = 'cliente';
        } else if ($tipo==__('Funcionário') || $tipo==__('funcionário') || $tipo=='Funcionario' || $tipo=='funcionario') {
            $tipo2  = 'funcionario';
        }
        if ($tipo2=='usuario') {
            $nomedisplay        = __('Usuários').' ';
            $nomedisplay_sing   = __('Usuário').' ';
            $nomedisplay_tipo   = __('Usuario');
        } else if ($tipo2=='funcionario') {
            $nome = \Framework\App\Acl::Sistema_Modulos_Configs_Funcional('usuario_Funcionario_nome');
            $nomedisplay        = __($nome).' ';
            $nomedisplay_sing   = Framework\Classes\Texto::Transformar_Plural_Singular(__($nome));
            $nomedisplay_tipo   = Framework\Classes\Texto::Transformar_Plural_Singular(__($nome));
            $linkextra = '/funcionario';
        } else {
            $linkextra = '/cliente';
            $nome = \Framework\App\Acl::Sistema_Modulos_Configs_Funcional('usuario_Cliente_nome');
            $nomedisplay        = __($nome).' ';
            $nomedisplay_sing   = Framework\Classes\Texto::Transformar_Plural_Singular(__($nome));
            $nomedisplay_tipo   = Framework\Classes\Texto::Transformar_Plural_Singular(__($nome));
        }
        // Enviar Email
        //$Visual->Blocar('<a title="Enviar email para '.$nomedisplay_sing.'" class="btn btn-success lajax explicar-titulo" data-acao="" href="'.URL_PATH.'usuario/Admin/Usuarios_Email/'.$id.$linkextra.'">Enviar email para '.$nomedisplay_sing.'</a><div class="space15"></div>');
        $emails = $Modelo->db->Sql_Select('Usuario_Historico_Email',Array('cliente'=>$id));
        if ($emails !== FALSE && !empty($emails)) {
            if (is_object($emails)) $emails = Array(0=>$emails);
            reset($emails);
            foreach ($emails as $indice=>&$valor) {
                $table['Cliente'][$i]              = $valor->nome_usuario;
                $email = '';
                
                if ($tema!='Setor') {
                    if ($valor->email_usuario2!='') {
                        if ($email!='') {
                            $email .= '<br>';
                        }
                        $email .= $valor->email_usuario2;
                    }
                    if ($valor->email_usuario!='') {
                        if ($email!='') {
                            $email .= '<br>';
                        }
                        $email .= $valor->email_usuario;
                    }
                    $table['Email Cliente'][$i]        = $email;
                }
                $table['Titulo da Mensagem'][$i]   = $valor->titulo;
                $table['Mensagem'][$i]             = $valor->mensagem;
                ++$i;
            }
            $Visual->Show_Tabela_DataTable($table);
            unset($table);
        } else {
            if ($tema=='Setor') {
                $Visual->Blocar('<center><b><font color="#FF0000" size="5">'.__('Nenhum Email enviado para o Setor').'</font></b></center>');            
            } else {
                $Visual->Blocar('<center><b><font color="#FF0000" size="5">'.__('Nenhum Email enviado para o Usuário').'</font></b></center>');            
            }
        }
        if ($tema=='Setor') {
            $titulo = __('Histórico de Envio de Email para Setor').' ('.$i.')';
        } else {
            $titulo = __('Histórico de Envio de Email para Cliente').' ('.$i.')';
        }
        $Visual->Bloco_Unico_CriaJanela($titulo);
        
        //Carrega Json
        $Visual->Json_Info_Update('Titulo', 'Histórico de Email');
    }
    public function Usuarios_Email($id = 0, $tipo = FALSE, $tema='Cliente') {
        if ($id==0 || !isset($id)) {
            $id = (int) $this->_Acl->Usuario_GetID();
        } else {
            $id = (int) $id;
        }
        if ($tipo === FALSE) {
            if ($usuario->grupo==CFG_TEC_IDCLIENTE) {
                $tipo   = __('Cliente');
                $tipo2  = 'cliente';
            } else if ($usuario->grupo==CFG_TEC_IDFUNCIONARIO) {
                $tipo   = 'Funcionário';
                $tipo2  = 'funcionario';
            }
        }
        // GAmbiarra Para Consertar erro de acento em url
        if ($tipo=='Funcionrio' || $tipo=="Funcionario") $tipo = "Funcionário";
        if ($tipo=="Usurio" || $tipo=="Usuario")         $tipo = __('Usuário');
        // Cria Tipo 2:
        if ($tipo=='Cliente' || $tipo=='cliente') {
            $tipo2  = 'cliente';
            $this->Tema_Endereco(__('Clientes'),'usuario/Admin/ListarCliente');
        } else if ($tipo=='Funcionário' || $tipo=='Funcionario' || $tipo=='funcionário' || $tipo=='funcionario') {
            $tipo2  = 'funcionario';
            $this->Tema_Endereco(__('Funcionários'),'usuario/Admin/ListarFuncionario');
        } else {
            $this->Tema_Endereco(__('Usuários'),'usuario/Admin/Main');
        }
        if ($tema=='Setor') {
            $this->Tema_Endereco(__('Enviar Email para Setor'));
        } else {
            $this->Tema_Endereco(__('Enviar Email'));
        }
        // Retira os de clientes
        $linkextra = '';
        if ($tipo !== FALSE) {
            $linkextra = $tipo.'/';
        }
        // Carrega formulario
        $form = new \Framework\Classes\Form('form_Sistema_Admin_Usuarios', 'usuario/Admin/Usuarios_Email2/'.$id.'/'.$linkextra,'formajax');
        $form->Input_Novo(
            'Titulo da Mensagem',
            'titulo',
            '',
            'text', 
             250,
            'obrigatorio',
            '',
            FALSE,
            ''
        ); 
        if ($tema=='Setor') {
            $form->Input_Novo(
                'Nome Opcional',
                'nome_opcional',
                '',
                'text', 
                250,
                '',
                '',
                FALSE,
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
                FALSE,
                ''
            ); 
        } else {
            $form->Input_Novo(
                'Nome do Email Setor',
                'nome_opcional',
                '',
                'text', 
                50,
                '',
                '',
                FALSE,
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
                FALSE,
                ''
            ); 
        }
        $form->TextArea_Novo(
            'Mensagem',
            'mensagem',
            'mensagem',
            '',
            'editor',
            FALSE,
            'obrigatorio',
            ''
        ); 
        if ($tema!='Setor') {
            $formulario = $form->retorna_form('Enviar Email para Usuário');
            $this->_Visual->Blocar($formulario);
            $this->_Visual->Bloco_Unico_CriaJanela(__('Enviar Email para Usuário'), '',10);
        } else {
            $formulario = $form->retorna_form('Enviar Email para o Setor');
            $this->_Visual->Blocar($formulario);
            $this->_Visual->Bloco_Unico_CriaJanela(__('Enviar Email para o Setor'), '',10);
        }
        // Usuario ver emails
        usuario_Controle::Usuarios_Email_Ver($id, $tipo2, $tema);
        // Titulo
        $this->_Visual->Json_Info_Update('Titulo', __('Enviar Email para Usuário'));
    }
    public function Usuarios_Email2($id = 0, $tipo = FALSE, $tema='Cliente') {
        if ($id==0 || !isset($id)) {
            $id = (int) $this->_Acl->Usuario_GetID();
        } else {
            $id = (int) $id;
        }
        // Envia Email
        $mailer = new \Framework\Classes\Email();
        $usuario = $this->_Modelo->db->Sql_Select('Usuario',Array('id'=>$id),1);
        $nome = $usuario->nome;
        // Add Email normal e alternativo para enviar 
        $enviar = '';
        if ($tema=='Cliente') {
            if ($usuario->email!='' && \Framework\App\Sistema_Funcoes::Control_Layoult_Valida_Email($usuario->email)) {
                $enviar .= '->setTo(\''.$usuario->email.'\', \''.$nome.'\')';
            }
            if ($usuario->email2!='' && \Framework\App\Sistema_Funcoes::Control_Layoult_Valida_Email($usuario->email2)) {
                $enviar .= '->setTo(\''.$usuario->email2.'\', \''.$nome.'\')';
            }
        }
        // Envia Se tiver Email Opcional
        $email_opcional = \Framework\App\Conexao::anti_injection($_POST['email_opcional']);
        $nome_opcional  = \Framework\App\Conexao::anti_injection($_POST['nome_opcional']);
        if ($email_opcional!='' && \Framework\App\Sistema_Funcoes::Control_Layoult_Valida_Email($email_opcional)) {
            $enviar .= '->setTo(\''.$email_opcional.'\', \''.$nome_opcional.'\')';
        }
        if ($enviar=='') {
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Nenhum Email válido para enviar !')
            );
            $this->_Visual->Json_IncluiTipo('Mensagens', $mensagens); 
            $this->_Visual->Json_Info_Update('Historico', FALSE);
            $this->Json_Definir_zerar(FALSE);
        } else {
            $amensagem = '<strong><b>Mensagem:</b> '.  \Framework\App\Conexao::anti_injection($_POST['mensagem']).'</strong><br><strong>'.usuario_PerfilVisual::Show_HTML($usuario, $tipo).'</strong>';
            // Enviar Email 
            eval('$send	= $mailer'.$enviar.'->setSubject(\''.\Framework\App\Conexao::anti_injection($_POST['titulo']).' - '.SISTEMA_NOME.'\')'.
            '->setFrom(SISTEMA_EMAIL, SISTEMA_NOME)'.
            '->addGenericHeader(\'X-Mailer\', \'PHP/\' . phpversion())'.
            '->addGenericHeader(\'Content-Type\', \'text/html; charset="utf-8"\')'.
            '->setMessage(\''.$amensagem.'\')'.
            '->setWrap(78)->send();');
            if ($send) {
                $Registro = new \Usuario_Historico_Email_DAO();
                $Registro->cliente          = $id;
                $Registro->titulo           = \Framework\App\Conexao::anti_injection($_POST['titulo']);
                $Registro->email_opcional   = $email_opcional;
                $Registro->nome_opcional    = $nome_opcional;
                $Registro->mensagem         = \Framework\App\Conexao::anti_injection($_POST['mensagem']);
                $Registro->email_usuario    = $usuario->email;
                $Registro->email_usuario2   = $usuario->email2;
                $Registro->nome_usuario     = $nome;
                $this->_Modelo->db->Sql_Insert($Registro);
                $mensagens = array(
                    "tipo" => 'sucesso',
                    "mgs_principal" => __('Email enviado com Sucesso'),
                    "mgs_secundaria" => __('Voce enviou com sucesso.')
                );
                $this->_Visual->Json_Info_Update('Titulo', 'Enviado com Sucesso.');
            } else {
                $mensagens = array(
                    "tipo" => 'erro',
                    "mgs_principal" => __('Erro'),
                    "mgs_secundaria" => __('Email não foi enviado !')
                );
            }
            // Recarrega Main
            /*if ($tipo=='cliente') {
                $this->ListarCliente();
            } else if ($tipo=='funcionario') {
                $this->ListarFuncionario();
            } else {
                $this->Main();
            }*/
            $this->Usuarios_Email($id, $tipo, $tema);
            $this->_Visual->Json_IncluiTipo('Mensagens', $mensagens); 
            $this->_Visual->Json_Info_Update('Historico', FALSE);
        }
    }
    
    static function Static_usuariolistar($grupo = FALSE, $ativado = FALSE, $inverter = FALSE, $export = FALSE) {
        
        
        $Registro   = &\Framework\App\Registro::getInstacia();
        $Controle   = $Registro->_Controle;
        $Modelo     = $Registro->_Modelo;
        $Visual     = $Registro->_Visual;
        $i          = 0;
        
        
        
        
        
        
        
        if ($grupo === FALSE) {
            $categoria = 0;
            if ($inverter) {
                $where = 'ativado!='.$ativado;
            } else {
                $where = 'ativado='.$ativado;
            }
            if ($ativado === FALSE) {
                $where = '';
            }
            $nomedisplay        = __('Usuários ');
            $nomedisplay_sing   = __('Usuário ');
            $nomedisplay_tipo   = __('Usuario');
            // Link
            $Controle->Tema_Endereco(__('Usuários'));
        } else {
            $categoria = (int) $grupo[0];
            
            // Pega GRUPOS VALIDOS
            $sql_grupos = $Modelo->db->Sql_Select('Sistema_Grupo', 'categoria='.$categoria,0, '', 'id');
            $grupos_id = Array();
            if (is_object($sql_grupos)) $sql_grupos = Array(0=>$sql_grupos);
            if ($sql_grupos !== FALSE && !empty($sql_grupos)) {
                foreach ($sql_grupos as &$valor) {
                    $grupos_id[] = $valor->id;
                }
            }
            
            if (empty($grupos_id)) return _Sistema_erroControle::Erro_Fluxo('Grupos não existe',404);
            
            // cria where de acordo com parametros
            if ($inverter) {
                $where = 'grupo NOT IN ('.implode(', ', $grupos_id).') AND ativado='.$ativado;
            } else {
                $where = 'grupo IN ('.implode(', ', $grupos_id).') AND ativado='.$ativado;
            }
            
            if ($ativado === FALSE) {
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
        if ($grupo !== FALSE && $grupo[0]==CFG_TEC_CAT_ID_CLIENTES && $inverter === FALSE) {
            $linkextra = '/cliente';
            $link = 'usuario/Admin/ListarCliente';
            $link_ver = 'comercio_certificado/Proposta/Usuarios_Produtos';    
            $link_editar = 'comercio_certificado/Proposta/Usuarios_Mostrar';
            $link_deletar = 'comercio_certificado/Proposta/Usuarios_Del';
            $link_add = 'comercio_certificado/Proposta/Usuarios_Mostrar';
        }
        else if ($grupo !== FALSE && $grupo[0]==CFG_TEC_CAT_ID_FUNCIONARIOS && $inverter === FALSE) {
            $linkextra = '/funcionario';
            $link = 'usuario/Admin/ListarFuncionario';
            $link_ver = 'comercio_certificado/Proposta/Usuarios_Produtos';    
            $link_editar = 'comercio_certificado/Proposta/Usuarios_Mostrar';
            $link_deletar = 'comercio_certificado/Proposta/Usuarios_Del';
            $link_add = 'comercio_certificado/Proposta/Usuarios_Mostrar';
        } else {
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
                'Print'     => TRUE,
                'Pdf'       => TRUE,
                'Excel'     => TRUE,
                'Link'      => $link,
            )
        ));
        // Continua Resto
        //$this->_Visual->Blocar('<a title="Adicionar " class="btn btn-success lajax explicar-titulo" data-acao="" href="'.URL_PATH.'usuario/Admin/Usuarios_Add'.$linkextra.'">Adicionar novo '.Framework\Classes\Texto::Transformar_Plural_Singular($nomedisplay).'</a><div class="space15"></div>');
        $usuario = $Modelo->db->Sql_Select('Usuario', $where,0, '', 'id,grupo,foto,nome,razao_social,email,email2,telefone,telefone2,celular,celular1,celular2,celular3,ativado,log_date_add');
        if (is_object($usuario)) $usuario = Array(0=>$usuario);
        if ($usuario !== FALSE && !empty($usuario)) {
            list($table, $i) = self::Usuarios_Tabela($usuario, $nomedisplay_sing, $linkextra, $grupo, $link_ver, $link_editar, $link_deletar);
            if ($export !== FALSE) {
                self::Export_Todos($export, $table, $nomedisplay);
            } else {
                $html .= $Visual->Show_Tabela_DataTable(
                    $table,     // Array Com a Tabela
                    '',          // style extra
                    FALSE,        // true -> Add ao Bloco, false => Retorna html
                    true,        // Apagar primeira coluna ?
                    Array(       // Ordenacao
                        Array(
                            0,'desc'
                        )
                    )
                );
            }
            unset($table);
        } else {
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
    public static function Campos_Deletar_Juridica($tipo, &$campos,&$usuario = FALSE) {
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
    public static function Campos_Deletar_Fisica($tipo, &$campos,&$usuario = FALSE) {
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
    public static function Campos_Deletar_Localizacao($tipo, &$campos,&$usuario = FALSE) {
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
    public static function Campos_Deletar($tipo = FALSE, &$campos,&$usuario = FALSE) {
        // Captura Instancias e 
        $Registro = &\Framework\App\Registro::getInstacia();
        $_Modelo  = &$Registro->_Modelo;
        
        if ($usuario !== FALSE && isset($usuario->grupo)) {
            $sql_grupo = $_Modelo->db->Sql_Select('Sistema_Grupo',Array('id'=>$usuario->grupo),1);
            $sql_grupo = $sql_grupo->categoria;
        } else {
            $sql_grupo = $tipo;
        }
            
            
        if (CFG_TEC_PAISES_EXTRAGEIROS === FALSE) {
            self::DAO_RemoveLinkExtra($campos, Array('pais', 'estado', 'cidade', 'bairro'));
        }
        // LOGIN
        $usuario_Admin_Login = \Framework\App\Acl::Sistema_Modulos_Configs_Funcional('usuario_Login');
        if (is_array($usuario_Admin_Login)) {
            // SE categoria nao existir
            if (!($sql_grupo === FALSE || in_array($sql_grupo, $usuario_Admin_Login))) {
                self::DAO_Campos_Retira($campos, 'login');
                self::DAO_Campos_Retira($campos, 'senha');
            }
        } else {
            if ($usuario_Admin_Login === FALSE) {
                self::DAO_Campos_Retira($campos, 'login');
                self::DAO_Campos_Retira($campos, 'senha');
            }
        }
        
        // GRUPO
        $usuario_Admin_Grupo = \Framework\App\Acl::Sistema_Modulos_Configs_Funcional('usuario_Grupo_Mostrar');
        if (is_array($usuario_Admin_Grupo)) {
            // SE categoria nao existir
            if (!($sql_grupo === FALSE || in_array($sql_grupo, $usuario_Admin_Grupo))) {
                self::DAO_Campos_Retira($campos, 'grupo');
            }
        } else {
            if ($usuario_Admin_Grupo === FALSE) {
                self::DAO_Campos_Retira($campos, 'grupo');
            }
        }
        
        // FOTO
        $usuario_Admin_Foto = \Framework\App\Acl::Sistema_Modulos_Configs_Funcional('usuario_Admin_Foto');
        if (is_array($usuario_Admin_Foto)) {
            // SE categoria nao existir
            if (!($sql_grupo === FALSE || in_array($sql_grupo, $usuario_Admin_Foto))) {
                self::DAO_Campos_Retira($campos, 'foto');
            }
        } else {
            if ($usuario_Admin_Foto === FALSE) {
                self::DAO_Campos_Retira($campos, 'foto');
            }
        }
        
        // CONTINUA
        if (!\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('usuario_Admin_Ativado')) {
            self::DAO_Campos_Retira($campos, 'ativado');
        }
        if (!\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('usuario_Admin_Site')) {
            self::DAO_Campos_Retira($campos, 'site');
        }
        // Tira resto 
        self::DAO_Campos_Retira($campos, 'Permissões do Usuário');
        self::DAO_Campos_Retira($campos, 'perfil_sexo');
        // Retira se nao for Engenharia
        if (!(\Framework\App\Sistema_Funcoes::Perm_Modulos('Engenharia')) || $tipo!='cliente') {
            self::DAO_Campos_Retira($campos, 'eng_clienteinvestidor');
            //self::DAO_Campos_Retira($campos, 'empreendimento');
            //self::DAO_Campos_Retira($campos, 'unidade');
        }
        // Caso seja Cliente
        if ($tipo=='cliente') {
            self::DAO_Campos_Retira($campos, 'banco');
            self::DAO_Campos_Retira($campos, 'agencia');
            self::DAO_Campos_Retira($campos, 'conta');
        } else {
            self::DAO_Campos_Retira($campos, 'telefone2');
            self::DAO_Campos_Retira($campos, 'email2');
        }
        // Caso seja Funcionario 
        if ($tipo=='funcionario') {
            // Retira Fisica / CNPJ
            self::Campos_Deletar_Juridica($tipo, $campos, $usuario);
            if (!\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('usuario_Cliente_PrecoDiferenciado')) {
                self::DAO_Campos_Retira($campos, 'precoespecial');
            }
        } else {
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
        if ((\Framework\App\Sistema_Funcoes::Perm_Modulos('predial'))) {
            self::DAO_Campos_Retira($campos, 'site');
            self::DAO_Campos_Retira($campos, 'email2');
            self::DAO_Campos_Retira($campos, 'telefone2');
            if ($tipo=='funcionario') {
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
        if (!(\Framework\App\Sistema_Funcoes::Perm_Modulos('usuario_rede'))) {
            self::DAO_Campos_Retira($campos, 'indicado_por');
        }
        // SE nao esta no modulo comercio_certificado
        if (!(\Framework\App\Sistema_Funcoes::Perm_Modulos('comercio_certificado'))) {
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
            if ($tipo=='cliente') {
                
            } else if ($tipo=='funcionario') {
                self::DAO_Campos_Retira($campos, 'site');
            }
        } else {
            // Retira Fisica / CPF
            self::DAO_Campos_Retira($campos, 'site');
            self::DAO_Campos_Retira($campos, 'telefone2');
            self::DAO_Campos_Retira($campos, 'email2');
            if ($tipo=='cliente') {
                self::Campos_Deletar_Fisica($tipo, $campos, $usuario);
                self::DAO_Campos_Retira($campos, 'obs');
            } else {
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
    
    
    
    
    protected function Usuario_Listagem($grupo = FALSE, $ativado = FALSE, $gravidade=0, $inverter = FALSE, $export = FALSE) {
        $i = 0;
        if ($grupo === FALSE) {
            $categoria = 0;
            if ($inverter) {
                $where = 'ativado!='.$ativado;
            } else {
                $where = 'ativado='.$ativado;
            }
            if ($ativado === FALSE) {
                $where = '';
            }
            $nomedisplay        = __('Usuários').' ';
            $nomedisplay_sing   = __('Usuário').' ';
            $nomedisplay_tipo   = __('Usuario');
            // Link
            $this->Tema_Endereco(__('Usuários'));
        } else {
            $categoria = (int) $grupo[0];
            
            // Pega GRUPOS VALIDOS
            $sql_grupos = $this->_Modelo->db->Sql_Select('Sistema_Grupo', 'categoria='.$categoria,0, '', 'id');
            $grupos_id = Array();
            if (is_object($sql_grupos)) $sql_grupos = Array(0=>$sql_grupos);
            if ($sql_grupos !== FALSE && !empty($sql_grupos)) {
                foreach ($sql_grupos as &$valor) {
                    $grupos_id[] = $valor->id;
                }
            }
            
            if (empty($grupos_id)) return _Sistema_erroControle::Erro_Fluxo('Grupos não existe',404);
            
            // cria where de acordo com parametros
            if ($inverter) {
                $where = 'grupo NOT IN ('.implode(', ', $grupos_id).') AND ativado='.$ativado;
            } else {
                $where = 'grupo IN ('.implode(', ', $grupos_id).') AND ativado='.$ativado;
            }
            
            if ($ativado === FALSE) {
                $where = explode(' AND ', $where);
                $where = $where[0];
            }
        
            $nomedisplay        = __($grupo[1]).' ';
            $nomedisplay_sing   = Framework\Classes\Texto::Transformar_Plural_Singular(__($grupo[1]));
            $nomedisplay_tipo   = Framework\Classes\Texto::Transformar_Plural_Singular(__($grupo[1]));
            // Link
            $this->Tema_Endereco(__($grupo[1]));
        }
        
        $linkextra = '';
        if ($grupo !== FALSE && $grupo[0]==CFG_TEC_CAT_ID_CLIENTES && $inverter === FALSE) {
            $linkextra = '/cliente';
            $link = 'usuario/Admin/ListarCliente';
            $link_add = 'usuario/Admin/Cliente_Add/'.$categoria;
        }
        else if ($grupo !== FALSE && $grupo[0]==CFG_TEC_CAT_ID_FUNCIONARIOS && $inverter === FALSE) {
            $linkextra = '/funcionario';
            $link = 'usuario/Admin/ListarFuncionario';
            $link_add = 'usuario/Admin/Funcionario_Add/'.$categoria;
        } else {
            $link = 'usuario/Admin/ListarUsuario';
            $link_add = 'usuario/Admin/Usuarios_Add/'.$categoria;
        }

        // Permissoes (Fora Do LOOPING por performace)
        $usuario_Admin_Foto             = \Framework\App\Acl::Sistema_Modulos_Configs_Funcional('usuario_Admin_Foto');
        $Financeiro_User_Saldo          = \Framework\App\Acl::Sistema_Modulos_Configs_Funcional('Financeiro_User_Saldo');
        $usuario_Admin_Grupo            = \Framework\App\Acl::Sistema_Modulos_Configs_Funcional('usuario_Grupo_Mostrar');


        // Verifica Grupo
        $Ativado_Grupo = FALSE;
        if (is_array($usuario_Admin_Grupo)) {
            if ($grupo === FALSE || (is_array($grupo) && in_array($grupo[0], $usuario_Admin_Grupo))) {
                $Ativado_Grupo = TRUE;
            }
        } else {
            if ($usuario_Admin_Grupo === TRUE) {
                $Ativado_Grupo = TRUE;
            }
        }

        // Verifica foto
        $Ativado_Foto = FALSE;
        if (is_array($usuario_Admin_Foto)) {
            if ($grupo === FALSE || (is_array($grupo) && in_array($grupo[0], $usuario_Admin_Foto))) {
                $Ativado_Foto = TRUE;
            }
        } else {
            if ($usuario_Admin_Foto === TRUE) {
                $Ativado_Foto = TRUE;
            }
        }         
        
        $table_colunas = Array();
        $table_colunas[] = __('Id');
        if ($Ativado_Grupo === TRUE) {
            $table_colunas[] = __('Grupo');
        }
        if ($Ativado_Foto === TRUE) {
            $table_colunas[] = __('Foto');
        }
        // Mostra Nome
        $table_colunas[] = __('Nome');

        $table_colunas[] = __('Contato');

        $table_colunas[] = __('Email');

        // para MOdulos que contem banco
        if (\Framework\App\Sistema_Funcoes::Perm_Modulos('Financeiro') && $Financeiro_User_Saldo) {
            $table_colunas[] = __('Saldo');
        }

        $table_colunas[] = __('Data de Cadastro');
        $table_colunas[] = __('Funções');

        $this->_Visual->Show_Tabela_DataTable_Massiva($table_colunas, $link, '', TRUE, FALSE,Array(Array(0,'desc')));
        
        if ($ativado === FALSE) {
            $titulo = 'Todos os '.$nomedisplay.' (<span id="DataTable_Contador">0</span>)';
        } elseif ($ativado==0) {
            $titulo = 'Todos os '.$nomedisplay.' Desativados (<span id="DataTable_Contador">0</span>)';
        } else {
            $titulo = 'Todos os '.$nomedisplay.' Ativados (<span id="DataTable_Contador">0</span>)';
        }
                
        $this->_Visual->Bloco_Unico_CriaJanela($titulo, '', $gravidade,Array("link"=>$link_add,'icon'=>'add', 'nome'=>'Adicionar '.Framework\Classes\Texto::Transformar_Plural_Singular($nomedisplay)));
    }
}
?>
