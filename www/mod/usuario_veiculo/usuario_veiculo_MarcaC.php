<?php
class usuario_veiculo_MarcaControle extends usuario_veiculo_Controle
{
    /**
    * Construtor
    * 
    * @name __construct
    * @access public
    * 
    * @uses usuario_veiculo_rede_PerfilModelo::Carrega Rede Modelo
    * @uses usuario_veiculo_rede_PerfilVisual::Carrega Rede Visual
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
    * @uses usuario_veiculo_Controle::$usuario_veiculoPerfil
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 0.4.2
    */
    public function Main() {
        \Framework\App\Sistema_Funcoes::Redirect(URL_PATH.'usuario_veiculo/Marca/Marcas');
        return false;
    }
    static function Endereco_Veiculo_Marca($true=true) {
        $Registro = &\Framework\App\Registro::getInstacia();
        $_Controle = $Registro->_Controle;
        $titulo = __('Marcas');
        $link = 'usuario_veiculo/Marca/Marcas';
        // Chama Veiculo
        usuario_veiculo_VeiculoControle::Endereco_Veiculo(true);
        //Chama
        if ($true===true) {
            $_Controle->Tema_Endereco($titulo,$link);
        } else {
            $_Controle->Tema_Endereco($titulo);
        }
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Marcas() {
        $i = 0;
        self::Endereco_Veiculo_Marca(false);
        $this->_Visual->Blocar('<a title="Adicionar Marca" class="btn btn-success lajax explicar-titulo" data-acao="" href="'.URL_PATH.'usuario_veiculo/Marca/Marcas_Add">Adicionar nova Marca</a><div class="space15"></div>');
        $linhas = $this->_Modelo->db->Sql_Select('Usuario_Veiculo_Marca');
        if ($linhas!==false && !empty($linhas)) {
            if (is_object($linhas)) $linhas = Array(0=>$linhas);
            reset($linhas);
            foreach ($linhas as $indice=>&$valor) {
                //$tabela['#Id'][$i]       = '#'.$valor->id;
                $tabela['Nome'][$i]      = $valor->nome;
                $tabela['Funções'][$i]   = $this->_Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Marca'        ,'usuario_veiculo/Marca/Marcas_Edit/'.$valor->id.'/'    ,'')).
                                           $this->_Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Marca'       ,'usuario_veiculo/Marca/Marcas_Del/'.$valor->id.'/'     ,'Deseja realmente deletar essa Marca ?'));
                ++$i;
            }
            $this->_Visual->Show_Tabela_DataTable($tabela);
            unset($tabela);
        } else {           
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhuma Marca</font></b></center>');
        }
        $titulo = __('Listagem de Marcas').' ('.$i.')';
        $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Administrar Marcas'));
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Marcas_Add() {
        self::Endereco_Veiculo_Marca(true);
        // Carrega Config
        $titulo1    = __('Adicionar Marca');
        $titulo2    = __('Salvar Marca');
        $formid     = 'form_Sistema_Admin_Marcas';
        $formbt     = __('Salvar');
        $formlink   = 'usuario_veiculo/Marca/Marcas_Add2/';
        $campos = Usuario_Veiculo_Marca_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos);
    }
    /**
     * 
     * 
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Marcas_Add2() {
        $titulo     = __('Marca Adicionada com Sucesso');
        $dao        = 'Usuario_Veiculo_Marca';
        $funcao     = '$this->Marcas();';
        $sucesso1   = __('Inserção bem sucedida');
        $sucesso2   = __('Marca cadastrada com sucesso.');
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);
    }
    /**
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Marcas_Edit($id) {
        self::Endereco_Veiculo_Marca(true);
        // Carrega Config
        $titulo1    = 'Editar Marca (#'.$id.')';
        $titulo2    = __('Alteração de Marca');
        $formid     = 'form_Sistema_AdminC_MarcaEdit';
        $formbt     = __('Alterar Marca');
        $formlink   = 'usuario_veiculo/Marca/Marcas_Edit2/'.$id;
        $editar     = Array('Usuario_Veiculo_Marca',$id);
        $campos = Usuario_Veiculo_Marca_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos,$editar);
    }
    /**
     * 
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Marcas_Edit2($id) {
        $titulo     = __('Marca Editada com Sucesso');
        $dao        = Array('Usuario_Veiculo_Marca',$id);
        $funcao     = '$this->Marcas();';
        $sucesso1   = __('Marca Alterada com Sucesso.');
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
    public function Marcas_Del($id) {
        
        
    	$id = (int) $id;
        // Puxa linha e deleta
        $linha = $this->_Modelo->db->Sql_Select('Usuario_Veiculo_Marca', Array('id'=>$id));
        $sucesso =  $this->_Modelo->db->Sql_Delete($linha);
        // Mensagem
    	if ($sucesso===true) {
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Deletada'),
                "mgs_secundaria" => __('Marca Deletada com sucesso')
            );
    	} else {
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Erro')
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        
        $this->Marcas();
        
        $this->_Visual->Json_Info_Update('Titulo', __('Marca deletada com Sucesso'));  
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
}
?>
