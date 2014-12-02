<?php
class usuario_mensagem_AdminControle extends usuario_mensagem_Controle
{
    /**
    * Construtor
    * 
    * @name __construct
    * @access public
    * 
    * @uses ticket_AdminModelo Carrega ticket Modelo
    * @uses ticket_AdminVisual Carrega ticket Visual
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 2.0
    */
    public function __construct(){
        // construct
        parent::__construct();
    }
    /**
    * Função Main, Principal
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
        \Framework\App\Sistema_Funcoes::Redirect(URL_PATH.'usuario_mensagem/Admin/Mensagem/');
        return false;
    }
    public function Mensagem(){
        if($this->get_usuarioid()!=0){
            $this->Mensagenslistar(1);
            //$this->Mensagem_formulario();
            // ORGANIZA E MANDA CONTEUDO
            $this->_Visual->Json_Info_Update('Titulo','Tickets');  
        }
    }
    public function Mensagem_Editar($mensagem=0){
        $mensagem = (int) $mensagem;
        if($mensagem==0 || !isset($mensagem)) return;
        self::Mensagem_Editar_Static($mensagem);
    }
    static function Mensagem_Editar_Static($mensagem){
        GLOBAL $language;
        $registro = &\Framework\App\Registro::getInstacia();
        $Controle = $registro->_Controle;
        $Modelo = $registro->_Modelo;
        $Visual = $registro->_Visual;
        $mensagem = (int) $mensagem;
        usuario_mensagem_SuporteControle::Endereco_Suporte_Listar(true,$mensagem);
        $Controle->Tema_Endereco('Editar Chamado');
        // Carrega campos e retira os que nao precisam
        $campos = usuario_mensagem_DAO::Get_Colunas();

        usuario_mensagem_Controle::Campos_deletar($campos);
        // Chama Objeto Mensagem
        $objeto = $Modelo->db->Sql_Select('Usuario_Mensagem', Array('id'=>$mensagem));
        //Atualiza Nome para nao dar erro
        if($objeto->para_nome=='') $objeto->para_nome='Suporte';
        self::mysql_AtualizaValores($campos, $objeto);
        // Carrega formulario
        $form = new \Framework\Classes\Form('form_Usuario_Mensagem_Suporte', 'usuario_mensagem/Suporte/Mensagem_inserir/', 'formajax');
        \Framework\App\Controle::Gerador_Formulario($campos, $form);
        $formulario = $form->retorna_form('Editar');
        $Visual->Blocar($formulario);
        // Mostra Conteudo
        $Visual->Bloco_Unico_CriaJanela('Edição de Ticket');
        // Pagina Config
        $Visual->Json_Info_Update('Titulo', 'Editar Ticket');
    }
    /**
     * 
     * @global Array $language
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Mensagem_Del($id){
        global $language;
        
    	$id = (int) $id;
        // Puxa setor e deleta
        $mensagem = $this->_Modelo->db->Sql_Select('Usuario_Mensagem', Array('id'=>$id));
        $sucesso =  $this->_Modelo->db->Sql_Delete($mensagem);
        // Mensagem
    	if($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => 'Deletado',
                "mgs_secundaria" => 'Mensagem deletada com sucesso'
            );
    	}else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => $language['mens_erro']['erro'],
                "mgs_secundaria" => $language['mens_erro']['erro']
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        
        $this->Mensagem();
        
        $this->_Visual->Json_Info_Update('Titulo', 'Mensagem deletada com Sucesso');  
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
}
?>
