<?php
// Principais
if(!defined('SISTEMA_DEBUG')){
    define('SISTEMA_DEBUG',        false);
}
if(!defined('SISTEMA_SERVIDORES')){
    define('SISTEMA_SERVIDORES',        false); // SE é central
}
if(!defined('SISTEMA_DEDICADO')){
    define('SISTEMA_DEDICADO',        false); // SE esta em um dedicado
}
if(!defined('SISTEMA_CACHE_PAGINAS')){
    define('SISTEMA_CACHE_PAGINAS',        false);
}

// RESTRITO AO SISTEMA
if(!defined('SISTEMA_CFG_VERSION')){
    define('SISTEMA_CFG_VERSION',        3.0); // 
}


// DINAMICA DO SISTEMA
if(!defined('SISTEMA_EXPORTAR_PDF')){
    define('SISTEMA_EXPORTAR_PDF',        false); // 
}
if(!defined('SISTEMA_EXPORTAR_EXCEL')){
    define('SISTEMA_EXPORTAR_EXCEL',        true); // 
}



// Linguagem Do Sistema
if(!defined('SISTEMA_LINGUAGEM')){
    define('SISTEMA_LINGUAGEM',        'ptBR'); 
}
// Modulo, Submodulo, e Metodo da Pagina Inicial
if(!defined('DEFAULT_MODULO')){
    define('DEFAULT_MODULO',        '_Sistema');
}if(!defined('DEFAULT_SUBMODULO')){
    define('DEFAULT_SUBMODULO',     'Principal');
}if(!defined('DEFAULT_METODO')){
    define('DEFAULT_METODO',        'Home');
}

// Configuração do Teclado
if(!defined('CONFIG_PADRAO_TECLADO')){
    define('CONFIG_PADRAO_TECLADO', 'UTF-8'); //ISO-8859-1
}
// BANCO DE DADOS
if(!defined('SQL_MAIUSCULO')){
    define('SQL_MAIUSCULO', false);
}
// CONFIGS DEBUG
if(!defined('SRV_NAME_SQL')){
    define('SRV_NAME_SQL', SRV_NAME);
}

// EMAIL
if(!defined('SIS_EMAIL_SMTP_HOST')){
    define('SIS_EMAIL_SMTP_HOST'            , 'mail.redialsolution.com.br');
}
if(!defined('SIS_EMAIL_SMTP_USER')){
    define('SIS_EMAIL_SMTP_USER'            , 'formail@redialsolution.com.br');
}
if(!defined('SIS_EMAIL_SMTP_SENHA')){
    define('SIS_EMAIL_SMTP_SENHA'           , 'rds123');
}
if(!defined('SISTEMA_EMAIL')){
    define('SISTEMA_EMAIL'                  , 'contato@ricardosierra.com.br');
}
if(!defined('SISTEMA_EMAIL_RECEBER')){
    define('SISTEMA_EMAIL_RECEBER'          , 'sierra.csi@gmail.com');
}
// Recebe os Erros do Sistema
if(!defined('SISTEMA_EMAIL_ADMINISTRADOR')){
    define('SISTEMA_EMAIL_ADMINISTRADOR'          , 'sierra.csi@gmail.com');
}



if(!defined('ROOT')){
    define('ROOT', ROOT_PADRAO);
}
    

// Configs TEMAS
if(!defined('TEMA_LOGIN')){
    // Separa tela de login ?
    define('TEMA_LOGIN', true);
}if(!defined('TEMA_PADRAO')){
    define('TEMA_PADRAO', 'metrolab');
}if(!defined('TEMA_COLOR')){
    define('TEMA_COLOR', 'blue');
}if(!defined('TEMA_LOGO')){
    define('TEMA_LOGO', 'png');
}if(!defined('TEMA_BUSCAR')){
    define('TEMA_BUSCAR', true);
}


// Session
if(!defined('SESSION_ADMIN_LOG')){
    define('SESSION_ADMIN_LOG',     'cliente_login');
}
if(!defined('SESSION_ADMIN_SENHA')){
    define('SESSION_ADMIN_SENHA',   'cliente_senha');
}
if(!defined('SESSION_ADMIN_ID')){
    define('SESSION_ADMIN_ID',      'cliente_id');
}


// LAYOULT PERSONALIZACAO
if(!defined('CFG_LP_LOGINCOR1')){
    define('CFG_LP_LOGINCOR1',      'red');
}if(!defined('CFG_LP_LOGINCOR2')){
    define('CFG_LP_LOGINCOR2',      'green');
}if(!defined('CFG_LP_LOGINCOR3')){
    define('CFG_LP_LOGINCOR3',      'yellow');
}if(!defined('CFG_LP_LOGINCOR4')){
    define('CFG_LP_LOGINCOR4',      'terques');
}

// Configuracoes Tecnicas
if(!defined('CFG_TEC_IDNEWSLETTER')){
    define('CFG_TEC_IDNEWSLETTER'       ,        6);
}
if(!defined('CFG_TEC_IDFUNCIONARIO')){
    define('CFG_TEC_IDFUNCIONARIO'      ,        5);
}
if(!defined('CFG_TEC_IDCLIENTE')){
    define('CFG_TEC_IDCLIENTE'          ,        4);
}
if(!defined('CFG_TEC_IDADMIN')){
    define('CFG_TEC_IDADMIN'            ,        2);
}
if(!defined('CFG_TEC_IDADMINDEUS')){
    define('CFG_TEC_IDADMINDEUS'        ,        1);
}
if(!defined('CFG_TEC_IDVENDEDOR')){
    define('CFG_TEC_IDVENDEDOR'        ,        7);
}
// CATEGORIAS
if(!defined('CFG_TEC_CAT_ID_ADMIN')){
    define('CFG_TEC_CAT_ID_ADMIN'        ,        1); // categoria gerais
}
if(!defined('CFG_TEC_CAT_ID_CLIENTES')){
    define('CFG_TEC_CAT_ID_CLIENTES'        ,        2); // categoria clientes
}
if(!defined('CFG_TEC_CAT_ID_FUNCIONARIOS')){
    define('CFG_TEC_CAT_ID_FUNCIONARIOS'        ,        3); // categoria funcionarios
}


if(!defined('CFG_TEC_PAISES_EXTRAGEIROS')){
    define('CFG_TEC_PAISES_EXTRAGEIROS' ,        false);
}

/*****************************************************************
 *                     PERSONALIZACAO DE TEXTO
 *****************************************************************/


if(!defined('SISTEMA_END')){ // TBM PARA CHECKLIST
    define('SISTEMA_END' ,        'Certa');
}
if(!defined('SISTEMA_TELEFONE')){ // TBM PARA CHECKLIST
    define('SISTEMA_TELEFONE' ,        '(21) 2222-2222');
}
if(!defined('SISTEMA_EMAIL')){ // TBM PARA CHECKLIST
    define('SISTEMA_EMAIL' ,        'contato@certa.com.br');
}



// NOME DE COMERCIO CHECKLIST E VEICULO EQUIPAMENTOS
if(!defined('CFG_TXT_EQUIPAMENTOS_NOME')){ 
    define('CFG_TXT_EQUIPAMENTOS_NOME' ,        'Nome');
}
if(!defined('CFG_TXT_COMERCIO_OS')){
    define('CFG_TXT_COMERCIO_OS'        ,       'Ordem de Serviço');
}
if(!defined('CFG_TXT_COMERCIO_OS_PLURAL')){
    define('CFG_TXT_COMERCIO_OS_PLURAL' ,       'Ordens de Serviço');
}
// IMPRESSAO
if(!defined('CFG_IMPRESSAO_TITULO_REPETIR')){
    define('CFG_IMPRESSAO_TITULO_REPETIR' ,    false);
}



/*****************************************************************
 *                       BANCO DE DADOS
 *****************************************************************/
// SISTEMA
if(!defined('MYSQL_SIS_MENU')){
    define('MYSQL_SIS_MENU'                             , 'Sistema_Menu');
}
if(!defined('MYSQL_SIS_LOG_PERFORMACE')){
    define('MYSQL_SIS_LOG_PERFORMACE'                   , 'Sistema_Log_Performace');
}

// CURSO

if(!defined('MYSQL_CURSO')){
    define('MYSQL_CURSO'                                , 'Curso');
}
if(!defined('MYSQL_CURSO_TURMA')){
    define('MYSQL_CURSO_TURMA'                          , 'Curso_Turma');
}
if(!defined('MYSQL_CURSO_TURMA_INSCRICAO')){
    define('MYSQL_CURSO_TURMA_INSCRICAO'                , 'Curso_Turma_Inscricao');
}

//COMERCIO VENDAS
if(  !defined('MYSQL_COMERCIO_VENDA_MESA')){
    define('MYSQL_COMERCIO_VENDA_MESA'                  , 'Comercio_Venda_Mesa');
}
if(  !defined('MYSQL_COMERCIO_VENDA_COMPOSICAO')){
    define('MYSQL_COMERCIO_VENDA_COMPOSICAO'            , 'Comercio_Venda_Composicao');
}
if(  !defined('MYSQL_COMERCIO_VENDA_COMPOSICAO_PRODUTOS')){
    define('MYSQL_COMERCIO_VENDA_COMPOSICAO_PRODUTOS'   , 'Comercio_Venda_Composicao_Produtos');
}
if(  !defined('MYSQL_COMERCIO_VENDA_CARRINHO')){
    define('MYSQL_COMERCIO_VENDA_CARRINHO'              , 'Comercio_Venda_Carrinho');
}
if(  !defined('MYSQL_COMERCIO_VENDA_CARRINHO_COMPOSICOES')){
    define('MYSQL_COMERCIO_VENDA_CARRINHO_COMPOSICOES'  , 'Comercio_Venda_Carrinho_Composicoes');
}

// TRANSPORTE
if(  !defined('MYSQL_TRANSPORTE_ARMAZEM')){
    define('MYSQL_TRANSPORTE_ARMAZEM'                  , 'Transporte_Armazem');
}
if(  !defined('MYSQL_TRANSPORTE_CAMINHONEIRO')){
    define('MYSQL_TRANSPORTE_CAMINHONEIRO'             , 'Transporte_Caminhoneiro');
}
if(  !defined('MYSQL_TRANSPORTE_ESTRADA')){
    define('MYSQL_TRANSPORTE_ESTRADA'                  , 'Transporte_Estrada');
}
if(  !defined('MYSQL_TRANSPORTE_FORNECEDOR')){
    define('MYSQL_TRANSPORTE_FORNECEDOR'                , 'Transporte_Fornecedor');
}
if(  !defined('MYSQL_TRANSPORTE_TRANSPORTADORA')){
    define('MYSQL_TRANSPORTE_TRANSPORTADORA'            , 'Transporte_Transportadora');
}
if(  !defined('MYSQL_TRANSPORTE_TRANSPORTADORA_PEDIDO')){
    define('MYSQL_TRANSPORTE_TRANSPORTADORA_PEDIDO'     , 'Transporte_Transportadora_Pedido');
}
if(  !defined('MYSQL_TRANSPORTE_ARMAZEM_PEDIDO')){
    define('MYSQL_TRANSPORTE_ARMAZEM_PEDIDO'            , 'Transporte_Armazem_Pedido');
}
if(  !defined('MYSQL_TRANSPORTE_CAMINHONEIRO_PEDIDO')){
    define('MYSQL_TRANSPORTE_CAMINHONEIRO_PEDIDO'       , 'Transporte_Caminhoneiro_Pedido');
}
if(  !defined('MYSQL_TRANSPORTE_TRANSPORTADORA_PEDIDO_LANCE')){
    define('MYSQL_TRANSPORTE_TRANSPORTADORA_PEDIDO_LANCE', 'Transporte_Transportadora_Pedido_Lance');
}
if(  !defined('MYSQL_TRANSPORTE_ARMAZEM_PEDIDO_LANCE')){
    define('MYSQL_TRANSPORTE_ARMAZEM_PEDIDO_LANCE'      , 'Transporte_Armazem_Pedido_Lance');
}
if(  !defined('MYSQL_TRANSPORTE_CAMINHONEIRO_PEDIDO_LANCE')){
    define('MYSQL_TRANSPORTE_CAMINHONEIRO_PEDIDO_LANCE'  , 'Transporte_Caminhoneiro_Pedido_Lance');
}



//GRAMATICA
if(  !defined('MYSQL_GRAMATICA')){
    define('MYSQL_GRAMATICA'                            , 'Gramatica');
}
if(  !defined('MYSQL_GRAMATICA_PREPOSICAO')){
    define('MYSQL_GRAMATICA_PREPOSICAO'                 , 'Gramatica_Preposicao');
}


//FRAMEWORK
if(  !defined('MYSQL_UNIVERSAL_VIVO_CEP')){
    define('MYSQL_UNIVERSAL_VIVO_CEP'                       , 'Universal_Vivo_Cep');
}
if(  !defined('MYSQL_UNIVERSAL_VIVO_CNPJ')){
    define('MYSQL_UNIVERSAL_VIVO_CNPJ'                      , 'Universal_Vivo_Cnpj');
}
if(  !defined('MYSQL_UNIVERSAL_VIVO_CPF')){
    define('MYSQL_UNIVERSAL_VIVO_CPF'                       , 'Universal_Vivo_Cpf');
}

if(  !defined('MYSQL_LOG_FALHA')){
    define('MYSQL_LOG_LOGIN_FALHA'                      , 'Log_Login_Falha');
}
if(  !defined('MYSQL_LOG_LOGIN')){
    define('MYSQL_LOG_LOGIN'                            , 'Log_Login');
}
if(  !defined('MYSQL_LOG_LOGIN_JANELA')){
    define('MYSQL_LOG_LOGIN_JANELA'                     , 'Log_Login_Janela');
}
if(  !defined('MYSQL_TELEFONE')){
    define('MYSQL_TELEFONE'                             , 'Telefone');
}
if(  !defined('MYSQL_TELEFONE_REFERENCIA')){
    define('MYSQL_TELEFONE_REFERENCIA'                  , 'Telefone_Referencia');
}

if(  !defined('MYSQL_EVENTO_MANIFESTACAO_TERRITORIAL')){
    define('MYSQL_EVENTO_MANIFESTACAO_TERRITORIAL'      , 'Evento_Manifestacao_Territorial');
}


// AGENDA
if(  !defined('MYSQL_AGENDA_COMPROMISSO')){
    define('MYSQL_AGENDA_COMPROMISSO'                   , 'Agenda_Compromisso');
}
if(  !defined('MYSQL_AGENDA_ATIVIDADE_HORA')){
    define('MYSQL_AGENDA_ATIVIDADE'                     , 'Agenda_Atividade');
}
if(  !defined('MYSQL_AGENDA_ATIVIDADE_HORA')){
    define('MYSQL_AGENDA_ATIVIDADE_HORA'                , 'Agenda_Atividade_Hora');
}


if(  !defined('MYSQL_INSTITUICAO')){
    define('MYSQL_INSTITUICAO'                          , 'Instituição');
}
if(  !defined('MYSQL_FOTO')){
    define('MYSQL_FOTO'                                 , 'Foto');
}
if(  !defined('MYSQL_FOTO_REFERENCIA')){
    define('MYSQL_FOTO_REFERENCIA'                      , 'Foto_Referencia');
}

if(!defined('MYSQL_BIBLIOTECA')){
    define('MYSQL_BIBLIOTECA'                           , 'Biblioteca');
}
if(!defined('MYSQL_BIBLIOTECA_ACESSO')){
    define('MYSQL_BIBLIOTECA_ACESSO'                    , 'Biblioteca_Acesso');
}
if(!defined('MYSQL_ENQUETE')){
    define('MYSQL_ENQUETE'                              , 'Enquete');
}
if(!defined('MYSQL_ENQUETE_RESPOSTA')){
    define('MYSQL_ENQUETE_RESPOSTA'                     , 'Enquete_Resposta');
}
if(!defined('MYSQL_ENQUETE_VOTO')){
    define('MYSQL_ENQUETE_VOTO'                         , 'Enquete_Voto');
}
// Banco de Dados
if(!defined('MYSQL_SIS_NEWSLETTER')){
    define('MYSQL_SIS_NEWSLETTER'                       , 'skafe_emails');
}

// COMERCIO
if(!defined('MYSQL_COMERCIO_VISITA')){
    define('MYSQL_COMERCIO_VISITA'                      , 'Comercio_Visita');
} if(!defined('MYSQL_COMERCIO_VISITA_COMENTARIO')){
    define('MYSQL_COMERCIO_VISITA_COMENTARIO'           ,'Comercio_Visita_Comentario');
}
if(!defined('MYSQL_COMERCIO_CHECKLIST')){
    define('MYSQL_COMERCIO_CHECKLIST'                   , 'Comercio_Checklist');
}


if(!defined('MYSQL_COMERCIO_PROPOSTA_SUB')){
    define('MYSQL_COMERCIO_PROPOSTA_SUB'                , 'Comercio_Proposta_Sub');
}
if(!defined('MYSQL_COMERCIO_PROPOSTA_MAODEOBRA')){
    define('MYSQL_COMERCIO_PROPOSTA_MAODEOBRA'          , 'Comercio_Proposta_MaodeObra');
}
if(!defined('MYSQL_COMERCIO_PROPOSTA_PRODUTO')){
    define('MYSQL_COMERCIO_PROPOSTA_PRODUTO'            , 'Comercio_Proposta_Produto');
}
if(!defined('MYSQL_COMERCIO_PROPOSTA_FUNCIONARIO')){
    define('MYSQL_COMERCIO_PROPOSTA_FUNCIONARIO'        , 'Comercio_Proposta_Funcionario');
}
if(!defined('MYSQL_COMERCIO_PROPOSTA_COMENTARIO')){
    define('MYSQL_COMERCIO_PROPOSTA_COMENTARIO'        , 'Comercio_Proposta_Comentario');
}
if(!defined('MYSQL_COMERCIO_PROPOSTA_CHECKLIST')){
    define('MYSQL_COMERCIO_PROPOSTA_CHECKLIST'          , 'Comercio_Proposta_Checklist');
}
if(!defined('MYSQL_COMERCIO_PROPOSTA')){
    define('MYSQL_COMERCIO_PROPOSTA'                    , 'comercio_proposta'); 
} 
if(!defined('MYSQL_COMERCIO_PROPOSTA_SERVICOTIPO')){
    define('MYSQL_COMERCIO_PROPOSTA_SERVICOTIPO'        , 'Comercio_Proposta_Servicotipo'); 
} 
if(!defined('MYSQL_COMERCIO_PROPOSTA_SERVICO')){
    define('MYSQL_COMERCIO_PROPOSTA_SERVICO'            , 'Comercio_Proposta_Servico'); 
} 
if(!defined('MYSQL_COMERCIO_PROPOSTA_SERVICOINSTALACAO')){
    define('MYSQL_COMERCIO_PROPOSTA_SERVICOINSTALACAO'  , 'Comercio_Proposta_ServicoInstalacao'); 
} 
if(!defined('MYSQL_COMERCIO_ESTOQUE')){
    define('MYSQL_COMERCIO_ESTOQUE'                     , 'Comercio_Estoque');
}
if(!defined('MYSQL_COMERCIO_PRODUTO_ESTOQUE_REDUZIR')){
    define('MYSQL_COMERCIO_PRODUTO_ESTOQUE_REDUZIR'     , 'Comercio_Estoque_Reduzir');
}
if(!defined('MYSQL_COMERCIO_UNIDADE')){
    define('MYSQL_COMERCIO_UNIDADE'                     , 'Comercio_Unidade');
}
if(!defined('MYSQL_COMERCIO_FAMILIA')){
    define('MYSQL_COMERCIO_FAMILIA'                     , 'Comercio_Familia');
}
if(!defined('MYSQL_COMERCIO_FORNECEDOR')){
    define('MYSQL_COMERCIO_FORNECEDOR'                  , 'comercio_fornecedor');
}
if(!defined('MYSQL_COMERCIO_FORNECEDOR_COMENTARIO')){
    define('MYSQL_COMERCIO_FORNECEDOR_COMENTARIO'       , 'comercio_fornecedor_Comentario');
}
if(!defined('MYSQL_COMERCIO_FORNECEDOR_MATERIAL')){
    define('MYSQL_COMERCIO_FORNECEDOR_MATERIAL'         , 'Comercio_Fornecedor_Material');
}
if(!defined('MYSQL_COMERCIO_FORNECEDOR_MATERIAL_PRODUTOS')){
    define('MYSQL_COMERCIO_FORNECEDOR_MATERIAL_PRODUTOS' , 'Comercio_Fornecedor_Material_Produtos');
}
if(!defined('MYSQL_COMERCIO_MARCA')){
    define('MYSQL_COMERCIO_MARCA'                       , 'comercio_marca');
}
if(!defined('MYSQL_COMERCIO_LINHA')){
    define('MYSQL_COMERCIO_LINHA'                       , 'comercio_linha');
}
if(!defined('MYSQL_COMERCIO_PRODUTO')){
    define('MYSQL_COMERCIO_PRODUTO'                     , 'comercio_produto'); 
}

// MODULOS COMERCIO_SERVICO
if(!defined('MYSQL_COMERCIO_SERVICO')){
    define('MYSQL_COMERCIO_SERVICO'                     , 'comercio_servico'); 
}   
if(!defined('MYSQL_COMERCIO_SERVICO_TIPO')){
    define('MYSQL_COMERCIO_SERVICO_TIPO'                , 'comercio_servico_tipo'); 
}
if(!defined('MYSQL_COMERCIO_SERVICO_AR')){
    define('MYSQL_COMERCIO_SERVICO_AR'                  , 'Comercio_Servico_Ar'); 
}
if(!defined('MYSQL_COMERCIO_SERVICO_BTU')){
    define('MYSQL_COMERCIO_SERVICO_BTU'                 , 'Comercio_Servico_Btu'); 
}
if(!defined('MYSQL_COMERCIO_SERVICO_GAS')){
    define('MYSQL_COMERCIO_SERVICO_GAS'                 , 'Comercio_Servico_Gas'); 
}
if(!defined('MYSQL_COMERCIO_SERVICO_LINHA')){
    define('MYSQL_COMERCIO_SERVICO_LINHA'               , 'Comercio_Servico_Linha'); 
}
if(!defined('MYSQL_COMERCIO_SERVICO_SERVICO')){
    define('MYSQL_COMERCIO_SERVICO_SERVICO'             , 'Comercio_Servico_Servico'); 
}
if(!defined('MYSQL_COMERCIO_SERVICO_SUPORTE')){
    define('MYSQL_COMERCIO_SERVICO_SUPORTE'             , 'Comercio_Servico_Suporte'); 
}
// MODULO USUARIOS
if(!defined('MYSQL_USUARIO_ANEXO')){
    define('MYSQL_USUARIO_ANEXO'                        , 'Usuario_Anexo');
}
// Usuarios Mensagem
if(!defined('MYSQL_USUARIO_MENSAGEM_ANEXO')){
    define('MYSQL_USUARIO_MENSAGEM_ANEXO'               , 'Usuario_Mensagem_Anexo');
}
if(!defined('MYSQL_USUARIO_MENSAGEM_ORIGEM')){
    define('MYSQL_USUARIO_MENSAGEM_ORIGEM'              , 'usuario_mensagem_origem');
}
if(!defined('MYSQL_USUARIO_MENSAGEM_ASSUNTO')){
    define('MYSQL_USUARIO_MENSAGEM_ASSUNTO'             , 'usuario_mensagem_assunto');
}
if(!defined('MYSQL_USUARIO_MENSAGEM_SETOR')){
    define('MYSQL_USUARIO_MENSAGEM_SETOR'               , 'usuario_mensagem_setor');
}
if(!defined('MYSQL_USUARIO_MENSAGEM_SETOR_RESPONSAVEL')){
    define('MYSQL_USUARIO_MENSAGEM_SETOR_RESPONSAVEL'   , 'usuario_mensagem_setor_responsavel');
}
// ENGENHARIA
if(!defined('MYSQL_ENGENHARIA_EQUIPAMENTO')){
    define('MYSQL_ENGENHARIA_EQUIPAMENTO'               , 'Engenharia_Equipamento');
}
if(!defined('MYSQL_ENGENHARIA_EMPREENDIMENTO')){
    define('MYSQL_ENGENHARIA_EMPREENDIMENTO'            , 'Engenharia_Empreendimento');
}
if(!defined('MYSQL_ENGENHARIA_EMPREENDIMENTO_UNIDADE')){
    define('MYSQL_ENGENHARIA_EMPREENDIMENTO_UNIDADE'    , 'Engenharia_Empreendimento_Unidade');
}
if(!defined('MYSQL_ENGENHARIA_ESTOQUE_RETIRADA')){
    define('MYSQL_ENGENHARIA_ESTOQUE_RETIRADA'          , 'Engenharia_Estoque_Retirada');
}
if(!defined('MYSQL_ENGENHARIA_EMPREENDIMENTO_CUSTO')){
    define('MYSQL_ENGENHARIA_EMPREENDIMENTO_CUSTO'      , 'Engenharia_Empreendimento_Custo');
}


// Comercio Certificado
if(!defined('MYSQL_COMERCIO_CERTIFICADO_PROPOSTA')){
    define('MYSQL_COMERCIO_CERTIFICADO_PROPOSTA'             , 'comercio_certificado_proposta');
}
if(!defined('MYSQL_COMERCIO_CERTIFICADO_AUDITORIA')){
    define('MYSQL_COMERCIO_CERTIFICADO_AUDITORIA'            , 'comercio_certificado_auditoria');
}
if(!defined('MYSQL_COMERCIO_CERTIFICADO_AUDITORIAPERIODICA')){
    define('MYSQL_COMERCIO_CERTIFICADO_AUDITORIAPERIODICA'   , 'comercio_certificado_auditoriaperiodica');
}


// Banco de Dados Predial
if(!defined('MYSQL_PREDIAL_SALAO')){
    define('MYSQL_PREDIAL_SALAO'                    , 'Predial_Salao');
}
if(!defined('MYSQL_PREDIAL_SALAO_RESERVA')){
    define('MYSQL_PREDIAL_SALAO_RESERVA'            , 'Predial_Salao_Reserva');
}
if(!defined('MYSQL_PREDIAL_BLOCO')){
    define('MYSQL_PREDIAL_BLOCO'                    , 'Predial_Bloco');
}
if(!defined('MYSQL_PREDIAL_BLOCO_APART')){
    define('MYSQL_PREDIAL_BLOCO_APART'              , 'Predial_Bloco_Apart');
}
if(!defined('MYSQL_PREDIAL_BLOCO_APART_ADVERTENCIA')){
    define('MYSQL_PREDIAL_BLOCO_APART_ADVERTENCIA'  , 'Predial_Bloco_Apart_Advertencia');
}
if(!defined('MYSQL_PREDIAL_BLOCO_APART_INFORMATIVO')){
    define('MYSQL_PREDIAL_BLOCO_APART_INFORMATIVO'  , 'Predial_Bloco_Apart_Informativo');
}
if(!defined('MYSQL_PREDIAL_BLOCO_APART_CORREIO')){
    define('MYSQL_PREDIAL_BLOCO_APART_CORREIO'      , 'Predial_Bloco_Apart_Correio');
}
if(!defined('MYSQL_PREDIAL_BLOCO_APART_CORREIO_AVISO')){
    define('MYSQL_PREDIAL_BLOCO_APART_CORREIO_AVISO', 'Predial_Bloco_Apart_Correio_Aviso');
}
if(!defined('MYSQL_PREDIAL_BLOCO_APART_ANIMAL')){
    define('MYSQL_PREDIAL_BLOCO_APART_ANIMAL'       , 'Predial_Bloco_Apart_Animal');
}
if(!defined('MYSQL_PREDIAL_BLOCO_APART_VEICULO')){
    define('MYSQL_PREDIAL_BLOCO_APART_VEICULO'      , 'Predial_Bloco_Apart_Veiculo');
}

// OUTROS BANCOS E SUAS TABELAS
if(!defined('MYSQL_CAT')){
    define('MYSQL_CAT',                                     'Categoria');
} if(!defined('MYSQL_CAT_ACESSO')){
    define('MYSQL_CAT_ACESSO',                              'Categoria_Acesso');
} if(!defined('MYSQL_LOGURL')){
    define('MYSQL_LOGURL',                                  'log_url');
} if(!defined('MYSQL_LOG_SQL')){
    define('MYSQL_LOG_SQL',                                 'log_sql');
} if(!defined('MYSQL_SIS_GRUPO')){
    define('MYSQL_SIS_GRUPO',                               'Sistema_Grupo');
} if(!defined('MYSQL_SIS_GRUPO_PERMISSAO')){
    define('MYSQL_SIS_GRUPO_PERMISSAO',                     'Sistema_Grupo_Permissao');
} if(!defined('MYSQL_SIS_PERMISSAO')){
    define('MYSQL_SIS_PERMISSAO',                           'Sistema_Permissao');
} if(!defined('MYSQL_USUARIO_PERMISSAO')){
    define('MYSQL_USUARIO_PERMISSAO',                       'Usuario_Permissao');
}
if(!defined('MYSQL_SIS_LOGIN_ESQUECISENHA')){
    define('MYSQL_SIS_LOGIN_ESQUECISENHA',                  'Sistema_Login_Esquecisenha');
}

// BASICOS
if(!defined('MYSQL_USUARIOS')){
    define('MYSQL_USUARIOS'                             , 'usuario');
} if(!defined('MYSQL_USUARIOS_HISTORICO_EMAIL')){
    define('MYSQL_USUARIOS_HISTORICO_EMAIL'             , 'Usuario_Historico_Email');
} if(!defined('MYSQL_USUARIO_VEICULO_ALUGUEL')){
    define('MYSQL_USUARIO_VEICULO_ALUGUEL'              , 'usuario_aluguel');
} if(!defined('MYSQL_USUARIO_VEICULO')){
    define('MYSQL_USUARIO_VEICULO'                      , 'Veiculo');
} if(!defined('MYSQL_USUARIO_VEICULO_EVENTO')){
    define('MYSQL_USUARIO_VEICULO_EVENTO'               , 'Veiculo_Evento');
} if(!defined('MYSQL_USUARIO_VEICULO_COMENTARIO')){
    define('MYSQL_USUARIO_VEICULO_COMENTARIO'           , 'Veiculo_Comentario');
} if(!defined('MYSQL_USUARIO_VEICULO_EQUIPAMENTO')){
    define('MYSQL_USUARIO_VEICULO_EQUIPAMENTO'          , 'Veiculo_Equipamento');
} if(!defined('MYSQL_USUARIO_VEICULO_EQUIPAMENTO_MARCAS')){
    define('MYSQL_USUARIO_VEICULO_EQUIPAMENTO_MARCAS'   , 'Veiculo_Equipamento_Marcas');
} if(!defined('MYSQL_USUARIO_VEICULO_EQUIPAMENTO_MODELO')){
    define('MYSQL_USUARIO_VEICULO_EQUIPAMENTO_MODELO'   , 'Veiculo_Equipamento_Modelo');
} if(!defined('MYSQL_USUARIO_VEICULO_MARCAS')){
    define('MYSQL_USUARIO_VEICULO_MARCAS'               , 'Veiculo_Marcas');
} if(!defined('MYSQL_USUARIO_VEICULO_MODELO')){
    define('MYSQL_USUARIO_VEICULO_MODELO'               , 'Veiculo_Modelo');
} if(!defined('MYSQL_USUARIOS_MENS')){
    define('MYSQL_USUARIOS_MENS'                        , 'Usuario_Mensagem');
} if(!defined('MYSQL_USUARIOS_MENS_RESP')){
    define('MYSQL_USUARIOS_MENS_RESP'                   , 'Usuario_Mensagem_resp');
} if(!defined('MYSQL_USUARIOS_COMENTARIOS')){
    define('MYSQL_USUARIOS_COMENTARIOS'                 , 'usuario_comentario');
} if(!defined('MYSQL_BANNERS')){
    define('MYSQL_BANNERS'                              , 'Banner');
}
// FINANCEIRO
if(!defined('MYSQL_FINANCEIRO_FINANCEIRO_FORMA')){
    define('MYSQL_FINANCEIRO_FINANCEIRO_FORMA'          , 'Pagamento_Forma');
} if(!defined('MYSQL_FINANCEIRO_FINANCEIRO_FORMA_CONDICAO')){
    define('MYSQL_FINANCEIRO_FINANCEIRO_FORMA_CONDICAO' , 'Pagamento_Forma_Condicao');
} if(!defined('MYSQL_FINANCEIRO_MOV_EXT')){
    define('MYSQL_FINANCEIRO_MOV_EXT'                   , 'Pagamento_Mov_Ext');
} if(!defined('MYSQL_FINANCEIRO_MOV_INT')){
    define('MYSQL_FINANCEIRO_MOV_INT'                   , 'Pagamento_Mov_Int');
}if(!defined('MYSQL_FINANCEIRO_BANCO')){
    define('MYSQL_FINANCEIRO_BANCO'                     , 'Financeiro_Banco');
}
// AUTO ATUALIZADOS
if(!defined('MYSQL_SOCIAL')){
    define('MYSQL_SOCIAL'                       , 'Social');
} if(!defined('MYSQL_SOCIAL_COMENTARIO')){
    define('MYSQL_SOCIAL_COMENTARIO'            , 'Social_Comentario');
} if(!defined('MYSQL_SOCIAL_FICOU')){
    define('MYSQL_SOCIAL_FICOU'                 , 'Social_Ficou');
}if(!defined('MYSQL_SOCIAL_FICOU_COMENTARIO')){
    define('MYSQL_SOCIAL_FICOU_COMENTARIO'      , 'Social_Ficou_Comentario');
}if(!defined('MYSQL_SOCIAL_CARACTERISTICA')){
    define('MYSQL_SOCIAL_CARACTERISTICA'        , 'Social_Caracteristica');
}if(!defined('MYSQL_SOCIAL_CARACTERISTICA_ACAO')){
    define('MYSQL_SOCIAL_CARACTERISTICA_ACAO'   , 'Social_Caracteristica_Acao');
}if(!defined('MYSQL_USUARIO_TELEFONE')){
    define('MYSQL_USUARIO_TELEFONE'              , 'Usuario_Telefone');
}if(!defined('MYSQL_USUARIO_TELEFONE_CHAMADA')){
    define('MYSQL_USUARIO_TELEFONE_CHAMADA'      , 'Usuario_Telefone_Chamada');
}if(!defined('MYSQL_SOCIAL_ACAO')){
    define('MYSQL_SOCIAL_ACAO'                  , 'Social_Acao');
}if(!defined('MYSQL_SOCIAL_ACAO_PARTICIPANTE')){
    define('MYSQL_SOCIAL_ACAO_PARTICIPANTE'     , 'Social_Acao_Participante');
}if(!defined('MYSQL_SOCIAL_ACAO_PRESENTE')){
    define('MYSQL_SOCIAL_ACAO_PRESENTE'         , 'Social_Acao_Presente');
}
// AUTO NAO USADOS
if(!defined('MYSQL_USUARIO_AGENDA_PASTA')){
    define('MYSQL_USUARIO_AGENDA_PASTA',         'Agenda_Pasta');
} if(!defined('MYSQL_USUARIO_AGENDA_PASTA_COR')){
    define('MYSQL_USUARIO_AGENDA_PASTA_COR',     'Agenda_Pasta_Cor');
} if(!defined('MYSQL_SOCIAL_TIPO')){
    define('MYSQL_SOCIAL_TIPO',          'Usuario_social_tipo');
} if(!defined('MYSQL_SOCIAL_HIST_FACE')){
    define('MYSQL_SOCIAL_HIST_FACE',     'Usuario_social_Historico_Face');
} if(!defined('MYSQL_SOCIAL_HIST_FACE_MGS')){
    define('MYSQL_SOCIAL_HIST_FACE_MGS', 'Usuario_social_Historico_Face_Mensagens');
} if(!defined('MYSQL_SOCIAL_RELACOES')){
    define('MYSQL_SOCIAL_RELACOES',      'Usuario_social_Relacoes');
} if(!defined('MYSQL_USUARIO_AGENDA_COMPROMISSOS')){
    define('MYSQL_USUARIO_AGENDA_COMPROMISSOS',  'agenda_compromissos');
} if(!defined('MYSQL_USUARIO_AGENDA_ATIVIDADES')){
    define('MYSQL_USUARIO_AGENDA_ATIVIDADES',    'Agenda_Atividades');
}

// adv
if(!defined('MYSQL_ADVOGADO_CLIENTES')){
    define('MYSQL_ADVOGADO_CLIENTES',            'adv_clientes');
} if(!defined('MYSQL_ADVOGADO_COMARCA')){
    define('MYSQL_ADVOGADO_COMARCA',             'adv_comarcas');
} if(!defined('MYSQL_ADVOGADO_VARAS')){
    define('MYSQL_ADVOGADO_VARAS',               'adv_varas');
} if(!defined('MYSQL_ADVOGADO_COLABORADORES')){
    define('MYSQL_ADVOGADO_COLABORADORES',       'adv_colaboradores');
} if(!defined('MYSQL_ADVOGADO_AUDIENCIAS')){
    define('MYSQL_ADVOGADO_AUDIENCIAS',          'adv_audiencias');
} if(!defined('MYSQL_ADVOGADO_TIPOAUDIENCIAS')){
    define('MYSQL_ADVOGADO_TIPOAUDIENCIAS',      'adv_tipoaudiencias');
} if(!defined('MYSQL_ADVOGADO_FASES')){
    define('MYSQL_ADVOGADO_FASES',               'adv_fases');
} if(!defined('MYSQL_ADVOGADO_TIPOFASES')){
    define('MYSQL_ADVOGADO_TIPOFASES',           'adv_tipofases');
} if(!defined('MYSQL_ADVOGADO_PROCESSOS')){
    define('MYSQL_ADVOGADO_PROCESSOS',           'adv_processos');
} if(!defined('MYSQL_ADVOGADO_AUTORES')){
    define('MYSQL_ADVOGADO_AUTORES',             'adv_autores');
} if(!defined('MYSQL_ADVOGADO_CONTRARIA')){
    define('MYSQL_ADVOGADO_CONTRARIA',           'adv_contraria');  // reus
}

// CONFIGURACOES DO BANCO DE DADOS
if(!defined('MYSQL_FINANCEIRO_FINANCAS')){
    define('MYSQL_FINANCEIRO_FINANCAS',          'Financeiro_Financas');  // reus
}
$mysql_tab_admin                           = 'administradores';
$mysql_tab_fin_tipo                        = 'Financeiro_tipo';
$mysql_tab_taref                           = 'tarefas';
$mysql_tab_taref_feitas                    = 'tarefas_feitas';
$mysql_tab_subtipos                        = 'Subtipos';
$mysql_tab_anotacoes                       = 'anotacoes';
$mysql_tab_compromisso                     = 'compromissos';
if(!defined('MYSQL_SIS_LOCALIZACAO_PAIZES')){
    define('MYSQL_SIS_LOCALIZACAO_PAIZES',       'localizacao_paises');
} if(!defined('MYSQL_SIS_LOCALIZACAO_ESTADOS')){
    define('MYSQL_SIS_LOCALIZACAO_ESTADOS',      'localizacao_estados');
} if(!defined('MYSQL_SIS_LOCALIZACAO_CIDADES')){
    define('MYSQL_SIS_LOCALIZACAO_CIDADES',      'localizacao_cidades');
} if(!defined('MYSQL_SIS_LOCALIZACAO_BAIRROS')){
    define('MYSQL_SIS_LOCALIZACAO_BAIRROS',      'localizacao_bairros');
} if(!defined('MYSQL_SIS_LOCAIS')){
    define('MYSQL_SIS_LOCAIS',                   'local');
} if(!defined('MYSQL_SIS_LOCAIS_TIPOS')){
    define('MYSQL_SIS_LOCAIS_TIPOS',             'local_tipos');
}

// MIDIAS, EVENTOS, NOTICIAS 
if(!defined('MYSQL_NOTICIAS')){
    define('MYSQL_NOTICIAS'           , 'Noticia');
}
if(!defined('MYSQL_NOTICIA_REFERENCIA')){
    define('MYSQL_NOTICIA_REFERENCIA'  , 'Noticia_Referencia');
}
if(!defined('MYSQL_EVENTO')){
    define('MYSQL_EVENTO',              'Evento');  // reus
}
if(!defined('MYSQL_EVENTO_ARTISTAS')){
    define('MYSQL_EVENTO_ARTISTAS',     'Evento_Artistas');  // reus
}
if(!defined('MYSQL_MUSICA')){
    define('MYSQL_MUSICA',              'Musica'); 
}
if(!defined('MYSQL_MUSICA_VIDEO')){
    define('MYSQL_MUSICA_VIDEO',        'Musica_Video'); 
}
if(!defined('MYSQL_MUSICA_ALBUM')){
    define('MYSQL_MUSICA_ALBUM',        'Musica_Album'); 
}
if(!defined('MYSQL_MUSICA_ALBUM_ARTISTA')){
    define('MYSQL_MUSICA_ALBUM_ARTISTA','Musica_Album_Artista'); 
}




// MODULO DESENVOLVIMENTO
if(!defined('MYSQL_DESENVOLVIMENTO_SENHA')){
    define('MYSQL_DESENVOLVIMENTO_SENHA'     , 'Desenvolvimento_Senha');
} if(!defined('MYSQL_PROJ')){
    define('MYSQL_PROJ',                         'Desenvolvimento_Projeto');
} if(!defined('MYSQL_DESENVOLVIMENTO_COMENTARIO')){
    define('MYSQL_DESENVOLVIMENTO_COMENTARIO',           'Desenvolvimento_Projeto_Comentario');
} if(!defined('MYSQL_PROJ_CONT')){
    define('MYSQL_PROJ_CONT',                    'Desenvolvimento_Projeto_Contas');
}
if(  !defined('MYSQL_DESENVOLVIMENTO_TAREFA')){
    define('MYSQL_DESENVOLVIMENTO_TAREFA'                       , 'Desenvolvimento_Projeto_Tarefa');
}
if(  !defined('MYSQL_DESENVOLVIMENTO_FRAMEWORK_MODULOS')){
    define('MYSQL_DESENVOLVIMENTO_FRAMEWORK_MODULOS'                    , 'Desenvolvimento_Framework_Modulos');
}
if(  !defined('MYSQL_DESENVOLVIMENTO_FRAMEWORK_SUBMODULO')){
    define('MYSQL_DESENVOLVIMENTO_FRAMEWORK_SUBMODULO'                  , 'Desenvolvimento_Framework_SubModulos');
}
if(  !defined('MYSQL_DESENVOLVIMENTO_FRAMEWORK_METODO')){
    define('MYSQL_DESENVOLVIMENTO_FRAMEWORK_METODO'                     , 'Desenvolvimento_Framework_Metodos');
}
if(  !defined('MYSQL_DESENVOLVIMENTO_FRAMEWORK_MODULO_CONFIG')){
    define('MYSQL_DESENVOLVIMENTO_FRAMEWORK_MODULO_CONFIG'              , 'Desenvolvimento_Framework_Modulo_Config');
}




// LIXO USADO APELAS PARA MANUTENCAO DE SISTEMAS ANTIGOS

if(!defined('MYSQL_USUARIO_FUNCAO')){
    define('MYSQL_USUARIO_FUNCAO'                       , 'Usuario_Funcao');
}
?>
