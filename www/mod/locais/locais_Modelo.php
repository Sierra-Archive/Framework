<?php
class locais_Modelo extends \Framework\App\Modelo
{
    public function __construct(){
        parent::__construct();
    }
    public function bairros_retorna(&$array,$cidade = 1){
        global $tabsql, $db;
        $i = 0;
        $sql = $db->query('SELECT id, nome FROM '.MYSQL_SIS_LOCALIZACAO_BAIRROS.' WHERE deletado!=1 AND cidade='.$cidade.' ORDER BY nome');
        while($campo = $sql->fetch_object()){
            $array[$i]['valor'] = $campo->id;
            $array[$i]['nome'] = $campo->nome;
            ++$i;
        }
        return $i;
    }
    public function cidades_retorna(&$array,$estado = 1){
        global $tabsql, $db;
        $i = 0;
        $sql = $db->query('SELECT id, nome FROM '.MYSQL_SIS_LOCALIZACAO_CIDADES.' WHERE deletado!=1 AND estado='.$estado.' ORDER BY nome');
        while($campo = $sql->fetch_object()){
            $array[$i]['valor'] = $campo->id;
            $array[$i]['nome'] = $campo->nome;
            ++$i;
        }
        return $i;
    }
    public function estados_retorna(&$array,$estado = 1){
        global $tabsql, $db;
        $i = 0;
        $sql = $db->query('SELECT id, nome FROM '.MYSQL_SIS_LOCALIZACAO_ESTADOS.' WHERE deletado!=1 AND pais='.$estado.' ORDER BY nome');
        while($campo = $sql->fetch_object()){
            $array[$i]['valor'] = $campo->id;
            $array[$i]['nome'] = $campo->nome;
            ++$i;
        }
        return $i;
    }
    public function paises_retorna(&$array){
        global $tabsql, $db;
        $i = 0;
        $sql = $db->query('SELECT id, nome FROM '.MYSQL_SIS_LOCALIZACAO_PAIZES.' WHERE deletado!=1 ORDER BY nome');
        while($campo = $sql->fetch_object()){
            $array[$i]['valor'] = $campo->id;
            $array[$i]['nome'] = $campo->nome;
            ++$i;
        }
        return $i;
    }
}
?>