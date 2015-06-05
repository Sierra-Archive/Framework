<?php
final Class Financeiro_Pagamento_Forma_Condicao_DAO extends Framework\App\Dao 
{
    protected $id;
    protected $forma_pagar;
    protected $nome;
    protected $parcelas;
    protected $entrada;
    protected static $objetocarregado     = false;     protected static $mysql_colunas       = false;     protected static $mysql_outside       = Array();     protected static $mysql_inside        = Array(); public function __construct() {  parent::__construct(); } public static function Get_Nome(){
        return MYSQL_FINANCEIRO_FINANCEIRO_FORMA_CONDICAO;
    }
    /**
     * Fornece Permissão de Copia da tabela
     * @return string
     */
    public static function Permissao_Copia(){
        return false;
    }
    public static function Get_Sigla(){
        return 'FPFC';
    }
    public static function Get_Engine(){
        return 'InnoDB';
    }
    public static function Get_Charset(){
        return 'latin1';
    }
    public static function Get_Autoadd(){
        return 1;
    }
    public static function Get_Class(){
        return get_class() ; //return str_replace(Array('_DAO'), Array(''), get_class());
    }
    public static function Gerar_Colunas(){
        return Array(
            Array(
                'mysql_titulo'      => 'id',
                'mysql_tipovar'     => 'int', //varchar, int, 
                'mysql_tamanho'     => 255,
                'mysql_null'        => false,
                'mysql_default'     => false,
                'mysql_primary'     => true,
                'mysql_estrangeira' => false, // chave estrangeira
                'mysql_autoadd'     => true,
                'mysql_comment'     => false,
                'mysql_inside'      => false, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => false, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false, //permissao funcional necessaria para campo 2 todos 
                'linkextra'         => '' ,//0 ninguem, 1 admin, 2 todos 
            ),
            Array(
                'mysql_titulo'      => 'forma_pagar',
                'mysql_tipovar'     => 'int', //varchar, int, 
                'mysql_tamanho'     => 11,
                'mysql_null'        => true,  // nulo ?
                'mysql_default'     => 0, // valor padrao
                'mysql_primary'     => false,  // chave primaria
                'mysql_estrangeira' => 'FPF.id|FPF.nome', // chave estrangeira     ligacao|apresentacao|condicao
                'mysql_autoadd'     => false,
                'mysql_comment'     => false,
                'mysql_inside'      => false, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => false, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false, //permissao funcional necessaria para campo 2 todos 
                'linkextra'         => 'Financeiro/Pagamento/Formas_Add/', //0 ninguem, 1 admin, 2 todos 
                'edicao'            => Array(
                    'Nome'              => __('Forma de Pagamento'),
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => '',
                    'formtipo'          => 'select',
                    'select'             => array(
                        'class'             => 'obrigatorio',
                        'infonulo'          => 'Escolha uma Forma de Pagamento',
                    )
                )
            ),Array(
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
                'linkextra'         => '', // //0 ninguem, 1 admin, 2 todos 
                'edicao'            => Array(
                    'Nome'              => __('Nome da Condição'),
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
                'mysql_titulo'      => 'parcelas',
                'mysql_tipovar'     => 'int', //varchar, int, 
                'mysql_tamanho'     => 3,
                'mysql_null'        => true,  // nulo ?
                'mysql_default'     => 1, // valor padrao
                'mysql_primary'     => false,  // chave primaria
                'mysql_estrangeira' => false, // chave estrangeira     ligacao|apresentacao|condicao
                'mysql_autoadd'     => false,
                'mysql_comment'     => false,
                'mysql_inside'      => false, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => false, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false, //permissao funcional necessaria para campo 2 todos 
                'edicao'            => Array(
                    'Nome'              => 'N° de Parcelas',
                    'valor_padrao'      => 0,
                    'readonly'          => false,
                    'aviso'             => '',
                    'formtipo'          => 'select',
                    'select'            => array(
                        'class'             => 'obrigatorio',
                        'infonulo'          => 'Escolha a quantidade de parcelas',
                        'opcoes'            => array(
                            array(
                                'value'         => '30',
                                'nome'          => '30 Parcelas'
                            ),
                            array(
                                'value'         => '29',
                                'nome'          => '29 Parcelas'
                            ),
                            array(
                                'value'         => '28',
                                'nome'          => '28 Parcelas'
                            ),
                            array(
                                'value'         => '27',
                                'nome'          => '27 Parcelas'
                            ),
                            array(
                                'value'         => '26',
                                'nome'          => '26 Parcelas'
                            ),
                            array(
                                'value'         => '25',
                                'nome'          => '25 Parcelas'
                            ),
                            array(
                                'value'         => '24',
                                'nome'          => '24 Parcelas'
                            ),
                            array(
                                'value'         => '23',
                                'nome'          => '23 Parcelas'
                            ),
                            array(
                                'value'         => '22',
                                'nome'          => '22 Parcelas'
                            ),
                            array(
                                'value'         => '21',
                                'nome'          => '21 Parcelas'
                            ),
                            array(
                                'value'         => '20',
                                'nome'          => '20 Parcelas'
                            ),
                            array(
                                'value'         => '19',
                                'nome'          => '19 Parcelas'
                            ),
                            array(
                                'value'         => '18',
                                'nome'          => '18 Parcelas'
                            ),
                            array(
                                'value'         => '17',
                                'nome'          => '17 Parcelas'
                            ),
                            array(
                                'value'         => '16',
                                'nome'          => '16 Parcelas'
                            ),
                            array(
                                'value'         => '15',
                                'nome'          => '15 Parcelas'
                            ),
                            array(
                                'value'         => '14',
                                'nome'          => '14 Parcelas'
                            ),
                            array(
                                'value'         => '13',
                                'nome'          => '13 Parcelas'
                            ),
                            array(
                                'value'         => '12',
                                'nome'          => '12 Parcelas'
                            ),
                            array(
                                'value'         => '11',
                                'nome'          => '11 Parcelas'
                            ),
                            array(
                                'value'         => '10',
                                'nome'          => '10 Parcelas'
                            ),
                            array(
                                'value'         => '9',
                                'nome'          => '9 Parcelas'
                            ),
                            array(
                                'value'         => '8',
                                'nome'          => '8 Parcelas'
                            ),
                            array(
                                'value'         => '7',
                                'nome'          => '7 Parcelas'
                            ),
                            array(
                                'value'         => '6',
                                'nome'          => '6 Parcelas'
                            ),
                            array(
                                'value'         => '5',
                                'nome'          => '5 Parcelas'
                            ),
                            array(
                                'value'         => '4',
                                'nome'          => '4 Parcelas'
                            ),
                            array(
                                'value'         => '3',
                                'nome'          => '3 Parcelas'
                            ),
                            array(
                                'value'         => '2',
                                'nome'          => '2 Parcelas'
                            ),
                            array(
                                'value'         => '1',
                                'nome'          => '1 Parcela'
                            ),
                            array(
                                'value'         => '0',
                                'nome'          => 'Nenhuma Parcela'
                            ),
                        )
                    )
                )
            ),Array(
                'mysql_titulo'      => 'entrada',
                'mysql_tipovar'     => 'float', //varchar, int, 
                'mysql_tamanho'     => 8,
                'mysql_null'        => true,
                'mysql_default'     => false,
                'mysql_primary'     => false,
                'mysql_estrangeira' => false, // chave estrangeira
                'mysql_autoadd'     => false,
                'mysql_comment'     => false,
                'mysql_inside'      => '\Framework\App\Sistema_Funcoes::Tranf_Porc_Float({valor})', // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => '\Framework\App\Sistema_Funcoes::Tranf_Float_Porc({valor})', // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false, //permissao funcional necessaria para campo 2 todos 
                'linkextra'         => '', // //0 ninguem, 1 admin, 2 todos 
                'edicao'            => Array(
                    'Nome'              => __('Entrada'),
                    'Mascara'           => 'Porc',
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
        );
    }
}
?>
