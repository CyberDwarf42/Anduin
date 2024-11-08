<!--Aaron Gockley
11/7/2024
SDEV-435-81
Argonath Inventory Management Systems
This page is for searching for a customers history-->
<?php
include "utilities.php";
rear_header("History");
$connection = OpenConn(); ?>

<form action="customer_search.php" method="post">
    CustomerEmail<input type="email" name="email" required>
</form>

<?php
$result = $connection->execute_query("SELECT * FROM customer");
$customers = mysqli_fetch_all($result, MYSQLI_ASSOC); ?>
<table>
    <thead>
    <tr>
        <td>Name</td>
        <td>Email</td>
        <td>Street</td>
        <td>City</td>
        <td>State</td>
        <td>Zip</td>
        <td>PhoneNumber</td>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($customers as $customer): ?>
    <tr>
        <td>
            <?php echo $customer['Name']; ?>
        </td>
        <td>
            <?php echo $customer['Email']; ?>
        </td>
        <td>
            <?php echo $customer['StreetAddress']; ?>
        </td>
        <td>
            <?php echo $customer['City']; ?>
        </td>
        <td>
            <?php echo $customer['State']; ?>
        </td>
        <td>
            <?php echo $customer['ZipCode']; ?>
        </td>
        <td>
            <?php echo $customer['PhoneNumber']; ?>
        </td>
    </tr>
    </tbody>
    <?php endforeach; ?>
</table>



<?php rear_footer();

