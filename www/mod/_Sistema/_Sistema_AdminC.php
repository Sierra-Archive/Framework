<?php

class _Sistema_AdminControle extends _Sistema_Controle
{
    public function __construct(){
        parent::__construct();
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Main(){
        // Chama Widgets
        $this->AdminWidgets();
        \Framework\App\Visual::Layoult_Home_Widgets_Show();
        
        // Grupo, Configs, Permissoes e Menuys
        $this->Grupos(false,'Menor');
        $this->Configs(false,'Menor');
        $this->Permissoes('Maior');
        $this->Menus('Maior');
        
        // remove indice de menus
        $this->Tema_Endereco_Zerar();
        // Add denovo
        $this->Endereco_Admin(false);
        
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Administração Avançada'));
    }
    public function AdminWidgets(){
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
            false, 
            20
        );
        \Framework\App\Visual::Layoult_Home_Widgets_Add(
            'Menu', 
            '_Sistema/Admin/Menus', 
            'tag', 
            $menu_qnt, 
            'block-green', 
            false, 
            10
        );
        \Framework\App\Visual::Layoult_Home_Widgets_Add(
            'Configurações', 
            '_Sistema/Admin/Configs', 
            'tag', 
            $config_qnt, 
            'block-green', 
            false, 
            10
        );
        \Framework\App\Visual::Layoult_Home_Widgets_Add(
            'Permissões', 
            '_Sistema/Admin/Permissao', 
            'tag', 
            $permissao_qnt, 
            'nav-olive', 
            false, 
            8
        );
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Menus($export='Unico'){
        $this->Endereco_Admin_Menu(false);
        $i = 0;
        $this->_Visual->Blocar($this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            Array(
                __('Adicionar Menu'),
                '_Sistema/Admin/Menus_Add',
                ''
            ),
            Array(
                'Print'     => true,
                'Pdf'       => true,
                'Excel'     => true,
                'Link'      => '_Sistema/Admin/Menus',
            )
        )));
        $menu = $this->_Modelo->db->Sql_Select('Sistema_Menu');
        if(is_object($menu)) $menu = Array(0=>$menu);
        if($menu!==false && !empty($menu)){
            reset($menu);
            $perm_status = $this->_Registro->_Acl->Get_Permissao_Url('_Sistema/Admin/Menu_Status');
            $perm_editar = $this->_Registro->_Acl->Get_Permissao_Url('_Sistema/Admin/Menus_Edit');
            $perm_del = $this->_Registro->_Acl->Get_Permissao_Url('_Sistema/Admin/Menus_Del');
            foreach ($menu as &$valor) {
                $tabela['Pai'][$i]          =  $valor->parent2;
                $tabela['#Gravidade'][$i]   = '#'.$valor->gravidade;
                $tabela['Nome'][$i]         = $valor->nome;
                $tabela['Link'][$i]         = $valor->link;
                $tabela['Img'][$i]          = $valor->img;
                $tabela['Icone'][$i]        = $valor->icon;
                if($valor->status==1){
                    $texto = __('Desativado');
                }else{
                    $texto = __('Ativado');
                }
                $tabela['Status'][$i]        = '<span id="status'.$valor->id.'">'.$this->_Visual->Tema_Elementos_Btn('Status'.$valor->status     ,Array($texto        ,'_Sistema/Admin/Menu_Status/'.$valor->id.'/'    ,''),$perm_status).'</span>';
            
                $tabela['Funções'][$i]      = $this->_Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Menu'        ,'_Sistema/Admin/Menus_Edit/'.$valor->id.'/'    ,''),$perm_editar).
                                              $this->_Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Menu'       ,'_Sistema/Admin/Menus_Del/'.$valor->id.'/'     ,'Deseja realmente deletar esse Menu ? Isso irá afetar o sistema!'),$perm_del);
                ++$i;
            }
            if($export!==false && $export!=='Unico'){
                self::Export_Todos($export,$tabela, 'Menus');
            }else{
                $this->_Visual->Show_Tabela_DataTable(
                    $tabela,     // Array Com a Tabela
                    '',          // style extra
                    true,        // true -> Add ao Bloco, false => Retorna html
                    false,        // Apagar primeira coluna ?
                    Array(       // Ordenacao
                        Array(
                            0,'desc'
                        )
                    )
                );
            }
            unset($tabela);
        }else{
            if($export!==false){
                $mensagem = __('Nenhum Menu Cadastrado para exportar');
            }else{
                $mensagem = __('Nenhum Menu Cadastrado');
            }          
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">'.$mensagem.'</font></b></center>');
        }
        $titulo = __('Listagem de Menus').' ('.$i.')';
        if($export==='Unico'){
            $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        }else if($export==='Maior'){
            $this->_Visual->Bloco_Maior_CriaJanela($titulo);
        }else{
            $this->_Visual->Bloco_Menor_CriaJanela($titulo);
        }
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Administrar Menus'));
    }
    public function Menu_Status($id=false){
        if($id===false){
            return false;
        }
        $resultado = $this->_Modelo->db->Sql_Select('Sistema_Menu', Array('id'=>$id),1);
        if($resultado===false || !is_object($resultado)){
            return false;
        }
        if($resultado->status==1 || $resultado->status=='1'){
            $resultado->status='0';
        }else{
            $resultado->status='1';
        }
        $sucesso = $this->_Modelo->db->Sql_Update($resultado);
        if($sucesso){
            if($resultado->status==1 || $resultado->status=='1'){
                $texto = __('Ativado');
            }else{
                $texto = __('Desativado');
            }
            $conteudo = array(
                'location' => '#status'.$resultado->id,
                'js' => '',
                'html' =>  $this->_Visual->Tema_Elementos_Btn('Status'.$resultado->status     ,Array($texto        ,'_Sistema/Admin/Menu_Status/'.$resultado->id.'/'    ,''))
            );
            $this->_Visual->Json_IncluiTipo('Conteudo',$conteudo);
            $this->_Visual->Json_Info_Update('Titulo', __('Status Alterado')); 
        }else{
            $mensagens = array(
                "tipo"              => 'erro',
                "mgs_principal"     => __('Erro'),
                "mgs_secundaria"    => __('Ocorreu um Erro.')
            );
            $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);

            $this->_Visual->Json_Info_Update('Titulo', __('Erro')); 
        }
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Menus_Add(){
        $this->Endereco_Admin_Menu();
        // Carrega Config
        $titulo1    = __('Adicionar Menu');
        $titulo2    = __('Salvar Menu');
        $formid     = 'form_Sistema_Admin_Menu';
        $formbt     = __('Salvar');
        $formlink   = '_Sistema/Admin/Menus_Add2/';
        $campos = Sistema_Menu_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos);
    }
    /**
     * 
     * 
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Menus_Add2(){
        $titulo     = __('Menu Adicionado com Sucesso');
        $dao        = 'Sistema_Menu';
        $funcao     = '$this->Menus();';
        $sucesso1   = __('Inserção bem sucedida');
        $sucesso2   = __('Menu cadastrado com sucesso.');
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);
    }
    /**
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Menus_Edit($id){
        $this->Endereco_Admin_Menu();
        // Carrega Config
        $titulo1    = 'Editar Menu (#'.$id.')';
        $titulo2    = __('Alteração de Menu');
        $formid     = 'form_Sistema_AdminC_MenuEdit';
        $formbt     = __('Alterar Menu');
        $formlink   = '_Sistema/Admin/Menus_Edit2/'.$id;
        $editar     = Array('Sistema_Menu',$id);
        $campos = Sistema_Menu_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos,$editar);   
    }
    /**
     * 
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Menus_Edit2($id){
        $id = (int) $id;
        $titulo     = __('Menu Alterado com Sucesso');
        $dao        = Array('Sistema_Menu',$id);
        $funcao     = '$this->Menus();';
        $sucesso1   = __('Menu Alterado com Sucesso');
        $sucesso2   = ''.$_POST["nome"].' teve a alteração bem sucedida';
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);
    }
    /**
     * 
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Menus_Del($id){
        
        
    	$id = (int) $id;
        // Puxa menu e deleta
        $menu    =  $this->_Modelo->db->Sql_Select('Sistema_Menu', Array('id'=>$id));
        $sucesso =  $this->_Modelo->db->Sql_Delete($menu);
        // Mensagem
    	if($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Deletado'),
                "mgs_secundaria" => __('Menu Deletado com sucesso')
            );
    	}else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Erro')
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        
        $this->Menus();
        
        $this->_Visual->Json_Info_Update('Titulo', __('Menu deletado com Sucesso'));  
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Configs($tipobloco='Unico'){
        $this->Endereco_Admin_Config(false);
        
        $tabela_colunas[] = __('Chave');
        $tabela_colunas[] = __('Nome');
        $tabela_colunas[] = __('Valor');
        $tabela_colunas[] = __('Funções');

        $this->_Visual->Show_Tabela_DataTable_Massiva($tabela_colunas,'_Sistema/Admin/Configs');

        $titulo = __('Listagem de Configurações').' (<span id="DataTable_Contador">0</span>)';
        if($tipobloco==='Unico'){
            $this->_Visual->Bloco_Unico_CriaJanela($titulo,'',10);
        }else if($tipobloco==='Maior'){
            $this->_Visual->Bloco_Maior_CriaJanela($titulo,'',10);
        }else{
            $this->_Visual->Bloco_Menor_CriaJanela($titulo,'',10);
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
    public function Configs_Edit($id){
        $this->Endereco_Admin_Config();
        // Carrega Config
        $titulo1    = __('Editar Configuração').' (#'.$id.')';
        $titulo2    = __('Alteração de Configuração');
        $formid     = 'form_Sistema_AdminC_ConfigEdit';
        $formbt     = __('Alterar Configuração');
        $formlink   = '_Sistema/Admin/Configs_Edit2/'.$id;
        $editar     = Array('Sistema_Config',$id);
        $campos = Sistema_Config_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos,$editar);   
    }
    /**
     * 
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Configs_Edit2($id){
        $id = (int) $id;
        $titulo     = __('Configuração Alterada com Sucesso');
        $dao        = Array('Sistema_Config',$id);
        $funcao     = '$this->Configs();';
        $sucesso1   = __('Configuração Alterada com Sucesso');
        $sucesso2   = ''.$_POST["nome"].' teve a alteração bem sucedida';
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Permissoes($export='Unico'){
        $this->Endereco_Admin_Permissao(false);
        $i = 0;
        $this->_Visual->Blocar($this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            Array(
                __('Adicionar Permissao'),
                '_Sistema/Admin/Permissoes_Add',
                ''
            ),
            Array(
                'Print'     => true,
                'Pdf'       => true,
                'Excel'     => true,
                'Link'      => '_Sistema/Admin/Permissoes',
            )
        )));
        $permissao = $this->_Modelo->db->Sql_Select('Sistema_Permissao');
        if(is_object($permissao)) $permissao = Array(0=>$permissao);
        if($permissao!==false && !empty($permissao)){
            reset($permissao);
            $perm_editar = $this->_Registro->_Acl->Get_Permissao_Url('_Sistema/Admin/Permissoes_Edit');
            $perm_del = $this->_Registro->_Acl->Get_Permissao_Url('_Sistema/Admin/Permissoes_Del');
            foreach ($permissao as &$valor) {
                $tabela['Chave'][$i]        = $valor->chave;
                $tabela['Modulo'][$i]       = $valor->modulo;
                $tabela['SubModulo'][$i]    = $valor->submodulo;
                $tabela['Nome'][$i]         = $valor->nome;
                $tabela['Endereço'][$i]     = $valor->end;
                $tabela['Descrição'][$i]    = $valor->descricao;
                $tabela['Funções'][$i]      = $this->_Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Permissao'        ,'_Sistema/Admin/Permissoes_Edit/'.$valor->chave.'/'    ,''),$perm_editar).
                                              $this->_Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Permissao'       ,'_Sistema/Admin/Permissoes_Del/'.$valor->chave.'/'     ,'Deseja realmente deletar essa Permissao ? Isso irá afetar o sistema!'),$perm_del);
                ++$i;
            }
            if($export!==false && $export!=='Unico'){
                self::Export_Todos($export,$tabela, 'Permissoes');
            }else{
                $this->_Visual->Show_Tabela_DataTable(
                    $tabela,     // Array Com a Tabela
                    '',          // style extra
                    true,        // true -> Add ao Bloco, false => Retorna html
                    false,        // Apagar primeira coluna ?
                    Array(       // Ordenacao
                        Array(
                            0,'desc'
                        )
                    )
                );
            }
            unset($tabela);
        }else{
            if($export!==false){
                $mensagem = __('Nenhuma Permissão Cadastrada para exportar');
            }else{
                $mensagem = __('Nenhuma Permissão Cadastrada');
            }   
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">'.$mensagem.'</font></b></center>');
        }
        $titulo = __('Listagem de Permissões').' ('.$i.')';
        if($export==='Unico'){
            $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        }else if($export==='Maior'){
            $this->_Visual->Bloco_Maior_CriaJanela($titulo);
        }else{
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
    public function Permissoes_Add(){
        $this->Endereco_Admin_Permissao();
        // Carrega Config
        $titulo1    = __('Adicionar Permissão');
        $titulo2    = __('Salvar Permissão');
        $formid     = 'form_Sistema_Admin_Permissao';
        $formbt     = __('Salvar');
        $formlink   = '_Sistema/Admin/Permissoes_Add2/';
        $campos = Sistema_Permissao_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos);
    }
    /**
     * 
     * 
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Permissoes_Add2(){
        $titulo     = __('Permissão Adicionada com Sucesso');
        $dao        = 'Sistema_Permissao';
        $funcao     = '$this->Permissoes();';
        $sucesso1   = __('Inserção bem sucedida');
        $sucesso2   = __('Permissão cadastrada com sucesso.');
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);
    }
    /**
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Permissoes_Edit($id){
        $id         = \Framework\App\Conexao::anti_injection($id);
        $this->Endereco_Admin_Permissao();
        // Carrega Config
        $titulo1    = 'Editar Permissao (#'.$id.')';
        $titulo2    = __('Alteração de Permissao');
        $formid     = 'form_Sistema_AdminC_PermissaoEdit';
        $formbt     = __('Alterar Permissao');
        $formlink   = '_Sistema/Admin/Permissoes_Edit2/'.$id;
        $editar     = Array('Sistema_Permissao',$id);
        $campos = Sistema_Permissao_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos,$editar);   
    }
    /**
     * 
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Permissoes_Edit2($id){
        $id         = \Framework\App\Conexao::anti_injection($id);
        $titulo     = __('Permissão Alterada com Sucesso');
        $dao        = Array('Sistema_Permissao',$id);
        $funcao     = '$this->Permissoes();';
        $sucesso1   = __('Permissão Alterada com Sucesso');
        $sucesso2   = ''.$_POST["nome"].' teve a alteração bem sucedida';
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);
    }
    /**
     * 
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Permissoes_Del($id){
        
        $id         = \Framework\App\Conexao::anti_injection($id);
        
        // Puxa permissao e deleta
        $permissao    =  $this->_Modelo->db->Sql_Select('Sistema_Permissao', Array('chave'=>$id));
        $sucesso =  $this->_Modelo->db->Sql_Delete($permissao);
        // Mensagem
    	if($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Deletado'),
                "mgs_secundaria" => __('Permissão Deletada com sucesso')
            );
    	}else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Erro')
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        
        $this->Permissoes();
        
        $this->_Visual->Json_Info_Update('Titulo', __('Permissão deletada com Sucesso'));  
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
    public function Grupos_Funcionarios(){
        $this->Grupos(CFG_TEC_CAT_ID_FUNCIONARIOS);
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Grupos($grupocat = false,$export='Unico'){
        $this->Endereco_Admin_Grupo(false);
        if($grupocat==='false') $grupocat = false;
        if($grupocat!==false){
            $where = Array('categoria'=>$grupocat);
        }else{
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
                'Print'     => true,
                'Pdf'       => true,
                'Excel'     => true,
                'Link'      => '_Sistema/Admin/Grupos/'.$grupocat,
            )
        )));
        $grupos = $this->_Modelo->db->Sql_Select('Sistema_Grupo',$where);
        if($grupos==false){
            \Framework\App\Acl::grupos_inserir();
            $grupos = $this->_Modelo->db->Sql_Select('Sistema_Grupo');
        }
        if(is_object($grupos)) $grupos = Array(0=>$grupos);
        if($grupos!==false && !empty($grupos)){
            reset($grupos);
            $perm_editar = $this->_Registro->_Acl->Get_Permissao_Url('_Sistema/Admin/Grupos_Edit');
            $perm_del = $this->_Registro->_Acl->Get_Permissao_Url('_Sistema/Admin/Grupos_Del');
            foreach ($grupos as $indice=>&$valor) {
                $num_usuarios = $this->_Modelo->db->query('SELECT id,nome'.
                        ' FROM '.MYSQL_USUARIOS.' WHERE servidor=\''.SRV_NAME_SQL.'\' AND grupo='.$valor->id.' AND deletado=0');
                $num_qnt      = $num_usuarios->num_rows;
                //while($this->_Acl->logado_usuario = $query->fetch_object()){
                // Procura Resultado
                $tabela['#Id'][$i]              = '#'.$valor->id;
                $tabela['Tipo de Grupo'][$i]    = $valor->categoria2;
                $tabela['Nome'][$i]             = '<a href="'.URL_PATH.'_Sistema/Admin/Grupo_Permissao/'.$valor->id.'" acao="" class="lajax">'.$valor->nome.'</a>';
                $tabela['Integrantes'][$i]      = $num_qnt;
                $tabela['Funções'][$i]          = $this->_Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Grupo'        ,'_Sistema/Admin/Grupos_Edit/'.$valor->id.'/'.$grupocat    ,''),$perm_editar);
                if($num_qnt===0){
                    $tabela['Funções'][$i]          .= $this->_Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Grupo'       ,'_Sistema/Admin/Grupos_Del/'.$valor->id.'/'.$grupocat     ,'Deseja realmente deletar esse Grupo ? Isso irá afetar o sistema!'),$perm_del);
                }
                ++$i;
            }
            
            if($export!==false && $export!=='Unico'){
                self::Export_Todos($export,$tabela, 'Grupos');
            }else{
                $this->_Visual->Show_Tabela_DataTable($tabela);
            }
            unset($tabela);
        }else{            
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhum Grupo</font></b></center>');
        }
        $titulo = __('Listagem de Grupos').' ('.$i.')';
        if($export==='Unico'){
            $this->_Visual->Bloco_Unico_CriaJanela($titulo,'',60);
        }else if($export==='Maior'){
            $this->_Visual->Bloco_Maior_CriaJanela($titulo,'',60);
        }else{
            $this->_Visual->Bloco_Menor_CriaJanela($titulo,'',60);
        }
        
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Administrar Grupos'));
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Grupos_Add($grupocat = false){
        $this->Endereco_Admin_Grupo();
        if($grupocat===false) $grupocat = 'false';
        // Carrega Config
        $titulo1    = __('Adicionar Grupo');
        $titulo2    = __('Salvar Grupo');
        $formid     = 'form_Sistema_Admin_Grupos';
        $formbt     = __('Salvar');
        $formlink   = '_Sistema/Admin/Grupos_Add2/'.$grupocat;
        $campos = Sistema_Grupo_DAO::Get_Colunas();
        self::DAO_Campos_Retira($campos, 'valor_mensalidade');
        self::DAO_Campos_Retira($campos, 'valor_matricula');
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos);
    
    }
    /**
     * 
     * 
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Grupos_Add2($grupocat = false){
        if($grupocat==='false') $grupocat = false;
        $titulo     = __('Grupo Adicionado com Sucesso');
        $dao        = 'Sistema_Grupo';
        $funcao     = '$this->Grupos();';
        $sucesso1   = __('Inserção bem sucedida');
        $sucesso2   = __('Grupo cadastrado com sucesso.');
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);
    }
    /**
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Grupos_Edit($id,$grupocat = false){
        $this->Endereco_Admin_Grupo();
        if($grupocat===false) $grupocat = 'false';
        // Carrega Config
        $titulo1    = 'Editar Grupo (#'.$id.')';
        $titulo2    = __('Alteração de Grupo');
        $formid     = 'form_Sistema_AdminC_GrupoEdit';
        $formbt     = __('Alterar Grupo');
        $formlink   = '_Sistema/Admin/Grupos_Edit2/'.$id.'/'.$grupocat;
        $editar     = Array('Sistema_Grupo',$id);
        $campos = Sistema_Grupo_DAO::Get_Colunas();
        self::DAO_Campos_Retira($campos, 'valor_mensalidade');
        self::DAO_Campos_Retira($campos, 'valor_matricula');
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos,$editar);   
    }
    /**
     * 
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Grupos_Edit2($id,$grupocat = false){
        if($grupocat===false) $grupocat = 'false';
        $titulo     = __('Grupo Editado com Sucesso');
        $dao        = Array('Sistema_Grupo',$id);
        $funcao     = '$this->Grupos('.$grupocat.');';
        $sucesso1   = __('Grupo Alterado com Sucesso.');
        $sucesso2   = ''.$_POST["nome"].' teve a alteração bem sucedida';
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);   
    }
    /**
     * 
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Grupos_Del($id,$grupocat = false){
        
        if($grupocat==='false') $grupocat = false;
        
    	$id = (int) $id;
        // Puxa grupo e deleta
        $grupo = $this->_Modelo->db->Sql_Select('Sistema_Grupo', Array('id'=>$id));
        $sucesso =  $this->_Modelo->db->Sql_Delete($grupo);
        // Mensagem
    	if($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Deletado'),
                "mgs_secundaria" => __('Grupo Deletado com sucesso')
            );
    	}else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Erro')
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        
        $this->Grupos($grupocat);
        
        $this->_Visual->Json_Info_Update('Titulo', __('Grupo deletado com Sucesso'));  
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Grupo_Permissao($grupo=false){
        $i = 0;
        if($grupo===false){
            $botao_titulo  = __('Adicionar Permissão de Grupo');
            $aviso_nenhuma = __('Nenhuma permissão de Nenhum Grupo');
            $botao_extra   = '';
            $where = Array();
        }else{
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
                'Print'     => true,
                'Pdf'       => true,
                'Excel'     => true,
                '_Sistema/Admin/Grupo_Permissao'.$botao_extra,
            )
        )));
        // CONEXAO
        $grupopermissaos = $this->_Modelo->db->Sql_Select('Sistema_Grupo_Permissao',$where);
        if(is_object($grupopermissaos)) $grupopermissaos = Array(0=>$grupopermissaos);
        if($grupopermissaos!==false && !empty($grupopermissaos)){
            reset($grupopermissaos);
            $perm_editar = $this->_Registro->_Acl->Get_Permissao_Url('_Sistema/Admin/Grupo_Permissao_Edit');
            $perm_del = $this->_Registro->_Acl->Get_Permissao_Url('_Sistema/Admin/Grupo_Permissao_Del');
            foreach ($grupopermissaos as $indice=>&$valor) {
                $tabela['#Id'][$i]          = '#'.$valor->id;
                $tabela['Grupo'][$i]        = $valor->grupo2;
                $tabela['Permissão'][$i]    = $valor->permissao2;
                $tabela['Valor'][$i]        = $valor->valor;
                $tabela['Funções'][$i]      =  $this->_Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Permissão de Grupo'        ,'_Sistema/Admin/Grupo_Permissao_Edit/'.$valor->id.'/'    ,''),$perm_editar);
                if($valor->id>4){
                    $tabela['Funções'][$i]  .= $this->_Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Permissão de Grupo'       ,'_Sistema/Admin/Grupo_Permissao_Del/'.$valor->id.'/'     ,'Deseja realmente deletar esse Grupo ? Isso irá afetar o sistema!'),$perm_del);
                }
                ++$i;
            }
            $this->_Visual->Show_Tabela_DataTable($tabela);
            unset($tabela);
        }else{ 
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">'.$aviso_nenhuma.'</font></b></center>');
        }
        $titulo = __('Listagem de Permissão de Grupo').' ('.$i.')';
        if($export==='Unico'){
            $this->_Visual->Bloco_Unico_CriaJanela($titulo,'',50);
        }else if($export==='Maior'){
            $this->_Visual->Bloco_Maior_CriaJanela($titulo,'',50);
        }else{
            $this->_Visual->Bloco_Menor_CriaJanela($titulo,'',50);
        }
        
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Administrar Permissões de Grupos'));
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Grupo_Permissao_Add($grupo=false){
        // Carrega campos 
        if($grupo!==false){
            $campos = Sistema_Grupo_Permissao_DAO::Get_Colunas();
            $extra = '/'.$grupo;
            self::DAO_Campos_Retira($campos, 'grupo');
        }else{
            $campos = Sistema_Grupo_Permissao_DAO::Get_Colunas();
            $extra = '';
        }
        //retira os que nao precisam
        self::DAO_Campos_Retira($campos, 'valor_mensalidade');
        self::DAO_Campos_Retira($campos, 'valor_matricula');
        // Carrega formulario
        $form = new \Framework\Classes\Form('form_Sistema_Admin_Grupo_Permissao','_Sistema/Admin/Grupo_Permissao_Add2/'.$extra,'formajax');
        \Framework\App\Controle::Gerador_Formulario($campos, $form);
        $formulario = $form->retorna_form('Cadastrar');
        $this->_Visual->Blocar($formulario);
        // Mostra Conteudo
        $this->_Visual->Bloco_Unico_CriaJanela(__('Cadastro de Permissão de Grupo'));
        // Pagina Config
        $this->_Visual->Json_Info_Update('Titulo', __('Adicionar Permissão de Grupo'));
    }
    /**
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Grupo_Permissao_Edit($id,$grupo=false){
        $id = (int) $id;
        $extra = '';
        if($grupo!==false) $extra = '/'.$grupo;
        // Carrega campos e retira os que nao precisam
        $campos = Sistema_Grupo_Permissao_DAO::Get_Colunas();
        self::DAO_Campos_Retira($campos, 'valor_mensalidade');
        self::DAO_Campos_Retira($campos, 'valor_matricula');
        // recupera grupo
        $grupopermissao = $this->_Modelo->db->Sql_Select('Sistema_Grupo_Permissao', Array('id'=>$id));
        self::mysql_AtualizaValores($campos, $grupopermissao);

        // edicao de grupos
        $form = new \Framework\Classes\Form('form_Sistema_AdminC_GrupoEdit','_Sistema/Admin/Grupo_Permissao_Edit2/'.$id.'/'.$extra,'formajax');
        \Framework\App\Controle::Gerador_Formulario($campos, $form);
        $formulario = $form->retorna_form('Alterar Permissão de Grupo');
        $this->_Visual->Blocar($formulario);
        $this->_Visual->Bloco_Unico_CriaJanela(__('Alteração de Permissão de Grupo'));
        // Json
        $this->_Visual->Json_Info_Update('Titulo', 'Editar Permissão de Grupo (#'.$id.')');
        
    }
    /**
     * 
     * 
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Grupo_Permissao_Add2($grupo=false){
        
        
        // Cria novo Grupo
        $grupopermissao = new Sistema_Grupo_Permissao_DAO;
        self::mysql_AtualizaValores($grupopermissao);
        if($grupo!==false) $grupopermissao->grupo = $grupo;
        $sucesso =  $this->_Modelo->db->Sql_Inserir($grupopermissao);
        
        // Atualiza
        $this->Grupo_Permissao(); 
        
        // Mostra Mensagem de Sucesso
        if($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Inserção bem sucedida'),
                "mgs_secundaria" => __('Permissão de Grupo cadastrado com sucesso.')
            ); 
        }else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Erro')
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens); 
        // Json
        $this->_Visual->Json_Info_Update('Titulo', __('Permissão de Grupo Adicionado com Sucesso'));  
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
    /**
     * 
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Grupo_Permissao_Edit2($id,$grupo=false){
        
        $id = (int) $id;
        // Puxa o grupo, e altera seus valores, depois salva novamente
        $grupopermissao = $this->_Modelo->db->Sql_Select('Sistema_Grupo_Permissao', Array('id'=>$id));
        self::mysql_AtualizaValores($grupopermissao);
        $sucesso =  $this->_Modelo->db->Sql_Update($grupopermissao);
        // Atualiza
        $this->Grupo_Permissao();
        // Mensagem
        if($sucesso===true){
            $mensagens = array(
                "tipo"              => 'sucesso',
                "mgs_principal"     => __('Permissão de Grupo Alterado com Sucesso'),
                "mgs_secundaria"    => ''.$_POST["nome"].' teve a alteração bem sucedida'
            );
        }else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Erro')
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);  
        //Json
        $this->_Visual->Json_Info_Update('Titulo', __('Permissão de Grupo Editado com Sucesso'));  
        $this->_Visual->Json_Info_Update('Historico', false);    
    }
    /**
     * 
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Grupo_Permissao_Del($id){
        
        
    	$id = (int) $id;
        // Puxa grupo e deleta
        $grupopermissao = $this->_Modelo->db->Sql_Select('Sistema_Grupo_Permissao', Array('id'=>$id));
        $sucesso =  $this->_Modelo->db->Sql_Delete($grupopermissao);
        // Mensagem
    	if($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Deletado'),
                "mgs_secundaria" => __('Permissão de Grupo Deletado com sucesso')
            );
    	}else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Erro')
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        
        $this->Grupo_Permissao();
        
        $this->_Visual->Json_Info_Update('Titulo', __('Permissão de Grupo deletado com Sucesso'));  
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
    public function Newsletter($export='Unico'){
        $i = 0;
        $this->_Visual->Blocar($this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            Array(
                __('Adicionar Newsletter'),
                '_Sistema/Admin/Newsletter_Add',
                ''
            ),
            Array(
                'Print'     => true,
                'Pdf'       => true,
                'Excel'     => true,
                'Link'      => '_Sistema/Admin/Newsletter',
            )
        )));
        $grupopermissaos = $this->_Modelo->db->Sql_Select('Sistema_Newsletter');
        if(is_object($grupopermissaos)) $grupopermissaos = Array(0=>$grupopermissaos);
        if($grupopermissaos!==false && !empty($grupopermissaos)){
            reset($grupopermissaos);
            $perm_editar = $this->_Registro->_Acl->Get_Permissao_Url('_Sistema/Admin/Newsletter_Edit');
            $perm_del = $this->_Registro->_Acl->Get_Permissao_Url('_Sistema/Admin/Newsletter_Del');
            foreach ($grupopermissaos as $indice=>&$valor) {
                $tabela['Id'][$i]           = $valor->id;
                $tabela['Nome'][$i]         = $valor->nome;
                $tabela['Email'][$i]        = $valor->email;
                if($valor->tipo==1){
                    $tabela['Tipo'][$i]     = __('Newsletter');
                }else if($valor->tipo==2){
                    $tabela['Tipo'][$i]     = __('Contato');
                }else if($valor->tipo==3){
                    $tabela['Tipo'][$i]     = __('Trabalhe Conosco');                    
                }
                $tabela['Estado'][$i]       = $valor->estado;
                $tabela['Linguagem'][$i]    = $valor->lang;
                $tabela['Funções'][$i]      = $this->_Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Newsletter'        ,'_Sistema/Admin/Newsletter_Edit/'.$valor->id.'/'    ,''),$perm_editar).
                                              $this->_Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Newsletter'       ,'_Sistema/Admin/Newsletter_Del/'.$valor->id.'/'     ,'Deseja realmente deletar essa Newsletter ? Isso irá afetar o sistema!'),$perm_del);
                ++$i;
            }
            if($export!==false && $export!=='Unico'){
                self::Export_Todos($export,$tabela, 'Newsletter');
            }else{
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
            if($export!==false){
                $mensagem = __('Nenhuma Newsletter para Exportar');
            }else{
                $mensagem = __('Nenhuma Newsletter');
            }            
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">'.$mensagem.'</font></b></center>');
        }
        $titulo = __('Listagem de Newsletter').' ('.$i.')';
        if($export==='Unico'){
            $this->_Visual->Bloco_Unico_CriaJanela($titulo,'',40);
        }else if($export==='Maior'){
            $this->_Visual->Bloco_Maior_CriaJanela($titulo,'',40);
        }else{
            $this->_Visual->Bloco_Menor_CriaJanela($titulo,'',40);
        }
        
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Administrar Newsletters'));
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Newsletter_Add(){
        // Carrega campos e retira os que nao precisam
        $campos = Sistema_Newsletter_DAO::Get_Colunas();
        self::DAO_Campos_Retira($campos, 'valor_mensalidade');
        self::DAO_Campos_Retira($campos, 'valor_matricula');
        // Carrega formulario
        $form = new \Framework\Classes\Form('form_Sistema_Admin_Newsletter','_Sistema/Admin/Newsletter_Add2/','formajax');
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
    public function Newsletter_Edit($id){
        $id = (int) $id;
        // Carrega campos e retira os que nao precisam
        $campos = Sistema_Newsletter_DAO::Get_Colunas();
        self::DAO_Campos_Retira($campos, 'valor_mensalidade');
        self::DAO_Campos_Retira($campos, 'valor_matricula');
        // recupera grupo
        $grupopermissao = $this->_Modelo->db->Sql_Select('Sistema_Newsletter', Array('id'=>$id));
        self::mysql_AtualizaValores($campos, $grupopermissao);

        // edicao de grupos
        $form = new \Framework\Classes\Form('form_Sistema_AdminC_GrupoEdit','_Sistema/Admin/Newsletter_Edit2/'.$id.'/','formajax');
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
    public function Newsletter_Add2(){
        
        
        // Cria novo Grupo
        $grupopermissao = new Sistema_Newsletter_DAO;
        self::mysql_AtualizaValores($grupopermissao);
        $sucesso =  $this->_Modelo->db->Sql_Inserir($grupopermissao);
        
        // Recarrega Newsletter
        $this->Newsletter();  
        
        // Mostra Mensagem de Sucesso
        if($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Inserção bem sucedida'),
                "mgs_secundaria" => __('Newsletter cadastrado com sucesso.')
            ); 
        }else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Erro')
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        // Json
        $this->_Visual->Json_Info_Update('Titulo', __('Newsletter Adicionado com Sucesso'));  
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
    /**
     * 
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Newsletter_Edit2($id){
        
        $id = (int) $id;
        // Puxa o grupo, e altera seus valores, depois salva novamente
        $grupopermissao = $this->_Modelo->db->Sql_Select('Sistema_Newsletter', Array('id'=>$id));
        self::mysql_AtualizaValores($grupopermissao);
        $sucesso =  $this->_Modelo->db->Sql_Update($grupopermissao);
        // Atualiza
        $this->Newsletter();
        // Mensagem
        if($sucesso===true){
            $mensagens = array(
                "tipo"              => 'sucesso',
                "mgs_principal"     => __('Newsletter Alterado com Sucesso'),
                "mgs_secundaria"    => ''.$_POST["nome"].' teve a alteração bem sucedida'
            );
        }else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Erro')
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);  
        //Json
        $this->_Visual->Json_Info_Update('Titulo', __('Newsletter Editado com Sucesso'));  
        $this->_Visual->Json_Info_Update('Historico', false);    
    }
    /**
     * 
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Newsletter_Del($id){
        
        
    	$id = (int) $id;
        // Puxa grupo e deleta
        $grupopermissao = $this->_Modelo->db->Sql_Select('Sistema_Newsletter', Array('id'=>$id));
        $sucesso =  $this->_Modelo->db->Sql_Delete($grupopermissao);
        // Mensagem
    	if($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Deletado'),
                "mgs_secundaria" => __('Newsletter Deletado com sucesso')
            );
    	}else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Erro')
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        
        $this->Newsletter();
        
        $this->_Visual->Json_Info_Update('Titulo', __('Newsletter deletado com Sucesso'));  
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
    /**
     * 
     * @param type $true
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    function Endereco_Admin($true=true){
        $titulo = __('Administração Geral');
        $link = '_Sistema/Admin/Main';
        if($true===true){
            $this->Tema_Endereco($titulo,$link);
        }else{
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
    function Endereco_Admin_Permissao($true=true){
        self::Endereco_Admin();
        $titulo = __('Permissões do Sistema');
        $link = '_Sistema/Admin/Permissoes';
        if($true===true){
            $this->Tema_Endereco($titulo,$link);
        }else{
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
    function Endereco_Admin_Config($true=true){
        self::Endereco_Admin();
        $titulo = __('Permissões do Sistema');
        $link = '_Sistema/Admin/Permissoes';
        if($true===true){
            $this->Tema_Endereco($titulo,$link);
        }else{
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
    function Endereco_Admin_Menu($true=true){
        $this->Endereco_Admin();
        $titulo = __('Menus do Sistema');
        $link = '_Sistema/Admin/Menus';
        if($true===true){
            $this->Tema_Endereco($titulo,$link);
        }else{
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
    function Endereco_Admin_Grupo($true=true){
        $this->Endereco_Admin();
        $titulo = __('Grupos do Sistema');
        $link = '_Sistema/Admin/Grupos';
        if($true===true){
            $this->Tema_Endereco($titulo,$link);
        }else{
            $this->Tema_Endereco($titulo);
        }
    }
}
?>
