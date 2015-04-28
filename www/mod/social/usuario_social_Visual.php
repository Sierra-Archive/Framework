<?php
class social_Visual extends \Framework\App\Visual
{
    public function __construct(){
        parent::__construct();
    } 
    static function Usuario_social_ShowSelect(&$array,&$form){
    	global $language;
    	
    	$form->Select_Opcao($language['social']['form'],0,0);
    	if(!empty($array)){
            reset($array);
            foreach ($array as $indice=>&$valor) {
                $form->Select_Opcao($array[$indice]['nome'],$array[$indice]['id'],0);
                ++$i;
            }
    	}
    	return $i;
    }
}
?>