<?php
namespace Framework\App;
abstract class Dao implements \DaoInterface
{
    // Controle de MYSQL
    protected static $objetocarregado     = false;
    protected static $mysql_colunas       = false;
    protected static $mysql_outside       = false;
    protected static $mysql_inside        = false;
    
    // SE aceita ou nao configuracoes do usuario
    protected static $aceita_config       = true;
    // SE aceita ou nao configuracoes do usuario NOS CAMPOS
    protected static $campos_naoaceita_config  = false;
    
    // Colunas Default
    protected        $log_date_add        = '';
    protected        $log_user_add        = '';
    protected        $log_date_edit       = '';
    protected        $log_user_edit       = '';
    protected        $log_date_del        = '';
    protected        $log_user_del        = '';
    protected        $deletado            = 0;
    public function __construct() {
        if(static::$objetocarregado===false){
            $this->Get_CarregaMYSQL();
            static::$mysql_colunas      = $this->Gerar_Colunas();
            static::$objetocarregado    = true;
        }
    }
    public static function Get_Engine(){
        return 'InnoDB';
    }
    /**
     * 
     * @return string
     */
    public static function Get_Charset(){
        return 'latin1';
    }
    /**
     * 
     * @return int
     */
    public static function Get_Autoadd(){
        return 1;
    }
    /**
     * 
     * @return type
     */
    final public static function Get_Colunas(){
        if(static::$mysql_colunas===false){
            $class = get_called_class();
            static::$mysql_colunas = $class::Gerar_Colunas();
        }
        return static::$mysql_colunas;
    }
    /**
     * Caso Retorne False (padrao) nao é tabela de ligacao.
     * Mas se for tabela de mts pra mts vai retornar Array(
     *      'tablesigla1'=>'coluna extrangeira e primaria',
     *      'tablesigla2'=>'coluna extrangeira e primaria',
     *      [...]
     * )
     * @return boleano or Array
     */
    public static function Get_LinkTable(){
        return false;
    }
    /**
     * Verifica se uma tabela é estatica ou não em relação a todos os projetos.
     * Se é estatica, nao terá 'servidor', todos os registros serao abertos por 
     * todas as configuracoes de servidor
     * @return boleano
     */
    public static function Get_StaticTable(){
        return false;
    }
    public function Atributo_Del($atributo){
        if(isset($this->$atributo)){
            unset($this->$atributo);
            return true;
        }
        return false;
    }
    /**
     * 
     * @return boolean
     */
    final public function Get_CarregaMYSQL(){
        $campos         = $this->Get_Colunas();
        $inside         = &static::$mysql_inside;
        $outside        = &static::$mysql_outside;
        $inside         = Array();
        $outside        = Array();
        
        if(!is_array($campos)) throw new \Exception('Coluna Não é Array'.$campos,3250);
        // Bota as Principais
        $inside['log_date_add']     = 'data_hora_brasil_eua({valor})';
        $outside['log_date_add']    = 'data_hora_eua_brasil({valor})';
        $inside['log_date_edit']    = 'data_hora_brasil_eua({valor})';
        $outside['log_date_edit']   = 'data_hora_eua_brasil({valor})';
        $inside['log_date_del']     = 'data_hora_brasil_eua({valor})';
        $outside['log_date_del']    = 'data_hora_eua_brasil({valor})';
        // Percorre DAO e add TODOS
        reset($campos);
        while (key($campos) !== null) {
            $current = current($campos);
            // Exception
            if(!is_array($current)) throw new \Exception('Coluna Inconsistente'.$current,3250);
            
            // Recupera por refencia
            $mysql_outside = &$current['mysql_outside'];
            $mysql_inside  = &$current['mysql_inside'];
            $mysql_titulo  = &$current['mysql_titulo'];
            
            // Passa valores
            if($mysql_inside === false || $mysql_inside == ''){
                $inside[$mysql_titulo] = false;
            }else{
                $inside[$mysql_titulo] = $mysql_inside;
            }
            if($mysql_outside === false || $mysql_outside == ''){
                $outside[$mysql_titulo] = false;
            }else{
                $outside[$mysql_titulo] = $mysql_outside;
            }
        
            next($campos);
        }
    }
    /**
     * 
     * @return boolean
     */
    final public function Get_Primaria(){
        $campos = $this->Get_Colunas();
        $primarias = Array();
        $contador = 0;
        foreach($campos as &$valor){
            if(isset($valor['mysql_primary']) && $valor['mysql_primary'] === true){
                $primarias[$contador] = $valor['mysql_titulo'];
                ++$contador;
            }
        }
        if($contador==0) return false;
        else             return $primarias;
    }
    final public function Get_Indice_Unico(){
        $campos = $this->Get_Colunas();
        $indice_unico   = Array(); 
        $i_u            = Array(); // contagem de indices unicos
        foreach($campos as &$valor){
            // Verifica Indices Unicos
            if(isset($valor['mysql_indice_unico']) && $valor['mysql_indice_unico']!==false && is_string($valor['mysql_indice_unico'])){
                if(isset($i_u[$valor['mysql_indice_unico']]) && is_int($i_u[$valor['mysql_indice_unico']]) && $i_u[$valor['mysql_indice_unico']]>0){
                    $indice_unico[$valor['mysql_indice_unico']] .= ',';
                }else{
                    if(static::Get_StaticTable()===false){
                        $indice_unico[$valor['mysql_indice_unico']] = (string)  '`servidor`,'  ;
                    }else{
                        $indice_unico[$valor['mysql_indice_unico']] = (string)  ''  ;
                    }
                    $i_u[$valor['mysql_indice_unico']]          = (int)     0   ;
                }
                $indice_unico[$valor['mysql_indice_unico']] .= '`'.$valor['mysql_titulo'].'`';
                ++$i_u[$valor['mysql_indice_unico']];
            }
        }
        if(count($indice_unico)==0) return false;
        else                        return $indice_unico;
    }
    /**
     * 
     * @return boolean
     */
    final public function Get_Extrangeiras(){
        $campos = $this->Get_Colunas();
        $extrangeiras = Array();
        reset($campos);
        while (key($campos) !== null) {
            $current = current($campos);
            if(isset($current['mysql_estrangeira']) && $current['mysql_estrangeira']== true){
                $extrangeiras[] = Array(
                    'titulo'        =>  $current['mysql_titulo'],
                    'conect'        =>  $current['mysql_estrangeira']
                );
            }
            next($campos);
        }
        if(empty($extrangeiras)) return false;
        else             return $extrangeiras;
    }
    /**
     * MESMA FUNCAO ACIMA MAS COM A SIGLA SEPARADO
     * @return boolean
     */
    final public function Get_Extrangeiras_ComExterna(){
        $campos = $this->Get_Colunas();
        $extrangeiras = Array();
        reset($campos);
        while (key($campos) !== null) {
            $current = current($campos);
            if(isset($current['mysql_estrangeira']) && $current['mysql_estrangeira']!== false){
                $extrangeiras[$current['mysql_titulo']] = $current['mysql_estrangeira'];
            }
            next($campos);
        }
        if(empty($extrangeiras)) return false;
        else             return $extrangeiras;
    }
    final public function __set($nome,$resultado){
        $this->$nome = $resultado;
    }
    final public function __get($nome){
        if(!isset($this->$nome)){
            return false;
        }
        return $this->$nome;
    }
    
    /**
     * Pega Do banco de dados
     * Metodos Magicos
     * Antigo nome: __set
     * 
     * @param type $nome
     * @param type $resultado
     * @return type
     */
    final public function bd_get($nome,$resultado){
        // Pega as variaveis static
        $aceita_config = &static::$aceita_config;
        $campos_naoaceita_config = &static::$campos_naoaceita_config;
        
        // Caso nao exista retorna direto
        if(static::$mysql_outside===false){
            $this->Get_CarregaMYSQL();
        }
        if(!isset(static::$mysql_outside[$nome])){
            $this->$nome = $resultado;
            return true;
        }
        
        // SE aceitar config e tiver config de passar pra maiusculo, entao passa
        $this->$nome = (SQL_MAIUSCULO && $aceita_config && ($campos_naoaceita_config===false || !in_array($nome, $campos_naoaceita_config)))?mb_strtoupper(($resultado), 'UTF-8'):$resultado;
        
        
        $funcao = static::$mysql_outside[$nome];
        // Verifica se nao tem funcao ou é nula, caso contrario à executa
        if($funcao===false || $funcao=='' || $funcao=='{valor}'){
            $this->$nome = $resultado;
        }else{
            $funcao = str_replace(Array('{valor}'), Array('$this->$nome'), $funcao);
            eval('$this->$nome = '.$funcao.';');
        }
        return true;
    }
    /**
     * Metodos Magicos
     * insere no banco de dados
     * Antigo nome: __get
     * @param type $nome
     * @return boolean
     */
    final public function bd_set($nome){
        // Pega as variaveis static
        $aceita_config = &static::$aceita_config;
        $campos_naoaceita_config = &static::$campos_naoaceita_config;
        // Resutlado
        if(!isset($this->$nome)){
            return false;
        }
        // Se for inserir array no banco de dados, serializa
        if(is_array($this->$nome)){
            return serialize($this->$nome);
        }
        $this->$nome = (SQL_MAIUSCULO && $aceita_config && ($campos_naoaceita_config===false || !in_array($nome, $campos_naoaceita_config)))?mb_strtoupper(($this->$nome), 'UTF-8'):$this->$nome;
        
        
        // Caso nao exista retorna direto
        if(static::$mysql_inside===false){
            $this->Get_CarregaMYSQL();
        }
        if(!isset(static::$mysql_inside[$nome])){
            return $this->$nome;
        }
        $funcao = static::$mysql_inside[$nome];  
        if(!$funcao){
            return $this->$nome;
        }else{
            $funcao = str_replace(Array('{valor}'), Array('$this->$nome'), $funcao);
            if($funcao==''){
                return $this->$nome;
            }
            else{
                return eval('return '.$funcao.';');
            }
        }
    }
    /**
     * 
     * @return type
     */
    final public function Get_Object_Vars(){
        return get_object_vars($this);
    }
    
    
    // Certifica da Limpeza da Memoria
    function __destruct() {
        foreach ($this as $index => $value) unset($this->$index);
    }
}
?>
