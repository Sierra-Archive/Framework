<?php
final Class Comercio_Certificado_Auditoria_DAO extends Framework\App\Dao 
{
    protected $id;
    protected $idproduto;
    protected $ordem;
    protected $meses;
    protected static $objetocarregado     = false;     protected static $mysql_colunas       = false;     protected static $mysql_outside       = Array();     protected static $mysql_inside        = Array(); public function __construct() {  parent::__construct(); } public static function Get_Nome() {
        return MYSQL_COMERCIO_CERTIFICADO_AUDITORIA;
    }
    /**
     * Fornece Permissão de Copia da tabela
     * @return string
     */
    public static function Permissao_Copia() {
        return false;
    }
    public static function Get_Sigla() {
        return 'CCA';
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
                'mysql_null'        => FALSE,
                'mysql_default'     => FALSE,
                'mysql_primary'     => TRUE,
                'mysql_estrangeira' => FALSE, // chave estrangeira
                'mysql_autoadd'     => TRUE,
                'mysql_comment'     => FALSE,
                'mysql_inside'      => FALSE, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => FALSE, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => FALSE, //permissao funcional necessaria para campo 2 todos 
                'linkextra'         => '' ,//0 ninguem, 1 admin, 2 todos 
            ),Array(
                'mysql_titulo'      => 'idproduto',
                'mysql_tipovar'     => 'int', //varchar, int, 
                'mysql_tamanho'     => 11,
                'mysql_null'        => FALSE,
                'mysql_default'     => FALSE,
                'mysql_primary'     => FALSE,
                'mysql_estrangeira' => 'CP.id|CP.nome', // chave estrangeira
                'mysql_autoadd'     => FALSE,
                'mysql_comment'     => FALSE,
                'mysql_inside'      => FALSE, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => FALSE, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => FALSE, //permissao funcional necessaria para campo 2 todos 
                'linkextra'         => 'comercio/Produto/Produtos_Add',
                'edicao'            => Array(
                    'Nome'              => __('Produto'),
                    'valor_padrao'      => FALSE,
                    'readonly'          => FALSE,
                    'aviso'             => ''
                )
            ),Array(
                'mysql_titulo'      => 'ordem',
                'mysql_tipovar'     => 'int', //varchar, int, 
                'mysql_tamanho'     => 11,
                'mysql_null'        => TRUE,
                'mysql_default'     => FALSE,
                'mysql_primary'     => FALSE,
                'mysql_estrangeira' => FALSE, // chave estrangeira
                'mysql_autoadd'     => FALSE,
                'mysql_comment'     => FALSE,
                'mysql_inside'      => FALSE, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => FALSE, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => FALSE, //permissao funcional necessaria para campo 2 todos 
                'linkextra'         => ''
            ),Array(
                'mysql_titulo'      => 'meses',
                'mysql_tipovar'     => 'int', //varchar, int, 
                'mysql_tamanho'     => 11,
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
                    'Nome'              => __('Meses'),
                    'Mascara'           => 'Numero',
                    'valor_padrao'      => FALSE,
                    'readonly'          => FALSE,
                    'aviso'             => __('Em relação a Auditoria Anterior'),
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
