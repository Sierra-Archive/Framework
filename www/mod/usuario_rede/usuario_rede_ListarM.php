<?php

class usuario_rede_ListarModelo extends usuario_rede_Modelo
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
    * Função para Retornar Atividades Referentes
    * 
    * @name Indicados_Retorna
    * @access public
    * 
    * @param Array $rede Array Vazia Vinda como Ponteiro para Preenchimento com a rede Correspondente
    * 
    * @uses $tabsql
    * @uses MYSQL_USUARIO_AGENDA_ATIVIDADES
    * 
    * @return int $i Quantidades de Registros Retornada
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 0.4.2
    *//*#update
    public function Indicados_Retorna($antecessor=0, $nivel=0){
        $array = Array();
        $i =0;
        /*$where = Array(
            'deletado'      => 0,
            '!nivel_usuario'      => 0,
            'ativado'      => 1,
            'indicado_por'      => $antecessor,
        )
        $sql = $this->db->Sql_Select('Usuario',$where,0,'nome');
        *//*
        $sql = $this->db->query('SELECT U.id, U.nome,U.grupo FROM '.MYSQL_USUARIOS.' U WHERE U.deletado=0 AND U.grupo!='.CFG_TEC_IDCLIENTE.' AND U.ativado=1 AND U.indicado_por='.$antecessor.' ORDER BY U.nome');
        while($campo = $sql->fetch_object()){
            $array[$i]['id'] = $campo->id;
            $array[$i]['nome'] = $campo->nome;
            $array[$i]['grupo'] = $campo->grupo;
            if($nivel<2) $array[$i]['indicados'] = $this->Indicados_Retorna($campo->id, $nivel+1);
            ++$i;
        }
        if($i>0)        return $array; 
        else            return 0;
    }*/
}
?>