<?php
namespace Framework\App;
/**
 * Funções Exenciais para o Sistema
 * 
 * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
 * @version 0.4.2
 */
Class Sistema_Funcoes {
    /**
     * Redireciona a Pagina
     * 
     * @name redirect
     * @access public
     * @return void
     * 
     * @author Ricardo Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public static function Redirect($url)
    {
        // acrescenta url 
        if( strpos($url, URL_PATH)!==false && strpos($url, 'www.')===false && strpos($url, 'http://')===false){
            $url = URL_PATH.$url;
        }
        
        // Ou redireciona via php ou html
        if(LAYOULT_IMPRIMIR==='AJAX'){
            $Registro = Registro::getInstacia();
            $params = Array('Url'=>$url,'Tempo'=>10);
            if($Registro->_Visual===false){
                $Registro->_Visual = new \Framework\App\Visual();
            }
            $Registro->_Visual->Json_IncluiTipo('Redirect',$params);
            if(\Framework\App\Controle::$ligado===false){
                $Registro->_Visual->renderizar();
                \Framework\App\Controle::Tema_Travar();
            }
            return true;
        }else{
            header('Location: ' . $url);
        }
        exit;
    }
    /**
     * Trata Extensoes de Arquvo para Corrigir Extensoes
     * 
     * @param type $ext Extensao
     * 
     * @return string Extensao com Apenas 3 caracteres, retorna com 4, por exemplo jpeg
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public static function Control_Arq_Ext($ext){
        $ext = strtolower($ext);
        if($ext==='jpe'){
            $ext = 'jpeg';
        }
        if($ext==='mpe'){
            $ext = 'mpeg';
        }
        if($ext==='tif'){
            $ext = 'tiff';
        }
        return $ext;
    }
    /**
     * Recebe um NUmero e Devolve a Letra Associada
     * 
     * @param int $numero
     * @return string Uma Letra
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public static function Letra_Aleatoria($numero){
        $string = 'ABCDEFGHIJKLMNOPQUVYXWZ';
        $tam = strlen($string);
        
        if(!is_numeric($numero)){
            throw new \Exception('Parametro não Numerico'.$numero, 3030);
        }else{
            $numero = (int) $numero;
        }
        
        // Se for maior que as Ocorrencias, Retorna ao começo
        while($tam<=$numero) $numero = $numero%$tam;
        if($numero<0)$numero = 0;
        
        return $string[$numero];
    }
    /**
     * Decodifica Link Decode
     * 
     * @param type $texto
     * @param type $inverso
     * @return type
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public static function Letra_LinkDecode($texto,$inverso=false){
        $letras = Array(
            'À',
            'Á',
            'Â',
            'Ã',
            'Ç',
            'ˆ',
            'È',
            'É',
            'Ê',
            'Í',
            'Ï',
            'Ð',
            'Ñ',
            'Ò',
            'Ó',
            'Ô',
            'Õ',
            'Ö',
            '˜',
            'Ù',
            'Ú',
            'Û',
            'à',
            'á',
            'â',
            'ã',
            'ç',
            'è',
            'é',
            'ð',
            'ò',
            'ó',
            'ô',
            'õ',
        );
        $codigo = Array(
            '%C3%80',
            '%C3%81',
            '%C3%82',
            '%C3%83',
            '%C3%87',
            '%CB%86',
            '%CB%88',
            '%CB%89',
            '%C3%8A',
            '%C3%8D',
            '%C3%8F',
            '%C3%90',
            '%C3%91',
            '%C3%92',
            '%C3%93',
            '%C3%94',
            '%C3%95',
            '%C3%96',
            '%CB%9C',
            '%C3%99',
            '%C3%9A',
            '%C3%9B',
            '%C3%A0',
            '%C3%A1',
            '%C3%A2',
            '%C3%A3',
            '%C3%A7',
            '%C3%A8',
            '%C3%A9',
            '%C3%B0',
            '%C3%B2',
            '%C3%B3',
            '%C3%B4',
            '%C3%B5',
        );
        if($inverso===false){
            $a = &$codigo;
            $b = &$letras;
        }else{
            $a = &$letras;
            $b = &$codigo;
        }
        $texto = str_replace($a, $b, $texto);
        return $texto;
    }
    /**
     * Redireciona para um Pagina de Erro
     * 
     * @param type $codigo
     * 
     * @version 0.4.2
     * @author Ricardo Sierra <web@ricardosierra.com.br>
     */
    public static function Erro($codigo)
    {
        /*if(LAYOULT_IMPRIMIR=='COMPLETO'){
            $url = URL_PATH.'_Sistema'.US.'erro'.US.'Main'.US.$codigo.US;
        }else{
            $url = URL_PATH.'ajax'.US.'_Sistema'.US.'erro'.US.'Main'.US.$codigo.US;
        }*/
        
        $url = URL_PATH.'_Sistema'.US.'erro'.US.'Main'.US.$codigo.US;
        \Framework\App\Sistema_Funcoes::Redirect($url);
    }
    /**
     * Transforma Traço em Barra e vice versa em endereço de Diretorios
     * 
     * @param type $dir
     * 
     * 
     * @version 0.4.2
     * @author Ricardo Sierra <web@ricardosierra.com.br>
     */
    public static function DirReplace($dir = false){
        if($dir){
            if(strpos($dir, '-')){
                $dir = str_replace(Array('-'), Array('/'), $dir);
            }else{
                $dir = str_replace(Array('/'), Array('-'), $dir);
            }
            return $dir;
        }
        return false;
    }
    /**
     * Faz uma Limpeza em uma URL
     * 
     * @param type $url
     * @return type
     * 
     * @version 0.4.2
     * @author Ricardo Sierra <web@ricardosierra.com.br>
     */
    public static function Url_Limpeza($url){
        $url = str_replace(Array('http://','https://'), Array('',''), $url);
        $url = str_replace(Array('www.','www2.'), Array('',''), $url);
        return $url;
    }
    /**
     * Verifica se uma URL possui SSL
     * @param type $url
     * @return bollean (yes or no)
     */
    public static function Url_Secure($url){
        if(strpos($url,'https://')===0){
            return true;
        }else{
            return false;
        }
    }
    /**
     * Verifica a Versão do PHP
     * Returna TRUE para comporta a versao, e false para versao nao compativel
     * 
     * @param type $versao
     * @return boolean
     * 
     * @version 0.4.2
     * @author Ricardo Sierra <web@ricardosierra.com.br>
     */
    public static function VersionPHP($versao){
        if (strnatcmp(phpversion(),$versao) >= 0) return TRUE;
        else                                        return FALSE;
    }
    /**
     *  Transforma Objetos em Variaveis
     * 
     * @version 0.4.2
     * @author Ricardo Sierra <web@ricardosierra.com.br>
     */
    public static function Transf_Object_Array(&$objetos){
        if(is_object($objetos)){
            $valores = $objetos->Get_Object_Vars();
            $objetos2 = Array();
            foreach ($valores as $indice2 => &$valor2){
                $objetos2[$indice2] = $valor2;
            }
            return $objetos2;
        }else if(is_array($objetos)){
            $objetos2 = Array();
            foreach($objetos as $indice=>&$valor){
                if(!is_object($valor)) continue;
                $valores = $valor->Get_Object_Vars();
                $objetos2[$indice] = Array();
                foreach ($valores as $indice2 => &$valor2){
                    $objetos2[$indice][$indice2] = $valor2;
                }
            }
            return $objetos2;
        }
        return false;
    }
    /**
     * Verifica se um Modulo é permitido ou nao no sistema
     * @param type $modulo
     * @return boolean
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public static function Perm_Modulos($modulo,$submodulo=false){
        if($submodulo=='' || !isset($submodulo)) $submodulo = false;
        if(!file_exists(MOD_PATH.$modulo.DS.$modulo.'_Controle.php')){
            return false;
        }
        if($submodulo!==false && !file_exists(MOD_PATH.$modulo.DS.$modulo.'_'.$submodulo.'C.php')){
            return false;
        }
        // Verifica se Modulo é permitido
        if($modulo!='_Sistema' && function_exists('config_modulos') && !array_key_exists($modulo,config_modulos())){
            return false;
        }else{
            return true;
        }
    }
    /**
     * Criptografa Senha de Formularios
     * 
     * @param type $senha
     * @param type $protecao_extra
     * @param type $datetime
     * @return type
     * 
     * @version 0.4.2
     * @author Ricardo Sierra <web@ricardosierra.com.br>
     */
    public static function Form_Senha_Blindar($senha,$protecao_extra = false,$datetime = false){
        if($protecao_extra){
            if($datetime===false) $datetime = time();
            // Já que Existe um Super Banco de Dados na Internet, que processa
            // ŧodos os MD5 e SHA1, e arruma senha que funcionem através de 
            // engenharia reversa. Então Aqui a gente Dificulta e muito esse tipo
            // de ação. Teria que criar uma base usando o mesmo algoritmo que o
            // abaixo, além de precisar saber o algoritmo, e ter acesso as senhas
            // criptografadas. Um processo lento, custoso e complicado.
            $senha = '\?SiTec\?'.$datetime.'\?'.sha1(sha1('SierraTecnologia_'.date('dmY', $datetime).'_'.SRV_NAME_SQL.'_'.$datetime).sha1($senha)); // 51 Caracteres
        }else{
            $senha = md5($senha);
        }
        return $senha;
    }
    
    /********************************
     * FUNCOES PARA SEGURANCA
     */
    /**
     * Gera um Token em cima do IP, navegador e outros do Usuario pra ver se é ele mesmo !
     * @return type
     * 
     * @version 0.4.2
     * @author Ricardo Sierra <web@ricardosierra.com.br>
     */
    public static function Seguranca_Usuario_Validar(){
        // #update Precisa FAzer AINDA ESSA FUNCAO
        $time = time();
        $token = '123456';
        return $token;
    }
    /**
     * 
     * @param type $texto
     * @return type
     * 
     * @version 0.4.2
     * @author Ricardo Sierra <web@ricardosierra.com.br>
     */
    static public function Seguranca_Gerar_Hash($texto){
        return sha1('SierraTecnologia'.$texto);
    }
    /**
     * 
     * @return type
     * 
     * @version 0.4.2
     * @author Ricardo Sierra <web@ricardosierra.com.br>
     */
    static public function Seguranca_Gerar_Token(){
        return md5(uniqid(rand(), true));
    }
    
    /********************************
     * FUNCOES PARA PERFOMARCE
     */
    /**
     * 
     * @param type $html
     * @return type
     * 
     * @version 0.4.2
     * @author Ricardo Sierra <web@ricardosierra.com.br>
     */
    public static function HTML_min($html){
        $html          = explode('>',trim($html));
        $htmlnovo      = '';
        foreach($html as &$valor){
            $htmlnovo .= trim($valor).'>';
        }
        $html          = $htmlnovo;
        $html = str_replace(Array("\r","\n",'>>'), Array("","",'>'), $html);
        return $html;
    }
    
    /****
     * Validacoes
     */

    /**
     * Valida CEP
     * 
     * @param type $cep
     * @return boolean
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public static function Control_Layoult_Valida_Cep($cep){
        // verifica o resultado
        if(preg_match("/^[0-9]{5}-[0-9]{3}$/", trim($cep))==1){
            return true;
        }
        else
        {    
            return false;
        }
    }

    /**
     * Valida um Email
     * FUNCAO QUE VERIFICA SE UM EMAIL EH VALIDO, retorna 0 se nao for
     * 
     * @param type $email
     * @return int
     * 
     * @version 0.4.2
     * @author Ricardo Sierra <web@ricardosierra.com.br>
     */
    public static function Control_Layoult_Valida_Email($email){
        $mail_correcto = 0; 
        //verifico umas coisas
        if ((strlen($email) >= 6) && (substr_count($email,"@") == 1) && (substr($email,0,1) != "@") && (substr($email,strlen($email)-1,1) != "@") && (!strstr($email,"'")) && (!strstr($email,"\"")) && (!strstr($email,"\\")) && (!strstr($email,"\$")) && (!strstr($email," ")) && 
        //vejo se tem caracter .
        substr_count($email,".")>= 1){
            //obtenho a termina��o do dominio
            $term_dom = substr(strrchr ($email, '.'),1);
            $caracter_ult = \substr(substr($email,0,strlen($email) - strlen($term_dom) - 1),strlen(substr($email,0,strlen($email) - strlen($term_dom) - 1))-1,1);
            //verifico que a termina��o do dominio seja correcta
            if (\strlen($term_dom)>1 && \strlen($term_dom)<5 && (!\strstr($term_dom,"@")) && 
            //verifico que o de antes do dominio seja correcto
            $caracter_ult != "@" && $caracter_ult != "."){
                $mail_correcto = 1;
            }
        }
        if ($mail_correcto) {
            return 1;
        } else {
            return 0;
        }
    }
    /**
     * Transforma Bytes Valor em Texto
     * 
     * @param int $tamanho
     * @return string
     * 
     * @version 0.4.2
     * @author Ricardo Sierra <web@ricardosierra.com.br>
     */
    public static function Tranf_Byte_Otimizado($tamanho){
        $tamanho = (int) $tamanho;
        if($tamanho>=1099511627776){
            $tamanho    =   ((string) round($tamanho/1099511627776)).' TB';
        }else if($tamanho>=1073741824){
            $tamanho    =   ((string) round($tamanho/1073741824)).' GB';
        }else if($tamanho>=1048576){
            $tamanho    =   ((string) round($tamanho/1048576)).' MB';
        }else if($tamanho>=1024){
            $tamanho    =   ((string) round($tamanho/1024)).' KB';
        }else{
            $tamanho    =   ((string) round($tamanho)).' B';
        }
        return $tamanho;
        //return round($real,2);
    }
    /**
     * Transforma Bytes Texto em Valor
     * 
     * @param type $float
     * @return type
     * 
     * @version 0.4.2
     * @author Ricardo Sierra <web@ricardosierra.com.br>
     */
    public static function Tranf_Otimizado_Byte($float){
        $tamanho = (float) $float;
        if(strpos($float, 'TB')!==false){
            return $tamanho*1099511627776;
        }
        if(strpos($float, 'GB')!==false){
            return $tamanho*1073741824;
        }
        if(strpos($float, 'MB')!==false){
            return $tamanho*1048576;
        }
        if(strpos($float, 'KB')!==false){
            return $tamanho*1024;
        }
        return $tamanho;
    }
    /**
     * Transforma Segundos para Tempo
     * 
     * @param int $tamanho
     * @return string
     * 
     * @version 0.4.2
     * @author Ricardo Sierra <web@ricardosierra.com.br>
     */
    public static function Tranf_Segundo_Tempo($tamanho,$termina_em='minutos'){
        $tamanho = (int) $tamanho;
        $valor_final = '';
        $espaço = '';
        // Anos
        if($tamanho>=31556926){
            $valor_temp = (int) round($tamanho/31556926) ;
            $valor_final    .= (string) ($valor_temp === 1 ? $valor_temp.' ano' : $valor_temp.' anos');
            $tamanho -= $tamanho - ($tamanho%31556926);
            $espaço = ' ';
        }
        if ($termina_em === 'anos') {
            return ($valor_final === '' ? '0 anos' : $valor_final);
        }
        // Dias
        if($tamanho>=86400){
            $valor_temp = (int) round($tamanho/86400) ;
            $valor_final    .= (string) ($espaço.($valor_temp === 1 ? $valor_temp.' dia' : $valor_temp.' dias'));
            $tamanho -= $tamanho - ($tamanho%86400);
            $espaço = ' ';
        }
        if ($termina_em === 'dias') {
            return ($valor_final === '' ? '0 dias' : $valor_final);
        }
        // Horas
        if($tamanho>=3600){
            $valor_temp = (int) round($tamanho/3600) ;
            $valor_final    .= (string) ($espaço.($valor_temp === 1 ? $valor_temp.' hora' : $valor_temp.' horas'));
            $tamanho -= $tamanho - ($tamanho%3600);
            $espaço = ' ';
        }
        if ($termina_em === 'horas') {
            return ($valor_final === '' ? '0 horas' : $valor_final);
        }
        // Minutos
        if($tamanho>=60){
            $valor_temp = (int) round($tamanho/60) ;
            $valor_final    .= (string) ($espaço.($valor_temp === 1 ? $valor_temp.' minuto' : $valor_temp.' minutos'));
            $tamanho -= $tamanho - ($tamanho%60);
            $espaço = ' ';
        }
        if ($termina_em === 'minutos') {
            return ($valor_final === '' ? '0 minutos' : $valor_final);
        }
        if($tamanho>0){
            $valor_final .= $espaço.' segundos';
        }
        return $valor_final.'';
    }
    /**
     * Transforma Tempo para Segundos
     * 
     * @param string $float
     * @return int
     * 
     * @version 0.4.2
     * @author Ricardo Sierra <web@ricardosierra.com.br>
     */
    public static function Tranf_Tempo_Segundo($float){
        $float = strtolower($float);
        $valor_final = 0;
        if(strpos($float, 'anos')!==false){
            $float_quebrado = \explode('anos',$float);
            $float = $float_quebrado[1];
            $valor_final += ((float) $float_quebrado[0])*31556926;
        }
        if(strpos($float, 'ano')!==false){
            $float_quebrado = \explode('ano',$float);
            $float = $float_quebrado[1];
            $valor_final += ((float) $float_quebrado[0])*31556926;
        }
        if(strpos($float, 'dias')!==false){
            $float_quebrado = \explode('dias',$float);
            $float = $float_quebrado[1];
            $valor_final += ((float) $float_quebrado[0])*86400;
        }
        if(strpos($float, 'dia')!==false){
            $float_quebrado = \explode('dia',$float);
            $float = $float_quebrado[1];
            $valor_final += ((float) $float_quebrado[0])*86400;
        }
        if(strpos($float, 'horas')!==false){
            $float_quebrado = \explode('horas',$float);
            $float = $float_quebrado[1];
            $valor_final += ((float) $float_quebrado[0])*3600;
        }
        if(strpos($float, 'hora')!==false){
            $float_quebrado = \explode('hora',$float);
            $float = $float_quebrado[1];
            $valor_final += ((float) $float_quebrado[0])*3600;
        }
        if(strpos($float, 'minutos')!==false){
            $float_quebrado = \explode('minutos',$float);
            $float = $float_quebrado[1];
            $valor_final += ((float) $float_quebrado[0])*60;
        }
        if(strpos($float, 'minuto')!==false){
            $float_quebrado = \explode('minuto',$float);
            $float = $float_quebrado[1];
            $valor_final += ((float) $float_quebrado[0])*60;
        }
        return (int) $valor_final;
    }
    /**
     * Transforma Tempo para Segundos
     * 
     * @param string $url
     * @return int
     * 
     * @version 0.4.2
     * @author Ricardo Sierra <web@ricardosierra.com.br>
     */
    public static function Tranf_Url_Https($url){
        return str_replace('http://','https://',$url);
    }
    /**
     * Transforma Distancia para Otimizado
     * 
     * @param float $tamanho
     * @return string
     * 
     * @version 0.4.2
     * @author Ricardo Sierra <web@ricardosierra.com.br>
     */
    public static function Tranf_Distancia_Otimizado($tamanho){
        $tamanho = (float) $tamanho;
        if($tamanho>100){
            $tamanho    =   ((string) round($tamanho/1000,1).' km');
        }else{
            $tamanho    =   ((string) round($tamanho).' m');
        }
        return $tamanho;
    }
    /**
     * Transforma Otimizado em Distancia
     * 
     * @param string $float
     * @return float
     * 
     * @version 0.4.2
     * @author Ricardo Sierra <web@ricardosierra.com.br>
     */
    public static function Tranf_Otimizado_Distancia($float){
        $tamanho = (float) $float;
        if(strpos($float, 'km')!==false){
            return $tamanho*1000;
        }
        return $tamanho;
    }
    /**
     * Transpor Real em Decimal
     * 
     * @param string $real
     * @return float
     * 
     * @version 0.4.2
     * @author Ricardo Sierra <web@ricardosierra.com.br>
     */
    public static function Tranf_Real_Float($real){
        if ($real === '') {
            return 0.0;
        }
        if(is_float($real)) {
            return round($real, 2);
        }
        return round(((float) 
            preg_replace("/[^0-9.]/", "", 
                str_replace(Array(',','.','%A','%B'), Array('%A','%B','.',','), $real)
            )
        ),2);
    }
    /**
     * Transforma Decimal em Real
     * 
     * @param float $float
     * @return string
     * 
     * @version 0.4.2
     * @author Ricardo Sierra <web@ricardosierra.com.br>
     */
    public static function Tranf_Float_Real($float){
        if (strpos($float, 'R$') !== false) {
            return $float;
        }
        return (((float) $float)>=0
            ?'R$'.number_format(((float) $float), 2, ',', '.'):
            '<span class="text-error">- R$ '.number_format(((float) $float)*-1, 2, ',', '.').'</span>');
    }
    /**
     * Transforma Porcentagem em Decimal
     * 
     * @param float $porc
     * @return string
     * 
     * @version 0.4.2
     * @author Ricardo Sierra <web@ricardosierra.com.br>
     */
    public static function Tranf_Porc_Float($porc){
        if ($porc === '') {
            return 0.0;
        }
        if(is_float($porc)) {
            return $porc;
        }
        return round(
            ((float) preg_replace("/[^0-9.]/", "", 
                str_replace(Array(',','.','%A','%B'), Array('%A','%B','.',','), $porc)
            ))
        /100,4);
    }
    /**
     * Transforma Decimal em Porcentagem
     * 
     * @param float $float
     * @return string
     * 
     * @version 0.4.2
     * @author Ricardo Sierra <web@ricardosierra.com.br>
     */
    public static function Tranf_Float_Porc($float){
        if (strpos($float, ' %') !== false) {
            return $float;
        }
        $porc = number_format((float) $float*100, 2, ',', '.');
        if($porc<10){
            return '0'.$porc.'%';
        }
        return $porc.'%';
    }
    /**
     * 
     * @param type $data
     * @param type $ano
     * @param type $mes
     * @param type $dia
     * @param type $hora
     * @param type $minuto
     * @param type $segundos
     * @return type
     * 
     * @version 0.4.2
     * @author Ricardo Sierra <web@ricardosierra.com.br>
     */
    public static function Modelo_Data_Soma($data,$ano=0,$mes=0,$dia=0,$hora=0,$minuto=0,$segundos=0) {
        $data = trim($data);
        // Formato: 23/09/2013 00:00:00 ou 2013-09-23 00:00:00
        if(strlen($data)==19){
            $partes = explode(' ', $data);        
            if(strpos($partes[1], '-')!==false){
                $horas = explode('-', $partes[1]);
            
                if(strpos($partes[0], '/')!==false){
                    $tipo = 'd/m/Y H-i-s';
                    $dias = explode('/', $partes[0]);  

                    // REposiciona Novo Horario
                    $novo_hora      = (int) $horas[0];
                    $novo_minuto    = (int) $horas[1];
                    $novo_segundos  = (int) $horas[2];
                    $novo_dia       = (int) $dias[0];
                    $novo_mes       = (int) $dias[1];
                    $novo_ano       = (int) $dias[2];
                    // SOMA
                    $novo_hora      = $novo_hora+$hora;
                    $novo_minuto    = $novo_minuto+$minuto;
                    $novo_segundos  = $novo_segundos+$segundos;
                    $novo_dia       = $novo_dia+$dia;
                    $novo_mes       = $novo_mes+$mes;
                    $novo_ano       = $novo_ano+$ano;
                }else{
                    $tipo = 'Y-m-d H-i-s';
                    $dias = explode('-', $partes[0]);

                    // REposiciona Novo Horario
                    $novo_hora      = (int) $horas[0];
                    $novo_minuto    = (int) $horas[1];
                    $novo_segundos  = (int) $horas[2];
                    $novo_dia       = (int) $dias[2];
                    $novo_mes       = (int) $dias[1];
                    $novo_ano       = (int) $dias[0];
                    // SOMA
                    $novo_hora      = $novo_hora+$hora;
                    $novo_minuto    = $novo_minuto+$minuto;
                    $novo_segundos  = $novo_segundos+$segundos;
                    $novo_dia       = $novo_dia+$dia;
                    $novo_mes       = $novo_mes+$mes;
                    $novo_ano       = $novo_ano+$ano;
                }
            }else{
                $horas = explode(':', $partes[1]);
                
                if(strpos($partes[0], '/')!==false){
                    $tipo = 'd/m/Y H:i:s';
                    $dias = explode('/', $partes[0]);  

                    // REposiciona Novo Horario
                    $novo_hora      = (int) $horas[0];
                    $novo_minuto    = (int) $horas[1];
                    $novo_segundos  = (int) $horas[2];
                    $novo_dia       = (int) $dias[0];
                    $novo_mes       = (int) $dias[1];
                    $novo_ano       = (int) $dias[2];
                    // SOMA
                    $novo_hora      = $novo_hora+$hora;
                    $novo_minuto    = $novo_minuto+$minuto;
                    $novo_segundos  = $novo_segundos+$segundos;
                    $novo_dia       = $novo_dia+$dia;
                    $novo_mes       = $novo_mes+$mes;
                    $novo_ano       = $novo_ano+$ano; 
                }else{
                    $tipo = 'Y-m-d H:i:s';
                    $dias = explode('-', $partes[0]);

                    // REposiciona Novo Horario
                    $novo_hora      = (int) $horas[0];
                    $novo_minuto    = (int) $horas[1];
                    $novo_segundos  = (int) $horas[2];
                    $novo_dia       = (int) $dias[2];
                    $novo_mes       = (int) $dias[1];
                    $novo_ano       = (int) $dias[0];
                    // SOMA
                    $novo_hora      = $novo_hora+$hora;
                    $novo_minuto    = $novo_minuto+$minuto;
                    $novo_segundos  = $novo_segundos+$segundos;
                    $novo_dia       = $novo_dia+$dia;
                    $novo_mes       = $novo_mes+$mes;
                    $novo_ano       = $novo_ano+$ano;
                }
            }
        }else 
        // Formato: 23/09/13 | 21:13 ou 13-09-23 | 21:13
        if(strlen($data)==16){
            $partes = explode(' | ', $data);        
            if(strpos($partes[1], '-')!==false){
                $horas = explode('-', $partes[1]);
                if(strpos($partes[0], '/')!==false){
                    $tipo = 'd/m/y | H-i';
                    $dias = explode('/', $partes[0]);
                    
                    // REposiciona Novo Horario
                    $novo_hora      = (int) $horas[0];
                    $novo_minuto    = (int) $horas[1];
                    $novo_segundos  = (int) '00';
                    $novo_dia       = (int) $dias[0];
                    $novo_mes       = (int) $dias[1];
                    $novo_ano       = (int) '20'.$dias[2];
                    // SOMA
                    $novo_hora      = $novo_hora+$hora;
                    $novo_minuto    = $novo_minuto+$minuto;
                    $novo_segundos  = $novo_segundos+$segundos;
                    $novo_dia       = $novo_dia+$dia;
                    $novo_mes       = $novo_mes+$mes;
                    $novo_ano       = $novo_ano+$ano;
                }else{
                    $dias = explode('-', $partes[0]);
                    $tipo = 'y-m-d | H-i';
                    
                    // REposiciona Novo Horario
                    $novo_hora      = (int) $horas[0];
                    $novo_minuto    = (int) $horas[1];
                    $novo_segundos  = (int) '00';
                    $novo_dia       = (int) $dias[2];
                    $novo_mes       = (int) $dias[1];
                    $novo_ano       = (int) '20'.$dias[0];
                    // SOMA
                    $novo_hora      = $novo_hora+$hora;
                    $novo_minuto    = $novo_minuto+$minuto;
                    $novo_segundos  = $novo_segundos+$segundos;
                    $novo_dia       = $novo_dia+$dia;
                    $novo_mes       = $novo_mes+$mes;
                    $novo_ano       = $novo_ano+$ano;
                }
            }else{
                $horas = explode(':', $partes[1]);
                if(strpos($partes[0], '/')!==false){
                    $tipo = 'd/m/y | H:i';
                    $dias = explode('/', $partes[0]);
                    
                    // REposiciona Novo Horario
                    $novo_hora      = (int) $horas[0];
                    $novo_minuto    = (int) $horas[1];
                    $novo_segundos  = (int) '00';
                    $novo_dia       = (int) $dias[0];
                    $novo_mes       = (int) $dias[1];
                    $novo_ano       = (int) '20'.$dias[2];
                    $novo_hora      = $novo_hora+$hora;
                    $novo_minuto    = $novo_minuto+$minuto;
                    $novo_segundos  = $novo_segundos+$segundos;
                    $novo_dia       = $novo_dia+$dia;
                    $novo_mes       = $novo_mes+$mes;
                    $novo_ano       = $novo_ano+$ano;
                }else{
                    $tipo = 'y-m-d | H:i';
                    $dias = explode('-', $partes[0]);
                    
                    // REposiciona Novo Horario
                    $novo_hora      = (int) $horas[0];
                    $novo_minuto    = (int) $horas[1];
                    $novo_segundos  = (int) '00';
                    $novo_dia       = (int) $dias[2];
                    $novo_mes       = (int) $dias[1];
                    $novo_ano       = (int) '20'.$dias[0];
                    $novo_hora      = $novo_hora+$hora;
                    $novo_minuto    = $novo_minuto+$minuto;
                    $novo_segundos  = $novo_segundos+$segundos;
                    $novo_dia       = $novo_dia+$dia;
                    $novo_mes       = $novo_mes+$mes;
                    $novo_ano       = $novo_ano+$ano;
                }
            }
        }else 
        // Formato: 23/09/2013 ou 2013-09-23
        if(strlen($data)==10){
            if(strpos($data, '/')!==false){
                $tipo = 'd/m/Y';
                $partes = explode('/', $data);
                    
                // REposiciona Novo Horario
                $novo_hora      = 0;
                $novo_minuto    = 0;
                $novo_segundos  = 0;
                $novo_dia       = (int) $partes[0];
                $novo_mes       = (int) $partes[1];
                $novo_ano       = (int) $partes[2];
                $novo_hora      = $novo_hora+$hora;
                $novo_minuto    = $novo_minuto+$minuto;
                $novo_segundos  = $novo_segundos+$segundos;
                $novo_dia       = $novo_dia+$dia;
                $novo_mes       = $novo_mes+$mes;
                $novo_ano       = $novo_ano+$ano;
            }else{
                $tipo = 'Y-m-d';
                $partes = explode('-', $data);
                    
                // REposiciona Novo Horario
                $novo_hora      = 0;
                $novo_minuto    = 0;
                $novo_segundos  = 0;
                $novo_dia       = (int) $partes[2];
                $novo_mes       = (int) $partes[1];
                $novo_ano       = (int) $partes[0];
                $novo_hora      = $novo_hora+$hora;
                $novo_minuto    = $novo_minuto+$minuto;
                $novo_segundos  = $novo_segundos+$segundos;
                $novo_dia       = $novo_dia+$dia;
                $novo_mes       = $novo_mes+$mes;
                $novo_ano       = $novo_ano+$ano;
            }
        }
        
        // Aumenta segundo, minuto e hora que tiver ultrapassado
        while($novo_segundos>=60){
            $novo_segundos = $novo_segundos-60;
            ++$novo_minuto;
        }
        while($novo_minuto>=60){
            $novo_minuto = $novo_minuto-60;
            ++$novo_hora;
        }
        while($novo_hora>=60){
            $novo_hora = $novo_hora-60;
            ++$novo_dia;
        }
        // Faz do mes antes para calculo de dias
        while($novo_mes>12){
            $novo_mes = $novo_mes-12;
            ++$novo_ano;
        }
        // Faz corretagem de dias
        $dias_do_mes = cal_days_in_month(CAL_GREGORIAN, $novo_mes, $novo_ano);
        while($novo_dia>$dias_do_mes){
            $novo_dia = $novo_dia-$dias_do_mes;
            ++$novo_mes;
            // Recalcula Ano
            if($novo_mes>12){
                $novo_mes = $novo_mes-12;
                ++$novo_ano;
            }
            // Chama novo dia do mes
            $dias_do_mes = cal_days_in_month(CAL_GREGORIAN, $novo_mes, $novo_ano);
        }
        // Calcula e devolve nova data
        $data = mktime($novo_hora, $novo_minuto, $novo_segundos, $novo_mes, $novo_dia, $novo_ano);
        return date($tipo, $data);
    }
    /**
     * 
     * @param type $info (mes, ano, dia, semana, etc...
     * @param type $data
     * 
     * @version 0.4.2
     * @author Ricardo Sierra <web@ricardosierra.com.br>
     */
    static public function Get_Info_Data($info, $data){
        if($info=='mes_nome'){
            return (string) jdmonthname($data,0);
        }else if($info=='mes'){
            $data = explode('/',$data);
            return (int) $data[1];
        }else if($info=='semana'){
            $data = explode('/',$data);
            return (int) date("w", mktime(0,0,0,$data[1],$data[0],$data[2]) );
        }else if($info=='semana_do_ano'){
          $data = explode('/',$data);
          return (int) intval( date('z', mktime(0,0,0,$data[1],$data[0],$data[2]) ) / 7 ) + 1;
        }else if($info=='dia'){
            $data = explode('/',$data);
            return (int) $data[0];
        }else if($info=='ano'){
            $data = explode('/',$data);
            return (int) $data[2];
        }
        
        return false;
    }
    /**
     * Geradores
     * Gera Senha Automaticamente
     * 
     * @param type $tamanho
     * @param type $forca
     * @return string
     * 
     * @version 0.4.2
     * @author Ricardo Sierra <web@ricardosierra.com.br>
     */
    static public function Gerar_Senha($tamanho=8, $forca=6) {
    
        $vogais             = '2357';
        $consoantes         = '014689';
        
        if ($forca >= 2) {
            $consoantes .= 'bcdfghjklmnpqrstvwxz';
        }
        if ($forca >= 3) {
            $vogais .= 'aeiouy';
        }
        if ($forca >= 5) {
            $consoantes    .= 'BCDFGHJKLMNPQRSTVWXZ';
        }
        if ($forca >= 6) {
            $vogais        .= "AEIOUY";
        }
        if ($forca >= 8 ) {
            $vogais .= '*@';
        }
        if ($forca >= 10 ) {
            $vogais .= '-!#%$';
        }

        $senha = '';
        $alt = time() % 2;
        for ($i = 0; $i < $tamanho; $i++) {
            if ($alt == 1) {
                $senha .= $consoantes[(rand() % strlen($consoantes))];
                $alt = 0;
            } else {
                $senha .= $vogais[(rand() % strlen($vogais))];
                $alt = 1;
            }
        }
        return $senha;
    }
    /**
     * Detecta Navegador
     * 
     * @return type
     * 
     * @version 0.4.2
     * @author Ricardo Sierra <web@ricardosierra.com.br>
     */
    public static function Detectar_Navegador()
    {
        if(!isset($_SERVER['HTTP_USER_AGENT']) || empty($_SERVER['HTTP_USER_AGENT'])) {
            return array(
                'name' => 'Desconhecido',
                'version' => 'Desconhecido',
                'platform' => 'Desconhecido',
                'userAgent' => ''
            );
        }
        $userAgent = strtolower($_SERVER['HTTP_USER_AGENT']);

        if (preg_match('/opera/', $userAgent)) {
            $name = 'opera';
        }
        elseif (preg_match('/webkit/', $userAgent)) {
            $name = 'safari';
        }
        elseif (preg_match('/msie/', $userAgent)) {
            $name = 'msie';
        }
        elseif (preg_match('/mozilla/', $userAgent) && !preg_match('/compatible/', $userAgent)) {
            $name = 'mozilla';
        }
        else {
            $name = 'Desconhecido';
        }

        if (preg_match('/.+(?:rv|it|ra|ie)[\/: ]([\d.]+)/', $userAgent, $matches)) {
            $version = $matches[1];
        }
        else {
            $version = 'Desconhecido';
        }

        if (preg_match('/linux/', $userAgent)) {
            $platform = 'linux';
        }
        elseif (preg_match('/macintosh|mac os x/', $userAgent)) {
            $platform = 'mac';
        }
        elseif (preg_match('/windows|win32/', $userAgent)) {
            $platform = 'windows';
        }
        else {
            $platform = 'unrecognized';
        }

        return array(
            'Nome'          => $name,
            'Versão'        => $version,
            'Plataforma'    => $platform,
            'UserAgent'     => $userAgent
        );
    }
    /**
     * Captura GPS
     * 
     * @param type $exifCoord
     * @param type $hemi
     * @return type
     * 
     * @version 0.4.2
     * @author Ricardo Sierra <web@ricardosierra.com.br>
     */
    public static function Get_Gps($exifCoord, $hemi) {
        $degrees = count($exifCoord) > 0 ? self::Trans_Gps_Number($exifCoord[0]) : 0;
        $minutes = count($exifCoord) > 1 ? self::Trans_Gps_Number($exifCoord[1]) : 0;
        $seconds = count($exifCoord) > 2 ? self::Trans_Gps_Number($exifCoord[2]) : 0;
        $flip = ($hemi == 'W' or $hemi == 'S') ? -1 : 1;
        return $flip * ($degrees + $minutes / 60 + $seconds / 3600);
    }
    /**
     * Trata GPS
     * 
     * @param type $coordPart
     * @return int
     * 
     * @version 0.4.2
     * @author Ricardo Sierra <web@ricardosierra.com.br>
     */
    public static function Trans_Gps_Number($coordPart) {
        $parts = explode('/', $coordPart);
        if (count($parts) <= 0)
            return 0;
        if (count($parts) == 1)
            return $parts[0];
        return floatval($parts[0]) / floatval($parts[1]);
    }
}



?>
