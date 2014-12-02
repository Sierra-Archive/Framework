<?php
namespace Framework\App;
Class Sistema_Funcoes {
    /**
     * Redireciona a Pagina
     * 
     * @name redirect
     * @access public
     * @return void
     * 
     * @author Ricardo Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public static function Redirect($url)
    {
        if(LAYOULT_IMPRIMIR==='AJAX' && strpos($url, URL_PATH)!==false){
            $registro = Registro::getInstacia();
            $params = Array('Url'=>$url,'Tempo'=>10);
            if($registro->_Visual===false){
                $registro->_Visual = new \Framework\App\Visual();
            }
            $registro->_Visual->Json_IncluiTipo('Redirect',$params);
            if(\Framework\App\Controle::$ligado===false){
                $registro->_Visual->renderizar();
                \Framework\App\Controle::Tema_Travar();
            }
            return true;
        }else{
            header('Location: ' . $url);
        }
        exit;
    }
    public static function Control_Arq_Ext($ext){
        $ext = strtolower($ext);
        if($ext==='jpe'){
            $ext = 'jpeg';
        }
        if($ext==='mpe'){
            $ext = 'mpeg';
        }
        return $ext;
    }
    public static function Letra_Aleatoria($numero){
        $string = 'ABCDEFGHIJKLMNOPQUVYXWZ';
        return $string[$numero];
    }
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
     * 
     * @param type $codigo
     * 
     * @version 2.0
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
     * 
     * @param type $dir
     * 
     * 
     * @version 2.0
     * @author Ricardo Sierra <web@ricardosierra.com.br>
     */
    public static function DirReplace($dir = false){
        if($dir){
            if(strpos($dir, '-')){
                $dir = str_replace(Array('-'), Array('/'), $dir);
            }else{
                $dir = str_replace(Array('/'), Array('-'), $dir);
            }
        }
    }
    /**
     * 
     * @param type $url
     * @return type
     * 
     * @version 2.0
     * @author Ricardo Sierra <web@ricardosierra.com.br>
     */
    public static function Url_Limpeza($url){
        $url = str_replace(Array('http://','https://'), Array('',''), $url);
        $url = str_replace(Array('www.','www2.'), Array('',''), $url);
        return $url;
    }
    /**
     * Verifica a Versão do PHP
     * Returna TRUE para comporta a versao, e false para versao nao compativel
     * 
     * @param type $versao
     * @return boolean
     * 
     * @version 2.0
     * @author Ricardo Sierra <web@ricardosierra.com.br>
     */
    public static function VersionPHP($versao){
        if (strnatcmp(SIS_PHPVERSION,$versao) >= 0) return TRUE;
        else                                        return FALSE;
    }
    /**
     *  Transforma Objetos em Variaveis
     * @version 2.0
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
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.0.1
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
        if($modulo!='_Sistema' && !array_key_exists($modulo,config_modulos())){
            return false;
        }else{
            return true;
        }
    }
    /**
     * Formularios
     */
    public static function Form_Senha_Blindar($senha){
        return md5(\anti_injection($senha));
    }
    
    /********************************
     * FUNCOES PARA PERFOMARCE
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
     * @param type $cnpj
     * @return boolean
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.0.1
     */
    public static function Control_Layoult_Valida_Cep($cnpj){
        //Etapa 1: Cria um array com apenas os digitos numéricos, isso permite receber o cnpj em diferentes formatos como "00.000.000/0000-00", "00000000000000", "00 000 000 0000 00" etc...
        $j=0;
        for($i=0; $i<(strlen($cnpj)); $i++)
        {
            if(is_numeric($cnpj[$i]))
            {
                $num[$j]=$cnpj[$i];
                $j++;
            }
        }
        //Etapa 2: Conta os dígitos, um Cnpj válido possui 14 dígitos numéricos.
        if(count($num)!=14)
        {
            return false;
        }
        //Etapa 3: O número 00000000000 embora não seja um cnpj real resultaria um cnpj válido após o calculo dos dígitos verificares e por isso precisa ser filtradas nesta etapa.
        if ($num[0]==0 && $num[1]==0 && $num[2]==0 && $num[3]==0 && $num[4]==0 && $num[5]==0 && $num[6]==0 && $num[7]==0 && $num[8]==0 && $num[9]==0 && $num[10]==0 && $num[11]==0)
        {
            return false;
        }
        //Etapa 4: Calcula e compara o primeiro dígito verificador.
        else
        {
            $j=5;
            for($i=0; $i<4; $i++)
            {
                $multiplica[$i]=$num[$i]*$j;
                $j--;
            }
            $soma = array_sum($multiplica);
            $j=9;
            for($i=4; $i<12; $i++)
            {
                $multiplica[$i]=$num[$i]*$j;
                $j--;
            }
            $soma = array_sum($multiplica);	
            $resto = $soma%11;	
            if($resto<2)
            {
                $dg=0;
            }
            else
            {
                $dg=11-$resto;
            }
            if($dg!=$num[12])
            {
                return false;
            }
        }
        //Etapa 5: Calcula e compara o segundo dígito verificador.
        if(!isset($isCnpjValid))
        {
            $j=6;
            for($i=0; $i<5; $i++)
            {
                $multiplica[$i]=$num[$i]*$j;
                $j--;
            }
            $soma = array_sum($multiplica);
            $j=9;
            for($i=5; $i<13; $i++)
            {
                $multiplica[$i]=$num[$i]*$j;
                $j--;
            }
            $soma = array_sum($multiplica);	
            $resto = $soma%11;	
            if($resto<2)
            {
                $dg=0;
            }
            else
            {
                $dg=11-$resto;
            }
            if($dg!=$num[13])
            {
                return false;
            }
            else
            {
                return true;
            }
        }
        //Trecho usado para depurar erros.
        /*
        if($isCnpjValid==true)
        {
        echo "<p><font color="GREEN">Cnpj é Válido</font></p>";
        }
        if($isCnpjValid==false)
        {
        echo "<p><font color="RED">Cnpj Inválido</font></p>";
        }
        */
        //Etapa 6: Retorna o Resultado em um valor booleano.
        return true;
    }

    // FUNCAO QUE VERIFICA SE UM EMAIL EH VALIDO, retorna 0 se nao for
    public static function Control_Layoult_Valida_Email($email){
        $mail_correcto = 0; 
        //verifico umas coisas
        if ((strlen($email) >= 6) && (substr_count($email,"@") == 1) && (substr($email,0,1) != "@") && (substr($email,strlen($email)-1,1) != "@")){
            if ((!strstr($email,"'")) && (!strstr($email,"\"")) && (!strstr($email,"\\")) && (!strstr($email,"\$")) && (!strstr($email," "))) {
                //vejo se tem caracter .
                if (substr_count($email,".")>= 1){
                    //obtenho a termina��o do dominio
                    $term_dom = substr(strrchr ($email, '.'),1);
                    //verifico que a termina��o do dominio seja correcta
                    if (strlen($term_dom)>1 && strlen($term_dom)<5 && (!strstr($term_dom,"@")) ){
                        //verifico que o de antes do dominio seja correcto
                        $antes_dom = substr($email,0,strlen($email) - strlen($term_dom) - 1);
                        $caracter_ult = substr($antes_dom,strlen($antes_dom)-1,1);
                        if ($caracter_ult != "@" && $caracter_ult != "."){
                                $mail_correcto = 1; 
                        }
                    }
                }
            }
        }
        if ($mail_correcto)
           return 1;
        else
           return 0;
    }
    public static function Tranf_Byte_Otimizado($tamanho){
        $tamanho = (int) $tamanho;
        if($tamanho>1099511627776){
            $tamanho    =   ((string) round($tamanho/1099511627776)).' TB';
        }else if($tamanho>1073741824){
            $tamanho    =   ((string) round($tamanho/1073741824)).' GB';
        }else if($tamanho>1048576){
            $tamanho    =   ((string) round($tamanho/1048576)).' MB';
        }else if($tamanho>1024){
            $tamanho    =   ((string) round($tamanho/1024)).' KB';
        }else{
            $tamanho    =   ((string) round($tamanho)).' B';
        }
        return $tamanho;
        //return round($real,2);
    }
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
    public static function Tranf_Real_Float($real){
        if($real==='') return 0.0;
        if(is_float($real)) return round($real,2);
        $real = str_replace(Array(',','.','%A','%B'), Array('%A','%B','.',','), $real);
        $real = preg_replace("/[^0-9.]/", "", $real); 
        $real = (float) $real;
        return round($real,2);
    }
    public static function Tranf_Float_Real($float){
        if(strpos($float, 'R$')!==false) return $float;
        $float = (float) $float;
        return ($float>=0?'R$ '.number_format($float, 2, ',', '.'):'<span class="text-error">- R$ '.number_format($float*-1, 2, ',', '.').'</span>');
    }
    public static function Tranf_Porc_Float($porc){
        if($porc==='') return 0.0;
        if(is_float($porc)) return $porc;
        $porc = str_replace(Array(',','.','%A','%B'), Array('%A','%B','.',','), $porc);
        $porc = preg_replace("/[^0-9.]/", "", $porc);
        $porc = (float) $porc;
        return round($porc/100,4);
    }
    public static function Tranf_Float_Porc($float){
        if(strpos($float, ' %')!==false) $float = self::Tranf_Porc_Float($float);
        $float = (float) $float;
        $float = number_format($float*100, 2, ',', '.');
        if($float<10){
            return '0'.$float.' %';
        }
        return $float.' %';
    }
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
}



?>
