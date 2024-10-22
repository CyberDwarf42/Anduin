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