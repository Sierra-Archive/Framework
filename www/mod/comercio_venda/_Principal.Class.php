<?php

class comercio_venda_Principal implements PrincipalInterface
{
    /**
    * Função Home para o modulo comercio_venda aparecer na pagina HOME
    * 
    * @name Home
    * @access public
    * @static
    * 
    * @param Class &$controle Classe Controle Atual passada por Ponteiro
    * @param Class &$modelo Modelo Passado por Ponteiro
    * @param Class &$Visual Visual Passado por Ponteiro
    *
    * @uses \Framework\App\Controle::$comercio_venda
    * 
    * @return void 
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 2.0
    */
    static function Home(&$controle, &$modelo, &$Visual){
        $html = '';
        $i = 1;
        $j = 0;
        
        // Mesas Ocupadas
        $mesas_ocupadas = Array();
        
        // Faz Busca Por Carrinhos Abertos
        $where = '(data_fechada=\'0000-00-00 00:00:00\' || data_fechada=\'\')';
        $carrinhos = $modelo->db->Sql_Select('Comercio_Venda_Carrinho');
        if(is_object($carrinhos)) $carrinhos = Array($carrinhos);
        if($carrinhos!==false && !empty($carrinhos)){
            foreach($carrinhos as &$valor){
                // SE nao for Balcao Adiciona a Mesa Ocupada
                if($valor->mesa!='' && $valor->mesa!=0){
                    $mesas_ocupadas[$valor->mesa] = Array(
                        'Pago'=>$valor->pago,
                        'Valor'=>$valor->valor,
                    );
                }else{
                    // Faz o Html da Parada
                    $cor = 'important';
                    $numero = $valor->valor;
                    $html .= '<a data-original-title="Novo Caixa" 
                        href="http://localhost/Framework/comercio_venda/Carrinho/Carrinhos_Add?popup=true" 
                        data-toggle="tooltip" data-placement="bottom" acao="" class="icon-btn span3 lajax">
                        <i class="icon-food"></i>
                        <div>Balcão '.$i.'</div>
                        <span class="badge badge-'.$cor.'">'.$numero.'</span>
                    </a>';
                    ++$i ;
                
                    // Contador por Linha
                    ++$j;
                    if($j>=4){
                        $j = 0;
                        $html .= '</div><div class="row-fluid">';
                    }
                }
            }
        }
        
        // FAz BUsca Por Todas as Mesas
        $mesas = $modelo->db->Sql_Select('Comercio_Venda_Mesa');
        if(is_object($mesas)) $mesas = Array($mesas);
        if($mesas!==false && !empty($mesas)){
            foreach($mesas as &$valor){
                
                // SE Tiver Aberta Bota ali
                if(isset($mesas_ocupadas[$valor->id]) && $mesas_ocupadas[$valor->id]!==false){
                    $cor = 'important';
                    $numero = $mesas_ocupadas[$valor->id]['Valor'];
                }else{
                    $cor = 'success';
                    $numero = 'R$ 0,00';
                }
                
                // Faz o Html da Parada
                $html .= '<a data-original-title="Novo Caixa" 
                        href="http://localhost/Framework/comercio_venda/Carrinho/Carrinhos_Add?popup=true" 
                        data-toggle="tooltip" data-placement="bottom" acao="" class="icon-btn span3 lajax">
                        <i class="icon-food"></i>
                    <div>'.$valor->nome.'</div>
                    <span class="badge badge-'.$cor.'">'.$numero.'</span>
                </a>';
                
                // Contador por Linha
                ++$j;
                if($j>=4){
                    $j = 0;
                    $html .= '</div><div class="row-fluid">';
                }
            }
        }
        
        
        if($html===''){
            return false;
        }
        
        /*<a href="#" class="icon-btn span2">
                <i class="icon-barcode"></i>
                <div>Products</div>
                <span class="badge badge-success">4</span>
            </a>
            <a href="#" class="icon-btn span2">
                <i class="icon-reorder"></i>
                <div>Reports</div>
            </a>
            <a href="#" class="icon-btn span2">
                <i class="icon-sitemap"></i>
                <div>Categories</div>
            </a>
            <a href="#" class="icon-btn span2">
                <i class="icon-calendar"></i>
                <div>Calendar</div>
                <span class="badge badge-success">4</span>
            </a>
            <a href="#" class="icon-btn span2">
                <i class="icon-envelope"></i>
                <div>Inbox</div>
                <span class="badge badge-info">12</span>
            </a>*/
        
        $html = '<div class="row-fluid">
            '.$html.'
        </div>';
        // Acrescenta na Tela
        $Visual->Blocar($html);
        $Visual->Bloco_Maior_CriaJanela('Mesas');
        
        return true;
    }
    static function Widget(&$_Controle){
        $_Controle->Widget_Add('Superior',
        '<li class="dropdown mtop5">'.
            '<a class="dropdown-toggle element lajax" acao="" data-placement="bottom" data-toggle="tooltip" href="'.URL_PATH.'comercio_venda/Carrinho/Carrinhos_Add" data-original-title="Novo Caixa">'.
                '<i class="icon-shopping-cart"></i>'.
            '</a>'.
        '</li>');
    }
    static function Busca(&$controle, &$modelo, &$Visual,$busca){
        return false;
    }
    static function Config(){
        return false;
    }

    public static function Estatistica($data_inicio, $data_final, $filtro = false) {
        return false;
    }

    public static function Relatorio($data_inicio, $data_final, $filtro = false) {
        return false;
    }

}
?>