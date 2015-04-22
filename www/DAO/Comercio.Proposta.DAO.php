<?php
final Class Comercio_Proposta_DAO extends Framework\App\Dao 
{
    protected $id;
    protected $propostatipo;
    protected $cliente;
    protected $cuidados;
    protected $referencia;
    protected $telefone;
    protected $comissao;
    protected $imposto;
    protected $valor_extra;
    protected $valor_fixo;
    protected $pagar_lucro;
    protected $pagar_desconto;
    protected $forma_pagar;
    protected $condicao_pagar;
    protected $validade;
    protected $status;
    protected $valor;
    protected $obs;
    protected static $objetocarregado     = false;     protected static $mysql_colunas       = false;     protected static $mysql_outside       = Array();     protected static $mysql_inside        = Array(); public function __construct() {  parent::__construct(); } public static function Get_Nome(){
        return MYSQL_COMERCIO_PROPOSTA;
    }
    /**
     * Fornece Permissão de Copia da tabela
     * @return string
     */
    public static function Permissao_Copia(){
        return false;
    }
    public static function Get_Sigla(){
        return 'CPRO';
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
                'linkextra'          => '' ,//0 ninguem, 1 admin, 2 todos 
            ),
            Array(
                'mysql_titulo'      => 'propostatipo',
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
                'linkextra'          => '', //0 ninguem, 1 admin, 2 todos 
                'edicao'            => Array(
                    'Nome'              => 'Tipo de Proposta',
                    'valor_padrao'      => 0,
                    'readonly'          => false,
                    'aviso'             => '',
                    'formtipo'          => 'select',
                    'change'            => 'Control_Layoult_Form_Campos_Trocar(\'#referencia,#telefone,.servico,.servicotipo,.btu,.produto\')',
                    'select'            => array(
                        'class'             => 'obrigatorio',
                        'infonulo'          => 'Escolha o tipo de proposta',
                        'opcoes'            => array(
                            array(
                                'value'         =>  '1',
                                'nome'          => 'Instalação'
                            ),
                            array(
                                'value'         =>  '0',
                                'nome'          => 'Serviço'
                            ),
                        )
                    )
                )
            ),Array(
                'mysql_titulo'      => 'cliente',
                'mysql_tipovar'     => 'int', //varchar, int, 
                'mysql_tamanho'     => 11,
                'mysql_null'        => true,
                'mysql_default'     => false,
                'mysql_primary'     => false,
                'mysql_estrangeira' => 'U.id|U.nome-U.razao_social|U.ativado=1-EXTB.categoria='.CFG_TEC_CAT_ID_CLIENTES, // chave estrangeira
                'mysql_autoadd'     => false,
                'mysql_comment'     => false,
                'mysql_inside'      => false, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => false, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false, //permissao funcional necessaria para campo 2 todos 
                'linkextra'          => '', // //0 ninguem, 1 admin, 2 todos 
                'edicao'            => Array(
                    'Nome'              => 'Cliente',
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => 'Minimo 3 caracteres',
                    'formtipo'          => 'input',
                    'input'             => array(
                        'tipo'              => 'text',
                        'class'             => 'obrigatorio'
                    )
                )
            ),
            Array(
                'mysql_titulo'      => 'cuidados',
                'mysql_tipovar'     => 'int', //varchar, int, 
                'mysql_tamanho'     => 11,
                'mysql_null'        => true,  // nulo ?
                'mysql_default'     => 0, // valor padrao
                'mysql_primary'     => false,  // chave primaria
                'mysql_estrangeira' => 'U.id|U.nome-U.razao_social|U.ativado=1-U.grupo='.CFG_TEC_IDVENDEDOR, // chave estrangeira     ligacao|apresentacao|condicao
                'mysql_autoadd'     => false,
                'mysql_comment'     => false,
                'mysql_inside'      => false, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => false, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false, //permissao funcional necessaria para campo 2 todos 
                'linkextra'          => false, //'usuario/Admin/Usuarios_Add/cliente',
                'edicao'            => Array(
                    'Nome'              => 'Vendedor',
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => 'obrigatorio',
                    'formtipo'          => 'select',
                    'select'             => array(
                        'class'             => 'obrigatorio',
                        'infonulo'          => 'Escolha um Vendedor',
                    )
                )
            ),
            Array(
                'mysql_titulo'      => 'referencia',
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
                'linkextra'          => '', //0 ninguem, 1 admin, 2 todos 
                'edicao'            => Array(
                    'Nome'              => 'Referência',
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => '',
                    'formtipo'          => 'input',
                    'form_escondido'    => 'apagar', // Apagar = Vai Apagar Após a troca
                    //'form_escondido'    => true,    // Vai aparecer, quando trocar select
                    'input'             => array(
                        'tipo'              => 'text',
                        'class'             => 'obrigatorio'
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
                'linkextra'          => '', //0 ninguem, 1 admin, 2 todos 
                'edicao'            => Array(
                    'Nome'              => 'Telefone',
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => '',
                    'formtipo'          => 'input',
                    'form_escondido'    => 'apagar', // Apagar = Vai Apagar Após a troca
                    //'form_escondido'    => true,    // Vai aparecer, quando trocar select
                    'input'             => array(
                        'tipo'              => 'text',
                        'class'             => 'obrigatorio masc_fone'
                    )
                )
            ),
            
            /**
             * Instacao
             */
            Array(
                'TabelaLinkada'     => Array(
                    'Pai'               => 'CPRO', // TABELA que vai manipular a conexao
                    'Tabela'            => 'CPROSI', // TABELA de LINK A SER CONECTADA
                    'valor_padrao'      => false, // id do pai
                    'Nome'              => 'Btus', // Nome no FOrmulario
                    'Class'             => 'obrigatorio', // Classe no formulario
                    'aviso'             => '', // Aviso no formulario
                    'formtipo'          => 'SelectMultiplo',  // Tipo de formulario
                    'SelectMultiplo'   => Array(
                        'Extrangeira'       => 'CSB.id|CSB.nome',
                        'Linkar'            => 'proposta', // CAmpo a ser encaixado id do pai
                        'Linkado'           => 'btu',// CAmpo a ser encaixado id do link
                        'Campos'            => Array(
                            'distancia','suporte','tipocondensadora','infra','tipoevaporadora','tipodreno','obs'
                        ),
                        'form_escondido'    => true,    // Vai aparecer, quando trocar select
                        'infonulo'          => 'Escolha pelo menos um Btu para Instalar',
                      'linkextra'         => false
                    ), // Campo Boleano da tabela LINK, caso false apaga os que nao forem puxados
                )
            ),
            Array(
                'TabelaLinkada'     => Array(
                    'Pai'               => 'CPRO', // TABELA que vai manipular a conexao
                    'Tabela'            => 'CPROP', // TABELA de LINK A SER CONECTADA
                    'valor_padrao'      => false, // id do pai
                    'Nome'              => 'Produtos Vendidos', // Nome no FOrmulario
                    'Class'             => '', // Classe no formulario
                    'aviso'             => '', // Aviso no formulario
                    'formtipo'          => 'SelectMultiplo',  // Tipo de formulario
                    'SelectMultiplo'   => Array(
                        'Extrangeira'       => 'CP.id|CP.nome',
                        'Linkar'            => 'proposta', // CAmpo a ser encaixado id do pai
                        'Linkado'           => 'produto',// CAmpo a ser encaixado id do link
                        'Campos'            => Array(
                            'prod_qnt'
                        ),
                        'form_escondido'    => true,    // Vai aparecer, quando trocar select
                        'infonulo'          => 'Escolha os Produtos Vendidos na Proposta',
                      'linkextra'         => false
                    ), // Campo Boleano da tabela LINK, caso false apaga os que nao forem puxados
                )
            ),
            
            /**
             * servicos
             */
            Array(
                'TabelaLinkada'     => Array(
                    'Pai'               => 'CPRO', // TABELA que vai manipular a conexao
                    'Tabela'            => 'CPROS', // TABELA de LINK A SER CONECTADA
                    'valor_padrao'      => false, // id do pai
                    'Nome'              => 'Serviço', // Nome no FOrmulario
                    'Class'             => 'obrigatorio', // Classe no formulario
                    'aviso'             => '', // Aviso no formulario
                    'formtipo'          => 'SelectMultiplo',  // Tipo de formulario
                    'SelectMultiplo'   => Array(
                        'Extrangeira'       => 'CSS.id|CSS.nome',
                        'Linkar'            => 'proposta', // CAmpo a ser encaixado id do pai
                        'Linkado'           => 'servico',// CAmpo a ser encaixado id do link
                        'Campos'            => Array(
                            'qnt'
                        ),
                        'form_escondido'    => 'apagar', // Apagar = Vai Apagar Após a troca
                        'infonulo'          => 'Escolha pelo menos um Serviço',
                      'linkextra'         => false
                    ), // Campo Boleano da tabela LINK, caso false apaga os que nao forem puxados
                )
            ),
            //Tipo de Serviço
            Array(
                'TabelaLinkada'     => Array(
                    'Pai'               => 'CPRO', // TABELA que vai manipular a conexao
                    'Tabela'            => 'CPROST', // TABELA de LINK A SER CONECTADA
                    'valor_padrao'      => false, // id do pai
                    'Nome'              => 'Serviços', // Nome no FOrmulario
                    'Class'             => 'obrigatorio', // Classe no formulario
                    'aviso'             => '', // Aviso no formulario
                    'formtipo'          => 'SelectMultiplo',  // Tipo de formulario
                    'SelectMultiplo'   => Array(
                        'Extrangeira'       => 'CSST.id|CSST.nome',
                        'Linkar'            => 'proposta', // CAmpo a ser encaixado id do pai
                        'Linkado'           => 'servicotipo',// CAmpo a ser encaixado id do link
                        'Campos'            => Array(
                            false //'diarias_qnt','diarias_valor'
                        ),
                        'form_escondido'    => 'apagar', // Apagar = Vai Apagar Após a troca
                        'infonulo'          => 'Escolha pelo menos um Serviço',
                        'linkextra'         => '',//comercio_servicos/ServicoTipo/Servico_Tipo_Add'
                    ), // Campo Boleano da tabela LINK, caso false apaga os que nao forem puxados
                )
            ),
            // MAO DE OBRA DOS FUNCIONARIOS
            Array(
                'TabelaLinkada'     => Array(
                    'Pai'               => 'CPRO', // TABELA que vai manipular a conexao
                    'Tabela'            => 'CPROM', // TABELA de LINK A SER CONECTADA
                    'valor_padrao'      => false, // id do pai
                    'Nome'              => 'Mão de Obra', // Nome no FOrmulario
                    'Class'             => 'obrigatorio', // Classe no formulario
                    'aviso'             => '', // Aviso no formulario
                    'formtipo'          => 'SelectMultiplo',  // Tipo de formulario
                    'SelectMultiplo'   => Array(
                        'Extrangeira'       => 'SG.id|SG.nome',
                        'Linkar'            => 'proposta', // CAmpo a ser encaixado id do pai
                        'Linkado'           => 'grupo',// CAmpo a ser encaixado id do link
                        'Campos'            => Array(
                            'maodeobra_qnt','maodeobra_dias','maodeobra_diaria','maodeobra_depreciacao','maodeobra_passagem','maodeobra_alimentacao'
                        ),
                        'form_escondido'    => 'apagar', // Apagar = Vai Apagar Após a troca
                        'infonulo'          => 'Escolha pelo menos um Tipo de Serviço',
                      'linkextra'         => '',//comercio_servicos/ServicoTipo/Servico_Tipo_Add'
                    ), // Campo Boleano da tabela LINK, caso false apaga os que nao forem puxados
                )
            ),Array(
                'mysql_titulo'      => 'comissao',
                'mysql_tipovar'     => 'float', //varchar, int, 
                'mysql_tamanho'     => 8,
                'mysql_null'        => true,
                'mysql_default'     => false,
                'mysql_primary'     => false,
                'mysql_estrangeira' => false, // chave estrangeira
                'mysql_autoadd'     => false,
                'mysql_comment'     => false,
                'mysql_inside'      => '\Framework\App\Sistema_Funcoes::Tranf_Porc_Float({valor})', // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => '\Framework\App\Sistema_Funcoes::Tranf_Float_Porc({valor})', // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false, //permissao funcional necessaria para campo 2 todos 
                'linkextra'          => '', // //0 ninguem, 1 admin, 2 todos 
                'edicao'            => Array(
                    'Nome'              => 'Comissão',
                    'Mascara'           => 'Porc',
                    'valor_padrao'      => \Framework\App\Sistema_Funcoes::Tranf_Float_Porc(\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('comercio_Proposta_Comissao')),
                    'readonly'          => false,
                    'aviso'             => 'Minimo 3 caracteres',
                    'formtipo'          => 'input',
                    'input'             => array(
                        'tipo'              => 'text',
                        'class'             => 'obrigatorio'
                    )
                )
            ),Array(
                'mysql_titulo'      => 'imposto',
                'mysql_tipovar'     => 'float', //varchar, int, 
                'mysql_tamanho'     => 8,
                'mysql_null'        => true,
                'mysql_default'     => false,
                'mysql_primary'     => false,
                'mysql_estrangeira' => false, // chave estrangeira
                'mysql_autoadd'     => false,
                'mysql_comment'     => false,
                'mysql_inside'      => '\Framework\App\Sistema_Funcoes::Tranf_Porc_Float({valor})', // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => '\Framework\App\Sistema_Funcoes::Tranf_Float_Porc({valor})', // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false, //permissao funcional necessaria para campo 2 todos 
                'linkextra'          => '', // //0 ninguem, 1 admin, 2 todos 
                'edicao'            => Array(
                    'Nome'              => 'Porcentagem de Imposto',
                    'Mascara'           => 'Porc',
                    'valor_padrao'      => \Framework\App\Sistema_Funcoes::Tranf_Float_Porc(\Framework\App\Acl::Sistema_Modulos_Configs_Funcional('comercio_Propostas_Imposto')),
                    'readonly'          => false,
                    'aviso'             => 'Minimo 3 caracteres',
                    'formtipo'          => 'input',
                    'input'             => array(
                        'tipo'              => 'text',
                        'class'             => 'obrigatorio'
                    )
                )
            ),
            Array(
                'mysql_titulo'      => 'valor_extra',
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
                    'Nome'              => 'Gasto Extra',
                    'Mascara'           => 'Real',
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => 'Somente Números',
                    'formtipo'          => 'input',
                    'input'             => array(
                        'tipo'              => 'text',
                        'class'             => 'obrigatorio'
                    )
                )
            ),Array(
                'mysql_titulo'      => 'pagar_lucro',
                'mysql_tipovar'     => 'float', //varchar, int, 
                'mysql_tamanho'     => 8,
                'mysql_null'        => true,
                'mysql_default'     => false,
                'mysql_primary'     => false,
                'mysql_estrangeira' => false, // chave estrangeira
                'mysql_autoadd'     => false,
                'mysql_comment'     => false,
                'mysql_inside'      => '\Framework\App\Sistema_Funcoes::Tranf_Porc_Float({valor})', // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => '\Framework\App\Sistema_Funcoes::Tranf_Float_Porc({valor})', // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false, //permissao funcional necessaria para campo 2 todos 
                'linkextra'          => '', // //0 ninguem, 1 admin, 2 todos 
                'edicao'            => Array(
                    'Nome'              => 'Porcentagem de Lucro',
                    'Mascara'           => 'Porc',
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => 'Minimo 3 caracteres',
                    'formtipo'          => 'input',
                    'input'             => array(
                        'tipo'              => 'text',
                        'class'             => 'obrigatorio'
                    )
                )
            ),Array(
                'mysql_titulo'      => 'pagar_desconto',
                'mysql_tipovar'     => 'float', //varchar, int, 
                'mysql_tamanho'     => 8,
                'mysql_null'        => true,
                'mysql_default'     => false,
                'mysql_primary'     => false,
                'mysql_estrangeira' => false, // chave estrangeira
                'mysql_autoadd'     => false,
                'mysql_comment'     => false,
                'mysql_inside'      => '\Framework\App\Sistema_Funcoes::Tranf_Porc_Float({valor})', // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => '\Framework\App\Sistema_Funcoes::Tranf_Float_Porc({valor})', // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false, //permissao funcional necessaria para campo 2 todos 
                'linkextra'          => '', // //0 ninguem, 1 admin, 2 todos 
                'edicao'            => Array(
                    'Nome'              => 'Porcentagem de Desconto',
                    'Mascara'           => 'Porc',
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => 'Minimo 3 caracteres',
                    'formtipo'          => 'input',
                    'input'             => array(
                        'tipo'              => 'text',
                        'class'             => 'obrigatorio'
                    )
                )
            ),
            // Calcula Sózinho
            Array(
                'mysql_titulo'      => 'valor_fixo',
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
                    'Nome'              => 'Valor Final',
                    'Mascara'           => 'Real',
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => 'Somente Números',
                    'formtipo'          => 'input',
                    'input'             => array(
                        'tipo'              => 'text',
                        'class'             => 'obrigatorio'
                    )
                )
            ),
            // FORMA DE PAGAMENTO
            Array(
                'mysql_titulo'      => 'forma_pagar',
                'mysql_tipovar'     => 'int', //varchar, int, 
                'mysql_tamanho'     => 11,
                'mysql_null'        => true,  // nulo ?
                'mysql_default'     => 0, // valor padrao
                'mysql_primary'     => false,  // chave primaria
                'mysql_estrangeira' => 'FPF.id|FPF.nome', // chave estrangeira     ligacao|apresentacao|condicao
                'form_change'       => 'CPRO', // CHANGE PARA EXTRANGEIRAS -> Sigla Tabela Pai / Sigla Tabela Atual ou false
                'mysql_autoadd'     => false,
                'mysql_comment'     => false,
                'mysql_inside'      => false, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => false, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false, //permissao funcional necessaria para campo 2 todos 
                'linkextra'          => 'Financeiro/Pagamento/Formas_Add/', //0 ninguem, 1 admin, 2 todos 
                'edicao'            => Array(
                    'Nome'              => 'Forma de Pagamento',
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => '',
                    'formtipo'          => 'select',
                    'select'             => array(
                        'class'             => 'obrigatorio',
                        'infonulo'          => 'Escolha uma Forma de Pagamento',
                    )
                )
            ),
            Array(
                'mysql_titulo'      => 'condicao_pagar',
                'mysql_tipovar'     => 'int', //varchar, int, 
                'mysql_tamanho'     => 11,
                'mysql_null'        => true,  // nulo ?
                'mysql_default'     => 0, // valor padrao
                'mysql_primary'     => false,  // chave primaria
                'mysql_estrangeira' => 'FPFC.id|FPFC.nome|FPFC.forma_pagar={forma_pagar}', // chave estrangeira     ligacao|apresentacao|condicao
                'mysql_autoadd'     => false,
                'mysql_comment'     => false,
                'mysql_inside'      => false, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => false, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false, //permissao funcional necessaria para campo 2 todos 
                'linkextra'          => 'Financeiro/Pagamento/Condicoes_Add/', //0 ninguem, 1 admin, 2 todos 
                'edicao'            => Array(
                    'Nome'              => 'Condição de Pagamento',
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => '',
                    'formtipo'          => 'select',
                    'select'             => array(
                        'class'             => 'obrigatorio',
                        'infonulo'          => 'Escolha uma Condição de Pagamento',
                    )
                )
            ),Array(
                'mysql_titulo'      => 'validade',
                'mysql_tipovar'     => 'date', //varchar, int, 
                'mysql_tamanho'     => 10,
                'mysql_null'        => true,
                'mysql_default'     => '0000-00-00', // valor padrao
                'mysql_primary'     => false,
                'mysql_estrangeira' => false, // chave estrangeira
                'mysql_autoadd'     => false,
                'mysql_comment'     => false,
                'mysql_inside'      => 'data_brasil_eua({valor})', // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => 'data_eua_brasil({valor})', // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false, //permissao funcional necessaria para campo 2 todos 
                'linkextra'          => '', // //0 ninguem, 1 admin, 2 todos 
                'edicao'            => Array(
                    'Nome'              => 'Validade da Proposta',
                    'Mascara'           => 'Data',
                    'valor_padrao'      => false,
                    'readonly'          => false,
                    'aviso'             => '',
                    'formtipo'          => 'input',
                    'validar'           => 'Control_Layoult_Valida_Data',
                    'input'             => array(
                        'tipo'              => 'text',
                        'class'             => 'obrigatorio'
                    )
                )
            ),
            
            
            
            // Os, Checklist
            Array(
                'TabelaLinkada'     => Array(
                    'Pai'               => 'CPRO', // TABELA que vai manipular a conexao
                    'Tabela'            => 'CPROC', // TABELA de LINK A SER CONECTADA
                    'valor_padrao'      => false, // id do pai
                    'Nome'              => 'Checklist', // Nome no FOrmulario
                    'Class'             => '', // Classe no formulario
                    'aviso'             => '', // Aviso no formulario
                    'formtipo'          => 'SelectMultiplo',  // Tipo de formulario
                    'SelectMultiplo'   => Array(
                        'Extrangeira'       => 'CC.id|CC.nome|CC.status=1',
                        'Linkar'            => 'proposta', // CAmpo a ser encaixado id do pai
                        'Linkado'           => 'checklist',// CAmpo a ser encaixado id do link
                        'Campos'            => false,
                        'infonulo'          => 'Escolha pelo menos um Checklist',
                      'linkextra'         => false
                    ), // Campo Boleano da tabela LINK, caso false apaga os que nao forem puxados
                )
            ),
            
            // Os, FUncionarios
            Array(
                'TabelaLinkada'     => Array(
                    'Pai'               => 'CPRO', // TABELA que vai manipular a conexao
                    'Tabela'            => 'CPROF', // TABELA de LINK A SER CONECTADA
                    'valor_padrao'      => false, // id do pai
                    'Nome'              => 'Funcionários', // Nome no FOrmulario
                    'Class'             => 'obrigatorio', // Classe no formulario
                    'aviso'             => '', // Aviso no formulario
                    'formtipo'          => 'SelectMultiplo',  // Tipo de formulario
                    'SelectMultiplo'   => Array(
                        'Extrangeira'       => 'U.id|U.nome-U.razao_social|EXTB.categoria='.CFG_TEC_CAT_ID_FUNCIONARIOS,
                        'Linkar'            => 'proposta', // CAmpo a ser encaixado id do pai
                        'Linkado'           => 'funcionario',// CAmpo a ser encaixado id do link
                        'Campos'            => Array(
                            'dias'
                        ),
                        'infonulo'          => 'Escolha pelo menos um Funcionário',
                      'linkextra'         => false
                    ), // Campo Boleano da tabela LINK, caso false apaga os que nao forem puxados
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
                                'value'         =>  '4',
                                'nome'          => 'Recusada'
                            ),
                            /*array(
                                'value'         =>  '3',
                                'nome'          => 'Finalizada'
                            ),
                            array(
                                'value'         =>  '2',
                                'nome'          => 'Aprovada em Execução'
                            ),*/
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
            // Calcula Sózinho
            Array(
                'mysql_titulo'      => 'valor',
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
                    'Nome'              => 'Observação',
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
