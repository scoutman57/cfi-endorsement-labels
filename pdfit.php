<?php

#fpdf font library available at http://www.fpdf.org/
define('FPDF_FONTPATH','/home/rash/fpdf/font/');
require('/home/rash/fpdf/fpdf.php');

$labelcode = $_POST['labelcode'];
$labelskip = $_POST['skip'];

$labelspersheet = $_POST['labelspersheet'];
$labelcols = $_POST['labelcols'];
$labelvertinit = $_POST['labelvertinit'];
$labelvert = $_POST['labelvert'];
$labelhorizinit = $_POST['labelhorizinit'];
$labelhoriz = $_POST['labelhoriz'];
$labelrightmar = $_POST['labelrightmar'];
$linespace = $_POST['linespace'];
$fontsize = $_POST['fontsize'];


$pdf= new FPDF();
$labelno = $labelskip;
$labelcount = 0;

if(!empty($_POST['textlist']))
{

  foreach($_POST['textlist'] as $selected)
  {
    $val = str_replace( "ยง","ง",$selected);
    if( $labelno % $labelspersheet == 0 || $labelcount==0 )
    {
      $pdf->AddPage('P');
      $pdf->SetFont('Times','',$fontsize);  # font: courier, reg, 12pt
      if( $labelno != $labelskip ) $labelno=0;
    }
    $pdf->SetXY( ($labelno%$labelcols)*$labelhoriz + $labelhorizinit, ((int)($labelno/$labelcols))*$labelvert + $labelvertinit );
    $pdf->MultiCell( $labelhoriz-$labelrightmar,$linespace,$val,0,'L',0);

    $labelno++;
    $labelcount++;
  }
}

$pdf->Output("labels.pdf",'D');
?>

