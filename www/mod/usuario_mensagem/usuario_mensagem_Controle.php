<?php
class usuario_mensagem_Controle extends \Framework\App\Controle
{
    /**
    * Construtor
    * 
    * @name __construct
    * @access public
    *
    * @uses \Framework\App\Visual::$menu
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 3.1.1
    */
    public function __construct(){
        parent::__construct();
    }
    public function Mensagens_Mostrar($tipodemensagem = false){
        // ORGANIZA E MANDA CONTEUDO
        $this->_Visual->Json_Info_Update('Titulo',$this->Mensagenslistar(0, $tipodemensagem));
    } 
   /**
     * lISTA OS SUPORTES
     * @param type $admin
     */
    protected function Mensagenslistar($admin = 0, $tipodemensagem = false){
        $this->_Visual->Blocar('<a title="Adicionar Mensagem de Suporte" class="btn btn-success lajax explicar-titulo" acao="" href="'.URL_PATH.'usuario_mensagem/Suporte/Mensagem_formulario">Adicionar novo Suporte</a><div class="space15"></div>');
        $i = 0;
        $mensagens = Array();
        if($admin==0 || $admin=='0'){
            $proprietario = $this->_Acl->Usuario_GetID();
        }else{
            $proprietario = 0;
        }
        $this->_Modelo->Mensagens_Retorna($mensagens,$proprietario,1,$tipodemensagem);
        if(is_object($mensagens)) $mensagens = Array(0=>$mensagens);
        if(!empty($mensagens) && $mensagens!==false){
            $i = usuario_mensagem_Controle::Mensagens_TabelaMostrar($this->_Visual, $mensagens,$admin);
        }else{
            if($admin==0){
                if($tipodemensagem===false){
                    $texto_vazio = __('Você não possui nenhum chamado.');
                }else if($tipodemensagem=='nov'){
                    $texto_vazio = __('Você não possui chamados novos.');
                }else if($tipodemensagem=='fin'){
                    $texto_vazio = __('Você não possui nenhum chamados finalizados.');
                }else if($tipodemensagem=='lim'){
                    $texto_vazio = __('Você não possui nenhum chamados em tempo limite.');
                }else if($tipodemensagem=='esg'){
                    $texto_vazio = __('Você não possui nenhum chamados Esgotado.');
                }
            }else{
                if($tipodemensagem===false){
                    $texto_vazio = __('O sistema não possui nenhum chamado.');
                }else if($tipodemensagem=='nov'){
                    $texto_vazio = __('O sistema não possui nenhum chamados novos.');
                }else if($tipodemensagem=='fin'){
                    $texto_vazio = __('O sistema não possui nenhum chamados finalizados.');
                }else if($tipodemensagem=='lim'){
                    $texto_vazio = __('O sistema não possui nenhum chamados em tempo limite.');
                }else if($tipodemensagem=='esg'){
                    $texto_vazio = __('O sistema não possui nenhum chamados Esgotado.');
                }
            }
            $this->_Visual->Blocar('<center><b><font color="#FF0000" size="5">'.$texto_vazio.'</font></b></center>');
        }
        
        // Titulos
        if($admin==0){
            if($tipodemensagem===false){
                $titulo  = __('Todos os seus Chamados');
            }else if($tipodemensagem=='nov'){
                $titulo  = __('Todos seus novos Chamados');
            }else if($tipodemensagem=='fin'){
                $titulo  = __('Todos seus Chamados Finalizados');
            }else if($tipodemensagem=='lim'){
                $titulo  = __('Todos seus Chamados em tempo limite');
            }else if($tipodemensagem=='esg'){
                $titulo  = __('Todos seus Chamados em tempo Esgotado');
            }
        }else{
            if($tipodemensagem===false){
                $titulo  = __('Todos os Chamados do Sistema');
            }else if($tipodemensagem=='nov'){
                $titulo  = __('Todos novos Chamados do Sistema');
            }else if($tipodemensagem=='fin'){
                $titulo  = __('Todos Chamados Finalizados do Sistema');
            }else if($tipodemensagem=='lim'){
                $titulo  = __('Todos Chamados em Tempo lLimite do Sistema');
            }else if($tipodemensagem=='esg'){
                $titulo  = __('Todos Chamados em Tempo Esgotado do Sistema');
            }
        }
        $titulo  = $titulo.' ('.$i.')';
        $this->_Visual->Bloco_Unico_CriaJanela($titulo);
        return $titulo;
    }
    static function Mensagenslistar_naolidas(&$modelo,&$Visual,$usuarioid,$admin = 0){
        $i = 0;
        $mensagens = Array();
        if($admin==0) $usuario = $usuarioid;
        else          $usuario = 0;
        usuario_mensagem_Modelo::Mensagens_Retornanaolidas($modelo,$mensagens,$usuario,1);
        if(!empty($mensagens)){
            $i = usuario_mensagem_Controle::Mensagens_TabelaMostrar($Visual, $mensagens,$admin);
            $Visual->Bloco_Unico_CriaJanela('Chamados não lidos ('.$i.')','',100);
        }
        // ORGANIZA E MANDA CONTEUDO
        $this->_Visual->Json_Info_Update('Titulo', __('Chamados não lidos'));  
    }
    static function Mensagens_TabelaMostrar(&$Visual,&$mensagens,$admin=0){
        $_Registro = &\Framework\App\Registro::getInstacia();
        $label = function($nometipo){
            if($nometipo=='Chamado Novo')       $tipo = 'success';
            else if($nometipo=='Esgotado')      $tipo = 'important';
            else if($nometipo=='Finalizado')    $tipo = 'inverse';
            else                                $tipo = 'warning';
            return '<span class="badge badge-'.$tipo.'">'.$nometipo.'</span>';
        };
        reset($mensagens);
        $i = 0;
        
        $perm_finalizar = $_Registro->_Acl->Get_Permissao_Url('usuario_mensagem/Suporte/Finalizar');
        $perm_view = $_Registro->_Acl->Get_Permissao_Url('usuario_mensagem/Suporte/VisualizadordeMensagem');
        $perm_editar = $_Registro->_Acl->Get_Permissao_Url('usuario_mensagem/Admin/Mensagem_Editar');
        $perm_del = $_Registro->_Acl->Get_Permissao_Url('usuario_mensagem/Admin/Mensagem_Del');
        
        foreach ($mensagens as &$valor) {
            if($valor->lido===false){
                $valor->assunto2                = '<b>'.$valor->assunto2.'</b>';
            }
            $tabela['Protocolo'][$i]            = '#'.$valor->id;
            $tabela['Cliente'][$i]              = $valor->cliente2;
            if($admin==1) $tabela['De'][$i]     = $valor->escritor_nome;
            $tabela['Assunto'][$i]              = $valor->assunto2;
            $tabela['Tipo'][$i]                 = $label($valor->tipo);
            if($valor->datapassada==1){
                $tabela['Últ. Alteração'][$i]   = $valor->datapassada.' hora atrás';
            }else{
                $tabela['Últ. Alteração'][$i]   = $valor->datapassada.' horas atrás';
            }
            
            $tabela['Data de Criação'][$i]      = $valor->log_date_add; //date_replace($valor->log_date_add, "d/m/y | H:i");
            $tabela['Ultima Modificação'][$i]   = $valor->log_date_edit; //date_replace($valor->log_date_edit, "d/m/y | H:i");
            if($valor->tipo!='Finalizado'){
                $tabela['Visualizar Mensagem'][$i]  = $Visual->Tema_Elementos_Btn('Personalizado' ,    Array('Finalizar Mensagem'         ,'usuario_mensagem/Suporte/Finalizar/'.$valor->id.'/'    ,'','download','inverse'),$perm_finalizar);
            }else{
                $tabela['Visualizar Mensagem'][$i] = '';
            }
            $tabela['Visualizar Mensagem'][$i]  .= $Visual->Tema_Elementos_Btn('Visualizar' ,    Array('Visualizar Mensagem'         ,'usuario_mensagem/Suporte/VisualizadordeMensagem/'.$valor->id.'/'    ,''),$perm_view).
                                                  $Visual->Tema_Elementos_Btn('Editar'     ,    Array('Editar Mensagem'             ,'usuario_mensagem/Admin/Mensagem_Editar/'.$valor->id.'/'    ,''), $perm_editar).
                                                  $Visual->Tema_Elementos_Btn('Deletar'    ,    Array('Deletar Mensagem'            ,'usuario_mensagem/Admin/Mensagem_Del/'.$valor->id.'/'     ,'Deseja realmente deletar essa Mensagem ?'), $perm_del);
            ++$i;
        }
        $Visual->Show_Tabela_DataTable($tabela,'',true,false,Array(Array(1,'asc')));
        unset($tabela);
        return $i;
    }
    public function MensagemExibir($mensagem){
        $id = (int) $mensagem;
        $mensagens = Array();
        $tabela = Array();
            $i = 0;
        $amensagem = $this->_Modelo->Mensagem_Retorna($mensagens, $id, 1);
        usuario_mensagem_SuporteControle::Endereco_Suporte_Listar(false,$id);
        $titulo = $amensagem->assunto2;
        if($titulo=='' || $titulo==NULL) $titulo = __('Conversa sem Assunto');
        // Se tiver config maluco da skafe mostra
        if(\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('usuario_mensagem_Obs')){
            $where = Array('id'=>$amensagem->cliente);
            $usuario = $this->_Modelo->db->Sql_Select('Usuario',$where,1);
            $tabela['Mensagem'][$i] = '<b>'.$amensagem->cliente2.':</b> '.$usuario->obs;
            $tabela['Data'][$i] = $usuario->log_date_add;
            ++$i;
        }
        // Continua
        if($mensagens->is_empty==NULL){
            $mensagens->rewind();
            while ($mensagens->valid){
                $tabela['Mensagem'][$i] = '<b>'.$mensagens->current->escritor_nome.':</b> '.$mensagens->current->resposta;
                $tabela['Data'][$i] = $mensagens->current->log_date_add;
                ++$i;
                $mensagens->next();
            }
            $info = '<b>Setor:</b> '.$amensagem->setor2.
            '<br><b>Assunto:</b> '.$titulo;
            if((\Framework\App\Sistema_Funcoes::Perm_Modulos('comercio') && file_exists(MOD_PATH.'comercio'.DS.'comercio_Controle.php'))){
                $info .= '<br><b>Cliente:</b> '.$amensagem->cliente2.
                '<br><b>Origem:</b> '.$amensagem->origem2.
                '<br><b>Marca:</b> '.$amensagem->marca2.
                '<br><b>Linha:</b> '.$amensagem->linha2.
                '<br><b>Produto:</b> '.$amensagem->produto2.
                '<br><b>Numero do Protocolo:</b> '.$amensagem->id.
                '<br><b>Lote:</b> '.$amensagem->lote.
                '<br><b>Validade:</b> '.$amensagem->validade.
                '<br><b>Fabricacao:</b> '.$amensagem->fabricacao;
            }
            $this->_Visual->Show_Tabela_DataTable($tabela,'',true,false,Array(Array(1,'asc')));
            $this->_Visual->Blocar('<h3>Informações Adicionais:</h3>'.$info);
            $this->_Visual->Bloco_Unico_CriaJanela($titulo,'',60);
            unset($tabela);
        }
    }
    static function Mensagem_formulario_Static($cliente=0){
        // Carrega campos e retira os que nao precisam
        $campos = Usuario_Mensagem_DAO::Get_Colunas();
        self::Campos_deletar($campos);
        if($cliente!=0) self::mysql_AtualizaValor($campos, 'cliente',$cliente);
        
        // Pagina Config
        $titulo1    = __('Cadastro de Ticket');
        $titulo2    = __('Enviar Ticket');
        $formid     = 'form_Usuario_Mensagem_Suporte';
        $formbt     = __('Salvar');
        $formlink   = 'usuario_mensagem/Suporte/Mensagem_inserir';
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos);
    
    }
    public function Mensagem_formulario($cliente=0){
        usuario_mensagem_SuporteControle::Endereco_Suporte(true);
        self::Mensagem_formulario_Static($cliente);
    }
    public function Resposta_formulario($mensagemid){
        $mensagemid = (int)$mensagemid;
        
        $form = new \Framework\Classes\Form('mensagem_resposta',SISTEMA_MODULO.'/'.SISTEMA_SUB.'/Resposta_inserir/'.$mensagemid.'/','formajax','full');
        // CADASTRA
        $form->Input_Novo('Mensagem','mensagem',$mensagemid,'hidden', false, 'obrigatorio');
        $form->TextArea_Novo('Responder','resposta','','','text', 10000, 'obrigatorio');
        $this->_Visual->Blocar($form->retorna_form(__('Enviar')));
        $this->_Visual->Bloco_Unico_CriaJanela(__('Responder Ticket'));
    }
    /**
     * Formulario Suporter - Inserir Mensagem de FOrmulario
     */
    public function Mensagem_inserir(){
        
        $cliente = false;
        if(isset($_POST["cliente"])){
            $clienteid = (int) $_POST["cliente"];
            $cliente  = $this->_Modelo->db->Sql_Select('Usuario', '{sigla}id=\''.$clienteid.'\'',1,'id DESC');
        }
        
        if($cliente===false){
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Esse Cliente não Existe')
            );
            $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens); 
            $this->_Visual->Json_Info_Update('Historico', false);
            return false;
        }
        
        // Nao sei daonde Vem esse Paranome, foi feito isso pra consertar o erro
        if(isset($_POST["paranome"])){
            $paranome = \anti_injection($_POST["paranome"]);
        }else{
            if($cliente->razao_social!==''){
                $paranome = $cliente->razao_social;
            }else{
                $paranome = $cliente->nome;
            }
        }
        
        // Pega para id , mesmo problema;
        if(isset($_POST["paraid"])){
            $paraid = (int) $_POST["paraid"];
        }else{
            $paraid = $clienteid;
        }
        
        // Assunto
        $assunto = \anti_injection($_POST["assunto"]);
        
        
        $sucesso =  $this->_Modelo->db->Sql_Inserir($objeto);
        $titulo     = __('Mensagem inserida com Sucesso');
        $dao        = 'Usuario_Mensagem';
        $funcao     = false;
        $sucesso1   = __('Mensagem inserida com Sucesso');
        $sucesso2   = 'Solicitação de '.$paranome.' foi enviada com sucesso';
        $alterar    = Array('escritor'=>\Framework\App\Acl::Usuario_GetID_Static(),'escritor_nome'=>$this->_Acl->logado_usuario->nome);
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);  
        
        
        $identificador  = $this->_Modelo->db->Sql_Select('Usuario_Mensagem', '',1,'id DESC');
        // REcria Mensagem
        $mensagem = '<b>'.__('Cliente:').' </b>'.     $identificador->cliente2.
                    '<br><b>'.__('Setor:').' </b>'.       $identificador->setor2.
                    '<br><b>'.__('Assunto:').' </b>'.     $identificador->assunto2.
                    '<br><b>'.__('Origem:').' </b>'.      $identificador->origem2.
                    '<br><b>'.__('Marca:').' </b>'.       $identificador->marca2.
                    '<br><b>'.__('Linha:').' </b>'.       $identificador->linha2.
                    '<br><b>'.__('Produto:').' </b>'.     $identificador->produto2.
                    '<br><b>'.__('Lote:').' </b>'.        $identificador->lote.
                    '<br><b>'.__('Validade:').' </b>'.    $identificador->validade.
                    '<br><b>'.__('Fabricação:').' </b>'.  $identificador->fabricacao.
                    '<br><b>'.__('Mensagem:').' </b>' . nl2br($identificador->mensagem);
        // Recupera Email e Dados do Setor
        $assunto    = $this->_Modelo->db->Sql_Select('Usuario_Mensagem_Assunto','{sigla}id=\''.$assunto.'\'');
        $setor      = $this->_Modelo->db->Sql_Select('Usuario_Mensagem_Setor','{sigla}id=\''.$assunto->setor.'\'');
        // Enviar Email
        $mailer = new \Framework\Classes\Email();
        $enviar = '';
        $emaildosetor = $setor->email;
        if(strpos($emaildosetor, ',')===false){
            $enviar .= '->setTo(\''.$emaildosetor.'\', \''.$setor->nome.'\')';
        }else{
            $emaildosetor = explode(',', $emaildosetor);
            foreach($emaildosetor as &$valor){
                $enviar .= '->setTo(\''.$valor.'\', \''.$setor->nome.'\')';
            }
        }
        eval('$send	= $mailer'.$enviar.'->setSubject(\''.__('NOVA MENSAGEM SAQUE').' - '.SISTEMA_NOME.'\')'.
        '->setFrom(SISTEMA_EMAIL, SISTEMA_NOME)'.
        '->addGenericHeader(\'X-Mailer\', \'PHP/\' . phpversion())'.
        '->addGenericHeader(\'Content-Type\', \'text/html; charset="utf-8"\')'.
        '->setMessage(\'<strong><b>Mensagem:</b> \'.$mensagem.\'</strong>\')'.
        '->setWrap(78)->send();');
        //atualiza
        $this->VisualizadordeMensagem($identificador->id);
        $this->_Visual->Json_Info_Update('Historico', false); 
    }
    public function Resposta_inserir(){
        if(!isset($_POST["mensagem"]) || !isset($_POST['resposta'])){
            throw new \Exception('Página não Encontrada',404);
        }
        $mensagem = (int) $_POST["mensagem"];
        if(!is_int($mensagem) || $mensagem==0){
            throw new \Exception('Página não Encontrada',404);
        }
        $resposta = \anti_injection($_POST["resposta"]);
        $sucesso =  $this->_Modelo->Mensagem_Resp_Inserir($mensagem,$resposta);
        $amensagem =  $this->_Modelo->db->Sql_Select('Usuario_Mensagem','{sigla}id=\''.$mensagem.'\'');
        // Recupera Email e Dados do Setor
        $assunto    = $this->_Modelo->db->Sql_Select('Usuario_Mensagem_Assunto','{sigla}id=\''.$amensagem->assunto.'\'');
        $setor      = $this->_Modelo->db->Sql_Select('Usuario_Mensagem_Setor','{sigla}id=\''.$assunto->setor.'\'');
        
        // REcria Mensagem
        $resposta = '<b>'.__('Cliente:').' </b>'.     $amensagem->cliente2.
                    '<br><b>'.__('Setor:').' </b>'.       $amensagem->setor2.
                    '<br><b>'.__('Assunto:').' </b>'.     $amensagem->assunto2.
                    '<br><b>'.__('Origem:').' </b>'.      $amensagem->origem2.
                    '<br><b>'.__('Marca:').' </b>'.       $amensagem->marca2.
                    '<br><b>'.__('Linha:').' </b>'.       $amensagem->linha2.
                    '<br><b>'.__('Produto:').' </b>'.     $amensagem->produto2.
                    '<br><b>'.__('Lote:').' </b>'.        $amensagem->lote.
                    '<br><b>'.__('Validade:').' </b>'.    $amensagem->validade.
                    '<br><b>'.__('Fabricação:').' </b>'.  $amensagem->fabricacao.
                    '<br><b>'.__('Mensagem:').' </b>'.    $amensagem->mensagem.
                    '<br><b>'.__('Resposta:').' </b>'.    $resposta;
        // Envia Email
        $mailer = new \Framework\Classes\Email();
        $enviar = '';
        $emaildosetor = $setor->email;
        if(strpos($emaildosetor, ',')===false){
            $enviar = '->setTo(\''.$emaildosetor.'\', \''.$setor->nome.'\')';
        }else{
            $emaildosetor = explode(',', $emaildosetor);
            foreach($emaildosetor as &$valor){
                $enviar .= '->setTo(\''.$valor.'\', \''.$setor->nome.'\')';
            }
        }
        eval('$send	= $mailer'.$enviar.'->setSubject(\''.__('NOVA RESPOSTA SAQUE').' - '.SISTEMA_NOME.'\')'.
        '->setFrom(SISTEMA_EMAIL, SISTEMA_NOME)'.
        '->addGenericHeader(\'X-Mailer\', \'PHP/\' . phpversion())'.
        '->addGenericHeader(\'Content-Type\', \'text/html; charset="utf-8"\')'.
        '->setMessage(\'<strong><b>Resposta:</b> \'.$resposta.\'</strong>\')'.
        '->setWrap(78)->send();');
        if($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Resposta inserida com Sucesso'),
                "mgs_secundaria" => $resposta
            );
        }else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Erro')
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        $this->VisualizadordeMensagem($mensagem);
        $this->_Visual->Json_Info_Update('Historico', false); 
    }
    public static function MensagensWidgets(){
        $Registro = &\Framework\App\Registro::getInstacia();
        $Modelo = &$Registro->_Modelo;
        $Visual = &$Registro->_Visual;
        $total = 0; $novos = 0; $espera = 0; $esgotado = 0; $finalizado = 0;
        
        // PEga só as deles 
        $where = false;
        $where = Array('escritor'=>$Registro->_Acl->Usuario_GetID(), 'para'=>0);
        
        #update -> Aqui tera que ser Sql_Contar (Mais performatico, aqui ta perdendo mt tempo de processamento)
        $array = $Modelo->db->Sql_Select('Usuario_Mensagem',$where,0, '','assunto.tempocli,log_date_edit,log_date_add,finalizado');
        if(is_object($array)) $array = Array(0=>$array);
        if($array!==false && !empty($array)){
            reset($array);
            foreach($array as $valor){
                ++$total;
                list($tipo,$tempopassado) = usuario_mensagem_Modelo::Mensagem_TipoChamado($valor);
                if($tipo=='fin'){
                    ++$finalizado;
                }else if($tipo=='nov'){
                    ++$novos;
                }else if($tipo=='lim'){
                    ++$espera;
                }else if($tipo=='esg'){
                    ++$esgotado;
                }else{
                    ++$finalizado;
                }
            }
        }
        // Quantidades de Setores e Assuntos
        
        $setor_qnt = $Modelo->db->Sql_Contar('Usuario_Mensagem_Setor');
        
        $assunto_qnt = $Modelo->db->Sql_Contar('Usuario_Mensagem_Assunto');
        // Adiciona Widget a Pagina Inicial
        // Adiciona Widget a Pagina Inicial
        \Framework\App\Visual::Layoult_Home_Widgets_Add(
            __('Chamados Abertos'), 
            'usuario_mensagem/Suporte/Mensagens_Mostrar/nov', 
            'envelope', 
            '+'.$novos, 
            'block-yellow', 
            false, 
            191
        );
        // Adiciona Widget a Pagina Inicial
        \Framework\App\Visual::Layoult_Home_Widgets_Add(
            __('Chamados à Vencer'), 
            'usuario_mensagem/Suporte/Mensagens_Mostrar/lim', 
            'thumbs-down', 
            '+'.$espera, 
            'block-vinho', 
            true, 
            181
        );
        // Adiciona Widget a Pagina Inicial
        \Framework\App\Visual::Layoult_Home_Widgets_Add(
            __('Chamados Vencidos'), 
            'usuario_mensagem/Suporte/Mensagens_Mostrar/esg', 
            'time', 
            '+'.$esgotado, 
            'block-green', 
            false,
            161
        );
        // Adiciona Widget a Pagina Inicial
        \Framework\App\Visual::Layoult_Home_Widgets_Add(
            __('Chamados Finalizados'), 
            'usuario_mensagem/Suporte/Mensagens_Mostrar/fin', 
            'thumbs-up', 
            '+'.$esgotado, 
            'block-orange', 
            false,
            151
        );
        // Adiciona Widget a Pagina Inicial
        \Framework\App\Visual::Layoult_Home_Widgets_Add(
            __('Todos os Chamados'),
            'usuario_mensagem/Suporte/Mensagens/',
            'ticket',
            $total,
            'light-blue',
            true,
            150
        );
        // Adiciona Widget a Pagina Inicial
        \Framework\App\Visual::Layoult_Home_Widgets_Add(
            __('Setores'),
            'usuario_mensagem/Setor/Setores/',
            'smile',
            $setor_qnt,
            'block-grey',
            false,
            131
        );
        // Adiciona Widget a Pagina Inicial
        \Framework\App\Visual::Layoult_Home_Widgets_Add(
            __('Assuntos'),
            'usuario_mensagem/Assunto/Assuntos/',
            'comments-alt',
            $assunto_qnt,
            'block-red',
            false,
            121
        );
    }
    static function Campos_deletar(&$campos){
        // SE nao tiver acesso ao comercio bloqueia
        if(!(\Framework\App\Sistema_Funcoes::Perm_Modulos('comercio'))){
            self::DAO_Campos_Retira($campos, 'cliente');
            self::DAO_Campos_Retira($campos, 'marca');
            self::DAO_Campos_Retira($campos, 'linha');
            self::DAO_Campos_Retira($campos, 'produto');
            self::DAO_Campos_Retira($campos, 'lote');
            self::DAO_Campos_Retira($campos, 'validade');
            self::DAO_Campos_Retira($campos, 'fabricacao');
        }
    }
    
    
    
    
    
    
    
    
    
    
    
    
    /**
     * 2015 - Funções mais Performaticas para Substituir as Anteriores
     */
}
?>
