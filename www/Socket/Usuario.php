<?php
$timestamp 		  = (int) $_GET['timestamp'];
$timestamp_novo   = time();
$timestamp_minimo = $timestamp_novo-600;
$endereco_notificacao = 'Notificacao.tmp';
// Verifica se Usuario ta Logado
// Atualiza Log de Login falando que está logado



// Verifica se Tem Notificacao
$notificacao = Array();
$modificar = false;
if (file_exists($endereco_notificacao) && is_readable($endereco_notificacao)) {
    $resultado = unserialize(file_get_contents($endereco_notificacao));
} else {
    $resultado = false;
}
if ($resultado !== false && !empty($resultado)) {
    foreach ($resultado as $indice->$valor) {
            if ($timestamp>$valor['timestamp']) {
                if ($valor['user']!=\Framework\App\Acl::Usuario_GetID_Static() && \Framework\App\Acl::Permissao($valor['url']))
                    $notificacao[] = Array(
                            'Url' => $valor['url'],
                            'Notificacao' => $valor['notificacao']
                    );
            } else if ($timestamp<$timestamp_minimo) {
                    unset($resultado[$indice]);
                    $modificar = true;
            }
    }
}
if ($modificar) {
    // Cria o arquivo com o conteúdo
    file_put_contents($endereco_notificacao, serialize($resultado));
}



// Gera Json com Notificacao e Novo Timestamp


