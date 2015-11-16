<?php
class categoria_AdminControle extends categoria_Controle
{
    public function __construct() {
        parent::__construct();
    }
    protected function Endereco_Categoria($true= TRUE ) {
        if ($true === TRUE) {
            $this->Tema_Endereco(__('Categorias'),'categoria/Admin/Categorias');
        } else {
            $this->Tema_Endereco(__('Categorias'));
        }
    }
    /**
     * 
     */
    public function Main() {
        return FALSE;
    }
    public function Categorias($modulo='') {
        $this->Categorias_ShowTab($modulo);
        //$this->Categorias_Add();
        // ORGANIZA E MANDA CONTEUDO
        $this->_Visual->Json_Info_Update('Titulo', __('Categorias'));
    }
    /**
    * Mostra todas as Categorias
    * 
    * @name Categorias_ShowTab
    * @access public
    * 
    * @param string $tipo Carrega Tipo de Categoria
    * 
    * @uses Tabela Carrega uma Nova Tabela
    * @uses Tabela::$addcabecario Carrega o topo da Tabela
    * @uses \Framework\App\Modelo::$Categorias_Retorna
    * @uses \Framework\App\Visual::$Categorias_ShowTab
    * @uses \Framework\App\Visual::$blocar
    * @uses \Framework\App\Visual::$Bloco_Maior_CriaJanela
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 0.4.2
    */
    public function Categorias_ShowTab($tipo='') {
        self::Endereco_Categoria(FALSE);
        $table = Array();
        $array = $this->_Modelo->Categorias_Retorna($tipo);
        $table = new \Framework\Classes\Tabela();
        $table->addcabecario(array('Id', 'Nome', 'Acesso', 'Editar'));   
        
        // Botao Add
        $this->_Visual->Blocar($this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            Array(
                'Adicionar Categoria',
                'categoria/Admin/Categorias_Add',
                ''
            ),
            Array(
                'Print'     => TRUE,
                'Pdf'       => TRUE,
                'Excel'     => TRUE,
                'Link'      => 'categoria/Admin/Categorias',
            )
        )));
        // Conexao
        $this->_Visual->Categorias_ShowTab($array, $table);
        $this->_Visual->Blocar($table->retornatabela());
        $this->_Visual->Bloco_Unico_CriaJanela(__('Categorias'));
        unset($table);        
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Categorias_Add($modulo = FALSE) {
        self::Endereco_Categoria(TRUE);
        // Carrega Config
        if ($modulo === FALSE) {
            $titulo1    = __('Adicionar Categoria');
            $titulo2    = __('Salvar Categoria');
        } else {
            $dados_modulo = Categoria_Acesso_DAO::Mod_Acesso_Get($modulo);
            if ($dados_modulo === FALSE) {
                return FALSE;
            }
            $titulo1    = 'Adicionar '.$dados_modulo['nome'];
            $titulo2    = 'Adicionar '.$dados_modulo['nome'];            
        }
        $formid     = 'form_categoria_Admin_Categorias';
        $formbt     = __('Salvar');
        $formlink   = 'categoria/Admin/Categorias_Add2/';
        $campos     = Categoria_DAO::Get_Colunas();
        if ($modulo !== FALSE) {
            $formlink = $formlink.$modulo.'/';
            if (\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('categoria_parent_extra') == FALSE) {
                self::DAO_Campos_Retira($campos, 'parent');
            }
            self::DAO_Campos_Retira($campos, 'Modulos Liberados');
        }
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1, $titulo2, $formlink, $formid, $formbt, $campos);
    }
    /**
     * 
     * 
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Categorias_Add2($modulo = FALSE) {
        if (!isset($_GET['formselect']) || !isset($_GET['condicao'])) {
            return FALSE;
        }
        
        $titulo     = __('Adicionado com Sucesso');
        $dao        = 'Categoria';
        $function     = '$this->Categorias();';
        $sucesso1   = __('Inserção bem sucedida');
        $sucesso2   = __('Cadastrado com sucesso.');
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo, $dao, $function, $sucesso1, $sucesso2, $alterar);
        // Cadastra o modulo
        if ($modulo !== FALSE) {
            $identificador  = $this->_Modelo->db->Sql_Select ($dao, Array(),1,'ID DESC');
            $identificador  = $identificador->id;
            $objeto = new \Categoria_Acesso_DAO();
            $objeto->categoria  = $identificador;
            $objeto->mod_acc    = $modulo;
            $sucesso = $this->_Modelo->db->Sql_Insert($objeto);
            // Gambiarra para Atualiza select denovo
            $select = \Framework\App\Conexao::anti_injection($_GET['formselect']);
            $condicao = \Framework\App\Conexao::anti_injection($_GET['condicao']);
            $opcoes = $this->_Modelo->db->Tabelas_CapturaExtrangeiras($condicao);   
            $html = '';
            if ($opcoes !== FALSE && !empty($opcoes)) {
                if (is_object($opcoes)) $opcoes = Array(0=>$opcoes);
                reset($opcoes);
                foreach ($opcoes as $indice=>&$valor) {
                    if ($identificador==$indice) {
                        $selecionado=1;
                    }
                    else{
                        $selecionado=0;
                    }
                    $html .= \Framework\Classes\Form::Select_Opcao_Stat($valor, $indice, $selecionado);
                }
            }
            // Json
            $this->_Visual->Json_RetiraTipo('#'.$select);
            $conteudo = array(
                'location'  =>  '#'.$select,
                'js'        =>  '$("#'.$select.'").trigger("liszt:updated");',
                'html'      =>  $html
            );
            $this->_Visual->Json_IncluiTipo('Conteudo', $conteudo);
            $this->_Visual->Json_Info_Update('Historico', FALSE);  
        }
    }
    /**
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Categorias_Edit($id, $modulo = FALSE) {
        self::Endereco_Categoria(TRUE);
        // Carrega Config
        if ($modulo === FALSE) {
            $titulo1    = 'Editar Categoria (#'.$id.')';
            $titulo2    = 'Alteração de Categoria (#'.$id.')';
        } else {
            $dados_modulo = Categoria_Acesso_DAO::Mod_Acesso_Get($modulo);
            $titulo1      = 'Editar '.$dados_modulo['nome'].' (#'.$id.')';    
            $titulo2      = 'Editar '.$dados_modulo['nome'].' (#'.$id.')';    
        }
        $formid     = 'form_categoria_Admin_Categorias_Edit';
        $formbt     = __('Alterar Categoria');
        $formlink   = 'categoria/Admin/Categorias_Edit2/';
        $editar     = Array('Categoria', $id);
        if ($modulo !== FALSE) {
            $formlink .= $formlink.$modulo.'/';
            self::DAO_Campos_Retira($campos, 'Modulos Liberados');
        }
        // Add id ao Link
        $formlink = $formlink.$id;
        // Captura campos e Formata
        $campos = Categoria_DAO::Get_Colunas();
        if ($modulo !== FALSE) {
            self::DAO_Campos_Retira($campos, 'parent');
            self::DAO_Campos_Retira($campos, 'Modulos Liberados');
        }
        // Gera Formulario
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1, $titulo2, $formlink, $formid, $formbt, $campos, $editar);
    }
    /**
     * 
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Categorias_Edit2($id, $modulo = FALSE) {
        if (!isset($_POST["nome"])) {
            return _Sistema_erroControle::Erro_Fluxo('Nome não Informado em Categoria',404);
        }
        
        $titulo     = __('Editado com Sucesso');
        $dao        = Array('Categoria', $id);
        $function     = '$this->Categorias();';
        $sucesso1   = __('Alterado com Sucesso.');
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
    public function Categorias_Del($id) {
        
    	$id = (int) $id;
        // Puxa Categoria e Acessos
        $categorias = $this->_Modelo->db->Sql_Select('Categoria', Array('id'=>$id));
        $acesso = $this->_Modelo->db->Sql_Select('Categoria_Acesso', Array('categoria'=>$id));
        $sucesso =  $this->_Modelo->db->Sql_Delete($categorias);
        // Mensagem
    	if ($sucesso === TRUE) {
            $sucesso =  $this->_Modelo->db->Sql_Delete($acesso);
            if ($sucesso === TRUE) {
                $mensagens = array(
                    "tipo" => 'sucesso',
                    "mgs_principal" => __('Deletado'),
                    "mgs_secundaria" => __('Deletado com sucesso')
                );
            } else {
                $mensagens = array(
                    "tipo" => 'erro',
                    "mgs_principal" => __('Erro'),
                    "mgs_secundaria" => __('Erro')
                );
            }
    	} else {
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Erro')
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens', $mensagens);
        
        $this->Categorias();
        
        $this->_Visual->Json_Info_Update('Titulo', __('Deletado com Sucesso'));  
        $this->_Visual->Json_Info_Update('Historico', FALSE);  
    }
}
?>
