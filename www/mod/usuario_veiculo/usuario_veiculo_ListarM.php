<?php
class usuario_veiculo_ListarModelo extends usuario_veiculo_Modelo
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
    * @version 0.4.24
    */
    public function __construct() {
      parent::__construct();
    }   /**
     * Retorna horario vago dos alugueis
     * 
     * @name retorna_Agendadatas
     * @access public
     * 
     * @return void
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.24
     */
    public function retorna_Agendadatas(&$datas, $veiculo=0) {
        GLOBAL $tabsql, $config;
        $i = 0;
        $datainicial = APP_DATA;
        
        // grava ultimas datas para cada evento
        $where = '';
        if ($veiculo!=0) $where = ' && V.id='.$veiculo;
        $sql = $this->db->query('SELECT C.nome AS CATEGORIA, V.id, V.foto, V.ano, V.modelo, M.nome as MARCA, V.cc, V.valor1, V.valor2, V.valor3, V.franquia
        FROM '.MYSQL_USUARIO_VEICULO.' V, '.MYSQL_CAT.' C, '.MYSQL_USUARIO_VEICULO_MARCAS.' M
        WHERE V.deletado=0 && V.categoria=C.id && V.marca=M.id '.$where.' ORDER BY V.id'); //P.categoria
        while ($campo = $sql->fetch_object()) {
            $ultimasdatas[$campo->id] = $datainicial;
            $veiculotitulo[$campo->id] = $campo->modelo.' '.$campo->cc.'cc '.$campo->MARCA.' Ano de '.$campo->ano.' ('.$campo->CATEGORIA.')';
        }
        
        
        // faz uma pesquisa por todas as datas
        // acrescenta a ultima data gravada como inicio
        // e a data inicial da reserva como data final
        // a data final da reserva grava no lugar da ultima data do evento
        $where = '';
        if ($veiculo!=0) $where = ' && veiculo='.$veiculo;
        $sql = $this->db->query(' SELECT data_inicial, data_final, veiculo
        FROM '.MYSQL_USUARIO_VEICULO_ALUGUEL.' WHERE deletado!=1 AND data_inicial>'.$datainicial.''.$where.' ORDER BY data_inicial'); //P.categoria
        while ($campo = $sql->fetch_object()) {
            $datas[$i]['Id'] = $campo->veiculo;
            $datas[$i]['Titulo'] = $veiculotitulo[$campo->veiculo];
            $datas[$i]['DataInicial'] = date('Y-m-d', strtotime("+1 days",strtotime($ultimasdatas[$campo->veiculo])));
            $datas[$i]['DataFinal'] = date('Y-m-d', strtotime("-1 days",strtotime($campo->data_inicial)));
            $ultimasdatas[$campo->veiculo] = $campo->data_final;
            ++$i;
        }
        
        // percorre todas as ultimas datas gravadas e acrescenta as datas
        reset($ultimasdatas);
        foreach ($ultimasdatas as $key=>$value) {
            $datas[$i]['Id'] = $key;
            $datas[$i]['Titulo'] = $veiculotitulo[$key];
            $datas[$i]['DataInicial'] = date('Y-m-d', strtotime("+1 days",strtotime($value)));
            $datas[$i]['DataFinal'] = date('Y-m-d', strtotime("+365 days",strtotime($value)));
            ++$i;
        }
        
        
        
        return $i;
        
    }
    public function agendamento_inserir($veiculo, $data_inicial, $data_final, $valor) {
        global $config;
        $this->db->query('INSERT INTO '.MYSQL_USUARIO_VEICULO_ALUGUEL.' (user,veiculo,data_inicial,data_final,valor,data_cadastro) VALUES (\''.\Framework\App\Acl::Usuario_GetID_Static().'\',\''.$veiculo.'\',\''.$data_inicial.'\',\''.$data_final.'\',\''.$valor.'\',\''.APP_HORA.'\')');
        
        $sql = $this->db->query('SELECT id FROM '.MYSQL_USUARIO_VEICULO_ALUGUEL.' WHERE deletado!=1 AND data_cadastro=\''.APP_HORA.'\' AND user=\''.\Framework\App\Acl::Usuario_GetID_Static().'\' ORDER BY id DESC LIMIT 1');
        while ($campo = $sql->fetch_object()) {
           $id = $campo->id;
        }
        $dt_vencimento = date("Y-m-d", time() + (FINANCEIRO_DIASVENCIMENTO * 86400));
        Financeiro_Modelo::MovInt_Inserir($this,\Framework\App\Acl::Usuario_GetID_Static(), $valor,0,'usuario_veiculo_aluguel', $id, $dt_vencimento);
        return 1;
    }
}
?>