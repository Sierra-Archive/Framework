<?php
final Class Comercio_Certificado_Proposta_DAO extends Framework\App\Dao 
{
    protected $id;
    protected $idcliente;
    protected $idproduto;
    protected $num_proposta;
    protected $num_contrato;
    protected $num_certificado;
    protected $validade;
    protected $data_aceita_proposta;
    protected $data_certificado;
    protected $data_envio_contrato;
    protected $data_dev_contrato;
    protected $data_envio_cert;
    protected $data_imetro;
    protected $data_comissao;
    protected $produto_valor_contrato;
    protected $produto_valor_entrada;
    protected $produto_num_parcelas;
    protected $produto_dia_faturamento;
    protected $valor_mensal;
    protected $status;
    protected static $objetocarregado     = false;     protected static $mysql_colunas       = false;     protected static $mysql_outside       = Array();     protected static $mysql_inside        = Array(); public function __construct() {  parent::__construct(); } public static function Get_Nome(){
        return MYSQL_COMERCIO_CERTIFICADO_PROPOSTA;
    }
    /**
     * Fornece Permissão de Copia da tabela
     * @return string
     */
    public static function Permissao_Copia(){
        return false;
    }
    public static function Get_Sigla(){
        return 'CCP';
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
        return str_replace(Array('_DAO'), Array(''), get_class());
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
                'linkextra'          => '' ,//0 ninguem, 1 admin, 2 todos 
            ),Array(
                'mysql_titulo'      => 'idcliente',
                'mysql_tipovar'     => 'int', //varchar, int, 
                'mysql_tamanho'     => 11,
                'mysql_null'        => false,
                'mysql_default'     => false,
                'mysql_primary'     => false,
                'mysql_estrangeira' => 'U.id|U.nome-U.razao_social|EXTB.categoria='.CFG_TEC_CAT_ID_CLIENTES, // chave estrangeira
                'mysql_autoadd'     => false,
                'mysql_comment'     => false,
                'mysql_inside'      => false, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => false, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false, //permissao funcional necessaria para campo 2 todos 
                'linkextra'          => '',
                'edicao'            => Array(
                    'Nome'              => 'Cliente',
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => '',
                    'formtipo'          => 'select',
                    'select'             => array(
                        'class'             => 'obrigatorio',
                        'infonulo'          => 'Escolha um Cliente',
                    )
                )
            ),Array(
                'mysql_titulo'      => 'idproduto',
                'mysql_tipovar'     => 'int', //varchar, int, 
                'mysql_tamanho'     => 11,
                'mysql_null'        => false,
                'mysql_default'     => false,
                'mysql_primary'     => false,
                'mysql_estrangeira' => 'CP.id|CP.sigla', // chave estrangeira
                'mysql_autoadd'     => false,
                'mysql_comment'     => false,
                'mysql_inside'      => false, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => false, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false, //permissao funcional necessaria para campo 2 todos 
                'linkextra'          => 'comercio_certificado/Produto/Produtos',
                'edicao'            => Array(
                    'Nome'              => 'Produto',
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => '',
                    'formtipo'          => 'select',
                    'select'             => array(
                        'class'             => 'obrigatorio',
                        'infonulo'          => 'Escolha um Produto',
                    )
                )
            ),Array(
                'mysql_titulo'      => 'num_proposta',
                'mysql_tipovar'     => 'varchar', //varchar, int, 
                'mysql_tamanho'     => 11,
                'mysql_null'        => true,
                'mysql_default'     => 0,
                'mysql_primary'     => false,
                'mysql_estrangeira' => false, // chave estrangeira
                'mysql_autoadd'     => false,
                'mysql_comment'     => false,
                'mysql_inside'      => false, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => false, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false, //permissao funcional necessaria para campo 2 todos 
                'linkextra'          => '', // //0 ninguem, 1 admin, 2 todos 
                'edicao'            => Array(
                    'Nome'              => 'Número da Proposta',
                    'valor_padrao'      => false,
                    'readonly'          => true,
                    'aviso'             => 'Somente Números',
                    'formtipo'          => 'input',
                    'input'             => array(
                        'tipo'              => 'text',
                        'class'             => ''
                    )
                )
            ),Array(
                'mysql_titulo'      => 'num_contrato',
                'mysql_tipovar'     => 'int', //varchar, int, 
                'mysql_tamanho'     => 11,
                'mysql_null'        => true,
                'mysql_default'     => 0,
                'mysql_primary'     => false,
                'mysql_estrangeira' => false, // chave estrangeira
                'mysql_autoadd'     => false,
                'mysql_comment'     => false,
                'mysql_inside'      => false, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => false, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false, //permissao funcional necessaria para campo 2 todos 
                'linkextra'          => '', // //0 ninguem, 1 admin, 2 todos 
                'edicao'            => Array(
                    'Nome'              => 'Número do Contrato',
                    'Mascara'           => 'Numero',
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => 'Somente Números',
                    'formtipo'          => 'input',
                    'input'             => array(
                        'tipo'              => 'text',
                        'class'             => ''
                    )
                )
            ),Array(
                'mysql_titulo'      => 'num_certificado',
                'mysql_tipovar'     => 'int', //varchar, int, 
                'mysql_tamanho'     => 11,
                'mysql_null'        => true,
                'mysql_default'     => 0,
                'mysql_primary'     => false,
                'mysql_estrangeira' => false, // chave estrangeira
                'mysql_autoadd'     => false,
                'mysql_comment'     => false,
                'mysql_inside'      => false, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => false, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false, //permissao funcional necessaria para campo 2 todos 
                'linkextra'          => '', // //0 ninguem, 1 admin, 2 todos 
                'edicao'            => Array(
                    'Nome'              => 'Número do Certificado',
                    'Mascara'           => 'Numero',
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => 'Somente Números',
                    'formtipo'          => 'input',
                    'input'             => array(
                        'tipo'              => 'text',
                        'class'             => ''
                    )
                )
            ),Array(
                'mysql_titulo'      => 'validade',
                'mysql_tipovar'     => 'date', //varchar, int, 
                'mysql_tamanho'     => 10,
                'mysql_null'        => false,
                'mysql_default'     => '0000-00-00',
                'mysql_primary'     => false,
                'mysql_estrangeira' => false, // chave estrangeira
                'mysql_autoadd'     => false,
                'mysql_comment'     => false,
                'mysql_inside'      => 'data_brasil_eua({valor})', // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => 'data_eua_brasil({valor})', // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false, //permissao funcional necessaria para campo 2 todos 
                'linkextra'          => '', // //0 ninguem, 1 admin, 2 todos 
                'edicao'            => Array(
                    'Nome'              => 'Data de Validade',
                    'Mascara'           => 'Data',
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => '',
                    'formtipo'          => 'input',
                    'validar'           => 'Control_Layoult_Valida_Data',
                    'input'             => array(
                        'tipo'              => 'text',
                        'class'             => ''
                    )
                )
            ),Array(
                'mysql_titulo'      => 'data_aceita_proposta',
                'mysql_tipovar'     => 'date', //varchar, int, 
                'mysql_tamanho'     => 10,
                'mysql_null'        => false,
                'mysql_default'     => '0000-00-00',
                'mysql_primary'     => false,
                'mysql_estrangeira' => false, // chave estrangeira
                'mysql_autoadd'     => false,
                'mysql_comment'     => false,
                'mysql_inside'      => 'data_brasil_eua({valor})', // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => 'data_eua_brasil({valor})', // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false, //permissao funcional necessaria para campo 2 todos 
                'linkextra'          => '', // //0 ninguem, 1 admin, 2 todos 
                'edicao'            => Array(
                    'Nome'              => 'Data de Aceitação da Proposta',
                    'Mascara'           => 'Data',
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => '',
                    'formtipo'          => 'input',
                    'validar'           => 'Control_Layoult_Valida_Data',
                    'input'             => array(
                        'tipo'              => 'text',
                        'class'             => ''
                    )
                )
            ),Array(
                'mysql_titulo'      => 'data_certificado',
                'mysql_tipovar'     => 'date', //varchar, int, 
                'mysql_tamanho'     => 10,
                'mysql_null'        => false,
                'mysql_default'     => '0000-00-00',
                'mysql_primary'     => false,
                'mysql_estrangeira' => false, // chave estrangeira
                'mysql_autoadd'     => false,
                'mysql_comment'     => false,
                'mysql_inside'      => 'data_brasil_eua({valor})', // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => 'data_eua_brasil({valor})', // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false, //permissao funcional necessaria para campo 2 todos 
                'linkextra'          => '', // //0 ninguem, 1 admin, 2 todos 
                'edicao'            => Array(
                    'Nome'              => 'Data de Certificação',
                    'Mascara'           => 'Data',
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => '',
                    'formtipo'          => 'input',
                    'validar'           => 'Control_Layoult_Valida_Data',
                    'input'             => array(
                        'tipo'              => 'text',
                        'class'             => ''
                    )
                )
            ),Array(
                'mysql_titulo'      => 'data_envio_contrato',
                'mysql_tipovar'     => 'date', //varchar, int, 
                'mysql_tamanho'     => 10,
                'mysql_null'        => false,
                'mysql_default'     => '0000-00-00',
                'mysql_primary'     => false,
                'mysql_estrangeira' => false, // chave estrangeira
                'mysql_autoadd'     => false,
                'mysql_comment'     => false,
                'mysql_inside'      => 'data_brasil_eua({valor})', // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => 'data_eua_brasil({valor})', // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false, //permissao funcional necessaria para campo 2 todos 
                'linkextra'          => '', // //0 ninguem, 1 admin, 2 todos 
                'edicao'            => Array(
                    'Nome'              => 'Data da Assinatura do Contrato',
                    'Mascara'           => 'Data',
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => '',
                    'formtipo'          => 'input',
                    'validar'           => 'Control_Layoult_Valida_Data',
                    'input'             => array(
                        'tipo'              => 'text',
                        'class'             => ''
                    )
                )
            ),Array(
                'mysql_titulo'      => 'data_dev_contrato',
                'mysql_tipovar'     => 'date', //varchar, int, 
                'mysql_tamanho'     => 10,
                'mysql_null'        => false,
                'mysql_default'     => '0000-00-00',
                'mysql_primary'     => false,
                'mysql_estrangeira' => false, // chave estrangeira
                'mysql_autoadd'     => false,
                'mysql_comment'     => false,
                'mysql_inside'      => 'data_brasil_eua({valor})', // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => 'data_eua_brasil({valor})', // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false, //permissao funcional necessaria para campo 2 todos 
                'linkextra'          => '', // //0 ninguem, 1 admin, 2 todos 
                'edicao'            => Array(
                    'Nome'              => 'Envio ao Cliente',
                    'Mascara'           => 'Data',
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => '',
                    'formtipo'          => 'input',
                    'validar'           => 'Control_Layoult_Valida_Data',
                    'input'             => array(
                        'tipo'              => 'text',
                        'class'             => ''
                    )
                )
            ),Array(
                'mysql_titulo'      => 'data_envio_cert',
                'mysql_tipovar'     => 'date', //varchar, int, 
                'mysql_tamanho'     => 10,
                'mysql_null'        => false,
                'mysql_default'     => '0000-00-00',
                'mysql_primary'     => false,
                'mysql_estrangeira' => false, // chave estrangeira
                'mysql_autoadd'     => false,
                'mysql_comment'     => false,
                'mysql_inside'      => 'data_brasil_eua({valor})', // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => 'data_eua_brasil({valor})', // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false, //permissao funcional necessaria para campo 2 todos 
                'linkextra'          => '', // //0 ninguem, 1 admin, 2 todos 
                'edicao'            => Array(
                    'Nome'              => 'Data de Envio do Certificado',
                    'Mascara'           => 'Data',
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => '',
                    'formtipo'          => 'input',
                    'validar'           => 'Control_Layoult_Valida_Data',
                    'input'             => array(
                        'tipo'              => 'text',
                        'class'             => ''
                    )
                )
            ),Array(
                'mysql_titulo'      => 'data_imetro',
                'mysql_tipovar'     => 'date', //varchar, int, 
                'mysql_tamanho'     => 10,
                'mysql_null'        => false,
                'mysql_default'     => '0000-00-00',
                'mysql_primary'     => false,
                'mysql_estrangeira' => false, // chave estrangeira
                'mysql_autoadd'     => false,
                'mysql_comment'     => false,
                'mysql_inside'      => 'data_brasil_eua({valor})', // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => 'data_eua_brasil({valor})', // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false, //permissao funcional necessaria para campo 2 todos 
                'linkextra'          => '', // //0 ninguem, 1 admin, 2 todos 
                'edicao'            => Array(
                    'Nome'              => 'Data Imetro',
                    'Mascara'           => 'Data',
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => '',
                    'formtipo'          => 'input',
                    'validar'           => 'Control_Layoult_Valida_Data',
                    'input'             => array(
                        'tipo'              => 'text',
                        'class'             => ''
                    )
                )
            ),Array(
                'mysql_titulo'      => 'data_comissao',
                'mysql_tipovar'     => 'date', //varchar, int, 
                'mysql_tamanho'     => 10,
                'mysql_null'        => false,
                'mysql_default'     => '0000-00-00',
                'mysql_primary'     => false,
                'mysql_estrangeira' => false, // chave estrangeira
                'mysql_autoadd'     => false,
                'mysql_comment'     => false,
                'mysql_inside'      => 'data_brasil_eua({valor})', // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => 'data_eua_brasil({valor})', // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false, //permissao funcional necessaria para campo 2 todos 
                'linkextra'          => '', // //0 ninguem, 1 admin, 2 todos 
                'edicao'            => Array(
                    'Nome'              => 'Data da Comissão',
                    'Mascara'           => 'Data',
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => '',
                    'formtipo'          => 'input',
                    'validar'           => 'Control_Layoult_Valida_Data',
                    'input'             => array(
                        'tipo'              => 'text',
                        'class'             => ''
                    )
                )
            ),Array(
                'mysql_titulo'      => 'produto_valor_contrato',
                'mysql_tipovar'     => 'float', //varchar, int, 
                'mysql_tamanho'     => 30,
                'mysql_null'        => true,
                'mysql_default'     => false,
                'mysql_primary'     => false,
                'mysql_estrangeira' => false, // chave estrangeira
                'mysql_autoadd'     => false,
                'mysql_comment'     => false,
                'mysql_inside'      => '\Framework\App\Sistema_Funcoes::Tranf_Real_Float({valor})', // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => '\Framework\App\Sistema_Funcoes::Tranf_Float_Real({valor})', // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false, //permissao funcional necessaria para campo 2 todos 
                'linkextra'          => '', // //0 ninguem, 1 admin, 2 todos 
                'edicao'            => Array(
                    'Nome'              => 'Valor do Contrato do Produto',
                    'Mascara'           => 'Real',
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => 'Minimo 3 caracteres',
                    'formtipo'          => 'input',
                    'input'             => array(
                        'tipo'              => 'text',
                        'class'             => ''
                    )
                )
            ),Array(
                'mysql_titulo'      => 'produto_valor_entrada',
                'mysql_tipovar'     => 'float', //varchar, int, 
                'mysql_tamanho'     => 30,
                'mysql_null'        => true,
                'mysql_default'     => false,
                'mysql_primary'     => false,
                'mysql_estrangeira' => false, // chave estrangeira
                'mysql_autoadd'     => false,
                'mysql_comment'     => false,
                'mysql_inside'      => '\Framework\App\Sistema_Funcoes::Tranf_Real_Float({valor})', // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => '\Framework\App\Sistema_Funcoes::Tranf_Float_Real({valor})', // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false, //permissao funcional necessaria para campo 2 todos 
                'linkextra'          => '', // //0 ninguem, 1 admin, 2 todos 
                'edicao'            => Array(
                    'Nome'              => 'Valor de Entrada do Produto',
                    'Mascara'           => 'Real',
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => '',
                    'formtipo'          => 'input',
                    'input'             => array(
                        'tipo'              => 'text',
                        'class'             => ''
                    )
                )
            ),Array(
                'mysql_titulo'      => 'produto_num_parcelas',
                'mysql_tipovar'     => 'int', //varchar, int, 
                'mysql_tamanho'     => 11,
                'mysql_null'        => true,
                'mysql_default'     => false,
                'mysql_primary'     => false,
                'mysql_estrangeira' => false, // chave estrangeira
                'mysql_autoadd'     => false,
                'mysql_comment'     => false,
                'mysql_inside'      => false, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => false, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false, //permissao funcional necessaria para campo 2 todos 
                'linkextra'          => '', // //0 ninguem, 1 admin, 2 todos 
                'edicao'            => Array(
                    'Nome'              => 'Números de Parcelas do Produto',
                    'Mascara'           => 'Numero',
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => '',
                    'formtipo'          => 'input',
                    'input'             => array(
                        'tipo'              => 'text',
                        'class'             => ''
                    )
                )
            ),Array(
                'mysql_titulo'      => 'produto_dia_faturamento',
                'mysql_tipovar'     => 'text', //varchar, int, 
                'mysql_tamanho'     => 1000,
                'mysql_null'        => true,
                'mysql_default'     => false,
                'mysql_primary'     => false,
                'mysql_estrangeira' => false, // chave estrangeira
                'mysql_autoadd'     => false,
                'mysql_comment'     => false,
                'mysql_inside'      => 'data_brasil_eua({valor})', // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => 'data_eua_brasil({valor})', // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false, //permissao funcional necessaria para campo 2 todos 
                'linkextra'          => '', // //0 ninguem, 1 admin, 2 todos 
                'edicao'            => Array(
                    'Nome'              => 'Dia do Faturamento',
                    'Mascara'           => 'Data',
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => '',
                    'formtipo'          => 'input',
                    'input'          => array(
                        'tipo'              => 'text',
                        'class'             => ''
                    )
                )
            ),Array(
                'mysql_titulo'      => 'valor_mensal',
                'mysql_tipovar'     => 'float', //varchar, int, 
                'mysql_tamanho'     => 30,
                'mysql_null'        => true,
                'mysql_default'     => false,
                'mysql_primary'     => false,
                'mysql_estrangeira' => false, // chave estrangeira
                'mysql_autoadd'     => false,
                'mysql_comment'     => false,
                'mysql_inside'      => '\Framework\App\Sistema_Funcoes::Tranf_Real_Float({valor})', // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => '\Framework\App\Sistema_Funcoes::Tranf_Float_Real({valor})', // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false, //permissao funcional necessaria para campo 2 todos 
                'linkextra'          => '', // //0 ninguem, 1 admin, 2 todos 
                'edicao'            => Array(
                    'Nome'              => 'Valor Mensal',
                    'Mascara'           => 'Real',
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => '',
                    'formtipo'          => 'input',
                    'input'             => array(
                        'tipo'              => 'text',
                        'class'             => ''
                    )
                )
            ),
            // Status
            Array(
                'mysql_titulo'      => 'status',
                'mysql_tipovar'     => 'int', //varchar, int, 
                'mysql_tamanho'     => 3,
                'mysql_null'        => false,  // nulo ?
                'mysql_default'     => 1, // valor padrao
                'mysql_primary'     => false,  // chave primaria
                'mysql_estrangeira' => false, // chave estrangeira     ligacao|apresentacao|condicao
                'mysql_autoadd'     => false,
                'mysql_comment'     => false,
                'mysql_inside'      => false, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => false, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false, //permissao funcional necessaria para campo 2 todos 
                'linkextra'          => '', //0 ninguem, 1 admin, 2 todos 
                'edicao'            => Array(
                    'Nome'              => 'Status',
                    'valor_padrao'      => 0,
                    'readonly'          => false,
                    'aviso'             => '',
                    'formtipo'          => 'select',
                    'select'            => array(
                        'opcoes'            => array(
                            array(
                                'value'         =>  '2',
                                'nome'          => 'Reprovada'
                            ),
                            array(
                                'value'         =>  '1',
                                'nome'          => 'Aprovada'
                            ),
                            array(
                                'value'         =>  '0',
                                'nome'          => 'Pendente'
                            ),
                        )
                    )
                )
            ),
        );
    }
}
?>
