<?php
/*
 * Arquivos de Funcao Atualizados.. Para funcionamento com php5...
 * 2013-05-13
 */

/**
 *     SEGURANÇA - Antiinjection
 * @param type $sql
 * @return type
 * 
 * @version 0.2 -> Alterado para caso receba um Array, usar recursao para fazer antiinfection em todos
 */
function anti_injection($sql,$tags=false){
     if(is_array($sql)){
         $seg = Array();
         foreach($sql as $indice=>&$valor){
             $seg[\anti_injection($indice)] = \anti_injection($valor,$tags);
         }
         $sql = $seg;
     }else{
        /*// remove palavras que contenham sintaxe sql
        $sql = mysql_real_escape_string($sql);
        if($tags===false){
            $sql = strip_tags($sql);//tira tags html e php
        }*/
     }
     return $sql;
}
/**
 * Criptografia Fraca
 * @param type $x
 * @return type
 */
function B ($x)
{
    return base64_decode($x);
}
function B2 ($x)
{
    return base64_encode($x);
}

/**
 *  ORDENACAO DE ARRAY
 * @param type $a
 * @param type $b
 * @return int
 */
// FUNCAO DE ORDENA��O DE ARRAY
function ordenar($a, $b, $seguir = 'pontos')
{   
    if ($a[$seguir] == $b[$seguir]) {
        return 0;
    }
    return ($a[$seguir] > $b[$seguir]) ? -1 : 1;
}
/**
 * SEPARAR ARRAY
 * @param type $array
 * @param type $comeco
 * @param type $separador
 * @param type $separando
 * @param type $outroarray_i
 * @param type $outroarray_f
 * @return string
 */
function desfazer_array($array, $comeco=0,  $separador=" | " ,  $separando=" -> " ,  $outroarray_i=" { " ,  $outroarray_f=" } " )
{
  $imprimir = "";
  foreach( $array as $key=>$value)
  {
    if( is_array( $value ) )
    {
	  $imprimir .= $outroarray_i;
      $imprimir .= desfazer_array($value, 0, $separador, $separando, $outroarray_i, $outroarray_f );
	  $imprimir .= $outroarray_f;
    }
    else
    {
		if($comeco==0) $imprimir .=  $key.$separando.$value;
		else           $imprimir .=  $separador.$key.$separando.$value;
		++$comeco;
    }
  }
  return $imprimir;
}


/**
 * REMOVER ACENTOS
 * @param type $string
 * @return type
 */
#REMOVER ACENTOS
function remover_acentos($string)
{ 
     // Converte todos os caracteres para minusculo 
     $string = strtolower($string); 
     // Remove os acentos 
     $string = eregi_replace('[aáàãâä]', 'a', $string); 
     $string = eregi_replace('[eéèêë]', 'e', $string); 
     $string = eregi_replace('[iíìîï]', 'i', $string); 
     $string = eregi_replace('[oóòõôö]', 'o', $string); 
     $string = eregi_replace('[uúùûü]', 'u', $string); 
     // Remove o cedilha e o ñ 
     $string = eregi_replace('[ç]', 'c', $string); 
     $string = eregi_replace('[ñ]', 'n', $string); 
     // Substitui os espaços em brancos por underline 
     $string = eregi_replace('( )', '_', $string); 
     // Remove hifens duplos 
     $string = eregi_replace('--', '_', $string); 
     return $string;

}
/**
 * ORDENA ARRAYS MULTIDIMENSIONAIS
 * @param type $toOrderArray
 * @param type $field
 * @param type $inverse
 */
// ordena array multi dimensionais
function orderMultiDimensionalArray(&$toOrderArray, $field, $inverse = false) { 
    if(empty($toOrderArray)) return false;
    $position = array();  
    $newRow = array();  
    foreach ($toOrderArray as $key => $row) {  
            $position[$key]  = $row[$field];  
            $newRow[$key] = $row;  
    }  
    if ($inverse) {  
        arsort($position);  
    }  
    else {  
        asort($position);  
    }  
    $returnArray = array();  
    foreach ($position as $key => $pos) {       
        $returnArray[] = $newRow[$key];  
    }  
    $toOrderArray = $returnArray;
}


/**
 * 
 * @param type $data
 * @return type
 */
// Cria uma função que retorna o timestamp de uma data
function Data_geraTimestamp($data,$quebra=true) {
    $data = trim($data);
    // Formato: 23/09/2013 00:00:00 ou 2013-09-23 00:00:00
    if(strlen($data)==19){
        $partes = explode(' ', $data);        
        if(strpos($partes[1], '-')!==false){
            $horas = explode('-', $partes[1]);
        }else{
            $horas = explode(':', $partes[1]);
        }
        if(strpos($partes[0], '/')!==false){
            $dias = explode('/', $partes[0]);
            return mktime($horas[0], $horas[1], $horas[2], $dias[1], $dias[0], $dias[2]);
        }else{
            $dias = explode('-', $partes[0]);
            return mktime($horas[0], $horas[1], $horas[2], $dias[1], $dias[2], $dias[0]);
        }
    }else 
    // Formato: 23/09/13 | 21:13 ou 13-09-23 | 21:13
    if(strlen($data)==16){
        $partes = explode(' | ', $data);        
        if(strpos($partes[1], '-')!==false){
            $horas = explode('-', $partes[1]);
        }else{
            $horas = explode(':', $partes[1]);
        }
        if(strpos($partes[0], '/')!==false){
            $dias = explode('/', $partes[0]);
            return mktime($horas[0], $horas[1], '00', $dias[1], $dias[0], '20'.$dias[2]);
        }else{
            $dias = explode('-', $partes[0]);
            return mktime($horas[0], $horas[1], '00', $dias[1], $dias[2], '20'.$dias[0]);
        }
    }else 
    // Formato: 23/09/2013 ou 2013-09-23
    if(strlen($data)==10){
        if(strpos($data, '/')!==false){
            $partes = explode('/', $data);
            return mktime(0, 0, 0, $partes[1], $partes[0], $partes[2]);
        }else{
            $partes = explode('-', $data);
            return mktime(0, 0, 0, $partes[1], $partes[2], $partes[0]);
        }
    }
    if($quebra) throw new \Exception('Função::Data_geraTimestamp(): Data em Formato Inválido ('.$data.')',3040);
    return false;
}
/**
 * 
 * @param type $data_inicial
 * @param type $data_Final
 * @return type
 */
function Data_CalculaDiferenca($data_inicial,$data_final){
    // Usa a função criada e pega o timestamp das duas datas:
    $time_inicial = Data_geraTimestamp($data_inicial);
    $time_final = Data_geraTimestamp($data_final);
    // Calcula a diferença de segundos entre as duas datas:
    $diferenca = $time_final - $time_inicial;

    // Calcula a diferença de horas
    $dias = (int)floor( $diferenca / (60 * 60));
    return $dias;
}
function Data_CalculaDiferenca_Em_Segundos($data_inicial,$data_final){
    // Usa a função criada e pega o timestamp das duas datas:
    $time_inicial = Data_geraTimestamp($data_inicial);
    $time_final = Data_geraTimestamp($data_final);
    // Calcula a diferença de segundos entre as duas datas:
    $diferenca = $time_final - $time_inicial;

    // Calcula a diferença de segundos
    $dias = (int)floor( $diferenca );
    return $dias;
}
/**
 * 
 * @param type $data
 * @return type
 */
#DATA BRASIL EUA
function data_brasil_eua($data)
{
    $array = explode("/",$data);
    if(!isset($array[2])){
        return '0000-00-00';
    }
    return $array[2].'-'.$array[1].'-'.$array[0];
}
/**
 * 
 * @param type $data
 * @return type
 */
#DATA EUA BRASIL
function data_eua_brasil($data)
{
    $array = explode("-",$data);
    if(!isset($array[2])){
        return '0000/00/00';
    }
    return $array[2].'/'.$array[1].'/'.$array[0];
}
/**
 * 
 * @param type $data
 * @return type
 */
#DATA E HORA EUA tranforma pra BRASIL
function data_hora_eua_brasil($data)
{
    // Caso seja vazio retorna vazio
    if($data==NULL){
        return '';
    }
    
    $data = explode(" ",$data);
    $array2 = explode("-",$data[0]);
    if(!isset($data[1]) || !isset($array2[2])){
        return '00/00/0000 00:00:00';
    }
    $hora = $data[1];
    
    return $array2[2].'/'.$array2[1].'/'.$array2[0].' '.$hora;
}
/**
 * 
 * @param type $data1
 * @return type
 */
#DATA E HORA EUA BRASIL
function data_hora_brasil_eua($data)
{
    // Caso seja vazio retorna vazio
    if($data==NULL){
        return '';
    }
    $data_quebrada = explode(" ",$data);
    
    
    if(!isset($data_quebrada[1])){
        return '0000-00-00 00:00:00';
    }
    $hora = $data_quebrada[1];
    $data_quebrada = explode("/",$data_quebrada[0]);
    
    if(!isset($data_quebrada[2])){
        return '0000-00-00 00:00:00';
    }
    
    return $data_quebrada[2].'-'.$data_quebrada[1].'-'.$data_quebrada[0].' '.$hora;
}
/**
 * 
 * @param type $date_time
 * @param type $output_string
 * @param type $utilizar_funcao_date
 * @return boolean
 */
function date_replace($date_time, $output_string, $utilizar_funcao_date = false) {
     // Verifica se a string est� num formato v�lido de data ("aaaa-mm-dd" ou "aaaa-mm-dd hh:mm:ss")
     if (preg_match("/^(\d{4}(-\d{2}){2})( \d{2}(:\d{2}){2})?$/", $date_time)) {
       $valor['d'] = substr($date_time, 8, 2);
       $valor['m'] = substr($date_time, 5, 2);
       $valor['Y'] = substr($date_time, 0, 4);
       $valor['y'] = substr($date_time, 2, 2);
      $valor['H'] = substr($date_time, 11, 2);
      $valor['i'] = substr($date_time, 14, 2);
      $valor['s'] = substr($date_time, 17, 2);

    // Verifica se a string est� num formato v�lido de hor�rio ("hh:mm:ss")
    } else if (preg_match("/^(\d{2}(:\d{2}){2})?$/", $date_time)) {
      $valor['d'] = NULL;
      $valor['m'] = NULL;
      $valor['Y'] = NULL;
      $valor['y'] = NULL;
      $valor['H'] = substr($date_time, 0, 2);
      $valor['i'] = substr($date_time, 3, 2);
      $valor['s'] = substr($date_time, 6, 2);

    } else {
      return false;
    }
    if ($utilizar_funcao_date) {
      return date($output_string, mktime($valor['H'], $valor['i'], $valor['s'], $valor['m'], $valor['d'], $valor['Y']));
    }
    foreach (array('d', 'm', 'Y', 'y', 'H', 'i', 's') as $caractere) {
	$output_string = preg_replace('/'.$caractere.'/', $valor[$caractere], $output_string);
    }
    $output_string = preg_replace("/(^|[^\\\\])\\\\/", "\\1", $output_string);

    return $output_string;
}

function Mail_Send($nome_remetente, $email_remetente,$email_destinatario,$assunto,$mgm){
    $mensagem = "Locaway<br />";
    $mensagem .= $mgm;
    $mensagem .= "<br /><br />";
    $cabecalho =    "MIME-Version: 1.0\n";
    $cabecalho .=   "Content-Type: text/html; charset=UTF-8\n";
    $cabecalho .=   "From: \"{$nome_remetente}\" <{$email_remetente}>\n";
    $status_envio = @mail ($email_destinatario, $assunto, $mensagem, $cabecalho);
    if ($status_envio) { return 1; } else { return 0;}
}
/**
 * Inverso de nl2br
 * @param type $string
 * @return type
 */
function br2nl($string)
{
    return preg_replace('/\<br(\s*)?\/?\>/i', "\n", $string);
}
?>
