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
    * @version 0.4.2
    */
    public function __construct() {
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
    * @version 0.4.2
    */
    public function Main() {
        \Framework\App\Sistema_Funcoes::Redirect(URL_PATH.'comercio/Unidade/Unidades/');
        return FALSE;
    }
    static function Endereco_Unidade($true= TRUE ) {
        $Registro = &\Framework\App\Registro::getInstacia();
        $_Controle = $Registro->_Controle;
        $titulo = __('Unidades');
        $link = 'comercio/Unidade/Unidades';
        if ($true === TRUE) {
            $_Controle->Tema_Endereco($titulo, $link);
        } else {
            $_Controle->Tema_Endereco($titulo);
        }
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Unidades() {
        self::Endereco_Unidade(FALSE);
        $i = 0;
        $this->_Visual->Blocar('<a title="Adicionar Unidade" class="btn btn-success lajax explicar-titulo" data-acao="" href="'.URL_PATH.'comercio/Unidade/Unidades_Add">Adicionar nova Unidade</a><div class="space15"></div>');
        $linhas = $this->_Modelo->db->Sql_Select('Comercio_Unidade');
        if ($linhas !== FALSE && !empty($linhas)) {
            if (is_object($linhas)) $linhas = Array(0=>$linhas);
            reset($linhas);
            foreach ($linhas as $indice=>&$valor) {
                //$tabela['#Id'][$i]       = '#'.$valor->id;
                $tabela['Nome da Unidade'][$i]      = $valor->nome;
                $tabela['Funções'][$i]   = $this->_Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Unidade'        ,'comercio/Unidade/Unidades_Edit/'.$valor->id.'/'    , '')).
                                           $this->_Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Unidade'       ,'comercio/Unidade/Unidades_Del/'.$valor->id.'/'     ,'Deseja realmente deletar essa Unidade ?'));
                ++$i;
            }
            $this->_Visual->Show_Tabela_DataTable($tabela);
            unset($tabela);
        } else {            
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhuma Unidade</font></b></center>');
        }
        $titulo = __('Listagem de Unidades').' ('.$i.')';
        $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Administrar Unidades'));
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Unidades_Add() {
        self::Endereco_Unidade(TRUE);
        // Carrega Config
        $titulo1    = __('Adicionar Unidade');
        $titulo2    = __('Salvar Unidade');
        $formid     = 'form_Sistema_Admin_Unidades';
        $formbt     = __('Salvar');
        $formlink   = 'comercio/Unidade/Unidades_Add2/';
        $campos = Comercio_Unidade_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1, $titulo2, $formlink, $formid, $formbt, $campos);
    }
    /**
     * 
     * 
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Unidades_Add2() {
        $titulo     = __('Unidade Adicionada com Sucesso');
        $dao        = 'Comercio_Unidade';
        $funcao     = '$this->Unidades();';
        $sucesso1   = __('Inserção bem sucedida');
        $sucesso2   = __('Unidade cadastrada com sucesso.');
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo, $dao, $funcao, $sucesso1, $sucesso2, $alterar);
    }
    /**
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Unidades_Edit($id) {
        self::Endereco_Unidade(TRUE);
        // Carrega Config
        $titulo1    = 'Editar Unidade (#'.$id.')';
        $titulo2    = __('Alteração de Unidade');
        $formid     = 'form_Sistema_AdminC_UnidadeEdit';
        $formbt     = __('Alterar Unidade');
        $formlink   = 'comercio/Unidade/Unidades_Edit2/'.$id;
        $editar     = Array('Comercio_Unidade', $id);
        $campos = Comercio_Unidade_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1, $titulo2, $formlink, $formid, $formbt, $campos, $editar);
    }
    /**
     * 
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Unidades_Edit2($id) {
        $titulo     = __('Unidade Editada com Sucesso');
        $dao        = Array('Comercio_Unidade', $id);
        $funcao     = '$this->Unidades();';
        $sucesso1   = __('Unidade Alterada com Sucesso.');
        $sucesso2   = ''.$_POST["nome"].' teve a alteração bem sucedida';
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo, $dao, $funcao, $sucesso1, $sucesso2, $alterar);      
    }
    /**
     * 
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Unidades_Del($id) {
        
        
    	$id = (int) $id;
        // Puxa linha e deleta
        $linha = $this->_Modelo->db->Sql_Select('Comercio_Unidade', Array('id'=>$id));
        $sucesso =  $this->_Modelo->db->Sql_Delete($linha);
        // Mensagem
    	if ($sucesso === TRUE) {
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Deletada'),
                "mgs_secundaria" => __('Unidade Deletada com sucesso')
            );
    	} else {
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Erro')
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens', $mensagens);
        
        $this->Unidades();
        
        $this->_Visual->Json_Info_Update('Titulo', __('Unidade deletada com Sucesso'));  
        $this->_Visual->Json_Info_Update('Historico', FALSE);  
    }
}
?>
