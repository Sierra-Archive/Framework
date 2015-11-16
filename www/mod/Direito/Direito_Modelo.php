<?php

class DireitoModelo extends \Framework\App\Modelo
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
    public $campos = Array();
    public function __construct() {
        parent::__construct();
    }
    /**
     * Lista todos os dados de certo campo em Certa tabela
     * 
     * @param type $table
     * @param type $table_campo
     * @param type $resultado
     * @return int
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Listar($table, $table_campo, &$resultado) {
        $i = 0;
        $sql = $this->db->query('SELECT id,'.$table_campo.'
        FROM '.$table.' WHERE deletado!=1 ORDER BY '.$table_campo.''); //P.categoria
        while ($campo = $sql->fetch_object()) {
            $resultado[$i]['id'] = $campo->id;
            eval('$resultado[$i][$table_campo] = $campo->'.$table_campo.';');
            ++$i;
        }
        return $i;
    }
    /**
     * Tras qnt de Linhas de certa Tabela
     * 
     * @param type $table
     * @return int
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Contar($table) {
        $i = 0;
        $sql = $this->db->query('SELECT id
        FROM '.$table.' WHERE deletado!=1');
        while ($campo = $sql->fetch_object()) {
            ++$i;
        }
        return $i;
    }
}
