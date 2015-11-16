<?php
final Class Transporte_Caminhoneiro_Pedido_DAO extends Framework\App\Dao 
{
    protected $id;
    protected $categoria;
    protected $descricao_carga;
    protected $comprimento;
    protected $altura;
    protected $largura;
    protected $capacidade;
    protected $qnt_volumes;
    protected $peso_bruto;
    protected $descricao_embalagem;
    protected $inicio_data;
    
    
    protected $fim_data;
    protected $inicio_pais;
    protected $inicio_estado;
    protected $inicio_cidade;
    protected $inicio_bairro;
    protected $fim_pais;
    protected $fim_estado;
    protected $fim_cidade;
    protected $fim_bairro;
    
    
    
    protected $status;
    protected $obs;
    protected static $objetocarregado     = false;     protected static $mysql_colunas       = false;     protected static $mysql_outside       = Array();     protected static $mysql_inside        = Array(); public function __construct() {  parent::__construct(); } public static function Get_Nome() {
        return MYSQL_TRANSPORTE_CAMINHONEIRO_PEDIDO;
    }
    /**
     * Fornece Permissão de Copia da tabela
     * @return string
     */
    public static function Permissao_Copia() {
        return false;
    }
    public static function Get_Sigla() {
        return 'TCP';
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
            ),
            Array(
                'mysql_titulo'      => 'categoria',
                'mysql_tipovar'     => 'int', //varchar, int, 
                'mysql_tamanho'     => 11,
                'mysql_null'        => TRUE, // true NULL, false, NOT NULL
                'mysql_default'     => FALSE,//false -> NONE, outro -> default
                'mysql_primary'     => FALSE, // chave primaria
                'mysql_estrangeira' => 'C.id|C.nome|CA.mod_acc=Transporte_Caminhao', // chave estrangeira     ligacao|apresentacao|condicao
                'mysql_autoadd'     => FALSE,
                'mysql_comment'     => FALSE,
                'mysql_inside'      => FALSE, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => FALSE, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => FALSE, //permissao funcional necessaria para campo 2 todos 
                'linkextra'         => 'categoria/Admin/Categorias_Add/Transporte_Caminhao', //0 ninguem, 1 admin, 2 todos 
                'edicao'            => Array(
                    'Nome'              => __('Tipo de Caminhao Necessario'),
                    'valor_padrao'      => FALSE,
                    'readonly'          => FALSE,
                    'aviso'             => '',
                    'formtipo'          => 'select',
                    'select'             => array(
                        'class'             => 'obrigatorio',
                        'infonulo'          => 'Escolha um Tipo de Caminhao',
                    )
                )
            ),Array(
                'mysql_titulo'      => 'descricao_carga',
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
                    'Nome'              => __('Descriçao da Carga'),
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
                'mysql_titulo'      => 'descricao_embalagem',
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
                    'Nome'              => __('Descrição da Embalagem'),
                    'valor_padrao'      => FALSE,
                    'readonly'          => FALSE,
                    'aviso'             => __('Minimo 3 caracteres'),
                    'formtipo'          => 'input',
                    'input'             => array(
                        'tipo'              => 'text',
                        'class'             => 'obrigatorio'
                    )
                )
            ),
            Array(
                'mysql_titulo'      => 'comprimento',
                'mysql_tipovar'     => 'int', //varchar, int, 
                'mysql_tamanho'     => 11,
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
                    'Nome'              => __('Comprimento'),
                    'Mascara'           => 'Numero',
                    'valor_padrao'      => FALSE,
                    'readonly'          => FALSE,
                    'aviso'             => '0 = Nenhum',
                    'formtipo'          => 'input',
                    'input'             => array(
                        'tipo'              => 'text',
                        'class'             => 'obrigatorio'
                    )
                )
            ),
            Array(
                'mysql_titulo'      => 'altura',
                'mysql_tipovar'     => 'int', //varchar, int, 
                'mysql_tamanho'     => 11,
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
                    'Nome'              => __('Altura'),
                    'Mascara'           => 'Numero',
                    'valor_padrao'      => FALSE,
                    'readonly'          => FALSE,
                    'aviso'             => '0 = Nenhum',
                    'formtipo'          => 'input',
                    'input'             => array(
                        'tipo'              => 'text',
                        'class'             => 'obrigatorio'
                    )
                )
            ),
            Array(
                'mysql_titulo'      => 'largura',
                'mysql_tipovar'     => 'int', //varchar, int, 
                'mysql_tamanho'     => 11,
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
                    'Nome'              => __('Largura'),
                    'Mascara'           => 'Numero',
                    'valor_padrao'      => FALSE,
                    'readonly'          => FALSE,
                    'aviso'             => '0 = Nenhum',
                    'formtipo'          => 'input',
                    'input'             => array(
                        'tipo'              => 'text',
                        'class'             => 'obrigatorio'
                    )
                )
            ),
            Array(
                'mysql_titulo'      => 'capacidade',
                'mysql_tipovar'     => 'int', //varchar, int, 
                'mysql_tamanho'     => 11,
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
                    'Nome'              => __('Capacidade'),
                    'Mascara'           => 'Numero',
                    'valor_padrao'      => FALSE,
                    'readonly'          => FALSE,
                    'aviso'             => '0 = Nenhum',
                    'formtipo'          => 'input',
                    'input'             => array(
                        'tipo'              => 'text',
                        'class'             => 'obrigatorio'
                    )
                )
            ),
            Array(
                'mysql_titulo'      => 'qnt_volumes',
                'mysql_tipovar'     => 'int', //varchar, int, 
                'mysql_tamanho'     => 11,
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
                    'Nome'              => __('Qnt de Volumes'),
                    'Mascara'           => 'Numero',
                    'valor_padrao'      => FALSE,
                    'readonly'          => FALSE,
                    'aviso'             => '0 = Nenhum',
                    'formtipo'          => 'input',
                    'input'             => array(
                        'tipo'              => 'text',
                        'class'             => 'obrigatorio'
                    )
                )
            ),
            Array(
                'mysql_titulo'      => 'peso_bruto',
                'mysql_tipovar'     => 'int', //varchar, int, 
                'mysql_tamanho'     => 11,
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
                    'Nome'              => __('Peso Bruto'),
                    'Mascara'           => 'Numero',
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
                'mysql_titulo'      => 'inicio_data',
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
                    'Nome'              => __('Data do Inicio'),
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
                'mysql_titulo'      => 'fim_data',
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
                    'Nome'              => __('Data do Fim'),
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
            ),
            Array(
                'mysql_titulo'      => 'inicio_pais',
                'mysql_tipovar'     => 'int', //varchar, int, 
                'mysql_tamanho'     => 11,
                'mysql_null'        => FALSE,  // nulo ?
                'mysql_default'     => FALSE, // valor padrao
                'mysql_primary'     => FALSE,  // chave primaria
                'mysql_estrangeira' => 'SLP.id|SLP.nome', // chave estrangeira     ligacao|apresentacao|condicao
                'form_change'       => 'TAP', // CHANGE PARA EXTRANGEIRAS -> Sigla Tabela Pai / Sigla Tabela Atual ou false
                'mysql_autoadd'     => FALSE,
                'mysql_comment'     => FALSE,
                'mysql_inside'      => FALSE, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => FALSE, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => FALSE, //permissao funcional necessaria para campo 2 todos 
                'linkextra'         => '', //0 ninguem, 1 admin, 2 todos 
                'edicao'            => Array(
                    'Nome'              => __('País de Saida'),
                    'valor_padrao'      => FALSE,
                    'readonly'          => FALSE,
                    'aviso'             => ''
                ) 
            ),
            Array(
                'mysql_titulo'      => 'inicio_estado',
                'mysql_tipovar'     => 'int', //varchar, int, 
                'mysql_tamanho'     => 11,
                'mysql_null'        => FALSE,  // nulo ?
                'mysql_default'     => FALSE, // valor padrao
                'mysql_primary'     => FALSE,  // chave primaria
                'mysql_estrangeira' => 'SLE.id|SLE.sigla|SLE.pais={inicio_pais}', // chave estrangeira     ligacao|apresentacao|condicao
                'form_change'       => 'TAP', // CHANGE PARA EXTRANGEIRAS -> Sigla Tabela Pai / Sigla Tabela Atual ou false
                'mysql_autoadd'     => FALSE,
                'mysql_comment'     => FALSE,
                'mysql_inside'      => FALSE, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => FALSE, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => FALSE, //permissao funcional necessaria para campo 2 todos 
                'linkextra'         => '', //0 ninguem, 1 admin, 2 todos 
                'edicao'            => Array(
                    'Nome'              => __('Estado de Saida'),
                    'valor_padrao'      => FALSE,
                    'readonly'          => FALSE,
                    'aviso'             => ''
                )
            ),
            Array(
                'mysql_titulo'      => 'inicio_cidade',
                'mysql_tipovar'     => 'int', //varchar, int, 
                'mysql_tamanho'     => 11,
                'mysql_null'        => FALSE,  // nulo ?
                'mysql_default'     => FALSE, // valor padrao
                'mysql_primary'     => FALSE,  // chave primaria
                'mysql_estrangeira' => 'SLC.id|SLC.nome|SLC.estado={inicio_estado}', // chave estrangeira     ligacao|apresentacao|condicao
                'form_change'       => 'TAP', // CHANGE PARA EXTRANGEIRAS -> Sigla Tabela Pai / Sigla Tabela Atual ou false
                'mysql_autoadd'     => FALSE,
                'mysql_comment'     => FALSE,
                'mysql_inside'      => FALSE, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => FALSE, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => FALSE, //permissao funcional necessaria para campo 2 todos 
                'linkextra'         => '', //0 ninguem, 1 admin, 2 todos 
                'edicao'            => Array(
                    'Nome'              => __('Cidade de Saida'),
                    'valor_padrao'      => FALSE,
                    'readonly'          => FALSE,
                    'aviso'             => ''
                )
            ),
            Array(
                'mysql_titulo'      => 'inicio_bairro',
                'mysql_tipovar'     => 'int', //varchar, int, 
                'mysql_tamanho'     => 11,
                'mysql_null'        => FALSE,  // nulo ?
                'mysql_default'     => FALSE, // valor padrao
                'mysql_primary'     => FALSE,  // chave primaria
                'mysql_estrangeira' => 'SLB.id|SLB.nome|SLB.cidade={inicio_cidade}', // chave estrangeira     ligacao|apresentacao|condicao
                'mysql_autoadd'     => FALSE,
                'mysql_comment'     => FALSE,
                'mysql_inside'      => FALSE, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => FALSE, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => FALSE, //permissao funcional necessaria para campo 2 todos 
                'linkextra'         => '', //0 ninguem, 1 admin, 2 todos 
                'edicao'            => Array(
                    'Nome'              => __('Bairro de Saida'),
                    'valor_padrao'      => FALSE,
                    'readonly'          => FALSE,
                    'aviso'             => ''
                ) 
            ),
            Array(
                'mysql_titulo'      => 'fim_pais',
                'mysql_tipovar'     => 'int', //varchar, int, 
                'mysql_tamanho'     => 11,
                'mysql_null'        => FALSE,  // nulo ?
                'mysql_default'     => FALSE, // valor padrao
                'mysql_primary'     => FALSE,  // chave primaria
                'mysql_estrangeira' => 'SLP.id|SLP.nome', // chave estrangeira     ligacao|apresentacao|condicao
                'form_change'       => 'TAP', // CHANGE PARA EXTRANGEIRAS -> Sigla Tabela Pai / Sigla Tabela Atual ou false
                'mysql_autoadd'     => FALSE,
                'mysql_comment'     => FALSE,
                'mysql_inside'      => FALSE, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => FALSE, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => FALSE, //permissao funcional necessaria para campo 2 todos 
                'linkextra'         => '', //0 ninguem, 1 admin, 2 todos 
                'edicao'            => Array(
                    'Nome'              => __('País de Chegada'),
                    'valor_padrao'      => FALSE,
                    'readonly'          => FALSE,
                    'aviso'             => ''
                ) 
            ),
            Array(
                'mysql_titulo'      => 'fim_estado',
                'mysql_tipovar'     => 'int', //varchar, int, 
                'mysql_tamanho'     => 11,
                'mysql_null'        => FALSE,  // nulo ?
                'mysql_default'     => FALSE, // valor padrao
                'mysql_primary'     => FALSE,  // chave primaria
                'mysql_estrangeira' => 'SLE.id|SLE.sigla|SLE.pais={fim_pais}', // chave estrangeira     ligacao|apresentacao|condicao
                'form_change'       => 'TAP', // CHANGE PARA EXTRANGEIRAS -> Sigla Tabela Pai / Sigla Tabela Atual ou false
                'mysql_autoadd'     => FALSE,
                'mysql_comment'     => FALSE,
                'mysql_inside'      => FALSE, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => FALSE, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => FALSE, //permissao funcional necessaria para campo 2 todos 
                'linkextra'         => '', //0 ninguem, 1 admin, 2 todos 
                'edicao'            => Array(
                    'Nome'              => __('Estado de Chegada'),
                    'valor_padrao'      => FALSE,
                    'readonly'          => FALSE,
                    'aviso'             => ''
                )
            ),
            Array(
                'mysql_titulo'      => 'fim_cidade',
                'mysql_tipovar'     => 'int', //varchar, int, 
                'mysql_tamanho'     => 11,
                'mysql_null'        => FALSE,  // nulo ?
                'mysql_default'     => FALSE, // valor padrao
                'mysql_primary'     => FALSE,  // chave primaria
                'mysql_estrangeira' => 'SLC.id|SLC.nome|SLC.estado={fim_estado}', // chave estrangeira     ligacao|apresentacao|condicao
                'form_change'       => 'TAP', // CHANGE PARA EXTRANGEIRAS -> Sigla Tabela Pai / Sigla Tabela Atual ou false
                'mysql_autoadd'     => FALSE,
                'mysql_comment'     => FALSE,
                'mysql_inside'      => FALSE, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => FALSE, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => FALSE, //permissao funcional necessaria para campo 2 todos 
                'linkextra'         => '', //0 ninguem, 1 admin, 2 todos 
                'edicao'            => Array(
                    'Nome'              => __('Cidade de Chegada'),
                    'valor_padrao'      => FALSE,
                    'readonly'          => FALSE,
                    'aviso'             => ''
                )
            ),
            Array(
                'mysql_titulo'      => 'fim_bairro',
                'mysql_tipovar'     => 'int', //varchar, int, 
                'mysql_tamanho'     => 11,
                'mysql_null'        => FALSE,  // nulo ?
                'mysql_default'     => FALSE, // valor padrao
                'mysql_primary'     => FALSE,  // chave primaria
                'mysql_estrangeira' => 'SLB.id|SLB.nome|SLB.cidade={fim_cidade}', // chave estrangeira     ligacao|apresentacao|condicao
                'mysql_autoadd'     => FALSE,
                'mysql_comment'     => FALSE,
                'mysql_inside'      => FALSE, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => FALSE, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => FALSE, //permissao funcional necessaria para campo 2 todos 
                'linkextra'         => '', //0 ninguem, 1 admin, 2 todos 
                'edicao'            => Array(
                    'Nome'              => __('Bairro de Chegada'),
                    'valor_padrao'      => FALSE,
                    'readonly'          => FALSE,
                    'aviso'             => ''
                ) 
            ),
            // Status
            Array(
                'mysql_titulo'      => 'status',
                'mysql_tipovar'     => 'int', //varchar, int, 
                'mysql_tamanho'     => 3,
                'mysql_null'        => FALSE,  // nulo ?
                'mysql_default'     => 1, // valor padrao
                'mysql_primary'     => FALSE,  // chave primaria
                'mysql_estrangeira' => FALSE, // chave estrangeira     ligacao|apresentacao|condicao
                'mysql_autoadd'     => FALSE,
                'mysql_comment'     => FALSE,
                'mysql_inside'      => FALSE, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => FALSE, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => FALSE, //permissao funcional necessaria para campo 2 todos 
                'linkextra'         => '', //0 ninguem, 1 admin, 2 todos 
                'edicao'            => Array(
                    'Nome'              => __('Status'),
                    'valor_padrao'      => 0,
                    'readonly'          => FALSE,
                    'aviso'             => '',
                    'formtipo'          => 'select',
                    'select'            => array(
                        'opcoes'            => array(
                            array(
                                'value'         =>  '1',
                                'nome'          => 'Fechado'
                            ),
                            array(
                                'value'         =>  '0',
                                'nome'          => 'Aberto'
                            ),
                        )
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
