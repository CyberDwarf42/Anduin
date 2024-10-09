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
