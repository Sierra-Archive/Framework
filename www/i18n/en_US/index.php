<?php
// Em ingles
$language = array( 
    'Agenda'  => array(
        'Atividades' =>  array(
            'Cadastro' => 'Cadastrar Nova Atividade',
            'Obs' => 'Observação'
        )
    ), 'financas'  => array(
        'pers' => 'Pessoas Associadas',
        'sinal' => 'Sinal',
        'positivo' => 'positivo',
        'negativo' => 'negativo',
    	'formsucesso1' => 'Financeiro inserido com Sucesso',
    	'formsucesso2' => 'O valor de {valor} foi add a base de dados...',
    	'del1' => 'Financeiro removido com Sucesso',
    	'del2' => '#{id} foi removido da base de dados...'
    ), 'social'  => array(
        'form' => 'Não relacionado a ninguém',
        'cadastro' => 'Cadastro de Pessoas',
        'form_idface' => 'Face id',
        'form_nome' => 'Nome'
    ),'mens_suce'  => array(
        'enviado' => 'Informação enviada com Sucesso.',
        'usuarios' => '',
        'entreagora' => '',
        'bandas' => '',
        'textobandas' => ''
    ),'mens_erro'  => array(
        'login' => 'Email ou senha inválida.',
        'usuarios' => 'Usuario não Logado',
        'loguenome' => 'Se logue e depois mande seu nome',
        'bandas' => '',
        'textobandas' => '',
        'erro' => 'Erro'
    ),'mens'  => array(
        'buscaevento' => 'Buscar por Evento',
        'usuarios' => '',
        'entreagora' => '',
        'bandas' => '',
        'textobandas' => ''
    ),'palavras'  => array(
        'admin' => 'Administração',
        'restrito' => 'Acesso Restrito',
        'login' => 'Login',
        'senha' => 'Senha',
        'logar' => 'Logar-se',
        'continuar' => 'Continuar',
        'cadastrar' => 'Cadastre-se',
        'busca' => 'Buscar',
        'eventos' => 'Eventos',
        'inicial' => 'Página Inicial',
        'locais' => 'Locais',
        'cat' => 'Categoria',
        'info' => 'Informações'
    ),'erros'  => array(
        'loginerrado' => 'Usuário ou Senha não identificado!!!',
        'pag_sumida' => 'P&aacute;gina não encontrada!!!',
        'pag_desencontrada' => 'A p&aacute;gina que voc&ecirc; queria n&atilde;o foi encontrada em nossos servidores. Certifique-se que digitou o endere&ccedil;o certo.',
        'clickaqui' => 'Clique aqui para ir a p&aacute;gina inicial',
        'nao_possivel' => 'Não foi possível inserir a mensagem no momento.'
    ),'formularios'  => array(
        'data' => 'Data',
        'valor' => 'Valor',
        'obs' => 'Observação',
        'cancelar' => 'Cancelar',
        'cadastrar' => 'Cadastrar',
        'editar' => 'Editar',
        'enviar' => 'Enviar',
        'inicio' => 'Inicio',
        'final' => 'Final'
    ),'galerias'  => array(
        'cadastro' => array(
            '1' => 'Galeria inserida com Sucesso',
            '2' => '{nome} foi add a base de dados...'
        ), 
        'galerias' => 'Galerias'
    ),'usuarios'  => array(
        'cadastro' => array(
            'titulo' => 'Cadastro de Usuários',
            'sucesso1' => 'Cadastro realizado com sucesso',
            'sucesso2' => 'Confira seu email para pegar sua senha.'
        ),
        'form' => array(
            'nome' => 'Nome',
            'email' => 'Email',
            'nascimento' => 'Nascimento',
            'pais' => 'Pais',
            'estado' => 'Estado',
            'cidade' => 'Cidade',
            'bairro' => 'Bairro',
            'end' => 'Endereço',
            'num' => 'Número',
            'tipo' => 'Tipo'
        )
    ),'calendario'  => array(
        'semanas' => array(
            0 => 'Domingo',
            1 => 'Segunda-Feira',
            2 => 'Terça-Feira',
            3 => 'Quarta-Feira',
            4 => 'Quinta-Feira',
            5 => 'Sexta-Feira',
            6 => 'Sábado'
        ),
        'sem' => array(
            0 => 'Do',
            1 => 'Se',
            2 => 'Te',
            3 => 'Qu',
            4 => 'Qu',
            5 => 'Se',
            6 => 'Sá'
        ),
        'meses' => array(
            0 => 'Janeiro',
            1 => 'Fevereiro',
            2 => 'Março',
            3 => 'Abril',
            4 => 'Maio',
            5 => 'Junho',
            6 => 'Julho',
            7 => 'Agosto',
            8 => 'Setembro',
            9 => 'Outubro',
            10 => 'Novembro',
            11 => 'Dezembro'
        )
    ),'admin'  => array(
        'cadastro' => array(
            'evento' => 'Cadastrar Evento',
            'local' => 'Cadastrar Local',
            'galeria' => 'Cadastrar Galeria',
            'local' => 'Cadastrar Local',
        	'financas' => 'Cadastrar Ação Financeira'
        )
    ), 'titulos' => array(
            'evento' => 'Eventos no Local',
            'cadtipolocal' => 'Cadastrar Tipo de Local'
    ), 'eventos' => array(
            'listaadd' => 'Nome Inserido na lista com Sucesso',
            'listaadd2' => 'Voce foi confirmado no evento {evento}...',
            'listarem' => 'Nome Removido na lista com Sucesso',
            'listarem2' => 'Voce foi removido no evento {evento}...',
            'vou' => 'Eu vou',
            'naovou' => 'Não Vou',
            'listaamiga' => 'Lista Amiga ({qnt})',
            'info' => 'Informações',
            'chegar' => 'Como Chegar'
    )
);
/*
preg_replace(array('/{nome}/'), array('Nome do Individuo'), $language['galerias']['cadastro']['2'])
*/
?>