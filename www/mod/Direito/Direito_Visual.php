<?php
class DireitoVisual extends \Framework\App\Visual
{
    /**
    * Construtor
    * 
    * @name __construct
    * @access public
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 2.0
    */
    public function __construct(){
        parent::__construct();
    }
    /**
     * 
     * @param type $array
     * @return string
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    static function Show_TabMeusNumeros($array){
        
        $html = '<table>'.
            '<thead>'.
                '<tr>'.
                    '<th colspan="2">Meus Números</th>'.
                '</tr>'.
            '</thead>'.
            '<tbody>'.
                '<tr>'.
                    '<td class="backcolor tleft">Processos</td>'.
                    '<td class="tright">'.$array[0].'</td>'.
                '</tr>'.
                '<tr>'.
                    '<td class="backcolor tleft">Réus</td>'.
                    '<td class="tright">'.$array[1].'</td>'.
                '</tr>'.
                '<tr>'.
                    '<td class="backcolor tleft">Autores</td>'.
                    '<td class="tright">'.$array[2].'</td>'.
                '</tr>'.
            '</tbody>'.
        '</table>';
        return $html;
    }
}
?>