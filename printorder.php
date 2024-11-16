<?php

//$id = $_GET['ID'];
use Dompdf\Dompdf;


require_once('dompdf/autoload.inc.php');

//'http://localhost/Anduin/Order.php?ID='.$id

$dompdf = new Dompdf;
$dompdf->loadHtml(file_get_contents('http://localhost/Anduin/customerhistory.php?ID=1'));
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("Order #1.pdf", array("Attachment" => false));