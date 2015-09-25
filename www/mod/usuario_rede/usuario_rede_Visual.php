<?php
class usuario_rede_Visual extends \Framework\App\Visual
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
    /**
    * Html da tabela dos valores da rede
    * 
    * @name Show_TabRedeIndicados
    * @access public
    * 
    * @param Array $array Carrega Array com valores
    * 
    * @return string tabela::$retornatabela Retorna Tabela Preenchida com os Dados
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version
    */
    static function Show_TabRedeIndicados(&$array){
        
        $html = '<table>'.
            '<thead>'.
                '<tr>'.
                    '<th colspan="2">Minha Rede</th>'.
                '</tr>'.
            '</thead>'.
            '<tbody>'.
                '<tr>'.
                    '<td class="backcolor tleft">Primários</td>'.
                    '<td class="tright">'.$array['primario'].'</td>'.
                '</tr>'.
                '<tr>'.
                    '<td class="backcolor tleft">Secundários</td>'.
                    '<td class="tright">'.$array['secundario'].'</td>'.
                '</tr>'.
                '<tr>'.
                    '<td class="backcolor tleft">Terciários</td>'.
                    '<td class="tright">'.$array['terciario'].'</td>'.
                '</tr>'.
                '<tr>'.
                    '<td class="backcolor tleft tbold">Total</td>'.
                    '<td class="tright tbold">'.$array['total'].'</td>'.
                '</tr>'.
                '<tr>'.
                    '<td colspan="2" class="backcolor tcenter tbold">Niveis</td>'.
                '</tr>'.
                '<tr>'.
                    '<td class="backcolor tleft">Master</td>'.
                    '<td class="tright">'.$array['associado_nivel_1'].'</td>'.
                '</tr>'.
                '<tr>'.
                    '<td class="backcolor tleft">Bronze</td>'.
                    '<td class="tright">'.$array['associado_nivel_2'].'</td>'.
                '</tr>'.
                '<tr>'.
                    '<td class="backcolor tleft">Prata</td>'.
                    '<td class="tright">'.$array['associado_nivel_3'].'</td>'.
                '</tr>'.
                '<tr>'.
                    '<td class="backcolor tleft">Gold</td>'.
                    '<td class="tright">'.$array['associado_nivel_4'].'</td>'.
                '</tr>'.
                '<tr>'.
                    '<td class="backcolor tleft">Platinum</td>'.
                    '<td class="tright">'.$array['associado_nivel_5'].'</td>'.
                '</tr>'.
            '</tbody>'.
        '</table>';
        return $html;
    }
}
?>