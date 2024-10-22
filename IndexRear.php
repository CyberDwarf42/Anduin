<!--Aaron Gockley
10/19/2024
SDEV-435-81
Argonath Inventory Management Systems
This page is for displaying orders-->
<?php
include "utilities.php";
rear_header("Orders");
$connection = OpenConn();

$result = mysqli_query($connection, "SELECT * FROM orderids INNER JOIN customer ON orderids.Customer = customer.ID WHERE orderids.picked=0");

$orders = mysqli_fetch_all($result, MYSQLI_ASSOC);

if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $orderid = $_GET['delete'];
    $result = $connection->execute_query("SELECT * FROM lineitems INNER JOIN inventory ON lineitems.Item = inventory.ID WHERE OrderID = '$orderid'");
    $lines = mysqli_fetch_all($result, MYSQLI_ASSOC);

    foreach ($lines as $line) { //this updates the inventory to change the inventory quantities to match the inventory after the order is deleted.
        $id = $line['Item'];
        $oldcommitted = $line['QtyCommitted'];
        $oldonhand = $line['QtyOnHand'];
        $newcommitted = $oldcommitted - $line['Qty'];
        $newonhand = $oldonhand + $line['Qty'];
        $connection->execute_query("UPDATE inventory SET QtyOnHand = '$newonhand', QtyCommitted = '$newcommitted' WHERE ID = '$id'");
    }
    $connection->execute_query("DELETE FROM lineitems WHERE OrderID = '$orderid'");
    $connection->execute_query("DELETE FROM orderids WHERE OrderID = '$orderid'");
    header("Location:IndexRear.php");
}

if (isset($_GET['picked']) && is_numeric($_GET['picked'])) {
    $orderid = $_GET['picked'];
    $result = $connection->execute_query("SELECT * FROM lineitems INNER JOIN inventory ON lineitems.Item = inventory.ID WHERE OrderID = '$orderid'");
    $lines = mysqli_fetch_all($result, MYSQLI_ASSOC);
    foreach ($lines as $line) {
        $id = $line['Item'];
        $oldcommitted = $line['QtyCommitted'];
        $newcommitted = $oldcommitted - $line['Qty'];
        $connection->execute_query("UPDATE inventory SET QtyCommitted = '$newcommitted' WHERE ID = '$id'");
    }
    $connection->execute_query("UPDATE orderids SET Picked = 1 WHERE OrderID = '$orderid'");
    header("Location:IndexRear.php");
}

    ?>
    <table>
        <thead>
        <tr>
            <td>Order Number</td>
            <td>Customer Name</td>
            <td>Email</td>
            <td>Phone Number</td>
            <td>Mark as Picked</td>
            <td>Cancel Order</td>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($orders as $order): ?>
        <tr>
            <td>
                <a href="Order.php?ID=<?php echo $order['OrderID']; ?>"><?php echo $order['OrderID']; ?></a>
            </td>
            <td>
                <?php echo $order['Name']; ?><br>
            </td>
            <td>
                <?php echo $order['Email']; ?><br>
            </td>
            <td>
                <?php echo $order['PhoneNumber']; ?><br>
            </td>
            <td>
                <a href="IndexRear.php?picked=<?php echo $order['OrderID']; ?>">Mark as Picked</a><br>
            </td>
            <td>
                <a href="IndexRear.php?delete=<?php echo $order['OrderID']; ?>">Delete</a><br>
            </td>
        </tr>
</tbody>
        <?php endforeach; ?>
    </table>