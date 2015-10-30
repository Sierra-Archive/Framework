<?php
namespace Framework\Classes;

class SierraTec_Manutencao {
    
    
    protected $log;
    protected $Registro;
    protected $_Conexao;
    public function __construct() {
        $this->registro = &\Framework\App\Registro::getInstacia();
        $this->_Conexao = $this->registro->_Conexao;
    }
    /***********************************
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     *                 FUNCOES DE MANUTENCAO,
     * 
     *                  SEMPRE QUE O CODIGO FOR ALTERADO MANUTENCAO RODA

                        E COLOCA AS CONFIGURACOES NECESSARIAS
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     */
    public function log($log) {
        echo $log;
    }
    
    /**
     * Descobre Quais Dao o Cliente Necessita
     */
    public function Manutencao() {
        // Atualiza Dependencias
        $dependencia_dao = array_merge(
            $this->Atualiza_Dependencia_Banco_De_Dados('app'),
            $this->Atualiza_Dependencia_Banco_De_Dados(CLASS_PATH)
        );
        $modulos = config_modulos();
        foreach($modulos as &$valor) {
            /*var_dump($dependencia_dao);
            echo "\n\nProximo:".$valor;*/
            $dependencia_dao = array_merge($dependencia_dao,$this->Atualiza_Dependencia_Banco_De_Dados(MOD_PATH.$valor.DS));
        }
        //var_dump($dependencia_dao);
        $this->Alterar_Config('TEMP_DEPENDENCIA_TABELAS',serialize($dependencia_dao),'_temp');
        
        // Limpa Bando de Dados
        $this->BD_Limpar();
    }
    /**
     * Procura Por Todos os Usos de Dao e Coloca ai !
     * @param type $dir
     */
    public function Atualiza_Dependencia_Banco_De_Dados($dir=ROOT_PADRAO) {

        // Carrega Todos os DAO
        if ($dir=='mod') {
            $dir = MOD_PATH;  
        } else if ($dir=='app') {
            $dir = APP_PATH;  
        }
        
        $dependencia_dao            = Array();
        $dependencia_dao_CONSTANTE  = Array();
        // Le pasta
        $diretorio = dir($dir);
        
        // PRocura Arqiuvos e Anota valores usados
        while ($arquivo = $diretorio -> read()) {
            $achado         = Array();
            // Ignora Propria Pasta, pasta anterior e Arquivo Autoload
            if ($arquivo!='..' && $arquivo!='.' && $arquivo!='AutoLoad.php') {
                if (is_dir($dir.$arquivo)) {
                    $dependencia_dao = array_merge($dependencia_dao,$this->Atualiza_Dependencia_Banco_De_Dados($dir.$arquivo.DS));
                } else {
                    $conteudo = file_get_contents($dir.$arquivo);
                    // PRocura Ocorrencias de COnexao
                    $resultado = preg_match_all(
                        '/Sql_(Select|Inserir|Update|Delete)'.
                            '(\(|\(\')([_A-Za-z]+)(\)|\,|\')/U', 
                        $conteudo, 
                        $achado
                    );
                    if ($resultado >= 1) {
                        reset($achado[3]);
                        while (key($achado[3])!==NULL) {
                            $dependencia_dao[current($achado[3])] = current($achado[3]);
                            next($achado[3]);
                        }
                    }
                    // Procura DAO iniciado
                    $resultado = preg_match_all(
                        '/[_A-Za-z]+_DAO/U', 
                        $conteudo, 
                        $achado
                    );
                    if ($resultado >= 1) {
                        reset($achado[0]);
                        while (key($achado[0])!==NULL) {
                            $current = str_replace('_DAO', '', current($achado[0]));
                            $dependencia_dao[$current] = $current;
                            next($achado[0]);
                        }
                    }
                    // Procura CONSTANTES DE BANCO DE DADOS
                    $resultado = preg_match_all(
                        '/MYSQL_(.+)[^([:alnum:]_)]/U', 
                        $conteudo, 
                        $achado
                    );
                    
                    if ($resultado >= 1) {
                        reset($achado[1]);
                        while (key($achado[1])!==NULL) {
                            if (current($achado[1]));
                            $constante = str_replace(Array(')','\'','('), Array('','',''), 'MYSQL_'.current($achado[1]));
                            if ($constante!=='MYSQL_') {
                                eval('$dependencia_dao_CONSTANTE[$constante] = '.$constante.';');
                            }
                            next($achado[1]);
                        }
                    }
                }   
            }
        }
        
        // Adiciona as COnstantes a Classe
        $tabelas = &\Framework\App\Conexao::$tabelas;
        foreach($tabelas as &$valor) {
            if (in_array($valor['nome'], $dependencia_dao_CONSTANTE)) {
                //var_dump($valor['nome'],$valor['class']); echo "\n\n";
                $dependencia_dao[$valor['class']] = $valor['class'];
            }
        }
        
        
        // Grava em Config do Modulo
        // Aumenta uma Versao V.V.V+1
        // Grava Dependencia DAO #update
        return $dependencia_dao;
    }
    
    
    /***********************************
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     *                 FUNCOES DE ALTERACAO DE CODIGO ESPECIFICAS
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     */
    /**
     * Pega o Arquivo de CONFIG atual e altera valores
     * @param type $nome
     * @param type $valor
     * @param type $config
     * @return type
     */
    public function Alterar_Config($nome,$valor=false,$config='config') {
        
        // Carrega CONFIG
        $arq = INI_PATH.SRV_NAME.DS.$config.'.php'; 
        if (file_exists($arq)) {
            chmod ($arq, 0777);
            $conteudo = file_get_contents($arq);
            // Caso valor seja falso, apenas retorna valor
            if ($valor===false) {
                return $this->Cod_Atualiza_Constante($conteudo, $nome,$valor);
            } else {
                // SE nao, pega o novo conteudo e altera no arquivo.
                $conteudo = $this->Cod_Atualiza_Constante($conteudo, $nome,$valor);
            }
            
            // Salvar
            file_put_contents($arq, $conteudo);
                    
            //Retorna
            return true;
        } else {
            $arquivo = fopen ($arq, 'w');
            if (is_int($valor)) {
                $conteudo_novo = '<?php'."\n".'define(\''.$nome.'\',  '.$valor.');'."\n"."?>";
            } else {
                $conteudo_novo = '<?php'."\n".'define(\''.$nome.'\',  \''.$valor.'\');'."\n"."?>";
            }
            
            if (!fwrite($arquivo, $conteudo_novo)) die('Não foi possível atualizar o arquivo.');
            fclose($arquivo);
            chmod ($arq, 0777);
        }
    }
    
    
    /***********************************
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     *                 FUNCOES DE VERIFICAÇÂO DE CONSISTENCIA
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     */
    public function Verificar_Sis_Dao() {
        // Verificar se Toda Dao tem Primaria..
        //etc..
    }
    
    
    
    
    /***********************************
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     *                 FUNCOES DE LIMPEZA E BACKUP
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     */
    
    // Remove Tabelas não Usadas e campos nao usados
    // #update
    public function BD_Limpar() {
        // Antes de Limpar Faz Backup
        $this->BD_Backup();
    }
    public function BD_Backup() {
        // Antes de Limpar Faz Backup
    }
    
    
    
    
    /***********************************
     * 
     * 
     * 
     * 
     *                 FUNCOES DE TRANSFERENCIA DE DOMINIO E ATUALIZACAO   de CONTEUDO
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     */
    
    /**
     *  troca o nome de um servidor para outro
     * @param type $novo Nome antigo
     * @param type $antigo Nome Novo
     */
    public function Tranferencia_DB_Servidor($novo,$antigo=false) {
        $tabelas = &\Framework\App\Conexao::$tabelas;
        foreach($tabelas as $indice=>&$valor) {
            if ($valor['static']===false) {
                if ($antigo!==false) {
                    $this->_Conexao->query('UPDATE '.$indice.' SET servidor=\''.$novo.'\' WHERE servidor=\''.$antigo.'\'');
                } else {
                    $this->_Conexao->query('UPDATE '.$indice.' SET servidor=\''.$novo.'\'');
                }
            }
        }
        //$this->_Modelo->db->
    }
    /**
     * Atualiza Código e Banco de Dados para Versoes mais Recentes
     * @param type $versao Versão antiga para Atualizacao
     */
    public function Atualizacao_Version($versao=2.2) {
        $versao_atual = SISTEMA_CFG_VERSION;
        
        // Atualizacao para Versao 2.3
        if ($versao<2.3 && $versao_atual>=2.3) {
            $qnt = Array();
            $qnt['deupau'] = 0;
            $sucesso = 0;
            $foi = false;
            // Acrescentar Categoria em Todos os Financeiros
            $atualizar = Array();
            $financeiro = $this->_Conexao->Sql_Select('Financeiro_Pagamento_Interno',false,0,''/*,'motivo,motivoid,categoria'*/);
            if (is_object($financeiro)) $financeiro = Array($financeiro);
            if (!empty($financeiro)) {
                foreach($financeiro as $valor) {
                    $valor->categoria = (int) $valor->categoria;
                    if ($valor->motivo=='comercio_Estoque' && ($valor->categoria=='' || $valor->categoria==0 || $valor->categoria==NULL)) {
                        $valor_motivo = $this->_Conexao->Sql_Select('Comercio_Fornecedor_Material',Array('id'=>$valor->motivoid),1,'','categoria');
                        if (!is_object($valor_motivo)) {  ++$qnt['deupau']; continue;}
                        $valor->categoria = $valor_motivo->categoria;
                        $foi = $this->_Conexao->Sql_Update($valor);
                        if ($foi) {
                            $sucesso=$sucesso+1;
                        }
                    }
                    
                    if ($valor->categoria=='' || $valor->categoria==0 || $valor->categoria==NULL) {
                        if (isset($qnt['nullo'])) {
                            ++$qnt['nullo'];
                        } else {
                            $qnt['nullo'] = 1;
                        }
                    } else {
                        if (isset($qnt[$valor->categoria])) {
                            ++$qnt[$valor->categoria];
                        } else {
                            $qnt[$valor->categoria] = 1;
                        }
                    }
                }
            }
            var_dump($sucesso,$qnt);
            
            
            
        }
    }
    
    
    
    
    
    
    /***********************************
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     *                 FUNCOES DE BUSCA GENERICA EM CODIGO
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     */
    /**
     * 
     * @param type $codigo
     * @param type $variavel
     */
    private function PHP_GetVariavel($codigo,$variavel) {
        // Procura CONSTANTES DE BANCO DE DADOS
        $achado = Array();
        $resultado = preg_match_all(
            '/\$'.$variavel.'[ \t\n\r\f\v]*=[ \t\n\r\f\v]*([^ \t\n\r\f\v]*);/U', 
            $codigo, 
            $achado
        );
        if ($resultado >= 1) {
        var_dump(
            $achado);
            reset($achado[1]);
            while (key($achado[1])!==NULL) {
                $constante = 'MYSQL'.current($achado[1]);
                $dependencia_dao_CONSTANTE[$constante] = $constante;
                next($achado[1]);
            }
        }
    }
    /**
     * Pega um Código, procura por uma constante, se alterarvalor for falso, devolve o valor da constante,
     * se nao o altera.
     * @param type $codigo
     * @param type $nome_Constante
     * @param type $alterarvalor
     */
    private function Cod_Atualiza_Constante($codigo,$nome_Constante,$alterarvalor=false) {
        // Procura CONSTANTES DE BANCO DE DADOS
        $achado = Array();
        $resultado = preg_match_all(
            '/define\(\''.$nome_Constante.'\'[ \t\n\r\f\v]*,[ \t\n\r\f\v]*([^ \t\n\r\f\v]*)\);/U', 
            $codigo, 
            $achado
        );
        if ($resultado > 1) {
            $this->log('Não se pode ter duas constantes com o mesmo nome',$nome_Constante);
        }
        
        // Caso nao tenha resultado
        if ($resultado == 0) {
            // Caso tenha valor, cria a constante
            if ($alterarvalor!==false) {
                if (is_bool($alterarvalor)) {
                    $resultado = 'true';
                } else if ($alterarvalor==='false' || $alterarvalor==='falso') {
                    $resultado = 'false';
                } else if (is_string($alterarvalor)) {
                    $resultado = '\''.$alterarvalor.'\'';
                } else {
                    $resultado = (int) $alterarvalor;
                }
                
                $codigo = preg_replace(
                    '/\?>/U', 
                    'define(\''.$nome_Constante.'\','.$resultado.'); '."\n\n".'?>', 
                    $codigo,
                    1
                );
                return $codigo;
            }
        } else 
        //CASo tenha resultado
        if ($resultado >= 1) {
            $resultado = $achado[1][0];
            
            // CAso alterar valor seja falso, retorna no mesmo tipo e nao como string usando eval
            if ($alterarvalor===false) {
                return eval('return '.$resultado.';');
            }
            
            // CAso seja inteiro, boleano ou string
            if (strpos($resultado, '\'')!==false || strtolower($resultado)=='null') {
                $tipo = 'string';
                $resultado = '\''.$alterarvalor.'\'';
            } else if (strtolower($resultado)=='false' || strtolower($resultado)=='true') {
                $tipo = 'boleano';
                if ($alterarvalor===true || $alterarvalor==='true') {
                    $resultado = 'true';
                } else if ($alterarvalor==='false' || $alterarvalor==='falso') {
                    $resultado = 'false';
                }
            } else {
                $tipo = 'numeral';
                $resultado = (string) $alterarvalor;
            }
            
            $codigo = preg_replace(
                '/define\(\''.$nome_Constante.'\'([ \t\n\r\f\v]*),([ \t\n\r\f\v]*)([^ \t\n\r\f\v;]*)\);/U', 
                'define(\''.$nome_Constante.'\'$1,${2}'.$resultado.');', 
                $codigo
            );
            return $codigo;
        }
    }
    
    
    private function PHP_GetClasses($codigo) {
        
        $achado = Array();
        $resultado = preg_match_all(
            '/\$'.$variavel.'[ \t\n\r\f\v]*=[ \t\n\r\f\v]*([^ \t\n\r\f\v]*);/U', 
            $codigo, 
            $achado
        );
    }
    private function PHP_GetClasses_Variaveis($codigo) {
        
    }
    public static function PHP_GetClasses_Metodos($codigo,$privacidade='*') {
        $metodos = Array();
        $achado = Array();
        
                    //    '/MYSQL_(.+)[^([:alnum:]_)]/U', 
        // PRocura Ocorrencias de COnexao
        $resultado = preg_match_all(
            '/(public|private|private) function ([_A-Za-z0-9]+)\(([_A-Za-z=,\'\"\&\$]*)\)\{/U', 
            $codigo, 
            $achado
        );
        $i = 0;
        if ($resultado >= 1) {
            foreach($achado[2] as $indice=>$valor) {
                if ($valor=='__construct') continue;
                
                //Verifica Privacidade
                if ($privacidade!=='*' && $privacidade!=='public' && isset($achado[1][$indice]) && $achado[1][$indice]!=='public') {
                    continue;
                }
                if ($privacidade!=='*' && $privacidade!=='protected' && isset($achado[1][$indice]) && $achado[1][$indice]!=='protected') {
                    continue;
                }
                if ($privacidade!=='*' && $privacidade!=='private' && isset($achado[1][$indice]) && $achado[1][$indice]!=='private') {
                    continue;
                }
                
                $metodos[$i] = Array(
                    'Nome'          => $valor,
                    'Privacidade'   => $achado[1][$indice],
                    'Args'          => Array()
                );
                
                if (isset($achado[3][$indice]) && $achado[3][$indice]!=='') {
                    $argumentos = explode(',',$achado[3][$indice]);
                    foreach($argumentos as $valor2) {
                        $argumentos_item = explode('=',$valor2);
                        if (isset($argumentos_item[1])) {
                            $metodos[$i]['Args'][] = Array(
                                'Nome'          => $valor,
                                'Opcional'      => true,
                                'Padrao'        => $argumentos_item[1]
                            );
                        } else {
                            $metodos[$i]['Args'][] = Array(
                                'Nome'          => $valor,
                                'Opcional'      => false,
                                'Padrao'        => false
                            );
                        }
                    }
                }
                ++$i;
            }
        }
        return $metodos;
    }
    private function PHP_GetFunction($codigo) {
        
    }
    
    
    //#update, fazer
    // BUsca Todas As Classes dentro de Um arquivo
    public function Cod_Busca_Classes() {
        $classes = Array();
        foreach($classes as $valor) {
            $this->Cod_Busca_Classes_Metodos($valor);
        }
    }
    /**
     * Procura Pelos Metodos dentro de uma Classe
     * @param type $cod
     */
    public function Cod_Busca_Classes_Metodos($cod) {
        $metodos = Array();
        //Procura DAO SENDO USADO
        foreach($metodos as $valor) {
            foreach($tabelas as $valor2) {
                $this->Cod_Busca_Valor($valor,$valor2);
            }
            $this->Cod_Busca_ClassesUsadas($valor);
            $this->Cod_Busca_MetodosUsados($valor);
        }
    }
    /**
     * Busca Por uma string ou um numero, ou qlqr outra coisa
     */
    public function Cod_Busca_Valor($cod,$valor) {
        if (is_string($valor)) {
            $achado = Array();
            $resultado = preg_match_all(
                '/\$'.$variavel.'[ \t\n\r\f\v]*=[ \t\n\r\f\v]*([^ \t\n\r\f\v]*);/U', 
                $codigo, 
                $achado
            );
        }
    }
    /**
     * Busca Por uma string ou um numero, ou qlqr outra coisa
     */
    public function Cod_Busca_ClassesUsadas($cod,$valor) {
        // new até ;
    }
    public function Cod_Busca_MetodosUsados($cod,$valor) {
        // Quando Tiver :: do começo da linha até o proximo ;
        
        // QUando Tiver -> dentro da expressao $ até ;
    }
    
    
    
    
    
    
}