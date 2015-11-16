<?php

class _Sistema_AdminControle extends _Sistema_Controle
{
    public function __construct() {
        parent::__construct();
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Main() {
        // Chama Widgets
        $this->AdminWidgets();
        \Framework\App\Visual::Layoult_Home_Widgets_Show();
        
        // Grupo, Configs, Permissoes e Menuys
        $this->Grupos(FALSE,'Menor');
        $this->Configs(FALSE,'Menor');
        $this->Permissoes('Maior');
        $this->Menus('Maior');
        
        // remove indice de menus
        $this->Tema_Endereco_Zerar();
        // Add denovo
        $this->Endereco_Admin(FALSE);
        
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Administração Avançada'));
    }
    public function AdminWidgets() {
        // Grupo
        $grupo_qnt = $this->_Modelo->db->Sql_Contar('Sistema_Grupo');
        // Menu
        $menu_qnt = $this->_Modelo->db->Sql_Contar('Sistema_Menu');
        // Config
        $config_qnt = $this->_Modelo->db->Sql_Contar('Sistema_Config');
        // Permissao
        $permissao_qnt = $this->_Modelo->db->Sql_Contar('Sistema_Permissao');
        
        // Exibir
        \Framework\App\Visual::Layoult_Home_Widgets_Add(
            'Grupos', 
            '_Sistema/Admin/Grupos', 
            'user', 
            $grupo_qnt, 
            'block-purple', 
            FALSE, 
            20
        );
        \Framework\App\Visual::Layoult_Home_Widgets_Add(
            'Menu', 
            '_Sistema/Admin/Menus', 
            'tag', 
            $menu_qnt, 
            'block-green', 
            FALSE, 
            10
        );
        \Framework\App\Visual::Layoult_Home_Widgets_Add(
            'Configurações', 
            '_Sistema/Admin/Configs', 
            'tag', 
            $config_qnt, 
            'block-green', 
            FALSE, 
            10
        );
        \Framework\App\Visual::Layoult_Home_Widgets_Add(
            'Permissões', 
            '_Sistema/Admin/Permissao', 
            'tag', 
            $permissao_qnt, 
            'nav-olive', 
            FALSE, 
            8
        );
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Menus($export='Unico') {
        $this->Endereco_Admin_Menu(FALSE);
        $i = 0;
        $this->_Visual->Blocar($this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            Array(
                __('Adicionar Menu'),
                '_Sistema/Admin/Menus_Add',
                ''
            ),
            Array(
                'Print'     => TRUE,
                'Pdf'       => TRUE,
                'Excel'     => TRUE,
                'Link'      => '_Sistema/Admin/Menus',
            )
        )));
        $menu = $this->_Modelo->db->Sql_Select('Sistema_Menu');
        if (is_object($menu)) $menu = Array(0=>$menu);
        if ($menu !== FALSE && !empty($menu)) {
            reset($menu);
            $permissionStatus = $this->_Registro->_Acl->Get_Permissao_Url('_Sistema/Admin/Menu_Status');
            $permissionEdit = $this->_Registro->_Acl->Get_Permissao_Url('_Sistema/Admin/Menus_Edit');
            $permissionDelete = $this->_Registro->_Acl->Get_Permissao_Url('_Sistema/Admin/Menus_Del');
            foreach ($menu as &$valor) {
                $table['Pai'][$i]          =  $valor->parent2;
                $table['#Gravidade'][$i]   = '#'.$valor->gravidade;
                $table['Nome'][$i]         = $valor->nome;
                $table['Link'][$i]         = $valor->link;
                $table['Img'][$i]          = $valor->img;
                $table['Icone'][$i]        = $valor->icon;
                if ($valor->status==1) {
                    $texto = __('Desativado');
                } else {
                    $texto = __('Ativado');
                }
                $table['Status'][$i]        = '<span id="status'.$valor->id.'">'.$this->_Visual->Tema_Elementos_Btn('Status'.$valor->status     ,Array($texto        ,'_Sistema/Admin/Menu_Status/'.$valor->id.'/'    , ''), $permissionStatus).'</span>';
            
                $table['Funções'][$i]      = $this->_Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Menu'        ,'_Sistema/Admin/Menus_Edit/'.$valor->id.'/'    , ''), $permissionEdit).
                                              $this->_Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Menu'       ,'_Sistema/Admin/Menus_Del/'.$valor->id.'/'     ,'Deseja realmente deletar esse Menu ? Isso irá afetar o sistema!'), $permissionDelete);
                ++$i;
            }
            if ($export !== FALSE && $export!=='Unico') {
                self::Export_Todos($export, $table, 'Menus');
            } else {
                $this->_Visual->Show_Tabela_DataTable(
                    $table,     // Array Com a Tabela
                    '',          // style extra
                    true,        // true -> Add ao Bloco, false => Retorna html
                    FALSE,        // Apagar primeira coluna ?
                    Array(       // Ordenacao
                        Array(
                            0,'desc'
                        )
                    )
                );
            }
            unset($table);
        } else {
            if ($export !== FALSE) {
                $mensagem = __('Nenhum Menu Cadastrado para exportar');
            } else {
                $mensagem = __('Nenhum Menu Cadastrado');
            }          
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">'.$mensagem.'</font></b></center>');
        }
        $titulo = __('Listagem de Menus').' ('.$i.')';
        if ($export==='Unico') {
            $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        } else if ($export==='Maior') {
            $this->_Visual->Bloco_Maior_CriaJanela($titulo);
        } else {
            $this->_Visual->Bloco_Menor_CriaJanela($titulo);
        }
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Administrar Menus'));
    }
    public function Menu_Status($id = FALSE) {
        if ($id === FALSE) {
            return FALSE;
        }
        $resultado = $this->_Modelo->db->Sql_Select('Sistema_Menu', Array('id'=>$id),1);
        if ($resultado === FALSE || !is_object($resultado)) {
            return FALSE;
        }
        if ($resultado->status==1 || $resultado->status=='1') {
            $resultado->status='0';
        } else {
            $resultado->status='1';
        }
        $sucesso = $this->_Modelo->db->Sql_Update($resultado);
        if ($sucesso) {
            if ($resultado->status==1 || $resultado->status=='1') {
                $texto = __('Ativado');
            } else {
                $texto = __('Desativado');
            }
            $conteudo = array(
                'location' => '#status'.$resultado->id,
                'js' => '',
                'html' =>  $this->_Visual->Tema_Elementos_Btn('Status'.$resultado->status     ,Array($texto        ,'_Sistema/Admin/Menu_Status/'.$resultado->id.'/'    , ''))
            );
            $this->_Visual->Json_IncluiTipo('Conteudo', $conteudo);
            $this->_Visual->Json_Info_Update('Titulo', __('Status Alterado')); 
        } else {
            $mensagens = array(
                "tipo"              => 'erro',
                "mgs_principal"     => __('Erro'),
                "mgs_secundaria"    => __('Ocorreu um Erro.')
            );
            $this->_Visual->Json_IncluiTipo('Mensagens', $mensagens);

            $this->_Visual->Json_Info_Update('Titulo', __('Erro')); 
        }
        $this->_Visual->Json_Info_Update('Historico', FALSE);  
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Menus_Add() {
        $this->Endereco_Admin_Menu();
        // Carrega Config
        $titulo1    = __('Adicionar Menu');
        $titulo2    = __('Salvar Menu');
        $formid     = 'form_Sistema_Admin_Menu';
        $formbt     = __('Salvar');
        $formlink   = '_Sistema/Admin/Menus_Add2/';
        $campos = Sistema_Menu_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1, $titulo2, $formlink, $formid, $formbt, $campos);
    }
    /**
     * 
     * 
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Menus_Add2() {
        $titulo     = __('Menu Adicionado com Sucesso');
        $dao        = 'Sistema_Menu';
        $function     = '$this->Menus();';
        $sucesso1   = __('Inserção bem sucedida');
        $sucesso2   = __('Menu cadastrado com sucesso.');
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo, $dao, $function, $sucesso1, $sucesso2, $alterar);
    }
    /**
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Menus_Edit($id) {
        $this->Endereco_Admin_Menu();
        // Carrega Config
        $titulo1    = 'Editar Menu (#'.$id.')';
        $titulo2    = __('Alteração de Menu');
        $formid     = 'form_Sistema_AdminC_MenuEdit';
        $formbt     = __('Alterar Menu');
        $formlink   = '_Sistema/Admin/Menus_Edit2/'.$id;
        $editar     = Array('Sistema_Menu', $id);
        $campos = Sistema_Menu_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1, $titulo2, $formlink, $formid, $formbt, $campos, $editar);   
    }
    /**
     * 
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Menus_Edit2($id) {
        $id = (int) $id;
        $titulo     = __('Menu Alterado com Sucesso');
        $dao        = Array('Sistema_Menu', $id);
        $function     = '$this->Menus();';
        $sucesso1   = __('Menu Alterado com Sucesso');
        $sucesso2   = ''.$_POST["nome"].' teve a alteração bem sucedida';
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo, $dao, $function, $sucesso1, $sucesso2, $alterar);
    }
    /**
     * 
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Menus_Del($id) {
        
        
    	$id = (int) $id;
        // Puxa menu e deleta
        $menu    =  $this->_Modelo->db->Sql_Select('Sistema_Menu', Array('id'=>$id));
        $sucesso =  $this->_Modelo->db->Sql_Delete($menu);
        // Mensagem
    	if ($sucesso === TRUE) {
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Deletado'),
                "mgs_secundaria" => __('Menu Deletado com sucesso')
            );
    	} else {
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Erro')
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens', $mensagens);
        
        $this->Menus();
        
        $this->_Visual->Json_Info_Update('Titulo', __('Menu deletado com Sucesso'));  
        $this->_Visual->Json_Info_Update('Historico', FALSE);  
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Configs($tipobloco='Unico') {
        $this->Endereco_Admin_Config(FALSE);
        
        $table_colunas[] = __('Chave');
        $table_colunas[] = __('Nome');
        $table_colunas[] = __('Valor');
        $table_colunas[] = __('Funções');

        $this->_Visual->Show_Tabela_DataTable_Massiva($table_colunas,'_Sistema/Admin/Configs');

        $titulo = __('Listagem de Configurações').' (<span id="DataTable_Contador">0</span>)';
        if ($tipobloco==='Unico') {
            $this->_Visual->Bloco_Unico_CriaJanela($titulo, '',10);
        } else if ($tipobloco==='Maior') {
            $this->_Visual->Bloco_Maior_CriaJanela($titulo, '',10);
        } else {
            $this->_Visual->Bloco_Menor_CriaJanela($titulo, '',10);
        }
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Administrar Configurações'));
    }
    /**
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Configs_Edit($id) {
        $this->Endereco_Admin_Config();
        // Carrega Config
        $titulo1    = __('Editar Configuração').' (#'.$id.')';
        $titulo2    = __('Alteração de Configuração');
        $formid     = 'form_Sistema_AdminC_ConfigEdit';
        $formbt     = __('Alterar Configuração');
        $formlink   = '_Sistema/Admin/Configs_Edit2/'.$id;
        $editar     = Array('Sistema_Config', $id);
        $campos = Sistema_Config_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1, $titulo2, $formlink, $formid, $formbt, $campos, $editar);   
    }
    /**
     * 
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Configs_Edit2($id) {
        $id = (int) $id;
        $titulo     = __('Configuração Alterada com Sucesso');
        $dao        = Array('Sistema_Config', $id);
        $function     = '$this->Configs();';
        $sucesso1   = __('Configuração Alterada com Sucesso');
        $sucesso2   = ''.$_POST["nome"].' teve a alteração bem sucedida';
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo, $dao, $function, $sucesso1, $sucesso2, $alterar);
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Permissoes($export='Unico') {
        $this->Endereco_Admin_Permissao(FALSE);
        $i = 0;
        $this->_Visual->Blocar($this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            Array(
                __('Adicionar Permissao'),
                '_Sistema/Admin/Permissoes_Add',
                ''
            ),
            Array(
                'Print'     => TRUE,
                'Pdf'       => TRUE,
                'Excel'     => TRUE,
                'Link'      => '_Sistema/Admin/Permissoes',
            )
        )));
        $permissao = $this->_Modelo->db->Sql_Select('Sistema_Permissao');
        if (is_object($permissao)) $permissao = Array(0=>$permissao);
        if ($permissao !== FALSE && !empty($permissao)) {
            reset($permissao);
            $permissionEdit = $this->_Registro->_Acl->Get_Permissao_Url('_Sistema/Admin/Permissoes_Edit');
            $permissionDelete = $this->_Registro->_Acl->Get_Permissao_Url('_Sistema/Admin/Permissoes_Del');
            foreach ($permissao as &$valor) {
                $table['Chave'][$i]        = $valor->chave;
                $table['Modulo'][$i]       = $valor->modulo;
                $table['SubModulo'][$i]    = $valor->submodulo;
                $table['Nome'][$i]         = $valor->nome;
                $table['Endereço'][$i]     = $valor->end;
                $table['Descrição'][$i]    = $valor->descricao;
                $table['Funções'][$i]      = $this->_Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Permissao'        ,'_Sistema/Admin/Permissoes_Edit/'.$valor->chave.'/'    , ''), $permissionEdit).
                                              $this->_Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Permissao'       ,'_Sistema/Admin/Permissoes_Del/'.$valor->chave.'/'     ,'Deseja realmente deletar essa Permissao ? Isso irá afetar o sistema!'), $permissionDelete);
                ++$i;
            }
            if ($export !== FALSE && $export!=='Unico') {
                self::Export_Todos($export, $table, 'Permissoes');
            } else {
                $this->_Visual->Show_Tabela_DataTable(
                    $table,     // Array Com a Tabela
                    '',          // style extra
                    true,        // true -> Add ao Bloco, false => Retorna html
                    FALSE,        // Apagar primeira coluna ?
                    Array(       // Ordenacao
                        Array(
                            0,'desc'
                        )
                    )
                );
            }
            unset($table);
        } else {
            if ($export !== FALSE) {
                $mensagem = __('Nenhuma Permissão Cadastrada para exportar');
            } else {
                $mensagem = __('Nenhuma Permissão Cadastrada');
            }   
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">'.$mensagem.'</font></b></center>');
        }
        $titulo = __('Listagem de Permissões').' ('.$i.')';
        if ($export==='Unico') {
            $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        } else if ($export==='Maior') {
            $this->_Visual->Bloco_Maior_CriaJanela($titulo);
        } else {
            $this->_Visual->Bloco_Menor_CriaJanela($titulo);
        }
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Administrar Permissões'));
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Permissoes_Add() {
        $this->Endereco_Admin_Permissao();
        // Carrega Config
        $titulo1    = __('Adicionar Permissão');
        $titulo2    = __('Salvar Permissão');
        $formid     = 'form_Sistema_Admin_Permissao';
        $formbt     = __('Salvar');
        $formlink   = '_Sistema/Admin/Permissoes_Add2/';
        $campos = Sistema_Permissao_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1, $titulo2, $formlink, $formid, $formbt, $campos);
    }
    /**
     * 
     * 
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Permissoes_Add2() {
        $titulo     = __('Permissão Adicionada com Sucesso');
        $dao        = 'Sistema_Permissao';
        $function     = '$this->Permissoes();';
        $sucesso1   = __('Inserção bem sucedida');
        $sucesso2   = __('Permissão cadastrada com sucesso.');
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo, $dao, $function, $sucesso1, $sucesso2, $alterar);
    }
    /**
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Permissoes_Edit($id) {
        $id         = \Framework\App\Conexao::anti_injection($id);
        $this->Endereco_Admin_Permissao();
        // Carrega Config
        $titulo1    = 'Editar Permissao (#'.$id.')';
        $titulo2    = __('Alteração de Permissao');
        $formid     = 'form_Sistema_AdminC_PermissaoEdit';
        $formbt     = __('Alterar Permissao');
        $formlink   = '_Sistema/Admin/Permissoes_Edit2/'.$id;
        $editar     = Array('Sistema_Permissao', $id);
        $campos = Sistema_Permissao_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1, $titulo2, $formlink, $formid, $formbt, $campos, $editar);   
    }
    /**
     * 
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Permissoes_Edit2($id) {
        $id         = \Framework\App\Conexao::anti_injection($id);
        $titulo     = __('Permissão Alterada com Sucesso');
        $dao        = Array('Sistema_Permissao', $id);
        $function     = '$this->Permissoes();';
        $sucesso1   = __('Permissão Alterada com Sucesso');
        $sucesso2   = ''.$_POST["nome"].' teve a alteração bem sucedida';
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo, $dao, $function, $sucesso1, $sucesso2, $alterar);
    }
    /**
     * 
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Permissoes_Del($id) {
        
        $id         = \Framework\App\Conexao::anti_injection($id);
        
        // Puxa permissao e deleta
        $permissao    =  $this->_Modelo->db->Sql_Select('Sistema_Permissao', Array('chave'=>$id));
        $sucesso =  $this->_Modelo->db->Sql_Delete($permissao);
        // Mensagem
    	if ($sucesso === TRUE) {
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Deletado'),
                "mgs_secundaria" => __('Permissão Deletada com sucesso')
            );
    	} else {
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Erro')
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens', $mensagens);
        
        $this->Permissoes();
        
        $this->_Visual->Json_Info_Update('Titulo', __('Permissão deletada com Sucesso'));  
        $this->_Visual->Json_Info_Update('Historico', FALSE);  
    }
    public function Grupos_Funcionarios() {
        $this->Grupos(CFG_TEC_CAT_ID_FUNCIONARIOS);
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Grupos($grupocat = FALSE, $export='Unico') {
        $this->Endereco_Admin_Grupo(FALSE);
        if ($grupocat === 'false') {
            $grupocat = FALSE;
        }
        if ($grupocat !== FALSE) {
            $where = Array('categoria'=>$grupocat);
        } else {
            $grupocat = 'false';
            $where = Array();
        }
        $i = 0;
        $this->_Visual->Blocar($this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            Array(
                __('Adicionar Grupo'),
                '_Sistema/Admin/Grupos_Add/'.$grupocat,
                ''
            ),
            Array(
                'Print'     => TRUE,
                'Pdf'       => TRUE,
                'Excel'     => TRUE,
                'Link'      => '_Sistema/Admin/Grupos/'.$grupocat,
            )
        )));
        $grupos = $this->_Modelo->db->Sql_Select('Sistema_Grupo', $where);
        if ($grupos == FALSE) {
            \Framework\App\Acl::grupos_inserir();
            $grupos = $this->_Modelo->db->Sql_Select('Sistema_Grupo');
        }
        $table = Array();
        if (is_object($grupos)) {
            $grupos = Array(0 => $grupos);
        }
        if ($grupos !== FALSE && !empty($grupos)) {
            reset($grupos);
            $permissionEdit = $this->_Registro->_Acl->Get_Permissao_Url('_Sistema/Admin/Grupos_Edit');
            $permissionDelete = $this->_Registro->_Acl->Get_Permissao_Url('_Sistema/Admin/Grupos_Del');
            foreach ($grupos as &$valor) {
                $num_usuarios = $this->_Modelo->db->query('SELECT id,nome'.
                        ' FROM '.MYSQL_USUARIOS.' WHERE servidor=\''.SRV_NAME_SQL.'\' AND grupo='.$valor->id.' AND deletado=0');
                $num_qnt      = $num_usuarios->num_rows;
                //while ($this->_Acl->logado_usuario = $query->fetch_object()) {
                // Procura Resultado
                $table['#Id'][$i]              = '#'.$valor->id;
                $table['Tipo de Grupo'][$i]    = $valor->categoria2;
                $table['Nome'][$i]             = '<a href="'.URL_PATH.'_Sistema/Admin/Grupo_Permissao/'.$valor->id.'" data-acao="" class="lajax">'.$valor->nome.'</a>';
                $table['Integrantes'][$i]      = $num_qnt;
                $table['Funções'][$i]          = $this->_Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Grupo'        ,'_Sistema/Admin/Grupos_Edit/'.$valor->id.'/'.$grupocat    , ''), $permissionEdit);
                if ($num_qnt===0) {
                    $table['Funções'][$i]          .= $this->_Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Grupo'       ,'_Sistema/Admin/Grupos_Del/'.$valor->id.'/'.$grupocat     ,'Deseja realmente deletar esse Grupo ? Isso irá afetar o sistema!'), $permissionDelete);
                }
                ++$i;
            }
            
            if ($export !== FALSE && $export!=='Unico') {
                self::Export_Todos($export, $table, 'Grupos');
            } else {
                $this->_Visual->Show_Tabela_DataTable($table);
            }
            unset($table);
        } else {
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhum Grupo</font></b></center>');
        }
        $titulo = __('Listagem de Grupos').' ('.$i.')';
        if ($export==='Unico') {
            $this->_Visual->Bloco_Unico_CriaJanela($titulo, '',60);
        } else if ($export==='Maior') {
            $this->_Visual->Bloco_Maior_CriaJanela($titulo, '',60);
        } else {
            $this->_Visual->Bloco_Menor_CriaJanela($titulo, '',60);
        }
        
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Administrar Grupos'));
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Grupos_Add($grupocat = FALSE) {
        $this->Endereco_Admin_Grupo();
        if ($grupocat === FALSE) {
            $grupocat = 'false';
        }
        // Carrega Config
        $titulo1    = __('Adicionar Grupo');
        $titulo2    = __('Salvar Grupo');
        $formid     = 'form_Sistema_Admin_Grupos';
        $formbt     = __('Salvar');
        $formlink   = '_Sistema/Admin/Grupos_Add2/'.$grupocat;
        $campos = Sistema_Grupo_DAO::Get_Colunas();
        self::DAO_Campos_Retira($campos, 'valor_mensalidade');
        self::DAO_Campos_Retira($campos, 'valor_matricula');
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1, $titulo2, $formlink, $formid, $formbt, $campos);
    
    }
    /**
     * 
     * 
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Grupos_Add2($grupocat = FALSE) {
        if ($grupocat === 'false') {
            $grupocat = FALSE;
        }
        $titulo     = __('Grupo Adicionado com Sucesso');
        $dao        = 'Sistema_Grupo';
        $function     = '$this->Grupos();';
        $sucesso1   = __('Inserção bem sucedida');
        $sucesso2   = __('Grupo cadastrado com sucesso.');
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo, $dao, $function, $sucesso1, $sucesso2, $alterar);
    }
    /**
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Grupos_Edit($id, $grupocat = FALSE) {
        $this->Endereco_Admin_Grupo();
        if ($grupocat === FALSE) {
            $grupocat = 'false';
        }
        // Carrega Config
        $titulo1    = 'Editar Grupo (#'.$id.')';
        $titulo2    = __('Alteração de Grupo');
        $formid     = 'form_Sistema_AdminC_GrupoEdit';
        $formbt     = __('Alterar Grupo');
        $formlink   = '_Sistema/Admin/Grupos_Edit2/'.$id.'/'.$grupocat;
        $editar     = Array('Sistema_Grupo', $id);
        $campos = Sistema_Grupo_DAO::Get_Colunas();
        self::DAO_Campos_Retira($campos, 'valor_mensalidade');
        self::DAO_Campos_Retira($campos, 'valor_matricula');
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1, $titulo2, $formlink, $formid, $formbt, $campos, $editar);   
    }
    /**
     * 
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Grupos_Edit2($id, $grupocat = FALSE) {
        if ($grupocat === FALSE) {
            $grupocat = 'false';
        }
        $titulo     = __('Grupo Editado com Sucesso');
        $dao        = Array('Sistema_Grupo', $id);
        $function     = '$this->Grupos('.$grupocat.');';
        $sucesso1   = __('Grupo Alterado com Sucesso.');
        $sucesso2   = ''.$_POST["nome"].' teve a alteração bem sucedida';
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo, $dao, $function, $sucesso1, $sucesso2, $alterar);   
    }
    /**
     * 
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Grupos_Del($id, $grupocat = FALSE) {
        
        if ($grupocat === 'false') {
            $grupocat = FALSE;
        }

        $id = (int) $id;
        // Puxa grupo e deleta
        $grupo = $this->_Modelo->db->Sql_Select('Sistema_Grupo', Array('id'=>$id));
        $sucesso =  $this->_Modelo->db->Sql_Delete($grupo);
        // Mensagem
    	if ($sucesso === TRUE) {
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Deletado'),
                "mgs_secundaria" => __('Grupo Deletado com sucesso')
            );
    	} else {
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Erro')
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens', $mensagens);
        
        $this->Grupos($grupocat);
        
        $this->_Visual->Json_Info_Update('Titulo', __('Grupo deletado com Sucesso'));  
        $this->_Visual->Json_Info_Update('Historico', FALSE);  
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Grupo_Permissao($grupo = FALSE, $bloco='Unico') {
        $i = 0;
        if ($grupo === FALSE) {
            $botao_titulo  = __('Adicionar Permissão de Grupo');
            $aviso_nenhuma = __('Nenhuma permissão de Nenhum Grupo');
            $botao_extra   = '';
            $where = Array();
        } else {
            $botao_titulo  = __('Adicionar Permissão ao Grupo');
            $aviso_nenhuma = __('Nenhuma permissão do Grupo');
            $botao_extra   = '/'.$grupo;
            $where = Array('grupo'=>$grupo);
        }
        // BOTAO IMPRIMIR / ADD
        $this->_Visual->Blocar($this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            Array(
                $botao_titulo,
                '_Sistema/Admin/Grupo_Permissao_Add'.$botao_extra,
                ''
            ),
            Array(
                'Print'     => TRUE,
                'Pdf'       => TRUE,
                'Excel'     => TRUE,
                'Link'      => '_Sistema/Admin/Grupo_Permissao'.$botao_extra,
            )
        )));
        // CONEXAO
        $table = Array();
        $grupopermissaos = $this->_Modelo->db->Sql_Select('Sistema_Grupo_Permissao', $where);
        if (is_object($grupopermissaos)) $grupopermissaos = Array(0=>$grupopermissaos);
        if ($grupopermissaos !== FALSE && !empty($grupopermissaos)) {
            reset($grupopermissaos);
            $permissionEdit = $this->_Registro->_Acl->Get_Permissao_Url('_Sistema/Admin/Grupo_Permissao_Edit');
            $permissionDelete = $this->_Registro->_Acl->Get_Permissao_Url('_Sistema/Admin/Grupo_Permissao_Del');
            foreach ($grupopermissaos as &$valor) {
                $table['#Id'][$i]          = '#'.$valor->id;
                $table['Grupo'][$i]        = $valor->grupo2;
                $table['Permissão'][$i]    = $valor->permissao2;
                $table['Valor'][$i]        = $valor->valor;
                $table['Funções'][$i]      =  $this->_Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Permissão de Grupo'        ,'_Sistema/Admin/Grupo_Permissao_Edit/'.$valor->id.'/'    , ''), $permissionEdit);
                $table['Funções'][$i]  .= $this->_Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Permissão de Grupo'       ,'_Sistema/Admin/Grupo_Permissao_Del/'.$valor->id.'/'     ,__('Deseja realmente deletar essa Permissão de Grupo ? Isso irá afetar o sistema!')), $permissionDelete);
                ++$i;
            }
            $this->_Visual->Show_Tabela_DataTable($table);
            unset($table);
        } else { 
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">'.$aviso_nenhuma.'</font></b></center>');
        }
        $titulo = __('Listagem de Permissão de Grupo').' ('.$i.')';
        if ($bloco==='Unico') {
            $this->_Visual->Bloco_Unico_CriaJanela($titulo, '',50);
        } else if ($bloco==='Maior') {
            $this->_Visual->Bloco_Maior_CriaJanela($titulo, '',50);
        } else {
            $this->_Visual->Bloco_Menor_CriaJanela($titulo, '',50);
        }
        
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Administrar Permissões de Grupos'));
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Grupo_Permissao_Add($grupo = FALSE) {
        // Carrega Config
        $titulo1    = __('Adicionar Permissão de Grupo');
        $titulo2    = __('Cadastro de Permissão de Grupo');
        $formid     = 'form_Sistema_Admin_Grupo_Permissao_Add';
        $formbt     = __('Salvar');
        if ($grupo !== FALSE) {
            $campos = Sistema_Grupo_Permissao_DAO::Get_Colunas();
            $extra = '/'.$grupo;
            self::DAO_Campos_Retira($campos, 'grupo');
        } else {
            $campos = Sistema_Grupo_Permissao_DAO::Get_Colunas();
            $extra = '';
        }
        $formlink   = '_Sistema/Admin/Grupo_Permissao_Add2/'.$extra;
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1, $titulo2, $formlink, $formid, $formbt, $campos);
    }
    /**
     * 
     * 
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Grupo_Permissao_Add2($grupo = FALSE) {
        // Verifica se Ja possui Antes de Inserir
        $titulo     = __('Permissão de Grupo Adicionado com Sucesso');
        $dao        = 'Sistema_Grupo_Permissao';
        $function     = '$this->Grupo_Permissao();';
        $sucesso1   = __('Inserção bem sucedida');
        $sucesso2   = __('Permissão de Grupo Adicionado com Sucesso');
        
        if ($grupo !== FALSE) {
            $alterar = ['grupo' => $grupo];
        }
        $this->Gerador_Formulario_Janela2($titulo, $dao, $function, $sucesso1, $sucesso2, $alterar);
    }
    /**
     * 
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Grupo_Permissao_Del($id) {
        // Puxa grupo e deleta
        $grupopermissao = $this->_Modelo->db->Sql_Select('Sistema_Grupo_Permissao', Array('id'=>(int) $id));
        $sucesso =  $this->_Modelo->db->Sql_Delete($grupopermissao);
        // Mensagem
    	if ($sucesso === TRUE) {
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Deletado'),
                "mgs_secundaria" => __('Permissão de Grupo Deletado com sucesso')
            );
    	} else {
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Erro')
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens', $mensagens);
        
        $this->Grupo_Permissao();
        
        $this->_Visual->Json_Info_Update('Titulo', __('Permissão de Grupo deletado com Sucesso'));  
        $this->_Visual->Json_Info_Update('Historico', FALSE);  
    }
    public function Newsletter($export='Unico') {
        $i = 0;
        $this->_Visual->Blocar($this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            Array(
                __('Adicionar Newsletter'),
                '_Sistema/Admin/Newsletter_Add',
                ''
            ),
            Array(
                'Print'     => TRUE,
                'Pdf'       => TRUE,
                'Excel'     => TRUE,
                'Link'      => '_Sistema/Admin/Newsletter',
            )
        )));
        $grupopermissaos = $this->_Modelo->db->Sql_Select('Sistema_Newsletter');
        if (is_object($grupopermissaos)) {
            $grupopermissaos = Array(0 => $grupopermissaos);
        }
        if ($grupopermissaos !== FALSE && !empty($grupopermissaos)) {
            reset($grupopermissaos);
            $permissionEdit = $this->_Registro->_Acl->Get_Permissao_Url('_Sistema/Admin/Newsletter_Edit');
            $permissionDelete = $this->_Registro->_Acl->Get_Permissao_Url('_Sistema/Admin/Newsletter_Del');
            foreach ($grupopermissaos as &$valor) {
                $table['Id'][$i]           = $valor->id;
                $table['Nome'][$i]         = $valor->nome;
                $table['Email'][$i]        = $valor->email;
                if ($valor->tipo==1) {
                    $table['Tipo'][$i]     = __('Newsletter');
                } else if ($valor->tipo==2) {
                    $table['Tipo'][$i]     = __('Contato');
                } else if ($valor->tipo==3) {
                    $table['Tipo'][$i]     = __('Trabalhe Conosco');                    
                }
                $table['Estado'][$i]       = $valor->estado;
                $table['Linguagem'][$i]    = $valor->lang;
                $table['Funções'][$i]      = $this->_Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Newsletter'        ,'_Sistema/Admin/Newsletter_Edit/'.$valor->id.'/'    , ''), $permissionEdit).
                                              $this->_Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Newsletter'       ,'_Sistema/Admin/Newsletter_Del/'.$valor->id.'/'     ,'Deseja realmente deletar essa Newsletter ? Isso irá afetar o sistema!'), $permissionDelete);
                ++$i;
            }
            if ($export !== FALSE && $export!=='Unico') {
                self::Export_Todos($export, $table, 'Newsletter');
            } else {
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
            if ($export !== FALSE) {
                $mensagem = __('Nenhuma Newsletter para Exportar');
            } else {
                $mensagem = __('Nenhuma Newsletter');
            }            
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">'.$mensagem.'</font></b></center>');
        }
        $titulo = __('Listagem de Newsletter').' ('.$i.')';
        if ($export==='Unico') {
            $this->_Visual->Bloco_Unico_CriaJanela($titulo, '',40);
        } else if ($export==='Maior') {
            $this->_Visual->Bloco_Maior_CriaJanela($titulo, '',40);
        } else {
            $this->_Visual->Bloco_Menor_CriaJanela($titulo, '',40);
        }
        
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Administrar Newsletters'));
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Newsletter_Add() {
        // Carrega campos e retira os que nao precisam
        $campos = Sistema_Newsletter_DAO::Get_Colunas();
        self::DAO_Campos_Retira($campos, 'valor_mensalidade');
        self::DAO_Campos_Retira($campos, 'valor_matricula');
        // Carrega formulario
        $form = new \Framework\Classes\Form('form_Sistema_Admin_Newsletter', '_Sistema/Admin/Newsletter_Add2/', 'formajax');
        \Framework\App\Controle::Gerador_Formulario($campos, $form);
        $formulario = $form->retorna_form('Cadastrar');
        $this->_Visual->Blocar($formulario);
        // Mostra Conteudo
        $this->_Visual->Bloco_Unico_CriaJanela(__('Cadastro de Newsletter'));
        // Pagina Config
        $this->_Visual->Json_Info_Update('Titulo', __('Adicionar Newsletter'));
    }
    /**
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Newsletter_Edit($id) {
        $id = (int) $id;
        // Carrega campos e retira os que nao precisam
        $campos = Sistema_Newsletter_DAO::Get_Colunas();
        self::DAO_Campos_Retira($campos, 'valor_mensalidade');
        self::DAO_Campos_Retira($campos, 'valor_matricula');
        // recupera grupo
        $grupopermissao = $this->_Modelo->db->Sql_Select('Sistema_Newsletter', Array('id'=>$id));
        self::mysql_AtualizaValores($campos, $grupopermissao);

        // edicao de grupos
        $form = new \Framework\Classes\Form('form_Sistema_AdminC_GrupoEdit', '_Sistema/Admin/Newsletter_Edit2/'.$id.'/', 'formajax');
        \Framework\App\Controle::Gerador_Formulario($campos, $form);
        $formulario = $form->retorna_form('Alterar Newsletter');
        $this->_Visual->Blocar($formulario);
        $this->_Visual->Bloco_Unico_CriaJanela(__('Alteração de Newsletter'));
        // Json
        $this->_Visual->Json_Info_Update('Titulo', 'Editar Newsletter (#'.$id.')');
        
    }
    /**
     * 
     * 
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Newsletter_Add2() {
        
        
        // Cria novo Grupo
        $grupopermissao = new Sistema_Newsletter_DAO;
        self::mysql_AtualizaValores($grupopermissao);
        $sucesso =  $this->_Modelo->db->Sql_Insert($grupopermissao);
        
        // Recarrega Newsletter
        $this->Newsletter();  
        
        // Mostra Mensagem de Sucesso
        if ($sucesso === TRUE) {
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Inserção bem sucedida'),
                "mgs_secundaria" => __('Newsletter cadastrado com sucesso.')
            ); 
        } else {
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Erro')
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens', $mensagens);
        // Json
        $this->_Visual->Json_Info_Update('Titulo', __('Newsletter Adicionado com Sucesso'));  
        $this->_Visual->Json_Info_Update('Historico', FALSE);  
    }
    /**
     * 
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Newsletter_Edit2($id) {
        
        $id = (int) $id;
        // Puxa o grupo, e altera seus valores, depois salva novamente
        $grupopermissao = $this->_Modelo->db->Sql_Select('Sistema_Newsletter', Array('id'=>$id));
        self::mysql_AtualizaValores($grupopermissao);
        $sucesso =  $this->_Modelo->db->Sql_Update($grupopermissao);
        // Atualiza
        $this->Newsletter();
        // Mensagem
        if ($sucesso === TRUE) {
            $mensagens = array(
                "tipo"              => 'sucesso',
                "mgs_principal"     => __('Newsletter Alterado com Sucesso'),
                "mgs_secundaria"    => ''.$_POST["nome"].' teve a alteração bem sucedida'
            );
        } else {
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Erro')
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens', $mensagens);  
        //Json
        $this->_Visual->Json_Info_Update('Titulo', __('Newsletter Editado com Sucesso'));  
        $this->_Visual->Json_Info_Update('Historico', FALSE);    
    }
    /**
     * 
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Newsletter_Del($id) {
        
        
    	$id = (int) $id;
        // Puxa grupo e deleta
        $grupopermissao = $this->_Modelo->db->Sql_Select('Sistema_Newsletter', Array('id'=>$id));
        $sucesso =  $this->_Modelo->db->Sql_Delete($grupopermissao);
        // Mensagem
    	if ($sucesso === TRUE) {
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Deletado'),
                "mgs_secundaria" => __('Newsletter Deletado com sucesso')
            );
    	} else {
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Erro')
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens', $mensagens);
        
        $this->Newsletter();
        
        $this->_Visual->Json_Info_Update('Titulo', __('Newsletter deletado com Sucesso'));  
        $this->_Visual->Json_Info_Update('Historico', FALSE);  
    }
    /**
     * 
     * @param type $true
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    function Endereco_Admin($true= TRUE ) {
        $titulo = __('Administração Geral');
        $link = '_Sistema/Admin/Main';
        if ($true === TRUE) {
            $this->Tema_Endereco($titulo, $link);
        } else {
            $this->Tema_Endereco($titulo);
        }
    }
    /**
     * 
     * @param type $true
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    function Endereco_Admin_Permissao($true= TRUE ) {
        self::Endereco_Admin();
        $titulo = __('Permissões do Sistema');
        $link = '_Sistema/Admin/Permissoes';
        if ($true === TRUE) {
            $this->Tema_Endereco($titulo, $link);
        } else {
            $this->Tema_Endereco($titulo);
        }
    }
    /**
     * Configura as Configuracoes Publicas
     * @param type $true
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    function Endereco_Admin_Config($true= TRUE ) {
        self::Endereco_Admin();
        $titulo = __('Permissões do Sistema');
        $link = '_Sistema/Admin/Permissoes';
        if ($true === TRUE) {
            $this->Tema_Endereco($titulo, $link);
        } else {
            $this->Tema_Endereco($titulo);
        }
    }
    /**
     * 
     * @param type $true
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    function Endereco_Admin_Menu($true= TRUE ) {
        $this->Endereco_Admin();
        $titulo = __('Menus do Sistema');
        $link = '_Sistema/Admin/Menus';
        if ($true === TRUE) {
            $this->Tema_Endereco($titulo, $link);
        } else {
            $this->Tema_Endereco($titulo);
        }
    }
    /**
     * 
     * @param type $true
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    function Endereco_Admin_Grupo($true= TRUE ) {
        $this->Endereco_Admin();
        $titulo = __('Grupos do Sistema');
        $link = '_Sistema/Admin/Grupos';
        if ($true === TRUE) {
            $this->Tema_Endereco($titulo, $link);
        } else {
            $this->Tema_Endereco($titulo);
        }
    }
}
?>
