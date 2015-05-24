<?php
class usuario_mensagem_SetorControle extends usuario_mensagem_Controle
{
    /**
    * Construtor
    * 
    * @name __construct
    * @access public
    * 
    * @uses usuario_mensagem_rede_PerfilModelo::Carrega Rede Modelo
    * @uses usuario_mensagem_rede_PerfilVisual::Carrega Rede Visual
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
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 2.0
    */
    public function Main(){
        \Framework\App\Sistema_Funcoes::Redirect(URL_PATH.'usuario_mensagem/Setor/Setores/');
        return false;
    }
    static function Endereco_Setor($true=true){
        $registro = \Framework\App\Registro::getInstacia();
        $_Controle = $registro->_Controle;
        $titulo = 'Setores';
        $link = 'usuario_mensagem/Setor/Setores';
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
    public function Setores($export=false){
        self::Endereco_Setor(false);
        
        $tabela = Array(
            'Grupo','Nome','Email do Setor','Funções'
        );
        $this->_Visual->Show_Tabela_DataTable_Massiva($tabela,'usuario_mensagem/Setor/Setores');
        $titulo = 'Listagem de Setores (<span id="DataTable_Contador">0</span>)';  //
        $this->_Visual->Bloco_Unico_CriaJanela($titulo,'',10,Array("link"=>"usuario_mensagem/Setor/Setores_Add",'icon'=>'add','nome'=>'Adicionar Setor'));
        
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo','Administrar Setores');
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Setores_Add(){
        self::Endereco_Setor(true);
        // Carrega Config
        $titulo1    = 'Adicionar Setor';
        $titulo2    = 'Salvar Setor';
        $formid     = 'form_Sistema_Admin_Setores';
        $formbt     = 'Salvar';
        $formlink   = 'usuario_mensagem/Setor/Setores_Add2/';
        $campos = usuario_mensagem_Setor_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos);
    }
    /**
     * 
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Setores_Edit($id){
        self::Endereco_Setor(true);
        $id = (int) $id;
        // Carrega campos e retira os que nao precisam
        $campos = usuario_mensagem_Setor_DAO::Get_Colunas();
        // recupera setor
        $setor = $this->_Modelo->db->Sql_Select('Usuario_Mensagem_Setor', Array('id'=>$id));
        self::mysql_AtualizaValores($campos, $setor);

        // edicao de setores
        $form = new \Framework\Classes\Form('form_Sistema_AdminC_SetorEdit','usuario_mensagem/Setor/Setores_Edit2/'.$id.'/','formajax');
        \Framework\App\Controle::Gerador_Formulario($campos, $form);
        $formulario = $form->retorna_form('Alterar Setor');
        $this->_Visual->Blocar($formulario);
        $this->_Visual->Bloco_Unico_CriaJanela('Alteração de Setor');
        // Json
        $this->_Visual->Json_Info_Update('Titulo', 'Editar Setor (#'.$id.')');
        
    }
    /**
     * 
     * @global Array $language
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Setores_Add2(){
        $titulo     = 'Setor Adicionado com Sucesso';
        $dao        = 'usuario_mensagem_Setor';
        $funcao     = '$this->Setores();';
        $sucesso1   = 'Inserção bem sucedida';
        $sucesso2   = 'Setor cadastrado com sucesso.';
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
    public function Setores_Edit2($id){
        global $language;
        $id = (int) $id;
        // Puxa o setor, e altera seus valores, depois salva novamente
        $setor = $this->_Modelo->db->Sql_Select('Usuario_Mensagem_Setor', Array('id'=>$id));
        self::mysql_AtualizaValores($setor);
        $sucesso =  $this->_Modelo->db->Sql_Update($setor);
        // Atualiza
        $this->Setores();
        // Mensagem
        if($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => 'Setor Alterado com Sucesso',
                "mgs_secundaria" => ''.$_POST["nome"].' teve a alteração bem sucedida'
            );
        }else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => $language['mens_erro']['erro'],
                "mgs_secundaria" => $language['mens_erro']['erro']
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);  
        //Json
        $this->_Visual->Json_Info_Update('Titulo', 'Setor Editado com Sucesso');  
        $this->_Visual->Json_Info_Update('Historico', false);    
    }
    /**
     * 
     * @global Array $language
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Setores_Del($id){
        global $language;
        
    	$id = (int) $id;
        // Puxa setor e deleta
        $setor = $this->_Modelo->db->Sql_Select('Usuario_Mensagem_Setor', Array('id'=>$id));
        $sucesso =  $this->_Modelo->db->Sql_Delete($setor);
        // Mensagem
    	if($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => 'Deletado',
                "mgs_secundaria" => 'Setor Deletado com sucesso'
            );
    	}else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => $language['mens_erro']['erro'],
                "mgs_secundaria" => $language['mens_erro']['erro']
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        
        $this->Setores();
        
        $this->_Visual->Json_Info_Update('Titulo', 'Setor deletado com Sucesso');  
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
}
?>
