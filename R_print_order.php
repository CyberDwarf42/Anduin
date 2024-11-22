<?php

$id = $_GET['ID'];
use Dompdf\Dompdf;


require_once('dompdf/autoload.inc.php');


$dompdf = new Dompdf;
$dompdf->loadHtml(file_get_contents('http://localhost/Anduin/R_order.php?ID='.$id));
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("Order #1.pdf", array("Attachment" => false));