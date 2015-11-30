<?php
namespace Framework\App\System\Info;

use Framework\App\Registro;

class Config
{
    protected $_registro;
    public function __construct()
    {
        $this->_register = &Registro::getInstacia();
        // Cria Log de Acesso
        
        
        
    }
    public static function getVersion($version)
    { 
        $versionExplode = explode('.', $version);
        return Array((int) $versionExplode[0], (int) $versionExplode[1], (int) $versionExplode[2]);
    }  
    public static function getRelease($compatibility,$improvement,$bug)
    { 
        return (($compatibility*1000*1000)+($improvement*1000)+$bug);
    }  
    public static function getReleaseReverse($version)
    {
        $compatibility = (int) ($version/1000000);
        $improvement = (int) (($version%1000000)/1000);
        $bug = (int) ($version-($compatibility*1000000)-($improvement*1000));
        return Array($compatibility,$improvement,$bug);
    }  
}