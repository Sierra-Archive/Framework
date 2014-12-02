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
    * @uses comercio_servicos_Controle::$servicosPerfil
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 2.0
    */
    public function Main(){
        \Framework\App\Sistema_Funcoes::Redirect(URL_PATH.'comercio_servicos/ServicoTipo/Servico_Tipo');
        return false;
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Servico_Tipo($export = false){
        $i = 0;
        $this->_Visual->Blocar($this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            Array(
                'Adicionar Tipo de Serviço',
                'comercio_servicos/ServicoTipo/Servico_Tipo_Add',
                ''
            ),
            Array(
                'Print'     => true,
                'Pdf'       => true,
                'Excel'     => true,
                'Link'      => 'comercio_servicos/ServicoTipo/Servico_Tipo',
            )
        )));
        $setores = $this->_Modelo->db->Sql_Select('Comercio_Servicos_Servico_Tipo');
        if($setores!==false && !empty($setores)){
            if(is_object($setores)) $setores = Array(0=>$setores);
            reset($setores);
            foreach ($setores as $indice=>&$valor) {
                $tabela['Nome'][$i]             = $valor->nome;
                $tabela['Funções'][$i]          = $this->_Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Tipo de Serviço'        ,'comercio_servicos/ServicoTipo/Servico_Tipo_Edit/'.$valor->id.'/'    ,'')).
                                                  $this->_Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Tipo de Serviço'       ,'comercio_servicos/ServicoTipo/Servico_Tipo_Del/'.$valor->id.'/'     ,'Deseja realmente deletar esse Tipo de Serviço ?'));
                ++$i;
            }
            if($export!==false){
                self::Export_Todos($export,$tabela, 'Tipo de Serviço');
            }else{
                $this->_Visual->Show_Tabela_DataTable($tabela);
            }
            unset($tabela);
        }else{          
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhum Tipo de Serviço</font></b></center>');
        }
        $titulo = 'Tipos de Serviços ('.$i.')';
        $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo','Administrar Tipos de Serviços');
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Servico_Tipo_Add(){
        // Carrega Config
        $titulo1    = 'Adicionar Tipo de Serviço';
        $titulo2    = 'Salvar Tipo de Serviço';
        $formid     = 'form_comercio_servicotipo';
        $formbt     = 'Salvar';
        $formlink   = 'comercio_servicos/ServicoTipo/Servico_Tipo_Add2/';
        $campos = Comercio_Servicos_Servico_Tipo_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos);
    }
    /**
     * 
     * @global Array $language
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Servico_Tipo_Add2(){
        $titulo     = 'Tipo de Serviço adicionada com Sucesso';
        $dao        = 'Comercio_Servicos_Servico_Tipo';
        $funcao     = '$this->Servico_Tipo();';
        $sucesso1   = 'Inserção bem sucedida';
        $sucesso2   = 'Tipo de Serviço cadastrada com sucesso.';
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);
    }
    /**
     * 
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Servico_Tipo_Edit($id){
        // Carrega Config
        $titulo1    = 'Editar Tipo de Serviço (#'.$id.')';
        $titulo2    = 'Alteração de Tipo de Serviço';
        $formid     = 'form_Sistema_ServicoTipoC_Tipo de ServiçoEdit';
        $formbt     = 'Alterar Tipo de Serviço';
        $formlink   = 'comercio_servicos/ServicoTipo/Servico_Tipo_Edit2/'.$id;
        $editar     = Array('Comercio_Servicos_Servico_Tipo',$id);
        $campos = Comercio_Servicos_Servico_Tipo_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos,$editar);
    }
    /**
     * 
     * @global Array $language
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Servico_Tipo_Edit2($id){
        $titulo     = 'Tipo de Serviço editada com Sucesso';
        $dao        = Array('Comercio_Servicos_Servico_Tipo',$id);
        $funcao     = '$this->Servico_Tipo();';
        $sucesso1   = 'Tipo de Serviço Alterada com Sucesso.';
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
    public function Servico_Tipo_Del($id){
        global $language;
        
    	$id = (int) $id;
        // Puxa setor e deleta
        $setor = $this->_Modelo->db->Sql_Select('Comercio_Servicos_Servico_Tipo', Array('id'=>$id));
        $sucesso =  $this->_Modelo->db->Sql_Delete($setor);
        // Mensagem
    	if($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => 'Deletado',
                "mgs_secundaria" => 'Tipo de Serviço deletada com sucesso'
            );
    	}else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => $language['mens_erro']['erro'],
                "mgs_secundaria" => $language['mens_erro']['erro']
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        
        $this->Servico_Tipo();
        
        $this->_Visual->Json_Info_Update('Titulo', 'Tipo de Serviço deletada com Sucesso');  
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
}
?>
