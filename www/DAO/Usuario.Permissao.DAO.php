<?php
final Class Usuario_Permissao_DAO extends Framework\App\Dao 
{
    protected $permissao;
    protected $usuario;
    protected $valor;
    
    // Padrao é false, ou array com os campos que nao aceita
    protected static $aceita_config       = false;
    protected static $campos_naoaceita_config  = Array('permissao','valor');
    
    protected static $objetocarregado     = false;     protected static $mysql_colunas       = false;     protected static $mysql_outside       = Array();     protected static $mysql_inside        = Array(); public function __construct() {  parent::__construct(); } public static function Get_Nome(){
        return MYSQL_USUARIO_PERMISSAO;
    }
    /**
     * Fornece Permissão de Copia da tabela
     * @return string
     */
    public static function Permissao_Copia(){
        return false;
    }
    public static function Get_Sigla(){
        return 'UP';
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
    public static function Get_LinkTable(){
        return Array(
            'U' =>'usuario',      // Sistemas Grupos
            'SP'=>'permissao', // Sistemas Permissoes
        );
    }
    public static function Get_Class(){
        return str_replace(Array('_DAO'), Array(''), get_class());
    }
    public static function Gerar_Colunas(){
        return Array(
            Array(
                'mysql_titulo'      => 'permissao',
                'mysql_tipovar'     => 'varchar', //varchar, int, 
                'mysql_tamanho'     => 100,
                'mysql_null'        => true,  // nulo ?
                'mysql_default'     => 0, // valor padrao
                'mysql_primary'     => true,  // chave primaria
                'mysql_estrangeira' => 'SP.chave|SP.nome', // chave estrangeira     ligacao|apresentacao|condicao
                'mysql_autoadd'     => false,
                'mysql_comment'     => false,
                'mysql_inside'      => false, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => false, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false, //permissao funcional necessaria para campo 2 todos 
                'linkextra'          => '', //0 ninguem, 1 admin, 2 todos 
            ),
            Array(
                'mysql_titulo'      => 'usuario',
                'mysql_tipovar'     => 'int', //varchar, int, 
                'mysql_tamanho'     => 11,
                'mysql_null'        => true,  // nulo ?
                'mysql_default'     => 0, // valor padrao
                'mysql_primary'     => true,  // chave primaria
                'mysql_estrangeira' => 'U.id|U.nome-U.razao_social', // chave estrangeira     ligacao|apresentacao|condicao
                'mysql_autoadd'     => false,
                'mysql_comment'     => false,
                'mysql_inside'      => false, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => false, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false, //permissao funcional necessaria para campo 2 todos 
                'linkextra'          => 'usuario/Admin/Usuarios_Add',
                'edicao'            => Array(
                    'Nome'              => 'Usuário',
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => ''
                )
            ),
            Array(
                'mysql_titulo'      => 'valor',
                'mysql_tipovar'     => 'int', //varchar, int, 
                'mysql_tamanho'     => 3,
                'mysql_null'        => true,  // nulo ?
                'mysql_default'     => 0, // valor padrao
                'mysql_primary'     => false,  // chave primaria
                'mysql_estrangeira' => false, // chave estrangeira     ligacao|apresentacao|condicao
                'mysql_autoadd'     => false,
                'mysql_comment'     => false,
                'mysql_inside'      => false, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => false, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false, //permissao funcional necessaria para campo 2 todos 
                'linkextra'          => '', //0 ninguem, 1 admin, 2 todos
                'edicao'            => Array(
                    'Nome'              => 'Valor',
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => 'Ativado ou não',
                    'formtipo'          => 'select',
                    'select'            => array(
                        'opcoes'            => array(
                            array(
                                'value'         =>  '0',
                                'nome'          => 'Desativado'
                            ),
                            array(
                                'value'         =>  '1',
                                'nome'          => 'Ativado'
                            )
                        )
                    )
                )
            )
        );
    }
}
?>
