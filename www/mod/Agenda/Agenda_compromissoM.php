<?php

class Agenda_compromissoModelo extends Agenda_Modelo
{

    public function __construct(){
      parent::__construct();
    }
    public function compromisso_inserir($nome,$dt_inicio,$dt_fim,$descricao,$local){
        global $config;
        $this->db->query('INSERT INTO '.MYSQL_USUARIO_AGENDA_COMPROMISSOS.' (user,dt_inicio,dt_fim,nome,descricao,local,log_date_add) VALUES (\''.\Framework\App\Acl::Usuario_GetID_Static().'\',\''.$dt_inicio.'\',\''.$dt_fim.'\',\''.$nome.'\',\''.$descricao.'\',\''.$local.'\',\''.APP_HORA.'\')');
        return 1;
    }
    public function compromisso_retorna(&$array){
        $i = 0;
        $sql = $this->db->query('SELECT UAC.id, UAC.nome FROM '.MYSQL_USUARIO_AGENDA_COMPROMISSOS.' UAC WHERE deletado!=1');
        while($campo = $sql->fetch_object()){
              $array[$i]['id'] = $campo->id;
              $array[$i]['nome'] = $campo->nome;
              ++$i;
        }
        return $i;
    }
    public function compromisso_fullretorna(&$array){
        $i = 0;
        $sql = $this->db->query('SELECT LL.nome as LOCAL, UAC.id, UAC.nome, UAC.dt_inicio, UAC.dt_fim, UAC.descricao FROM '.MYSQL_SIS_LOCAIS.' LL JOIN '.MYSQL_USUARIO_AGENDA_COMPROMISSOS.' UAC on (LL.id=UAC.local) WHERE UAC.deletado!=1');
        while($campo = $sql->fetch_object()){
              $array[$i]['id'] = $campo->id;
              $array[$i]['nome'] = $campo->nome;
              $array[$i]['dt_inicio'] = data_hora_eua_brasil($campo->dt_inicio);
              $array[$i]['dt_fim'] = data_hora_eua_brasil($campo->dt_fim);
              $array[$i]['descricao'] = $campo->descricao;
              $array[$i]['local'] = $campo->LOCAL;
              ++$i;
        }
        return $i;
    }
    static function compromissos_retornaanteriores(&$modelo, &$array){
        $i = 0; 
        $sql = $modelo->db->query('SELECT LL.nome as LOCAL, UAC.id, UAC.nome, UAC.dt_inicio, UAC.dt_fim, UAC.descricao FROM '.MYSQL_SIS_LOCAIS.' LL JOIN '.MYSQL_USUARIO_AGENDA_COMPROMISSOS.' UAC on (LL.id=UAC.local) WHERE UAC.deletado!=1 AND UAC.dt_inicio<\''.APP_HORA.'\' ORDER BY UAC.dt_inicio DESC');
        while($campo = $sql->fetch_object()){
              $array[$i]['id'] = $campo->id;
              $array[$i]['nome'] = $campo->nome;
              $array[$i]['dt_inicio'] = data_hora_eua_brasil($campo->dt_inicio);
              $array[$i]['dt_fim'] = data_hora_eua_brasil($campo->dt_fim);
              $array[$i]['descricao'] = $campo->descricao;
              $array[$i]['local'] = $campo->LOCAL;
              ++$i;
        }
        return $i;
    }
    static function compromissos_retornaproximos(&$modelo, &$array){
        $i = 0;
        $sql = $modelo->db->query('SELECT LL.nome as LOCAL, UAC.id, UAC.nome, UAC.dt_inicio, UAC.dt_fim, UAC.descricao FROM '.MYSQL_SIS_LOCAIS.' LL JOIN '.MYSQL_USUARIO_AGENDA_COMPROMISSOS.' UAC on (LL.id=UAC.local) WHERE UAC.deletado!=1 AND UAC.dt_inicio>=\''.APP_HORA.'\' ORDER BY UAC.dt_inicio');
        while($campo = $sql->fetch_object()){
              $array[$i]['id'] = $campo->id;
              $array[$i]['nome'] = $campo->nome;
              $array[$i]['dt_inicio'] = data_hora_eua_brasil($campo->dt_inicio);
              $array[$i]['dt_fim'] = data_hora_eua_brasil($campo->dt_fim);
              $array[$i]['descricao'] = $campo->descricao;
              $array[$i]['local'] = $campo->LOCAL;
              ++$i;
        }
        return $i;
    }
    public function compromisso_fullretorna_unico($id){
        $array = array();
        $sql = $this->db->query('SELECT LL.nome as LOCAL, UAC.dt_inicio, UAC.dt_fim, UAC.descricao FROM '.MYSQL_SIS_LOCAIS.' LL JOIN '.MYSQL_USUARIO_AGENDA_COMPROMISSOS.' UAC on (LL.id=UAC.local) WHERE UAC.deletado!=1 AND UAC.id='.$id.' LIMIT 1');
        while($campo = $sql->fetch_object()){
              $array['dt_inicio'] = data_hora_eua_brasil($campo->dt_inicio);
              $array['dt_fim'] = data_hora_eua_brasil($campo->dt_fim);
              $array['descricao'] = $campo->descricao;
              $array['local'] = $campo->LOCAL;
        }
        return $array;
    }
}
?>
