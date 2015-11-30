<?php
class comercio_LinhaControle extends comercio_Controle
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
        \Framework\App\Sistema_Funcoes::Redirect(URL_PATH.'comercio/Linha/Linhas');
        return false;
    }
    static function Endereco_Linha($true=true){
        $registro = \Framework\App\Registro::getInstacia();
        $_Controle = $registro->_Controle;
        $titulo = 'Linhas';
        $link = 'comercio/Linha/Linhas';
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
    public function Linhas($export=false){
        self::Endereco_Linha(false);
        $i = 0;
        // BOTAO IMPRIMIR / ADD
        $this->_Visual->Blocar($this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            Array(
                'Adicionar Linha',
                'comercio/Linha/Linhas_Add',
                ''
            ),
            Array(
                'Print'     => true,
                'Pdf'       => true,
                'Excel'     => true,
                'Link'      => 'comercio/Linha/Linhas',
            )
        )));
        // CONEXAO
        $linhas = $this->_Modelo->db->Sql_Select('Comercio_Linha');
        if($linhas!==false && !empty($linhas)){
            if(is_object($linhas)) $linhas = Array(0=>$linhas);
            reset($linhas);
            foreach ($linhas as $indice=>&$valor) {
                //$tabela['#Id'][$i]     = '#'.$valor->id;
                $tabela['Marca'][$i]     = $valor->marca2;
                $tabela['Nome'][$i]      = $valor->nome;
                $tabela['Funções'][$i]   = $this->_Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Linha'        ,'comercio/Linha/Linhas_Edit/'.$valor->id.'/'    ,'')).
                                           $this->_Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Linha'       ,'comercio/Linha/Linhas_del/'.$valor->id.'/'     ,'Deseja realmente deletar essa Linha ?'));
                ++$i;
            }
            if($export!==false){
                self::Export_Todos($export,$tabela, 'Comercio - Produtos (Linhas)');
            }else{
                $this->_Visual->Show_Tabela_DataTable($tabela);
            }
            unset($tabela);
        }else{         
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhuma Linha</font></b></center>');
        }
        $titulo = 'Listagem de Linhas ('.$i.')';
        $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo','Administrar Linhas');
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Linhas_Add(){
        self::Endereco_Linha(true);
        // Carrega Config
        $titulo1    = 'Adicionar Linha';
        $titulo2    = 'Salvar Linha';
        $formid     = 'form_Sistema_Admin_Linhas';
        $formbt     = 'Salvar';
        $formlink   = 'comercio/Linha/Linhas_Add2/';
        $campos = Comercio_Linha_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos);
    }
    /**
     * 
     * @global Array $language
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Linhas_Add2(){
        $titulo     = 'Linha Adicionada com Sucesso';
        $dao        = 'Comercio_Linha';
        $funcao     = '$this->Linhas();';
        $sucesso1   = 'Inserção bem sucedida';
        $sucesso2   = 'Linha cadastrada com sucesso.';
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);
    }
    /**
     * 
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Linhas_Edit($id){
        self::Endereco_Linha(true);
        // Carrega Config
        $titulo1    = 'Editar Linha (#'.$id.')';
        $titulo2    = 'Alteração de Linha';
        $formid     = 'form_Sistema_AdminC_LinhaEdit';
        $formbt     = 'Alterar Linha';
        $formlink   = 'comercio/Linha/Linhas_Edit2/'.$id;
        $editar     = Array('Comercio_Linha',$id);
        $campos = Comercio_Linha_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos,$editar);
    }
    /**
     * 
     * @global Array $language
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Linhas_Edit2($id){
        $titulo     = 'Linha Editada com Sucesso';
        $dao        = Array('Comercio_Linha',$id);
        $funcao     = '$this->Linhas();';
        $sucesso1   = 'Linha Alterada com Sucesso.';
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
    public function Linhas_Del($id){
        global $language;
        
    	$id = (int) $id;
        // Puxa linha e deleta
        $linha = $this->_Modelo->db->Sql_Select('Comercio_Linha', Array('id'=>$id));
        $sucesso =  $this->_Modelo->db->Sql_Delete($linha);
        // Mensagem
    	if($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => 'Deletado',
                "mgs_secundaria" => 'Linha Deletada com sucesso'
            );
    	}else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => $language['mens_erro']['erro'],
                "mgs_secundaria" => $language['mens_erro']['erro']
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        
        $this->Linhas();
        
        $this->_Visual->Json_Info_Update('Titulo', 'Linha deletada com Sucesso');  
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
}
?>
