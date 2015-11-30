<?php
final Class Usuario_Agenda_Compromisso_DAO extends Framework\App\Dao 
{
    protected $id;
    protected $nome;
    protected $dt_inicio;
    protected $dt_fim;
    protected $descricao;
    protected $local;
    
    protected static $objetocarregado     = false;     
    protected static $mysql_colunas       = false;     
    protected static $mysql_outside       = Array();     
    protected static $mysql_inside        = Array(); 
    public function __construct() {  parent::__construct(); } 
    public static function Get_Nome(){
        return MYSQL_USUARIO_AGENDA_COMPROMISSOS;
    }
    /**
     * Fornece Permissão de Copia da tabela
     * @return string
     */
    public static function Permissao_Copia(){
        return false;
    }
    public static function Get_Sigla(){
        return 'UAC';
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
                'mysql_titulo'      => 'nome',
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
                    'Nome'              =>  'Titulo',
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => '',
                    'formtipo'          => 'input',
                    'input'             => array(
                        'tipo'              => 'text',
                        'class'             => 'obrigatorio'
                    )
                )
            ),
            Array(
                'mysql_titulo'      => 'dt_inicio',
                'mysql_tipovar'     => 'datetime', //varchar, int, 
                'mysql_tamanho'     => 19,
                'mysql_null'        => false,
                'mysql_default'     => '0000-00-00 00:00:00',
                'mysql_primary'     => false,
                'mysql_estrangeira' => false, // chave estrangeira
                'mysql_autoadd'     => false,
                'mysql_comment'     => false,
                'mysql_inside'      => 'data_hora_brasil_eua({valor})', // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => 'data_hora_eua_brasil({valor})', // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false, //permissao funcional necessaria para campo 2 todos 
                'linkextra'          => '', // //0 ninguem, 1 admin, 2 todos 
                'edicao'            => Array(
                    'Nome'              => 'Data Inicio',
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => '',
                    'formtipo'          => 'input',
                    'validar'           => 'Control_Layoult_Valida_DataTime',
                    'input'             => array(
                        'tipo'              => 'text',
                        'class'             => 'obrigatorio masc_data_hora'
                    )
                )
            ),
            Array(
                'mysql_titulo'      => 'dt_fim',
                'mysql_tipovar'     => 'datetime', //varchar, int, 
                'mysql_tamanho'     => 19,
                'mysql_null'        => false,
                'mysql_default'     => '0000-00-00 00:00:00',
                'mysql_primary'     => false,
                'mysql_estrangeira' => false, // chave estrangeira
                'mysql_autoadd'     => false,
                'mysql_comment'     => false,
                'mysql_inside'      => 'data_hora_brasil_eua({valor})', // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => 'data_hora_eua_brasil({valor})', // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false, //permissao funcional necessaria para campo 2 todos 
                'linkextra'          => '', // //0 ninguem, 1 admin, 2 todos 
                'edicao'            => Array(
                    'Nome'              => 'Data Fim',
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => '',
                    'formtipo'          => 'input',
                    'validar'           => 'Control_Layoult_Valida_DataTime',
                    'input'             => array(
                        'tipo'              => 'text',
                        'class'             => 'obrigatorio masc_data_hora'
                    )
                )
            ),
            Array(
                'mysql_titulo'      => 'descricao',
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
                'linkextra'          => '', //0 ninguem, 1 admin, 2 todos 
                'edicao'            => Array(
                    'Nome'              => 'Observação',
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => '',
                    'formtipo'          =>'textarea',
                   'textarea'             => array(
                        'tipo'              => 'text',
                        'class'             => 'obrigatorio'
                    )
                )
            ),Array(
                'mysql_titulo'      => 'local',
                'mysql_tipovar'     => 'int', //varchar, int, 
                'mysql_tamanho'     => 11,
                'mysql_null'        => false,
                'mysql_default'     => false,
                'mysql_primary'     => false,
                'mysql_estrangeira' => 'LL.id|LL.nome', // chave estrangeira
                'mysql_autoadd'     => false,
                'mysql_comment'     => false,
                'mysql_inside'      => false, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => false, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false, //permissao funcional necessaria para campo 2 todos 
                'linkextra'          => false,//'comercio/Marca/Marcas_Add',
                'edicao'            => Array(
                    'Nome'              => 'Local',
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => ''
                )
            )
        );
    }
}
?>
