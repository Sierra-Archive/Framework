<?php
/********************
 * 
 * 
 * 
 * 
 * 
 * 
 *    FOI CRIADO O AdminC,AdminM,AdminV para substituir o cateogira que estava
 * na versao 1.0 do framework
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * Ricardo Rebello Sierra <web@ricardosierra.com.br>
 * 
 * 
 * 
 * 
 * 
 * 
 */
class categoria_categoriaControle extends categoria_Controle
{
    public function __construct(){
        parent::__construct();
    }
    /**
     * 
     */
    public function Main($status=''){
        if(isset($status) AND $status!='') $status=__('salvar');
        else                               $status='';
        if($status=='salvar'){
            $this->_Visual->Json_Info_Update('Titulo', __('Categorias'));
              
            // insere categoria e atualiza o select
            $this->Categorias_inserir();
            $array = $this->_Modelo->Categorias_Retorna('',0,1);
            $form = \Framework\Classes\Form::Select_Opcao_Stat('Pasta Raiz',0,1);
            $this->_Visual->Categorias_ShowSelect_AJAX($array,$form);
            $conteudo = array(
                "location" => "#selectcategorias",
                "js" => '',
                "html" => $form
            );
            $this->_Visual->Json_IncluiTipo('Conteudo',$conteudo);

            // atualiza tabela central 
            $this->Categorias_ShowTab();
            // ORGANIZA E MANDA CONTEUDO
            $this->_Visual->Json_Start('Categorias');
        }else{
            $this->Categorias_ShowTab();
            $this->Categorias_formcadastro();
    
            // ORGANIZA E MANDA CONTEUDO
            $this->_Visual->Json_Info_Update('Titulo', __('Categorias'));

        }
    }
    /**
     * 
     * @param type $tipo
     */
    public function Categorias_formeditar($id){
        
        $id = (int) $id;
        $categoria = $this->_Modelo->Categoria_Retorna($id);
        
        $form = new \Framework\Classes\Form('adminformcategoriasend', SISTEMA_MODULO.'/'.SISTEMA_SUB.'/Categorias_alterar/'.$id.'/','formajax');
        $this->Categorias_formulario($form,$tipo,$categoria['nome'],$categoria['parent']);
        $this->_Visual->Blocar($form->retorna_form(__('Editar')));
        $this->_Visual->Bloco_Menor_CriaJanela(__('Editar Categoria'));
        // ORGANIZA E MANDA CONTEUDO
        $this->_Visual->Json_Info_Update('Titulo', __('Editar Categoria'));
    }
    public function Categorias_alterar($id){
        
        $id = (int) $id;
        $nome = \Framework\App\Conexao::anti_injection($_POST["nome"]);
        $parent = (int) $_POST["parent"];
        $mod_acc = \Framework\App\Conexao::anti_injection($_POST["mod_acc"]);
        
        if($parent!=$id){
            $sucesso =  $this->_Modelo->Categorias_alterar($id,$nome,$parent,$mod_acc);
            if($sucesso===true){
                $mensagens = array(
                    "tipo" => 'sucesso',
                    "mgs_principal" => __('Categoria alterada com Sucesso'),
                    "mgs_secundaria" => ''.$nome.' foi alterado na base de dados...'
                );
            }else{
                $mensagens = array(
                    "tipo" => 'erro',
                    "mgs_principal" => __('Erro'),
                    "mgs_secundaria" => __('Erro')
                );
            }
        }else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => ''.$nome.' não pode estar dentro dele mesmo.'
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens); 
        
        $this->Categorias_ShowTab();
        $this->Categorias_formcadastro();
        
        // ORGANIZA E MANDA CONTEUDO
        $this->_Visual->Json_Info_Update('Titulo', __('Categoria alterada com Sucesso'));
        $this->_Visual->Json_Info_Update('Historico', false);
    
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
    public function Categorias_ShowTab($tipo=''){
        $tabela = Array();
        $array = $this->_Modelo->Categorias_Retorna($tipo);
        $tabela = new \Framework\Classes\Tabela();
        $tabela->addcabecario(array('Id','Nome', 'Acesso','Editar'));        
        $this->_Visual->Categorias_ShowTab($array,$tabela);
        $this->_Visual->Blocar($tabela->retornatabela());
        $this->_Visual->Bloco_Maior_CriaJanela(__('Categorias'));
        unset($tabela);        
    }
    /**
    * Cadastro de Nova Categoria
    * 
    * @name Categorias_formcadastro
    * @access public
     * 
     * 
     * @uses \Framework\App\Visual::$blocar
    * @uses \Framework\App\Visual::$Bloco_Menor_CriaJanela Mostra Cadastro de Categoria na Aba direita
    * 
    * 
    * @param string $tipo Carrega Tipo de Categoria
    * 

    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 0.4.2
    */
    public function Categorias_formcadastro($modulo=false){
        
        $form = new \Framework\Classes\Form('adminformcategoriasend',SISTEMA_MODULO.'/'.SISTEMA_SUB.'/Main/salvar/','formajax');
        
        $formbt = __('Salvar');
        $titulo1 = __('Cadastrar Categoria');
        $titulo2 = __('Cadastrar Categoria');
        // Puxa Form
        $this->Categorias_formulario($form);
        // Carrega formulario
        if(isset($_GET['formselect']) && $_GET['formselect']!='' && LAYOULT_IMPRIMIR=='AJAX'){
            $formulario = $form->retorna_form();
            $conteudo = array(
                'id' => 'popup',
                'title' => $titulo2,
                'botoes' => array(
                    array(
                        'text' => $formbt,
                        'clique' => '$(\'#'.$formid.'\').submit();'
                    ),
                    array(
                        'text' => 'Cancelar',
                        'clique' => '$( this ).dialog( "close" );'
                    )
                ),
                'html' => \Framework\App\Sistema_Funcoes::HTML_min($formulario)
            );
            $this->_Visual->Json_IncluiTipo('Popup',$conteudo);
            $this->_Visual->Json_Info_Update('Historico',0);
        }else{
            $formulario = $form->retorna_form($formbt);
            $this->_Visual->Blocar($formulario);
            // Mostra Conteudo
            $this->_Visual->Bloco_Menor_CriaJanela($titulo2);
            // Pagina Config
            $this->_Visual->Json_Info_Update('Historico',1);
        }
        $this->_Visual->Json_Info_Update('Titulo',$titulo1);
   }
    /**
     *
     * 
    * @uses Form Carrega novo Formulario
    * @uses \Framework\Classes\Form::$Input_Novo
    * @uses \Framework\Classes\Form::$Select_Novo
    * @uses \Framework\Classes\Form::$Select_Opcao
    * @uses \Framework\Classes\Form::$Select_Fim
    * @uses \Framework\Classes\Form::$retorna_form
    * @uses \Framework\App\Modelo::$Categorias_Retorna
    * @uses \Framework\App\Visual::$Categorias_ShowSelect

     * 
     * @param type $tipo
     * @return void
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Categorias_formulario(&$form, $tipo='' , $nome = '', $parent = 0){
      
        $categorias = $this->_Modelo->Categorias_Retorna($tipo,0,1);
        // CADASTRA
        $form->Input_Novo('Nome','nome',$nome,'text', 30, 'obrigatorio ');
        
        // COMEÇO DOS SELECT DE CATEGORIAS PAI
        $form->Select_Novo('Categoria Pai','parent','selectcategorias');
        if($parent==0) $form->Select_Opcao('Pasta Raiz',0,1);
        else  $form->Select_Opcao('Pasta Raiz',0,1);
        $this->_Visual->Categorias_ShowSelect($categorias,$form,$parent);
        $form->Select_Fim();
        
        // COMEÇO DOS SELECT DE PERMISSOES DE MODULOS
        $acc = categoria_Controle::Categorias_CarregaModulosTotais();
        $form->Select_Novo('Modulo Aceito','mod_acc','mod_acc');
        $j = 0;
        foreach($acc as &$valor){
            if($j==0) $form->Select_Opcao($valor['chave_nome'],$valor['chave_nome'],1);
            else  $form->Select_Opcao($valor['chave_nome'],$valor['chave_nome'],0);
            ++$j;
        }
        $form->Select_Fim();
        
        
        // FINAL DOS SELECT DE LOCALIDADES
    }
    /**
     * Inserir Categoria no Banco de Dados apos Cadastro
     * 
     * @name Categorias_inserir
     * @access public
     * 
     * 
     * @uses \Framework\App\Modelo::$Categorias_inserir
     * @uses \Framework\App\Visual::$Json_IncluiTipo
     * 
     * @return void
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Categorias_inserir(){
        
        $nome = \Framework\App\Conexao::anti_injection($_POST["nome"]);
        $parent = (int) $_POST["parent"];
        $mod_acc = \Framework\App\Conexao::anti_injection($_POST["mod_acc"]);
        
        $sucesso =  $this->_Modelo->Categorias_inserir($nome,$parent,$mod_acc);
        
        if($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Categoria inserida com Sucesso'),
                "mgs_secundaria" => ''.$nome.' foi add a base de dados...'
            );
        }else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Erro')
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        $this->_Visual->Json_Info_Update('Titulo', __('Categoria inserida com Sucesso'));
        $this->_Visual->Json_Info_Update('Historico', false);
    
    }
}
?>