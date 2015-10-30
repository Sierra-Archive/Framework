<?php
namespace Framework\App\Resource\Validation;
class Cpf 
{  
    public static function Validates($cpf) {  
        if (strlen($cpf) === 14){
            return (bool) (self::calcDigVerif(
                    substr(
                        str_replace(
                            Array('.','-'),
                            '', 
                            $cpf
                        ),
                        0, 
                        9
                    )
                )==(
                    substr(
                        str_replace(
                            Array('.','-'), 
                            '', 
                            $cpf
                        ),
                        9, 
                        11
                    )
                )
            );       
        }
        if (strlen($cpf) !== 11) {
            return false;
        }
        return (bool) (self::calcDigVerif(substr($cpf,0, 9))==(substr($cpf,9, 11)));       
    }      
    
    public static function Generate() {       
        $iniciais = "";
        $numero;       
        for ($i = 0; $i < 9; $i++) {       
            $numero = (int) (rand(0,9));       
            $iniciais .= (string) $numero;       
        }       
        return $iniciais.self::calcDigVerif($iniciais);       
    }       
  
    
    public static function Transfer_Client($cpf) {
        if (strlen($cpf) !== 11) {
            return $cpf;
        } else {
            return (string) substr((string) $cpf,0, 3).'.'.substr((string) $cpf,3, 3).'.'.substr((string) $cpf,6, 3).'-'.substr((string) $cpf,9, 3);  
        } 
    }  
    
    public static function Transfer_Server($cpf) {       
        return (int) str_replace(Array('.','-'), '', $cpf);
    }
    
    private static function calcDigVerif($num) {    
   
        $soma = 0;
        $peso = 10;       
        for ($i = 0; $i < strlen($num); $i++) {     
            $soma += (int) ((substr($num,$i, $i + 1)) * $peso--);
        }

        if ($soma % 11 == 0 | $soma % 11 == 1)       
            $primDig = (int) (0);       
        else       
            $primDig = (int) (11 - ($soma % 11));       

        $soma = 0;       
        $peso = 11;       
        for ($i = 0; $i < strlen($num); $i++)       
               $soma += (int) (substr($num,$i, $i + 1)) * $peso--;       

        $soma += ((int)$primDig) * 2;       
        if ($soma % 11 == 0 | $soma % 11 == 1)       
            $segDig = 0;       
        else       
            $segDig = (int) (11 - ($soma % 11));       

        return (string) $primDig.$segDig;       
    }       

}  
?>