<?php
final Class Usuario_DAO extends Framework\App\Dao 
{
    protected $id;
    protected $indicado_por;
    protected $grupo;
    //protected $crm;
    protected $nome;
    protected $fisica;
    protected $perfil_nascimento;
    protected $perfil_sexo;
    protected $cep;
    protected $endereco;
    protected $pais;
    protected $estado;
    protected $cidade;
    protected $bairro;
    protected $numero;
    protected $complemento;
    protected $telefone;
    protected $fax;
    protected $celular;
    protected $email;
    protected $site;
    protected $obs;
    protected $login;
    protected $senha;
    protected $cpf;
    
    //Upload
    protected $foto;
    //FISICO
    protected $rg;            // RG
    protected $orgao;         // ORGAO
    
    // Para Empresas
    protected $cnpj;         // CNPJ
    protected $cnpj_insc;    // CNPJ
    protected $razao_social; // Razao Social
    protected $nome_contato;
    protected $nomefantasia; // Nome Empresa
    // Endereço de Entrega
    protected $entrega_cep;
    protected $entrega_endereco;
    protected $entrega_pais;
    protected $entrega_estado;
    protected $entrega_cidade;
    protected $entrega_bairro;
    protected $entrega_numero;
    protected $entrega_complemento;
    //Certa
    protected $selo_liberar; // Liberar Selo 
    protected $resp_empresa;
    protected $resp_fatura;
    // Financeiro
    protected $banco;
    protected $agencia;
    protected $conta;
    //Clientes
    protected $email2;
    protected $telefone2;
    // Funcionarios
    protected $data_admissao;
    protected $data_demissao;
    protected $vale_transporte;
    protected $vale_refeicao;
    protected $hora_entrada;
    protected $hora_saida;
    protected $salariobase;
    protected $tipocontrato;
    protected $cnh;
    protected $cnh_valida;
    protected $emergencia;
    
    protected $ativado;
    protected $precoespecial;
    
    // Engenharia:
    protected $eng_clienteinvestidor;
    /*protected $empreendimento;
    protected $unidade;*/
    
    // Veiculos_Aluguel
    protected $foto_cnh;
    protected $foto_cnh_apv;
    protected $foto_res;
    protected $foto_res_apv;
    
    
    // Padrao é false, ou array com os campos que nao aceita
    protected static $campos_naoaceita_config  = Array('foto','email','email2','login','senha','foto_cnh','foto_res');
    
    protected static $objetocarregado     = false;     protected static $mysql_colunas       = false;     protected static $mysql_outside       = Array();     protected static $mysql_inside        = Array(); public function __construct() {  parent::__construct(); } public static function Get_Nome(){
        return MYSQL_USUARIOS;
    }
    /**
     * Fornece Permissão de Copia da tabela
     * @return string
     */
    public static function Permissao_Copia(){
        return false;
    }
    public static function Get_Sigla(){
        return 'U';
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
        if(isset($_COOKIE['indicativo_nome'])){
            $indicativo_nome = $_COOKIE['indicativo_nome'];
        }else{
            $indicativo_nome = 0;
        }
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
            ),
            Array(
                'mysql_titulo'      => 'indicado_por',
                'mysql_tipovar'     => 'int', //varchar, int, 
                'mysql_tamanho'     => 11,
                'mysql_null'        => true,  // nulo ?
                'mysql_default'     => $indicativo_nome, // valor padrao
                'mysql_primary'     => false,  // chave primaria
                'mysql_estrangeira' => 'U.id|U.nome-U.razao_social', // chave estrangeira     ligacao|apresentacao|condicao
                'mysql_autoadd'     => false,
                'mysql_comment'     => false,
                'mysql_inside'      => false, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => false, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false, //permissao funcional necessaria para campo 2 todos 
                'edicao'            => Array(
                    'Nome'              => __('Indicado Por'),
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => ''
                )
            ),
            Array(
                'mysql_titulo'      => 'grupo',
                'mysql_tipovar'     => 'int', //varchar, int, 
                'mysql_tamanho'     => 11,
                'mysql_null'        => true,  // nulo ?
                'mysql_default'     => 0, // valor padrao
                'mysql_primary'     => false,  // chave primaria
                'mysql_estrangeira' => 'SG.id|SG.nome', // chave estrangeira     ligacao|apresentacao|condicao
                'mysql_autoadd'     => false,
                'mysql_comment'     => false,
                'mysql_inside'      => false, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => false, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false, //permissao funcional necessaria para campo 2 todos 
                'edicao'            => Array(
                    'Nome'              => __('Grupo do Usuário'),
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => '',
                    'formtipo'          => 'select',
                    'select'             => array(
                        'class'             => 'obrigatorio',
                        'infonulo'          => 'Escolha um Grupo de Usuários',
                    )
                )
            ),
            Array(
                'mysql_titulo'      => 'crm',
                'mysql_tipovar'     => 'varchar', //varchar, int, 
                'mysql_tamanho'     => 30,
                'mysql_null'        => true,  // nulo ?
                'mysql_default'     => 0, // valor padrao
                'mysql_primary'     => false,  // chave primaria
                'mysql_estrangeira' => false, // chave estrangeira     ligacao|apresentacao|condicao
                'mysql_autoadd'     => false,
                'mysql_comment'     => false,
                'mysql_inside'      => false, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => false, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false //permissao funcional necessaria para campo 2 todos 
            ),
            Array(
                'mysql_titulo'      => 'eng_clienteinvestidor',
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
                'edicao'            => Array(
                    'Nome'              => __('Cliente ou Investidor'),
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => '',
                    'formtipo'          => 'select',
                    'select'            => array(
                        'class'             => 'obrigatorio',
                        'infonulo'          => 'Escolha se é cliente ou Investidor',
                        'opcoes'            => array(
                            array(
                                'value'         =>  '0',
                                'nome'          => 'Cliente'
                            ),
                            array(
                                'value'         =>  '1',
                                'nome'          => 'Investidor'
                            ),
                        )
                    )
                )
            ),/*Array(
                'mysql_titulo'      => 'empreendimento',
                'mysql_tipovar'     => 'int', //varchar, int, 
                'mysql_tamanho'     => 11,
                'mysql_null'        => false,
                'mysql_default'     => false,
                'mysql_primary'     => false,
                'mysql_estrangeira' => 'EE.id|EE.nome', // chave estrangeira
                'form_change'       => 'U', // CHANGE PARA EXTRANGEIRAS -> Sigla Tabela Pai / Sigla Tabela Atual ou false
                'mysql_autoadd'     => false,
                'mysql_comment'     => false,
                'mysql_inside'      => false, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => false, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false, //permissao funcional necessaria para campo 2 todos 
                'linkextra'         => 'Engenharia/Empreendimento/Empreendimentos_Add',
                'edicao'            => Array(
                    'Nome'              => __('Empreendimento'),
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => '',
                    'formtipo'          => 'select',
                    'select'            => array(
                        'class'             => 'obrigatorio',
                        'infonulo'          => 'Escolha um Empreendimento',
                    ),
                )
            ),Array(
                'mysql_titulo'      => 'unidade',
                'mysql_tipovar'     => 'int', //varchar, int, 
                'mysql_tamanho'     => 11,
                'mysql_null'        => false,
                'mysql_default'     => false,
                'mysql_primary'     => false,
                'mysql_estrangeira' => 'EEU.id|EEU.unidade|EEU.empreendimento={empreendimento}', // chave estrangeira
                'mysql_autoadd'     => false,
                'mysql_comment'     => false,
                'mysql_inside'      => false, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => false, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false, //permissao funcional necessaria para campo 2 todos 
                'linkextra'         => 'Engenharia/Unidade/Unidades_Add',
                'edicao'            => Array(
                    'Nome'              => __('Unidade do Empreendimento'),
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => '',
                    'formtipo'          => 'select',
                    'select'            => array(
                        'class'             => 'obrigatorio',
                        'infonulo'          => 'Escolha primeiro um Empreendimento',
                    ),
                )
            ),*/
            Array(
                'mysql_titulo'      => 'fisica',
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
                'edicao'            => Array(
                    'Nome'              => __('Pessoa Fisica ou Juridica'),
                    'valor_padrao'      => 1,
                    'readonly'          => false,
                    'aviso'             => '',
                    'formtipo'          => 'select',
                    'change'            => 'Control_Layoult_Form_Campos_Trocar(\'#nome,#nome_contato,#rg,#orgao,#cpf,#cnpj,#cnpj_insc,#razao_social,#nomefantasia\')',
                    'select'            => array(
                        'class'             => 'obrigatorio',
                        'infonulo'          => 'Escolha se a Pessoa é Fisica ou Juridica',
                        'opcoes'            => array(
                            array(
                                'value'         =>  '1',
                                'nome'          => 'Juridica'
                            ),
                            array(
                                'value'         =>  '0',
                                'nome'          => 'Fisica'
                            ),
                        )
                    )
                )
            ),
            Array(
                'mysql_titulo'      => 'nome',
                'mysql_tipovar'     => 'varchar', //varchar, int, 
                'mysql_tamanho'     => 100,
                'mysql_null'        => true,  // nulo ?
                'mysql_default'     => 'Sem nome', // valor padrao
                'mysql_primary'     => false,  // chave primaria
                'mysql_estrangeira' => false, // chave estrangeira     ligacao|apresentacao|condicao
                'mysql_autoadd'     => false,
                'mysql_comment'     => false,
                'mysql_inside'      => false, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => false, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false, //permissao funcional necessaria para campo 2 todos 
                'edicao'            => Array(
                    'Nome'              => __('Nome Completo'),
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => __('Apenas letras'),
                    'formtipo'          => 'input',
                    'form_escondido'    => true,    // Vai aparecer, quando trocar select
                    'input'             => array(
                        'tipo'              => 'text',
                        'class'             => 'obrigatorio masc_letras'
                    )
                )
            ),
            Array(
                'mysql_titulo'      => 'cpf',
                'mysql_tipovar'     => 'varchar', //varchar, int, 
                'mysql_tamanho'     => 200,
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
                    'Nome'              => __('CPF'),
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => '',
                    'formtipo'          => 'input',
                    'form_escondido'    => true,    // Vai aparecer, quando trocar select
                    'input'             => array(
                        'tipo'              => 'text',
                        'class'             => 'masc_cpf'
                    )
                )
            ),
            Array(
                'mysql_titulo'      => 'rg',
                'mysql_tipovar'     => 'varchar', //varchar, int, 
                'mysql_tamanho'     => 200,
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
                    'Nome'              => __('Registro Geral (RG)'),
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => '',
                    'formtipo'          => 'input',
                    'form_escondido'    => true,    // Vai aparecer, quando trocar select
                    'input'             => array(
                        'tipo'              => 'text',
                        'class'             => 'masc_rg'
                    )
                )
            ),
            Array(
                'mysql_titulo'      => 'orgao',
                'mysql_tipovar'     => 'varchar', //varchar, int, 
                'mysql_tamanho'     => 200,
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
                    'Nome'              => __('Orgão Emissor'),
                    'valor_padrao'      => '',   //DetranRJ
                    'readonly'          => false,
                    'aviso'             => '',
                    'formtipo'          => 'input',
                    'form_escondido'    => true,    // Vai aparecer, quando trocar select
                    'input'             => array(
                        'tipo'              => 'text',
                        'class'             => ''
                    )
                )
            ),
            Array(
                'mysql_titulo'      => 'razao_social',
                'mysql_tipovar'     => 'varchar', //varchar, int, 
                'mysql_tamanho'     => 200,
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
                    'Nome'              => __('Razão Social'),
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => '',
                    'formtipo'          => 'input',
                    'form_escondido'    => 'apagar', // Apagar = Vai Apagar Após a troca
                    'input'             => array(
                        'tipo'              => 'text',
                        'class'             => ''
                    )
                )
            ),
            Array(
                'mysql_titulo'      => 'nome_contato',
                'mysql_tipovar'     => 'varchar', //varchar, int, 
                'mysql_tamanho'     => 200,
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
                    'Nome'              => __('Nome do Contato'),
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => '',
                    'formtipo'          => 'input',
                    'form_escondido'    => 'apagar', // Se ficara escondido para aparecer apos troca
                    'input'             => array(
                        'tipo'              => 'text',
                        'class'             => ''
                    )
                )
            ),
            Array(
                'mysql_titulo'      => 'nomefantasia',
                'mysql_tipovar'     => 'varchar', //varchar, int, 
                'mysql_tamanho'     => 200,
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
                    'Nome'              => __('Nome Fantasia'),
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => '',
                    'formtipo'          => 'input',
                    'form_escondido'    => 'apagar', // Se ficara escondido para aparecer apos troca
                    'input'             => array(
                        'tipo'              => 'text',
                        'class'             => ''
                    )
                )
            ),
            Array(
                'mysql_titulo'      => 'cnpj',
                'mysql_tipovar'     => 'varchar', //varchar, int, 
                'mysql_tamanho'     => 200,
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
                    'Nome'              => __('Cnpj'),
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => '',
                    'formtipo'          => 'input',
                    'form_escondido'    => 'apagar', // Se ficara escondido para aparecer apos troca
                    'validar'           => 'Control_Layoult_Valida_CNPJ',
                    'input'             => array(
                        'tipo'              => 'text',
                        'class'             => 'masc_cnpj'
                    )
                )
            ),
            Array(
                'mysql_titulo'      => 'cnpj_insc',
                'mysql_tipovar'     => 'varchar', //varchar, int, 
                'mysql_tamanho'     => 200,
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
                    'Nome'              => __('Insc. Estadual / Municipal'),
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => '',
                    'formtipo'          => 'input',
                    'form_escondido'    => 'apagar', // Se ficara escondido para aparecer apos troca
                    'validar'           => 'Control_Layoult_Valida_INSC',
                    'input'             => array(
                        'tipo'              => 'text',
                        'class'             => 'masc_insc'
                    )
                )
            ),
            Array(
                'mysql_titulo'      => 'perfil_nascimento',
                'mysql_tipovar'     => 'date', //varchar, int, 
                'mysql_tamanho'     => 10,
                'mysql_null'        => false,  // nulo ?
                'mysql_default'     => '0000-00-00', // valor padrao
                'mysql_primary'     => false,  // chave primaria
                'mysql_estrangeira' => false, // chave estrangeira     ligacao|apresentacao|condicao
                'mysql_autoadd'     => false,
                'mysql_comment'     => false,
                'mysql_inside'      => 'data_brasil_eua({valor})', // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => 'data_eua_brasil({valor})', // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false, //permissao funcional necessaria para campo 2 todos 
                'edicao'            => Array(
                    'Nome'              => __('Nascimento'),
                    'Mascara'           => 'Data',
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => '',
                    'formtipo'          => 'input',
                    'validar'           => 'Control_Layoult_Valida_Data',
                    'form_escondido'    => true,    // Vai aparecer, quando trocar select
                    'input'             => array(
                        'tipo'              => 'text',
                        'class'             => ''
                    )
                )
            ),
            Array(
                'mysql_titulo'      => 'perfil_sexo',
                'mysql_tipovar'     => 'varchar', //varchar, int, 
                'mysql_tamanho'     => 20,
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
                    'Nome'              => __('Sexo'),
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => '',
                    'formtipo'          => 'select',
                    'form_escondido'    => true,    // Vai aparecer, quando trocar select
                    'select'            => array(
                        'opcoes'            => array(
                            array(
                                'value'         =>  '0',
                                'nome'          => 'Feminino'
                            ),
                            array(
                                'value'         =>  '1',
                                'nome'          => 'Masculino'
                            )
                        )
                    )
                )
            ),
            Array(
                'mysql_titulo'      => 'fax',
                'mysql_tipovar'     => 'varchar', //varchar, int, 
                'mysql_tamanho'     => 30,
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
                    'Nome'              => __('Fax'),
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => '',
                    'formtipo'          => 'input',
                    'input'             => array(
                        'tipo'              => 'text',
                        'class'             => 'masc_fone'
                    )
                )
            ),
            Array(
                'mysql_titulo'      => 'email',
                'mysql_tipovar'     => 'varchar', //varchar, int, 
                'mysql_tamanho'     => 200,
                'mysql_null'        => true,  // nulo ?
                'mysql_default'     => 'Sem Email', // valor padrao
                'mysql_primary'     => false,  // chave primaria
                'mysql_estrangeira' => false, // chave estrangeira     ligacao|apresentacao|condicao
                'mysql_autoadd'     => false,
                'mysql_comment'     => false,
                'mysql_inside'      => false, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => false, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false, //permissao funcional necessaria para campo 2 todos 
                'linkextra'         => '',
                'edicao'            => Array(
                    'Nome'              => __('Email'),
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => '',
                    'validar'           => 'Control_Layoult_Valida_EMAIL',
                    'formtipo'          => 'input',
                    'input'             => array(
                        'tipo'              => 'text',
                        'class'             => 'obrigatorio'
                    )
                )
            ),
            Array(
                'mysql_titulo'      => 'email2',
                'mysql_tipovar'     => 'varchar', //varchar, int, 
                'mysql_tamanho'     => 200,
                'mysql_null'        => true,  // nulo ?
                'mysql_default'     => 'Sem Email', // valor padrao
                'mysql_primary'     => false,  // chave primaria
                'mysql_estrangeira' => false, // chave estrangeira     ligacao|apresentacao|condicao
                'mysql_autoadd'     => false,
                'mysql_comment'     => false,
                'mysql_inside'      => false, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => false, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false, //permissao funcional necessaria para campo 2 todos 
                'linkextra'         => '',
                'edicao'            => Array(
                    'Nome'              => __('Email Alternativo'),
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => '',
                    'validar'           => 'Control_Layoult_Valida_EMAIL',
                    'formtipo'          => 'input',
                    'input'             => array(
                        'tipo'              => 'text',
                        'class'             => ''
                    )
                )
            ),
            Array(
                'mysql_titulo'      => 'telefone',
                'mysql_tipovar'     => 'varchar', //varchar, int, 
                'mysql_tamanho'     => 30,
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
                    'Nome'              => __('Telefone Fixo'),
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => '',
                    'formtipo'          => 'input',
                    'input'             => array(
                        'tipo'              => 'text',
                        'class'             => 'masc_fone'
                    )
                )
            ),
            Array(
                'mysql_titulo'      => 'telefone2',
                'mysql_tipovar'     => 'varchar', //varchar, int, 
                'mysql_tamanho'     => 30,
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
                    'Nome'              => __('Telefone Fixo 2'),
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => '',
                    'formtipo'          => 'input',
                    'input'             => array(
                        'tipo'              => 'text',
                        'class'             => 'masc_fone'
                    )
                )
            ),
            Array(
                'mysql_titulo'      => 'celular',
                'mysql_tipovar'     => 'varchar', //varchar, int, 
                'mysql_tamanho'     => 30,
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
                    'Nome'              => __('Celular'),
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => '',
                    'formtipo'          => 'input',
                    'input'             => array(
                        'tipo'              => 'text',
                        'class'             => 'masc_cel'
                    )
                )
            ),
            Array(
                'mysql_titulo'      => 'cep',
                'mysql_tipovar'     => 'varchar', //varchar, int, 
                'mysql_tamanho'     => 200,
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
                    'Nome'              => __('Cep'),
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => '',
                    'change'            => 'Control_Layoult_Pesquisa_Cep(\'#cep\')',
                    'validar'           => 'Control_Layoult_Valida_Cep',
                    'formtipo'          => 'input',
                    'input'             => array(
                        'tipo'              => 'text',
                        'class'             => 'masc_cep'
                    )
                )
            ),
            Array(
                'mysql_titulo'      => 'pais',
                'mysql_tipovar'     => 'int', //varchar, int, 
                'mysql_tamanho'     => 11,
                'mysql_null'        => false,  // nulo ?
                'mysql_default'     => false, // valor padrao
                'mysql_primary'     => false,  // chave primaria
                'mysql_estrangeira' => 'SLP.id|SLP.nome', // chave estrangeira     ligacao|apresentacao|condicao
                'form_change'       => 'U', // CHANGE PARA EXTRANGEIRAS -> Sigla Tabela Pai / Sigla Tabela Atual ou false
                'mysql_autoadd'     => false,
                'mysql_comment'     => false,
                'mysql_inside'      => false, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => false, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false, //permissao funcional necessaria para campo
                'linkextra'         => 'locais/localidades/Paises_Add', //0 ninguem, 1 admin, 2 todos 
                'edicao'            => Array(
                    'Nome'              => __('Pais'),
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => '',
                    'select'             => array(
                        'class'             => 'obrigatorio',
                        'infonulo'          => 'Escolha um Pais',
                    )
                ) 
            ),
            Array(
                'mysql_titulo'      => 'estado',
                'mysql_tipovar'     => 'int', //varchar, int, 
                'mysql_tamanho'     => 11,
                'mysql_null'        => false,  // nulo ?
                'mysql_default'     => false, // valor padrao
                'mysql_primary'     => false,  // chave primaria
                'mysql_estrangeira' => 'SLE.id|SLE.sigla|SLE.pais={pais}', // chave estrangeira     ligacao|apresentacao|condicao
                'form_change'       => 'U', // CHANGE PARA EXTRANGEIRAS -> Sigla Tabela Pai / Sigla Tabela Atual ou false
                'mysql_autoadd'     => false,
                'mysql_comment'     => false,
                'mysql_inside'      => false, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => false, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false, //permissao funcional necessaria para campo
                'linkextra'         => 'locais/localidades/Estados_Add', //0 ninguem, 1 admin, 2 todos 
                'edicao'            => Array(
                    'Nome'              => __('Estado'),
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => '',
                    'select'             => array(
                        'class'             => 'obrigatorio',
                        'infonulo'          => 'Escolha um Estado',
                    )
                )
            ),
            Array(
                'mysql_titulo'      => 'cidade',
                'mysql_tipovar'     => 'int', //varchar, int, 
                'mysql_tamanho'     => 11,
                'mysql_null'        => false,  // nulo ?
                'mysql_default'     => false, // valor padrao
                'mysql_primary'     => false,  // chave primaria
                'mysql_estrangeira' => 'SLC.id|SLC.nome|SLC.estado={estado}', // chave estrangeira     ligacao|apresentacao|condicao
                'form_change'       => 'U', // CHANGE PARA EXTRANGEIRAS -> Sigla Tabela Pai / Sigla Tabela Atual ou false
                'mysql_autoadd'     => false,
                'mysql_comment'     => false,
                'mysql_inside'      => false, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => false, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false, //permissao funcional necessaria para campo
                'linkextra'         => 'locais/localidades/Cidades_Add', //0 ninguem, 1 admin, 2 todos 
                'edicao'            => Array(
                    'Nome'              => __('Cidade'),
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => '',
                    'select'             => array(
                        'class'             => 'obrigatorio',
                        'infonulo'          => 'Escolha uma Cidade',
                    )
                )
            ),
            Array(
                'mysql_titulo'      => 'bairro',
                'mysql_tipovar'     => 'int', //varchar, int, 
                'mysql_tamanho'     => 11,
                'mysql_null'        => false,  // nulo ?
                'mysql_default'     => false, // valor padrao
                'mysql_primary'     => false,  // chave primaria
                'mysql_estrangeira' => 'SLB.id|SLB.nome|SLB.cidade={cidade}', // chave estrangeira     ligacao|apresentacao|condicao
                'mysql_autoadd'     => false,
                'mysql_comment'     => false,
                'mysql_inside'      => false, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => false, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false, //permissao funcional necessaria para campo
                'linkextra'         => 'locais/localidades/Bairros_Add', //0 ninguem, 1 admin, 2 todos 
                'edicao'            => Array(
                    'Nome'              => __('Bairro'),
                    'valor_padrao'      => false, //10639,
                    'readonly'          => false,
                    'aviso'             => '',
                    'select'             => array(
                        'class'             => 'obrigatorio',
                        'infonulo'          => 'Escolha um Bairro',
                    )
                ) 
            ),
            Array(
                'mysql_titulo'      => 'endereco',
                'mysql_tipovar'     => 'varchar', //varchar, int, 
                'mysql_tamanho'     => 200,
                'mysql_null'        => false,  // nulo ?
                'mysql_default'     => false, // valor padrao
                'mysql_primary'     => false,  // chave primaria
                'mysql_estrangeira' => false, // chave estrangeira     ligacao|apresentacao|condicao
                'mysql_autoadd'     => false,
                'mysql_comment'     => false,
                'mysql_inside'      => false, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => false, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false, //permissao funcional necessaria para campo
                'linkextra'         => '', //0 ninguem, 1 admin, 2 todos 
                'edicao'            => Array(
                    'Nome'              => __('Endereço'),
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
                'mysql_titulo'      => 'numero',
                'mysql_tipovar'     => 'varchar', //varchar, int, 
                'mysql_tamanho'     => 15,
                'mysql_null'        => false,  // nulo ?
                'mysql_default'     => false, // valor padrao
                'mysql_primary'     => false,  // chave primaria
                'mysql_estrangeira' => false, // chave estrangeira     ligacao|apresentacao|condicao
                'mysql_autoadd'     => false,
                'mysql_comment'     => false,
                'mysql_inside'      => false, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => false, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false, //permissao funcional necessaria para campo
                'linkextra'         => '', //0 ninguem, 1 admin, 2 todos 
                'edicao'            => Array(
                    'Nome'              => __('Número'),
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
            ),
            Array(
                'mysql_titulo'      => 'complemento',
                'mysql_tipovar'     => 'varchar', //varchar, int, 
                'mysql_tamanho'     => 15,
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
                    'Nome'              => __('Complemento'),
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
                'mysql_titulo'      => 'resp_empresa',
                'mysql_tipovar'     => 'varchar', //varchar, int, 
                'mysql_tamanho'     => 200,
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
                    'Nome'              => __('Responsável pela Empresa'),
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
                'mysql_titulo'      => 'entrega_cep',
                'mysql_tipovar'     => 'varchar', //varchar, int, 
                'mysql_tamanho'     => 200,
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
                    'Nome'              => __('Cep de Correspondência'),
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => '',
                    'change'            => '',
                    'formtipo'          => 'input',
                    'input'             => array(
                        'tipo'              => 'text',
                        'class'             => 'masc_cep'
                    )
                )
            ),
            Array(
                'mysql_titulo'      => 'entrega_pais',
                'mysql_tipovar'     => 'int', //varchar, int, 
                'mysql_tamanho'     => 11,
                'mysql_null'        => false,  // nulo ?
                'mysql_default'     => false, // valor padrao
                'mysql_primary'     => false,  // chave primaria
                'mysql_estrangeira' => 'SLP.id|SLP.nome', // chave estrangeira     ligacao|apresentacao|condicao
                'form_change'       => 'U', // CHANGE PARA EXTRANGEIRAS -> Sigla Tabela Pai / Sigla Tabela Atual ou false
                'mysql_autoadd'     => false,
                'mysql_comment'     => false,
                'mysql_inside'      => false, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => false, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false, //permissao funcional necessaria para campo 2 todos 
                'edicao'            => Array(
                    'Nome'              => __('Pais de Correspondência'),
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => ''
                ) 
            ),
            Array(
                'mysql_titulo'      => 'entrega_estado',
                'mysql_tipovar'     => 'int', //varchar, int, 
                'mysql_tamanho'     => 11,
                'mysql_null'        => false,  // nulo ?
                'mysql_default'     => false, // valor padrao
                'mysql_primary'     => false,  // chave primaria
                'mysql_estrangeira' => 'SLE.id|SLE.sigla|SLE.pais={entrega_pais}', // chave estrangeira     ligacao|apresentacao|condicao
                'form_change'       => 'U', // CHANGE PARA EXTRANGEIRAS -> Sigla Tabela Pai / Sigla Tabela Atual ou false
                'mysql_autoadd'     => false,
                'mysql_comment'     => false,
                'mysql_inside'      => false, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => false, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false, //permissao funcional necessaria para campo 2 todos 
                'edicao'            => Array(
                    'Nome'              => __('Estado de Correspondência'),
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => ''
                )
            ),
            Array(
                'mysql_titulo'      => 'entrega_cidade',
                'mysql_tipovar'     => 'int', //varchar, int, 
                'mysql_tamanho'     => 11,
                'mysql_null'        => false,  // nulo ?
                'mysql_default'     => false, // valor padrao
                'mysql_primary'     => false,  // chave primaria
                'mysql_estrangeira' => 'SLC.id|SLC.nome|SLC.estado={entrega_estado}', // chave estrangeira     ligacao|apresentacao|condicao
                'form_change'       => 'U', // CHANGE PARA EXTRANGEIRAS -> Sigla Tabela Pai / Sigla Tabela Atual ou false
                'mysql_autoadd'     => false,
                'mysql_comment'     => false,
                'mysql_inside'      => false, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => false, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false, //permissao funcional necessaria para campo 2 todos 
                'edicao'            => Array(
                    'Nome'              => __('Cidade de Correspondência'),
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => ''
                )
            ),
            Array(
                'mysql_titulo'      => 'entrega_bairro',
                'mysql_tipovar'     => 'int', //varchar, int, 
                'mysql_tamanho'     => 11,
                'mysql_null'        => false,  // nulo ?
                'mysql_default'     => false, // valor padrao
                'mysql_primary'     => false,  // chave primaria
                'mysql_estrangeira' => 'SLB.id|SLB.nome|SLB.cidade={entrega_cidade}', // chave estrangeira     ligacao|apresentacao|condicao
                'mysql_autoadd'     => false,
                'mysql_comment'     => false,
                'mysql_inside'      => false, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => false, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false, //permissao funcional necessaria para campo 2 todos 
                'edicao'            => Array(
                    'Nome'              => __('Bairro de Correspondência'),
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => ''
                ) 
            ),
            Array(
                'mysql_titulo'      => 'entrega_endereco',
                'mysql_tipovar'     => 'varchar', //varchar, int, 
                'mysql_tamanho'     => 200,
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
                    'Nome'              => __('Endereço de Correspondência'),
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
                'mysql_titulo'      => 'entrega_numero',
                'mysql_tipovar'     => 'varchar', //varchar, int, 
                'mysql_tamanho'     => 15,
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
                    'Nome'              => __('Número de Correspondência'),
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
            ),
            Array(
                'mysql_titulo'      => 'entrega_complemento',
                'mysql_tipovar'     => 'varchar', //varchar, int, 
                'mysql_tamanho'     => 15,
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
                    'Nome'              => __('Complemento da Correspondência'),
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
                'mysql_titulo'      => 'resp_fatura',
                'mysql_tipovar'     => 'varchar', //varchar, int, 
                'mysql_tamanho'     => 200,
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
                    'Nome'              => __('Responsável pela Fatura'),
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => '',
                    'formtipo'          => 'input',
                    'input'             => array(
                        'tipo'              => 'text',
                        'class'             => ''
                    )
                )
            )/*,
            Array(
                'mysql_titulo'      => 'banco',
                'mysql_tipovar'     => 'varchar', //varchar, int, 
                'mysql_tamanho'     => 200,
                'mysql_null'        => false,  // nulo ?
                'mysql_default'     => false, // valor padrao
                'mysql_primary'     => false,  // chave primaria
                'mysql_estrangeira' => 'FB.id|FB.nome', // chave estrangeira     ligacao|apresentacao|condicao
                'mysql_autoadd'     => false,
                'mysql_comment'     => false,
                'mysql_inside'      => false, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => false, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false, //permissao funcional necessaria para campo
                'linkextra'         => 'Financeiro/Banco/Bancos_Add', //0 ninguem, 1 admin, 2 todos 
                'edicao'            => Array(
                    'Nome'              => __('Banco'),
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => ''
                ) 
            )*/,
            Array(
                'mysql_titulo'      => 'banco',
                'mysql_tipovar'     => 'varchar', //varchar, int, 
                'mysql_tamanho'     => 200,
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
                    'Nome'              => __('Banco'),
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
                'mysql_titulo'      => 'agencia',
                'mysql_tipovar'     => 'varchar', //varchar, int, 
                'mysql_tamanho'     => 200,
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
                    'Nome'              => __('Agencia'),
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
                'mysql_titulo'      => 'conta',
                'mysql_tipovar'     => 'varchar', //varchar, int, 
                'mysql_tamanho'     => 200,
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
                    'Nome'              => __('Conta'),
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
                'mysql_titulo'      => 'data_admissao',
                'mysql_tipovar'     => 'varchar', //varchar, int, 
                'mysql_tamanho'     => 200,
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
                    'Nome'              => __('Data de Admissão'),
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
            ),
            Array(
                'mysql_titulo'      => 'data_demissao',
                'mysql_tipovar'     => 'varchar', //varchar, int, 
                'mysql_tamanho'     => 200,
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
                    'Nome'              => __('Data de Demissão'),
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
            ),
            Array(
                'mysql_titulo'      => 'vale_transporte',
                'mysql_tipovar'     => 'varchar', //varchar, int, 
                'mysql_tamanho'     => 200,
                'mysql_null'        => false,  // nulo ?
                'mysql_default'     => false, // valor padrao
                'mysql_primary'     => false,  // chave primaria
                'mysql_estrangeira' => false, // chave estrangeira     ligacao|apresentacao|condicao
                'mysql_autoadd'     => false,
                'mysql_comment'     => false,
                'mysql_inside'      => '\Framework\App\Sistema_Funcoes::Tranf_Real_Float({valor})', // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => '\Framework\App\Sistema_Funcoes::Tranf_Float_Real({valor})', // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false, //permissao funcional necessaria para campo 2 todos 
                'edicao'            => Array(
                    'Nome'              => __('Vale Transporte'),
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
            Array(
                'mysql_titulo'      => 'vale_refeicao',
                'mysql_tipovar'     => 'varchar', //varchar, int, 
                'mysql_tamanho'     => 200,
                'mysql_null'        => false,  // nulo ?
                'mysql_default'     => false, // valor padrao
                'mysql_primary'     => false,  // chave primaria
                'mysql_estrangeira' => false, // chave estrangeira     ligacao|apresentacao|condicao
                'mysql_autoadd'     => false,
                'mysql_comment'     => false,
                'mysql_inside'      => '\Framework\App\Sistema_Funcoes::Tranf_Real_Float({valor})', // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => '\Framework\App\Sistema_Funcoes::Tranf_Float_Real({valor})', // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false, //permissao funcional necessaria para campo 2 todos 
                'edicao'            => Array(
                    'Nome'              => __('Vale Refeição'),
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
            Array(
                'mysql_titulo'      => 'hora_entrada',
                'mysql_tipovar'     => 'varchar', //varchar, int, 
                'mysql_tamanho'     => 200,
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
                    'Nome'              => __('Hora da Entrada'),
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
                'mysql_titulo'      => 'hora_saida',
                'mysql_tipovar'     => 'varchar', //varchar, int, 
                'mysql_tamanho'     => 200,
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
                    'Nome'              => __('Hora da Saida'),
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
                'mysql_titulo'      => 'salariobase',
                'mysql_tipovar'     => 'varchar', //varchar, int, 
                'mysql_tamanho'     => 200,
                'mysql_null'        => false,  // nulo ?
                'mysql_default'     => false, // valor padrao
                'mysql_primary'     => false,  // chave primaria
                'mysql_estrangeira' => false, // chave estrangeira     ligacao|apresentacao|condicao
                'mysql_autoadd'     => false,
                'mysql_comment'     => false,
                'mysql_inside'      => '\Framework\App\Sistema_Funcoes::Tranf_Real_Float({valor})', // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => '\Framework\App\Sistema_Funcoes::Tranf_Float_Real({valor})', // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false, //permissao funcional necessaria para campo 2 todos 
                'edicao'            => Array(
                    'Nome'              => __('Salário Base'),
                    'Mascara'           => 'Real',
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
                'mysql_titulo'      => 'tipocontrato',
                'mysql_tipovar'     => 'varchar', //varchar, int, 
                'mysql_tamanho'     => 200,
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
                    'Nome'              => __('Tipo de Contrato'),
                    'valor_padrao'      => 1,
                    'readonly'          => false,
                    'aviso'             => '',
                    'formtipo'          => 'select',
                    'select'            => array(
                        'opcoes'            => array(
                            array(
                                'value'         =>  '1',
                                'nome'          => 'Funcionário Próprio'
                            ),
                            array(
                                'value'         =>  '0',
                                'nome'          => 'Funcionário Temporário'
                            ),
                        )
                    )
                )
            ),
            Array(
                'mysql_titulo'      => 'cnh',
                'mysql_tipovar'     => 'varchar', //varchar, int, 
                'mysql_tamanho'     => 200,
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
                    'Nome'              => __('Carteira de Motorista'),
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
                'mysql_titulo'      => 'cnh_valida',
                'mysql_tipovar'     => 'date', //varchar, int, 
                'mysql_tamanho'     => 10,
                'mysql_null'        => false,  // nulo ?
                'mysql_default'     => '0000-00-00', // valor padrao
                'mysql_primary'     => false,  // chave primaria
                'mysql_estrangeira' => false, // chave estrangeira     ligacao|apresentacao|condicao
                'mysql_autoadd'     => false,
                'mysql_comment'     => false,
                'mysql_inside'      => 'data_brasil_eua({valor})', // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => 'data_eua_brasil({valor})', // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false, //permissao funcional necessaria para campo 2 todos 
                'edicao'            => Array(
                    'Nome'              => __('Validade da Carteira'),
                    'Mascara'           => 'Data',
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => '',
                    'formtipo'          => 'input',
                    'validar'           => 'Control_Layoult_Valida_Data',
                    'form_escondido'    => true,    // Vai aparecer, quando trocar select
                    'input'             => array(
                        'tipo'              => 'text',
                        'class'             => ''
                    )
                )
            ),
            Array(
                'mysql_titulo'      => 'site',
                'mysql_tipovar'     => 'varchar', //varchar, int, 
                'mysql_tamanho'     => 200,
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
                    'Nome'              => __('Site'),
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => '',
                    'valida'            => 'Control_Layoult_Valida_URL',
                    'formtipo'          => 'input',
                    'input'             => array(
                        'tipo'              => 'text',
                        'class'             => ''
                    )
                )
            ),
            Array(
                'mysql_titulo'      => 'login',
                'mysql_tipovar'     => 'varchar', //varchar, int, 
                'mysql_tamanho'     => 200,
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
                    'Nome'              => __('Login'),
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => __('Se logará com ele.'),
                    'formtipo'          => 'input',
                    'input'             => array(
                        'tipo'              => 'text',
                        'class'             => 'obrigatorio'
                    )
                )
            ),
            Array(
                'mysql_titulo'      => 'senha',
                'mysql_tipovar'     => 'varchar', //varchar, int, 
                'mysql_tamanho'     => 80,
                'mysql_null'        => true,  // nulo ?
                'mysql_default'     => \Framework\App\Sistema_Funcoes::Form_Senha_Blindar('123456',true),
                'mysql_primary'     => false,  // chave primaria
                'mysql_estrangeira' => false, // chave estrangeira     ligacao|apresentacao|condicao
                'mysql_autoadd'     => false,
                'mysql_comment'     => false,
                'mysql_inside'      => 'Framework\App\Sistema_Funcoes::Form_Senha_Blindar({valor},true)', // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => false, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false, //permissao funcional necessaria para campo 2 todos 
                'edicao'            => Array(
                    'Nome'              => __('Senha'),
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => __('Minimo 6 caracteres'),
                    'formtipo'          => 'input',
                    'input'             => array(
                        'tipo'              => 'password',
                        'class'             => ''
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
                'edicao'            => Array(
                    'Nome'              => __('Upload de Foto'),
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => __('Imagens somente do tipo GIF ou JPG'),
                    'aviso_titulo'      => 'Importante',
                    'formtipo'          => 'upload',
                    'upload'            => array(
                        'tipo'              => 'Imagem',
                        'class'             => ''
                    )
                )
            ),
            Array(
                'mysql_titulo'      => 'emergencia',
                'mysql_tipovar'     => 'longtext', //varchar, int, 
                'mysql_tamanho'     => 1000,
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
                    'Nome'              => __('Em caso de Emergência'),
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => '',
                    'formtipo'          =>'textarea',
                    'textarea'          => array(
                        'tipo'              => 'text',
                        'class'             => ''
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
            ),
            Array(
                'mysql_titulo'      => 'selo_liberar',
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
                    'Nome'              => __('Não Liberar Selo?'),
                    'valor_padrao'      => false,
                    'readonly'          => false,
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
                            ),
                        )
                    )
                )
            ),
            Array(
                'mysql_titulo'      => 'precoespecial',
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
                'edicao'            => Array(
                    'Nome'              => __('Tipo de Preço'),
                    'valor_padrao'      => 0,
                    'readonly'          => false,
                    'aviso'             => '',
                    'formtipo'          => 'select',
                    'select'            => array(
                        'opcoes'            => array(
                            array(
                                'value'         =>  '1',
                                'nome'          => 'Preço Especial'
                            ),
                            array(
                                'value'         =>  '0',
                                'nome'          => 'Preço Padrão'
                            ),
                        )
                    )
                )
            ),
            Array(
                'mysql_titulo'      => 'foto_cnh',
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
                'edicao'            => Array(
                    'Nome'              => __('Foto da CNH'),
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => __('Imagens somente do tipo GIF ou JPG'),
                    'aviso_titulo'      => 'Importante',
                    'formtipo'          => 'upload',
                    'upload'            => array(
                        'tipo'              => 'Imagem',
                        'class'             => ''
                    )
                )
            ),
            Array(
                'mysql_titulo'      => 'foto_cnh_apv',
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
                'edicao'            => Array(
                    'Nome'              => __('Foto da CNH'),
                    'valor_padrao'      => 0,
                    'readonly'          => false,
                    'aviso'             => '',
                    'formtipo'          => 'select',
                    'select'            => array(
                        'opcoes'            => array(
                            array(
                                'value'         =>  '1',
                                'nome'          => 'Aprovado'
                            ),
                            array(
                                'value'         =>  '0',
                                'nome'          => 'Não Aprovado'
                            ),
                        )
                    )
                )
            ),
            Array(
                'mysql_titulo'      => 'foto_res',
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
                'edicao'            => Array(
                    'Nome'              => __('Foto da Residência'),
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => __('Imagens somente do tipo GIF ou JPG'),
                    'aviso_titulo'      => 'Importante',
                    'formtipo'          => 'upload',
                    'upload'            => array(
                        'tipo'              => 'Imagem',
                        'class'             => ''
                    )
                )
            ),
            Array(
                'mysql_titulo'      => 'foto_res_apv',
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
                'edicao'            => Array(
                    'Nome'              => __('Foto da Residência'),
                    'valor_padrao'      => 0,
                    'readonly'          => false,
                    'aviso'             => '',
                    'formtipo'          => 'select',
                    'select'            => array(
                        'opcoes'            => array(
                            array(
                                'value'         =>  '1',
                                'nome'          => 'Aprovado'
                            ),
                            array(
                                'value'         =>  '0',
                                'nome'          => 'Não Aprovado'
                            ),
                        )
                    )
                )
            ),
            Array(
                'mysql_titulo'      => 'ativado',
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
                'edicao'            => Array(
                    'Nome'              => __('Status'),
                    'valor_padrao'      => 1,
                    'readonly'          => false,
                    'aviso'             => '',
                    'formtipo'          => 'select',
                    'select'            => array(
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
                'TabelaLinkada'     => Array(
                    'Pai'               => 'U', // TABELA que vai manipular a conexao
                    'Tabela'            => 'UP', // TABELA de LINK A SER CONECTADA
                    'valor_padrao'      => false, // ID DO PAI
                    'Nome'              => __('Permissões do Usuário'), // Nome no FOrmulario
                    'Class'             => '', // Classe no formulario
                    'aviso'             => '', // Aviso no formulario
                    'formtipo'          => 'BoleanoMultiplo',  // Tipo de formulario
                    'BoleanoMultiplo'   => Array(
                        'campoid'           => 'chave', // CAmpo de conexao
                        'campomostrar'      => 'nome', // Campo mostrar
                        'Col1'              => 'Telas a Permitir', // Nome da 1 Coluna (Nao Selecionada)
                        'Col2'              => 'Telas Permitidas', // Nome da 2 Coluna (Selecionadas)
                        'Valor'             => 'valor'
                    ), // Campo Boleano da tabela LINK, caso false apaga os que nao forem puxados
                )
            )
        );
    }
}
?>
