<?php
namespace Framework\App;
class Boot {
    public static function Iniciar(){     
        $tempo = new \Framework\App\Tempo('BOOT Iniciar');   
        // Inicia SEssao e Classes PARTE 1
        \Framework\App\Session::init();
        $registro = &\Framework\App\Registro::getInstacia();
        $registro->_Cache   = new \Framework\App\Cache(CACHE_PATH);
        $registro->_Conexao = new \Framework\App\Conexao();
        $registro->_Request = new \Framework\App\Request();
        
        // Recupera pra evitar multiplas solicitacoes
        $getmetodo          = $registro->_Request->getMetodo();
        $getmodulo          = $registro->_Request->getModulo();
        $getsubmodulo       = $registro->_Request->getSubModulo();
        $getargs            = $registro->_Request->getArgs();
        $geturl             = $registro->_Request->getURL();
        
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
        $registro->_Modelo  = new $modelo_Executar;
        $registro->_Visual  = new $visual_Executar;
        $registro->_Acl     = new \Framework\App\Acl();
        
        // Verifica Permissão da URL
        $permissao = $registro->_Acl->Get_Permissao_Url($geturl);

        if($permissao===false){
            throw new \Exception('Sem Permissão', 2826); 
        }
        
        // Verifica se Existe e Executa
        if(is_readable($modulo_rotaC) && is_readable($modulo_rotaM) && is_readable($modulo_rotaV)){
            if(is_readable($submodulo_rotaC) && is_readable($submodulo_rotaM) && is_readable($submodulo_rotaV)){

                // Chama Controle
                $registro->_Controle = new $controle_Executar;
                if(is_callable(array($registro->_Controle,$metodo))){
                    $metodo = $getmetodo;
                }else{
                    $metodo = 'Main';
                }
                if(count($getargs)>0){
                    call_user_func_array(array($registro->_Controle,$metodo), $getargs);
                }else{
                    call_user_func(array($registro->_Controle,$metodo));
                }
            }else{
                throw new \Exception('SubMódulo não Encontrado', 404); //
            }
        }else{
            throw new \Exception('Módulo não Encontrado', 404); //
        }
    }
    public static function Desligar(){
        // Destroi A PORRA TODA
        $registro = &\Framework\App\Registro::getInstacia();
        $registro->destruir('_Controle');
        $registro->destruir('_Visual');
        $registro->destruir('_Modelo');
        $registro->destruir('_Acl');
        $registro->destruir('_Request');
        // Imprimi Controle de Tempo se Pedido
        //if(TEMPO_IMPRIMIR) \Framework\App\Tempo::Imprimir();
        if(TEMPO_IMPRIMIR){
            \Framework\App\Tempo::Salvar();
        }
        // Fecha Conexao
        $registro->destruir('_Conexao');
        exit;
    }
}
?>
