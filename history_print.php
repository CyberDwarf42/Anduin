<!--Aaron Gockley
11/15/2024
SDEV-435-81
Argonath Inventory Management Systems
This page creates a pdf to print or email to the customer with order history->
<?php

$ID = $_GET['ID'];
use Dompdf\Dompdf;

require_once('dompdf/autoload.inc.php');

$dompdf = new Dompdf;
$dompdf->loadHtml(file_get_contents('http://localhost/Anduin/customer_history.php?ID='.$ID));
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("Customer #$ID.pdf", array("Attachment" => false));