<?php
class usuario_Visual extends \Framework\App\Visual
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
    * @version 0.4.2
    */
    public function __construct(){
        parent::__construct();
    } 
    static function Show_TabStatusPlano(&$array){
        
        $html = '<table>'.
            '<thead>'.
                '<tr>'.
                    '<th colspan="2">Plano</th>'.
                '</tr>'.
            '</thead>'.
            '<tbody>'.
                '<tr>'.
                    '<td class="backcolor tleft">Seu plano é:</td>'.
                    '<td class="tright">'.$array['plano'].'</td>'.
                '</tr>';
                if($array['alterar']!=''){
                    $html .= '<tr>'.
                        '<td class="backcolor tleft">Mudar de Plano</td>'.
                        '<td class="tright">'.$array['alterar'].'</td>'.
                    '</tr>';
                }
                $html .= '<tr>'.
                    '<td class="backcolor tleft">Status</td>'.
                    '<td class="tright">'.$array['status'].'</td>'.
                '</tr>'.
            '</tbody>'.
        '</table>';
        return $html;
    }
}
?>