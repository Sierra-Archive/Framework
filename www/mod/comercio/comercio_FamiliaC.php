<?php
class comercio_FamiliaControle extends comercio_Controle
{
    /**
    * Construtor
    * 
    * @name __construct
    * @access public
    * 
    * @uses comercio_rede_PerfilModelo::Carrega Rede Modelo
    * @uses comercio_rede_PerfilVisual::Carrega Rede Visual
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
    * @uses comercio_Controle::$comercioPerfil
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 2.0
    */
    public function Main(){
        \Framework\App\Sistema_Funcoes::Redirect(URL_PATH.'comercio/Familia/Familias');
        return false;
    }
    static function Endereco_Familia($true=true){
        $registro = \Framework\App\Registro::getInstacia();
        $_Controle = $registro->_Controle;
        $titulo = 'Familias';
        $link = 'comercio/Familia/Familias';
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
    public function Familias($export=false){
        self::Endereco_Familia(false);
        $i = 0;
        // BOTAO IMPRIMIR / ADD
        $this->_Visual->Blocar($this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            Array(
                'Adicionar Familia',
                'comercio/Familia/Familias_Add',
                ''
            ),
            Array(
                'Print'     => true,
                'Pdf'       => true,
                'Excel'     => true,
                'Link'      => 'comercio/Familia/Familias',
            )
        )));
        // CONEXAO
        $linhas = $this->_Modelo->db->Sql_Select('Comercio_Familia');
        if($linhas!==false && !empty($linhas)){
            if(is_object($linhas)) $linhas = Array(0=>$linhas);
            reset($linhas);
            foreach ($linhas as $indice=>&$valor) {
                //$tabela['#Id'][$i]       = '#'.$valor->id;
                $tabela['Nome'][$i]      = $valor->nome;
                $tabela['Funções'][$i]   = $this->_Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Familia'        ,'comercio/Familia/Familias_Edit/'.$valor->id.'/'    ,'')).
                                           $this->_Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Familia'       ,'comercio/Familia/Familias_del/'.$valor->id.'/'     ,'Deseja realmente deletar essa Familia ?'));
                ++$i;
            }
            if($export!==false){
                self::Export_Todos($export,$tabela, 'Comercio - Produtos (Familias)');
            }else{
                $this->_Visual->Show_Tabela_DataTable($tabela);
            }
            unset($tabela);
        }else{          
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhuma Familia</font></b></center>');
        }
        $titulo = 'Listagem de Familias ('.$i.')';
        $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo','Administrar Familias');
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Familias_Add(){
        self::Endereco_Familia(true);
        // Carrega Config
        $titulo1    = 'Adicionar Familia';
        $titulo2    = 'Salvar Familia';
        $formid     = 'form_Sistema_Admin_Familias';
        $formbt     = 'Salvar';
        $formlink   = 'comercio/Familia/Familias_Add2/';
        $campos = Comercio_Familia_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos);
    }
    /**
     * 
     * @global Array $language
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Familias_Add2(){
        $titulo     = 'Familia Adicionada com Sucesso';
        $dao        = 'Comercio_Familia';
        $funcao     = '$this->Familias();';
        $sucesso1   = 'Inserção bem sucedida';
        $sucesso2   = 'Familia cadastrada com sucesso.';
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);
    }
    /**
     * 
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Familias_Edit($id){
        self::Endereco_Familia(true);
        // Carrega Config
        $titulo1    = 'Editar Familia (#'.$id.')';
        $titulo2    = 'Alteração de Familia';
        $formid     = 'form_Sistema_AdminC_FamiliaEdit';
        $formbt     = 'Alterar Familia';
        $formlink   = 'comercio/Familia/Familias_Edit2/'.$id;
        $editar     = Array('Comercio_Familia',$id);
        $campos = Comercio_Familia_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos,$editar);
    }
    /**
     * 
     * @global Array $language
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Familias_Edit2($id){
        $titulo     = 'Familia Editada com Sucesso';
        $dao        = Array('Comercio_Familia',$id);
        $funcao     = '$this->Familias();';
        $sucesso1   = 'Familia Alterada com Sucesso.';
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
    public function Familias_Del($id){
        global $language;
        
    	$id = (int) $id;
        // Puxa linha e deleta
        $linha = $this->_Modelo->db->Sql_Select('Comercio_Familia', Array('id'=>$id));
        $sucesso =  $this->_Modelo->db->Sql_Delete($linha);
        // Mensagem
    	if($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => 'Deletada',
                "mgs_secundaria" => 'Familia Deletada com sucesso'
            );
    	}else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => $language['mens_erro']['erro'],
                "mgs_secundaria" => $language['mens_erro']['erro']
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        
        $this->Familias();
        
        $this->_Visual->Json_Info_Update('Titulo', 'Familia deletada com Sucesso');  
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
}
?>
