<?php
class Desenvolvimento_TarefaControle extends Desenvolvimento_Controle
{
    /**
    * Construtor
    * 
    * @name __construct
    * @access public
    * 
    * @uses Desenvolvimento_ListarModelo Carrega tarefa Modelo
    * @uses Desenvolvimento_ListarVisual Carrega tarefa Visual
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 0.4.2
    */
    public function __construct() {
        parent::__construct();
    }
    protected function Endereco_Tarefa($true= TRUE ) {
        if ($true === TRUE) {
            $this->Tema_Endereco(__('Tarefas'),'Desenvolvimento/Tarefa/Tarefas');
        } else {
            $this->Tema_Endereco(__('Tarefas'));
        }
    }
    /**
    * Main
    * 
    * @name Main
    * @access public
    * 
    * @uses Desenvolvimento_Controle::$tarefaPerfil
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 0.4.2
    */
    public function Main() {
        return FALSE;
    }
    static function Tarefas_Tabela($tarefas) {
        $Registro   = &\Framework\App\Registro::getInstacia();
        $Visual     = &$Registro->_Visual;
        $table = Array();
        $i = 0;
        if (is_object($tarefas)) $tarefas = Array(0=>$tarefas);
        reset($tarefas);
        foreach ($tarefas as $indice=>&$valor) {
            $table['#Id'][$i]          =   '#'.$valor->id;
            $table['Categoria'][$i]    =   $valor->categoria2;
            $table['Projeto'][$i]      =   $valor->projeto2;
            $table['Fk'][$i]            =   $valor->framework;
            $table['Fk - Mód'][$i]     =   $valor->framework_modulo;
            $table['Fk - SubMód'][$i]  =   $valor->framework_submodulo;
            $table['Fk - Mét'][$i]     =   $valor->framework_metodo;
            $table['Descrição'][$i]    =   $valor->descricao;
            $table['Funções'][$i]      =   $Visual->Tema_Elementos_Btn('Editar'          ,Array('Editar Tarefa'        ,'Desenvolvimento/Tarefa/Tarefas_Edit/'.$valor->id.'/'    , '')).
                                            $Visual->Tema_Elementos_Btn('Deletar'         ,Array('Deletar Tarefa'       ,'Desenvolvimento/Tarefa/Tarefas_Del/'.$valor->id.'/'     ,'Deseja realmente deletar esse Tarefa ?'));
            ++$i;
        }
        return Array($table, $i);
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Tarefas($export = FALSE) {
        $this->Endereco_Tarefa(FALSE);
        $i = 0;
        // Add BOtao
        $this->_Visual->Blocar($this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            Array(
                'Adicionar Tarefa',
                'Desenvolvimento/Tarefa/Tarefas_Add',
                ''
            ),
            Array(
                'Print'     => TRUE,
                'Pdf'       => TRUE,
                'Excel'     => TRUE,
                'Link'      => 'Desenvolvimento/Tarefa/Tarefas',
            )
        )));
        // Query
        $tarefas = $this->_Modelo->db->Sql_Select('Desenvolvimento_Projeto_Tarefa');
        if ($tarefas !== FALSE && !empty($tarefas)) {
            list($table, $i) = self::Tarefas_Tabela($tarefas);
            if ($export !== FALSE) {
                self::Export_Todos($export, $table, 'Tarefas');
            } else {
                $this->_Visual->Show_Tabela_DataTable(
                    $table,     // Array Com a Tabela
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
            unset($table);
        } else {    
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhuma Tarefa</font></b></center>');
        }
        $titulo = __('Listagem de Tarefas').' ('.$i.')';
        $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Administrar Tarefas'));
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Tarefas_Add() {
        $this->Endereco_Tarefa();
        // Carrega Config
        $titulo1    = __('Adicionar Tarefa');
        $titulo2    = __('Salvar Tarefa');
        $formid     = 'form_Sistema_Admin_Tarefas';
        $formbt     = __('Salvar');
        $formlink   = 'Desenvolvimento/Tarefa/Tarefas_Add2/';
        $campos = Desenvolvimento_Projeto_Tarefa_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1, $titulo2, $formlink, $formid, $formbt, $campos);
    }
    /**
     * 
     * 
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Tarefas_Add2() {
        $titulo     = __('Tarefa Adicionada com Sucesso');
        $dao        = 'Desenvolvimento_Projeto_Tarefa';
        $function     = '$this->Tarefas();';
        $sucesso1   = __('Inserção bem sucedida');
        $sucesso2   = __('Tarefa cadastrada com sucesso.');
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo, $dao, $function, $sucesso1, $sucesso2, $alterar);
    }
    /**
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Tarefas_Edit($id) {
        $this->Endereco_Tarefa();
        // Carrega Config
        $titulo1    = 'Editar Tarefa (#'.$id.')';
        $titulo2    = __('Alteração de Tarefa');
        $formid     = 'form_Sistema_AdminC_TarefaEdit';
        $formbt     = __('Alterar Tarefa');
        $formlink   = 'Desenvolvimento/Tarefa/Tarefas_Edit2/'.$id;
        $editar     = Array('Desenvolvimento_Projeto_Tarefa', $id);
        $campos = Desenvolvimento_Projeto_Tarefa_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1, $titulo2, $formlink, $formid, $formbt, $campos, $editar);
    }
    /**
     * 
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Tarefas_Edit2($id) {
        $titulo     = __('Tarefa Editada com Sucesso');
        $dao        = Array('Desenvolvimento_Projeto_Tarefa', $id);
        $function     = '$this->Tarefas();';
        $sucesso1   = __('Tarefa Alterada com Sucesso.');
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
    public function Tarefas_Del($id) {
        
        
    	$id = (int) $id;
        // Puxa linha e deleta
        $linha = $this->_Modelo->db->Sql_Select('Desenvolvimento_Projeto_Tarefa', Array('id'=>$id));
        $sucesso =  $this->_Modelo->db->Sql_Delete($linha);
        // Mensagem
    	if ($sucesso === TRUE) {
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Deletado'),
                "mgs_secundaria" => __('Tarefa Deletada com sucesso')
            );
    	} else {
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Erro')
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens', $mensagens);
        
        $this->Tarefas();
        
        $this->_Visual->Json_Info_Update('Titulo', __('Tarefa Deletada com Sucesso'));  
        $this->_Visual->Json_Info_Update('Historico', FALSE);  
    }
}

