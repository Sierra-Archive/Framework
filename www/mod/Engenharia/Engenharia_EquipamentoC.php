<?php
class Engenharia_EquipamentoControle extends Engenharia_Controle
{
    /**
    * Construtor
    * 
    * @name __construct
    * @access public
    * 
    * @uses Engenharia_ListarModelo Carrega Engenharia Modelo
    * @uses Engenharia_ListarVisual Carrega Engenharia Visual
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
    * @uses Engenharia_Controle::$EngenhariaPerfil
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 2.0
    */
    public function Main(){
        \Framework\App\Sistema_Funcoes::Redirect(URL_PATH.'Engenharia/Equipamento/Equipamentos');
        return false;
    }
    protected function Endereco_Equipamento($true=true){
        if($true===true){
            $this->Tema_Endereco('Equipamentos','Engenharia/Equipamento/Equipamentos');
        }else{
            $this->Tema_Endereco('Equipamentos');
        }
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Equipamentos(){
        $this->Endereco_Equipamento(false);
        $i = 0;
        // Botao Add
        $this->_Visual->Blocar($this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            Array(
                'Adicionar Equipamento',
                'Engenharia/Equipamento/Equipamentos_Add',
                ''
            ),
            Array(
                'Print'     => true,
                'Pdf'       => true,
                'Excel'     => true,
                'Engenharia/Equipamento/Equipamentos',
            )
        )));
        // Conexao
        $linhas = $this->_Modelo->db->Sql_Select('Engenharia_Equipamento');
        if($linhas!==false && !empty($linhas)){
            if(is_object($linhas)) $linhas = Array(0=>$linhas);
            reset($linhas);
            foreach ($linhas as $indice=>&$valor) {
                //$tabela['#Id'][$i]       = '#'.$valor->id;
                $tabela['Tipo de Equipamento'][$i]  =   $valor->categoria2;
                $tabela['Equipamento'][$i]          =   $valor->nome;
                $tabela['Data Aquisição'][$i]       =   $valor->data_aquisicao;
                $tabela['Valor'][$i]                =   $valor->valor;
                $tabela['Funções'][$i]              =   $this->_Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Equipamento'        ,'Engenharia/Equipamento/Equipamentos_Edit/'.$valor->id.'/'    ,'')).
                                                        $this->_Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Equipamento'       ,'Engenharia/Equipamento/Equipamentos_Del/'.$valor->id.'/'     ,'Deseja realmente deletar essa Equipamento ?'));
                ++$i;
            }
            $this->_Visual->Show_Tabela_DataTable($tabela);
            unset($tabela);
        }else{           
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhum Equipamento</font></b></center>');
        }
        $titulo = 'Listagem de Equipamentos ('.$i.')';
        $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Administrar Equipamentos'));
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Equipamentos_Add(){  
        $this->Endereco_Equipamento();      
        // Carrega Config
        $titulo1    = 'Adicionar Equipamento';
        $titulo2    = 'Salvar Equipamento';
        $formid     = 'form_Sistema_Admin_Equipamentos';
        $formbt     = 'Salvar';
        $formlink   = 'Engenharia/Equipamento/Equipamentos_Add2/';
        $campos = Engenharia_Equipamento_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos);
    }
    /**
     * 
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Equipamentos_Add2(){
        $titulo     = 'Equipamento Adicionado com Sucesso';
        $dao        = 'Engenharia_Equipamento';
        $funcao     = '$this->Equipamentos();';
        $sucesso1   = 'Inserção bem sucedida';
        $sucesso2   = 'Equipamento cadastrado com sucesso.';
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);
    }
    /**
     * 
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Equipamentos_Edit($id){
        $this->Endereco_Equipamento();      
        // Carrega Config
        $titulo1    = 'Editar Equipamento (#'.$id.')';
        $titulo2    = 'Alteração de Equipamento';
        $formid     = 'form_Sistema_AdminC_EquipamentoEdit';
        $formbt     = 'Alterar Equipamento';
        $formlink   = 'Engenharia/Equipamento/Equipamentos_Edit2/'.$id;
        $editar     = Array('Engenharia_Equipamento',$id);
        $campos = Engenharia_Equipamento_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos,$editar);
    }
    /**
     * 
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Equipamentos_Edit2($id){
        $titulo     = 'Equipamento Editado com Sucesso';
        $dao        = Array('Engenharia_Equipamento',$id);
        $funcao     = '$this->Equipamentos();';
        $sucesso1   = 'Equipamento Alterado com Sucesso.';
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
    public function Equipamentos_Del($id){
        global $language;
        
    	$id = (int) $id;
        // Puxa linha e deleta
        $linha = $this->_Modelo->db->Sql_Select('Engenharia_Equipamento', Array('id'=>$id));
        $sucesso =  $this->_Modelo->db->Sql_Delete($linha);
        // Mensagem
    	if($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Deletado'),
                "mgs_secundaria" => __('Equipamento Deletado com sucesso')
            );
    	}else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => $language['mens_erro']['erro'],
                "mgs_secundaria" => $language['mens_erro']['erro']
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        
        $this->Equipamentos();
        
        $this->_Visual->Json_Info_Update('Titulo', __('Equipamento deletado com Sucesso'));  
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
}
?>
