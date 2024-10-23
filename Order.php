<?php
$id = $_GET['OrderID'];
include 'utilities.php';

rear_header($id);
$connection = OpenConn();
$result = $connection->query("SELECT * FROM orderids INNER JOIN lineitems ON lineitems.OrderID = orderids.OrderID INNER JOIN customer ON customer.ID = orderids.Customer INNER JOIN inventory ON inventory.ID = lineitems.Item WHERE orderids.OrderID = '$id'");