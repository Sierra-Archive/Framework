<?php

namespace Framework\Classes;

require(dirname(__FILE__).'/fpdf.php');

class Pdf extends FPDF
{
    private $titulo = false;
    private $logo = false;
    function __construct($titulo, $logo = false, $orientation='P', $unit='mm', $size='A4')
    {
	// Call parent constructor
	$this->FPDF($orientation, $unit, $size);
        
	// Initialization
        $this->titulo = utf8_decode($titulo);
        $this->SetTitle($this->titulo);
        $this->SetAuthor(utf8_decode('Ricardo Rebello Sierra'));
        $this->SetFont('Arial', '',10);
        // Logo Caso Solicitado
        if ($logo !== false) {
            $this->logo = $logo;
        } else {
            $this->logo = ARQ_URL.'_Sistema/logo.png';
        }
    }
    // Page header
    function Header()
    {
        // Logo
        $this->Image($this->logo,10,6,60);
        // Arial bold 15
        $this->SetFont('Arial', 'B',15);
        // Move to the right
        $this->Cell(80);
        // Title
        $this->Cell(strlen($this->titulo)*4,10, $this->titulo,1,0,'C');
        // Line break
        $this->Ln(20);
    }

    // Page footer
    function Footer()
    {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial', 'I',8);
        // Page number
        $this->Cell(0,10,utf8_decode('Página '.$this->PageNo().'/{nb}'),0,0,'C');
    }

    // Array Table do meu Framework
    function ArrayTable(&$table)
    {
        $this->SetFont('Arial', 'B',9);
        $colunas = count($table);
        $largura = 190/$colunas;
        // Header
        foreach ($table as $indice=>&$valor) {
            $this->Cell($largura,7,utf8_decode($indice),1);
        }
        
        $this->SetFont('Arial', '',8);
        $this->Ln();
        for ($i=0;$i<$colunas;++$i) {
            foreach ($table as &$valor) {
                if (!isset($valor[$i]) || $valor[$i]=='') {
                    $this->Cell($largura,6,' ',1);
                } else {
                    $this->Cell($largura,6,utf8_decode($valor[$i]),1);
                }
            }
            $this->Ln();
        }
        // Closing line
        $this->Cell($colunas*$largura,0, '', 'T');
    }

    // Better table
    function ImprovedTable($header, $data)
    {
            // Column widths
            $w = array(40, 35, 40, 45);
            // Header
            for($i=0;$i<count($header);$i++)
                    $this->Cell($w[$i],7, $header[$i],1,0,'C');
            $this->Ln();
            // Data
            foreach ($data as $row)
            {
                    $this->Cell($w[0],6, $row[0],'LR');
                    $this->Cell($w[1],6, $row[1],'LR');
                    $this->Cell($w[2],6,number_format($row[2]),'LR',0,'R');
                    $this->Cell($w[3],6,number_format($row[3]),'LR',0,'R');
                    $this->Ln();
            }
            // Closing line
            $this->Cell(array_sum($w),0, '', 'T');
    }

    // Colored table
    function FancyTable($header, $data)
    {
            // Colors, line width and bold font
            $this->SetFillColor(255,0,0);
            $this->SetTextColor(255);
            $this->SetDrawColor(128,0,0);
            $this->SetLineWidth(.3);
            $this->SetFont('', 'B');
            // Header
            $w = array(40, 35, 40, 45);
            for($i=0;$i<count($header);$i++)
                    $this->Cell($w[$i],7, $header[$i],1,0,'C',true);
            $this->Ln();
            // Color and font restoration
            $this->SetFillColor(224,235,255);
            $this->SetTextColor(0);
            $this->SetFont('');
            // Data
            $fill = false;
            foreach ($data as $row)
            {
                    $this->Cell($w[0],6, $row[0],'LR',0,'L', $fill);
                    $this->Cell($w[1],6, $row[1],'LR',0,'L', $fill);
                    $this->Cell($w[2],6,number_format($row[2]),'LR',0,'R', $fill);
                    $this->Cell($w[3],6,number_format($row[3]),'LR',0,'R', $fill);
                    $this->Ln();
                    $fill = !$fill;
            }
            // Closing line
            $this->Cell(array_sum($w),0, '', 'T');
    }
}
