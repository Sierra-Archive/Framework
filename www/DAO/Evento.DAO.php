<?php
final Class Evento_DAO extends Framework\App\Dao 
{
    protected $id;
    protected $nome;
    protected $local;
    protected $data_inicio;
    protected $data_fim;
    protected $destaque;
    protected $status;
    protected $foto;
    protected $texto;
    protected static $objetocarregado     = false;     protected static $mysql_colunas       = false;     protected static $mysql_outside       = Array();     protected static $mysql_inside        = Array(); public function __construct() {  parent::__construct(); } public static function Get_Nome(){
        return MYSQL_EVENTO;
    }
    /**
     * Fornece Permissão de Copia da tabela
     * @return string
     */
    public static function Permissao_Copia(){
        return false;
    }
    public static function Get_Sigla(){
        return 'Event';
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
                'edicao'            => Array(
                    'Nome'              => 'Nome do Evento',
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => '',
                    'formtipo'          => 'input',
                    'input'             => array(
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
                'mysql_estrangeira' => 'L.id|L.nome', // chave estrangeira
                'mysql_autoadd'     => false,
                'mysql_comment'     => false,
                'mysql_inside'      => false, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => false, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false, //permissao funcional necessaria para campo 2 todos 
                'linkextra'         => 'locais/locais/Locais_Add',
                'edicao'            => Array(
                    'Nome'              => 'Local do Evento',
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => '',
                    'formtipo'          => 'select',
                    'select'             => array(
                        'class'             => 'obrigatorio',
                        'infonulo'          => 'Escolha um Local'
                    )
                )
            ),Array(
                'mysql_titulo'      => 'data_inicio',
                'mysql_tipovar'     => 'datetime', //varchar, int, 
                'mysql_tamanho'     => 19,
                'mysql_null'        => true,
                'mysql_default'     => '0000-00-00 00:00:00', // valor padrao
                'mysql_primary'     => false,
                'mysql_estrangeira' => false, // chave estrangeira
                'mysql_autoadd'     => false,
                'mysql_comment'     => false,
                'mysql_inside'      => 'data_hora_brasil_eua({valor})', // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => 'data_hora_eua_brasil({valor})', // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false, //permissao funcional necessaria para campo 2 todos 
                'edicao'            => Array(
                    'Nome'              => 'Inicio do Evento',
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => '',
                    'formtipo'          => 'input',
                    'input'             => array(
                        'tipo'              => 'text',
                        'class'             => 'obrigatorio masc_data_hora'
                    )
                )
            ),Array(
                'mysql_titulo'      => 'data_fim',
                'mysql_tipovar'     => 'datetime', //varchar, int, 
                'mysql_tamanho'     => 19,
                'mysql_null'        => true,
                'mysql_default'     => '0000-00-00 00:00:00', // valor padrao
                'mysql_primary'     => false,
                'mysql_estrangeira' => false, // chave estrangeira
                'mysql_autoadd'     => false,
                'mysql_comment'     => false,
                'mysql_inside'      => 'data_hora_brasil_eua({valor})', // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => 'data_hora_eua_brasil({valor})', // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false, //permissao funcional necessaria para campo 2 todos 
                'edicao'            => Array(
                    'Nome'              => 'Fim do Evento',
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => '',
                    'formtipo'          => 'input',
                    'input'             => array(
                        'tipo'              => 'text',
                        'class'             => 'obrigatorio masc_data_hora'
                    )
                )
            ),
            Array(
                'TabelaLinkada'     => Array(
                    'Pai'               => 'Event', // TABELA que vai manipular a conexao
                    'Tabela'            => 'EventA', // TABELA de LINK A SER CONECTADA
                    'valor_padrao'      => false, // id do pai
                    'Nome'              => 'Artistas', // Nome no FOrmulario
                    'Class'             => 'obrigatorio', // Classe no formulario
                    'aviso'             => '', // Aviso no formulario
                    'formtipo'          => 'SelectMultiplo',  // Tipo de formulario
                    'SelectMultiplo'   => Array(
                        'Extrangeira'       => 'MAA.id|MAA.nome',
                        'Linkar'            => 'evento', // CAmpo a ser encaixado id do pai
                        'Linkado'           => 'artista',// CAmpo a ser encaixado id do link
                        'Campos'            => Array(
                            'cache'
                        ),
                        'infonulo'          => 'Escolha pelo menos um Artista',
                      'linkextra'         => false
                    ), // Campo Boleano da tabela LINK, caso false apaga os que nao forem puxados
                )
            ),
            Array(
                'mysql_titulo'      => 'destaque',
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
                'edicao'            => Array(
                    'Nome'              => 'Destaque',
                    'valor_padrao'      => 0,
                    'readonly'          => false,
                    'aviso'             => '',
                    'formtipo'          => 'select',
                    'select'            => array(
                        'class'             => 'obrigatorio',
                        'infonulo'          => 'Escolha se o Evento fica ou não em destaque',
                        'opcoes'            => array(
                            array(
                                'value'         =>  '0',
                                'nome'          => 'Não'
                            ),
                            array(
                                'value'         =>  '1',
                                'nome'          => 'Sim'
                            ),
                        )
                    )
                )
            ),
            Array(
                'mysql_titulo'      => 'status',
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
                    'Nome'              => 'Ativado',
                    'valor_padrao'      => 1,
                    'readonly'          => false,
                    'aviso'             => '',
                    'formtipo'          => 'select',
                    'select'            => array(
                        'class'             => 'obrigatorio',
                        'infonulo'          => 'Escolha se a noticia está ou não ativada',
                        'opcoes'            => array(
                            array(
                                'value'         =>  '1',
                                'nome'          => 'Ativado'
                            ),
                            array(
                                'value'         =>  '0',
                                'nome'          => 'Desativado'
                            ),
                        )
                    )
                )
            ),
            Array(
                'mysql_titulo'      => 'foto',
                'mysql_tipovar'     => 'longtext', //varchar, int, 
                'mysql_tamanho'     => 10000,
                'mysql_null'        => true,  // nulo ?
                'mysql_default'     => '', // valor padrao
                'mysql_primary'     => false,  // chave primaria
                'mysql_estrangeira' => false, // chave estrangeira     ligacao|apresentacao|condicao
                'mysql_autoadd'     => false,
                'mysql_comment'     => false,
                'mysql_inside'      => false, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => false, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false, //permissao funcional necessaria para campo 2 todos 
                'linkextra'          => '', //0 ninguem, 1 admin, 2 todos 
                'edicao'            => Array(
                    'Nome'              => 'Upload de Foto',
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => 'Imagens somente do tipo GIF ou JPG',
                    'aviso_titulo'      => 'Importante',
                    'formtipo'          => 'upload',
                    'upload'            => array(
                        'tipo'              => 'Imagem',
                        'class'             => ''
                    )
                )
            ),
            Array(
                'mysql_titulo'      => 'texto',
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
                    'Nome'              => 'Descrição do Evento',
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
