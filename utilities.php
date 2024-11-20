<!--Aaron Gockley
9/20/2024
SDEV-435-81
Argonath Inventory Management System

This file holds utilites that will be used across multiple pages-->
<?php

/**
 *Connect to Database. This is used in pretty much every page.
 */
function OpenConn() {
    $Connection = mysqli_connect("localhost", "root", "", "anduin");
    if (!$Connection) {
        echo mysqli_connect_error() . ":" . mysqli_connect_errno();
        exit();
    }

    //database encoding
    if (!mysqli_set_charset($Connection, "utf8")) {
        echo "There was a problem.";
    }

    return $Connection;
}


/**
 * This is used in every front facing page, takes a title argument to generate the header across all front facing pages.
 * includes a little way to see how many items are in the cart in the current session.
 */

function front_header($title) {
    // Get the number of items in the shopping cart, which will be displayed in the header.
    $num_items_in_cart = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
    echo <<<EOT
    <!DOCTYPE html>
    <html lang="en">
      <head>
         <meta charset="UTF-8">
         <link rel="stylesheet" href="styles.css">
         <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
         
    <title>$title</title>
    </head>
    <body>
        <header>
            <div class="content-wrapper">
                <h1>$title</h1>
                <nav>
                    <a href="IndexFront.php">Home</a>
                </nav>
                <div class="link-icons">
                    <a href="cart.php">
                        <i class="fa fa-shopping-cart"></i>
                        <span>$num_items_in_cart</span>
                    </a>
                </div>
            </div>
        </header>
        <main>

EOT;
}

/**
 * Sets the footer for each front facing page.
 */
function front_footer() {
    $year = date("Y");
    echo <<<EOT
        </main>
        <footer>
        <div class="content-wrapper">
            <p>&copy; $year, Anduin Inventory Management</p>
        </div>
        </footer>
    </body>
</html>   

EOT;

}

/**
 * This sets up the header for the rear admin tools, includes links to everything for the admin tools.
 */
function rear_header($title) {
    echo <<<EOT
    <!DOCTYPE html>
    <html lang="en">
      <head>
         <meta charset="UTF-8">
         <link rel="stylesheet" href="styles.css">
         <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
         
    <title>$title</title>
    </head>
    <body>
        <header>
            <div class="inventory-container">
                <h1>$title</h1>
                <nav>
                    <a href="Add.php">Add Item</a>
                    <a href="Inventory_screen.php">Inventory</a>
                    <a href="customer_list.php">History</a>
                    <a href="IndexRear.php">Orders</a>
                </nav>
            </div>
        </header>
        <main>

EOT;
}

/**
 * This is the footer for the rear facing pages. 
 */
function rear_footer() {
    $year = date("Y");
    echo <<<EOT
        </main>
        <footer>
        <div class="content-wrapper">
            <p>&copy; $year, Anduin Inventory Management</p>
        </div>
        </footer>
    </body>
</html>   

EOT;

}