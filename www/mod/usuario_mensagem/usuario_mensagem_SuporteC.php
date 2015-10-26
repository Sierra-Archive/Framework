<?php
class usuario_mensagem_SuporteControle extends usuario_mensagem_Controle
{
    /**
    * Construtor
    * 
    * @name __construct
    * @access public
    * 
    * @uses ticket_ListarModelo Carrega ticket Modelo
    * @uses ticket_ListarVisual Carrega ticket Visual
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 0.4.2
    */
    public function __construct(){
        // construct
        parent::__construct();
    }
    static function Endereco_Suporte($true=true){
        $Registro = &\Framework\App\Registro::getInstacia();
        $_Controle = $Registro->_Controle;
        if($true===true){
            $_Controle->Tema_Endereco(__('Chamados'),'usuario_mensagem/Suporte/Mensagens/');
        }else{
            $_Controle->Tema_Endereco(__('Chamados'));
        }
    }
    static function Endereco_Suporte_Listar($true=true,$id){
        self::Endereco_Suporte();
        $Registro = &\Framework\App\Registro::getInstacia();
        $_Controle = $Registro->_Controle;
        if($true===true){
            $_Controle->Tema_Endereco(__('Visualizar Chamado'),'usuario_mensagem/Suporte/VisualizadordeMensagem/'.$id);
        }else{
            $_Controle->Tema_Endereco(__('Visualizar Chamado'));
        }
    }
    public function Finalizar($id){
        $id = (int) $id;
        // Atualiza Mensagem
        $objeto = $this->_Modelo->db->Sql_Select('Usuario_Mensagem',Array('id'=>$id));
        if(!is_object($objeto)) throw new \Exception('Mensagem não existe ou existe mais delas.',3030);
        $objeto->finalizado = 1;
        $this->_Modelo->db->Sql_Update($objeto);
        $this->Mensagens();
    }
    /**
    * Função Main, Principal
    * 
    * @name Main
    * @access public
    * 
    * @uses ticket_ListarModelo::$Indicados_Retorna
    * @uses ticket_ListarVisual::$Show_ticketIndicados
    * @uses \Framework\App\Visual::$blocar
    * @uses \Framework\App\Visual::$Bloco_Maior_CriaJanela
    * 
    * @return void 
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 0.4.2
    */
    public function Main(){
        \Framework\App\Sistema_Funcoes::Redirect(URL_PATH.'usuario_mensagem/Suporte/Mensagens/');
        return false;
    }
    public function Mensagens(){
        $nome = __('Tickets');
        self::Endereco_Suporte(false);
        $id = (int) $this->_Acl->Usuario_GetID();
        if($id>0){
            $this->Mensagenslistar();
            if($this->_Acl->logado_usuario->grupo==CFG_TEC_IDADMIN){
                $this->MensagensSetores(-1);
            }else{
                $this->MensagensSetores();
            }
            //$this->Mensagem_formulario();
            // ORGANIZA E MANDA CONTEUDO
            $this->_Visual->Json_Info_Update('Titulo',$nome);
            return true;
        }
        return false;
    }
    public function Mensagens_Mostrar($tipodemensagem = false){
        $titulo = $this->Mensagenslistar(0, $tipodemensagem);
        $this->Tema_Endereco($titulo);
        // ORGANIZA E MANDA CONTEUDO
        $this->_Visual->Json_Info_Update('Titulo',$titulo);
    }
    /**
     * 
     * @param type $grupo  (-1 = Admin)
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function MensagensSetores($grupo = 0){
        $i = 0;
        $mensagens = Array();
        if($grupo==0){
            $grupo = $this->_Acl->logado_usuario->grupo;
            $admin = 0;
        }else if($grupo==-1){
            $grupo = 0;
            $admin = 1;
        }
        $this->_Modelo->Suporte_MensagensSetor($mensagens,$grupo);
        if(is_object($mensagens)){
            $mensagens = Array(0=>$mensagens);
        }
        if(!empty($mensagens) && $mensagens!==false){
            $i = usuario_mensagem_Controle::Mensagens_TabelaMostrar($this->_Visual, $mensagens,$admin);
        }else{
            if($grupo==0){
                $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">'.__('Os setores não possuem chamados.').'</font></b></center>');  
            }else{
                $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">'.__('O setor não possui chamados.').'</font></b></center>');  
            }
        }
        if($grupo==0){
            $titulo  = __('Todos os Chamados de todos os Setores').' ('.$i.')';
        }else{
            $titulo  = __('Todos os Chamados do Setor').' ('.$i.')';
        }
        $this->_Visual->Bloco_Unico_CriaJanela($titulo);
    }
    public function Mostrar_Cliente($cliente = 0,$retorno='Unico'){
        self::Endereco_Suporte(true);
        $this->Tema_Endereco(__('Visualizar Chamados de Cliente'));
        self::MensagensdeCliente($cliente,$retorno);
        // ORGANIZA E MANDA CONTEUDO
        $this->_Visual->Json_Info_Update('Titulo', __('Visualizar Chamados de Cliente')); 
    }
    /**
     * 
     * @param type $cliente
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public static function MensagensdeCliente($cliente = 0,$retorno='Unico'){
        $Registro = &\Framework\App\Registro::getInstacia();
        $Modelo = &$Registro->_Modelo;
        $Visual = &$Registro->_Visual;
        $i = 0;
        $mensagens = Array();
        if($cliente==0){
            $usuario = (int) $this->_Acl->Usuario_GetID();
        }else{
            $usuario = $cliente;
        }
        usuario_mensagem_SuporteModelo::Suporte_MensagensCliente($mensagens,$usuario,1);
        if(is_object($mensagens)) $mensagens = Array(0=>$mensagens);
        if(!empty($mensagens) && $mensagens!==false){
            $i = usuario_mensagem_Controle::Mensagens_TabelaMostrar($Visual, $mensagens,$admin);
        }else{
            $Visual->Blocar('<center><b><font color="#FF0000" size="5">'.__('Não possui chamados.').'</font></b></center>');
        }
        $titulo  = __('Todos os chamados do Cliente').' ('.$i.')';
        if($retorno=='Unico'){
            $Visual->Bloco_Unico_CriaJanela($titulo);
        }else{
            $Visual->Bloco_Menor_CriaJanela($titulo);
        }
    }
    public function VisualizadordeMensagem($mensagem){
        $id = (int) $this->_Acl->Usuario_GetID();
        if($id>0){
            $mensagem = (int) $mensagem;
            
            $this->MensagemExibir($mensagem);
            $this->Resposta_formulario($mensagem);
            $this->Anexar($mensagem);
            // ORGANIZA E MANDA CONTEUDO
            $this->_Visual->Json_Info_Update('Titulo', __('Visualizar Ticket')); 
        }else{
            throw new \Exception('Id não Encontrado de Usuário: '.$id, 5050);
        }
    }
    public function Anexar($mensagem){
        // Upload de Chamadas
        $this->_Visual->Blocar(
            $this->_Visual->Upload_Janela(
                'usuario_mensagem',
                'Suporte',
                'VisualizadordeMensagem',
                $mensagem,
                'gif;jpg;jpeg;', // Arquivos Permitidos
                'Arquivos de Imagem'
            )
        );
        $this->_Visual->Bloco_Unico_CriaJanela(__('Fazer Upload de Anexo')  ,'',8);
        
        // Processa Anexo
        list($titulo,$html,$i) = $this->Anexos_Processar($mensagem);
        $this->_Visual->Blocar('<span id="anexo_arquivos_mostrar">'.$html.'</span>');
        $this->_Visual->Bloco_Unico_CriaJanela($titulo,'',9);
        
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Listagem de Anexos'));
    }
    public function VisualizadordeMensagem_Upload($mensagem = 0){
        $fileTypes = array(
            // Audio
            'gif',
            'jpg',
            'jpeg',
        ); // File extensions
        $dir = 'usuario_mensagem'.DS.'Chamados_Anexos'.DS;
        $ext = $this->Upload($dir,$fileTypes,false);
        $this->layoult_zerar = false;
        if($ext!==false){
            
            $arquivo = new \Usuario_Mensagem_Anexo_DAO();
            $arquivo->mensagem      = $mensagem;
            $arquivo->ext           = $ext[0];
            $arquivo->endereco      = $ext[1];
            $arquivo->nome          = $ext[2];
            $this->_Modelo->db->Sql_Inserir($arquivo);
            $this->_Visual->Json_Info_Update('Titulo', __('Upload com Sucesso'));
            $this->_Visual->Json_Info_Update('Historico', false);
            // Tras de Volta e Atualiza via Json
            list($titulo,$html,$i) = $this->Anexos_Processar($mensagem);
            $conteudo = array(
                'location'  => '#anexo_arquivos_num',
                'js'        => '',
                'html'      => $i
            );
            $this->_Visual->Json_IncluiTipo('Conteudo',$conteudo);
            $conteudo = array(
                'location'  => '#anexo_arquivos_mostrar',
                'js'        => '',
                'html'      => $html
            );
            $this->_Visual->Json_IncluiTipo('Conteudo',$conteudo);
        }else{
            $this->_Visual->Json_Info_Update('Titulo', __('Erro com Upload'));
            $this->_Visual->Json_Info_Update('Historico', false);
        }
    }
    private function Anexos_Processar($mensagem = false){
        // Anexo
        if($mensagem!==false && $mensagem!=0){
            $resultado_mensagens = $this->_Modelo->db->Sql_Select('Usuario_Mensagem', Array('id'=>$mensagem),1);
            if($resultado_mensagens===false){
                throw new \Exception('Essa mensagem não existe:'. $mensagem, 404);
            }
            // Condicao de Query
            $where = Array('mensagem'=>$resultado_mensagens->id);
        }else{
            $mensagem = 0;
            $where = Array();
        }
        $i = 0;
        $html = '';
        // COntinua
        $anexos = $this->_Modelo->db->Sql_Select('Usuario_Mensagem_Anexo',$where);
        if($anexos!==false && !empty($anexos)){
            // Percorre Anexos
            if(is_object($anexos)) $anexos = Array(0=>$anexos);
            reset($anexos);
            if(!empty($anexos)){
                foreach ($anexos as &$valor) {
                    $endereco = ARQ_PATH.'usuario_mensagem'.DS.'Chamados_Anexos'.DS.strtolower($valor->endereco.'.'.$valor->ext);
                    if(file_exists($endereco)){
                        $tamanho    =   round(filesize($endereco)/1024);
                        $tipo       =   $valor->ext;
                        $tabela[__('Nome')][$i]             = '<a href="'.URL_PATH.'usuario_mensagem/Suporte/Download/'.$valor->id.'/" border="1" class="lajax" data-acao="">'.$valor->nome.'</a>';
                        $tabela[__('Tamanho')][$i]          = $tamanho.' KB';
                        $tabela[__('Data')][$i]             = $valor->log_date_add;
                        $tabela[__('Download')][$i]          = $this->_Visual->Tema_Elementos_Btn('Baixar'     ,Array(__('Download de Arquivo')  ,'usuario_mensagem/Suporte/Download/'.$valor->id    ,''));
                        ++$i;
                    }
                }
            }
            $html .= $this->_Visual->Show_Tabela_DataTable($tabela,'',false);
            unset($tabela);
        }else{
            $html .= '<center><b><font color="#FF0000" size="5">'.__('Nenhum Anexo').'</font></b></center>';            
        }
        $titulo = __('Anexos').' (<span id="anexo_arquivos_num">'.$i.'</span>)';
        return Array($titulo,$html,$i);
    }
    public function Download($anexo,$mensagem=false){
        $resultado_arquivo = $this->_Modelo->db->Sql_Select('Usuario_Mensagem_Anexo', '{sigla}id=\''.$anexo.'\'',1);
        if($resultado_arquivo===false || !is_object($resultado_arquivo)){
            throw new \Exception('Esse anexo não existe:'. $anexo, 404);
        }
        $endereco = 'usuario_mensagem'.DS.'Chamados_Anexos'.DS.strtolower($resultado_arquivo->endereco.'.'.$resultado_arquivo->ext);
        self::Export_Download($endereco, $resultado_arquivo->nome.'.'.$resultado_arquivo->ext);
    }
}
?>
