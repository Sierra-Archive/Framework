<?php
// Verificar se Roda MYSQLNATIVO DRIVER



//phpinfo();
//$mysqli = new mysqli("localhost", "ricardos_predial", "1020943", "ricardos_predial"); 
$mysqli = new mysqli("localhost", "root", "jmedtyqw", "Cliente_Predial"); 

if ($mysqli->connect_error)
{
    die("$mysqli->connect_errno: $mysqli->connect_error");
}




$cidade = "Rio de Janeiro";

/* cria uma declaração preparada */
$stmt =  $mysqli->stmt_init();
if ($stmt->prepare("SELECT estado FROM localizacao_cidades WHERE Nome=?")) {

    /* atribui os parâmetros aos marcadores */
    $stmt->bind_param("s", $cidade);

    /* executa a query */
    $stmt->execute();

    /* atribui as variáveis de resultado */
    $stmt->bind_result($estado);

    /* busca o valor */
    $stmt->fetch();

    printf("%s está no estado %s\n", $cidade, $estado);

    /* fecha a declaração */
    $stmt->close();
} else {
    echo __('nao preparo');
}








echo "<br><br>\n\n'hahahahahhahahahahahahah<br><br>\n\n'";





$query = "SELECT * FROM localizacao_cidades WHERE deletado=?";

$stmt = $mysqli->stmt_init();
if (!$stmt->prepare($query))
{
    print 'Falha na query: '.$query.' \n';
}
else
{
    $stmt->bind_param("s", $ativado);

    $ativado_array = array('0','1','2','3');

    foreach($ativado_array as $ativado)
    {
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_array(MYSQLI_NUM))
        {
            foreach ($row as $r)
            {
                print "$r ";
            }
            print "\n";
        }
    }
}

$stmt->close();
$mysqli->close();
?>