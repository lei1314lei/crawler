<?php
/**
 * Tiny function to enhance functionality of ucwords
 *
 * Will capitalize first letters and convert separators if needed
 *
 * @param string $str
 * @param string $destSep
 * @param string $srcSep
 * @return string
 */
function uc_words($str, $destSep='_', $srcSep='_')
{
    return str_replace(' ', $destSep, ucwords(str_replace($srcSep, ' ', $str)));
}

function format_data($text,$replace = "<br>") {

    return trim(preg_replace("{(\n|\r|\t|\r\n)+}", $replace, $text));
}

// convert csv file to array
function csvToarray($file,$delimiter=",",$enclose="\"",$escape="\r\n"){

    if(is_file($file)){
        return array_map('str_getcsv', file($file));
    }else {
        throw new exception("file $file is not exist!");
    }
}
// convert array to csv file
function arrayToCsv(array $data,$new_file_name,$mode = "a+"){
    $fp = fopen($new_file_name.".csv",$mode);
    foreach($data as $v) {
        if(is_string($v)) {$v = array($v);}
        foreach($v as &$sub_v) {
            $sub_v = str_replace(array("\n", "\r", "\t", "\r\n"), "<br>", $sub_v);
        }

        fputcsv($fp,$v);
    }
    return;
}

// Convert excel to Csv, it is useful for convert excel with chinese to csv with utf-8
function excelToCsv($filename) {
    // TODO file extention restriction
    echo 'Loading file ',pathinfo($filename,PATHINFO_BASENAME),' using IOFactory to identify the format<br />';
    $objPHPExcel = PHPExcel_IOFactory::load($filename);
    //  var_dump($objPHPExcel);exit;
    $objWriter = new PHPExcel_Writer_CSV($objPHPExcel);
    $objWriter->save(end(pathinfo($filename)).".csv");
    echo '<hr />';
    $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
    //  var_dump($sheetData);
}
?>