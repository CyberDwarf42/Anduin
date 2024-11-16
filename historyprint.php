<?php

$id = $_GET['ID'];
use Dompdf\Dompdf;
$url="http://localhost/Anduin/customerhistory.php?ID=$id";


require_once('dompdf/autoload.inc.php');

$dompdf = new Dompdf;
$dompdf->loadHtml(file_get_contents($url));
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("Customer #$id.pdf", array("Attachment" => false));