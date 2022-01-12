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
        $numRows = $objExcel->setActiveSheetIndex(0)->getHighestRow();
        $numColumns = $objExcel->setActiveSheetIndex(0)->getHighestColumn();
        $rows = array();

        for( $i = 2; $i <= $numRows;  $i++){
            $row = array();
            for ($a = 'A'; $a <= $numColumns; $a++){
                $celda = $objExcel->getActiveSheet()->getCell( $a . $i );
                if (PHPExcel_Shared_Date::isDateTime($celda)) {
                    array_push( $row, $celda->getFormattedValue() );
                }else {
                    $val = $celda->getCalculatedValue();
                    if( is_float( $val ) )
                        $val = round( $val, 2 );
                    array_push( $row, $val );
                }
            }
            array_push( $rows, $row );
        }
    }
    print_r( json_encode( $rows ) );
}

?>
