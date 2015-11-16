<?php
final Class Comercio_Servicos_Linha_DAO extends Framework\App\Dao 
{
    protected $id;
    protected $btu;
    protected $distancia;
    protected $valor;
    protected static $objetocarregado     = false;     protected static $mysql_colunas       = false;     protected static $mysql_outside       = Array();     protected static $mysql_inside        = Array(); public function __construct() {  parent::__construct(); } public static function Get_Nome() {
        return MYSQL_COMERCIO_SERVICO_LINHA;
    }
    /**
     * Fornece Permissão de Copia da tabela
     * @return string
     */
    public static function Permissao_Copia() {
        return false;
    }
    public static function Get_Sigla() {
        return 'CSL';
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
                'mysql_tamanho'     => 255,
                'mysql_null'        => FALSE,
                'mysql_default'     => FALSE,
                'mysql_primary'     => TRUE,
                'mysql_estrangeira' => FALSE, // chave estrangeira
                'mysql_autoadd'     => TRUE,
                'mysql_comment'     => FALSE,
                'mysql_inside'      => FALSE, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => FALSE, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => FALSE, //permissao funcional necessaria para campo 2 todos 
            ),
            Array(
                'mysql_titulo'      => 'btu',
                'mysql_tipovar'     => 'int', //varchar, int, 
                'mysql_tamanho'     => 11,
                'mysql_null'        => TRUE,  // nulo ?
                'mysql_default'     => FALSE, // valor padrao
                'mysql_primary'     => FALSE,  // chave primaria
                'mysql_estrangeira' => 'CSB.id|CSB.nome', // chave estrangeira     ligacao|apresentacao|condicao
                'mysql_autoadd'     => FALSE,
                'mysql_comment'     => FALSE,
                'mysql_inside'      => FALSE, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => FALSE, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => FALSE, //permissao funcional necessaria para campo
                'linkextra'         => 'comercio_servicos/Instalacao/Btu_Add', //0 ninguem, 1 admin, 2 todos 
                'edicao'            => Array(
                    'Nome'              => __('Btu'),
                    'valor_padrao'      => FALSE,
                    'readonly'          => FALSE,
                    'aviso'             => '',
                    'formtipo'          => 'select',
                    'select'             => array(
                        'class'             => 'obrigatorio',
                        'infonulo'          => 'Escolha um Btu',
                    )
                )
            ),Array(
                'mysql_titulo'      => 'distancia',
                'mysql_tipovar'     => 'varchar', //varchar, int, 
                'mysql_tamanho'     => 100,
                'mysql_null'        => FALSE,
                'mysql_default'     => 'Entre 0 e 5 metros', // valor padrao
                'mysql_primary'     => FALSE,
                'mysql_estrangeira' => FALSE, // chave estrangeira
                'mysql_autoadd'     => FALSE,
                'mysql_comment'     => FALSE,
                'mysql_inside'      => FALSE, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => FALSE, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => FALSE, //permissao funcional necessaria para campo 2 todos 
                'edicao'            => Array(
                    'Nome'              => __('Distância'),
                    'valor_padrao'      => FALSE,
                    'readonly'          => FALSE,
                    'aviso'             => '',
                    'formtipo'          => 'input',
                    'input'             => array(
                        'tipo'              => 'text',
                        'class'             => 'obrigatorio'
                    )
                )
            ),Array(
                'mysql_titulo'      => 'valor',
                'mysql_tipovar'     => 'float', //varchar, int, 
                'mysql_tamanho'     => 30,
                'mysql_null'        => TRUE,
                'mysql_default'     => FALSE,
                'mysql_primary'     => FALSE,
                'mysql_estrangeira' => FALSE, // chave estrangeira
                'mysql_autoadd'     => FALSE,
                'mysql_comment'     => FALSE,
                'mysql_inside'      => '\Framework\App\Sistema_Funcoes::Tranf_Real_Float({valor})', // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => '\Framework\App\Sistema_Funcoes::Tranf_Float_Real({valor})', // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => FALSE, //permissao funcional necessaria para campo 2 todos 
                'edicao'            => Array(
                    'Nome'              => __('Valor'),
                    'Mascara'           => 'Real',
                    'valor_padrao'      => FALSE,
                    'readonly'          => FALSE,
                    'aviso'             => __('Somente Números'),
                    'formtipo'          => 'input',
                    'input'             => array(
                        'tipo'              => 'text',
                        'class'             => 'obrigatorio'
                    )
                )
            )
        );
    }
}
?>
