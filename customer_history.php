<!--Aaron Gockley
11/15/2024
SDEV-435-81
Argonath Inventory Management Systems
This processes the customer id to get their history-->
<?php

$ID = $_GET['ID'];
include 'utilities.php';

$connection = OpenConn();

$lines = $connection->query("SELECT orderids.OrderID, lineitems.Qty, inventory.Name FROM orderids INNER JOIN lineitems ON orderids.OrderID = lineitems.OrderID INNER JOIN inventory ON lineitems.Item = inventory.ID WHERE orderids.Customer = '$ID'");

?>

<table>
    <thead>
    <tr>
        <td>OrderID</td>
        <td>Name</td>
        <td>Qty</td>
    </tr>
    </thead>
    <tbody>
    <?php foreach($lines as $line): ?>
    <tr>
        <td>
            <?php echo $line['OrderID']; ?>
        </td>
        <td>
            <?php echo $line['Name']; ?>
        </td>
        <td>
            <?php echo $line['Qty']; ?>
        </td>
    </tr>
    </tbody>
    <?php endforeach; ?>
</table>
<?php rear_footer();