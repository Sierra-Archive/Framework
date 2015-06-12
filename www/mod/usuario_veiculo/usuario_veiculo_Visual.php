<?php
class usuario_veiculo_Visual extends \Framework\App\Visual
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
     * @name Marcas_ShowSelect
     * 
     * @global type $language
     * @param type $array
     * @param type $form
     * @return type
     */
    static function Marcas_ShowSelect(&$array,&$form,$padrao=0){
    	
        
    	if($padrao==0) $form->Select_Opcao('Selecione uma Marca',0,1);
        else           $form->Select_Opcao('Selecione uma Marca',0,0);
            
    	if(!empty($array)){
            reset($array);
            foreach ($array as $indice=>&$valor) {
                if($padrao==$array[$indice]['id']) $selecionado = 1;
                else                               $selecionado = 0;
                $form->Select_Opcao($array[$indice]['nome'],$array[$indice]['id'],$selecionado);
                ++$i;
            }
    	}
    	return $i;
    }
    /**
     * 
     * @global type $language
     * @param type $array
     * @return type
     */
    static function Marcas_ShowSelectAjax(&$array){
    	
    	$html = '';
    	$html .= \Framework\Classes\Form::Select_Opcao_Stat('Selecione uma Marca',0,0);
    	if(!empty($array)){
    		reset($array);
    		foreach ($array as $indice=>&$valor) {
    			$html .= \Framework\Classes\Form::Select_Opcao_Stat($array[$indice]['nome'],$array[$indice]['id'],0);
    		}
    	}
    	return $html;
    }
}
?>