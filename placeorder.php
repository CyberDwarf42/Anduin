<!--Aaron Gockley
10/15/2024
SDEV-435-81
Argonath Inventory Management System

This processes customer information and enters a new order.-->
<?php
session_start();
include 'utilities.php';

$connection = OpenConn();

front_header('Place Order');

        $first = ($_POST['first']);
        $last = ($_POST['last']);
        $email = ($_POST['email']);
        $address = ($_POST['address']);
        $state = ($_POST['state']);
        $city = ($_POST['city']);
        $state = ($_POST['state']);
        $zip = ($_POST['zip']);
        $phone = ($_POST['phone']);

        $name = $first . " " . $last;



    if ($connection->execute_query("SELECT * FROM customer WHERE Name = ?", [$name]) !== TRUE) {
        echo $name;
        $connection->execute_query("INSERT INTO customer (Name, Email, StreetAddress, City, State, ZipCode, PhoneNumber) VALUES ('$name', '$email', '$address', '$city', '$state', '$zip', '$phone')");
        $id = $connection->execute_query('SELECT ID FROM customer WHERE Name = ?', [$name]);
        while ($row = $id->fetch_assoc()) {
            $ID = $row['ID'];
        }
        $connection->execute_query("INSERT INTO orderids (Customer, picked) VALUES ($ID, '0')");
        $orderid = $connection->execute_query('SELECT SCOPE_IDENTITY() AS orderid');
        

    }

$products_in_cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
$products = array();
if ($products_in_cart) {
    //This creates an array for loading the items from the database.
    $array_to_question_marks = implode(',', array_fill(0, count($products_in_cart), '?'));
    $connection = OpenConn();
    $query = $connection->prepare('SELECT * FROM inventory WHERE ID IN (' .$array_to_question_marks . ')');
    //$query->bind_param("i", $product_id);

    $query->execute(array_keys($products_in_cart));
    $result = $query->get_result();
    $products = $result->fetch_all(MYSQLI_ASSOC);

    foreach ($products as $product) {
       echo $product['Name'];
    }
}