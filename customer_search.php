<!--Aaron Gockley
11/15/2024
SDEV-435-81
Argonath Inventory Management Systems
This is for searching for the searched for customer -->

<?php
include 'utilities.php';
$connection = OpenConn();

$email = $_POST['email'];

$result = $connection->execute_query("SELECT * From customer WHERE Email = ?", [$email]); //since two people may have the same name, I am using the email as a username.
$count = mysqli_num_rows($result); //counts the result,

mysqli_close($connection); //closes connection since it no longer is needed.

if ($count < 1) { //if it does not find any results.
    echo "No results found, please search again, or click the link to go back to the previous page.";

    ?>
    <form action="customer_search.php" method="post">
    CustomerEmail<input type="email" name="email" required>
    </form>
    <a href="customer_list.php">History</a
    <?php
} else {
    $info = $result->fetch_assoc();
    $ID = $info['ID'];
    header("Location: historyprint.php?ID=$ID");
}
