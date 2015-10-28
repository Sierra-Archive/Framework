<?php
namespace Framework\App;
/**
 * Boot do Sistema, Responsável por Iniciar todo o Sistema em toda Requisição
 * 
 * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
 * @version 0.4.2
 */
class Boot {
    /**
     * Armazena Url que foi Acessado o Sistema
     * @var string 
     */
    static $url = false;
    /**
     * Inicia o Sistema
     * 
     * @return boolean
     * @throws \Exception
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public static function Iniciar(){  
        // Pega Instancia e Inicia Cache
        $Registro = &\Framework\App\Registro::getInstacia();
        $Registro->_Cache   = new \Framework\App\Cache(CACHE_PATH);   
        
        // Verifica SE EXISTE CACHE
        if(SISTEMA_CACHE_PAGINAS){
            if(isset($_GET['url'])){
                self::$url = md5($_GET['url']);
            }else{
                self::$url = md5('index');
            }
            $Cache = $Registro->_Cache->Ler('Pagina_'.self::$url);
            if ($Cache) {
                echo $Cache;
                return false;
            }
        }
        
        
        
        // Se nao tiver cache continua
        $tempo = new \Framework\App\Tempo('BOOT Inicial');   
        // Inicia SEssao e Classes PARTE 1
        \Framework\App\Session::init();
        
        if($Registro->_Conexao===false){
            $Registro->_Conexao = new \Framework\App\Conexao();
        }
        if($Registro->_Request===false){
            $Registro->_Request = new \Framework\App\Request();
        }
        
        // Recupera pra evitar multiplas solicitacoes
        $getmetodo          = $Registro->_Request->getMetodo();
        $getmodulo          = $Registro->_Request->getModulo();
        $getsubmodulo       = $Registro->_Request->getSubModulo();
        $getargs            = $Registro->_Request->getArgs();
        $geturl             = $Registro->_Request->getURL();
        
        // Controle de Erros
        /*if(SISTEMA_DEBUG===true){
            // Controle de Erros
            ini_set('error_reporting', 'E_ALL');
            ini_set('display_errors', 'On');
        }else{
            // Controle de Erros
            ini_set('error_reporting', 'E_ALL & ~E_NOTICE');
            ini_set('display_errors', 'Off');
            ini_set('memory_limit','512M');
            ini_set('log_errors', 1);
            ini_set('error_log', 'my_file.log');
        }*/
        // Configura Modulos
        $controle_Executar = $getmodulo.'_'.$getsubmodulo.'Controle';
        $modelo_Executar = $getmodulo.'_'.$getsubmodulo.'Modelo';
        $visual_Executar = $getmodulo.'_'.$getsubmodulo.'Visual';
        $modulo_rotaC    = MOD_PATH.$getmodulo.DS.$getmodulo.'_Controle.php';
        $modulo_rotaM    = MOD_PATH.$getmodulo.DS.$getmodulo.'_Modelo.php';
        $modulo_rotaV    = MOD_PATH.$getmodulo.DS.$getmodulo.'_Visual.php';
        $submodulo       = $getmodulo.'_'.$getsubmodulo.'Controle';
        $submodulo_rotaC = MOD_PATH.$getmodulo.DS.$getmodulo.'_'.$getsubmodulo.'C.php';
        $submodulo_rotaM = MOD_PATH.$getmodulo.DS.$getmodulo.'_'.$getsubmodulo.'M.php';
        $submodulo_rotaV = MOD_PATH.$getmodulo.DS.$getmodulo.'_'.$getsubmodulo.'V.php';
        $metodo          = $getmetodo;
        
        
        // Inicia SEssao e Classes PARTE 2
        $Registro->_Acl     = new \Framework\App\Acl();
        
        // Verifica Permissão da URL
        $permissao = $Registro->_Acl->Get_Permissao_Url($geturl);

        if($permissao===false){
            throw new \Exception('Sem Permissão: '.$geturl, 403); 
        }
        
        unset($tempo);
        
        // Verifica se Existe e Executa
        if(is_readable($modulo_rotaC) && is_readable($modulo_rotaM) && is_readable($modulo_rotaV)){
            if(is_readable($submodulo_rotaC) && is_readable($submodulo_rotaM) && is_readable($submodulo_rotaV)){
                // Chama Controle, Modelo, e Visual
                $Registro->_Modelo  = new $modelo_Executar;
                $Registro->_Visual  = new $visual_Executar;
                $Registro->_Controle = new $controle_Executar;
                
                if(REQUISICAO_TIPO=='MODELO'){
                    if(is_callable(array($Registro->_Modelo,$metodo))){
                        $metodo = $getmetodo;
                    }else{
                        $metodo = 'Main';
                    }
                    if(count($getargs)>0){
                        call_user_func_array(array($Registro->_Modelo,$metodo), $getargs);
                    }else{
                        call_user_func(array($Registro->_Modelo,$metodo));
                    }
                    // Impede Retorno do Json do Controle
                    \Framework\App\Controle::Tema_Travar();
                }else{
                    if(is_callable(array($Registro->_Controle,$metodo))){
                        $metodo = $getmetodo;
                    }else{
                        $metodo = 'Main';
                    }
                    if(count($getargs)>0){
                        call_user_func_array(array($Registro->_Controle,$metodo), $getargs);
                    }else{
                        call_user_func(array($Registro->_Controle,$metodo));
                    }
                    
                }
            }else{
                return _Sistema_erroControle::Erro_Fluxo('SubMódulo não Encontrado',404); //
            }
        }else{
            return _Sistema_erroControle::Erro_Fluxo('Módulo não Encontrado',404); //
        }
        
        return true;
    }
    /**
     * Desliga o Sistema, Fecha Todas as Classes e Instancias
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public static function Desligar(){
        $tempo = new \Framework\App\Tempo('BOOT Desligar');  
        // Destroi A PORRA TODA
        $Registro = &\Framework\App\Registro::getInstacia();
        $Registro->destruir('_Controle');
        $Registro->destruir('_Visual');
        $Registro->destruir('_Modelo');
        $Registro->destruir('_Acl');
        $Registro->destruir('_Request');
        // Imprimi Controle de Tempo se Pedido
        //if(TEMPO_IMPRIMIR) \Framework\App\Tempo::Imprimir();
        if(TEMPO_IMPRIMIR){
            \Framework\App\Tempo::Salvar();
        }
        // Fecha Conexao
        $Registro->destruir('_Conexao');
        
        // Salvar Cache e Da exite
        if(SISTEMA_CACHE_PAGINAS){
            $conteudo = ob_get_contents();
            $Registro->_Cache->Salvar('Pagina_'.self::$url,$conteudo);
        }
        
        // Da Exit
        exit;
    }
}
?>
