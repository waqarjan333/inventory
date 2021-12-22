
<?php

/* Copyright (c) 2017 AurSoft
 * PDF file generator
 * Created Date: 11 October 2012
 * Craeted By: Umair shahid
 * Modified Date: 
 */

require_once 'autoload.php';

use mikehaertl\wkhtmlto\Pdf;

$wkhtmltopdf_path = "C:\Program Files\wkhtmltopdf\bin\wkhtmltopdf";
if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
    $wkhtmltopdf_path = "C:\Program Files\wkhtmltopdf\bin\wkhtmltopdf";
} else {
    if(strpos($_SERVER['SERVER_NAME'],".com")==false){
        $wkhtmltopdf_path = "/usr/local/bin/wkhtmltopdf";
    }
    else{
        $wkhtmltopdf_path = "../../updates/wkhtmltox/bin/wkhtmltopdf";
    }
}


$options = array( 'binary' => $wkhtmltopdf_path,'user-style-sheet' => 'pdf.css',
                'disable-smart-shrinking','encoding' => 'UTF-8','page-size'=>'A4', 'dpi' => 120);
$pdf = new Pdf();
$html = "<!DOCTYPE html>".$_POST["report_html"];
$pdf->addPage($html);
$pdf->setOptions($options);

// Remove all files from foldler
/*$files = glob('../files/reports_pdf/*'); 
foreach($files as $file){
    if(is_file($file))
    unlink($file); //delete file
}*/

$file_name = $_POST["report_file"];
if (!$pdf->saveAs('../files/reports_pdf/'.$file_name.'.pdf')) {
    echo $pdf->getError();
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>PDF</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>

    <script>
        parent.reports_obj.unMask();
        var win = window.open("<?php echo $_POST["server_path"]; ?>files/reports_pdf/<?php echo $file_name;?>.pdf", '_blank');
        win.focus();
        window.location.href = "pdf_form.php"
    </script>
</body>
</html>
