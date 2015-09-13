<?php
class usuario_veiculo_aluguel_Modelo extends \Framework\App\Modelo
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
    static function Financeiro(&$modelo,$usuarioid,$motivoid){
        $usuarioid = (int) $usuarioid;
        if(!isset($usuarioid) || !is_int($usuarioid) || $usuarioid==0) return 0;
        $motivoid = (int) $motivoid;
        if(!isset($motivoid)  || !is_int($motivoid)  || $motivoid==0 ) return 0;
        $Modelo->db->query('UPDATE '.MYSQL_USUARIO_VEICULO_ALUGUEL.' SET pago=1 WHERE id='.$motivoid);
        // BUSCA VALOR DO ALUGUEL
        $sql = $Modelo->db->query('SELECT valor
        FROM '.MYSQL_USUARIO_VEICULO_ALUGUEL.' WHERE deletado!=1 AND id='.$motivoid.' LIMIT 1'); //P.categoria
        while ($campo = $sql->fetch_object()) {
            $valor = $valor;
        }
        // ACRESCENTA PORCENTAGENS PARA AMIGOS DE NIVEL 1
        $i = 0;
        $sql = $Modelo->db->query('SELECT nivel_usuario
        FROM '.MYSQL_USUARIOS.'
        WHERE deletado!=1 AND indicado_por='.$usuarioid.' LIMIT 1'); //P.categoria
        while ($campo = $sql->fetch_object()) {
            $idindicado = $campo->id;
            if($campo->nivel_usuario!=0){
                eval('$novovalor = round((CONFIG_CLI_'.$campo->nivel_usuario.'_PORC1*$valor/100), 2);');
                $dt_vencimento = date("Y-m-d", time() + (FINANCEIRO_DIASVENCIMENTO * 86400));
                Financeiro_Modelo::MovInt_Inserir($modelo,$campo->id,$novovalor,1,'usuario_rede',$usuarioid,$dt_vencimento);                
            }
            ++$i;
        }
        if($i>0){
            // ACRESCENTA PORCENTAGENS PARA AMIGOS DE NIVEL 2
            $i = 0;
            $sql = $Modelo->db->query('SELECT nivel_usuario
            FROM '.MYSQL_USUARIOS.'
            WHERE deletado!=1 AND indicado_por='.$idindicado.' LIMIT 1'); //P.categoria
            while ($campo = $sql->fetch_object()) {
                $idindicado = $campo->id;
                if($campo->nivel_usuario!=0){
                    eval('$novovalor = round((CONFIG_CLI_'.$campo->nivel_usuario.'_PORC2*$valor/100), 2);');
                    $dt_vencimento = date("Y-m-d", time() + (FINANCEIRO_DIASVENCIMENTO * 86400));
                    Financeiro_Modelo::MovInt_Inserir($modelo,$campo->id,$novovalor,1,'usuario_rede',$usuarioid,$dt_vencimento);                
                }
                ++$i;
            }
        }
        if($i>0){
            // ACRESCENTA PORCENTAGENS PARA AMIGOS DE NIVEL 3
            $i = 0;
            $sql = $Modelo->db->query('SELECT nivel_usuario
            FROM '.MYSQL_USUARIOS.'
            WHERE deletado!=1 AND indicado_por='.$idindicado.' LIMIT 1'); //P.categoria
            while ($campo = $sql->fetch_object()) {
                if($campo->nivel_usuario!=0){
                    eval('$novovalor = round((CONFIG_CLI_'.$campo->nivel_usuario.'_PORC3*$valor/100), 2);');
                    $dt_vencimento = date("Y-m-d", time() + (FINANCEIRO_DIASVENCIMENTO * 86400));
                    Financeiro_Modelo::MovInt_Inserir($modelo,$campo->id,$novovalor,1,'usuario_rede',$usuarioid,$dt_vencimento);                
                }
                ++$i;
            }
        }
        return 1;
    }
    static function Financeiro_Motivo_Exibir($motivoid){
        $Registro = &\Framework\App\Registro::getInstacia();
        $Modelo = &$Registro->_Modelo;
        $i = 0;
        $sql = $Modelo->db->query(' SELECT C.nome AS CATEGORIA, V.id, V.foto, V.ano, V.modelo, M.nome as MARCA, V.cc, V.valor1, V.valor2, V.valor3, V.franquia
        FROM '.MYSQL_USUARIO_VEICULO.' V, '.MYSQL_CAT.' C, '.MYSQL_USUARIO_VEICULO_MARCAS.' M, '.MYSQL_USUARIO_VEICULO_ALUGUEL.' AL
        WHERE AL.id='.$motivoid.' && AL.veiculo=V.id && V.categoria=C.id && V.marca=M.id ORDER BY V.cc LIMIT 1'); //P.categoria
        while ($campo = $sql->fetch_object()) {
            ++$i;
            $veiculo = $campo->MARCA.' '.$campo->modelo.' '.$campo->cc.'cc';
        }
        if($i==0) return 'Erro';
        return  Array('Aluguel',$veiculo);
    }
}
?>