<?php
class Financeiro_Modelo extends \Framework\App\Modelo
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
    } /**
     * 
     * @global type $config
     * @param type $modelo
     * @param type $user
     * @param type $valor
     * @param type $positivo
     * @param type $motivo
     * @param type $motivoid
     * @param type $dt_vencimento
     * @param type $dt_pago
     */
    static function MovInt_Inserir(&$modelo,$user,$valor,$positivo,$motivo,$motivoid,$dt_vencimento,$dt_pago='0000-00-00 00:00:00'){
        GLOBAL $config;
        if($positivo==1){
            $modelo->db->query('INSERT INTO '.MYSQL_FINANCEIRO_MOV_INT.' (saida_motivo,saida_motivoid,entrada_motivo,entrada_motivoid,valor,positivo,motivo,motivoid,dt_vencimento,log_date_add,dt_pago) VALUES (\'Servidor\',\''.SRV_NAME_SQL.'\',\'Usuario\',\''.$user.'\',\''.$valor.'\',\''.$positivo.'\',\''.$motivo.'\',\''.$motivoid.'\',\''.$dt_vencimento.'\',\''.APP_HORA.'\',\''.$dt_pago.'\')');
        }else{
            $modelo->db->query('INSERT INTO '.MYSQL_FINANCEIRO_MOV_INT.' (entrada_motivo,entrada_motivoid,saida_motivo,saida_motivoid,valor,positivo,motivo,motivoid,dt_vencimento,log_date_add,dt_pago) VALUES (\'Servidor\',\''.SRV_NAME_SQL.'\',\'Usuario\',\''.$user.'\',\''.$valor.'\',\''.$positivo.'\',\''.$motivo.'\',\''.$motivoid.'\',\''.$dt_vencimento.'\',\''.APP_HORA.'\',\''.$dt_pago.'\')');
        }
    }
    /**
     *  Se tem debito devendo volta 1 se nao volta 0
     * @param type $motivo
     * @param type $usuarioid
     * @return int
     */
    static function MovInt_VerificaDebito(&$modelo,$usuarioid,$motivo){
        $i=0;
        $sql = $modelo->db->query('
                SELECT motivoid
                FROM '.MYSQL_FINANCEIRO_MOV_INT.'
                WHERE deletado!=1 AND motivo = \''.$motivo.'\' AND saida_motivo = \'Usuario\' AND saida_motivoid = '.$usuarioid.' AND pago = 0 ORDER BY log_date_add DESC LIMIT 1');
        while($campo = $sql->fetch_object()){
            $i = $campo->motivoid;
        }
        return $i;
    }
    
    
    
    public function MovFin_Carregar(&$array,$usuarioid){
        $i = 0;
        // CONSULTA EXTERNOS E GANHOS EM CIMA DE OUTROS USUARIOS
        /*$sql = $this->db->query('SELECT * FROM (
                SELECT positivo, valor, obs, log_date_add
                FROM '.MYSQL_FINANCEIRO_MOV_EXT.'
                WHERE deletado!=1 AND user = '.$usuarioid.'
            UNION ALL
                SELECT positivo, valor, \'associado\' AS obs, log_date_add
                FROM '.MYSQL_FINANCEIRO_MOV_INT.'
                WHERE deletado!=1 AND user = '.$usuarioid.'
            )a
            ORDER BY log_date_add
        ');*/
        $sql = $this->db->query('SELECT * FROM (
                SELECT 1 as positivo, valor, obs, log_date_add
                FROM '.MYSQL_FINANCEIRO_MOV_INT.'
                WHERE deletado!=1 AND entrada_motivo = \'Usuario\' AND entrada_motivoid = '.$usuarioid.'
            UNION ALL
                SELECT 0 as positivo, valor, \'associado\' AS obs, log_date_add
                FROM '.MYSQL_FINANCEIRO_MOV_INT.'
                WHERE deletado!=1 AND saida_motivo = \'Usuario\' AND saida_motivoid = '.$usuarioid.'
            ) as U
            ORDER BY log_date_add
        ');
        while($campo = $sql->fetch_object()){
            $array[$i]['positivo'] = $campo->positivo;
            $array[$i]['valor'] = $campo->valor;
            $array[$i]['log_date_add'] = $campo->log_date_add;
            if($campo->motivo=='' || !isset($campo->motivo)){
                $array[$i]['nome'] = $campo->obs;
            }else{
                eval('$array[$i][\'nome\'] = '.$campo->motivo.'Modelo::Financeiro_Motivo_Exibir($campo->motivoid);');
            }
            ++$i;
        }
        return $i;
    }
    public function Dividas_Carregar(&$array,$usuarioid){
        GLOBAL $config;
        $usuarioid = (int) $usuarioid;
        if($usuarioid!=0 && $usuarioid!='' && isset($usuarioid) && is_int($usuarioid)){
            $valor = 0;
            // CONSULTA EXTERNOS E GANHOS EM CIMA DE OUTROS USUARIOS
            /*$sql = $this->db->query('SELECT * FROM (
                    SELECT positivo, valor, log_date_add
                    FROM '.MYSQL_FINANCEIRO_MOV_EXT.'
                    WHERE deletado!=1 AND user = '.$usuarioid.'
                UNION ALL
                    SELECT positivo, valor, log_date_add
                    FROM '.MYSQL_FINANCEIRO_MOV_INT.'
                    WHERE deletado!=1 AND user = '.$usuarioid.' AND positivo = 1
                )a
                ORDER BY log_date_add
            ');
            while($campo = $sql->fetch_object()){
                if($campo->positivo==1){
                    $valor = $valor + $campo->valor;
                }else{
                    $valor = $valor - $campo->valor;
                }
            }*/
            // CONSULTA SEUS GASTOS NO SISTEMA
            $i=0;
            /*$sql = $this->db->query('
                    SELECT id, valor, positivo, motivo, motivoid, dt_vencimento, dt_pago
                    FROM '.MYSQL_FINANCEIRO_MOV_INT.'
                    WHERE deletado!=1 AND user = '.$usuarioid.' AND positivo = 0 ORDER BY log_date_add');*/
            $sql = $this->db->query('
                    SELECT id, valor, positivo, motivo, motivoid, dt_vencimento, dt_pago
                    FROM '.MYSQL_FINANCEIRO_MOV_INT.'
                    WHERE deletado!=1 AND saida_motivo = \'Usuario\' AND saida_motivoid = '.$usuarioid.' ORDER BY pago,log_date_add');
            while($campo = $sql->fetch_object()){
                if($campo->pago==1){
                    $valor = $valor-$campo->valor;
                    $array[$i]['situacao'] = 'Pago';
                    if($campo->dt_pago=='0000-00-00 00:00:00'){
                        $this->db->query('UPDATE '.MYSQL_FINANCEIRO_MOV_INT.' SET dt_pago=\''.APP_HORA.'\' WHERE id='.$campo->id);
                        eval($campo->motivo.'Modelo::Financeiro($this,$usuarioid,$campo->motivoid);');
                    }
                }else{
                    $array[$i]['situacao'] = 'Pendente';
                }
                eval('$array[$i][\'nome\'] = '.$campo->motivo.'Modelo::Financeiro_Motivo_Exibir($campo->motivoid);');
                $array[$i]['valor'] = $campo->valor;
                $array[$i]['dt_vencimento'] = $campo->dt_vencimento;
                $array[$i]['dt_pago'] = $campo->dt_pago;
                ++$i;
            }
            return $i;
        }else{
            return 0;
        }
    }
    static function Carregar_Saldo($modelo,$usuarioid, $completo = false){
        // bloqueia se usuario nao existe
        if(!isset($usuarioid) || $usuarioid==0){
          return 0;
        }
        if(!is_int($usuarioid)) $usuarioid = (int) $usuarioid;
        $valor = 0;
        // CONSULTA EXTERNOS E GANHOS EM CIMA DE OUTROS USUARIOS
        /*$sql = $modelo->db->query('SELECT * FROM (
                SELECT valor, log_date_add
                FROM '.MYSQL_FINANCEIRO_MOV_EXT.'
                WHERE deletado!=1 AND entrada_motivoid = '.$usuarioid.'
            UNION ALL
                SELECT positivo, valor, log_date_add
                FROM '.MYSQL_FINANCEIRO_MOV_INT.'
                WHERE deletado!=1 AND user = '.$usuarioid.'
            ) as U
            ORDER BY log_date_add
        ');*/
        $sql = $modelo->db->query('SELECT U.valor, U.log_date_add, U.positivo FROM (
                SELECT G.valor, G.log_date_add, 1 as positivo
                FROM '.MYSQL_FINANCEIRO_MOV_INT.' as G
                WHERE G.deletado!=1 AND G.entrada_motivo = \'Usuario\' AND G.entrada_motivoid = '.$usuarioid.'
            UNION ALL
                SELECT P.valor, P.log_date_add, 0 as positivo
                FROM '.MYSQL_FINANCEIRO_MOV_INT.' as P
                WHERE P.deletado!=1 AND P.saida_motivo = \'Usuario\' AND P.saida_motivoid = '.$usuarioid.'
            ) as U ORDER BY log_date_add
        ');
        while($campo = $sql->fetch_object()){
            if($campo->positivo==1){
                $valor = $valor + $campo->valor;
            }else{
                $valor = $valor - $campo->valor;
            }
        }
        if($completo===true){
            if($valor<0){
                $valor = '- R$ '.number_format($valor, 2, ',', '.');
            }else{
                $valor = 'R$ '.number_format($valor, 2, ',', '.');
            }
            return $valor;
        }else{
            return $valor;
        }
    }
    static function Financeiro(&$modelo,$usuarioid,$motivoid){
        /*$usuarioid = (int) $usuarioid;
        if(!isset($usuarioid) || !is_int($usuarioid) || $usuarioid==0) return 0;
        $modelo->db->query('UPDATE '.MYSQL_USUARIOS.' SET nivel_usuario_pago=1 WHERE id='.$usuarioid);
        */return 1;
    }
    static function Financeiro_Motivo_Exibir($motivoid){
        /*$usuarioid = (int) $usuarioid;
        if(!isset($usuarioid) || !is_int($usuarioid) || $usuarioid==0) return 0;
        $modelo->db->query('UPDATE '.MYSQL_USUARIOS.' SET nivel_usuario_pago=1 WHERE id='.$usuarioid);
        */
        $i = 0;
        $sql = $modelo->db->query('SELECT nome
        FROM '.MYSQL_USUARIOS.' WHERE deletado!=1 AND id='.$motivoid.' ORDER BY nome limit 1'); //P.categoria
        while ($campo = $sql->fetch_object()) {
            $nome = $campo->nome;
            ++$i;
        }
        if($i==0) return 'Erro';
        return Array('Transferencia',$nome);
    }
}
?>