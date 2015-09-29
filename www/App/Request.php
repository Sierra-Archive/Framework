<?php
namespace Framework\App;
/**
 * Pega a Requisição, pega todos os Dados e Prepara para Executar os Metodos
 * 
 * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
 * @version 0.4.2
 */
class Request
{
    private $_modulo;
    private $_submodulo;
    private $_metodo;
    private $_argumentos;
    private $_permitidos;
    private $_url;
    public  $url_inteira = '';
    
    public function __construct() {
        
        if(function_exists('config_modulos')){
            $this->_permitidos = config_modulos();
        }else{
            $this->permitidos = Array();
        }
        
        // Puxa URL e a separada pela /
        if(isset($_GET['url'])){
            $url = filter_input(INPUT_GET, 'url', FILTER_SANITIZE_URL);
            $this->_url = $url;
            $url = explode('/', $url);
            $url = array_filter($url);
        }else{
            $url = false;
            $this->_url = '';
        }
        
        // Extrai primeiro elemento como Controlador
        if(is_array($url) && count($url)>0){
            $this->_modulo = \Framework\App\Conexao::anti_injection(array_shift($url)); 
            if($this->isAjax()===true){
                define('LAYOULT_IMPRIMIR', 'AJAX');
                
                if($this->_modulo =='Modelo'){
                    $this->_modulo = \Framework\App\Conexao::anti_injection(array_shift($url)); 
                    $this->_url = substr($this->_url, 7);
                    define('REQUISICAO_TIPO', 'MODELO');
                }
            }else{
                // SE tiver com Ajax no Comeco, Retira, foi passado como Ajax, 
                // mas não é ajax.
                if($this->_modulo =='ajax'){
                    $this->_modulo = \Framework\App\Conexao::anti_injection(array_shift($url));
                }else if($this->_modulo =='Modelo'){
                    // Se nao for Ajax, Remove E nao Coloca do Tipo Modelo
                    $this->_modulo = \Framework\App\Conexao::anti_injection(array_shift($url)); 
                    $this->_url = substr($this->_url, 7);
                }
                define('LAYOULT_IMPRIMIR', 'COMPLETO');
            }
        }else{
            $this->_modulo = DEFAULT_MODULO;
            define('LAYOULT_IMPRIMIR', 'COMPLETO');
        }
        
        if(!defined('REQUISICAO_TIPO')){
            define('REQUISICAO_TIPO', 'CONTROLE');
        }
        
        // Extrai primeiro elemento como submodulo
        if(is_array($url) && count($url)>0){
            $this->_submodulo   = \Framework\App\Conexao::anti_injection(array_shift($url));
        }else{
            $this->_submodulo = DEFAULT_SUBMODULO;
        }
        // Extrai primeiro elemento como Metodo
        if(is_array($url) && count($url)>0){
            $this->_metodo      = \Framework\App\Conexao::anti_injection(array_shift($url));
        }else{
            $this->_metodo = DEFAULT_METODO;
        }
        
        
        
        // Resto fica como os argumentos
        if(is_array($url) && count($url)>0){
            $this->_argumentos  = $url;
        }else{
            $this->_argumentos = Array();
        }
        
        
        $this->url_inteira = $this->_modulo.'/'.$this->_submodulo.'/'.$this->_metodo;
        foreach($this->_argumentos as $valor){
            $this->url_inteira .= '/'.$valor;
        }
        
        define('SISTEMA_MODULO', $this->_modulo);
        define('SISTEMA_SUB', $this->_submodulo);
        define('SISTEMA_MET', $this->_metodo);
        define('SISTEMA_DIR_INT', $this->url_inteira);
        
        // Bloqueia caso modulo nao seja permitido: Da que a pagina nao foi encontrada
        if(!\Framework\App\Sistema_Funcoes::Perm_Modulos($this->_modulo)){
            throw new \Exception('Modulo não permitido para este servidor ou não existe: '.$this->_modulo,404);
        }
    }
    public function getURL() {
        return $this->_url;
    }
    public function getModulo(){
        return $this->_modulo;
    }
    public function getSubModulo(){
        return $this->_submodulo;
    }
    public function getMetodo(){
        return $this->_metodo;
    }
    /**
     * Extrai todos os somente um dos argumentos passados pela url
     * 
     * @param type $indice
     * @return type
     * 
     * @author Ricardo Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function getArgs($indice = -1){
        if($indice == -1)
            return $this->_argumentos;
        else
            return $this->_argumentos[$indice];
    }
    /**
     * Verifica se é uma requisição ajax
     * @return type
     */
    public function isAjax(){
        return (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
    }
}

?>
