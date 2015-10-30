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
    public function __construct() {
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
    */#update
    public function Indicados_Retorna($antecessor=0, $nivel=0) {
        $array = Array();
        $i =0;
        $where = Array(
            '!grupo'      => CFG_TEC_IDCLIENTE,
            'ativado'      => 1,
            'indicado_por'      => $antecessor,
        );
        $registros = $this->db->Sql_Select('Usuario',$where,0,'id,nome,grupo');
        if (is_object($registros)) $registros = Array($registros);
        if ($registros!==false) {
            foreach($registros as &$campo) {
                $array[$i]['id'] = $campo->id;
                $array[$i]['nome'] = $campo->nome;
                $array[$i]['grupo'] = $campo->grupo;
                if ($nivel<2) $array[$i]['indicados'] = $this->Indicados_Retorna($campo->id, $nivel+1);
                ++$i;
            }
        }
        if ($i>0)        return $array; 
        else            return 0;
    }
}
?>