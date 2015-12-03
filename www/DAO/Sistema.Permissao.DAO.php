<?php
final Class Sistema_Permissao_DAO extends Framework\App\Dao 
{
    protected $chave;
    protected $modulo;
    protected $submodulo;
    protected $metodo;
    protected $end;
    protected $nome;
    protected $descricao;
    
    // Padrao é false, ou array com os campos que nao aceita
    protected static $aceita_config       = false;
    protected static $campos_naoaceita_config  = Array('chave', 'modulo', 'submodulo', 'metodo', 'end');
    protected static $objetocarregado     = false;     protected static $mysql_colunas       = false;     protected static $mysql_outside       = Array();     protected static $mysql_inside        = Array(); public function __construct() {  parent::__construct(); } public static function Get_Nome() {
        return MYSQL_SIS_PERMISSAO;
    }
    /**
     * Fornece Permissão de Copia da tabela
     * @return string
     */
    public static function Permissao_Copia() {
        return false;
    }
    public static function Get_Sigla() {
        return 'SP';
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
                'mysql_titulo'      => 'chave',
                'mysql_tipovar'     => 'varchar', //varchar, int, 
                'mysql_tamanho'     => 100,
                'mysql_null'        => true,  // nulo ?
                'mysql_default'     => 'Sem nome', // valor padrao
                'mysql_primary'     => true,  // chave primaria
                'mysql_estrangeira' => false, // chave estrangeira     ligacao|apresentacao|condicao
                'mysql_autoadd'     => false,
                'mysql_comment'     => false,
                'mysql_inside'      => false, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => false, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false, //permissao funcional necessaria para campo 2 todos 
                'linkextra'         => '', //0 ninguem, 1 admin, 2 todos 
                'edicao'            => Array(
                    'Nome'              => __('Chave'),
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => __('Minimo 3 caracteres'),
                    'formtipo'          => 'input',
                    'input'             => array(
                        'tipo'              => 'text',
                        'class'             => 'obrigatorio'
                    )
                )
            ),Array(
                'mysql_titulo'      => 'modulo',
                'mysql_tipovar'     => 'varchar', //varchar, int, 
                'mysql_tamanho'     => 200,
                'mysql_null'        => true,  // nulo ?
                'mysql_default'     => 'Sem nome', // valor padrao
                'mysql_primary'     => false,  // chave primaria
                'mysql_estrangeira' => false, // chave estrangeira     ligacao|apresentacao|condicao
                'mysql_autoadd'     => false,
                'mysql_comment'     => false,
                'mysql_inside'      => false, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => false, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false, //permissao funcional necessaria para campo 2 todos 
                'linkextra'         => '', //0 ninguem, 1 admin, 2 todos 
                'edicao'            => Array(
                    'Nome'              => __('Modulo'),
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => __('Somente Letras'),
                    'formtipo'          => 'input',
                    'input'             => array(
                        'tipo'              => 'text',
                        'class'             => 'obrigatorio masc_letras'
                    )
                )
            ),Array(
                'mysql_titulo'      => 'submodulo',
                'mysql_tipovar'     => 'varchar', //varchar, int, 
                'mysql_tamanho'     => 200,
                'mysql_null'        => true,  // nulo ?
                'mysql_default'     => 'Sem nome', // valor padrao
                'mysql_primary'     => false,  // chave primaria
                'mysql_estrangeira' => false, // chave estrangeira     ligacao|apresentacao|condicao
                'mysql_autoadd'     => false,
                'mysql_comment'     => false,
                'mysql_inside'      => false, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => false, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false, //permissao funcional necessaria para campo 2 todos 
                'linkextra'         => '', //0 ninguem, 1 admin, 2 todos 
                'edicao'            => Array(
                    'Nome'              => __('SubModulo'),
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => __('Somente Letras'),
                    'formtipo'          => 'input',
                    'input'             => array(
                        'tipo'              => 'text',
                        'class'             => 'obrigatorio masc_letras'
                    )
                )
            ),Array(
                'mysql_titulo'      => 'metodo',
                'mysql_tipovar'     => 'varchar', //varchar, int, 
                'mysql_tamanho'     => 200,
                'mysql_null'        => true,  // nulo ?
                'mysql_default'     => 'Sem nome', // valor padrao
                'mysql_primary'     => false,  // chave primaria
                'mysql_estrangeira' => false, // chave estrangeira     ligacao|apresentacao|condicao
                'mysql_autoadd'     => false,
                'mysql_comment'     => false,
                'mysql_inside'      => false, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => false, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false, //permissao funcional necessaria para campo 2 todos 
                'linkextra'         => '', //0 ninguem, 1 admin, 2 todos 
                'edicao'            => Array(
                    'Nome'              => __('Metodo'),
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => '* Ou separado por ,',
                    'formtipo'          => 'input',
                    'input'             => array(
                        'tipo'              => 'text',
                        'class'             => 'obrigatorio'
                    )
                )
            ),
            Array(
                'mysql_titulo'      => 'end',
                'mysql_tipovar'     => 'varchar', //varchar, int, 
                'mysql_tamanho'     => 200,
                'mysql_null'        => true,  // nulo ?
                'mysql_default'     => 'Sem nome', // valor padrao
                'mysql_primary'     => false,  // chave primaria
                'mysql_estrangeira' => false, // chave estrangeira     ligacao|apresentacao|condicao
                'mysql_autoadd'     => false,
                'mysql_comment'     => false,
                'mysql_inside'      => false, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => false, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false, //permissao funcional necessaria para campo 2 todos 
                'linkextra'         => '', //0 ninguem, 1 admin, 2 todos 
                'edicao'            => Array(
                    'Nome'              => __('Endereço'),
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => __('Minimo 3 caracteres'),
                    'formtipo'          => 'input',
                    'input'             => array(
                        'tipo'              => 'text',
                        'class'             => 'obrigatorio'
                    )
                )
            ),
            Array(
                'mysql_titulo'      => 'nome',
                'mysql_tipovar'     => 'varchar', //varchar, int, 
                'mysql_tamanho'     => 100,
                'mysql_null'        => true,  // nulo ?
                'mysql_default'     => 'Sem nome', // valor padrao
                'mysql_primary'     => false,  // chave primaria
                'mysql_estrangeira' => false, // chave estrangeira     ligacao|apresentacao|condicao
                'mysql_autoadd'     => false,
                'mysql_comment'     => false,
                'mysql_inside'      => false, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => false, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false, //permissao funcional necessaria para campo 2 todos 
                'linkextra'         => '', //0 ninguem, 1 admin, 2 todos 
                'edicao'            => Array(
                    'Nome'              => __('Nome Completo'),
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => __('Apenas letras'),
                    'formtipo'          => 'input',
                    'input'             => array(
                        'tipo'              => 'text',
                        'class'             => 'obrigatorio masc_letras'
                    )
                )
            ),
            Array(
                'mysql_titulo'      => 'descricao',
                'mysql_tipovar'     => 'varchar', //varchar, int, 
                'mysql_tamanho'     => 100,
                'mysql_null'        => true,  // nulo ?
                'mysql_default'     => 'Sem nome', // valor padrao
                'mysql_primary'     => false,  // chave primaria
                'mysql_estrangeira' => false, // chave estrangeira     ligacao|apresentacao|condicao
                'mysql_autoadd'     => false,
                'mysql_comment'     => false,
                'mysql_inside'      => false, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => false, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false, //permissao funcional necessaria para campo 2 todos 
                'linkextra'         => '', //0 ninguem, 1 admin, 2 todos 
                'edicao'            => Array(
                    'Nome'              => __('Descrição'),
                    'valor_padrao'      => false,
                    'readonly'          => false,
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
}

