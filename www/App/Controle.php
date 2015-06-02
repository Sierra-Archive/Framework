<?php
namespace Framework\App;
/**
 * 
 */
abstract class Controle
{
    public static $ligado = false;
    
    /**
     * Armazena a Classe Registro (Classe singleton, ela garante a existencia de apenas uma instancia de cada classe)
     * @var Object 
     */
    protected $_Registro;
    protected $_Cache;
    protected $_Modelo;
    protected $_Visual;
    protected $_request;
    
    protected $_Acl;
    
    protected $sistema_linguagem = 'ptBR';
    
    protected $layoult_zerar = 'naousado'; // 
    public static $config_template;
    
    // Endereco
    protected $layoult_endereco_alterado = false; // 
    protected $layoult_endereco_travar = false; //
    protected $layoult_endereco = Array(
        Array('Página Inicial','_Sistema/Principal/Home')
    ); // 
    
    // BLOQUEIO DE LAYOULT E SE O SISTEMA TA PARA USUARIO LOGADO OU NAO
    protected static $sistema_travado = false;
    
    // CARREGA MODULOS
    protected $ModulosHome = array();
    /**
    * Construtor
    * 
    * @name __construct
    * @access public
    * 
    * @uses \Framework\App\Visual::$renderizar Carrega Layoult do Site se nao tiver logado ou nao tiver permissao suficiente
    * @uses \Framework\App\Visual::$menu
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 2.0.1
    */
    
    public function __construct(){
        $imprimir = new \Framework\App\Tempo('Construcao Controle');
        self::$ligado = true;
        
        $this->_Registro    = &\Framework\App\Registro::getInstacia();
        $this->_request     = &$this->_Registro->_Request;
        $this->_Cache       = &$this->_Registro->_Cache;
        $this->_Acl         = &$this->_Registro->_Acl;
        $this->_Modelo      = &$this->_Registro->_Modelo;
        $this->_Visual      = &$this->_Registro->_Visual;
        
        
        
        /*$manutencao = new \Framework\Classes\SierraTec_Manutencao();
        $manutencao->Atualizacao_Version(2.2);
        */
       /* $manutencao = new \Framework\Classes\SierraTec_Manutencao();
        $manutencao->Tranferencia_DB_Servidor('Fenix_Atls');
        exit;/**/
        
        /*$face = new \Framework\Classes\SierraTec_Facebook();
        $face->Armazena();
        
        exit;*/
        /*$manutencao = new \Framework\Classes\SierraTec_Manutencao();
        $manutencao->Manutencao();*/
        
        /*$framework = new \Framework\Classes\SierraTec_Manutencao();
        $framework->Atualiza_Dependencias();
        exit;*/
        

        // Carrega Modulos
        $this->ModulosHome = config_modulos();

        // Se nao for tipo AJAX chama os widgets;
        if(LAYOULT_IMPRIMIR!=='AJAX'){
            $this->Chamar_Widget();
        }
            
    }
    public function Json_Definir_zerar($valor){
        $this->layoult_zerar = $valor;
    }
    // #analisar -> Pouco Usado
    /**
     * 
     * @param type $lib
     * @throws Exception
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.0.1
     */
    protected function getLibrary($lib){
        $url_livraria = ROOT.'libs'.DS.$lib.'.php';
        if(is_readable($url_livraria)){
            require_once $url_livraria;
        }else{
            throw new \Exception('Biblioteca não Encontrada',404);
        }
    }
    /**
     * 
     * @param type $nome
     * @param type $endereco
     */
    public function Tema_Endereco($nome,$endereco=false){
        //if(!$this->layoult_endereco_travar){
            $this->layoult_endereco_alterado = true;
            // Caso seja endereco final nao deixa mais acrescentar nenhum
            //if(!$endereco) $this->layoult_endereco_travar = true;
            // ACrescenta Enderecos
            $this->layoult_endereco[] = Array($nome,$endereco);
        //}
    }
    /**
     * 
     * @param type $ultimo (false = todos, ou numero de vezes que vai tirar
     */
    protected function Tema_Endereco_Zerar($ultimo = false){
        if($ultimo===false){
            $this->layoult_endereco = Array(
                Array('Página Inicial','_Sistema/Principal/Home')
            );
        }else{
            $ultimo = (int) $ultimo;
            $i = 0;
            while($i<$ultimo){
                $removido = array_pop($this->layoult_endereco);
                --$ultimo;
            }
        }
    }
    /**
     * Envia Email
     * @param type $texto
     * @param type $assunto
     * @param type $email
     * @param type $nome
     * @return type
     */
    public static function Enviar_Email($texto,$assunto='Sem Assunto',$email=false,$nome=false){
        require_once CLASS_PATH . 'Email'.DS.'Email'.'.php';
        if($email===false) $email = SISTEMA_EMAIL_RECEBER;
        if($nome===false) $nome = 'Administrador';
        $mailer = new \Framework\Classes\Email();
        $send	= $mailer->setTo($email, $nome)
                    ->setSubject($assunto.' - '.SISTEMA_NOME)
                    ->setFrom(SISTEMA_EMAIL, SISTEMA_NOME)
                    ->addGenericHeader('X-Mailer', 'PHP/' . phpversion())
                    ->addGenericHeader('Content-Type', 'text/html; charset="utf-8"')
                    ->setMessage($texto)
                    ->setWrap(78)->send();
        return $send;
    }
    /**
     * Envia Email com ANexo para um Usuario do SIstema
     * 
     * @param type $id
     * @param type $arquivo
     * @param type $nomearquivo
     */
    protected function Enviar_Email_Anexo($id,$arquivo,$nomearquivo){
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
    /**
     * Trava o Código e para de Executar tudo
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public static function Tema_Travar(){
        self::$sistema_travado = true;
        
        Boot::Desligar();
    }
    /**
     * Retorna se o Layoult está travado de retornar HTML ou nao !
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public static function &Tema_Travar_GET(){
        return self::$sistema_travado;
    }
    /**
     * Efetua Download de Certo Aquivo
     */
    public static function Export_Download($endereco,$arquivo_nome='Relatorio'){
	// Define o tempo máximo de execução em 0 para as conexões lentas
	set_time_limit(0);
	 
	// Arqui você faz as validações e/ou pega os dados do banco de dados
	$arquivoLocal = ARQ_PATH.$endereco; // caminho absoluto do arquivo
	 
	// Verifica se o arquivo não existe
	if (!file_exists($arquivoLocal)) {
	// Exiba uma mensagem de erro caso ele não exista
            throw new \Exception('Arquivo não existe.'.$arquivoLocal,404);
	}
	 
        /*header("Content-Type: application/force-download");
header("Content-Type: application/octet-stream");
header("Content-Type: application/download");

header("Content-Length: ".filesize($link));

header('Content-Disposition: attachment; filename="'.$titulo_novo.'"');

readfile($link);*/
        $ext = strtolower(substr(strrchr(basename($arquivoLocal),"."),1));
        if($ext==='pdf'){ // verifica a extensão do arquivo para pegar o tipo
            $tipo="application/pdf";
        }else if($ext==='exe'){ // verifica a extensão do arquivo para pegar o tipo
            $tipo="application/octet-stream";
        }else if($ext==='zip'){ // verifica a extensão do arquivo para pegar o tipo
            $tipo="application/zip";
        }else if($ext==='doc'){ // verifica a extensão do arquivo para pegar o tipo
            $tipo="application/msword";
        }else if($ext==='xls'){ // verifica a extensão do arquivo para pegar o tipo
            $tipo="application/vnd.ms-excel";
        }else if($ext==='ppt'){ // verifica a extensão do arquivo para pegar o tipo
            $tipo="application/vnd.ms-powerpoint";
        }else if($ext==='gif'){ // verifica a extensão do arquivo para pegar o tipo
            $tipo="image/gif";
        }else if($ext==='png'){ // verifica a extensão do arquivo para pegar o tipo
            $tipo="image/png";
        }else if($ext==='jpg'){ // verifica a extensão do arquivo para pegar o tipo
            $tipo="image/jpg";
        }else if($ext==='mp3'){ // verifica a extensão do arquivo para pegar o tipo
            $tipo="audio/mpeg";
        }else{
            $tipo = 'application/octet-stream';
        }
        
        // Remove Zipagem de Arquivo
        ob_end_clean();
        ob_start();
        
        // Remove HEADER ANTERIORES
        header_remove('Content-Type');
        header_remove('Content-Encoding');
        
	// Configuramos os headers que serão enviados para o browser
	header('Content-Description: File Transfer');
	header('Content-Disposition: attachment; filename="'.basename($arquivo_nome).'"');
	header('Content-Type: '.$tipo);
	header('Content-Transfer-Encoding: binary');
	header('Content-Length: ' . filesize($arquivoLocal));
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Pragma: public');
	header('Expires: 0');
	 
	// Envia o arquivo para o cliente
	readfile($arquivoLocal);
    }
    protected function Gerador_Notificacao($pagina_permissao,$notificacao){
        // Se nao existir cria
        $folder     = TEMP_PATH.'Grafico';
        $folder_url = TEMP_URL.'Grafico';
        if(!file_exists($folder))
        {
            mkdir($folder, 0777);
        }
    }
    protected function Gerador_Grafico_Padrao($titulo,$x_nome='EixoX',$y_nome='EixoY',$dados=Array(),$tipo = 'points',$larg=600,$alt=400, $convert_real=true){
        // Se nao existir cria
        $folder     = TEMP_PATH.'Grafico';
        $folder_url = TEMP_URL.'Grafico';
        if(!file_exists($folder))
        {
            mkdir($folder, 0777);
        }


        // Inclui funcao
        //require_once("libs/phplot/phplot.php");
        $plot = new \Framework\Classes\PHPlot($larg, $alt);
        $plot->SetTitle(utf8_decode($titulo));
        $plot->SetXTitle(utf8_decode($x_nome));
        $plot->SetYTitle(utf8_decode($y_nome));
        
        // Passar para Real
        // setar o valores no eixo Y no formato moeda
        // este metodo aceita uma função quando o parametro custom é setado
        $plot->SetYLabelType('custom', '\Framework\App\Sistema_Funcoes::Tranf_Float_Real');


        /*# Definimos os dados do gráfico
        $dados = array(
                array('Janeiro', 10),
                array('Fevereiro', 5),
                array('Março', 4),
                array('Abril', 8),
                array('Maio', 7),
                array('Junho', 5),
        );*/
        $nome_Arquivo       = md5(serialize($dados)).'.png';
        $nome_Arquivo_url   = $folder_url.US.$nome_Arquivo;
        $nome_Arquivo       = $folder.DS.$nome_Arquivo;
        $plot->SetIsInline(true);
        $plot->SetDataValues($dados);
        $plot->SetOutputFile($nome_Arquivo);

        # Mostramos o gráfico na tela
        //$plot->SetPlotType($tipo); //points, pie, bars

        $plot->DrawGraph();
        return $nome_Arquivo_url;
    }
    protected function Gerador_Grafico_Pizza($titulo,$x_nome='EixoX',$y_nome='EixoY',$x_dados=Array(),$y_dados=Array(),$tipo = 'points',$larg=300,$alt=200){
        // Inclui funcao
        require_once("libs/phplot/phplot.php");

        $larg = $_GET['larg'];
        $alt = $_GET['alt'];
        $titulo = $_GET['titulo'];
        $data = unserialize($_GET['data']);
        $settings = unserialize($_GET['settings']);

        $plot = new PHPlot($larg, $alt);
        $plot->SetTitle($titulo);
        $plot->SetDataValues($data);
        $plot->SetDataType('text-data-single');
        $plot->SetPlotType('pie');
        foreach ($data as $row) $plot->SetLegend($row[0]);
        $plot->SetCallback('draw_graph', 'draw_data_table', $settings);
        $plot->DrawGraph();
    }
    protected function Export_Todos($tipo,&$conteudo,$arquivo_nome='Relatorio'){
        $tipo = (string) 'Export_'.$tipo;
        if(is_callable(array($this,$tipo))){
            self::$tipo($conteudo,$arquivo_nome);
            return true;
        }else{
            return false;
        }
    }
    private static function Export_Pdf(&$conteudo,$arquivo_nome='Relatorio',$imprimir=false){
        ob_clean();
        $pdf = new \Framework\Classes\Pdf($arquivo_nome);
        if(is_array($conteudo)){
            // Retira Funcoes Caso Exista
            if(isset($conteudo['Funções'])) unset($conteudo['Funções']);
            $pdf->AddPage();
            $pdf->ArrayTable($conteudo);
        }
        /*$pdf->AddPage();
        $pdf->ImprovedTable($header,$data);
        $pdf->AddPage();
        $pdf->FancyTable($header,$data);*/
        if($imprimir===true){
            $pdf->Output($arquivo_nome.".pdf","D");
        }else{
            $pdf->Output();
        }
        // Trava Sistema
        self::Tema_Travar();
    }
    private static function Export_Pdf_Download(&$conteudo,$arquivo_nome='Relatorio'){
        self::Export_Pdf($conteudo, $arquivo_nome, true);
    }
    /**
     * Html para Impressao
     * @return type
     */
    protected static function Export_Imprimir_Titulo(){
        return '<img style="max-height: 80px;" alt="'.SISTEMA_NOME.'" src="'.ARQ_URL.'_Sistema/logo.png">'.'<hr>'.'';
    }
    /**
     * Html para Impressao
     * @return type
     */
    protected static function Export_Imprimir_Rodape(){
        return '<hr><b>Endereço:</b> '.SISTEMA_END.'<br><b>Telefone:</b> '.SISTEMA_TELEFONE.'<br><b>Email:</b> '.SISTEMA_EMAIL;
    }
    private static function Export_Imprimir(&$conteudo,$arquivo_nome='Relatorio'){
        // Começa HTML
        $html = '<html><head><title>'.$arquivo_nome.'</title><script type=\'text/javascript\' src=\''.WEB_URL.'sistema/jquery/jquery.min.js\'></script><style> '
                . 'body {'
                    . 'font-size: 12px;'
                . '}'
                . 'p {'
                    . 'margin: 0px;'
                    . 'padding: 0px;'
                . '}'
                . '</style></head><body>'.self::Export_Imprimir_Titulo();
        // Definimos o nome do arquivo que será exportado
        // Criamos uma tabela HTML com o formato da planilha
        if(is_array($conteudo)){
            // Retira Funcoes Caso Exista
            if(isset($conteudo['Funções'])) unset($conteudo['Funções']);
            $html .= '<table width="100%"><tr>';
            $total = 0;
            foreach($conteudo as $indice=>&$valor){
                $html .= '<td><b>'.$indice.'</b></td>';
                ++$total;
            }
            $tamanho = count($conteudo[$indice]);
            $html .= '</tr>';
            for ($i=0;$i<$tamanho;++$i){
                $html .= '<tr>';
                foreach($conteudo as &$valor){
                    $html .= '<td>';
                    if(!isset($valor[$i]) || $valor[$i]==''){
                        $html .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                    }else{
                        $html .= $valor[$i];
                    }
                    $html .= '</td>';
                }
                $html .= '</tr>';
            }
            $html .= '</table>';
        }else{
            $html .= $conteudo;
        }
        $html .= self::Export_Imprimir_Rodape().'<script type="text/javascript">$(document).ready(function() {self.print()});</script></body></html>';
        echo $html;
        // Trava Sistema
        self::Tema_Travar();
    }
    /**
     * @param type $tabela
     * @param string $arquivo_nome
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    private static function Export_Excel(&$tabela,$arquivo_nome='Relatorio'){
        // Retira Funcoes Caso Exista
        if(isset($tabela['Funções'])) unset($tabela['Funções']);
        // Definimos o nome do arquivo que será exportado
        $arquivo_nome = $arquivo_nome.'.xls';
        // Criamos uma tabela HTML com o formato da planilha
        $html = '<table><tr>';
        $total = 0;
        foreach($tabela as $indice=>&$valor){
            $html .= '<td><b>'.$indice.'</b></td>';
            ++$total;
        }
        $tamanho = count($tabela[$indice]);
        $html .= '</tr>';
        for ($i=0;$i<$tamanho;++$i){
            $html .= '<tr>';
            foreach($tabela as &$valor){
                $html .= '<td>';
                if(!isset($valor[$i]) || $valor[$i]==''){
                    $html .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                }else{
                    $html .= utf8_decode($valor[$i]);
                }
                $html .= '</td>';
            }
            $html .= '</tr>';
        }
        $html .= '</table>';
        // Configurações header para forçar o download
        header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
        header ("Cache-Control: no-cache, must-revalidate");
        header ("Pragma: no-cache");
        header ("Content-type: application/x-msexcel");
        header ("Content-Disposition: attachment; filename=\"{$arquivo_nome}\"" );
        header ("Content-Description: PHP Generated Data" );
        // Envia o conteúdo do arquivo
        echo $html;
        // Trava Sistema
        self::Tema_Travar();
    }
    /**
     * Carrega dentro de um Formulario um botao pra escolher categoria
     * 
     * @name Categorias_ShowSelect
     * @access public
     * 
     * @param Class $form Carrega Formulario por ponteiro
     * @param string $tipo Carrega Tipo de Categoria
     * 
     * @uses $language
     * @uses \Framework\Classes\Form::$Select_Novo
     * @uses \Framework\Classes\Form::$Select_Fim
     * @uses \Framework\App\Modelo::$Categorias_Retorna
     * @uses \Framework\App\Visual::$Categorias_ShowSelect
     * 
     * @return void
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    protected function Categorias_ShowSelect(&$form,$tipo='',$padrao=0){
        global $language;
    	$array = $this->_Modelo->Categorias_Retorna($tipo);
    	$form->Select_Novo($language['palavras']['cat'],'categoria','categoria');
    	$this->_Visual->Categorias_ShowSelect($array,$form,$padrao);
    	$form->Select_Fim();
    }
    /**
     * 
     * @param type $dir
     * @param type $fileTypes
     * @param type $nomearquivo
     * @return string
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0.0
     */
    /*public function Upload($dir = '', $fileTypes = Array(), $nomearquivo = ''){
        $targetPath = ARQ_PATH.$dir;
        if(!is_dir($targetPath)){
            mkdir ($targetPath, 0777,true );
        }
        if (!empty($_FILES)) {
            $tempFile = $_FILES['Filedata']['tmp_name'];
            // pega extensao
            $extensao = explode('.', $_FILES['Filedata']['name']);
            $i = count($extensao);
            $extensao = $extensao[$i-1];
            $targetFile = rtrim($targetPath,'/') . '/' . $nomearquivo.'.'.$extensao;
            // Validate the file type
            $fileParts = pathinfo($_FILES['Filedata']['name']);
            if (in_array($extensao,$fileTypes)) {
                move_uploaded_file($tempFile,$targetFile);
                chmod ($targetFile, 0777);
                echo 1;
                return $extensao;
            } else {
                echo 'Invalid file type.';
            }
        }
        return 'falso';
    }*/
    /**
     * Ainda Nao Usado
     * #update
     */
    protected function Upload_Ext_Informacao($ext){
        $extensoes = Array(
            'dia'   => Array(
                'Descricao' => 'Extensao Usada por Diagramas pelo Procura DIA',
                'Img'       => 'dia.jpg',
            )
        );
        return $extensoes[$ext];
    }
    /**
     * 
     * @param type $padrao
     * @return type
     */
    protected function Upload_Ext($padrao='Imagem,Audio,Video,Zipado,Documento,Grafico,BD'){
        // Imagem
        $Imagem = Array(
            'bmp',
            'jpg',
            'jpeg',    // 'jpe', // Bug de Banco de Dados com 3 varchar
            'gif',
            'png',
        );
        // Audio
        $Audio = Array(
            '3gp',
            'aac',
            'ac3',
            'mp3',
            'ogg',
            'wma',
            'wav',
            'rm',
        );
        // Video
        $Video = Array(
            'mp4',
            'avi',
            'mpeg',     //'mpe', // Bug de Banco de Dados com 3 varchar
            'mov',
            'rmvb',
            'mkv',
            'vob',
        );
        // Zipado
        $Zipado = Array(
            '7z', //7-zip
            'arj',
            'bz2', //bzip2
            'cab',
            'gz', //Gzip
            'rar',
            'tar',
            'zip',
        );
        // Documento
        $Documento = Array(
            'txt',
            'doc',
            'docx',
            'xls',
            'xlsx',
            'ppt',
            'pdf',
            'odt',
        );
        // Graficos
        $Grafico = Array(
            'dia',
        );
        // BD
        $BD = Array(
            'dba',
            'sql',
            'mdb',
        );
        
        /*
         * NAO VEM COMO PADRAO
         */
        // Desenvolvimento
        $Desenvolvimento = Array(
            'asp',
            'c','cpp',
            'html','js','css',
            'php','php3','php4',
            'jar',
            'kml',
        );
        $Executavel = Array(
            'exe','dll','bin',
        );
        
        // Pega Tipos e Preenche Ext
        $ext = Array();
        $padrao = explode(',',$padrao);
        foreach($padrao as $valor){
            if(isset($$valor)){
                $ext = array_merge($ext, $$valor);
            }
        }
        
        return $ext;
    }
    /**
     * 
     * @param type $dir
     * @param type $fileTypes
     * @param type $nomearquivo
     * @return boolean
     */
    protected function Upload($dir = '', $fileTypes = false, $nomearquivo = false){
        $targetPath = ARQ_PATH.$dir;
        if(!is_dir($targetPath)){
            mkdir ($targetPath, 0777,true );
        }
        if (!empty($_FILES)) {
            if($nomearquivo===false){
                $nomearquivo = strtolower(srand(time()).rand(10000000000000, 99999999999999));
            }else{
                $nomearquivo = strtolower($nomearquivo);
            }
            // pega extensao
            $extensao = explode('.', $_FILES['file']['name']);
            $nomeoriginal = $extensao[0];
            $i = count($extensao);
            $extensao = strtolower($extensao[$i-1]);
            
            $tempFile = $_FILES['file']['tmp_name'];
            $targetFile = rtrim($targetPath,'/').DS.$nomearquivo.'.'.$extensao;  //4

            //$targetFile =  $targetPath. $_FILES['file']['name'];  //5
            
            $fileParts = pathinfo($_FILES['file']['name']);
            
            if(!is_array($fileTypes)){
                if($fileTypes===false){
                    $fileTypes = $this->Upload_Ext();
                }else{
                    $fileTypes = $this->Upload_Ext($fileTypes);
                }
            }
            
            if (in_array($extensao,$fileTypes)) {
                $tamanho = filesize($tempFile);
                move_uploaded_file($tempFile,$targetFile);
                chmod ($targetFile, 0777);
                return Array($extensao,$nomearquivo,$nomeoriginal,$tamanho);
            } else {
                $mensagens = array(
                    "tipo"              => 'erro',
                    "mgs_principal"     => 'Formato de Arquivo Inválido',
                    "mgs_secundaria"    => 'Extensão '.$extensao.' não permitida.'
                );
                $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
                $this->Json_Definir_zerar(false);
                return false;
            }

        }
        return false;
    }
    public function Gerador_Visualizar_Unidade(&$objeto, $titulo = 'Sem Titulo'){
        $objeto_Classe = get_class($objeto);
        $colunas = $objeto_Classe::Gerar_Colunas();
        $html = '';

        // Roda as Colunas
        foreach ($colunas as $value) {
            $valor      = &$value['mysql_titulo'];
            $valor2     = $valor.'2';
            if(isset($value['edicao']['Nome']) && isset($objeto->$valor)){
                if($objeto->$valor2!=''){
                    $html .= '<p style="clear:left;"><label style="width:120px; float:left;"><b>'.$value['edicao']['Nome'].':</b></label> '.$objeto->$valor2.'</p>';
                }else if($objeto->$valor!=''){
                    $html .= '<p style="clear:left;"><label style="width:120px; float:left;"><b>'.$value['edicao']['Nome'].':</b></label> '.$objeto->$valor.'</p>';
                }
            }
        }

        
        // Formula Json
        $conteudo = array(
            'id' => 'popup',
            'title' => $titulo,
            'botoes' => array(
                array(
                    'text' => 'Fechar Janela',
                    'clique' => '$( this ).dialog( "close" );'
                )
            ),
            'html' => $html
        );
        $this->_Visual->Json_IncluiTipo('Popup',$conteudo);
        $this->_Visual->Json_Info_Update('Historico', false);
    }
    /**
     * Gera um Formulario em cima do Layoult escolhido e do Banco de Dados escolhido..
     * O Objeto Dao pode ter sido modificado (campos removidos para fins de personalização)
     * 
     * 
     * @param type $objeto (Objeto DAO)
     * @param type $formulario (Objeto Form, para aproveitar o mesmo formulario
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.0.2
     */
    static function Gerador_Formulario(&$objeto,&$form,$cache=true){
        $tempo = new \Framework\App\Tempo('Controle Gerador Formulario');
        $Registro   = &\Framework\App\Registro::getInstacia();
        $Modelo    = $Registro->_Modelo;
        $extrangeiras = Array();
        $controladordearray = false;
        $html = '';
        foreach ($objeto as &$valor){
                
            // Pega Link extra
            if(isset($valor['linkextra']) && $valor['linkextra']!==false && $valor['linkextra']!==''){
                // Verifica se Tem Permissao
                $permitir = explode('/', $valor['linkextra']);
                $permitir = $permitir[0];
                if(\Framework\App\Sistema_Funcoes::Perm_Modulos($permitir)===true){
                    $linkextra = $valor['linkextra'];
                }else{
                    $linkextra = '';
                }
            }else{
                $linkextra = '';
            }
            
            // Zera Variaveis
            $gerar_span = false;
            
            if(!isset($valor['edicao']) && !isset($valor['TabelaLinkada'])){
                continue;
            }
            
            // verifica se o campo é escondido ou nao
            if(
                (
                    !isset($valor['edicao']['form_escondido']) 
                    || $valor['edicao']['form_escondido']===false
                ) && 
                isset($valor['TabelaLinkada']) 
                && (
                    (
                        !isset($valor['TabelaLinkada'][$valor['TabelaLinkada']['formtipo']]['form_escondido']) 
                        || $valor['TabelaLinkada'][$valor['TabelaLinkada']['formtipo']]['form_escondido']===false
                    )
                )
            ){
                $escondido = false;
            }else if(
                (
                    (
                        isset($valor['edicao']['form_escondido'])
                        &&
                        ($valor['edicao']['form_escondido']===true 
                        || $valor['edicao']['form_escondido']=='apagado' )
                    )
                    || (
                        isset($valor['TabelaLinkada'])
                        && isset($valor['TabelaLinkada'][$valor['TabelaLinkada']['formtipo']]['form_escondido'])
                        && (
                            $valor['TabelaLinkada'][$valor['TabelaLinkada']['formtipo']]['form_escondido']===true 
                            || $valor['TabelaLinkada'][$valor['TabelaLinkada']['formtipo']]['form_escondido']=='apagado'    
                        )
                    )
                )
            ){
                $escondido = 'apagado';
            }else if(((isset($valor['edicao']) && isset($valor['edicao']['form_escondido']) && $valor['edicao']['form_escondido']=='apagar') || (isset($valor['TabelaLinkada']) && isset($valor['TabelaLinkada'][$valor['TabelaLinkada']['formtipo']]['form_escondido']) && $valor['TabelaLinkada'][$valor['TabelaLinkada']['formtipo']]['form_escondido']=='apagar'))){
                $escondido = 'apagar';
            }else{
                $escondido = false;
            }
            
            // SE for array bota span Principal para Multiplo Elementos
            if($controladordearray){
                if(isset($valor['mysql_titulo']) && strpos($valor['mysql_titulo'], '[]')===false){
                    $html .= $form->addtexto('</span></span>');
                    $controladordearray = false;
                }/*else if(isset($valor['TabelaLinkada']['SelectMultiplo'])){
                    $html .= $form->addtexto('</span></span>');
                    $controladordearray = false;
                }*/
            }else{
                if(isset($valor['mysql_titulo']) && strpos($valor['mysql_titulo'], '[]')!==false){
                    $html .= $form->addtexto('<span id="'.str_replace('[]', '', $valor['mysql_titulo']).'controlador"><span id="'.str_replace('[]', '', $valor['mysql_titulo']).'controlador1">');
                    $controladordearray = true;
                }
            }
            
            
            // Gerador de Span de COntrole
            if(isset($valor['TabelaLinkada']['SelectMultiplo'])){
                // Verifica se Ta escondido para colocar atributo extra
                $spanatributoextra = '';
                if($escondido!==false){
                    $spanatributoextra = ' class="'.$valor['TabelaLinkada']['SelectMultiplo']['Linkado'].'_escondendo"';
                    if($escondido=='apagado'){
                        $spanatributoextra .= ' style="display: none;"';
                    }
                }
                // Separa Span
                $html .= $form->addtexto('<span id="'.$valor['TabelaLinkada']['SelectMultiplo']['Linkado'].'controlador"'.$spanatributoextra.'><span id="'.$valor['TabelaLinkada']['SelectMultiplo']['Linkado'].'controlador1">');
                $gerar_span = true;
            }
            
            
            
            // Extrangeiras LINKADAS
            if(isset($valor['TabelaLinkada'])){
                $tabelalinkada = &$valor['TabelaLinkada'];
                if($tabelalinkada['formtipo']==='BoleanoMultiplo'){
                    list($selecionado,$nao_selecionado) = $Modelo->db->Tabelas_CapturaLinkadas($tabelalinkada);
                    $html .= $form->BoleanoMultiplo(
                        $tabelalinkada['Nome'],
                        $tabelalinkada['BoleanoMultiplo']['Col1'],
                        $tabelalinkada['BoleanoMultiplo']['Col2'],
                        'tablink_'.$tabelalinkada['Tabela'],
                        $tabelalinkada['Class'],
                        $nao_selecionado,
                        $selecionado,
                        $escondido
                    );
                }else if($tabelalinkada['formtipo']==='SelectMultiplo'){
                    
                    // Carrega Informação que aparecera na tela quando nada for escrito
                    if(isset($tabelalinkada['selectmultiplo']['infonulo']) && $tabelalinkada['selectmultiplo']['infonulo']!='' && $tabelalinkada['selectmultiplo']['infonulo']!==false){
                        $select_infonulo = $tabelalinkada['SelectMultiplo']['infonulo'];
                    }else{
                        $select_infonulo = 'Escolha uma Opção';
                    }
                    
                    // Puxa Selecionados, Resutados e Colunas
                    list($selecionados,$resultado, $colunas) = $Modelo->db->Tabelas_CapturaLinkadas($tabelalinkada);
                    // Configura Array
                    $opcoes = Array();
                    if($resultado!==false){
                        // Captura Selects da Chave Extrangeira
                        foreach ($resultado as $indice_cha_ext=>$valor_cha_ext){
                            $selecionado = 0;
                            if(in_array($indice_cha_ext, $selecionados)){
                                $selecionado = 1;
                            }
                            $opcoes[] = Array(
                                'titulo'    => $valor_cha_ext,
                                'valor'     => $indice_cha_ext,
                                'selected'  => $selecionado,
                            );
                        }
                    }
                    // Coloca {id} que sera substituido pelo id
                    if($colunas!==false){
                        $colunas_temporaria = $colunas;
                        self::DAO_Campos_TrocaID($colunas_temporaria,'{id}');
                        // Puxa CAmpos Javascript
                        $form_js = new \Framework\Classes\Form();
                        $javascript_campos = self::Gerador_Formulario($colunas_temporaria, $form_js,false);
                        $javascript_campos = str_replace(Array('"','\n','\r','    '), Array('\"','','',''), $javascript_campos);
                        $javascript_campos = preg_replace('/\s/',' ',trim($javascript_campos));
                    }else{
                        $javascript_campos = '';
                    }
                    // Puxa Select
                    $html .= $form->SelectMultiplo(
                        $tabelalinkada['Nome'],     //Nome
                        $opcoes,          // Opcões do Slect
                        $tabelalinkada['SelectMultiplo']['Linkado'], // ID
                        $tabelalinkada['SelectMultiplo']['linkextra'],   // url
                        $tabelalinkada['SelectMultiplo']['Campos'],   // url
                        $javascript_campos, // js
                        false,    // condicao
                        $escondido,             // Se esta Escondido ou nao
                        $tabelalinkada['Class'],           // Class
                        $select_infonulo   // Informacao quando vazio             
                    );
                    // Se tiver selecionado coloca as colunas extras extras 
                    if($selecionados!==false && !empty($selecionados) && $colunas!==false){
                        foreach ($selecionados as &$valor2){
                            // Chama TAbela
                            $tabela_link = \Framework\App\Conexao::Tabelas_GetSiglas_Recolher($tabelalinkada['Tabela']);
                            // Condicao
                            $where = Array(
                                $tabelalinkada['SelectMultiplo']['Linkar'] =>$tabelalinkada['valor_padrao'],
                                $tabelalinkada['SelectMultiplo']['Linkado']=>$valor2
                            );
                            $objeto_novo = $Modelo->db->Sql_Select($tabela_link['classe'], $where,1);
                            if($objeto_novo===false) throw new \Exception('Registro não existe: ID->'.$id,404);
                            // Atualiza Valores
                            self::mysql_AtualizaValores($colunas, $objeto_novo, $objeto_novo->id);
                            // Atualiza id
                            $colunas_temporaria = $colunas;
                            self::DAO_Campos_TrocaID($colunas_temporaria,$valor2);
                            $nome = $tabelalinkada['SelectMultiplo']['Linkado'].'2';
                            // caso nao exista
                            if($objeto_novo->$nome===NULL){
                                CONTINUE;
                            }
                            self::DAO_Campos_TrocaNOME($colunas_temporaria,$objeto_novo->$nome);
                            // Separa os Span
                            $html .= $form->addtexto('</span><span id="'.$tabelalinkada['SelectMultiplo']['Linkado'].'controlador_'.$valor2.'">');
                            // PEga os CAmpos Extrangeiros
                            self::Gerador_Formulario($colunas_temporaria, $form,false);
                        }
                    }
                }
            }else if($valor['mysql_estrangeira']!==false && isset($valor['edicao'])){
                
                // Grava Extrangeira
                $extrangeiras[$valor['mysql_titulo']] = $valor['edicao']['valor_padrao'];
                
                // Captura condicao
                if($valor['mysql_estrangeira']){
                    $condicao = $valor['mysql_estrangeira'];
                    /*// Caso seja Extrangeira e dependente
                    if(strpos($condicao, '{')!==false){
                        $ext_campo = explode('|', $condicao);
                        $ext_campo = $ext_campo[2];
                        if(strpos($ext_campo, '.')!==false){
                            $ext_campo = explode('.', $ext_campo);
                            $ext_campo = $ext_campo[1];
                        }
                        $ext_campo = explode('=', $ext_campo);
                        $ext_campo = $ext_campo[0];
                        if(isset($extrangeiras[$ext_campo]) && $extrangeiras[$ext_campo]!==false){
                            $condicao = preg_replace('/{(.+)}/U', $extrangeiras[$ext_campo], $condicao);
                        }else{
                            $condicao = preg_replace('/{(.+)}/U', '0', $condicao);
                        }
                    }*/
                }else{
                    $condicao = false;
                }
                
                // Se houver dependencias no formulario, vai ter o form_change diferente de false
                if(isset($valor['form_change']) && $valor['form_change']!='' && $valor['form_change']!==false){
                    $change = 'Modelo_Ajax_Chamar(\'_Sistema/Recurso/Select_Recarrega_Extrangeira/'.$valor['form_change'].'/'.$valor['mysql_titulo'].'/\'+this.value,\'\',\'get\',true)';
                }else if(isset($valor['edicao']['change'])){
                    $change = $valor['edicao']['change'];
                }else{
                    $change = '';
                }
                
                // Add CLASSE DO Select
                if(isset($valor['edicao']['select']['class']) && $valor['edicao']['select']['class']!='' && $valor['edicao']['select']['class']!==false){
                    $select_class = $valor['edicao']['select']['class'];
                }else{
                    $select_class = '';
                }
                
                // Informação quando nulo 
                if(isset($valor['edicao']['select']['infonulo']) && $valor['edicao']['select']['infonulo']!='' && $valor['edicao']['select']['infonulo']!==false){
                    $select_infonulo = $valor['edicao']['select']['infonulo'];
                }else{
                    $select_infonulo = 'Escolha uma Opção';
                }
                
                // Multiplo select ou nao?
                if(isset($valor['edicao']['select']['multiplo']) && $valor['edicao']['select']['multiplo']!='' && $valor['edicao']['select']['multiplo']!==false){
                    $multiplo = true;
                }else{
                    $multiplo = false;
                }
                
                // Verifica se titulo tem [] indicando array para entao remover
                if(strpos($valor['mysql_titulo'], '[]')!==false && $multiplo===true){
                    $selectid = str_replace('[]', '', $valor['mysql_titulo']);
                }else{
                    $selectid = $valor['mysql_titulo'];
                }
                
                // Por fim, Add ao formulário o novo select
                $html .= $form->Select_Novo(
                    $valor['edicao']['Nome'],
                    $valor['mysql_titulo'],
                    $selectid,
                    $linkextra,
                    $change,
                    '',
                    $condicao,
                    $escondido,
                    $select_class,
                    $select_infonulo,
                    $multiplo
                );
                
                // Primeira Opção
                if($valor['edicao']['valor_padrao']===false){
                    $html .= $form->Select_Opcao('','',1);
                }else{
                    $html .= $form->Select_Opcao('','',0);
                }
                
                // Captura Selects pré denifidos
                if(isset($valor['edicao']['select']) && isset($valor['edicao']['select']['opcoes'])){
                    $select = &$valor['edicao']['select']['opcoes'];
                    foreach ($select as &$valor2){
                        if((string) $valor2['value'] === (string) $valor['edicao']['valor_padrao']){
                            $selecionado=1;
                        }else{
                            $selecionado=0;
                        }
                        $html .= $form->Select_Opcao($valor2['nome'],$valor2['value'],$selecionado);
                    }
                }
                
                // Captura Selects da Chave Extrangeira
                $resultado = $Modelo->db->Tabelas_CapturaExtrangeiras($valor);
                foreach ($resultado as $indice2 => &$valor2){
                    if((string) $indice2 === (string) $valor['edicao']['valor_padrao']){
                        $selecionado=1;
                    }else{
                        $selecionado=0;
                    }
                    $html .= $form->Select_Opcao($valor2,$indice2,$selecionado);
                }
                // Fecha Select
                $html .= $form->Select_Fim();
                
            }else 
            // Caso Contrario e Possua Opcao Edicao
            if(isset($valor['edicao'])){
                
                // Trata Campos que Mudam o Formulario, se for false desabilita mudanças
                if($valor['edicao']['valor_padrao']===false && isset($valor['edicao']['change']) && strpos($valor['edicao']['change'], 'Control_Layoult_Form_Campos_Trocar')!==false){
                    self::DAO_Campos_AlternadosDesabilitados($objeto);
                }
                
                if($valor['edicao']['formtipo']=='textarea'){
                    $html .= $form->TextArea_Novo(
                        $valor['edicao']['Nome'],
                        $valor['mysql_titulo'],
                        $valor['mysql_titulo'],
                        $valor['edicao']['valor_padrao'],
                        $valor['edicao']['textarea']['tipo'],
                        $valor['mysql_tamanho'],
                        $valor['edicao']['textarea']['class'],
                        $valor['edicao']['aviso'],
                        $valor['edicao']['readonly'],
                        $linkextra,
                        $escondido
                    ); 
                }else if($valor['edicao']['formtipo']=='input'){
                    // Change para formularios
                    if(isset($valor['edicao']['change']) && $valor['edicao']['change']!==false & $valor['edicao']['change']!=''){
                        $change = $valor['edicao']['change'];
                    }
                    else{
                        $change = '';
                    }
                    // Verifica se tem validacao js
                    if(isset($valor['edicao']['validar']) && $valor['edicao']['validar']!==false & $valor['edicao']['validar']!=''){
                        $validar = $valor['edicao']['validar'];
                    }
                    else{
                        $validar = '';
                    }
                    // Verifica se tem validacao js
                    if(isset($valor['edicao']['Mascara']) && $valor['edicao']['Mascara']!==false & $valor['edicao']['Mascara']!=''){
                        $mascara = $valor['edicao']['Mascara'];
                    }
                    else{
                        $mascara = false;
                    }
                    $html .= $form->Input_Novo(
                        $valor['edicao']['Nome'],
                        $valor['mysql_titulo'],
                        $valor['edicao']['valor_padrao'],
                        $valor['edicao']['input']['tipo'], 
                        $valor['mysql_tamanho'], 
                        $valor['edicao']['input']['class'],
                        $valor['edicao']['aviso'],
                        $valor['edicao']['readonly'],
                        $linkextra,
                        $change,
                        $mascara,
                        $validar,
                        $escondido
                    ); 
                
                }else if($valor['edicao']['formtipo']=='upload'){
                    // Verifica se tem validacao js
                    if(isset($valor['edicao']['validar']) && $valor['edicao']['validar']!==false & $valor['edicao']['validar']!=''){
                        $validar = $valor['edicao']['validar'];
                    }
                    else{
                        $validar = '';
                    }
                    $html .= $form->Upload(
                        $valor['edicao']['Nome'],
                        $valor['mysql_titulo'],
                        $valor['edicao']['valor_padrao'],
                        $valor['edicao']['upload']['tipo'], 
                        $valor['edicao']['upload']['class'],
                        $valor['edicao']['aviso'],
                        $valor['edicao']['aviso_titulo'],
                        $valor['edicao']['readonly'],
                        $validar,
                        $escondido
                    ); 
                }elseif($valor['edicao']['formtipo']=='select'){
                    if(isset($valor['edicao']['change'])){
                        $change = $valor['edicao']['change'];
                    }
                    else{
                        $change = '';
                    }
                    // Add o Select
                    if(isset($valor['edicao']['select']['class']) && $valor['edicao']['select']['class']!='' && $valor['edicao']['select']['class']!==false){
                        $select_class = $valor['edicao']['select']['class'];
                    }else{
                        $select_class = '';
                    }
                    if(isset($valor['edicao']['select']['infonulo']) && $valor['edicao']['select']['infonulo']!='' && $valor['edicao']['select']['infonulo']!==false){
                        $select_infonulo = $valor['edicao']['select']['infonulo'];
                    }else{
                        $select_infonulo = 'Escolha uma Opção';
                    }
                    
                    $html .= $form->Select_Novo(
                        $valor['edicao']['Nome'],
                        $valor['mysql_titulo'],
                        $valor['mysql_titulo'],
                        $linkextra,
                        $change,
                        '',
                        false,
                        $escondido,
                        $select_class,
                        $select_infonulo
                    );
                    $select = &$valor['edicao']['select']['opcoes'];
                    if($valor['edicao']['valor_padrao']===false){
                        $html .= $form->Select_Opcao('','',1);
                    }else{
                        $html .= $form->Select_Opcao('','',0);
                    }
                    if(is_array($select)){
                        foreach ($select as &$valor2){
                            if( (string) $valor2['value'] === (string) $valor['edicao']['valor_padrao']){
                                $selecionado=1;
                            }else{
                                $selecionado=0;
                            }
                            $html .= $form->Select_Opcao($valor2['nome'],$valor2['value'],$selecionado);
                        }
                    }
                    $html .= $form->Select_Fim();
                }
            }
            // se FOI CRIADO SPAN, FECHA
            if(isset($valor['TabelaLinkada']['SelectMultiplo'])){
                $html .= $form->addtexto('</span></span>');
                $controladordearray = false;
            }
            // SE for array bota span
            if($gerar_span===true){
                $html .= $form->addtexto('</span></span>');
                $gerar_span = false;
            }
        }
        return $html;
    }
    /**
     * Gera Formulario de Cadastro
     * 
     * 
     * @param type $titulo1
     * @param type $titulo2
     * @param type $formlink
     * @param type $formid
     * @param type $formbt
     * @param type $campos
     * @param type $editar
     * @param type $bloco
     * @param type $janela   // Indica se altera nome de pagina e etc.. enfim, funciona como janela unica ?
     * @throws Exception
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.0.1
     */
    static function Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,&$campos = false,$editar=false,$bloco='All',$janela=true){
        $registro = &\Framework\App\Registro::getInstacia();
        $Controle = &$registro->_Controle;
        $Modelo = &$registro->_Modelo;
        $Visual = &$registro->_Visual;
        $tempo = new \Framework\App\Tempo('Controle Gerador Form Janela');
        
        // Define Popup
        if(isset($_GET['formselect']) && $_GET['formselect']!=''){
            $bloco='Popup';
        }else if(isset($_GET['popup']) && $_GET['popup']!=''){
            $bloco='Popup';
        }
        
        // Se nao for ajax sai do Popup
        if(!defined('LAYOULT_POPUP')){
            if($bloco==='Popup' && LAYOULT_IMPRIMIR!=='AJAX'){
                $bloco='All';
                define('LAYOULT_POPUP', false);
            }else if($bloco==='Popup'){
                define('LAYOULT_POPUP', true);
            }else{
                define('LAYOULT_POPUP', false);
            }
        }else{
            if($bloco==='Popup' && LAYOULT_IMPRIMIR!=='AJAX'){
                $bloco='All';
            }
        }
        
        if(!is_array($campos)){
            $campos = $Modelo->Dao_GetColunas($campos);
        }
        
        // Verifica se nao é editavel
        if($editar!==false){
            
            if(is_object($editar)){
                $objeto = &$editar;
                $primaria = $objeto->Get_Primaria();
                
                
                if($primaria!==false){
                    $id = (int) $objeto->$primaria[0];
                }else{
                    $id = (int) $objeto->id;
                }
            }else{
                if(!is_array($editar))throw new \Exception('Variavel nao e um Array: '.$editar,2800);
                
                // PRIMARIA
                $class_usada = $editar[0].'_DAO';
                $primaria = new $class_usada;
                unset($class_usada);
                $primaria = $primaria->Get_Primaria();
                
                // recupera Arquivo
                if($primaria!==false){
                    $id = \anti_injection($editar[1]);
                    $objeto = $Modelo->db->Sql_Select($editar[0], Array($primaria[0]=>$id),1);
                }else{
                    $id = (int) $editar[1];
                    $objeto = $Modelo->db->Sql_Select($editar[0], Array('id'=>$id),1);
                }
                
                if($objeto===false) throw new \Exception('Registro não existe: ID->'.$id,404);
            }
            self::mysql_AtualizaValores($campos, $objeto,$id);
        }
        // Puxa Form
        $form = new \Framework\Classes\Form($formid,$formlink,'formajax',"mini",'horizontal','off');
        \Framework\App\Controle::Gerador_Formulario($campos, $form, true);
        // Carrega formulario
        if($bloco==='html'){
            return $form->retorna_form($formbt);
        }else if($bloco==='Popup' || (LAYOULT_POPUP===TRUE && LAYOULT_IMPRIMIR==='AJAX')){
            $formulario = $form->retorna_form();
            $conteudo = array(
                'id' => 'popup',
                'title' => $titulo2,
                'botoes' => array(
                    array(
                        'text' => $formbt,
                        'clique' => '$(\'#'.$formid.'\').submit();'
                    ),
                    array(
                        'text' => 'Cancelar',
                        'clique' => '$( this ).dialog( "close" );'
                    )
                ),
                'html' => \Framework\App\Sistema_Funcoes::HTML_min($formulario)
            );
            $Visual->Json_IncluiTipo('Popup',$conteudo);
            $janela = false;
        }else{
            $Visual->Blocar($form->retorna_form($formbt));
            // Mostra Conteudo
            if($bloco==='All'){
                $Visual->Bloco_Unico_CriaJanela($titulo2,'',0,'Sierra.Control_Form_Tratar($(\'#'.$formid.'\')[0]);');
            }else if($bloco==='right'){
                $Visual->Bloco_Menor_CriaJanela($titulo2,'',0,'Sierra.Control_Form_Tratar($(\'#'.$formid.'\')[0]);');
            }else if($bloco==='left'){
                $Visual->Bloco_Maior_CriaJanela($titulo2,'',0,'Sierra.Control_Form_Tratar($(\'#'.$formid.'\')[0]);');
            }
        }
        // Adiciona Titulo ao Endereço
        if($janela===true){
            $Controle->Tema_Endereco($titulo1);
            $Visual->Json_Info_Update('Historico', true);
            $Visual->Json_Info_Update('Titulo',$titulo1);
        }else{
            $Visual->Json_Info_Update('Historico', false);
        }
    }
    /**
     * 
     * @global type $language
     * @param type $titulo
     * @param type $dao
     * @param type $funcao
     * @param type $sucesso1
     * @param type $sucesso2
     * @param type $colocar
     * @param type $erro1
     * @param type $erro2
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.0.1
     */
    protected function Gerador_Formulario_Janela2($titulo,$dao,$funcao = '',$sucesso1,$sucesso2,$colocar=false,$erro1 = '',$erro2 = ''){
        global $language;
        $tempo = new \Framework\App\Tempo('Controle Gerador Form Janela2');
        // Variaveis
        $camponovo = false;
        // Verifica se é pra Add ou Editar
        if(is_array($dao)){
            $tipo           = 'edit';
            $tab            = \anti_injection($dao[0]);
            
            
            // PRIMARIA
            $class_usada = $tab.'_DAO';
            $primaria = new $class_usada;
            unset($class_usada);
            $primaria = $primaria->Get_Primaria();

            // recupera Arquivo
            if($primaria!==false){
                $identificador = \anti_injection($dao[1]);
                $objeto = $this->_Modelo->db->Sql_Select($tab, '{sigla}'.$primaria[0].'=\''.$identificador.'\'',1);
            }else{
                $identificador  = (int) $dao[1];
                $objeto = $this->_Modelo->db->Sql_Select($tab, '{sigla}id=\''.$identificador.'\'',1);
            }
            if($objeto===false) throw new \Exception('Registro não existe: ID->'.$identificador,404);
        }else{
            $tipo           = 'add';
            $tab            = \anti_injection($dao);
            $class_usada    = $tab.'_DAO';
            $identificador  = false;
            // Cria novo Origem
            $objeto         = new $class_usada;
            unset($class_usada);
            $primaria = $objeto->Get_Primaria();
        }
        
        // Adiciona OU Edita Valores
        self::mysql_AtualizaValores($objeto);
        
        // Adiciona Valores
        if(is_array($colocar) && $colocar!==false){
            reset($colocar);
            while (key($colocar) !== null) {
                $chave=key($colocar);
                $objeto->$chave = current($colocar);
                next($colocar);
            }
        }
        
        // Verifica Indices UNICOS
        $unicos = $objeto->Get_Indice_Unico();
        
        // Começa
        if($unicos!==false){
            foreach($unicos as &$valor){
                $indice_campos = '';
                $valor = str_replace(Array('`'), Array(''), $valor);
                $valores = explode(',',$valor);
                $where = Array();
                foreach($valores as &$valor2){
                    if($valor2=='servidor'){
                        $where[$valor2] = SRV_NAME_SQL;
                    }else{
                        $where[$valor2] = $objeto->$valor2;
                        if($indice_campos!=''){
                            $indice_campos .= ', ';
                        }
                        $indice_campos .= $valor2;
                    }
                }
                // caso esteja editando, o proprio registro nao conta
                if($tipo === 'edit' && $primaria!==false){
                    $where['!'.$primaria[0]] = $objeto->$primaria[0];
                }
                $objeto_pesquisado  = $this->_Modelo->db->Sql_Select($tab, $where,1);
                // Se for Encontrado outro Objeto Trava Funcao e Retorna Erro
                if($objeto_pesquisado!==false){
                    $mensagens = array(
                        "tipo"              => 'erro',
                        "mgs_principal"     => 'Registro Duplicado',
                        "mgs_secundaria"    => 'Dados já registrados: '.$indice_campos.'.'
                    );
                    $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
                    $this->_Visual->Javascript_Executar(
                            '$("#'.$valor2.'").css(\'border\', \'2px solid #FFAEB0\').focus();'
                    );
                    $this->_Visual->Json_Info_Update('Historico', false);
                    $this->layoult_zerar = false; 
                    return false;
                }
            }
        }
        // Insere OU ATUALIZA
        if($tipo=='add'){
            $sucesso        = $this->_Modelo->db->Sql_Inserir($objeto);
            $identificador  = $this->_Modelo->db->ultimo_id();
        }else if($tipo=='edit'){
            $identificador  = $objeto->$primaria[0];
            $sucesso        = $this->_Modelo->db->Sql_Update($objeto);
        }
        
        // Trata AS EXTRANGEIRAS MUITOS PARA MUITOS (LINKADAS)
        $dao_completo = $tab.'_DAO';
        $sigla = $dao_completo::Get_Sigla();
        $links = \Framework\App\Conexao::Tabelas_GetLinks_Recolher($sigla);
        $campos = &Conexao::Tabelas_GetCampos_Recolher($sigla);
        if($campos!==NULL && !empty($campos)){
            foreach ($campos as &$valor){
            if(isset($valor['TabelaLinkada'])){
                $tabelalinkada = &$valor['TabelaLinkada'];
                
                // Verifica se ta liberado e faz os calculos necessarios
                if($tabelalinkada['formtipo']=='SelectMultiplo'){
                    $get = $tabelalinkada['SelectMultiplo']['Linkado'];
                    
                    // Vericica se realmente é um array e captura
                    if(isset($_POST[$get]) && is_array($_POST[$get])){
                        $get = array_unique(\anti_injection($_POST[$get]));
                    }
                    
                    // Caso Exista o Mesmo o trata
                    if(isset($get) && is_array($get)){
                        // Busca AS caracteristicas da tabela mandando a sigla como parametro
                        $nome_da_tab        = \Framework\App\Conexao::Tabelas_GetSiglas_Recolher($tabelalinkada['Tabela']);
                        $nome_da_tab        = $nome_da_tab['classe'];
                        $nome_da_tab_class  = $nome_da_tab.'_DAO';

                        // Seleciona Todas as Opções
                        $where = Array($tabelalinkada['SelectMultiplo']['Linkar'] => $identificador);
                        $respostas  = $this->_Modelo->db->Sql_Select($nome_da_tab, $where);
                        // PEga essas opcoes e deleta a porra toda !
                        if($respostas!==false){
                            if(!is_array($respostas)) $respostas = Array($respostas);
                            $this->_Modelo->db->Sql_Delete($respostas,true);
                        }
                        // Agora registra o que importa
                        foreach($get as &$valor2){
                                // Caso nao exista pula
                            if($valor2=='' || $valor===NULL) continue;
                            // Cria Objeto e Cadastra o Mesmo
                            $objeto2 = new $nome_da_tab_class;
                            $objeto2->$tabelalinkada['SelectMultiplo']['Linkar']  = $identificador;
                            $objeto2->$tabelalinkada['SelectMultiplo']['Linkado'] = $valor2;
                            $ocampos = $tabelalinkada['SelectMultiplo']['Campos'];
                            if(isset($tabelalinkada['Preencher']) && $tabelalinkada['Preencher']!==false){
                                foreach($tabelalinkada['Preencher'] as $indice3=>&$valor3){
                                    $objeto2->$indice3 = $valor3;
                                }
                            }
                            if($ocampos!==false){
                                foreach($ocampos as &$valor3){
                                    if(isset($_POST[$valor3.'_'.$valor2])){
                                        $objeto2->$valor3 = \anti_injection($_POST[$valor3.'_'.$valor2]);
                                    }
                                }
                            }
                            $sucesso = $this->_Modelo->db->Sql_Inserir($objeto2);
                            unset($objeto2);
                        }
                    }
                }else
                // Verifica se ta liberado e faz os calculos necessarios
                if($tabelalinkada['formtipo']=='BoleanoMultiplo'){
                    // Pega os posts
                    $get = 'tablink_'.$tabelalinkada['Tabela'];
                    if(isset($_POST[$get]) && is_array($_POST[$get])){
                        $get = array_unique(\anti_injection($_POST[$get]));
                    }
                    if(isset($get) && is_array($get)){
                        $ovalor = $tabelalinkada['BoleanoMultiplo']['Valor'];
                        // Busca AS caracteristicas da tabela mandando a sigla como parametro
                        $nome_da_tab        = \Framework\App\Conexao::Tabelas_GetSiglas_Recolher($tabelalinkada['Tabela']);
                        $nome_da_tab        = $nome_da_tab['classe'];
                            
                        // Pega as tabelas linkadas reversa para poder achar a outra tabela de ligacao
                        $links_reverso = \Framework\App\Conexao::Tabelas_GetLinks_Recolher($tabelalinkada['Tabela'],true);
                        unset($links_reverso[$sigla]);
                        // Seleciona e Atualiza
                        $where = Array($links[$tabelalinkada['Tabela']] => $identificador);
                        $respostas  = $this->_Modelo->db->Sql_Select($nome_da_tab, $where);
                        //var_dump($respostas);
                        if($respostas!==false){
                            if(!is_array($respostas)) $respostas = Array($respostas);
                            // Caso nao tenha campo de controle deleta os que nao 
                            // forem selecionados
                            if($ovalor===false){
                                $this->_Modelo->db->Sql_Delete($respostas,true);
                            }
                            // Caso tenha valor a ser alterado
                            else{
                                foreach($respostas AS &$valor2){
                                    $valor2->$ovalor = '0';
                                }
                                $this->_Modelo->db->Sql_Update($respostas,false);
                            }
                        }
                        // Pega campo da 3 tabela linkada
                        foreach($links_reverso as $indice=>&$valor3){
                            if(is_array($valor3)){
                                $camponovo = $indice;
                            }else{
                                $camponovo = $valor3;
                            }
                        }
                        // Agora registra o que importa
                        //var_dump($get,$camponovo);
                        if(!empty($get) && $camponovo!==false){
                            foreach($get as &$valor2){
                                // Caso nao exista pula
                                if($valor2=='' || $valor===NULL) continue;
                                // Confere o Resto
                                if($ovalor===false){
                                    $objeto2 = new $nome_da_tab;
                                    $objeto2->$links[$tabelalinkada['Tabela']]  = $identificador;
                                    $objeto2->$camponovo                        = $valor2;
                                    $sucesso = $this->_Modelo->db->Sql_Inserir($objeto2);
                                }else{
                                    $where = Array(
                                        $links[$tabelalinkada['Tabela']]    => $identificador,
                                        $camponovo                          => $valor2,
                                    );
                                    $respostas2  = $this->_Modelo->db->Sql_Select($nome_da_tab, $where,1);
                                    if($respostas2===false){
                                        $objeto2 = new $nome_da_tab;
                                        $objeto2->$links[$tabelalinkada['Tabela']]  = $identificador;
                                        $objeto2->$camponovo                        = $valor2;
                                        $objeto2->$ovalor                           = '1';
                                        $sucesso = $this->_Modelo->db->Sql_Inserir($objeto2);
                                    }else{
                                        $respostas2->$ovalor                        = '1';
                                        $sucesso = $this->_Modelo->db->Sql_Update($respostas2,false);
                                    }
                                }
                                unset($objeto2);
                                unset($respostas2);
                            }
                        }
                    }
                }
            }
        }
        }
        // Termina de Tratar as LINKADAS
        if($erro1=='') $erro1 = $language['mens_erro']['erro'];
        if($erro2=='') $erro2 = $language['mens_erro']['erro'];
        
        // Mostra Mensagem de Sucesso
        if($sucesso===true){
            $mensagens = array(
                "tipo"              => 'sucesso',
                "mgs_principal"     => $sucesso1,
                "mgs_secundaria"    => $sucesso2
            ); 
            $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
            $this->_Visual->Json_Info_Update('Historico', false);  
        }else{
            $mensagens = array(
                "tipo"              => 'erro',
                "mgs_principal"     => $erro1,
                "mgs_secundaria"    => $erro2
            );
            $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
            $this->_Visual->Json_Info_Update('Historico', false);  
            $this->layoult_zerar = false;
            return false;
        }
        
        
        
        
        
        // Carrega Pagina, Caso seja formselect atualiza o select do formulario anterior
        if(isset($_GET['formselect']) && $_GET['formselect']!='' && LAYOULT_IMPRIMIR=='AJAX'){
            // Variavel Nula
            $js_Extra = '';
            // Captura
            $select = \anti_injection($_GET['formselect']);
            $condicao = \anti_injection($_GET['condicao']);
            // Trata pra Ver se Tem Chaves
            if(strpos($condicao, '{')!==false){
                $ext_campo = explode('|', $condicao);
                $ext_campo = $ext_campo[2];
                if(strpos($ext_campo, '.')!==false){
                    $ext_campo = explode('.', $ext_campo);
                    $ext_campo = $ext_campo[1];
                }
                $ext_campo = explode('=', $ext_campo);
                $ext_campo = $ext_campo[0];
                if(isset($_GET[$ext_campo])){
                    $mudar = \anti_injection($_GET[$ext_campo]);
                    $condicao = preg_replace('/{(.+)}/U', $mudar, $condicao);
                }else if(isset($_POST[$ext_campo])){
                    $mudar = \anti_injection($_POST[$ext_campo]);
                    $condicao = preg_replace('/{(.+)}/U', $mudar, $condicao);
                }else{
                    $mudar = '0';
                    $condicao = preg_replace('/{(.+)}/U', $mudar, $condicao);
                }
                $js_Extra = '$("#'.$ext_campo.' option").attr("selected", false);'.
                '$("#'.$ext_campo.' option[value=\''.$mudar.'\']").attr("selected", true);';
            }
                    
            $opcoes = $this->_Modelo->db->Tabelas_CapturaExtrangeiras($condicao);  
            if(is_object($opcoes)) $opcoes = Array(0=>$opcoes);
            //Guarda Resultados
            $html = '';
            if($opcoes!==false && !empty($opcoes)){
                reset($opcoes);
                foreach ($opcoes as $indice=>&$valor) {
                    if($identificador==$indice){
                        $selecionado=1;
                    }
                    else{
                        $selecionado=0;
                    }
                    $html .= \Framework\Classes\Form::Select_Opcao_Stat($valor,$indice,$selecionado);
                }
            }
            // Json
            $conteudo = array(
                'location'  =>  '#'.$select,
                'js'        =>  '$("#'.$select.'").trigger("liszt:updated");'.
                                'if(typeof $("#'.$select.'").attr("onchange") !== "undefined"){'.
                                    'var onchange = $("#'.$select.'").attr("onchange");'.
                                    'var valor = $("#'.$select.'").val();'.
                                    'onchange = onchange.replace(\'this.value\',\'valor\'); '.
                                    'eval(onchange);'.
                                '}'.
                                $js_Extra,
                'html'      =>  $html
            );
            $this->_Visual->Json_IncluiTipo('Conteudo',$conteudo);
        }else{
            // Recarrega Main
            if($funcao!='' && $funcao!==false){
                eval($funcao);
            }
            // Json
            $this->_Visual->Json_Info_Update('Titulo', $titulo);
        }
        return true;
    }

    
    /**
     * Usado Pelo Select MUltiplo, adiciona _id no final pra poder funcionar o input id
     * 
     * @param type $objeto
     * @param type $id
     * @return boolean
     */
    static function DAO_Campos_TrocaID(&$objeto,$id=false){
        // Ainda funciona com array
        if(is_array($objeto)){
            foreach ($objeto as &$valor){
                if(isset($valor['mysql_titulo'])){
                    $valor['mysql_titulo'] = $valor['mysql_titulo'].'_'.$id;
                }
            }
        }// Agora tbm funciona com objetos
        else{
            return false;
        }
        return true;
    }
    /**
     * Usado Pelo Select MUltiplo, como e de mts pra mts, troca {nome} por um nome
     * @param type $objeto
     * @param type $nome
     * @return boolean
     */
    static function DAO_Campos_TrocaNOME(&$objeto,$alterar=false){
        // Ainda funciona com array
        if(is_array($objeto)){
            foreach ($objeto as &$valor){
                if(isset($valor['edicao']['Nome'])){
                     $valor['edicao']['Nome'] = str_replace('{nome}', $alterar, $valor['edicao']['Nome']);
                }
            }
        }// Agora tbm funciona com objetos
        else{
            return false;
        }
        return true;
    }
    /**
     * Usado Quando tem um select que esconde outros campos, deleta os ocultos
     * @param type $objeto
     * @param type $campomysql
     * @return boolean
     */
    static function DAO_Campos_RetiraAlternados(&$objeto,$campomysql=false){
        // Ainda funciona com array
        if(is_array($objeto)){
            foreach ($objeto as &$valor){
                // Para continuar rodando a versao 1.0 do Sistema
                if(isset($valor['edicao']['form_escondido'])){
                    if($valor['mysql_titulo']==$campomysql || $campomysql===false){
                        $valor['edicao']['form_escondido'] = false;
                    }
                }
            }
        }// Agora tbm funciona com objetos
        else{
            return false;
        }
        return true;
    }
    /**
     * Usado Quando tem um select que esconde outros campos, quando esta selecionado,
     * os que tem o campo oculto, tem que trocar, pra isso serve essa funcao
     * 
     * @param type $objeto
     * @param type $campomysql
     * @return boolean
     */
    static function DAO_Campos_TrocaAlternados(&$objeto,$campomysql=false){
        // Ainda funciona com array
        if(is_array($objeto)){
            foreach ($objeto as &$valor){
                // Para continuar rodando a versao 1.0 do Sistema
                if(isset($valor['edicao']['form_escondido'])){
                    if($campomysql===false || $valor['mysql_titulo']==$campomysql){
                        if($valor['edicao']['form_escondido']                                   ===true){
                            $valor['edicao']['form_escondido']                              = 'apagar'; // Pode Apagar
                        }else if($valor['edicao']['form_escondido']                             =='apagar'){
                            $valor['edicao']['form_escondido']                              = true; // Verdade, esta Apagado
                        }
                    }
                }else if(isset($valor['TabelaLinkada']['SelectMultiplo']['form_escondido'])){
                    if($campomysql===false || $valor['TabelaLinkada']['Nome']==$campomysql){
                        if($valor['TabelaLinkada']['SelectMultiplo']['form_escondido']          ===true){
                            $valor['TabelaLinkada']['SelectMultiplo']['form_escondido']     = 'apagar'; // Pode Apagar
                        }else if($valor['TabelaLinkada']['SelectMultiplo']['form_escondido']    =='apagar'){
                            $valor['TabelaLinkada']['SelectMultiplo']['form_escondido']     = true; // Verdade, esta Apagado
                        }
                    }
                }else if(isset($valor['TabelaLinkada']['BoleanoMultiplo']['form_escondido'])){  
                    if($campomysql===false || $valor['TabelaLinkada']['Nome']==$campomysql){
                        if($valor['TabelaLinkada']['BoleanoMultiplo']['form_escondido']         ===true){
                            $valor['TabelaLinkada']['BoleanoMultiplo']['form_escondido']    = 'apagar'; // Pode Apagar
                        }else if($valor['TabelaLinkada']['BoleanoMultiplo']['form_escondido']   =='apagar'){
                            $valor['TabelaLinkada']['BoleanoMultiplo']['form_escondido']    = true; // Verdade, esta Apagado
                        }
                    }
                }
            }
        }// Agora tbm funciona com objetos
        else{
            return false;
        }
        return true;
    }
    static function DAO_Campos_AlternadosDesabilitados(&$objeto,$campomysql=false){
        // Ainda funciona com array
        if(is_array($objeto)){
            foreach ($objeto as &$valor){
                // Para continuar rodando a versao 1.0 do Sistema
                if(isset($valor['edicao']['form_escondido'])){
                    if($campomysql===false || $valor['mysql_titulo']==$campomysql){
                        $valor['edicao']['form_escondido']                              = true; // Verdade, esta Apagado
                    }
                }else if(isset($valor['TabelaLinkada']['SelectMultiplo']['form_escondido'])){
                    if($campomysql===false || $valor['TabelaLinkada']['Nome']==$campomysql){
                        $valor['TabelaLinkada']['SelectMultiplo']['form_escondido']     = true; // Verdade, esta Apagado
                    }
                }else if(isset($valor['TabelaLinkada']['BoleanoMultiplo']['form_escondido'])){  
                    if($campomysql===false || $valor['TabelaLinkada']['Nome']==$campomysql){
                        $valor['TabelaLinkada']['BoleanoMultiplo']['form_escondido']    = true; // Verdade, esta Apagado
                    }
                }
            }
        }// Agora tbm funciona com objetos
        else{
            return false;
        }
        return true;
    }
    /**
     * Troca de Permitido leitura pra nao permitido
     * 
     * @param type $objeto
     * @param type $campomysql
     * @param type $leitura
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0.2 (Agora funciona com Objetos DAO)
     * 
     * #update OBJETOS AINDA NAO FUNCIONAM
     */
    static function mysql_MudaLeitura(&$objeto,$campomysql,$leitura = true){
        // Ainda funciona com array
        if(is_array($objeto)){
            foreach ($objeto as &$valor){
                /*// Para continuar rodando a versao 1.0 do Sistema
                if(isset($valor['mysql'])){
                    if($valor['mysql']==$campomysql){
                        $valor['readonly'] = $leitura;
                    }
                }
                // A partir da 2.0 trata assim
                else */if(isset($valor['edicao'])){
                    if(is_array($campomysql)){
                        if(in_array($valor['mysql_titulo'],$campomysql)){
                            $valor['edicao']['readonly'] = $leitura;
                        }
                    }else{
                        if($valor['mysql_titulo']==$campomysql){
                            $valor['edicao']['readonly'] = $leitura;
                        }
                    }
                }
            }
        }// Agora tbm funciona com objetos
        else{
            return false;
        }
        return true;
    }
    /**
     * Remove o add que vem junto ao formulario
     * @param type $objeto
     * @param type $campomysql
     * @return boolean
     */
    static function DAO_RemoveLinkExtra(&$objeto,$campomysql){
        // Ainda funciona com array
        if(is_array($objeto)){
            foreach ($objeto as &$valor){
                if(isset($valor['mysql_titulo'])){
                    if(is_array($campomysql)){
                        if(in_array($valor['mysql_titulo'],$campomysql)){
                            $valor['linkextra'] = '';
                        }
                    }else{
                        if($valor['mysql_titulo']==$campomysql){
                            $valor['linkextra'] = '';
                        }
                    }
                }
            }
        }// Agora tbm funciona com objetos
        else{
            return false;
        }
        return true;
    }
    /**
     * Usado pelas tabelas extrangeiras, altera o valor {campo} usado, quando se tem
     * mts varios niveis de select tipo Pais, Estado, Cidade
     * 
     * @param type $objeto
     * @param type $campomysql
     * @param type $alterar
     * @return boolean
     */
    static function DAO_Ext_Alterar(&$objeto,$campomysql,$alterar){
        // Ainda funciona com array
        if(is_array($objeto)){
            foreach ($objeto as &$valor){
                if(isset($valor['mysql_estrangeira']) && $valor['mysql_titulo']==$campomysql){
                    $valor['mysql_estrangeira'] = preg_replace('/{(.+)}/U', $alterar, $valor['mysql_estrangeira']);
                }
            }
        }// Agora tbm funciona com objetos
        else{
            return false;
        }
        return true;
    }
    static function DAO_Ext_ADD(&$objeto,$campomysql,$add){
        // Ainda funciona com array
        if(is_array($objeto)){
            foreach ($objeto as &$valor){
                if(isset($valor['mysql_estrangeira']) && $valor['mysql_titulo']==$campomysql){
                    $valor['mysql_estrangeira'] = $valor['mysql_estrangeira'].'|'.$add;
                }
            }
        }// Agora tbm funciona com objetos
        else{
            return false;
        }
        return true;
    }
    /**
     * Atualiza o valor do campo para o valor_padrao
     * 
     * @param type $campos
     * @param type $campomysql
     * @param type $valor
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0.3 (Agora funciona com Objetos DAO, -1bug)
     */
    static function mysql_AtualizaValor(&$objeto,$campomysql,$resultado=false){
        // Ainda funciona com array
        if(is_array($objeto)){
            foreach ($objeto as &$valor){
                if(isset($valor['edicao'])){
                    if($valor['mysql_titulo']==$campomysql){
                        if($resultado!==false){
                            $valor['edicao']['valor_padrao'] = $resultado;
                        }else{
                            $valor['edicao']['valor_padrao'] = \anti_injection($_POST[$valor['mysql_titulo']]);
                        }
                    }
                }
            }
        }// Agora tbm funciona com objetos
        else{
            $campos = $objeto->Get_Object_Vars_Public();
            foreach ($campos as $indice => &$value){
                if($indice==$campomysql){
                    if($resultado!==false){
                        $objeto->$indice = $resultado;
                    }else if(isset($_POST[$indice])){
                        $objeto->$indice = \anti_injection($_POST[$indice]);
                    }
                }
            }
        }
    }
    /**
     * Atualiza o valor do campo para o valor_padrao
     * 
     * @param type $campos
     * @param type $valores
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0.2 (Agora funciona com Objetos DAO)
     */
    static function mysql_AtualizaValores(&$objeto,&$valores='',$id=false){
        // TRATA ID
        if(is_int($id)){
            if($id<=0) $id = false;
        }else if(is_string($id)){
            if($id=='') $id = false;
        }else{
            $id = false;
        }
        
        
        // TRATA VALORES
        if(is_object($valores)){
            $valor_tipo = 2;
        }else if(is_array($valores)){
            $valor_tipo = 1;
        }else{
            $valor_tipo = 0;
        }
        // Array, Formularios e Afins
        if(is_array($objeto)){
            foreach ($objeto as &$valor){
                
                // TABELA LINKADA
                if(isset($valor["TabelaLinkada"]) && $id!==false){
                    $valor['TabelaLinkada']['valor_padrao'] = $id;
                }else
                // EDICAO PADRAO 
                if(isset($valor['edicao'])){
                    // Valores são Objetos
                    if($valor_tipo===2){
                        
                        // Trata Campos que Mudam o Formulario
                        if(isset($valor['edicao']['change']) && strpos($valor['edicao']['change'], 'Control_Layoult_Form_Campos_Trocar')!==false){
                            if($valores->$valor['mysql_titulo']=== NULL || $valores->$valor['mysql_titulo']==='' || $valores->$valor['mysql_titulo']===false){
                                $valores->$valor['mysql_titulo'] = $valor['edicao']['valor_padrao'];
                            }
                            if($valor['edicao']['valor_padrao']===false){
                                self::DAO_Campos_AlternadosDesabilitados($objeto);
                            }else
                            if((string) $valor['edicao']['valor_padrao']!== (string) $valores->$valor['mysql_titulo']){
                                self::DAO_Campos_TrocaAlternados($objeto);
                            }
                        }
                        
                        // Atualiza Valor
                        $valor['edicao']['valor_padrao'] = $valores->$valor['mysql_titulo'];
                    }else
                    // Valores são Arrays
                    if($valor_tipo===1){
                        
                        // Trata Campos que Mudam o Formulario
                        if(isset($valor['edicao']['change']) && strpos($valor['edicao']['change'], 'Control_Layoult_Form_Campos_Trocar')!==false){
                            if($valores[$valor['mysql_titulo']]=== NULL || $valores[$valor['mysql_titulo']]==='' || $valores[$valor['mysql_titulo']]===false){
                                $valores[$valor['mysql_titulo']] = $valor['edicao']['valor_padrao'];
                            }
                            if($valor['edicao']['valor_padrao']===false){
                                self::DAO_Campos_AlternadosDesabilitados($objeto);
                            }else
                            if((string) $valor['edicao']['valor_padrao']!== (string) $valores[$valor['mysql_titulo']]){
                                self::DAO_Campos_TrocaAlternados($objeto);
                            }
                        }
                        
                        // Atualiza Valor
                        $valor['edicao']['valor_padrao'] = $valores[$valor['mysql_titulo']]; 
                    }else
                    // Caso Contrario Pega do POST
                    {
                        
                        // Atualiza Valor
                        $valor['edicao']['valor_padrao'] = \anti_injection($_POST[$valor['mysql_titulo']]);
                    }
                }else
                // Para funcionar com modulos da versao 1.0
                if(isset($valor['valor_padrao'])){
                    // Valores são Objetos
                    if($valor_tipo===2){
                        
                        // Atualiza Valor
                        $valor['valor_padrao'] = $valores->$valor['mysql'];
                    }else
                    // Valores são Arrays
                    if($valor_tipo===1){
                        
                        // Atualiza Valor
                        $valor['valor_padrao'] = $valores[$valor['mysql']];

                    }else
                    // Caso Contrario Pega do POST
                    {
                        
                        // Atualiza Valor
                        $valor['valor_padrao'] = \anti_injection($_POST[$valor['mysql']]);
                    }
                }
            }
        }
        else 
        // Agora tbm funciona com objetos
        if(is_object($objeto)){
            $campos = $objeto->Get_Object_Vars_Public();
            $primarias = $objeto->Get_Primaria();
            foreach ($campos as $indice => $value){
                if(!is_array($primarias)){
                    throw new \Exception('Primárias não é um Array: '.$primarias,3250);
                }
                // Verifica se Existe
                $is_primary = array_search($indice, $primarias);
                // SE for chave primaria bloqueia
                if($is_primary!==false && $valor_tipo===0 && isset($valores->$indice)){
                    throw new \Exception('Foi tentado alterar um campo primário: '.$indice,6010);
                }else if($objeto->$indice===NULL || $objeto->$indice===false || $is_primary===false){
                    if($valor_tipo===2){

                        // Atualiza Valor
                        if(isset($valores->$indice)){
                            $objeto->$indice = $valores->$indice;
                        }else{
                            $objeto->$indice = NULL;
                        }
                    }else if($valor_tipo===1){

                        // Atualiza Valor
                        if(isset($valores[$indice])){
                            $objeto->$indice = $valores[$indice];
                        }else{
                            $objeto->$indice = NULL;
                        }
                    }else{
                        if(isset($_POST['upload_'.$indice]) && $_POST['upload_'.$indice]!=''){

                            // Atualiza Valor
                            $objeto->$indice = \anti_injection($_POST['upload_'.$indice]);
                        }else if(isset($_POST[$indice])){

                            // Atualiza Valor
                            //if(isset($_POST[$indice])){
                                $objeto->$indice = \anti_injection($_POST[$indice]);
                            /*}else{
                                $objeto->Atributo_Del($indice);
                            }*/
                        }else{
                            $objeto->Atributo_Del($indice);
                        }
                    }
                }
            }
        }
        //var_dump($objeto->Get_Object_Vars_Public(),$objeto,$_POST);
        return true;
    }
    /**
     * 
     * @param type $campos
     * @param type $campomysql
     * @param type $exceto
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0.0
     */
    static function DAO_Campos_Retira(&$campos,$campomysql,$exceto=0){
        if(empty($campos)) throw new \Exception('Campos da DAO não existe', 3030); //
        if(is_array($campos)){
            foreach ($campos as $indice=>&$valor){
                if(((isset($valor['TabelaLinkada']) && $valor['TabelaLinkada']['Nome']==$campomysql) || (isset($valor['mysql_titulo']) && $valor['mysql_titulo']==$campomysql)) && $exceto==0){
                    unset($campos[$indice]);
                }else if(  isset($valor['TabelaLinkada']) && $valor['TabelaLinkada']['Nome']!=$campomysql && $exceto==1){
                    unset($campos[$indice]);
                }else if(  isset($valor['mysql_titulo']) && $valor['mysql_titulo']!=$campomysql && $exceto==1){
                    unset($campos[$indice]);
                }
            }
        }else{
            foreach ($campos as $indice=>&$valor){
                if(isset($valor['mysql_titulo']) && trim($valor['mysql_titulo'])==trim($campomysql) && $exceto==0){
                    unset($campos[$indice]);
                }else if(isset($valor['mysql_titulo']) && $valor['mysql_titulo']!=$campomysql && $exceto==1){
                    unset($campos[$indice]);
                }
            }
        }
    }
    /**
     * 
     * @param type $nome
     * @param type $chave
     * @param type $modulo
     * @param type $submodulo
     * 
     * #update
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.0.1
     */
    /*protected function _Permissao_Verificar($chave){
        $array = $this->_Acl->getPermissao();
        // #update, nao ta limitando paginas
        return;
        if(!isset($array[$chave]) || $array[$chave]['valor']!==true){
            self::Tema_Travar();
            \Framework\App\Sistema_Funcoes::Erro('5050');
        }
    }*/
    protected function _Permissao_Verificar_Modulo($modulo,$sub = ''){
        $array = $this->_Acl->getPermissao();
        $var = false;
        if(!empty($array)){
            foreach($array as &$valor){
                if(trim($modulo)==trim($valor['mod'])){
                    if(trim($sub)==trim($valor['sub'])){
                        if($valor['valor']===false){ $var = false;  }
                        if($valor['valor']===true){  $var = true;  }
                    }else{
                        if($valor['valor']===false){ $var = false;  }
                        if($valor['valor']===true){  $var = true;  }
                    }
                    //else                      { return false; }
                }
            }
        }
        if($var===true) return true;
        else            return false;
    }
    /**
     * Destruidor, quando a requisicao for toda carregada o chamara antes de encerrar e entregar o c�digo html pro cliente.
     * Toda vez que o controle for destruido, criara o seu json correspondente
     * 
     * @name __destruct
     * @access public
     * 
     * @return void
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.2
     * Retirada Permissao do menu e feito gambiarra pra Newslettler
    */
    public function __destruct() {
        $imprimir = new \Framework\App\Tempo('Destruicao Controle');
        if(self::Tema_Travar_GET()===false){
            // Pega Endereço
            $endereco_html = '';
            foreach($this->layoult_endereco as &$valor){
                if($valor[1]!==false){
                    $endereco_html .= '<li>'.
                    '<a class="lajax" href="'.URL_PATH.$valor[1].'" acao="">'.$valor[0].'</a>'.
                    ''.
                    '</li>';
                }else{
                    $endereco_html .= '<li class="active">'.
                    $valor[0].
                    '</li>';
                }

            }
            // Caso Configurado Colocar Busca
            if(TEMA_BUSCAR===true && isset(self::$config_template['Buscar'])){
                $endereco_html .= self::$config_template['Buscar'];
            }
            // cria form se nao tiver logado
            if(TEMA_LOGIN===false && $this->_Acl->logado===false && $this->_request->getSubModulo()!=='erro' && $this->_request->getSubModulo()!=='Recurso' && $this->_request->getSubModulo()!=='localidades'){
                $form = new \Framework\Classes\Form('Formlogin','',''); //formajax /'.SISTEMA_MODULO.'/'.SISTEMA_SUB.'/'.SISTEMA_MET
                $form->Input_Novo('Login','sistema_login','','text', '',30, '');
                $form->Input_Novo('Senha','sistema_senha','','password', 30, '','');
                $this->_Visual->Blocar($form->retorna_form('Entrar'));
                $this->_Visual->Bloco_Menor_CriaJanela('Login');
            }
            /*// carrega menu estatisticas se exister antes de encerrar tudo
            if(file_exists(MOD_PATH.''.\anti_injection(SISTEMA_MODULO).'/StatC.php')){
                $this->_Visual->menu['SubMenu']['link'][] = URL_PATH.''.\anti_injection(SISTEMA_MODULO).'/Stat/Modulo';
                $this->_Visual->menu['SubMenu']['nome'][] = 'Estatisticas';
                if(SISTEMA_SUB=='Stat' && SISTEMA_MET=='Modulo') $this->_Visual->menu['SubMenu']['ativo'][] = 1;
                else $this->_Visual->menu['SubMenu']['ativo'][] = 0;
            }*/
            if($this->_Visual->Json_Exist()===true || LAYOULT_IMPRIMIR=='AJAX'){
                if($this->layoult_zerar != 'naousado' && is_bool($this->layoult_zerar)){
                    $zerar = $this->layoult_zerar;
                }else{
                    if($this->_Visual->Json_ExisteTipo('Popup') || $this->_Visual->Json_ExisteTipo('Conteudo')){
                        $zerar = false;
                    }else{
                        $zerar = true;
                    }
                }
                // ORGANIZA E MANDA CONTEUDO
                if(LAYOULT_IMPRIMIR=='AJAX'){
                    // Assimila Widget Endereço
                    if($this->layoult_endereco_alterado===true && !(defined('LAYOULT_POPUP') && LAYOULT_POPUP===false)){
                        $conteudo = array(
                            'location' => '.breadcrumb',
                            'js' => '',
                            'html' =>  $endereco_html
                        );
                        $this->_Visual->Json_IncluiTipo('Conteudo',$conteudo);
                    }    
                    echo $this->_Visual->Json_Retorna($zerar);
                    return true;
                }
            }else{
                // Carrega Layoult
                $this->_Visual->Layolt_Tipo(2);
            }
            
            // Assimila Widget Endereço
            $this->_Visual->Widget_Assimilar('Navegacao_Endereco',$endereco_html);
            // ordena na ordem correta
            $menu = $this->_Cache->Ler('Menu');
            if (!$menu) {
                $menu = $this->_Modelo->Sistema_Menu();
                $this->_Cache->Salvar('Menu', $menu);
            }
            
            if(is_array($menu)){
                foreach($menu as $indice=>&$valor){
                    if($valor===false) continue;
                    
                    // CAso seja interno e  sem permissao, deleta;
                    if($valor['ext']===false && $this->_Registro->_Acl->Get_Permissao_Url($valor['link'])!==true){
                        unset($menu[$indice]);
                        continue;
                    }
                    
                    // Permissao dos Filhos
                    if(is_array($valor['filhos'])){
                        foreach($valor['filhos'] as $indice_filho=>&$filho){
                            if($this->_Registro->_Acl->Get_Permissao_Url($filho['link'])!==true){
                                unset($menu[$indice]['filhos'][$indice_filho]);
                                continue;
                            }
                        }
                    }
                    // Caso seja vazio vira false para nao aparecer
                    if(empty($menu[$indice]['filhos'])) $menu[$indice]['filhos'] = false;
                    
                    //Cria Para o Visual
                    $link = str_replace(Array(URL_PATH), Array(''), $valor['link']);
                    if($link!='#'){
                        $modulo = explode('/', $link);
                        //if(count($modulo)<3 || /*$this->_Acl->logado_usuario->grupo==CFG_TEC_IDADMIN || */$this->_Acl->logado_usuario->grupo==CFG_TEC_IDADMINDEUS || $this->_Permissao_Verificar_Modulo($modulo[0],$modulo[1])===true || $modulo[2]=='Home'){
                        if(isset($this->_Acl->logado_usuario->grupo) && (($this->_Acl->logado_usuario->grupo!=CFG_TEC_IDADMINDEUS && $modulo[2]!='Newsletter') || ($this->_Acl->logado_usuario->grupo!=CFG_TEC_IDNEWSLETTER &&  $modulo[2]!='Newsletter'))){

                            $this->_Visual->menu['link'][]  = $valor['link'];
                            $this->_Visual->menu['ext'][]   = $valor['ext'];
                            $this->_Visual->menu['nome'][]  = $valor['nome'];
                            $this->_Visual->menu['img'][]   = $valor['img'];
                            $this->_Visual->menu['ativo'][] = $valor['ativo'];
                            $this->_Visual->menu['icon'][]  = $valor['icon'];
                            $this->_Visual->menu['filhos'][]= $valor['filhos'];
                        }else if($modulo[0]=='_Sistema' && $modulo[1]=='Principal' && $modulo[2]=='Home'){
                            $this->_Visual->menu['link'][]  = $valor['link'];
                            $this->_Visual->menu['ext'][]   = $valor['ext'];
                            $this->_Visual->menu['nome'][]  = $valor['nome'];
                            $this->_Visual->menu['img'][]   = $valor['img'];
                            $this->_Visual->menu['ativo'][] = $valor['ativo'];
                            $this->_Visual->menu['icon'][]  = $valor['icon'];
                            $this->_Visual->menu['filhos'][]= false;
                        }
                    }else if($valor['filhos']!==false){
                        $this->_Visual->menu['link'][]  = "#";
                        $this->_Visual->menu['ext'][]   = $valor['ext'];
                        $this->_Visual->menu['nome'][]  = $valor['nome'];
                        $this->_Visual->menu['img'][]   = $valor['img'];
                        $this->_Visual->menu['ativo'][] = $valor['ativo'];
                        $this->_Visual->menu['icon'][] = $valor['icon'];
                        $this->_Visual->menu['filhos'][]= $valor['filhos'];
                    }
                }
            }
            unset($menu);
            $this->_Visual->renderizar();
            return true;
        }
    }
    public function Widget_Add($tipo,$valor){
        $this->_Visual->Widgets_Assimilar($tipo,$valor);
    }
    private function Chamar_Widget(){
        foreach($this->ModulosHome as $value){
            if(is_callable(array($value.'_Principal','Widget'))){
                eval($value.'_Principal::Widget($this);');
            }
        }
    }     
    //abstract public function Main();
}
?>
