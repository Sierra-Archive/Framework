<?php
class usuario_AnexoControle extends usuario_Controle
{
    /**
    * Construtor
    * 
    * @name __construct
    * @access public
    * 
    * @uses usuarios_ListarModelo Carrega usuarios Modelo
    * @uses usuarios_ListarVisual Carrega usuarios Visual
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
    * @uses usuarios_AnexoControle::$usuarios_lista
    * @uses usuarios_AnexoControle::$marcas_carregajanelaadd
    * @uses \Framework\App\Visual::$Json_Start
    * 
    * @return void 
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 2.0
    */
    public function Main($id=false,$tipo='Usuarios'){
        $this->Anexar($id,$tipo);
        // ORGANIZA E MANDA CONTEUDO
        $this->_Visual->Json_Info_Update('Titulo','Todos os tipos de Usuários');         
    }
    public function Anexar($id=false,$tipo='Usuarios'){
        // PEga usuario
        if($id==0 || !isset($id)){
            $id = (int) $this->_Acl->Usuario_GetID();
        }else{
            $id = (int) $id;
        }
        $usuario = $this->_Modelo->db->Sql_Select('Usuario', Array('id'=>$id));
        if($tipo===false){
            if($usuario->grupo==CFG_TEC_IDCLIENTE){
                $tipo   = 'Cliente';
                $tipo2  = 'cliente';
            }else if($usuario->grupo==CFG_TEC_IDFUNCIONARIO){
                $tipo   = 'Funcionário';
                $tipo2  = 'funcionario';
            }
        }else{
            // Primeira Letra Maiuscula
            $tipo = ucfirst($tipo);
        }
        // GAmbiarra Para Consertar erro de acento em url
        if($tipo=='Funcionrio' || $tipo=="Funcionario") $tipo = "Funcionário";
        if($tipo=="Usurio" || $tipo=="Usuario")         $tipo = 'Usuário';
        // Cria Tipo 2:
        if($tipo=='Cliente'){
            $tipo2  = 'cliente';
            $tipo   = Framework\Classes\Texto::Transformar_Plural_Singular(\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('usuario_Cliente_nome'));
            $this->Tema_Endereco('Clientes','usuario/Admin/ListarCliente');
        }else if($tipo=='Funcionário'){
            $tipo2  = 'funcionario';
            $this->Tema_Endereco('Funcionários','usuario/Admin/ListarFuncionario');
        }else{
            $this->Tema_Endereco('Usuários','usuario/Admin/Main');
        }
        // Titulo Anexo
        $nome = '';
        if($usuario->nome!=''){
            $nome .= $usuario->nome;
        }
        $this->Tema_Endereco('Anexos de '.$nome);
        // Upload de Chamadas
        $this->_Visual->Blocar(
            $this->_Visual->Upload_Janela(
                'usuario',
                'Anexo',
                'VisualizadordeUsuario',
                $id,
                'gif;jpg;jpeg;pdf;', // Arquivos Permitidos
                'Arquivos de Imagem'
            )
        );
        $this->_Visual->Bloco_Unico_CriaJanela( 'Fazer Upload de Anexo'  ,'',8);
        
        // Processa Anexo
        list($titulo,$html,$i) = $this->Anexos_Processar($id);
        $this->_Visual->Blocar('<span id="anexo_arquivos_mostrar">'.$html.'</span>');
        $this->_Visual->Bloco_Unico_CriaJanela($titulo,'',9);
        
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo','Listagem de Anexos');
    }
    public function VisualizadordeUsuario_Upload($usuario = 0){
        if($usuario!==false && $usuario!=0){
            $resultado_usuario = $this->_Modelo->db->Sql_Select('Usuario', Array('id'=>$usuario),1);
            if($resultado_usuario===false){
                throw new \Exception('Esse usuário não existe:'. $usuario, 404);
            }
            // Condicao de Query
            $where = Array('usuario'=>$resultado_usuario->id);
        }else{
            throw new \Exception('Usuário não especificado:'. $usuario, 404);
        }
        $fileTypes = array(
            // Audio
            'gif',
            'jpg',
            'jpeg',
            'pdf',
        ); // File extensions
        $dir = 'usuario'.DS.'Anexos'.DS;
        $ext = $this->Upload($dir,$fileTypes,false);
        $this->layoult_zerar = false;
        // CAso tenha sucesso.
        if($ext!==false){
            
            $arquivo = new \Usuario_Anexo_DAO();
            $arquivo->usuario      = $usuario;
            $arquivo->ext           = $ext[0];
            $arquivo->endereco      = $ext[1];
            $arquivo->nome          = $ext[2];
            $this->_Modelo->db->Sql_Inserir($arquivo);
            $this->_Visual->Json_Info_Update('Titulo', 'Upload com Sucesso');
            $this->_Visual->Json_Info_Update('Historico', false);
            // Tras de Volta e Atualiza via Json
            list($titulo,$html,$i) = $this->Anexos_Processar($usuario);
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
            
            
            // Enviar Email
            $this->Enviar_Email($usuario, $dir.strtolower($arquivo->endereco.'.'.$arquivo->ext),$arquivo->nome);
            
        }else{
            
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => 'Erro',
                "mgs_secundaria" => 'Houve algum erro ao fazer upload do arquivo !'
            );
            $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens); 
            $this->_Visual->Json_Info_Update('Titulo', 'Erro com Upload');
            $this->_Visual->Json_Info_Update('Historico', false);
        }
    }
    private function Anexos_Processar($usuario = false){
        // Anexo
        if($usuario!==false && $usuario!=0){
            $resultado_usuario = $this->_Modelo->db->Sql_Select('Usuario', Array('id'=>$usuario),1);
            if($resultado_usuario===false){
                throw new \Exception('Esse usuário não existe:'. $usuario, 404);
            }
            // Condicao de Query
            $where = Array('usuario'=>$resultado_usuario->id);
        }else{
            $usuario = 0;
            $where = Array();
        }
        $i = 0;
        $html = '';
        // COntinua
        $anexos = $this->_Modelo->db->Sql_Select('Usuario_Anexo',$where);
        if($anexos!==false && !empty($anexos)){
            // Percorre Anexos
            if(is_object($anexos)) $anexos = Array(0=>$anexos);
            reset($anexos);
            if(!empty($anexos)){
                foreach ($anexos as &$valor) {
                    $endereco = ARQ_PATH.'usuario'.DS.'Anexos'.DS.strtolower($valor->endereco.'.'.$valor->ext);
                    if(file_exists($endereco)){
                        $tamanho    =   round(filesize($endereco)/1024);
                        $tipo       =   $valor->ext;
                        $tabela['Nome'][$i]             = '<a href="'.URL_PATH.'usuario/Anexo/Download/'.$valor->id.'/" border="1" class="lajax" acao="">'.$valor->nome.'</a>';
                        $tabela['Tamanho'][$i]          = $tamanho.' KB';
                        $tabela['Data'][$i]             = $valor->log_date_add;
                        $tabela['Download'][$i]         = $this->_Visual->Tema_Elementos_Btn('Baixar'     ,Array('Download de Arquivo'   ,'usuario/Anexo/Download/'.$valor->id    ,''));
                        ++$i;
                    }
                }
            }
            $html .= $this->_Visual->Show_Tabela_DataTable($tabela,'',false);
            unset($tabela);
        }else{
            $html .= '<center><b><font color="#FF0000" size="5">Nenhum Anexo</font></b></center>';            
        }
        $titulo = 'Anexos (<span id="anexo_arquivos_num">'.$i.'</span>)';
        return Array($titulo,$html,$i);
    }
    public function Download($anexo,$usuario=false){
        $resultado_arquivo = $this->_Modelo->db->Sql_Select('Usuario_Anexo', Array('id'=>$anexo),1);
        if($resultado_arquivo===false || !is_object($resultado_arquivo)){
            throw new \Exception('Esse anexo não existe:'. $anexo, 404);
        }
        $endereco = 'usuario'.DS.'Anexos'.DS.strtolower($resultado_arquivo->endereco.'.'.$resultado_arquivo->ext);
        self::Export_Download($endereco, $resultado_arquivo->nome.'.'.$resultado_arquivo->ext);
    }
    private function Enviar_Email($id,$arquivo,$nomearquivo){
        $arquivo = \anti_injection($arquivo);
        $nomearquivo = \anti_injection($nomearquivo);
        // Envia Email
        $usuario = $this->_Modelo->db->Sql_Select('Usuario',Array('id'=>$id),1);
        $nome = $usuario->nome;
        // Add Email normal e alternativo para enviar 
        
        
        // NOVO SEND
        $mail = new \Framework\Classes\Mailer();
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host         = SIS_EMAIL_SMTP_HOST;  // Specify main and backup server
        $mail->SMTPAuth     = true;                               // Enable SMTP authentication
        $mail->Username     = SIS_EMAIL_SMTP_USER;                            // SMTP username
        $mail->Password     = SIS_EMAIL_SMTP_SENHA;                           // SMTP password
        $mail->SMTPSecure   = 'tls';                            // Enable encryption, 'ssl' also accepted

        $mail->From = SISTEMA_EMAIL;
        $mail->FromName = SISTEMA_NOME;
        
        $enviar = '';
        if($usuario->email!='' && \Framework\App\Sistema_Funcoes::Control_Layoult_Valida_Email($usuario->email)){
            $enviar .= $usuario->email.'-';
            $mail->addAddress($usuario->email, $nome);  // Add a recipient
        }
        if($usuario->email2!='' && \Framework\App\Sistema_Funcoes::Control_Layoult_Valida_Email($usuario->email2)){
            $enviar .= $usuario->email2.'-';
            $mail->addAddress($usuario->email2, $nome);  // Add a recipient
        }
        if($enviar==''){
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => 'Erro',
                "mgs_secundaria" => 'Nenhum Email válido do cliente para enviar anexo !'
            );
            $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens); 
            $this->_Visual->Json_Info_Update('Historico', false);
            $this->Json_Definir_zerar(false);
        }else{
            $amensagem = '<strong><b>Arquivo em Anexo:</b> '.  $nomearquivo.'</strong>';
            // Enviar Email 
            
            
            // Continua Mandando
            /*$mail->addReplyTo('info@example.com', 'Information');
            $mail->addCC('cc@example.com');
            $mail->addBCC('bcc@example.com');*/

            $mail->WordWrap     = 50;                                 // Set word wrap to 50 characters
            $mail->addAttachment(ARQ_PATH.$arquivo, $nomearquivo);    // Optional name
            $mail->isHTML(true);                                  // Set email format to HTML

            $mail->Subject      = 'Anexo de Chamado - '.SISTEMA_NOME;
            $mail->Body         = $amensagem;
            $mail->AltBody      = 'Arquivo em Anexo';
            /*
            if(!$mail->send()) {
               echo 'Message could not be sent.';
               echo 'Mailer Error: ' . $mail->ErrorInfo;
               exit;
            }
            echo 'Message has been sent';
            
            
            eval('$send	= $mailer'.$enviar.'->setSubject(\'\')'.
            '->setFrom(SISTEMA_EMAIL, SISTEMA_NOME)'.
            '->addGenericHeader(\'X-Mailer\', \'PHP/\' . phpversion())'.
            '->addGenericHeader(\'Content-Type\', \'text/html; charset="utf-8"\')'.
            '->addAttachment(\''.ARQ_PATH.$arquivo.'\',\''.$nomearquivo.'\')'.
            '->setMessage(\''.$amensagem.'\')'.
            '->setWrap(100)->send();');*/
            if($mail->send()){
                $mensagens = array(
                    "tipo" => 'sucesso',
                    "mgs_principal" => 'Anexo enviado com Sucesso',
                    "mgs_secundaria" => 'Voce enviou um Anexo com sucesso.'
                );
                $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens); 
                $this->_Visual->Json_Info_Update('Titulo','Enviado com Sucesso.');
            }else{
                $mensagens = array(
                    "tipo" => 'erro',
                    "mgs_principal" => 'Erro',
                    "mgs_secundaria" => 'Email não foi enviado !'
                );
                $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens); 
                $this->_Visual->Json_Info_Update('Titulo','Erro ao Enviar.');
            }
        }
    }
}
?>