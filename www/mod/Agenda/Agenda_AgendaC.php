<?php
class Agenda_AgendaControle extends Agenda_Controle
{
    /**
    * Construtor
    * 
    * @name __construct
    * @access public
    * 
    * @uses Agenda_ListarModelo Carrega Agenda Modelo
    * @uses Agenda_ListarVisual Carrega Agenda Visual
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
    * @uses Agenda_Controle::$AgendaPerfil
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 0.4.2
    */
    public function Main() {
        $this->Agendas();
        // ORGANIZA E MANDA CONTEUDO
        $this->_Visual->Json_Info_Update('Titulo', __('Agendas')); 
    }
    protected function Endereco_Agenda($true= TRUE ) {
        if ($true === TRUE) {
            $this->Tema_Endereco(__('Agendas'),'Agenda/Agenda/Agendas');
        } else {
            $this->Tema_Endereco(__('Agendas'));
        }
    }
    public static function Agenda() {
        
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Agendas($export = FALSE) {
        $i = 0;
        $this->Endereco_Agenda(FALSE);
        // Botao Add
        
        $tabela_colunas = Array();

        $tabela_colunas[] = __('Id');
        $tabela_colunas[] = __('Motivo');
        $tabela_colunas[] = __('Motivo ID');
        $tabela_colunas[] = __('Data Inicio');
        $tabela_colunas[] = __('Data Fim');
        $tabela_colunas[] = __('Funções');

        $this->_Visual->Show_Tabela_DataTable_Massiva($tabela_colunas,'Agenda/Agenda/Agendas');
        $titulo = __('Listagem de Agendas').' (<span id="DataTable_Contador">0</span>)';
        $this->_Visual->Bloco_Unico_CriaJanela($titulo, '',10,Array("link"=>"Agenda/Agenda/Agendas_Add",'icon'=>'add', 'nome'=>__('Adicionar Agenda')));
        
        
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Agendas'));
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Agendas_Add() { 
        $this->Endereco_Agenda();  
        // Carrega Config
        $titulo1    = __('Adicionar Agenda');
        $titulo2    = __('Salvar Agenda');
        $formid     = 'form_Sistema_Admin_Agendas';
        $formbt     = __('Salvar');
        $formlink   = 'Agenda/Agenda/Agendas_Add2/';
        $campos = Agenda_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1, $titulo2, $formlink, $formid, $formbt, $campos);
    }
    /**
     * 
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Agendas_Add2() {
        $titulo     = __('Agenda Adicionada com Sucesso');
        $dao        = 'Agenda';
        $funcao     = '$this->Agendas();';
        $sucesso1   = __('Inserção bem sucedida');
        $sucesso2   = __('Agenda cadastrado com sucesso.');
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo, $dao, $funcao, $sucesso1, $sucesso2, $alterar);
    }
    /**
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Agendas_Edit($id) {
        $this->Endereco_Agenda();
        // Carrega Config
        $titulo1    = 'Editar Agenda (#'.$id.')';
        $titulo2    = __('Alteração de Agenda');
        $formid     = 'form_Sistema_AdminC_AgendaEdit';
        $formbt     = __('Alterar Agenda');
        $formlink   = 'Agenda/Agenda/Agendas_Edit2/'.$id;
        $editar     = Array('Agenda', $id);
        $campos = Agenda_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1, $titulo2, $formlink, $formid, $formbt, $campos, $editar);
    }
    /**
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Agendas_Edit2($id) {
        $titulo     = __('Agenda Editada com Sucesso');
        $dao        = Array('Agenda', $id);
        $funcao     = '$this->Agendas();';
        $sucesso1   = __('Agenda Alterada com Sucesso.');
        $sucesso2   = ''.$_POST["nome"].' teve a alteração bem sucedida';
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo, $dao, $funcao, $sucesso1, $sucesso2, $alterar);      
    }
    /**
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Agendas_Del($id) {
    	$id = (int) $id;
        // Puxa compromisso e deleta
        $compromisso = $this->_Modelo->db->Sql_Select('Agenda', Array('id'=>$id));
        $sucesso =  $this->_Modelo->db->Sql_Delete($compromisso);
        // Mensagem
    	if ($sucesso === TRUE) {
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Deletado'),
                "mgs_secundaria" => __('Agenda Deletado com sucesso')
            );
    	} else {
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Erro')
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens', $mensagens);
        
        $this->Agendas();
        
        $this->_Visual->Json_Info_Update('Titulo', __('Agenda deletado com Sucesso'));  
        $this->_Visual->Json_Info_Update('Historico', FALSE);  
    }
}
?>
