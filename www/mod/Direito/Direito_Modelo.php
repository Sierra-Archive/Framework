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
     * @param type $tabela
     * @param type $tabela_campo
     * @param type $resultado
     * @return int
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Listar($tabela,$tabela_campo, &$resultado) {
        $i = 0;
        $sql = $this->db->query('SELECT id,'.$tabela_campo.'
        FROM '.$tabela.' WHERE deletado!=1 ORDER BY '.$tabela_campo.''); //P.categoria
        while ($campo = $sql->fetch_object()) {
            $resultado[$i]['id'] = $campo->id;
            eval('$resultado[$i][$tabela_campo] = $campo->'.$tabela_campo.';');
            ++$i;
        }
        return $i;
    }
    /**
     * Tras qnt de Linhas de certa Tabela
     * 
     * @param type $tabela
     * @return int
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Contar($tabela) {
        $i = 0;
        $sql = $this->db->query('SELECT id
        FROM '.$tabela.' WHERE deletado!=1');
        while ($campo = $sql->fetch_object()) {
            ++$i;
        }
        return $i;
    }
}
?>