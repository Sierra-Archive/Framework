<?php
class usuario_veiculo_Modelo extends \Framework\App\Modelo
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
    * Retorna todos os veiculos
    * 
    * @name retorna_veiculos
    * @access public
    * 
    * @uses $tabsql
     * @uses MYSQL_USUARIO_VEICULO_MARCAS
    * @uses MYSQL_USUARIO_VEICULO
    * @uses \Framework\App\Modelo::$usuario
    * @uses \Framework\App\Modelo::$db
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 0.4.2
    */
    public function retorna_veiculos(&$veiculos, $categoriasdividir = FALSE) {
        GLOBAL $tabsql;
        if ($categoriasdividir === TRUE) $i = Array();
        else                          $i = 0;
        $sql = $this->db->query(' SELECT C.nome AS CATEGORIA, V.id, V.foto, V.ano, V.modelo, M.nome as MARCA, V.cc, V.valor1, V.valor2, V.valor3, V.franquia
        FROM '.MYSQL_USUARIO_VEICULO.' V, '.MYSQL_CAT.' C, '.MYSQL_USUARIO_VEICULO_MARCAS.' M
        WHERE V.deletado=0 && V.categoria=C.id && V.marca=M.id ORDER BY V.cc'); //P.categoria
        while ($campo = $sql->fetch_object()) {
            if ($categoriasdividir === TRUE) {
                if (!isset($i[$campo->CATEGORIA])) $i[$campo->CATEGORIA]=0;
                $vei = &$veiculos[$campo->CATEGORIA][$i[$campo->CATEGORIA]];
            } else {
                $vei = &$veiculos[$i];
            }
            
            $vei['id'] = $campo->id;
            $vei['foto'] = $campo->foto;
            $vei['categoria'] = $campo->CATEGORIA;
            $vei['ano'] = $campo->ano;
            $vei['modelo'] = $campo->modelo;
            $vei['marca'] = $campo->MARCA;
            $vei['cc'] = $campo->cc;
            $vei['valor1'] = $campo->valor1;
            $vei['valor2'] = $campo->valor2;
            $vei['valor3'] = $campo->valor3;
            $vei['franquia'] = $campo->franquia;
            if ($categoriasdividir === TRUE)   ++$i[$campo->CATEGORIA];
            else                            ++$i;
        }
        return $i;
        
    }
    /**
    * Retorna apenas um veiculo
    * 
    * @name retorna_veiculo
    * @access public
    * 
    * @uses $tabsql
     * @uses MYSQL_USUARIO_VEICULO_MARCAS
    * @uses MYSQL_USUARIO_VEICULO
    * @uses \Framework\App\Modelo::$usuario
    * @uses \Framework\App\Modelo::$db
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 0.4.2
    */
    public function retorna_veiculo($id) {
        GLOBAL $tabsql;
        if (!is_int($id) || $id==0 || $id=='') return 0;
        $i = 0;
        $sql = $this->db->query(' SELECT C.nome AS CATEGORIA, V.marca AS MARCAID, V.id, V.foto, V.ano, V.modelo, M.nome as MARCA, V.cc, V.valor1, V.valor2, V.valor3, V.franquia, V.obs
        FROM '.MYSQL_USUARIO_VEICULO.' V, '.MYSQL_CAT.' C, '.MYSQL_USUARIO_VEICULO_MARCAS.' M
        WHERE V.deletado=0 && V.categoria=C.id && V.marca=M.id && V.id='.$id.''); //P.categoria
        while ($campo = $sql->fetch_object()) {
            $veiculo['id'] = $campo->id;
            $veiculo['foto'] = $campo->foto;
            $veiculo['categoria'] = $campo->CATEGORIA;
            $veiculo['ano'] = $campo->ano;
            $veiculo['modelo'] = $campo->modelo;
            $veiculo['marca'] = $campo->MARCA;
            $veiculo['marcaid'] = $campo->MARCAID;
            $veiculo['cc'] = $campo->cc;
            $veiculo['valor1'] = $campo->valor1;
            $veiculo['valor2'] = $campo->valor2;
            $veiculo['valor3'] = $campo->valor3;
            $veiculo['franquia'] = $campo->franquia;
            $veiculo['obs'] = $campo->obs;
        }
        return $veiculo;
        
    }
    /**
     * Retorna todas as marcas
     * 
     * @name retorna_marcas
     * @access public
     * 
     * @param type $marcas
     * @return int
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function retorna_marcas(&$marcas) {
        $i = 0;
        $sql = $this->db->query(' SELECT id,nome FROM '.MYSQL_USUARIO_VEICULO_MARCAS.' WHERE deletado!=1 ORDER BY nome'); //P.categoria
        while ($campo = $sql->fetch_object()) {
            $marcas[$i]['id'] = $campo->id;
            $marcas[$i]['nome'] = $campo->nome;
            ++$i;
        }
        return $i;
        
    }
}
?>