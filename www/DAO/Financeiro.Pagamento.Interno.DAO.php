<?php
final Class Financeiro_Pagamento_Interno_DAO extends Framework\App\Dao 
{
    protected $id;
    protected $categoria;
    protected $motivo;
    protected $motivoid;
    protected $entrada_motivo;
    protected $entrada_motivoid;
    protected $saida_motivo;
    protected $saida_motivoid;
    protected $valor;
    protected $valor_juros;
    protected $dt_vencimento;
    protected $dt_pago;
    protected $pago;
    protected $num_parcela;
    protected $forma_pagar;
    protected $forma_condicao;
    protected $obs;
    
    protected static $aceita_config       = false;
    protected static $objetocarregado     = false;     protected static $mysql_colunas       = false;     protected static $mysql_outside       = Array();     protected static $mysql_inside        = Array(); public function __construct() {  parent::__construct(); } public static function Get_Nome() {
        return MYSQL_FINANCEIRO_MOV_INT;
    }
    /**
     * Fornece Permissão de Copia da tabela
     * @return string
     */
    public static function Permissao_Copia() {
        return false;
    }
    public static function Get_Sigla() {
        return 'FMI';
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
                'mysql_null'        => FALSE, // true NULL, false, NOT NULL
                'mysql_default'     => FALSE, //false -> NONE, outro -> default
                'mysql_primary'     => TRUE,
                'mysql_estrangeira' => FALSE, // chave estrangeira
                'mysql_autoadd'     => TRUE,
                'mysql_comment'     => FALSE,
                'mysql_inside'      => FALSE, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => FALSE, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => FALSE, //permissao funcional necessaria para campo 2 todos 
                'linkextra'         => '' ,//0 ninguem, 1 admin, 2 todos 
            ),
            Array(
                'mysql_titulo'      => 'categoria',
                'mysql_tipovar'     => 'int', //varchar, int, 
                'mysql_tamanho'     => 11,
                'mysql_null'        => TRUE, // true NULL, false, NOT NULL
                'mysql_default'     => '0',//false -> NONE, outro -> default
                'mysql_primary'     => FALSE, // chave primaria
                'mysql_estrangeira' => 'C.id|C.nome', // chave estrangeira     ligacao|apresentacao|condicao
                'mysql_autoadd'     => FALSE,
                'mysql_comment'     => FALSE,
                'mysql_inside'      => FALSE, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => FALSE, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => FALSE, //permissao funcional necessaria para campo 2 todos 
                'linkextra'         => 'categoria/Admin/Categorias_Add', //0 ninguem, 1 admin, 2 todos 
                'edicao'            => Array(
                    'Nome'              => __('Categoria'),
                    'valor_padrao'      => '0',
                    'readonly'          => FALSE,
                    'aviso'             => '',
                    'formtipo'          => 'select',
                    'select'             => array(
                        'class'             => 'obrigatorio',
                        'infonulo'          => 'Escolha uma Categoria',
                    )
                )
            ),Array(
                'mysql_titulo'      => 'motivo',
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
                    'Nome'              => __('Motivo'),
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
                'mysql_titulo'      => 'motivoid',
                'mysql_tipovar'     => 'varchar', //varchar, int, 
                'mysql_tamanho'     => 30,
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
                'mysql_titulo'      => 'entrada_motivo',
                'mysql_tipovar'     => 'varchar', //varchar, int, 
                'mysql_tamanho'     => 100,
                'mysql_null'        => TRUE,
                'mysql_default'     => FALSE,
                'mysql_primary'     => FALSE,
                'mysql_estrangeira' => FALSE, // chave estrangeira
                'mysql_autoadd'     => FALSE,
                'mysql_comment'     => 'SERVIDOR ou class dao que esta pagando',
                'mysql_inside'      => FALSE, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => FALSE, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => FALSE, //permissao funcional necessaria para campo 2 todos 
                'linkextra'         => '', // //0 ninguem, 1 admin, 2 todos 
                'edicao'            => Array(
                    'Nome'              => __('Motivo da Entrada'),
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
                'mysql_titulo'      => 'entrada_motivoid',
                'mysql_tipovar'     => 'varchar', //varchar, int, 
                'mysql_tamanho'     => 30,
                'mysql_null'        => TRUE,
                'mysql_default'     => FALSE,
                'mysql_primary'     => FALSE,
                'mysql_estrangeira' => FALSE, // chave estrangeira
                'mysql_autoadd'     => FALSE,
                'mysql_comment'     => 'Identificador ou Chave  que esta pagando',
                'mysql_inside'      => FALSE, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => FALSE, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => FALSE, //permissao funcional necessaria para campo 2 todos 
                'linkextra'         => '', // //0 ninguem, 1 admin, 2 todos 
                'edicao'            => Array(
                    'Nome'              => __('Id do Motivo'),
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
                'mysql_titulo'      => 'saida_motivo',
                'mysql_tipovar'     => 'varchar', //varchar, int, 
                'mysql_tamanho'     => 100,
                'mysql_null'        => TRUE,
                'mysql_default'     => FALSE,
                'mysql_primary'     => FALSE,
                'mysql_estrangeira' => FALSE, // chave estrangeira
                'mysql_autoadd'     => FALSE,
                'mysql_comment'     => 'SERVIDOR ou class dao que esta recebendo',
                'mysql_inside'      => FALSE, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => FALSE, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => FALSE, //permissao funcional necessaria para campo 2 todos 
                'linkextra'         => '', // //0 ninguem, 1 admin, 2 todos 
                'edicao'            => Array(
                    'Nome'              => __('Motivo'),
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
                'mysql_titulo'      => 'saida_motivoid',
                'mysql_tipovar'     => 'varchar', //varchar, int, 
                'mysql_tamanho'     => 30,
                'mysql_null'        => TRUE,
                'mysql_default'     => FALSE,
                'mysql_primary'     => FALSE,
                'mysql_estrangeira' => FALSE, // chave estrangeira
                'mysql_autoadd'     => FALSE,
                'mysql_comment'     => 'Identificador ou Chave que esta recebendo',
                'mysql_inside'      => FALSE, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => FALSE, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => FALSE, //permissao funcional necessaria para campo 2 todos 
                'linkextra'         => '', // //0 ninguem, 1 admin, 2 todos 
                'edicao'            => Array(
                    'Nome'              => __('Id da Saida'),
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
                'mysql_titulo'      => 'num_parcela',
                'mysql_tipovar'     => 'int', //varchar, int, 
                'mysql_tamanho'     => 11,
                'mysql_null'        => FALSE,
                'mysql_default'     => '0', // valor padrao
                'mysql_primary'     => FALSE,
                'mysql_estrangeira' => FALSE, // chave estrangeira
                'mysql_autoadd'     => FALSE,
                'mysql_comment'     => FALSE,
                'mysql_inside'      => FALSE, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => FALSE, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => FALSE, //permissao funcional necessaria para campo 2 todos 
                'linkextra'         => '', // //0 ninguem, 1 admin, 2 todos 
                'edicao'            => Array(
                    'Nome'              => __('Número da Parcela'),
                    'Mascara'           => 'Numero',
                    'valor_padrao'      => FALSE,
                    'readonly'          => FALSE,
                    'aviso'             => '0 = Parcela Unica',
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
                'linkextra'         => '', // //0 ninguem, 1 admin, 2 todos 
                'edicao'            => Array(
                    'Nome'              => __('Valor'),
                    'Mascara'           => 'Real',
                    'valor_padrao'      => FALSE,
                    'readonly'          => FALSE,
                    'aviso'             => __('Somente Números'),
                    'formtipo'          => 'input',
                    'input'             => array(
                        'tipo'              => 'text',
                        'class'             => ''
                    )
                )
            ),Array(
                'mysql_titulo'      => 'dt_vencimento',
                'mysql_tipovar'     => 'date', //varchar, int, 
                'mysql_tamanho'     => 10,
                'mysql_null'        => FALSE,
                'mysql_default'     => '0000-00-00', // valor padrao
                'mysql_primary'     => FALSE,
                'mysql_estrangeira' => FALSE, // chave estrangeira
                'mysql_autoadd'     => FALSE,
                'mysql_comment'     => FALSE,
                'mysql_inside'      => 'data_brasil_eua({valor})', // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => 'data_eua_brasil({valor})', // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => FALSE, //permissao funcional necessaria para campo 2 todos 
                'linkextra'         => '', // //0 ninguem, 1 admin, 2 todos 
                'edicao'            => Array(
                    'Nome'              => __('Data do Vencimento'),
                    'Mascara'           => 'Data',
                    'valor_padrao'      => FALSE,
                    'readonly'          => FALSE,
                    'aviso'             => '',
                    'formtipo'          => 'input',
                    'validar'           => 'Control_Layoult_Valida_Data',
                    'input'             => array(
                        'tipo'              => 'text',
                        'class'             => 'obrigatorio'
                    )
                )
            ),Array(
                'mysql_titulo'      => 'valor_juros',
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
                'linkextra'         => '', // //0 ninguem, 1 admin, 2 todos 
                'edicao'            => Array(
                    'Nome'              => __('Valor Pago'),
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
            ),Array(
                'mysql_titulo'      => 'dt_pago',
                'mysql_tipovar'     => 'date', //varchar, int, 
                'mysql_tamanho'     => 10,
                'mysql_null'        => FALSE,
                'mysql_default'     => '0000-00-00', // valor padrao
                'mysql_primary'     => FALSE,
                'mysql_estrangeira' => FALSE, // chave estrangeira
                'mysql_autoadd'     => FALSE,
                'mysql_comment'     => FALSE,
                'mysql_inside'      => 'data_brasil_eua({valor})', // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => 'data_eua_brasil({valor})', // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => FALSE, //permissao funcional necessaria para campo 2 todos 
                'linkextra'         => '', // //0 ninguem, 1 admin, 2 todos 
                'edicao'            => Array(
                    'Nome'              => __('Data do Pagamento'),
                    'Mascara'           => 'Data',
                    'valor_padrao'      => APP_DATA_BR,
                    'readonly'          => FALSE,
                    'aviso'             => '',
                    'formtipo'          => 'input',
                    'validar'           => 'Control_Layoult_Valida_Data',
                    'input'             => array(
                        'tipo'              => 'text',
                        'class'             => 'obrigatorio'
                    )
                )
            ),
            Array(
                'mysql_titulo'      => 'pago',
                'mysql_tipovar'     => 'int', //varchar, int, 
                'mysql_tamanho'     => 11,
                'mysql_null'        => FALSE, // true NULL, false, NOT NULL
                'mysql_default'     => '0',//false -> NONE, outro -> default
                'mysql_primary'     => FALSE, // chave primaria
                'mysql_estrangeira' => FALSE, // chave estrangeira
                'mysql_autoadd'     => FALSE,
                'mysql_comment'     => FALSE,
                'mysql_inside'      => FALSE, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => FALSE, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => FALSE, //permissao funcional necessaria para campo 2 todos 
                'linkextra'         => '', //0 ninguem, 1 admin, 2 todos 
                'edicao'            => Array(
                    'Nome'              => __('Pago'),
                    'valor_padrao'      => 1,
                    'readonly'          => FALSE,
                    'aviso'             => '',
                    'formtipo'          => 'select',
                    'select'            => array(
                        'opcoes'            => array(
                            array(
                                'value'         =>  '0',
                                'nome'          => 'Não'
                            ),
                            array(
                                'value'         =>  '1',
                                'nome'          => 'Sim'
                            )
                        )
                    )
                )
            ),
            Array(
                'mysql_titulo'      => 'forma_pagar',
                'mysql_tipovar'     => 'int', //varchar, int, 
                'mysql_tamanho'     => 11,
                'mysql_null'        => TRUE,  // nulo ?
                'mysql_default'     => 0, // valor padrao
                'mysql_primary'     => FALSE,  // chave primaria
                'mysql_estrangeira' => 'FPF.id|FPF.nome', // chave estrangeira     ligacao|apresentacao|condicao
                'form_change'       => 'CPRO', // CHANGE PARA EXTRANGEIRAS -> Sigla Tabela Pai / Sigla Tabela Atual ou false
                'mysql_autoadd'     => FALSE,
                'mysql_comment'     => FALSE,
                'mysql_inside'      => FALSE, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => FALSE, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => FALSE, //permissao funcional necessaria para campo 2 todos 
                'linkextra'         => 'Financeiro/Pagamento/Formas_Add/', //0 ninguem, 1 admin, 2 todos 
                'edicao'            => Array(
                    'Nome'              => __('Forma de Pagamento'),
                    'valor_padrao'      => FALSE,
                    'readonly'          => FALSE,
                    'aviso'             => '',
                    'formtipo'          => 'select',
                    'select'             => array(
                        'class'             => 'obrigatorio',
                        'infonulo'          => 'Escolha uma Forma de Pagamento',
                    )
                )
            ),
            Array(
                'mysql_titulo'      => 'forma_condicao',
                'mysql_tipovar'     => 'int', //varchar, int, 
                'mysql_tamanho'     => 11,
                'mysql_null'        => TRUE,  // nulo ?
                'mysql_default'     => 0, // valor padrao
                'mysql_primary'     => FALSE,  // chave primaria
                'mysql_estrangeira' => 'FPFC.id|FPFC.nome|FPFC.forma_pagar={forma_pagar}', // chave estrangeira     ligacao|apresentacao|condicao
                'mysql_autoadd'     => FALSE,
                'mysql_comment'     => FALSE,
                'mysql_inside'      => FALSE, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => FALSE, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => FALSE, //permissao funcional necessaria para campo 2 todos 
                'linkextra'         => 'Financeiro/Pagamento/Condicoes_Add/', //0 ninguem, 1 admin, 2 todos 
                'edicao'            => Array(
                    'Nome'              => __('Condição de Pagamento'),
                    'valor_padrao'      => FALSE,
                    'readonly'          => FALSE,
                    'aviso'             => '',
                    'formtipo'          => 'select',
                    'select'             => array(
                        'class'             => 'obrigatorio',
                        'infonulo'          => 'Escolha uma Condição de Pagamento',
                    )
                )
            ),
            Array(
                'mysql_titulo'      => 'obs',
                'mysql_tipovar'     => 'longtext', //varchar, int, 
                'mysql_tamanho'     => 10000,
                'mysql_null'        => FALSE,  // nulo ?
                'mysql_default'     => FALSE, // valor padrao
                'mysql_primary'     => FALSE,  // chave primaria
                'mysql_estrangeira' => FALSE, // chave estrangeira     ligacao|apresentacao|condicao
                'mysql_autoadd'     => FALSE,
                'mysql_comment'     => FALSE,
                'mysql_inside'      => FALSE, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => FALSE, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => FALSE, //permissao funcional necessaria para campo 2 todos 
                'linkextra'         => '', //0 ninguem, 1 admin, 2 todos 
                'edicao'            => Array(
                    'Nome'              => __('Observação'),
                    'valor_padrao'      => FALSE,
                    'readonly'          => FALSE,
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
