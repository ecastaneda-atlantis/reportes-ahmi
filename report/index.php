<?php
  require 'excel/Classes/PHPExcel/IOFactory.php';
  require 'pdf/pdf.php';

  $name = 'example.xlsx';
  $objExcel = PHPEXCEL_IOFactory::load( $name );
  $objExcel->setActiveSheetIndex(0);
  $numRows = $objExcel->setActiveSheetIndex(0)->getHighestRow();
  $numColumns = $objExcel->setActiveSheetIndex(0)->getHighestColumn();
  $rows = array();

  for( $i = 1; $i <= $numRows;  $i++){
    $row = array();
    for ($a = 'A'; $a <= $numColumns ; $a++)
      array_push( $row, $objExcel->getActiveSheet()->getCell( $a . $i )->getCalculatedValue() );
    array_push( $rows, $row );
  }


  ob_start();
  $pdf = new PDF();
  $pdf->SetTitle( 'Titulo 1', true );
  $pdf->AliasNbPages();
  $pdf->AddPage();
  $pdf->SetFont('Times','',9);
  for( $i = 0; $i < count( $rows ); $i++){
      $pdf->Cell( 20,8, $rows[$i][0],1,0,'C', 0);
      $pdf->Cell( 40,8, $rows[$i][1],1,0,'C', 0);
      $pdf->Cell( 20,8, $rows[$i][2],1,1,'C', 0);
  }

  $pdf->Output();
  ob_end_flush();
?>
