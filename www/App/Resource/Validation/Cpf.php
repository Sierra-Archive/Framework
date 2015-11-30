<?php
namespace Framework\App\Resource\Validation;
class Cpf 
{  
    public static function Validates($cpf) { 
        if (strlen($cpf) === 14) {
            return (bool) (
                self::calcDigVerif(
                    substr(
                        str_replace(
                            Array('.', '-'),
                            Array('', ''),
                            $cpf
                        ),
                        0, 
                        9
                    )
                )==(
                    substr(
                        str_replace(
                            Array('.', '-'), 
                            Array('', ''),
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
        return (bool) (
            self::calcDigVerif(substr($cpf, 0, 9))==(substr($cpf, 9, 11))
        );       
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
        return (int) str_replace(Array('.', '-'), '', $cpf);
    }
    
    public static function calcDigVerif($cpf) {   
        //Pega Somente os NUmeros
        $num = str_replace(
            Array('.', '-'),
            Array('', ''),
            $cpf
        );
   
        // Primeiro Digito
        $soma1 = 0;
        $peso1 = 10;       
        for ($i = 0; $i < strlen($num); $i++) {     
            $soma1 += (int) ((substr($num, $i, 1)) * $peso1 );
            $peso1 = $peso1 - 1;
        }
        if ($soma1 % 11 == 0 || $soma1 % 11 == 1){ 
            $primDig = (int) (0);       
        } else {
            $primDig = (int) (11 - ($soma1 % 11)); 
        }
   
        
        // Segundo Digito
        $soma2 = 0;       
        $peso2 = 11;       
        for ($i = 0; $i < strlen($num); $i++){   
            $soma2 += ( ( (int) substr($num, $i, 1)) * $peso2 );
            $peso2 = $peso2 - 1;
        }
        $soma2 += (( (int) $primDig ) * $peso2); 
        if ($soma2 % 11 == 0 || $soma2 % 11 == 1) {      
            $segDig = 0;       
        } else {
            $segDig = (int) (11 - ($soma2 % 11));   
        }

        return (string) $primDig.$segDig;       
    }       

}  
