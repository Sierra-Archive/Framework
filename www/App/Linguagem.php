<?php
     
/**
 * Sistema de Linguagem
 *
 * @author Thiago Belem <contato@thiagobelem.net>
 * @link http://blog.thiagobelem.net/
 */
class Linguagem {

    /**
     * Tempo padrão de cache
     *
     * @var string
     */
    private $linguagem = Array();

    public function Carregar ($file=false) {
        if (!file_exists(LANG_PATH.$file.'.ini')) {
            // Trigger an error -- has to be in English though
            // because we can't load the language file
            trigger_error(sprintf("The language file %s couldn't be opened.", $file.'.ini'), E_USER_WARNING);
        } else {
            // Parse the language file
            if (isset($this->linguagem)) {
                    $this->linguagem = array_merge($this->linguagem, parse_ini_file(LANG_PATH.$file.'.ini'));
            } else {
                    $this->linguagem = parse_ini_file(LANG_PATH.$file.'.ini');
            }


            if (!is_array($this->linguagem)) {
                    // Couldn't load the language file
                    trigger_error(sprintf("The language file %s couldn't be loaded.", $file.'.ini'), E_USER_WARNING);
            }
        }
    }
    /**
     * Captura Linguagem
     * 
     * @param type $name
     * @param type $replacements
     * @return string
     */
    function GetLang($name, $replacements=array())
    {
        if(!isset($this->linguagem[$name])) {
            return '';
        }


        $string = $this->linguagem[$name];
        if(empty($replacements)) {
            return $string;
        }


        // Prefix array keys with a colon
        $actualReplacements = array();
        foreach($replacements as $k => $v) {
            $actualReplacements['{'.$k.'}'] = $v;
        }
        return strtr($string, $actualReplacements);
    }
    /**
     * Verifica Erro de Linguagem e Corrige
     * @param type $pasta
     */
    function Verificar_Erro($pasta=false) {
        // Carrega Todos os DAO
        if($pasta===false){
            $dir = dirname(__FILE__).'/language/en';
            $diretorio1 = dir($dir);  
        }else{
            $dir = dirname(__FILE__).'/language/en/'.$pasta;
            $diretorio1 = dir($dir); 
        }
        while($arquivo = $diretorio1 -> read()){
            if($arquivo!='..' && $arquivo!='.'){
                if(strpos($arquivo, '.ini')!==false){
                    $var1 = parse_ini_file($dir.'/'.$arquivo);
                    $var2 = parse_ini_file(str_replace(Array('/en'), Array('/ptbr') , $dir.'/'.$arquivo));
                    $dif = array_diff_key($var1, $var2);
                    if(!empty($dif)){
                        $var2 = array_merge_recursive($var2,$dif);
                        $this->Ini_Salvar(str_replace(Array('/en'), Array('/ptbr') , $dir.'/'.$arquivo),$var2);
                    }
                }else{
                    if($pasta!==false) $arquivo = $pasta.'/'.$arquivo;
                    $this->Verificar_Erro($arquivo);
                }
            }
        }
    }
    function Ini_Salvar($inifile, $content)
    {
        $linhas = '';
        if(file_exists($inifile)){
            unlink($inifile);
        }
        foreach ($content as $key => $content)
        {
            $linhas .= "{$key}  =  \"{$content}\"\n";
        }
        file_put_contents($inifile, $linhas);
    } 
}
?>