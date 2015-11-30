<?php
namespace Framework\App\System\Info\Login;

use Framework\App\Registro;
use Framework\App\System\Info\Config;

class Acesso
{
    protected $_register;
    public function __construct($usuario)
    {
        $this->_register = &Registro::getInstacia();
        $timeDelete = time()-(30*60); //30 Minutos
        $updateConfigSystem = true;
        
        //Apaga Todos Anteriores
        $open = $this->_register->_Conexao->Sql_Select(
            'Log_Login',
            '({sigla}dt_saida=\'0000-00-00 00:00:00\' OR {sigla}dt_saida is NULL) AND {sigla}time<=\''.$timeDelete.'\''
        );
        if (is_object($open)) {
            $open = Array($open);
        }
        if ($open!==false) {
            foreach ($open as &$value) {
                $value->dt_saida = APP_HORA_BR;
            }
            $this->_register->_Conexao->Sql_Update(
                $open
            );
        }
        
        // Cria Log de Acesso
        $logLogin = new \Log_Login_DAO();
        $logLogin->ip = isset($_SERVER['REMOTE_ADDR']) ? strtolower($_SERVER['REMOTE_ADDR']) : 'Desconhecido';
        $logLogin->login = $usuario;
        $logLogin->dt_entrada = APP_HORA_BR;
        $logLogin->dt_atualizado = APP_HORA_BR;
        $logLogin->time = time();
        $this->_register->_Conexao->Sql_Insert(
            $logLogin
        );
        
        //Busca VErsao do Sistema
        list($compatibility,$improvement,$bug) = Config::getVersion(SISTEMA_CFG_VERSION);
        $releaseVersion = Config::getRelease($compatibility, $improvement, $bug);
        
        // Busca Config Sistema
        $configSystemNew = false;
        $configSystem = $this->_register->_Conexao->Sql_Select(
            'Sistema_Config_Public',
            '{sigla}usuario=\'0\' AND {sigla}chave=\'systemVersion\'',
            1
        );
        if ($configSystem===false) {
            $configSystem = new \Sistema_Config_Public_DAO();
            $configSystem->usuario = '0';
            $configSystem->valor = '0';
            $configSystem->chave = 'systemVersion';
            $configSystemNew = true;
            list($compatibilityOlder, $improvementOlder, $bugOlder) = Array(0,0,0);
        }else{
            list($compatibilityOlder, $improvementOlder, $bugOlder) = Config::getReleaseReverse($configSystem->valor);
        }
        $configSystemVersion = $configSystem->valor;
        
        // Busca Config Usuario
        $configUserNew = false;
        $configUser = $this->_register->_Conexao->Sql_Select(
            'Sistema_Config_Public',
            '{sigla}usuario=\''.$usuario.'\' AND {sigla}chave=\'systemVersion\''
        );
        if ($configUser===false) {
            $configUser = new \Sistema_Config_Public_DAO();
            $configUser->usuario = $usuario;
            $configUser->valor = '0';
            $configUser->chave = 'systemVersion';
            $configUserNew = true;
        }
        $configUserVersion = $configUser->valor;
        
        // Notificacao do Usuario
        if ($releaseVersion>$configUserVersion) {
            $notification = new \Usuario_Notificacao_DAO();
            $notification->nome = __('O sistema foi atualizado para a versão: '.$compatibility.'.'.$improvement.'.'.$bug.'');
            $notification->usuario = $usuario;
            $notification->url = '_Sistema/Principal/Release';
            $notification->lido = '0';
            $this->_register->_Conexao->Sql_Insert($notification);
            
            //Update
            $configUser->valor = $releaseVersion;
            if ($configUserNew) {
                $this->_register->_Conexao->Sql_Insert($configUser);
            } else {
                $this->_register->_Conexao->Sql_Update($configUser);
            }
        }
        
        // Manutencao do Sistema
        if ($releaseVersion>$configSystemVersion) {
            
            //Update
            $configSystem->valor = $releaseVersion;
            // Pega Todos os Modulos
            $modulos = config_modulos();
            // Pra cada Modulo Executa A manutenção necessaria
            foreach ($modulos as $value) {
                $class = $value.'_Principal';
                if (is_callable(array($class, 'maintenance'))) {
                    if ($class::maintenance($compatibilityOlder, $improvementOlder, $bugOlder) === false) {
                        $updateConfigSystem = false;
                    }
                }
            }
            
            if($updateConfigSystem===true) {
                // Atualiza Config
                if ($configSystemNew) {
                    $this->_register->_Conexao->Sql_Insert($configSystem);
                } else {
                    $this->_register->_Conexao->Sql_Update($configSystem);
                }
            }
        }
        
        return true;
    }
    public static function update($id)
    { 
        // dt_saida = '0000-00-00 00:00:00'
        // Cria Log de Acesso
        $logLogin = Registro::getInstacia()->_Conexao->Sql_Select(
            'Log_Login',
            '({sigla}dt_saida=\'0000-00-00 00:00:00\' OR {sigla}dt_saida is NULL) AND {sigla}login=\''.$id.'\'',
            1
        );
        if ($logLogin===false) {
            return false;
        }
        $logLogin->dt_atualizado = APP_HORA_BR;
        $logLogin->time = time();
        Registro::getInstacia()->_Conexao->Sql_Update(
            $logLogin
        );
        
        return true;
    }  
    public static function failed($login,$senha)
    { 
        // Cria Log de Acesso
        $logLogin = new \Log_Login_Falha_DAO();
        $logLogin->log_ip = isset($_SERVER['REMOTE_ADDR']) ? strtolower($_SERVER['REMOTE_ADDR']) : 'Desconhecido';
        $logLogin->log_dt = APP_HORA_BR;
        $logLogin->login = $login;
        $logLogin->senha = $senha;
        Registro::getInstacia()->_Conexao->Sql_Insert(
            $logLogin
        );
    }  
    public static function logout($id)
    {
        $open = Registro::getInstacia()->_Conexao->Sql_Select(
            'Log_Login',
            '({sigla}dt_saida=\'0000-00-00 00:00:00\' OR {sigla}dt_saida is NULL) AND {sigla}login=\''.$id.'\''
        );
        if (is_object($open)) {
            $open = Array($open);
        }
        if ($open!==false) {
            foreach ($open as &$value) {
                $value->dt_saida = APP_HORA_BR;
            }
            Registro::getInstacia()->_Conexao->Sql_Update(
                $open
            );
        }
        return true;
    }  
}