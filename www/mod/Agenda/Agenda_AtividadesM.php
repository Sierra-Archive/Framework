<?php

class Agenda_AtividadesModelo extends Agenda_Modelo
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
    * Função para Inserir Atividade
    * 
    * @name Atividade_inserir
    * @access public
    * 
    * @param datetime $dt_inicio
    * @param datetime $dt_fim
    * @param string $obs
    * @param int $local
    * @param int $categoria
    * 
    * @uses $config
    * @uses MYSQL_USUARIO_AGENDA_ATIVIDADES
    * 
    * @return int $id Retorna id da Atividade Inserida
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 2.0
    */
    public function Atividade_inserir($dt_inicio,$dt_fim,$obs,$local,$categoria){
        global $config;
        
        // verifica se contem subcategoria
        if(stripos($categoria, '-')){
            $categoria = explode('-',$categoria);
            $subcat = $categoria[1];
            $categoria = $categoria[0];
        }else{
            $subcat = 0;
        }
        
        $this->db->query('INSERT INTO '.MYSQL_USUARIO_AGENDA_ATIVIDADES.' (user,log_date_add,dt_inicio,dt_final,local, obs, categoria, categoria_sub) VALUES (\''.\Framework\App\Acl::Usuario_GetID_Static().'\',\''.APP_HORA.'\',\''.$dt_inicio.'\',\''.$dt_fim.'\',\''.$local.'\',\''.$obs.'\',\''.$categoria.'\',\''.$subcat.'\')');

        // retorna id inserido
        $sql = $this->db->query('SELECT id FROM '.MYSQL_USUARIO_AGENDA_ATIVIDADES.' WHERE deletado!=1 ORDER BY id DESC LIMIT 1');
        $campo = $sql->fetch_object();
        return $campo->id;
    }
    /**
    * Função para Retornar Atividades Referentes
    * 
    * @name Atividades_retorna
    * @access public
    * 
    * @param Array $Atividades Array Vazia Vinda como Ponteiro para Preenchimento com as Atividades Correspondentes
    * @param Date $data_inicial Data Inicial para Pesquisas das Atividades
    * @param Date $data_final Data Final para Pesquisas das Atividades
    * 
    * @uses MYSQL_USUARIO_AGENDA_ATIVIDADES
    * 
    * @return int $i Quantidades de Registros Retornada
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 2.0
    */
    public function Atividades_retorna(&$Atividades, $data_inicial, $data_final){
        $i = 0;
        $sql = $this->db->query('SELECT L.nome as LOCAL, A.dt_inicio, A.dt_final, A.obs FROM '.MYSQL_SIS_LOCAIS.' L JOIN '.MYSQL_USUARIO_AGENDA_ATIVIDADES.' A on (L.id=A.local) WHERE A.deletado!=1 AND A.dt_inicio>=\''.$data_final.'\' AND A.dt_final=\''.$data_inicial.'\'');
        while($campo = $sql->fetch_object()){
              $Atividades[$i]['dt_inicio'] = data_hora_eua_brasil($campo->dt_inicio);
              $Atividades[$i]['dt_fim'] = data_hora_eua_brasil($campo->dt_fim);
              $Atividades[$i]['obs'] = $campo->obs;
              $Atividades[$i]['local'] = $campo->LOCAL;
              ++$i;
        }
        return $i;
    }
}
?>
