<?php
class biblioteca_Controle extends \Framework\App\Controle
{
    /**
    * Construtor
    * 
    * @name __construct
    * @access public
    *
    * @uses \Framework\App\Visual::$menu
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 0.4.2
    */
    public function __construct(){
        // construct
        parent::__construct();
    }
    static function Bibliotecas_AtualizaTamanho_Pai($parent=false){
        $Registro = &\Framework\App\Registro::getInstacia();
        if($parent===false) return false;
        if(!is_object($parent)){
            $parent = (int) $parent;
            if($parent<=0) return false;

            $pai = $Registro->_Modelo->db->Sql_Select('Biblioteca', '{sigla}id = '.$parent, 1);
            if($pai===false) return false;
        }else{
            $pai = $parent;
            $parent = (int) $pai->id;
        }
        
        // Tamanho inicial de bytes eh o tamanho da pasta
        $tamanho = strlen($pai->nome);
        
        // Soma Tamanho dos Filhos
        $biblioteca = $Registro->_Modelo->db->Sql_Select('Biblioteca', '{sigla}parent = '.$parent);
        if($biblioteca!==false){
            if(is_object($biblioteca)){
                $biblioteca = Array($biblioteca);
            }
            foreach($biblioteca as $valor){
                // Faz Recursividade com os Filhos
                if($valor->tipo==1){
                    $tamanho = $tamanho + self::Bibliotecas_AtualizaTamanho_Pai($valor->id);
                }
                $tamanho = $tamanho + $valor->tamanho;
            }
        }        
        
        // Atualiza Pai
        $pai->tamanho = $tamanho;
        $Registro->_Modelo->db->Sql_Update($pai);
        
        return $tamanho;
        // Atualiza Biblioteca
    }
}
?>