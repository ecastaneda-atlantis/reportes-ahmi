<?php
require 'excel/Classes/PHPExcel/IOFactory.php';

$metodo = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];
$dispositivo = gethostname();
$sistema = $_SERVER['HTTP_USER_AGENT'];

if( $metodo == 'POST' ){
    $newfilename = "example.xlsx";
    $move = move_uploaded_file( $_FILES["file"]["tmp_name"], "./" . $newfilename );

    if( $move ){
        $name = 'example.xlsx';
        $objExcel = PHPEXCEL_IOFactory::load( $name );
        $objExcel->setActiveSheetIndex(0);
        $numColumns = $objExcel->setActiveSheetIndex(0)->getHighestColumn();
        $headers = array();

        for ($a = 'A'; $a <= $numColumns ; $a++)
            array_push( $headers, [$objExcel->getActiveSheet()->getCell( $a . 1 )->getCalculatedValue(), $a] );

        print_r( json_encode( $headers ) );
    }
}
?>
