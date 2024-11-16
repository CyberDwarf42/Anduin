<!--Aaron Gockley
11/15/2024
SDEV-435-81
Argonath Inventory Management Systems
This page creates a pdf to print or email to the customer with order history->
<?php

$id = $_GET['ID'];
use Dompdf\Dompdf;


require_once('dompdf/autoload.inc.php');

$dompdf1 = new Dompdf;
$dompdf1->loadHtml(file_get_contents('http://localhost/Anduin/customerhistory.php?ID=1'));
$dompdf1->setPaper('A4', 'portrait');
$dompdf1->render();
$dompdf1->stream("Customer #$id.pdf", array("Attachment" => false));