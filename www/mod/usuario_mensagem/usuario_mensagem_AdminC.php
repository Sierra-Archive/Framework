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
            $this->_Visual->Json_Info_Update('Titulo', __('Tickets'));  
        }
    }
    public function Mensagem_Editar($mensagem=0){
        $mensagem = (int) $mensagem;
        if($mensagem==0 || !isset($mensagem)) return;
        self::Mensagem_Editar_Static($mensagem);
    }
    static function Mensagem_Editar_Static($mensagem){
        $mensagem = (int) $mensagem;
        usuario_mensagem_SuporteControle::Endereco_Suporte_Listar(true,$mensagem);
  
        // Carrega campos e retira os que nao precisam
        $campos = Usuario_Mensagem_DAO::Get_Colunas();
        usuario_mensagem_Controle::Campos_deletar($campos);
        // Chama Objeto Mensagem
        $editar = Framework\App\Registro::getInstacia()->_Modelo->db->Sql_Select('Usuario_Mensagem', '{sigla}id=\''.$mensagem.'\'');
        //Atualiza Nome para nao dar erro
        if($editar->para_nome=='') $editar->para_nome=__('Suporte');

        
        // Carrega Config
        $titulo1    = 'Editar Ticket (#'.$mensagem.')';
        $titulo2    = __('Edição de Ticket');
        $formid     = 'form_Usuario_Mensagem_Suporte';
        $formbt     = __('Alterar Edição');
        $formlink   = 'usuario_mensagem/Suporte/Mensagem_inserir';
        $editar     = $editar;
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos,$editar);
   
    }
    /**
     * 
     * 
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Mensagem_Del($id){
        
        
    	$id = (int) $id;
        // Puxa setor e deleta
        $mensagem = $this->_Modelo->db->Sql_Select('Usuario_Mensagem', Array('id'=>$id));
        $sucesso =  $this->_Modelo->db->Sql_Delete($mensagem);
        // Mensagem
    	if($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Deletado'),
                "mgs_secundaria" => __('Mensagem deletada com sucesso')
            );
    	}else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Erro')
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        
        $this->Mensagem();
        
        $this->_Visual->Json_Info_Update('Titulo', __('Mensagem deletada com Sucesso'));  
        $this->_Visual->Json_Info_Update('Historico', false);  
    }
}
?>
