<?php
final Class Simulador_Tag_DAO extends Framework\App\Dao 
{
    protected $id;
    protected $nome;
    protected $resultado_tipo;
    protected $obs;
    protected static $objetocarregado     = false;     protected static $mysql_colunas       = false;     protected static $mysql_outside       = Array();     protected static $mysql_inside        = Array(); public function __construct() {  parent::__construct(); } public static function Get_Nome() {
        return MYSQL_SIMULADOR_TAG;
    }
    /**
     * Fornece Permissão de Copia da tabela
     * @return string
     */
    public static function Permissao_Copia() {
        return false;
    }
    public static function Get_Sigla() {
        return 'SiT';
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
                'mysql_titulo'      => 'id',
                'mysql_tipovar'     => 'int', //varchar, int, 
                'mysql_tamanho'     => 11,
                'mysql_null'        => false,
                'mysql_default'     => false,
                'mysql_primary'     => true,
                'mysql_estrangeira' => false, // chave estrangeira
                'mysql_autoadd'     => true,
                'mysql_comment'     => false,
                'mysql_inside'      => false, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => false, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false, //permissao funcional necessaria para campo 2 todos
            ),
            Array(
                'mysql_titulo'      => 'nome',
                'mysql_tipovar'     => 'varchar', //varchar, int, 
                'mysql_tamanho'     => 100,
                'mysql_null'        => true,
                'mysql_default'     => false,
                'mysql_primary'     => false,
                'mysql_estrangeira' => false, // chave estrangeira
                'mysql_autoadd'     => false,
                'mysql_comment'     => false,
                'mysql_inside'      => false, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => false, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false, //permissao funcional necessaria para campo 2 todos 
                'linkextra'         => '',
                'edicao'            => Array(
                    'Nome'              => __('Nome'),
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => '',
                    'formtipo'          => 'input',
                    'input'             => array(
                        'tipo'              => 'text',
                        'class'             => 'obrigatorio'
                    )
                )
            ),
            Array(
                'mysql_titulo'      => 'resultado_tipo',
                'mysql_tipovar'     => 'varchar', //varchar, int, 
                'mysql_tamanho'     => 30,
                'mysql_null'        => false,  // nulo ?
                'mysql_default'     => 1, // valor padrao
                'mysql_primary'     => false,  // chave primaria
                'mysql_estrangeira' => false, // chave estrangeira     ligacao|apresentacao|condicao
                'mysql_autoadd'     => false,
                'mysql_comment'     => false,
                'mysql_inside'      => false, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => false, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false, //permissao funcional necessaria para campo 2 todos 
                'linkextra'         => '', //0 ninguem, 1 admin, 2 todos 
                'edicao'            => Array(
                    'Nome'              => __('Tipo de Resultado Aceito'),
                    'valor_padrao'      => 1,
                    'readonly'          => false,
                    'aviso'             => '',
                    'formtipo'          => 'select',
                    'select'            => array(
                        'class'             => 'obrigatorio',
                        'opcoes'            => array(
                            array(
                                'value'         =>  'Texto',
                                'nome'          => 'Texto'
                            ),
                            array(
                                'value'         =>  'Inteiro',
                                'nome'          => 'Inteiro'
                            ),
                        )
                    )
                )
            ),
            /*Array(
                'TabelaLinkada'     => Array(
                    'Pai'               => 'C', // TABELA que vai manipular a conexao
                    'Tabela'            => 'CA', // TABELA de LINK A SER CONECTADA
                    'valor_padrao'      => false, // ID DO PAI
                    'Nome'              => __('Modulos Liberados'), // Nome no FOrmulario
                    'Class'             => '', // Classe no formulario
                    'aviso'             => '', // Aviso no formulario
                    'formtipo'          => 'BoleanoMultiplo',  // Tipo de formulario
                    'BoleanoMultiplo'   => Array(
                        'campoid'           => 'id', // CAmpo de conexao
                        'campomostrar'      => 'nome', // Campo mostrar
                        'Col1'              => 'Não Liberar', // Nome da 1 Coluna (Nao Selecionada)
                        'Col2'              => 'Liberar', // Nome da 2 Coluna (Selecionadas)
                        'Valor'             => false
                    ), // Campo Boleano da tabela LINK, caso false apaga os que nao forem puxados
                )
            ),*/
            Array(
                'mysql_titulo'      => 'obs',
                'mysql_tipovar'     => 'longtext', //varchar, int, 
                'mysql_tamanho'     => 10000,
                'mysql_null'        => false,  // nulo ?
                'mysql_default'     => false, // valor padrao
                'mysql_primary'     => false,  // chave primaria
                'mysql_estrangeira' => false, // chave estrangeira     ligacao|apresentacao|condicao
                'mysql_autoadd'     => false,
                'mysql_comment'     => false,
                'mysql_inside'      => false, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => false, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false, //permissao funcional necessaria para campo 2 todos 
                'edicao'            => Array(
                    'Nome'              => __('Observação'),
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => '',
                    'formtipo'          =>'textarea',
                    'textarea'             => array(
                        'tipo'              => 'text',
                        'class'             => ''
                    )
                )
            )
        );
    }
}
?>
