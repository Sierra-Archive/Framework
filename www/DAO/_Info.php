<?php
/*
 * 
 * 
 * 
 * 
 */
final Class Predial_Bloco_Apart_DAO extends Framework\App\Dao 
{
    protected $id;
    protected $bloco;
    protected $num;
    protected $morador;
    
    // Padrao é true, com FALSE, a tabela nao é transformada em maiuscula
    protected static $aceita_config         = FALSE;
    // Padrao é FALSE, ou array com os campos que nao aceita
    protected static $campos_naoaceita_config  = Array('email', 'email2');
    
    protected static $objetocarregado     = FALSE;     protected static $mysql_colunas       = FALSE;     protected static $mysql_outside       = Array();     protected static $mysql_inside        = Array(); public function __construct() {  parent::__construct(); } public static function Get_Nome() {
        return MYSQL_PREDIAL_BLOCO_APART;
    }
    /**
     * Fornece Permissão de Copia da tabela
     * @return string
     */
    public static function Permissao_Copia() {
        return FALSE;
    }
    public static function Get_Sigla() {
        return 'PBA';
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
            /* [ x N ] INICIO */
            Array(
                'mysql_titulo'      => 'idproduto', // Nome do Campo no MYSQL
                'mysql_tipovar'     => 'int', //varchar, int, 
                'mysql_tamanho'     => 11, // Tamanho no Mysql
                'mysql_null'        => FALSE,
                'mysql_default'     => FALSE,
                'mysql_primary'     => FALSE,
                'mysql_indice_unico'=> 'num', // Se pode repetir = FALSE, se nao, 
                                              // o conjunto de campos que não podem repetir
                                              // possuem o mesmo nome neste valor
                'mysql_estrangeira' => 'CP.id|CP.nome', // chave estrangeira
                'form_change'       => '', // CHANGE PARA EXTRANGEIRAS -> Sigla Tabela Pai / Sigla Tabela Atual ou false
                'mysql_autoadd'     => FALSE,
                'mysql_comment'     => FALSE,
                'mysql_inside'      => FALSE, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => FALSE, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => FALSE, //permissao funcional necessaria para campo 2 todos 
                'linkextra'         => 'comercio/Produto/Produtos_Add',
                // Edicao sao as Partes Visuais do Formulario
                'edicao'            => Array(
                    'Nome'              => __('Produto'),
                    'Mascara'           => 'Numero', // MAscara, pode ser FALSE, ou Real, Numero, Porc, etc...
                    'valor_padrao'      => FALSE,
                    'change'            => '',
                    'readonly'          => FALSE, // Somente Leitura
                    'aviso'             => '',
                    /* Aqui embaixo não precisa se tiver chave extrangeira, pq preenche sózinho*/
                    'formtipo'          => 'input', // input, select, textarea
                    'input'             => array( // Indice respectivamente -> input, select, textarea, igual acima
                        'tipo'              => 'text', // text, password, hidden, etc..
                        /**
                         * Caso o tipo seja range pode ter mais dois em seguida
                         * 
                        'range_min'         => '0',
                        'range_max'         => '5',
                         */
                        'class'             => 'obrigatorio', // obrigatorio -> Torna o Campo Obrigatorio
                                                              // Tambem Pode Colocar qualquer outra classe, que ira entrar no input
                    ),
                    // Caso Select
                    'formtipo'          => 'select', // input, select, textarea
                    'select'             => array( // Indice respectivamente -> input, select, textarea, igual acima
                        'class'             => 'obrigatorio', // obrigatorio -> Torna o Campo Obrigatorio
                                                              // Tambem Pode Colocar qualquer outra classe, que ira entrar no input
                        'multiplo'          => FALSE, // false/true
                        'infonulo'          => 'Escolha uma Opção' //-> Select quando nulo
                    ),
                    /**/
                )
            )
            /* [ x N ] FIM */
            // Opcoes para Tabela Extrangeira
            ,
            Array(
                'TabelaLinkada'     => Array(
                    'Pai'               => 'N', // TABELA que vai manipular a conexao
                    'Tabela'            => 'NR', // TABELA de LINK A SER CONECTADA
                    'Preencher'         => Array( // CAso exista e != de FALSE, preenche automaticamente esses campos
                        'tabela'            => 'Musica_Album_Artista', // Campo e Resultado
                    ),
                    'valor_padrao'      => FALSE, // ID do pai, usada para edicao, sempre false por padrao
                    'Nome'              => __('Artistas'), // Nome no FOrmulario
                    'Class'             => 'obrigatorio', // Classe no formulario
                    'aviso'             => '', // Aviso no formulario
                    'formtipo'          => 'SelectMultiplo',  // Tipo de formulario
                    'SelectMultiplo'   => Array(
                        'Extrangeira'       => 'MAA.id|MAA.nome',
                        'Linkar'            => 'noticia', // CAmpo a ser encaixado id do pai
                        'Linkado'           => 'tabelaid',// CAmpo a ser encaixado id do link
                        'Campos'            => FALSE, // CAmpos extras da tabela de ligacao
                        'infonulo'          => 'Escolha pelo menos um Artista', // Informacao quando nada é clicado
                      'linkextra'         => false ,// Caso tenha atalho pra add
                    ), // Campo Boleano da tabela LINK, caso false apaga os que nao forem puxados
                )
            )
        );
    }
}
/*
 * 
 * 
 * 
 * 
 * 
 */

/**
 * Para Colunas Linkadas
 * 
 */