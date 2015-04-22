<?php
final Class Usuario_Mensagem_DAO extends Framework\App\Dao 
{
    protected $id               ;
    protected $cliente          ;
    protected $origem           ;
    protected $escritor         ;
    protected $escritor_nome    ;
    protected $para             ;
    protected $para_nome        ;
    protected $setor            ;
    protected $assunto          ;
    protected $marca            ;
    protected $linha            ;
    protected $produto          ;
    protected $lote             ;
    protected $validade         ;
    protected $fabricacao       ;
    protected $mensagem         ;
    protected $lido             ;
    protected $finalizado       ;
    protected $dt_lido          ;
    
    protected static $objetocarregado     = false;     protected static $mysql_colunas       = false;     protected static $mysql_outside       = Array();     protected static $mysql_inside        = Array(); public function __construct() {  parent::__construct(); } public static function Get_Nome(){
        return MYSQL_USUARIOS_MENS;
    }
    /**
     * Fornece Permissão de Copia da tabela
     * @return string
     */
    public static function Permissao_Copia(){
        return false;
    }
    public static function Get_Sigla(){
        return 'UM';
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
                'mysql_tamanho'     => 11,
                'mysql_null'        => false,  // nulo ?
                'mysql_default'     => false, // valor padrao
                'mysql_primary'     => true,  // chave primaria
                'mysql_estrangeira' => false, // chave estrangeira
                'mysql_autoadd'     => true,
                'mysql_comment'     => false,
                'mysql_inside'      => false, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => false, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false, //permissao funcional necessaria para campo 2 todos 
                'linkextra'          => '' ,//0 ninguem, 1 admin, 2 todos 
            ),
            Array(
                'mysql_titulo'      => 'escritor',
                'mysql_tipovar'     => 'int', //varchar, int, 
                'mysql_tamanho'     => 11,
                'mysql_null'        => false,  // nulo ?
                'mysql_default'     => false, // valor padrao
                'mysql_primary'     => false,  // chave primaria
                'mysql_estrangeira' => false,//'U.id|U.nome', // chave estrangeira
                'mysql_autoadd'     => false,
                'mysql_comment'     => false,
                'mysql_inside'      => false, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => false, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false, //permissao funcional necessaria para campo 2 todos 
                'linkextra'          => ''/*, //0 ninguem, 1 admin, 2 todos 
                'edicao'            => Array(
                    'Nome'              => 'De',
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => ''
                )*/
            ),
            Array(
                'mysql_titulo'      => 'escritor_nome',
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
                'perm_view'         => 2, //0 ninguem, 1 admin, 2 todos
                'perm_cadastrar'    => 1, //0 ninguem, 1 admin, 2 todos
                'perm_edit'         => 1
            ),
            Array(
                'mysql_titulo'      => 'para',
                'mysql_tipovar'     => 'int', //varchar, int, 
                'mysql_tamanho'     => 11,
                'mysql_null'        => false,  // nulo ?
                'mysql_default'     => false, // valor padrao
                'mysql_primary'     => false,  // chave primaria
                'mysql_estrangeira' => false,//'U.id|U.nome', // chave estrangeira
                'mysql_autoadd'     => false,
                'mysql_comment'     => false,
                'mysql_inside'      => false, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => false, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false, //permissao funcional necessaria para campo 2 todos 
                'linkextra'          => '', //0 ninguem, 1 admin, 2 todos 
                'edicao'            => Array(
                    'Nome'              => 'Para',
                    'valor_padrao'      => '0',
                    'readonly'          => false,
                    'aviso'             => '',
                    'formtipo'          => 'input',
                    'input'             => array(
                        'tipo'              => 'hidden',
                        'class'             => 'obrigatorio'
                    )
                )
            ),
            Array(
                'mysql_titulo'      => 'para_nome',
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
                'linkextra'          => '', //0 ninguem, 1 admin, 2 todos 
                'edicao'            => Array(
                    'Nome'              => 'Para',
                    'valor_padrao'      => 'Suporte',
                    'readonly'          => false,
                    'aviso'             => 'Apenas letras',
                    'formtipo'          => 'input',
                    'input'             => array(
                        'tipo'              => 'hidden',
                        'class'             => 'obrigatorio'
                    )
                )
            ),Array(
                'mysql_titulo'      => 'setor',
                'mysql_tipovar'     => 'int', //varchar, int, 
                'mysql_tamanho'     => 11,
                'mysql_null'        => false,
                'mysql_default'     => false,
                'mysql_primary'     => false,
                'mysql_estrangeira' => 'UMS.id|UMS.nome', // chave estrangeira
                'form_change'       => 'UM', // CHANGE PARA EXTRANGEIRAS -> Sigla Tabela Pai / Sigla Tabela Atual ou false
                'mysql_autoadd'     => false,
                'mysql_comment'     => false,
                'mysql_inside'      => false, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => false, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false, //permissao funcional necessaria para campo 2 todos 
                'linkextra'          => 'usuario_mensagem/Setor/Setores_Add',
                'edicao'            => Array(
                    'Nome'              => 'Setor',
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => '',
                    'formtipo'          => 'select',
                    'select'             => array(
                        'class'             => 'obrigatorio',
                        'infonulo'          => 'Escolha um Setor',
                    )
                )
            ),
            Array(
                'mysql_titulo'      => 'assunto',
                'mysql_tipovar'     => 'int', //varchar, int, 
                'mysql_tamanho'     => 11,
                'mysql_null'        => true,  // nulo ?
                'mysql_default'     => 0, // valor padrao
                'mysql_primary'     => false,  // chave primaria
                'mysql_estrangeira' => 'UMA.id|UMA.nome|UMA.setor={setor}', // chave estrangeira     ligacao|apresentacao|condicao
                'mysql_autoadd'     => false,
                'mysql_comment'     => false,
                'mysql_inside'      => false, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => false, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false, //permissao funcional necessaria para campo 2 todos 
                'linkextra'          => 'usuario_mensagem/Assunto/Assuntos_Add',
                'edicao'            => Array(
                    'Nome'              => 'Assunto',
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => 'Apenas letras',
                    'formtipo'          => 'select',
                    'select'             => array(
                        'class'             => 'obrigatorio',
                        'infonulo'          => 'Escolha um Assunto',
                    )
                )
            ),
            Array(
                'mysql_titulo'      => 'cliente',
                'mysql_tipovar'     => 'int', //varchar, int, 
                'mysql_tamanho'     => 11,
                'mysql_null'        => true,  // nulo ?
                'mysql_default'     => 0, // valor padrao
                'mysql_primary'     => false,  // chave primaria
                'mysql_estrangeira' => 'U.id|U.nome-U.razao_social|EXTB.categoria='.CFG_TEC_CAT_ID_CLIENTES, // chave estrangeira     ligacao|apresentacao|condicao
                'mysql_autoadd'     => false,
                'mysql_comment'     => false,
                'mysql_inside'      => false, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => false, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false, //permissao funcional necessaria para campo 2 todos 
                'linkextra'          => false, //'usuario/Admin/Usuarios_Add/cliente',
                'edicao'            => Array(
                    'Nome'              => 'Cliente',
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => 'obrigatorio',
                    'formtipo'          => 'select',
                    'select'             => array(
                        'class'             => 'obrigatorio',
                        'infonulo'          => 'Escolha um Cliente',
                    )
                )
            ),
            Array(
                'mysql_titulo'      => 'origem',
                'mysql_tipovar'     => 'int', //varchar, int, 
                'mysql_tamanho'     => 11,
                'mysql_null'        => true,  // nulo ?
                'mysql_default'     => 0, // valor padrao
                'mysql_primary'     => false,  // chave primaria
                'mysql_estrangeira' => 'UMO.id|UMO.nome', // chave estrangeira     ligacao|apresentacao|condicao
                'mysql_autoadd'     => false,
                'mysql_comment'     => false,
                'mysql_inside'      => false, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => false, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false, //permissao funcional necessaria para campo 2 todos 
                'linkextra'          => 'usuario_mensagem/Origem/Origens_Add',
                'edicao'            => Array(
                    'Nome'              => 'Origem',
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => '',
                    'formtipo'          => 'select',
                    'select'             => array(
                        'class'             => 'obrigatorio',
                        'infonulo'          => 'Escolha uma Origem',
                    )
                )
            ),Array(
                'mysql_titulo'      => 'marca',
                'mysql_tipovar'     => 'int', //varchar, int, 
                'mysql_tamanho'     => 11,
                'mysql_null'        => false,
                'mysql_default'     => false,
                'mysql_primary'     => false,
                'mysql_estrangeira' => 'CM.id|CM.nome', // chave estrangeira
                'form_change'       => 'UM', // CHANGE PARA EXTRANGEIRAS -> Sigla Tabela Pai / Sigla Tabela Atual ou false
                'mysql_autoadd'     => false,
                'mysql_comment'     => false,
                'mysql_inside'      => false, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => false, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false, //permissao funcional necessaria para campo 2 todos 
                'linkextra'          => 'comercio/Marca/Marcas_Add',
                'edicao'            => Array(
                    'Nome'              => 'Marca da Linha',
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => '',
                    'formtipo'          => 'select',
                    'select'             => array(
                        'class'             => 'obrigatorio',
                        'infonulo'          => 'Escolha uma Marca',
                    )
                )
            ),Array(
                'mysql_titulo'      => 'linha',
                'mysql_tipovar'     => 'int', //varchar, int, 
                'mysql_tamanho'     => 11,
                'mysql_null'        => false,
                'mysql_default'     => false,
                'mysql_primary'     => false,
                'mysql_estrangeira' => 'CL.id|CL.nome|CL.marca={marca}', // chave estrangeira
                'form_change'       => 'UM', // CHANGE PARA EXTRANGEIRAS -> Sigla Tabela Pai / Sigla Tabela Atual ou false
                'mysql_autoadd'     => false,
                'mysql_comment'     => false,
                'mysql_inside'      => false, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => false, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false, //permissao funcional necessaria para campo 2 todos 
                'linkextra'          => 'comercio/Linha/Linhas_Add', 
                'edicao'            => Array(
                    'Nome'              => 'Linha do Produto',
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => '',
                    'formtipo'          => 'select',
                    'select'             => array(
                        'class'             => 'obrigatorio',
                        'infonulo'          => 'Escolha uma Linha',
                    )
                )
            ),
            Array(
                'mysql_titulo'      => 'produto',
                'mysql_tipovar'     => 'int', //varchar, int, 
                'mysql_tamanho'     => 11,
                'mysql_null'        => true,  // nulo ?
                'mysql_default'     => 0, // valor padrao
                'mysql_primary'     => false,  // chave primaria
                'mysql_estrangeira' => 'CP.id|CP.nome|CP.linha={linha}', // chave estrangeira     ligacao|apresentacao|condicao
                'mysql_autoadd'     => false,
                'mysql_comment'     => false,
                'mysql_inside'      => false, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => false, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false, //permissao funcional necessaria para campo 2 todos 
                'linkextra'          => 'comercio/Produto/Produtos_Add',
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
            ),
            Array(
                'mysql_titulo'      => 'lote',
                'mysql_tipovar'     => 'varchar', //varchar, int, 
                'mysql_tamanho'     => 100,
                'mysql_null'        => true,  // nulo ?
                'mysql_default'     => 'Sem Lote', // valor padrao
                'mysql_primary'     => false,  // chave primaria
                'mysql_estrangeira' => false, // chave estrangeira     ligacao|apresentacao|condicao
                'mysql_autoadd'     => false,
                'mysql_comment'     => false,
                'mysql_inside'      => false, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => false, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false, //permissao funcional necessaria para campo 2 todos 
                'linkextra'          => '', //0 ninguem, 1 admin, 2 todos 
                'edicao'            => Array(
                    'Nome'              => 'Número do Lote',
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
            Array(
                'mysql_titulo'      => 'validade',
                'mysql_tipovar'     => 'varchar', //varchar, int, 
                'mysql_tamanho'     => 12,
                'mysql_null'        => false,  // nulo ?
                'mysql_default'     => '0000-00', // valor padrao
                'mysql_primary'     => false,  // chave primaria
                'mysql_estrangeira' => false, // chave estrangeira     ligacao|apresentacao|condicao
                'mysql_autoadd'     => false,
                'mysql_comment'     => false,
                'mysql_inside'      => false, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => false, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false, //permissao funcional necessaria para campo 2 todos 
                'linkextra'          => '',
                'edicao'            => Array(
                    'Nome'              => 'Data de Validade',
                    'Mascara'           => 'Validade',
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => 'Mês / Ano',
                    'validar'           => 'Control_Layoult_Valida_Validade',
                    'formtipo'          => 'input',
                    'input'             => array(
                        'tipo'              => 'text',
                        'class'             => ''
                    )
                )
            ),
            Array(
                'mysql_titulo'      => 'fabricacao',
                'mysql_tipovar'     => 'varchar', //varchar, int, 
                'mysql_tamanho'     => 12,
                'mysql_null'        => false,  // nulo ?
                'mysql_default'     => '0000-00', // valor padrao
                'mysql_primary'     => false,  // chave primaria
                'mysql_estrangeira' => false, // chave estrangeira     ligacao|apresentacao|condicao
                'mysql_autoadd'     => false,
                'mysql_comment'     => false,
                'mysql_inside'      => false, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => false, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false, //permissao funcional necessaria para campo 2 todos 
                'linkextra'          => '',
                'edicao'            => Array(
                    'Nome'              => 'Data de Fabricação',
                    'Mascara'           => 'Validade',
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => 'Mês / Ano',
                    'validar'           => 'Control_Layoult_Valida_Validade',
                    'formtipo'          => 'input',
                    'input'             => array(
                        'tipo'              => 'text',
                        'class'             => ''
                    )
                )
            ),
            Array(
                'mysql_titulo'      => 'mensagem',
                'mysql_tipovar'     => 'longtext', //varchar, int, 
                'mysql_tamanho'     => 10000,
                'mysql_null'        => true,  // nulo ?
                'mysql_default'     => 'Sem Mensagem', // valor padrao
                'mysql_primary'     => false,  // chave primaria
                'mysql_estrangeira' => false, // chave estrangeira     ligacao|apresentacao|condicao
                'mysql_autoadd'     => false,
                'mysql_comment'     => false,
                'mysql_inside'      => 'br2nl({valor})', // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => 'nl2br({valor})', // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false, //permissao funcional necessaria para campo 2 todos 
                'linkextra'          => '', //0 ninguem, 1 admin, 2 todos 
                'edicao'            => Array(
                    'Nome'              => 'Mensagem',
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => 'Apenas letras',
                    'formtipo'          =>'textarea',
                    'input'             => array(
                        'tipo'              => 'text',
                        'class'             => 'obrigatorio'
                    )
                )
            ),
            Array(
                'mysql_titulo'      => 'lido',
                'mysql_tipovar'     => 'int', //varchar, int, 
                'mysql_tamanho'     => 3,
                'mysql_null'        => false,  // nulo ?
                'mysql_default'     => 0, // valor padrao
                'mysql_primary'     => false,  // chave primaria
                'mysql_estrangeira' => false, // chave estrangeira     ligacao|apresentacao|condicao
                'mysql_autoadd'     => false,
                'mysql_comment'     => false,
                'mysql_inside'      => false, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => false, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false, //permissao funcional necessaria para campo 2 todos 
                'linkextra'          => ''
            ),
            Array(
                'mysql_titulo'      => 'finalizado',
                'mysql_tipovar'     => 'int', //varchar, int, 
                'mysql_tamanho'     => 3,
                'mysql_null'        => false,  // nulo ?
                'mysql_default'     => 0, // valor padrao
                'mysql_primary'     => false,  // chave primaria
                'mysql_estrangeira' => false, // chave estrangeira     ligacao|apresentacao|condicao
                'mysql_autoadd'     => false,
                'mysql_comment'     => false,
                'mysql_inside'      => false, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => false, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false, //permissao funcional necessaria para campo 2 todos 
                'linkextra'          => ''
            ),
            Array(
                'mysql_titulo'      => 'dt_lido',
                'mysql_tipovar'     => 'datetime', //varchar, int, 
                'mysql_tamanho'     => 19,
                'mysql_null'        => false,  // nulo ?
                'mysql_default'     => '0000-00-00 00:00:00', // valor padrao
                'mysql_primary'     => false,  // chave primaria
                'mysql_estrangeira' => false, // chave estrangeira     ligacao|apresentacao|condicao
                'mysql_autoadd'     => false,
                'mysql_comment'     => false,
                'mysql_inside'      => 'date_replace({valor}, "Y-m-d H:i:s")', // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => 'date_replace({valor}, "d/m/y | H:i")', // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false, //permissao funcional necessaria para campo 2 todos 
                'linkextra'          => '', //0 ninguem, 1 admin, 2 todos
            )
        );
    }
}
?>
