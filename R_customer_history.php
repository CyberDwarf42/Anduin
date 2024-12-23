<?php

$ID = $_GET['ID'];
include 'utilities.php';

$connection = OpenConn();

$lines = $connection->execute_query("SELECT orderids.OrderID, lineitems.Qty, inventory.Name FROM orderids INNER JOIN lineitems ON orderids.OrderID = lineitems.OrderID INNER JOIN inventory ON lineitems.Item = inventory.ID WHERE orderids.Customer = '$ID'");
//no need for parameterized query, since the ID is coming directly from the database, based on previous page.

mysqli_close($connection); //closed connection since it is no longer needed.
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