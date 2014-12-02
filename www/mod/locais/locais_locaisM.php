<?php

class locais_locaisModelo extends locais_Modelo
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
    * Inseri um Novo Tipo de Local
    * 
    * @name local_retorna
    * @access public
    * @static
    * 
    * @param Class &$modelo Ponteiro do Modelo
    * @param Array &$array Array Vazio Para Preenchimento via Ponteiro
    * 
    * @uses $tabsql
    * @return int $i Quantidades de Registros
    *
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 2.0
    */
    static function local_retorna(&$modelo, &$array){
        global $tabsql;
        $i = 0;
        $sql = $modelo->db->query('SELECT id, nome FROM '.MYSQL_SIS_LOCAIS.' WHERE deletado!=1');
        while($campo = $sql->fetch_object()){
            $array[$i]['id'] = $campo->id;
            $array[$i]['nome'] = $campo->nome;
            ++$i;
        }
        return $i;
    }
}
?>