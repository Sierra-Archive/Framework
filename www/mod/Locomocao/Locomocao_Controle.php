<?php
class Locomocao_Controle extends \Framework\App\Controle
{
    public function __construct(){
        // construct
        parent::__construct();
    } 
    
    /**
     * Retorna a Distancia e o Tempo para percorrer entre dois pontos
     *  
     * @param type $origem_pais
     * @param type $origem_estado
     * @param type $origem_cidade
     * @param type $origem_endereco
     * @param type $destino_pais
     * @param type $destino_estado
     * @param type $destino_cidade
     * @param type $destino_endereco
     * @param type $mode
     * @param type $language
     * @param type $sensor
     * 
     * @return Array
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public static function Retorna_Distancia($origem_pais,$origem_estado,$origem_cidade,$origem_endereco,$destino_pais,$destino_estado,$destino_cidade,$destino_endereco,$mode = 'CAR',$language = 'PT',$sensor = false){
        
        
        $xml = simplexml_load_file("http://maps.googleapis.com/maps/api/distancematrix/xml?origins=''".$origem."''|&destinations=''".$destino."''|&mode=''".$mode."''|&language=''".$language."''|&sensor=false");
        // Se nao Existir Retorna Falso
        var_dump($xml);
        if($xml->row->element->status!='OK'){
            return false;
        }
        return Array(
            'Tempo'=>Array(
                'Valor'=>(int) $xml->row->element->duration->value,
                'Texto'=>(string) $xml->row->element->duration->text
            ),
            'Distancia'=>Array(
                'Valor'=>(int) $xml->row->element->distance->value,
                'Texto'=>(string) $xml->row->element->distance->text
            )
        );
    }
}
?>