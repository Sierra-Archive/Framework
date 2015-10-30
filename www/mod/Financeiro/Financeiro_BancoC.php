<?php
class Financeiro_BancoControle extends Financeiro_Controle
{
    /**
    * Construtor
    * 
    * @name __construct
    * @access public
    * 
    * @uses financeiro_ListarModelo Carrega financeiro Modelo
    * @uses financeiro_ListarVisual Carrega financeiro Visual
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
    * @uses Financeiro_Controle::$financeiroPerfil
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 0.4.2
    */
    public function Main(){
        \Framework\App\Sistema_Funcoes::Redirect(URL_PATH.'Financeiro/Banco/Bancos');
        return false;
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Bancos(){
        $i = 0;
        // add botao
        $this->_Visual->Blocar($this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            Array(
                'Adicionar Banco',
                'Financeiro/Banco/Bancos_Add',
                ''
            ),
            Array(
                'Print'     => true,
                'Pdf'       => true,
                'Excel'     => true,
                'Link'     => 'Financeiro/Banco/Bancos',
            )
        )));
        $linhas = $this->_Modelo->db->Sql_Select('Financeiro_Banco');
        if ($linhas!==false && !empty($linhas)){
            if (is_object($linhas)) $linhas = Array(0=>$linhas);
            reset($linhas);
            foreach ($linhas as $indice=>&$valor) {
                //$tabela['#Id'][$i]       = '#'.$valor->id;
                $tabela['Nome'][$i]      = $valor->nome;
                $tabela['Funções'][$i]   = /*$this->_Visual->Tema_Elementos_Btn('Visualizar'      ,Array('Visualizar Banco'    ,'Financeiro/Banco/Bancos_View/'.$valor->id.'/'    ,'')).*/
                                           $this->_Visual->Tema_Elementos_Btn('Editar'          ,Array('Editar Banco'        ,'Financeiro/Banco/Bancos_Edit/'.$valor->id.'/'    ,'')).
                                           $this->_Visual->Tema_Elementos_Btn('Deletar'         ,Array('Deletar Banco'       ,'Financeiro/Banco/Bancos_Del/'.$valor->id.'/'     ,'Deseja realmente deletar esse Banco ?'));
                ++$i;
            }
            $this->_Visual->Show_Tabela_DataTable($tabela);
            unset($tabela);
        } else {         
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhum Banco</font></b></center>');
        }
        $titulo = __('Listagem de Bancos').' ('.$i.')';
        $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Administrar Bancos'));
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Bancos_Add(){
        // Carrega Config
        $titulo1    = __('Adicionar Banco');
        $titulo2    = __('Salvar Banco');
        $formid     = 'form_Sistema_Admin_Bancos';
        $formbt     = __('Salvar');
        $formlink   = 'Financeiro/Banco/Bancos_Add2/';
        $campos = Financeiro_Banco_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos);
    }
    /**
     * 
     * 
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Bancos_Add2(){
        $titulo     = __('Banco Adicionado com Sucesso');
        $dao        = 'Financeiro_Banco';
        $funcao     = '$this->Bancos();';
        $sucesso1   = __('Inserção bem sucedida');
        $sucesso2   = __('Banco cadastrado com sucesso.');
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);
    }
    /**
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Bancos_Edit($id){
        // Carrega Config
        $titulo1    = 'Editar Banco (#'.$id.')';
        $titulo2    = __('Alteração de Banco');
        $formid     = __('form_Sistema_AdminC_BancoEdit');
        $formbt     = __('Alterar Banco');
        $formlink   = 'Financeiro/Banco/Bancos_Edit2/'.$id;
        $editar     = Array('Financeiro_Banco',$id);
        $campos = Financeiro_Banco_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos,$editar);
    }
    /**
     * 
     * 
     * @param int $id Chave Primária (Id do Registro)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Bancos_Edit2($id){
        $titulo     = __('Banco Editado com Sucesso');
        $dao        = Array('Financeiro_Banco',$id);
        $funcao     = '$this->Bancos();';
        $sucesso1   = __('Banco Alterado com Sucesso.');
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
    public function Bancos_Del($id){
        
        
    	$id = (int) $id;
        // Puxa linha e deleta
        $linha = $this->_Modelo->db->Sql_Select('Financeiro_Banco', Array('id'=>$id));
        $sucesso =  $this->_Modelo->db->Sql_Delete($linha);
        // Mensagem
    	if ($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Deletado'),
                "mgs_secundaria" => __('Banco Deletado com sucesso')
            );
    	} else {
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Erro')
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        
        $this->Bancos();
        
        $this->_Visual->Json_Info_Update('Titulo', __('Banco deletado com Sucesso'));  
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
}
?>
