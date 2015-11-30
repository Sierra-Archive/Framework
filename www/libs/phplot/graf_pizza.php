<?php 
// bibliotecas
require("phplot.php");

$larg = $_GET['larg'];
$alt = $_GET['alt'];
$titulo = $_GET['titulo'];
$data = unserialize($_GET['data']);
$settings = unserialize($_GET['settings']);

$plot = new PHPlot($larg, $alt);
$plot->SetTitle($titulo);
$plot->SetDataValues($data);
$plot->SetDataType('text-data-single');
$plot->SetPlotType('pie');
foreach ($data as $row) $plot->SetLegend($row[0]);
$plot->SetCallback('draw_graph', 'draw_data_table', $settings);
$plot->DrawGraph();
?>