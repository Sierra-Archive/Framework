<?php
namespace Framework\App\Resource\Validation;
class Cpf 
{  
    public static function Validates($cpf) {       
        if (strlen($cpf) != 11)       
            return false;   
        $numDig = substr($cpf,0, 9);       
        return (bool) (self::calcDigVerif($numDig)==(substr($cpf,9, 11)));       
    }  
    
    public static function Generate() {       
        $iniciais = "";       
        $numero;       
        for ($i = 0; $i < 9; $i++) {       
            $numero = (int) (rand(0,1) * 10);       
            $iniciais += (string) $numero;       
        }       
        return $iniciais + self::calcDigVerif($iniciais);       
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