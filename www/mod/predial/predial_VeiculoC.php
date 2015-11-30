<?php
class predial_VeiculoControle extends predial_Controle
{
    public function __construct() {
        parent::__construct();
    }
    /**
    * Main
    * 
    * @name Main
    * @access public
    * 
    * @uses predial_Controle::$comercioPerfil
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 0.4.24
    */
    public function Main() {
        \Framework\App\Sistema_Funcoes::Redirect(URL_PATH.'predial/Veiculo/Veiculos');
        return false;
    }
    static function Endereco_Veiculo($true= true ) {
        $Registro = &\Framework\App\Registro::getInstacia();
        $_Controle = $Registro->_Controle;
        $titulo = __('Veiculos');
        $link = 'predial/Veiculo/Veiculos';
        if ($true === true) {
            $_Controle->Tema_Endereco($titulo, $link);
        } else {
            $_Controle->Tema_Endereco($titulo);
        }
    }
    static function Veiculos_Tabela(&$veiculos) {
        $Registro   = &\Framework\App\Registro::getInstacia();
        $Visual     = &$Registro->_Visual;
        $table = Array();
        $i = 0;
        if (is_object($veiculos)) $veiculos = Array(0=>$veiculos);
        reset($veiculos);
        foreach ($veiculos as &$valor) {
            $table[__('Bloco')][$i]            = $valor->bloco2;
            $table[__('Apartamento')][$i]      = $valor->apart2;
            $table[__('Modelo')][$i]           = $valor->modelo;
            $table[__('Placa')][$i]            = $valor->placa;
            $table[__('Marca')][$i]            = $valor->marca;
            $table[__('Funções')][$i]          = $Visual->Tema_Elementos_Btn('Editar'     ,Array(__('Editar Veiculo')        ,'predial/Veiculo/Veiculos_Edit/'.$valor->id.'/'    , '')).
                                              $Visual->Tema_Elementos_Btn('Deletar'    ,Array(__('Deletar Veiculo')       ,'predial/Veiculo/Veiculos_Del/'.$valor->id.'/'     , __('Deseja realmente deletar esse Veiculo ?')));
            ++$i;
        }
        return Array($table, $i);
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.24
     */
    public function Veiculos() {
        self::Endereco_Veiculo(false);
        $i = 0;
        // Botao Add
        $this->_Visual->Blocar($this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            Array(
                'Adicionar Veiculo',
                'predial/Veiculo/Veiculos_Add',
                ''
            ),
            Array(
                'Print'     => true,
                'Pdf'       => true,
                'Excel'     => true,
                'Link'      => 'predial/Veiculo/Veiculos',
            )
        )));
        // Busca
        $veiculos = $this->_Modelo->db->Sql_Select('Predial_Bloco_Apart_Veiculo');
        if ($veiculos !== false && !empty($veiculos)) {
            list($table, $i) = self::Veiculos_Tabela($veiculos);
            $this->_Visual->Show_Tabela_DataTable($table);
            unset($table);
        } else {       
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhum Veiculo</font></b></center>');
        }
        $titulo = __('Listagem de Veiculos').' ('.$i.')';
        $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Administrar Veiculos'));
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.24
     */
    public function Veiculos_Add() {
        self::Endereco_Veiculo();
        // Carrega Config
        $titulo1    = __('Adicionar Veiculo');
        $titulo2    = __('Salvar Veiculo');
        $formid     = 'form_Sistema_Admin_Veiculos';
        $formbt     = __('Salvar');
        $formlink   = 'predial/Veiculo/Veiculos_Add2/';
        $campos = Predial_Bloco_Apart_Veiculo_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1, $titulo2, $formlink, $formid, $formbt, $campos);
    }
    /**
     * 
     * 
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.24
     */
    public function Veiculos_Add2() {
        $titulo     = __('Veiculo Adicionado com Sucesso');
        $dao        = 'Predial_Bloco_Apart_Veiculo';
        $function     = '$this->Veiculos();';
        $sucesso1   = __('Inserção bem sucedida');
        $sucesso2   = __('Veiculo cadastrado com sucesso.');
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo, $dao, $function, $sucesso1, $sucesso2, $alterar);
    }
    /**
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.24
     */
    public function Veiculos_Edit($id) {
        self::Endereco_Veiculo();
        // Carrega Config
        $titulo1    = 'Editar Veiculo (#'.$id.')';
        $titulo2    = __('Alteração de Veiculo');
        $formid     = 'form_Sistema_AdminC_VeiculoEdit';
        $formbt     = __('Alterar Veiculo');
        $formlink   = 'predial/Veiculo/Veiculos_Edit2/'.$id;
        $editar     = Array('Predial_Bloco_Apart_Veiculo', $id);
        $campos = Predial_Bloco_Apart_Veiculo_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1, $titulo2, $formlink, $formid, $formbt, $campos, $editar);
    }
    /**
     * 
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.24
     */
    public function Veiculos_Edit2($id) {
        $titulo     = __('Veiculo Editado com Sucesso');
        $dao        = Array('Predial_Bloco_Apart_Veiculo', $id);
        $function     = '$this->Veiculos();';
        $sucesso1   = __('Veiculo Alterado com Sucesso.');
        $sucesso2   = ''.$_POST["nome"].' teve a alteração bem sucedida';
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo, $dao, $function, $sucesso1, $sucesso2, $alterar);   
    }
    /**
     * 
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.24
     */
    public function Veiculos_Del($id) {
        
        
    	$id = (int) $id;
        // Puxa veiculo e deleta
        $veiculo = $this->_Modelo->db->Sql_Select('Predial_Bloco_Apart_Veiculo', Array('id'=>$id));
        $sucesso =  $this->_Modelo->db->Sql_Delete($veiculo);
        // Mensagem
    	if ($sucesso === true) {
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Deletado'),
                "mgs_secundaria" => __('Veiculo deletado com sucesso')
            );
    	} else {
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Erro')
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens', $mensagens);
        
        $this->Veiculos();
        
        $this->_Visual->Json_Info_Update('Titulo', __('Veiculo deletado com Sucesso'));  
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
}
?>
