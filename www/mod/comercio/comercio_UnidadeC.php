<?php
class comercio_UnidadeControle extends comercio_Controle
{
    /**
    * Construtor
    * 
    * @name __construct
    * @access public
    * 
    * @uses comercio_rede_PerfilModelo::Carrega Rede Modelo
    * @uses comercio_rede_PerfilVisual::Carrega Rede Visual
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
    * Main
    * 
    * @name Main
    * @access public
    * 
    * @uses comercio_Controle::$comercioPerfil
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 2.0
    */
    public function Main(){
        \Framework\App\Sistema_Funcoes::Redirect(URL_PATH.'comercio/Unidade/Unidades/');
        return false;
    }
    static function Endereco_Unidade($true=true){
        $registro = \Framework\App\Registro::getInstacia();
        $_Controle = $registro->_Controle;
        $titulo = 'Unidades';
        $link = 'comercio/Unidade/Unidades';
        if($true===true){
            $_Controle->Tema_Endereco($titulo,$link);
        }else{
            $_Controle->Tema_Endereco($titulo);
        }
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Unidades(){
        self::Endereco_Unidade(false);
        $i = 0;
        $this->_Visual->Blocar('<a title="Adicionar Unidade" class="btn btn-success lajax explicar-titulo" acao="" href="'.URL_PATH.'comercio/Unidade/Unidades_Add">Adicionar nova Unidade</a><div class="space15"></div>');
        $linhas = $this->_Modelo->db->Sql_Select('Comercio_Unidade');
        if($linhas!==false && !empty($linhas)){
            if(is_object($linhas)) $linhas = Array(0=>$linhas);
            reset($linhas);
            foreach ($linhas as $indice=>&$valor) {
                //$tabela['#Id'][$i]       = '#'.$valor->id;
                $tabela['Nome da Unidade'][$i]      = $valor->nome;
                $tabela['Funções'][$i]   = $this->_Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Unidade'        ,'comercio/Unidade/Unidades_Edit/'.$valor->id.'/'    ,'')).
                                           $this->_Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Unidade'       ,'comercio/Unidade/Unidades_Del/'.$valor->id.'/'     ,'Deseja realmente deletar essa Unidade ?'));
                ++$i;
            }
            $this->_Visual->Show_Tabela_DataTable($tabela);
            unset($tabela);
        }else{            
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhuma Unidade</font></b></center>');
        }
        $titulo = 'Listagem de Unidades ('.$i.')';
        $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Administrar Unidades'));
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Unidades_Add(){
        self::Endereco_Unidade(true);
        // Carrega Config
        $titulo1    = 'Adicionar Unidade';
        $titulo2    = 'Salvar Unidade';
        $formid     = 'form_Sistema_Admin_Unidades';
        $formbt     = 'Salvar';
        $formlink   = 'comercio/Unidade/Unidades_Add2/';
        $campos = Comercio_Unidade_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos);
    }
    /**
     * 
     * @global Array $language
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Unidades_Add2(){
        $titulo     = 'Unidade Adicionada com Sucesso';
        $dao        = 'Comercio_Unidade';
        $funcao     = '$this->Unidades();';
        $sucesso1   = 'Inserção bem sucedida';
        $sucesso2   = 'Unidade cadastrada com sucesso.';
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);
    }
    /**
     * 
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Unidades_Edit($id){
        self::Endereco_Unidade(true);
        // Carrega Config
        $titulo1    = 'Editar Unidade (#'.$id.')';
        $titulo2    = 'Alteração de Unidade';
        $formid     = 'form_Sistema_AdminC_UnidadeEdit';
        $formbt     = 'Alterar Unidade';
        $formlink   = 'comercio/Unidade/Unidades_Edit2/'.$id;
        $editar     = Array('Comercio_Unidade',$id);
        $campos = Comercio_Unidade_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos,$editar);
    }
    /**
     * 
     * @global Array $language
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Unidades_Edit2($id){
        $titulo     = 'Unidade Editada com Sucesso';
        $dao        = Array('Comercio_Unidade',$id);
        $funcao     = '$this->Unidades();';
        $sucesso1   = 'Unidade Alterada com Sucesso.';
        $sucesso2   = ''.$_POST["nome"].' teve a alteração bem sucedida';
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);      
    }
    /**
     * 
     * @global Array $language
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Unidades_Del($id){
        global $language;
        
    	$id = (int) $id;
        // Puxa linha e deleta
        $linha = $this->_Modelo->db->Sql_Select('Comercio_Unidade', Array('id'=>$id));
        $sucesso =  $this->_Modelo->db->Sql_Delete($linha);
        // Mensagem
    	if($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Deletada'),
                "mgs_secundaria" => __('Unidade Deletada com sucesso')
            );
    	}else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => $language['mens_erro']['erro'],
                "mgs_secundaria" => $language['mens_erro']['erro']
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        
        $this->Unidades();
        
        $this->_Visual->Json_Info_Update('Titulo', __('Unidade deletada com Sucesso'));  
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
}
?>
