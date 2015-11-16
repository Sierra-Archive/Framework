<?php
final Class  Engenharia_Empreendimento_Custo_DAO extends Framework\App\Dao 
{
    protected $id;
    protected $empreendimento;
    protected $unidade;
    protected $cliente;
    protected $valor;
    protected $data_pag_prevista;
    protected $banco; // banco financiador
    protected static $objetocarregado     = false;     protected static $mysql_colunas       = false;     protected static $mysql_outside       = Array();     protected static $mysql_inside        = Array(); public function __construct() {  parent::__construct(); } public static function Get_Nome() {
        return MYSQL_ENGENHARIA_EMPREENDIMENTO_CUSTO;
    }
    /**
     * Fornece Permissão de Copia da tabela
     * @return string
     */
    public static function Permissao_Copia() {
        return false;
    }
    public static function Get_Sigla() {
        return 'EEC';
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
                'linkextra'         => '' ,//0 ninguem, 1 admin, 2 todos 
            ),Array(
                'mysql_titulo'      => 'empreendimento',
                'mysql_tipovar'     => 'int', //varchar, int, 
                'mysql_tamanho'     => 11,
                'mysql_null'        => FALSE,
                'mysql_default'     => FALSE,
                'mysql_primary'     => FALSE,
                'mysql_estrangeira' => 'EE.id|EE.nome', // chave estrangeira
                'form_change'       => 'EEC', // CHANGE PARA EXTRANGEIRAS -> Sigla Tabela Pai / Sigla Tabela Atual ou false
                'mysql_autoadd'     => FALSE,
                'mysql_comment'     => FALSE,
                'mysql_inside'      => FALSE, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => FALSE, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => FALSE, //permissao funcional necessaria para campo 2 todos 
                'linkextra'         => 'Engenharia/Empreendimento/Empreendimentos_Add',
                'edicao'            => Array(
                    'Nome'              => __('Empreendimento'),
                    'valor_padrao'      => FALSE,
                    'readonly'          => FALSE,
                    'aviso'             => '',
                    'select'             => array(
                        'class'             => 'obrigatorio',
                        'infonulo'          => 'Escolha um Empreendimento',
                    )
                )
            ),Array(
                'mysql_titulo'      => 'unidade',
                'mysql_tipovar'     => 'int', //varchar, int, 
                'mysql_tamanho'     => 11,
                'mysql_null'        => FALSE,
                'mysql_default'     => FALSE,
                'mysql_primary'     => FALSE,
                'mysql_estrangeira' => 'EEU.id|EEU.unidade|EEU.empreendimento={empreendimento}', // chave estrangeira
                'mysql_autoadd'     => FALSE,
                'mysql_comment'     => FALSE,
                'mysql_inside'      => FALSE, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => FALSE, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => FALSE, //permissao funcional necessaria para campo 2 todos 
                'linkextra'         => 'Engenharia/Unidade/Unidades_Add',
                'edicao'            => Array(
                    'Nome'              => __('Unidade do Empreendimento'),
                    'valor_padrao'      => FALSE,
                    'readonly'          => FALSE,
                    'aviso'             => '',
                    'select'             => array(
                        'class'             => 'obrigatorio',
                        'infonulo'          => 'Escolha primeiro um Empreendimento',
                    )
                )
            ),
            Array(
                'mysql_titulo'      => 'cliente',
                'mysql_tipovar'     => 'int', //varchar, int, 
                'mysql_tamanho'     => 11,
                'mysql_null'        => TRUE,  // nulo ?
                'mysql_default'     => 0, // valor padrao
                'mysql_primary'     => FALSE,  // chave primaria
                'mysql_estrangeira' => 'U.id|U.nome-U.razao_social|EXTB.categoria='.CFG_TEC_CAT_ID_CLIENTES, // chave estrangeira     ligacao|apresentacao|condicao
                'mysql_autoadd'     => FALSE,
                'mysql_comment'     => FALSE,
                'mysql_inside'      => FALSE, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => FALSE, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => FALSE, //permissao funcional necessaria para campo 2 todos 
                'linkextra'          => FALSE, //'usuario/Admin/Usuarios_Add/cliente',
                'edicao'            => Array(
                    'Nome'              => __('Cliente / Investidor'),
                    'valor_padrao'      => FALSE,
                    'readonly'          => FALSE,
                    'aviso'             => __('obrigatorio'),
                    'select'             => array(
                        'class'             => 'obrigatorio',
                        'infonulo'          => 'Escolha um Cliente/Investidor',
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
                    'aviso'             => '',
                    'formtipo'          => 'input',
                    'input'             => array(
                        'tipo'              => 'text',
                        'class'             => 'obrigatorio'
                    )
                )
            ),
            Array(
                'mysql_titulo'      => 'data_pag_prevista',
                'mysql_tipovar'     => 'date', //varchar, int, 
                'mysql_tamanho'     => 10,
                'mysql_null'        => FALSE,  // nulo ?
                'mysql_default'     => '0000-00-00', // valor padrao
                'mysql_primary'     => FALSE,  // chave primaria
                'mysql_estrangeira' => FALSE, // chave estrangeira     ligacao|apresentacao|condicao
                'mysql_autoadd'     => FALSE,
                'mysql_comment'     => FALSE,
                'mysql_inside'      => 'data_brasil_eua({valor})', // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => 'data_eua_brasil({valor})', // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => FALSE, //permissao funcional necessaria para campo 2 todos 
                'linkextra'         => '', //0 ninguem, 1 admin, 2 todos 
                'edicao'            => Array(
                    'Nome'              => __('Data Prevista do Pagamento'),
                    'Mascara'           => 'Data',
                    'valor_padrao'      => FALSE,
                    'readonly'          => FALSE,
                    'aviso'             => '',
                    'formtipo'          => 'input',
                    'validar'           => 'Control_Layoult_Valida_Data',
                    'input'             => array(
                        'tipo'              => 'text',
                        'class'             => ''
                    )
                )
            ),
            Array(
                'mysql_titulo'      => 'banco',
                'mysql_tipovar'     => 'int', //varchar, int, 
                'mysql_tamanho'     => 11,
                'mysql_null'        => TRUE, // true NULL, false, NOT NULL
                'mysql_default'     => FALSE,//false -> NONE, outro -> default
                'mysql_primary'     => FALSE, // chave primaria
                'mysql_estrangeira' => 'FB.id|FB.nome', // chave estrangeira     ligacao|apresentacao|condicao
                'mysql_autoadd'     => FALSE,
                'mysql_comment'     => FALSE,
                'mysql_inside'      => FALSE, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => FALSE, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => FALSE, //permissao funcional necessaria para campo 2 todos 
                'linkextra'         => 'Financeiro/Banco/Bancos_Add', //0 ninguem, 1 admin, 2 todos 
                'edicao'            => Array(
                    'Nome'              => __('Banco Financiador'),
                    'valor_padrao'      => FALSE,
                    'readonly'          => FALSE,
                    'aviso'             => '',
                    'formtipo'          => 'select',
                    'select'            => array(
                        'class'             => 'obrigatorio',
                        'infonulo'          => 'Escolha um Veiculo'
                    )
                )
            )
        );
    }
}
?>
