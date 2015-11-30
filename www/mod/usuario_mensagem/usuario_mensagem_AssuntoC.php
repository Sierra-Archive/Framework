<?php
class usuario_mensagem_AssuntoControle extends usuario_mensagem_Controle
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
    * @uses usuario_mensagem_Controle::$comercioPerfil
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 2.0
    */
    public function Main(){
        \Framework\App\Sistema_Funcoes::Redirect(URL_PATH.'usuario_mensagem/Assunto/Assuntos/');
        return false;
    }
    static function Endereco_Assunto($true=true){
        $registro = \Framework\App\Registro::getInstacia();
        $_Controle = $registro->_Controle;
        $titulo = 'Assuntos';
        $link = 'comercio/Assunto/Assuntos';
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
    public function Assuntos($export=false){
        self::Endereco_Assunto(false);
        $i = 0;
        $this->_Visual->Blocar($this->_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            Array(
                'Adicionar Assunto',
                'usuario_mensagem/Assunto/Assuntos_Add',
                ''
            ),
            Array(
                'Print'     => true,
                'Pdf'       => true,
                'Excel'     => true,
                'Link'      => 'usuario_mensagem/Assunto/Assuntos',
            )
        )));
        $assuntos = $this->_Modelo->db->Sql_Select('Usuario_Mensagem_Assunto');
        if($assuntos!==false && !empty($assuntos)){
            if(is_object($assuntos)) $assuntos = Array(0=>$assuntos);
            reset($assuntos);
            foreach ($assuntos as $indice=>&$valor) {
                //$tabela['#Id'][$i]                  = '#'.$valor->id;
                $tabela['Setor'][$i]                = $valor->setor2;
                $tabela['Nome'][$i]                 = $valor->nome;
                $tabela['Tempo de Resposta'][$i]    = $valor->tempocli.' horas';
                $tabela['Funções'][$i]              = $this->_Visual->Tema_Elementos_Btn('Editar'     ,Array('Editar Assunto'        ,'usuario_mensagem/Assunto/Assuntos_Edit/'.$valor->id.'/'    ,'')).
                                                      $this->_Visual->Tema_Elementos_Btn('Deletar'    ,Array('Deletar Assunto'       ,'usuario_mensagem/Assunto/Assuntos_del/'.$valor->id.'/'     ,'Deseja realmente deletar esse Assunto ?'));
                ++$i;
            }
            if($export!==false){
                self::Export_Todos($export,$tabela, 'Suporte - Assuntos');
            }else{
                $this->_Visual->Show_Tabela_DataTable($tabela);
            }
            unset($tabela);
        }else{  
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhum Assunto</font></b></center>');
        }
        $titulo = 'Listagem de Assuntos ('.$i.')';
        $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo','Administrar Assuntos');
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Assuntos_Add(){
        self::Endereco_Assunto(true);
        // Carrega Config
        $titulo1    = 'Adicionar Assunto';
        $titulo2    = 'Salvar Assunto';
        $formid     = 'form_Sistema_Admin_Assuntos';
        $formbt     = 'Salvar';
        $formlink   = 'usuario_mensagem/Assunto/Assuntos_Add2/';
        $campos = usuario_mensagem_Assunto_DAO::Get_Colunas();
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos);
    }
    /**
     * 
     * @global Array $language
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Assuntos_Add2(){
        $titulo     = 'Assunto Adicionado com Sucesso';
        $dao        = 'usuario_mensagem_Assunto';
        $funcao     = '$this->Assuntos();';
        $sucesso1   = 'Inserção bem sucedida';
        $sucesso2   = 'Assunto cadastrado com sucesso.';
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);
    }
    /**
     * 
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Assuntos_Edit($id){
        self::Endereco_Assunto(true);
        $id = (int) $id;
        // Carrega campos e retira os que nao precisam
        $campos = usuario_mensagem_Assunto_DAO::Get_Colunas();
        // recupera assunto
        $assunto = $this->_Modelo->db->Sql_Select('Usuario_Mensagem_Assunto', Array('id'=>$id));
        self::mysql_AtualizaValores($campos, $assunto);

        // edicao de assuntos
        $form = new \Framework\Classes\Form('form_Sistema_AdminC_AssuntoEdit','usuario_mensagem/Assunto/Assuntos_Edit2/'.$id.'/','formajax');
        \Framework\App\Controle::Gerador_Formulario($campos, $form);
        $formulario = $form->retorna_form('Alterar Assunto');
        $this->_Visual->Blocar($formulario);
        $this->_Visual->Bloco_Unico_CriaJanela('Alteração de Assunto');
        // Json
        $this->_Visual->Json_Info_Update('Titulo', 'Editar Assunto (#'.$id.')');
        
    }
    /**
     * 
     * @global Array $language
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Assuntos_Edit2($id){
        global $language;
        $id = (int) $id;
        // Puxa o assunto, e altera seus valores, depois salva novamente
        $assunto = $this->_Modelo->db->Sql_Select('Usuario_Mensagem_Assunto', Array('id'=>$id));
        self::mysql_AtualizaValores($assunto);
        $sucesso =  $this->_Modelo->db->Sql_Update($assunto);
        // Atualiza
        $this->Assuntos();
        // Mensagem
        if($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => 'Assunto Alterado com Sucesso',
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
        $this->_Visual->Json_Info_Update('Titulo', 'Assunto Editado com Sucesso');  
        $this->_Visual->Json_Info_Update('Historico', false);    
    }
    /**
     * 
     * @global Array $language
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Assuntos_Del($id){
        global $language;
        
    	$id = (int) $id;
        // Puxa assunto e deleta
        $assunto = $this->_Modelo->db->Sql_Select('Usuario_Mensagem_Assunto', Array('id'=>$id));
        $sucesso =  $this->_Modelo->db->Sql_Delete($assunto);
        // Mensagem
    	if($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => 'Deletado',
                "mgs_secundaria" => 'Assunto Deletado com sucesso'
            );
    	}else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => $language['mens_erro']['erro'],
                "mgs_secundaria" => $language['mens_erro']['erro']
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        
        $this->Assuntos();
        
        $this->_Visual->Json_Info_Update('Titulo', 'Assunto deletado com Sucesso');  
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
}
?>
