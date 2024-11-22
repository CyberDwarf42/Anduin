<?php

$id = $_GET['ID'];
include 'utilities.php';

$connection = OpenConn();
$lineresult = $connection->query("SELECT * FROM orderids INNER JOIN lineitems ON lineitems.OrderID = orderids.OrderID INNER JOIN inventory ON inventory.ID = lineitems.Item WHERE orderids.OrderID = '$id'");


$customerresult = $connection->query("SELECT * FROM customer INNER JOIN orderids ON orderids.Customer = customer.ID WHERE orderids.OrderID = '$id'");
$customerinfo = $customerresult->fetch_assoc();

$customerinfo = $customerinfo['Name']."<br>".$customerinfo['StreetAddress']."<br>".$customerinfo['City']. ', ' .$customerinfo['State']." ".$customerinfo['ZipCode']."<br>".$customerinfo['PhoneNumber']."<br>".$customerinfo['Email'];
?>

<table>
    <thead>
    <tr>
        <td>
        <?php echo $customerinfo; ?>
        </td>
    </tr>
    <tr>
        <td>
            <br>
        </td>
    </tr>
    <tr>
        <td>Name</td>
        <td>QtyToPick</td>
        <td>QtyOnHand</td>
    </tr>
    </thead>
    <tbody>
    <?php foreach($lineresult as $lineitem): ?>
    <tr>
        <td>
            <?php echo $lineitem['Name']; ?>
        </td>
        <td>
            <?php echo $lineitem['Qty'];?>
        </td>
        <td>
            <?php echo $lineitem['QtyOnHand'];?>
        </td>
    </tr>
    <br>
    </tbody>
    <?php endforeach; ?>
</table>
<br>

 <?php rear_footer();