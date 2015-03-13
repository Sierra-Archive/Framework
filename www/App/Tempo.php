<?php
namespace Framework\App;
class Tempo{
    private $nome = '';
    private $comeco = '';
    static private $log = Array();
    public function __construct($nome) {
        $this->nome = $nome.' S.M.';
        $this->comeco = microtime(true);
    }
    public function Fechar($fechar=true){
        $tempofinal = number_format((microtime(true)-$this->comeco)*1000, 10);
        self::$log[] = Array(
            $this->nome,
            $tempofinal,
            round((memory_get_usage(true)/1024)/1024,2).'MB',
            round((memory_get_peak_usage(true)/1024)/1024,2).'MB',
            round((memory_get_peak_usage(false)/1024)/1024,2).'MB'
        );
        if($fechar){
            unset($this);
        }
    }
    public function __destruct(){
        $this->Fechar(false);
    }
    private static function Tempo_Pagina(){
        $tempofinal = number_format((microtime(true)-TEMPO_COMECO)*1000, 10);
        self::$log[] = Array(
            SERVER_URL,
            $tempofinal,
            round((memory_get_usage(true)/1024)/1024,2).'MB',
            round((memory_get_peak_usage(true)/1024)/1024,2).'MB',
            round((memory_get_peak_usage(false)/1024)/1024,2).'MB'
        );
        
    }
    static function Salvar(){
        $comeco = microtime(true);
        self::Tempo_Pagina();
        $registro   = &\Framework\App\Registro::getInstacia();$db     = &$registro->_Conexao; $log = self::$log;
        
        // Se nao tiver Carregado Conexao, aborta
        if($db===false){
            return false;
        }
        
        // Busca Performaces e Da Forach
        $registro_mysql     = Array();
        $registros_mysql    = $db->Sql_Select('Sistema_Log_Performace',  false,0,'', 'chave,nome,ocorrencia,tempo_total,tempo_minimo,tempo_media,tempo_maximo', false);
        if(is_object($registros_mysql))$registros_mysql = Array($registros_mysql);
        if(!empty($registros_mysql)){
            foreach($registros_mysql as &$valor){
                $registro_mysql[$valor->chave] = $valor;
            }
        }
        $inserir = Array();
        $atualizar = Array();
        if(!empty($log)){
            foreach($log as &$valor){
                $chave = sha1($valor[0]);
                if(isset($registro_mysql[$chave])){
                    $log_sql = &$registro_mysql[$chave];
                    $log_sql->tempo_total = $log_sql->tempo_total+$valor[1];
                    ++$log_sql->ocorrencia;
                    if($valor[1]<$log_sql->tempo_minimo){
                        $log_sql->tempo_minimo  = $valor[1];
                    }
                    if($valor[1]>$log_sql->tempo_maximo){
                        $log_sql->tempo_maximo  = $valor[1];
                    }
                    if($log_sql->ocorrencia==0){
                        $log_sql->tempo_media = $log_sql->tempo_total;
                    }else{
                        $log_sql->tempo_media = ($log_sql->tempo_total/$log_sql->ocorrencia);
                    }
                    // Guarda pra Atualizar
                    $atualizar[] = $registro_mysql[$chave];
                }else{
                    $registro_mysql[$chave] = new \Sistema_Log_Performace_DAO();
                    $log_sql = &$registro_mysql[$chave];
                    $log_sql->chave         = $chave;
                    $log_sql->nome          = $valor[0];
                    $log_sql->tempo_total   = $valor[1];
                    $log_sql->tempo_minimo  = $valor[1];
                    $log_sql->tempo_maximo  = $valor[1];
                    $log_sql->tempo_media   = $valor[1];
                    $log_sql->ocorrencia = 1;
        //var_dump($log_sql,$valor);
                    // Guarda pra Inserir
                    $inserir[] = $log_sql;
                    // Atualiza Memoria Ram
                    $registro_mysql[$chave] = $registro_mysql[$chave];
                }
            }
        }
        // SE tiver a inserir, inseri
        //var_dump($inserir,$atualizar);
        if(!empty($inserir))    $db->Sql_Inserir($inserir,false);
        if(!empty($atualizar))  $db->Sql_Update($atualizar,false,false);
        
        
        // Grava Tempo de Log
        $nome   = 'Log Salvar S.M';
        $tempo  = number_format((microtime(true)-$comeco)*1000, 10);
        $chave  = sha1($nome);
        if(isset($registro_mysql[$chave])){
            $log_sql = &$registro_mysql[$chave];
            $log_sql->tempo_total = $log_sql->tempo_total+$tempo;
            ++$log_sql->ocorrencia;
            if($tempo<$log_sql->tempo_minimo){
                $log_sql->tempo_minimo  = $tempo;
            }
            if($tempo>$log_sql->tempo_maximo){
                $log_sql->tempo_maximo  = $tempo;
            }
            if($log_sql->ocorrencia==0){
                $log_sql->tempo_media = $log_sql->tempo_total;
            }else{
                $log_sql->tempo_media = ($log_sql->tempo_total/$log_sql->ocorrencia);
            }
            $db->Sql_Update($registro_mysql[$chave],false);
        }else{
            $registro_mysql[$chave] = new \Sistema_Log_Performace_DAO();
            $log_sql = &$registro_mysql[$chave];
            $log_sql->chave         = $chave;
            $log_sql->nome          = $nome;
            $log_sql->tempo_total   = $tempo;
            $log_sql->tempo_minimo  = $tempo;
            $log_sql->tempo_maximo  = $tempo;
            $log_sql->tempo_media   = $tempo;
            $log_sql->ocorrencia = 1;
            $db->Sql_Inserir($registro_mysql[$chave],false);
        }
    }
    static function Imprimir(){
        var_dump(self::$log);
    }
}
?>
