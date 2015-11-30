<?php
namespace Framework\App;
/**
 * Sistema de cache
 * 
 * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
 * @version 0.4.24
 */
class Cache {

    /**
     *
     * @var type 
     */
    private static $tipo = NULL;
    /**
     *
     * @var type 
     */
    private static $tipo_performace = 'lento';
    /**
     *
     * @var type 
     */
    private static $cache = NULL;

    /**
     * Tempo padrão de cache
     *
     * @var string
     */
    private static $time = '1200';

    /**
     * Local onde o cache será salvo
     *
     * Definido pelo construtor
     *
     * @var string
     */
    private $folder;

    /**
     * memcache
     */
    private $memcache_tempo = 60; // ainda nao implementado 
    
    /**
     * Construtor
     *
     * Inicializa a classe e permite a definição de onde os arquivos
     * serão salvos. Se o parâmetro $folder for ignorado o local dos
     * arquivos temporários do sistema operacional será usado
     *
     * @uses Cache::Arquivos_Pasta() Para definir o local dos arquivos de cache
     *
     * @param string $folder Local para salvar os arquivos de cache (opcional)
     *
     * @return void
     * 
     * @version 0.4.24
     * @author Ricardo Sierra <web@ricardosierra.com.br>
     */
    public function __construct($folder = null) {
        // Tenta Conectar Memcache, se nao faz pelo hd mesmo
        if (class_exists('\Memcached')) {
            self::$cache = new \Memcached();
            $retorno = self::$cache->addServer('localhost', 11211);
            if ($retorno !== false) {
                self::$tipo           = 'Memcache';
                self::$tipo_performace = 'rapido';
                /*// checando dados no cache e carregando em $rows
                if (!($rows = $cache->get('lista_usuarios'))) {
                    if ($cache->getResultCode() == \Memcached::RES_NOTFOUND) {
                        // dados não encontrados no cache.
                        // inserir no cache dados obtidos no banco
                        // obter lista de usuarios do banco de dados
                        // $rows = obter_lista_usuarios_db();
                        $rows = array('joao', 'jose', 'maria');

                        // inserindo dados
                        $cache->set('lista_usuarios', $rows);
                    }
                }
                // acessando dados
                var_dump($rows);
                $cache->delete('lista_usuarios');*/
            } else {
                self::$tipo='HD';
            }
        } else {
            self::$tipo='HD';
        }
        if (self::$tipo==='HD') {
            $this->Arquivos_Pasta(!is_null($folder) ? $folder : sys_get_temp_dir());
        }
    }
    /**
     * Gera Id para Memoria RAm (SHMOD) e Nome de arquivo para Cache
     * @param type $name
     * @return int
     * 
     * @version 0.4.24
     * @author Ricardo Sierra <web@ricardosierra.com.br>
     */
    protected function Cache_Cod($name) {
        // maintain list of caches here
        static::$Cod=array(
            'Conexao'       => 1001,
            'Framework'     => 1002
        );

        return $id[$name];
    }
    /**
     * Salvar e Ler
     * 
     * @param type $key
     * @param type $ram
     * @return boolean
     * 
     * @version 0.4.24
     * @author Ricardo Sierra <web@ricardosierra.com.br>
     */
    public function Ler($key, $ram = false, $travar_localmente= true ) {
        // SE for pra DEBUG nao salva
        if (SISTEMA_DEBUG===true && $travar_localmente) {
            return false;
        }

        // Continua
        $retorno = false;
        if (self::$tipo==='Memcache') {
            // SE FOR DEBUG DELETA CACHE
            /*if (SISTEMA_DEBUG===true) {
                self::$cache->delete(sha1($key));
                return false;
            }*/
            $retorno = self::$cache->get(sha1($key));
            if (!($retorno)) {
                if (self::$cache->getResultCode() == \Memcached::RES_NOTFOUND) {
                    return false;
                } else {
                    return false;
                }
            } else {
                return unserialize($retorno);
            }

        } else if (self::$tipo==='Shmop' && $ram && SISTEMA_DEDICADO) {
            try{
                $retorno = $this->Shmop_Leitura($key);
                if ($retorno !== false) return $retorno;
                else  $this->Arquivos_Leitura($key);
            }
            catch(Exception $e) {
                return $this->Arquivos_Leitura($key);
            }
        }
        
        
        // SE nao Faz de Arquivo (MAIS LENTA)
        return $this->Arquivos_Leitura($key);
    }
    /**
     * 
     * @param type $key
     * @param type $content
     * @param type $time
     * @param type $ram
     * @return type
     * 
     * @version 0.4.24
     * @author Ricardo Sierra <web@ricardosierra.com.br>
     */
    public function Salvar($key, &$content, $time = null, $ram = false) {
        if (self::$tipo==='Memcache') {
            $retorno = self::$cache->set(sha1($key), serialize($content));
            return $retorno;
        } else if (self::$tipo==='Shmop' && $ram && SISTEMA_DEDICADO) {
            try{
                $retorno = @$this->Shmop_Salvar($key, $content, 1200); // tempo em segundos
                if ($retorno !== false) return $retorno;
                else  $this->Arquivos_Leitura($key);
            }
            catch(Exception $e) {
                return $this->Arquivos_Salvar($key, $content, $time);
            }
        }
        return $this->Arquivos_Salvar($key, $content, $time);
    }
    /**
     * 
     * @param type $key
     * @return boolean
     * 
     * @version 0.4.24
     * @author Ricardo Sierra <web@ricardosierra.com.br>
     */
    public function Deletar($key = null) {
        if (self::$tipo==='Memcache') {
            if ($key!==null) {
                return self::$cache->delete(sha1($key));
            } else {
                return false;
            }
        } else if (self::$tipo==='Shmop' && SISTEMA_DEDICADO) {
            /*try{
                $retorno = @$this->Shmop_Salvar($key, $content, 1200); // tempo em segundos
                if ($retorno !== false) return $retorno;
                else  $this->Arquivos_Leitura($key);
            }
            catch(Exception $e) {*/
                return $this->Arquivos_Apaga($key, $content, $time);
            //}
        }
        return $this->Arquivos_Apaga($key, $content, $time);
    }






    // TIPO PASTA












    /**
     * Define onde os arquivos de cache serão salvos
     *
     * Irá verificar se a pasta existe e pode ser escrita, caso contrário
     * uma mensagem de erro será exibida
     *
     * @param string $folder Local para salvar os arquivos de cache (opcional)
     *
     * @return void
     * 
     * @version 0.4.24
     * @author Ricardo Sierra <web@ricardosierra.com.br>
     */
    protected function Arquivos_Pasta($folder) {
        if (!file_exists($folder))
        {
            mkdir($folder, 0777);
        }
        // Se a pasta existir, for uma pasta e puder ser escrita
        if (file_exists($folder) && is_dir($folder) && is_writable($folder)) {
            $this->folder = $folder;
        } else {
            trigger_error('Não foi possível acessar a pasta de cache', E_USER_ERROR);
        }
    }

    /**
     * Gera o local do arquivo de cache baseado na chave passada
     *
     * @param string $key Uma chave para identificar o arquivo
     *
     * @return string Local do arquivo de cache
     * 
     * @version 0.4.24
     * @author Ricardo Sierra <web@ricardosierra.com.br>
     */
    protected function Arquivos_GerarEndereco($key) {
        return \str_replace('//','/',($this->folder . DS . sha1($key) . '.tmp'));
    }

    /**
     * Salva um valor no cache
     *
     * @uses Cache::createCacheFile() para criar o arquivo com o cache
     *
     * @param string $key Uma chave para identificar o valor cacheado
     * @param mixed $content Conteúdo/variável a ser salvo(a) no cache
     * @param string $time Quanto tempo até o cache expirar (opcional)
     *
     * @return boolean Se o cache foi salvo
     * 
     * @version 0.4.24
     * @author Ricardo Sierra <web@ricardosierra.com.br>
     */
    protected function Arquivos_Salvar($key, &$content, $time = null) {
        $tempo = new \Framework\App\Tempo('Cache - Salvar '.$key);
        $time = strtotime(!is_null($time) ? $time.' seconds' : self::$time.' seconds');

        // Gera o nome do arquivo
        $filename = $this->Arquivos_GerarEndereco($key);
        //echo "\n\n Nome do Arquivo: $filename";

        // Cria o arquivo com o conteúdo
        return  file_put_contents($filename, serialize($content))
                OR trigger_error('Não foi possível criar o arquivo de cache', E_USER_ERROR);
    }


    /**
     * Salva um valor do cache
     *
     * @uses Cache::Arquivos_GerarEndereco() para gerar o local do arquivo de cache
     *
     * @param string $key Uma chave para identificar o valor cacheado
     *
     * @return mixed Se o cache foi encontrado retorna o seu valor, caso contrário retorna NULL
     * 
     * @version 0.4.24
     * @author Ricardo Sierra <web@ricardosierra.com.br>
     */
    protected function Arquivos_Leitura($key) {
        $tempo = new \Framework\App\Tempo('Cache - Leitura '.$key);
        $filename = $this->Arquivos_GerarEndereco($key);
        if (file_exists($filename) && is_readable($filename)) {
            return unserialize(file_get_contents($filename));
        }
        return false;
    }
    /**
     * APAGA ARQUIVO DE CACHE
     * @param type $key
     * @return boolean
     * 
     * @version 0.4.24
     * @author Ricardo Sierra <web@ricardosierra.com.br>
     */
    protected function Arquivos_Apaga($key) {
        $filename = $this->Arquivos_GerarEndereco($key);
        if (file_exists($filename) && is_readable($filename)) {
            return unlink($filename);
        }
        return false;
    }













    /**
     * TIPO SHMOD
     * 
     * @param type $name
     * @param type $data
     * @param type $timeout
     * @return boolean
     * 
     * @version 0.4.24
     * @author Ricardo Sierra <web@ricardosierra.com.br>
     */
    protected function Shmop_Salvar($name, &$data, $timeout) {
        $tempo = new \Framework\App\Tempo('CacheRAM - Salvar '.$name);
        // delete cache
        $id=shmop_open($this->Cache_Cod($name), "a", 0, 0);
        shmop_delete($id);
        shmop_close($id);

        // get id for name of cache
        $id=shmop_open($this->Cache_Cod($name), "c", 0644, strlen(serialize($data)));

        // return int for data size or boolean false for fail
        if ($id) {
            $this->Shmop_Expirar_Setar($name, $timeout);
            return shmop_write($id, serialize($data), 0);
        }
        else return false;
    }
    /**
     * 
     * @param type $name
     * @return boolean
     * 
     * @version 0.4.24
     * @author Ricardo Sierra <web@ricardosierra.com.br>
     */
    protected function Shmop_Leitura($name) {
        $tempo = new \Framework\App\Tempo('CacheRAM - Leitura '.$name);
        if (!$this->Shmop_Expirar_Checar($name)) {
            $id=shmop_open($this->Cache_Cod($name), "a", 0, 0);

            if ($id) $data=unserialize(shmop_read($id, 0, shmop_size($id)));
            else return false;          // failed to load data

            if ($data) {                // array retrieved
                shmop_close();
                return $data;
            }
            else return false;          // failed to load data
        }
        else return false;              // data was expired
    }
    /**
     * 
     * @param type $name
     * @param type $int
     * 
     * @version 0.4.24
     * @author Ricardo Sierra <web@ricardosierra.com.br>
     */
    protected function Shmop_Expirar_Setar($name, $int) {
        $timeout=new DateTime(date('Y-m-d H:i:s'));
        date_add($timeout, date_interval_create_from_date_string("$int seconds"));
        $timeout=date_format($timeout, 'YmdHis');

        $id=shmop_open(1000, "a", 0, 0);
        if ($id) $tl=unserialize(shmop_read($id, 0, shmop_size($id)));
        else $tl=array();
        shmop_delete($id);
        shmop_close($id);

        $tl[$name]=$timeout;
        $id=shmop_open(1000, "c", 0644, strlen(serialize($tl)));
        shmop_write($id, serialize($tl), 0);
    }
    /**
     * 
     * @param type $name
     * @return boolean
     * 
     * @version 0.4.24
     * @author Ricardo Sierra <web@ricardosierra.com.br>
     */
    protected function Shmop_Expirar_Checar($name) {
        $now=new DateTime(date('Y-m-d H:i:s'));
        $now=date_format($now, 'YmdHis');

        $id=shmop_open(1000, "a", 0, 0);
        if ($id) $tl=unserialize(shmop_read($id, 0, shmop_size($id)));
        else return true;
        shmop_close($id);

        $timeout=$tl[$name];
        return (intval($now)>intval($timeout));
    }
}

