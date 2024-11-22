<!--Aaron Gockley
10/15/2024
SDEV-435-81
Argonath Inventory Management System

This processes customer information and enters a new order.-->
<?php
session_start();
include 'utilities.php';
include 'owasp-php-filters/testing/sanitize.php';

$connection = OpenConn();

function addItems($ID) { //this function adds items to the lineitems table.
    $products_in_cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
    if ($products_in_cart) {
        //This creates an array for loading the items from the database.
        $array_to_question_marks = implode(',', array_fill(0, count($products_in_cart), '?'));
        $connection = OpenConn();
        $query = $connection->prepare('SELECT * FROM inventory WHERE ID IN (' .$array_to_question_marks . ')');

        //this loads all the cart items info into the products array, so we can use that information.
        $query->execute(array_keys($products_in_cart));
        $result = $query->get_result();
        $products = $result->fetch_all(MYSQLI_ASSOC);


        foreach ($products as $product) {
            $productID = $product['ID']; //loads the items id
            $productqty = $products_in_cart[$productID]; //loads the qty of that item in the cart.
            $connection->execute_query("INSERT INTO lineitems (Item, Qty, OrderID) VALUES ('$productID', '$productqty', '$ID')"); //inserts a line into lineitems
            $oldinfo = $connection->execute_query("SELECT * FROM inventory WHERE ID = '$productID'"); //loads the old inventory information.
            while ($info = $oldinfo->fetch_assoc()) {
                $oldonhand = $info['QtyOnHand'];
                $oldcommitted = $info['QtyCommitted'];
            }
            $newonhand = $oldonhand - $productqty; //creates new inventory values.
            $newcommitted = $oldcommitted + $productqty;
            $connection->execute_query("UPDATE inventory SET QtyOnHand = '$newonhand', QtyCommitted = '$newcommitted' WHERE ID = '$productID'"); //updates those values in inventory.
        }
    }
}

front_header('Place Order');

        $first = sanitize_sql_string($_POST['first']);
        $last = sanitize_sql_string($_POST['last']);
        $email = sanitize_sql_string($_POST['email']);
        $address = sanitize_sql_string($_POST['address']);
        $state = sanitize_sql_string($_POST['state']);
        $city = sanitize_sql_string($_POST['city']);
        $state = sanitize_sql_string($_POST['state']);
        $zip = sanitize_int($_POST['zip']);
        $phone = ($_POST['phone']);

        $name = $first . " " . $last;


        $result = $connection->execute_query("SELECT * FROM customer WHERE Email = ?", [$email]);
        $count = mysqli_num_rows($result);
    if ($count < 1) { //if the customer does not exist.
        $connection->execute_query("INSERT INTO customer (Name, Email, StreetAddress, City, State, ZipCode, PhoneNumber) VALUES ('$name', '$email', '$address', '$city', '$state', '$zip', '$phone')"); //it enters a new customer field
        $id = $connection->execute_query('SELECT ID FROM customer WHERE Name = ?', [$name]); //loads that customer ID
        while ($row = $id->fetch_assoc()) {
            $ID = $row['ID'];
        }
        $connection->execute_query("INSERT INTO orderids (Customer, picked) VALUES ($ID, '0')"); //creates a new order
        $orderid = mysqli_insert_id($connection); //gets that order id
        addItems($orderid); //inserts items using that ID
    } else { //identical to above function, but loads the existing customers id
        $customer = $connection->execute_query('SELECT * FROM customer WHERE Name = ?', [$name]);
        while ($row = $customer->fetch_assoc()) {
            $ID = $row['ID'];
        }
        $connection->execute_query("INSERT INTO orderids (Customer, picked) VALUES ($ID, '0')");
        $orderid = mysqli_insert_id($connection);
        addItems($orderid);
    }
    echo "Thank you for Ordering!";

front_footer();
session_destroy();