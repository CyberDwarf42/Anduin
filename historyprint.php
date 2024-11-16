<!--Aaron Gockley
11/15/2024
SDEV-435-81
Argonath Inventory Management Systems
This page creates a pdf to print or email to the customer with order history->
<?php

$id = $_GET['ID'];
use Dompdf\Dompdf;


require_once('dompdf/autoload.inc.php');



$dompdf = new Dompdf;
$dompdf->loadHtml(file_get_contents('http://localhost/Anduin/customerhistory.php?ID='.$id));
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("Customer #$id.pdf", array("Attachment" => false));