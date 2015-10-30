<?php
class usuario_rede_Modelo extends \Framework\App\Modelo
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
    * Funcao que retorna tabela de valores da rede
    * 
    * @name Retorna_num_Indicados
    * @access public
    * @static
    * 
    * @param Class $Modelo Carrega Class Modelo
    * @param int $user id do usuario a trazer numero de indicados
    * 
    * 
    * @return array $indicados Array com os valores da rede
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 0.4.2
    */
    static function Retorna_num_Indicados($Modelo, $user) {
        // zera contadores
        $indicados['primario'] = 0;
        $indicados['secundario'] = 0;
        $indicados['terciario'] = 0;
        $indicados['associado'] = Array();
        $indicados['total'] = 0;
        // faz busca pelos primarios
        $sql = $Modelo->db->query('SELECT id,grupo FROM '.MYSQL_USUARIOS.' WHERE deletado=0 AND ativado=1 AND indicado_por=\''.$user.'\'');
        while ($campo = $sql->fetch_object()) {
            $indicados['primario'] = $indicados['primario']+1;
            $indicados['total'] = $indicados['total']+1;
            $indicado_id1 = $campo->id;
            $indicado_nivel1 = $campo->grupo;
            if (!isset($indicados['associado'][$indicado_nivel1])) $indicados['associado'][$indicado_nivel1] = 0;
            $indicados['associado'][$indicado_nivel1] = $indicados['associado'][$indicado_nivel1] + 1;
            // faz busca pelos secundarios
            $sql2 = $Modelo->db->query('SELECT id,grupo FROM '.MYSQL_USUARIOS.' WHERE deletado=0 AND ativado=1 AND indicado_por=\''.$indicado_id1.'\'');
            while ($campo2 = $sql2->fetch_object()) {
                $indicados['secundario'] = $indicados['secundario']+1;
                $indicados['total'] = $indicados['total']+1;
                $indicado_id2 = $campo2->id;
                $indicado_nivel2 = $campo2->grupo;
                if (!isset($indicados['associado'][$indicado_nivel2])) $indicados['associado'][$indicado_nivel2] = 0;
                $indicados['associado'][$indicado_nivel2] = $indicados['associado'][$indicado_nivel2] + 1;
                // faz busca pelos terciarios
                $sql3 = $Modelo->db->query('SELECT id,grupo FROM '.MYSQL_USUARIOS.' WHERE deletado=0 AND ativado=1 AND indicado_por=\''.$indicado_id2.'\'');
                while ($campo3 = $sql3->fetch_object()) {
                    $indicados['terciario'] = $indicados['terciario']+1;
                    $indicados['total'] = $indicados['total']+1;
                    $indicado_id3 = $campo3->id;
                    $indicado_nivel3 = $campo3->grupo;
                    if (!isset($indicados['associado'][$indicado_nivel3])) $indicados['associado'][$indicado_nivel3] = 0;
                    $indicados['associado'][$indicado_nivel3] = $indicados['associado'][$indicado_nivel3] + 1;
                }
            }
        }
        return $indicados;
    }
    /**
     * Fornece ranking dos PRimarios
     * @static
     * 
     * @param type $ranking
     * @return int
     */
    /**#update
    static function Ranking_primarios(&$ranking,&$Modelo) {
        $i = 0;
        $sql = $Modelo->db->query('SELECT U.id, U.nome, count(*) as PRIMARIO FROM '.MYSQL_USUARIOS.' U INNER JOIN '.MYSQL_USUARIOS.' US ON U.id=US.indicado_por WHERE US.deletado=0 AND US.ativado=1 AND U.grupo!='.CFG_TEC_IDCLIENTE.' AND US.grupo!='.CFG_TEC_IDCLIENTE.' AND  U.deletado=0 AND U.ativado=1 GROUP BY US.indicado_por ORDER BY PRIMARIO DESC');
        $total = $Modelo->db->Sql_Select('Usuario');
        if (is_object($total)) $total = Array($total);
        $total = count($total);
        while ($campo = $sql->fetch_object()) {
            $ranking[$i]['id'] = $campo->id;
            $ranking[$i]['nome'] = $campo->nome;
            //$ranking[$i]['PRIMARIO'] = $campo->PRIMARIO;
            $ranking[$i]['PRIMARIO'] = number_format($campo->PRIMARIO/$total*100, 2, ',', ' ');
            ++$i;
        }
        return $i;
    }
     * 
     */
}
?>