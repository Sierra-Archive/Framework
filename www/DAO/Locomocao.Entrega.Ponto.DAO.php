<?php
final Class Locomocao_Entrega_Ponto_DAO extends Framework\App\Dao 
{
    protected $id;
    protected $motoboy;
    protected $endereco_saida;
    protected $endereco_chegada;
    protected $tempo;
    protected $distancia;
    
    protected $status;
    protected $obs;
    protected static $objetocarregado     = false;     protected static $mysql_colunas       = false;     protected static $mysql_outside       = Array();     protected static $mysql_inside        = Array(); public function __construct() {  parent::__construct(); } public static function Get_Nome(){
        return MYSQL_LOCOMOCAO_ENTREGA_PONTO;
    }
    /**
     * Fornece Permissão de Copia da tabela
     * @return string
     */
    public static function Permissao_Copia(){
        return false;
    }
    public static function Get_Sigla(){
        return 'LEP';
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
                'mysql_titulo'      => 'motoboy',
                'mysql_tipovar'     => 'int', //varchar, int, 
                'mysql_tamanho'     => 11,
                'mysql_null'        => true, // true NULL, false, NOT NULL
                'mysql_default'     => false,//false -> NONE, outro -> default
                'mysql_primary'     => false, // chave primaria
                'mysql_estrangeira' => 'U.id|U.nome', //|CA.mod_acc=Locomocao_Caminhao chave estrangeira     ligacao|apresentacao|condicao
                'mysql_autoadd'     => false,
                'mysql_comment'     => false,
                'mysql_inside'      => false, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => false, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false, //permissao funcional necessaria para campo 2 todos 
                'linkextra'         => false, //'categoria/Admin/Categorias_Add/Locomocao_Caminhao', //0 ninguem, 1 admin, 2 todos 
                'edicao'            => Array(
                    'Nome'              => __('Motoboy'),
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => '',
                    'formtipo'          => 'select',
                    'select'             => array(
                        'class'             => 'obrigatorio',
                        'infonulo'          => 'Escolha um Motoboy',
                    )
                )
            ),Array(
                'mysql_titulo'      => 'endereco_saida',
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
                    'Nome'              => __('Endereço de Saida'),
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
                'mysql_titulo'      => 'endereco_saida',
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
                    'Nome'              => __('Endereço de Chegada'),
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
                'mysql_titulo'      => 'tempo',
                'mysql_tipovar'     => 'int', //varchar, int, 
                'mysql_tamanho'     => 11,
                'mysql_null'        => false,  // nulo ?
                'mysql_default'     => false, // valor padrao
                'mysql_primary'     => false,  // chave primaria
                'mysql_estrangeira' => false, // chave estrangeira     ligacao|apresentacao|condicao
                'mysql_autoadd'     => false,
                'mysql_comment'     => false,
                'mysql_inside'      => false, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => false, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false, //permissao funcional necessaria para campo 2 todos 
                'linkextra'         => '', //0 ninguem, 1 admin, 2 todos 
                'edicao'            => Array(
                    'Nome'              => __('Tempo'),
                    'Mascara'           => 'Numero',
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => '0 = Nenhum',
                    'formtipo'          => 'input',
                    'input'             => array(
                        'tipo'              => 'text',
                        'class'             => 'obrigatorio'
                    )
                )
            ),
            Array(
                'mysql_titulo'      => 'distancia',
                'mysql_tipovar'     => 'int', //varchar, int, 
                'mysql_tamanho'     => 11,
                'mysql_null'        => false,  // nulo ?
                'mysql_default'     => false, // valor padrao
                'mysql_primary'     => false,  // chave primaria
                'mysql_estrangeira' => false, // chave estrangeira     ligacao|apresentacao|condicao
                'mysql_autoadd'     => false,
                'mysql_comment'     => false,
                'mysql_inside'      => false, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => false, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false, //permissao funcional necessaria para campo 2 todos 
                'linkextra'         => '', //0 ninguem, 1 admin, 2 todos 
                'edicao'            => Array(
                    'Nome'              => __('Distância'),
                    'Mascara'           => 'Numero',
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => '0 = Nenhum',
                    'formtipo'          => 'input',
                    'input'             => array(
                        'tipo'              => 'text',
                        'class'             => 'obrigatorio'
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
                'linkextra'         => '', //0 ninguem, 1 admin, 2 todos 
                'edicao'            => Array(
                    'Nome'              => __('Status'),
                    'valor_padrao'      => 0,
                    'readonly'          => false,
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
