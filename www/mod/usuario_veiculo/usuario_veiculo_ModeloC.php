<?php
class usuario_veiculo_ModeloControle extends usuario_veiculo_Controle
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
    * @uses usuario_veiculo_Controle::$usuario_veiculoPerfil
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 2.0
    */
    public function Main(){
        $this->Modelos();
        // ORGANIZA E MANDA CONTEUDO
        $this->_Visual->Json_Info_Update('Titulo','Modelos'); 
    }
    static function Endereco_Veiculo_Modelo($true=true){
        $registro = \Framework\App\Registro::getInstacia();
        $_Controle = $registro->_Controle;
        $titulo = 'Modelos';
        $link = 'usuario_veiculo/Modelo/Modelos';
        // Chama Veiculo
        usuario_veiculo_MarcaControle::Endereco_Veiculo_Marca(true);
        //Chama
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
    public function Modelos(){
        self::Endereco_Veiculo_Modelo(false);
        $i = 0;
        $this->_Visual->Blocar('<a title="Adicionar Modelo" class="btn btn-success lajax explicar-titulo" acao="" href="'.URL_PATH.'usuario_veiculo/Modelo/Modelos_Add">Adicionar novo Modelo</a><div class="space15"></div>');
        $modelos = $this->_Modelo->db->Sql_Select('Usuario_Veiculo_Modelo');
        if($modelos!==false && !empty($modelos)){
            if(is_object($modelos)) $modelos = Array(0=>$modelos);
            reset($modelos);
            foreach ($modelos as $indice=>&$valor) {
                //$tabela['#Id'][$i]     = '#'.$valor->id;
                $tabela['Marca'][$i]     = $valor->marca2;
                $tabela['Nome'][$i]      = $valor->nome;
                $tabela['Funções'][$i]   = $this->_Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Modelo'        ,'usuario_veiculo/Modelo/Modelos_Edit/'.$valor->id.'/'    ,'')).
                                           $this->_Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Modelo'       ,'usuario_veiculo/Modelo/Modelos_Del/'.$valor->id.'/'     ,'Deseja realmente deletar essa Modelo ?'));
                ++$i;
            }
            $this->_Visual->Show_Tabela_DataTable($tabela);
            unset($tabela);
        }else{           
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhum Modelo</font></b></center>');
        }
        $titulo = 'Listagem de Modelos ('.$i.')';
        $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo','Administrar Modelos');
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Modelos_Add(){
        self::Endereco_Veiculo_Modelo(true);
        // Carrega Config
        $titulo1    = 'Adicionar Modelo';
        $titulo2    = 'Salvar Modelo';
        $formid     = 'form_Sistema_Admin_Modelos';
        $formbt     = 'Salvar';
        $formlink   = 'usuario_veiculo/Modelo/Modelos_Add2/';
        $campos = Usuario_Veiculo_Modelo_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos);
    }
    /**
     * 
     * @global Array $language
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Modelos_Add2(){
        $titulo     = 'Modelo Adicionada com Sucesso';
        $dao        = 'Usuario_Veiculo_Modelo';
        $funcao     = '$this->Main();';
        $sucesso1   = 'Inserção bem sucedida';
        $sucesso2   = 'Modelo cadastrada com sucesso.';
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);
    }
    /**
     * 
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Modelos_Edit($id){
        self::Endereco_Veiculo_Modelo(true);
        // Carrega Config
        $titulo1    = 'Editar Modelo (#'.$id.')';
        $titulo2    = 'Alteração de Modelo';
        $formid     = 'form_Sistema_AdminC_ModeloEdit';
        $formbt     = 'Alterar Modelo';
        $formlink   = 'usuario_veiculo/Modelo/Modelos_Edit2/'.$id;
        $editar     = Array('Usuario_Veiculo_Modelo',$id);
        $campos = Usuario_Veiculo_Modelo::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos,$editar);
    }
    /**
     * 
     * @global Array $language
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Modelos_Edit2($id){
        $titulo     = 'Modelo Editada com Sucesso';
        $dao        = Array('Usuario_Veiculo_Modelo',$id);
        $funcao     = '$this->Main();';
        $sucesso1   = 'Modelo Alterada com Sucesso.';
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
    public function Modelos_Del($id){
        global $language;
        
    	$id = (int) $id;
        // Puxa modelo e deleta
        $modelo = $this->_Modelo->db->Sql_Select('Usuario_Veiculo_Modelo', Array('id'=>$id));
        $sucesso =  $this->_Modelo->db->Sql_Delete($modelo);
        // Mensagem
    	if($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => 'Deletado',
                "mgs_secundaria" => 'Modelo Deletado com sucesso'
            );
    	}else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => $language['mens_erro']['erro'],
                "mgs_secundaria" => $language['mens_erro']['erro']
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        
        $this->Main();
        
        $this->_Visual->Json_Info_Update('Titulo', 'Modelo deletado com Sucesso');  
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
}
?>
