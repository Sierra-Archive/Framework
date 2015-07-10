<?php

class usuario_veiculo_aluguel_ListarModelo extends usuario_veiculo_aluguel_Modelo
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
    * @version 3.1.1
    */
    public function __construct(){
      parent::__construct();
    }
    /**
    * Retorna todos os usuarios
    * 
    * @name retorna_usuarios
    * @access public
    * 
    * @uses MYSQL_USUARIO_VEICULO_ALUGUEL
    * @uses \Framework\App\Modelo::$usuario
    * @uses \Framework\App\Modelo::$db
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 3.1.1
    */
    public function retorna_aluguel(&$aluguel){
        $usuario_id = (int) \Framework\App\Acl::Usuario_GetID_Static();
        if(!is_int($usuario_id) || $usuario_id==0 || !isset($usuario_id)) return 0;
        $i = 0;
        $sql = $this->db->query('SELECT A.id, A.pago, VM.nome as MARCA,V.ano, V.modelo, A.data_inicial,A.data_final,A.valor,A.data_cadastro
        FROM ('.MYSQL_USUARIO_VEICULO_ALUGUEL.' as A INNER JOIN '.MYSQL_USUARIO_VEICULO.' AS V ON A.veiculo=V.id) INNER JOIN '.MYSQL_USUARIO_VEICULO_MARCAS.' as VM on V.marca=VM.id WHERE A.deletado!=1 AND A.user='.$usuario_id.' ORDER BY A.data_inicial'); //P.categoria
        while ($campo = $sql->fetch_object()) {
            $aluguel[$i]['id'] = $campo->id;
            $aluguel[$i]['veiculo'] = $campo->modelo.' '.$campo->ano.' '.$campo->marca;
            $aluguel[$i]['data_inicial'] = $campo->data_inicial;
            $aluguel[$i]['data_final'] = $campo->data_final;
            $aluguel[$i]['valor'] = $campo->valor;
            $aluguel[$i]['pago'] = $campo->pago;
            ++$i;
        }
        return $i;
        
    }
}
?>