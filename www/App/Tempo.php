<?php
namespace Framework\App;
/**
 * Classe para Idenfiticar e Armazenar Tempos de Execucao
 * 
 * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
 * @version 0.4.2
 */
class Tempo{
    /**
     * Nome do Armazenamento de Tempo
     * @var type 
     */
    private $nome = '';
    /**
     *
     * @var type 
     */
    private $comeco = '';
    static private $log = Array();
    /**
     * Construtor, Começa a medir o tempo
     * 
     * @param type $nome
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function __construct($nome) {
        $this->nome = $nome.' S.M.';
        $this->comeco = microtime(true);
    }
    /**
     * Fechar Logs
     * 
     * @param type $fechar
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Fechar($fechar=true) {
        $tempofinal = number_format((microtime(true)-$this->comeco)*1000, 10);
        self::$log[] = Array(
            $this->nome,
            $tempofinal,
            round((memory_get_usage(true)/1024)/1024,2).'MB',
            round((memory_get_peak_usage(true)/1024)/1024,2).'MB',
            round((memory_get_peak_usage(false)/1024)/1024,2).'MB'
        );
        if ($fechar) {
            unset($this);
        }
    }
    /**
     * Destruidor da Classe
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function __destruct() {
        $this->Fechar(false);
    }
    /**
     * Pega Tempo da Página
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    private static function Tempo_Pagina() {
        $tempofinal = number_format((microtime(true)-TEMPO_COMECO)*1000, 10);
        self::$log[] = Array(
            SERVER_URL,
            $tempofinal,
            round((memory_get_usage(true)/1024)/1024,2).'MB',
            round((memory_get_peak_usage(true)/1024)/1024,2).'MB',
            round((memory_get_peak_usage(false)/1024)/1024,2).'MB'
        );
        
    }
    /**
     * Salvar os Logs de Tempos
     * 
     * @return boolean
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    static function Salvar() {
        $comeco = microtime(true);
        self::Tempo_Pagina();
        $Registro   = &\Framework\App\Registro::getInstacia();$db     = &$Registro->_Conexao; $log = self::$log;
        
        // Se nao tiver Carregado Conexao, aborta
        if ($db===false) {
            return false;
        }
        
        // Busca Performaces e Da Forach
        $Registro_mysql     = Array();
        $Registros_mysql    = $db->Sql_Select('Sistema_Log_Performace',  false,0,'', 'chave,nome,ocorrencia,tempo_total,tempo_minimo,tempo_media,tempo_maximo', false);
        if (is_object($Registros_mysql))$Registros_mysql = Array($Registros_mysql);
        if (!empty($Registros_mysql)) {
            foreach($Registros_mysql as &$valor) {
                $Registro_mysql[$valor->chave] = $valor;
            }
        }
        $inserir = Array();
        $atualizar = Array();
        if (!empty($log)) {
            foreach($log as &$valor) {
                $chave = sha1($valor[0]);
                if (isset($Registro_mysql[$chave])) {
                    $log_sql = &$Registro_mysql[$chave];
                    $log_sql->tempo_total = $log_sql->tempo_total+$valor[1];
                    ++$log_sql->ocorrencia;
                    if ($valor[1]<$log_sql->tempo_minimo) {
                        $log_sql->tempo_minimo  = $valor[1];
                    }
                    if ($valor[1]>$log_sql->tempo_maximo) {
                        $log_sql->tempo_maximo  = $valor[1];
                    }
                    if ($log_sql->ocorrencia==0) {
                        $log_sql->tempo_media = $log_sql->tempo_total;
                    } else {
                        $log_sql->tempo_media = ($log_sql->tempo_total/$log_sql->ocorrencia);
                    }
                    // Guarda pra Atualizar
                    $atualizar[] = $Registro_mysql[$chave];
                } else {
                    $Registro_mysql[$chave] = new \Sistema_Log_Performace_DAO();
                    $log_sql = &$Registro_mysql[$chave];
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
                    $Registro_mysql[$chave] = $Registro_mysql[$chave];
                }
            }
        }
        // SE tiver a inserir, inseri
        //var_dump($inserir,$atualizar);
        if (!empty($inserir))    $db->Sql_Insert($inserir,false);
        if (!empty($atualizar))  $db->Sql_Update($atualizar,false,false);
        
        
        // Grava Tempo de Log
        $nome   = 'Log Salvar S.M';
        $tempo  = number_format((microtime(true)-$comeco)*1000, 10);
        $chave  = sha1($nome);
        if (isset($Registro_mysql[$chave])) {
            $log_sql = &$Registro_mysql[$chave];
            $log_sql->tempo_total = $log_sql->tempo_total+$tempo;
            ++$log_sql->ocorrencia;
            if ($tempo<$log_sql->tempo_minimo) {
                $log_sql->tempo_minimo  = $tempo;
            }
            if ($tempo>$log_sql->tempo_maximo) {
                $log_sql->tempo_maximo  = $tempo;
            }
            if ($log_sql->ocorrencia==0) {
                $log_sql->tempo_media = $log_sql->tempo_total;
            } else {
                $log_sql->tempo_media = ($log_sql->tempo_total/$log_sql->ocorrencia);
            }
            $db->Sql_Update($Registro_mysql[$chave],false);
        } else {
            $Registro_mysql[$chave] = new \Sistema_Log_Performace_DAO();
            $log_sql = &$Registro_mysql[$chave];
            $log_sql->chave         = $chave;
            $log_sql->nome          = $nome;
            $log_sql->tempo_total   = $tempo;
            $log_sql->tempo_minimo  = $tempo;
            $log_sql->tempo_maximo  = $tempo;
            $log_sql->tempo_media   = $tempo;
            $log_sql->ocorrencia = 1;
            $db->Sql_Insert($Registro_mysql[$chave],false);
        }
    }
    /**
     * IMprimir o Relatório dos Tempos
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    static function Imprimir() {
        var_dump(self::$log);
    }
}
?>
