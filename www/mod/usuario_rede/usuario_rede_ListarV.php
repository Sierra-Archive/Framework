<?php

class usuario_rede_ListarVisual extends usuario_rede_Visual
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
     *  Exbe de acordo com o nivel
     * @param type $array
     * @param type $nivel
     * @return type
     * 
     * @version 0.4.2
     */
    public function Show_RedeIndicadosNivel(&$array,$nivel = 1){
        $html = '';
        if($nivel==1){
            $nome = __('Primario');
            $link = '';
        }
        else if($nivel==2){
            $nome = __('Secundário');
        }
        else{
            $nome = __('Terciário');
        }
        // caso nao tenha nenhum indicado
        if($array==0){
            $html .= '<center><b><font color="#FF0000" size="5">Infelizmente nenhum '.$nome.' encontrado.</font></b></center>';            
        }
        // caso tenha algum indicado
        else{
            if(!empty($array)){
                  reset($array);
                  foreach ($array as $indice=>&$valor) {
                    $html .= '<div style="float:left; width:150px; text-align:center;">';
                        if($nivel!=3) $html .= '<a class="lajax" href="'.URL_PATH.'usuario_rede/Listar/Carrega_Indicados/'.$array[$indice]['id'].'/'.($nivel+1).'/" acao="">';
                        $html .= '<img width="50" src="'.WEB_URL.'img/icons/nivel_cliente'.$nivel.'.jpg" alt="'.__('Nivel de Indicação').'">';
                        if($nivel!=3) $html .= '</a>';
                        $html .= '<br>';
                        if($nivel!=3) $html .= '<a class="lajax" href="'.URL_PATH.'usuario_rede/Listar/Carrega_Indicados/'.$array[$indice]['id'].'/'.($nivel+1).'/" acao="">';
                        $html .= $array[$indice]['nome'];
                        if($nivel!=3) $html .= '</a>';
                    $html .= '</div>';
                  }
              }
              $html .= '<br><br><br><br>';
        }
        return $html;
    }
    
    
    /*
     * 
     * nao utilizado mais pelo projeto atual
     * 
     */
    /**
    * Html da tabela de Indicados
    * 
    * @name Show_RedeIndicados
    * @access public
    * 
    * @param Array $array Carrega Array com Indicados
    * 
    * @return string tabela::$retornatabela Retorna Tabela Preenchida com os Dados
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version
    */
    public function Show_RedeIndicados(&$array){
        $html = '';
        // caso nao tenha nenhum indicado
        if($array==0){
            $html .= '<center><b><font color="#FF0000" size="5">Infelizmente você ainda não indicou ninguem.</font></b></center>';            
        }
        // caso tenha algum indicado
        else{
            $tabela = new \Framework\Classes\Tabela();
            $tabela->addcabecario(array('Id','Nome')); 
            $this->Show_RedeIndicados_Recursiva($array, $tabela);
            $html = $tabela->retornatabela();
        }
        return $html;
    }
    /**
     * 
     * @param type $array
     * @param type $tabela
     * @param type $i
     * @param type $nivel
     * @return type
     */
    public function Show_RedeIndicados_Recursiva(&$array,&$tabela,$i=0,$nivel=0,$prenome = ''){
        $antecipa = $nivel;
        $nomeantes = '';
        $j = 0;
        while($antecipa>0){
            --$antecipa;
            $nomeantes = $nomeantes.'— ';
        }
        
        if($prenome=='') $prenome  = $array[$indice]['nome'];
        else             $prenome .= ' => ';
        
        if(!empty($array)){
              reset($array);
              foreach ($array as $indice=>&$valor) {
                /*if($nivel==0) $class = 'tbold tleft';
                else          $class = 'tleft backcolor';*/
                $class = 'tbold tleft';
                
                $tabela->addcorpo(array(
                    array("nome" => '#'.$array[$indice]['id']),
                    array("nome" => $prenome.$array[$indice]['nome'].' <img alt="'.__('Nivel da Indicação').' width="15" src="'.WEB_URL.'img/icons/nivel_cliente'.$array[$indice]['nivel_usuario'].'.jpg">', "class" => $class),
                ));
                ++$i;
                if(!empty($array[$j]['indicados'])){
                    $i = $this->Show_RedeIndicados_Recursiva($array[$j]['indicados'],$tabela,$i,$nivel+1,$prenome.$array[$indice]['nome']);
                }
                ++$j;
              }
          }
        return $i;
    }
}
?>