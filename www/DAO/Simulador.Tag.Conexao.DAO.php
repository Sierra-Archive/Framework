<?php
final Class Simulador_Tag_Conexao_DAO extends Framework\App\Dao 
{
    protected $tag;
    protected $motivo;
    protected $motivoid;
    protected $valor;
    protected static $objetocarregado     = false;     protected static $mysql_colunas       = false;     protected static $mysql_outside       = Array();     protected static $mysql_inside        = Array(); public function __construct() {  parent::__construct(); } public static function Get_Nome() {
        return MYSQL_SIMULADOR_TAG_CONEXAO;
    }
    /**
     * Fornece Permissão de Copia da tabela
     * @return string
     */
    public static function Permissao_Copia() {
        return false;
    }
    public static function Get_Sigla() {
        return 'SiTC';
    }
    public static function Get_LinkTable() {
        return Array(
            'SiT'      =>'tag',
            'CP'       =>'motivoid',
        );
        $links = self::Mod_Conexao_Get_Siglas();
        $array = Array('SiT'         =>  'tag');
        if (!empty($links)) {
            foreach($links as &$valor) {
                $array[$valor] = 'motivoid';
            }
        }
        return $array;
    }
    public static function Get_Engine() {
        return 'InnoDB';
    }
    public static function Get_Charset() {
        return 'latin1';
    }
    public static function Get_Autoadd() {
        return 1;
    }
    public static function Get_Class() {
        return get_class() ; //return str_replace(Array('_DAO'), Array(''), get_class());
    }
    public static function Gerar_Colunas() {
        return Array(
            Array(
                'mysql_titulo'      => 'tag',
                'mysql_tipovar'     => 'int', //varchar, int, 
                'mysql_tamanho'     => 11,
                'mysql_null'        => FALSE,
                'mysql_default'     => FALSE,
                'mysql_primary'     => TRUE,
                'mysql_estrangeira' => 'SiT.id|SiT.nome', // chave estrangeira
                'mysql_autoadd'     => FALSE,
                'mysql_comment'     => FALSE,
                'mysql_inside'      => FALSE, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => FALSE, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => FALSE, //permissao funcional necessaria para campo 2 todos 
            ),Array(
                'mysql_titulo'      => 'motivo',
                'mysql_tipovar'     => 'varchar', //varchar, int, 
                'mysql_tamanho'     => 100,
                'mysql_null'        => TRUE,
                'mysql_default'     => 'Comercio_Produto',
                'mysql_primary'     => TRUE,
                'mysql_estrangeira' => FALSE, // chave estrangeira
                'mysql_autoadd'     => FALSE,
                'mysql_comment'     => FALSE,
                'mysql_inside'      => FALSE, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => FALSE, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => FALSE, //permissao funcional necessaria para campo 2 todos 
                'linkextra'         => '', // //0 ninguem, 1 admin, 2 todos 
                /*'edicao'            => Array(
                    'Nome'              => __('Motivo'),
                    'valor_padrao'      => FALSE,
                    'readonly'          => FALSE,
                    'aviso'             => __('Minimo 3 caracteres'),
                    'formtipo'          => 'input',
                    'input'             => array(
                        'tipo'              => 'text',
                        'class'             => 'obrigatorio'
                    )
                )*/
            ),Array(
                'mysql_titulo'      => 'motivoid',
                'mysql_tipovar'     => 'varchar', //varchar, int, 
                'mysql_tamanho'     => 30,
                'mysql_null'        => TRUE,
                'mysql_default'     => FALSE,
                'mysql_primary'     => TRUE,
                'mysql_estrangeira' => FALSE, // chave estrangeira
                'mysql_autoadd'     => FALSE,
                'mysql_comment'     => FALSE,
                'mysql_inside'      => FALSE, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => FALSE, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => FALSE, //permissao funcional necessaria para campo 2 todos 
                'linkextra'         => '', // //0 ninguem, 1 admin, 2 todos 
                'edicao'            => Array(
                    'Nome'              => __('Id do Motivo'),
                    'Mascara'           => 'Numero',
                    'valor_padrao'      => FALSE,
                    'readonly'          => FALSE,
                    'aviso'             => __('Minimo 3 caracteres'),
                    'formtipo'          => 'input',
                    'input'             => array(
                        'tipo'              => 'text',
                        'class'             => 'obrigatorio'
                    )
                )
            ),Array(
                'mysql_titulo'      => 'valor',
                'mysql_tipovar'     => 'varchar', //varchar, int, 
                'mysql_tamanho'     => 100,
                'mysql_null'        => TRUE,
                'mysql_default'     => FALSE,
                'mysql_primary'     => FALSE,
                'mysql_estrangeira' => FALSE, // chave estrangeira
                'mysql_autoadd'     => FALSE,
                'mysql_comment'     => FALSE,
                'mysql_inside'      => FALSE, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => FALSE, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => FALSE, //permissao funcional necessaria para campo 2 todos 
                'linkextra'         => '', // //0 ninguem, 1 admin, 2 todos 
                'edicao'            => Array(
                    'Nome'              => __('Valor para {nome}'),
                    'valor_padrao'      => FALSE,
                    'readonly'          => FALSE,
                    'aviso'             => '',
                    'formtipo'          => 'input',
                    'input'             => array(
                        'tipo'              => 'text',
                        'class'             => 'obrigatorio'
                    )
                )
            )
        );
    }
    private static function Mod_Conexao() {
        return Array(
            'comercio|Produto'                  => Array(                
                'nome'      =>  'Caracteristica de Produtos',   
                'chave_nome'=>  'Produtos',             
                'chave'     =>  'comercio_Produto',  
                'sigla'     =>  'CP',
             ),
        );
    }
    /**
     * 
     * @param type $tipo (Chave)
     * @return type
     * @throws Exception
     */
    public static function Mod_Conexao_Get($tipo=false) {
        if ($tipo!==false) {
            $array = Array();
            // Percorre os modulos que aceitam tags
            $percorrer = Simulador_Tag_Conexao_DAO::Mod_Conexao();
            foreach($percorrer as &$value) {
                if (strtoupper($tipo)===strtoupper($value['chave'])) return $value;
            }
            return _Sistema_erroControle::Erro_Fluxo('Tag de Conexão não encontrado. Tipo:'.$tipo,404);
        } else {
            $array = Array();
            // Percorre os modulos que aceitam tags
            $percorrer = Simulador_Tag_Conexao_DAO::Mod_Conexao();
            foreach($percorrer as $indice=>&$value) {
                // Verifica se é do modulo inteiro ou de um submodulo
                if (strpos($indice, '|')===false) {
                    $modulo     = $indice;
                    $submodulo  = false;
                } else {
                    $indice = explode('|',$indice);
                    $modulo     = $indice[0];
                    $submodulo  = $indice[1];
                }
                // Verifica se o modulo é permitido
                if (\Framework\App\Sistema_Funcoes::Perm_Modulos($modulo,$submodulo)) {
                   $array[] = $value;
                }
            }
            return $array;
        }
    }
    public static function Mod_Conexao_Get_Nome($chave) {
        // Percorre os modulos que aceitam tags
        $percorrer = self::Mod_Conexao();
        foreach($percorrer as &$value) {
            if (strtoupper($chave)===strtoupper($value['chave'])) {
                return $value['nome'];
            }
        }
        return _Sistema_erroControle::Erro_Fluxo('Tag de Conexão não encontrado. '.$chave,404);
    }
    public static function Mod_Conexao_Get_Chave() {
        $repassar = self::Mod_Conexao_Get();
        foreach($repassar AS &$valor) {
            $valor = $valor['chave'];
        }
        return $repassar;
    }
    public static function Mod_Conexao_Get_Siglas() {
        $repassar = self::Mod_Conexao_Get();
        foreach($repassar AS &$valor) {
            $valor = $valor['sigla'];
        }
        return $repassar;
    }
}
?>
