<?php
class comercio_servicos_ServicoTipoControle extends comercio_servicos_Controle
{
    /**
    * Construtor
    * 
    * @name __construct
    * @access public
    * 
    * @uses comercio_servicos_rede_PerfilModelo::Carrega Rede Modelo
    * @uses comercio_servicos_rede_PerfilVisual::Carrega Rede Visual
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 0.4.2
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
    * @uses comercio_servicos_Controle::$servicosPerfil
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 0.4.2
    */
    public function Main(){
        \Framework\App\Sistema_Funcoes::Redirect(URL_PATH.'comercio_servicos/ServicoTipo/Servico_Tipo');
        return false;
    }
    static function Endereco_Servico_Tipo($true=true){
        $Registro = &\Framework\App\Registro::getInstacia();
        $_Controle = $Registro->_Controle;
        if ($true===true){
            $_Controle->Tema_Endereco(__('Tipos de Serviços'),'comercio_servicos/Servico_Tipo/Servico_Tipo');
        } else {
            $_Controle->Tema_Endereco(__('Tipos de Serviços'));
        }
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Servico_Tipo(){
        self::Endereco_Servico_Tipo(false);
        $tabela_colunas = Array();

        $tabela_colunas[] = __('Nome');
        $tabela_colunas[] = __('Funções');

        $this->_Visual->Show_Tabela_DataTable_Massiva($tabela_colunas,'comercio_servicos/ServicoTipo/Servico_Tipo');
        $titulo = __('Listagem de Serviços');
        $this->_Visual->Bloco_Unico_CriaJanela($titulo.' (<span id="DataTable_Contador">0</span>)','',10,Array("link"=>"comercio_servicos/ServicoTipo/Servico_Tipo_Add",'icon'=>'add','nome'=>'Adicionar Tipo de Serviço'));

        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Administrar Tipos de Serviços'));
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Servico_Tipo_Add(){
        // Carrega Config
        $titulo1    = __('Adicionar Tipo de Serviço');
        $titulo2    = __('Salvar Tipo de Serviço');
        $formid     = 'form_comercio_servicotipo';
        $formbt     = __('Salvar');
        $formlink   = 'comercio_servicos/ServicoTipo/Servico_Tipo_Add2/';
        $campos = Comercio_Servicos_Servico_Tipo_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos);
    }
    /**
     * 
     * 
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Servico_Tipo_Add2(){
        $titulo     = __('Tipo de Serviço adicionada com Sucesso');
        $dao        = 'Comercio_Servicos_Servico_Tipo';
        $funcao     = '$this->Servico_Tipo();';
        $sucesso1   = __('Inserção bem sucedida');
        $sucesso2   = __('Tipo de Serviço cadastrada com sucesso.');
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);
    }
    /**
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Servico_Tipo_Edit($id){
        // Carrega Config
        $titulo1    = 'Editar Tipo de Serviço (#'.$id.')';
        $titulo2    = __('Alteração de Tipo de Serviço');
        $formid     = 'form_Sistema_ServicoTipoC_Tipo de ServiçoEdit';
        $formbt     = __('Alterar Tipo de Serviço');
        $formlink   = 'comercio_servicos/ServicoTipo/Servico_Tipo_Edit2/'.$id;
        $editar     = Array('Comercio_Servicos_Servico_Tipo',$id);
        $campos = Comercio_Servicos_Servico_Tipo_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos,$editar);
    }
    /**
     * 
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Servico_Tipo_Edit2($id){
        $titulo     = __('Tipo de Serviço editada com Sucesso');
        $dao        = Array('Comercio_Servicos_Servico_Tipo',$id);
        $funcao     = '$this->Servico_Tipo();';
        $sucesso1   = __('Tipo de Serviço Alterada com Sucesso.');
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
    public function Servico_Tipo_Del($id){
        
        
    	$id = (int) $id;
        // Puxa setor e deleta
        $setor = $this->_Modelo->db->Sql_Select('Comercio_Servicos_Servico_Tipo', Array('id'=>$id));
        $sucesso =  $this->_Modelo->db->Sql_Delete($setor);
        // Mensagem
    	if ($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Deletado'),
                "mgs_secundaria" => __('Tipo de Serviço deletada com sucesso')
            );
    	} else {
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Erro')
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        
        $this->Servico_Tipo();
        
        $this->_Visual->Json_Info_Update('Titulo', __('Tipo de Serviço deletada com Sucesso'));  
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
}
?>
