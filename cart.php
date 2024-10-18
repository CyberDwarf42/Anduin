<!--Aaron Gockley
10/05/2024
SDEV-435-81
Argonath Inventory Management Systems
This displays all the items in the cart and maintains the cart object across pages.-->
<?php
session_start();
include 'utilities.php';
//This checks the form data from the product page
if(isset($_POST['ID'], $_POST['quantity']) && is_numeric($_POST['ID']) && is_numeric($_POST['quantity'])) {
    //this makes sure the variables are integers
    $product_id = (int)$_POST['ID'];
    $quantity = (int)$_POST['quantity'];
    $connection = OpenConn();

    $query = "SELECT * FROM inventory WHERE ID = '$product_id'";
    $result = mysqli_query($connection, $query);
    $product = mysqli_fetch_array($result); //loads the result into an associative array

    //checks if product exists
    if ($product && $quantity > 0) {
        //the product exists, so we can create/update the session variable
        if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
            if (array_key_exists($product_id, $_SESSION['cart'])) {
                //The product already exists so we update the quantity
                $_SESSION['cart'][$product_id] += $quantity;
            } else {
                //adds the item to the cart
                $_SESSION['cart'][$product_id] = $quantity;
            }
        } else {
            //cart does not exist yet, so it is created.
            $_SESSION['cart'] = array($product_id => $quantity);
        }
    }
    //prevents resubmission
    //header('Location: cart.php');
    //exit;
}
    // Remove product from cart, check for the URL param "remove", this is the product id, make sure it's a number and check if it's in the cart
    if (isset($_GET['remove']) && is_numeric($_GET['remove']) && isset($_SESSION['cart']) && isset($_SESSION['cart'][$_GET['remove']])) {
        // Remove the product from the shopping cart
        unset($_SESSION['cart'][$_GET['remove']]);
    }
    //this updates the shopping cart.
    if (isset($_POST['update']) && isset($_SESSION['cart'])) {
        //this loops through the post data to update the quantities.
        foreach ($_POST as $key => $value) {
            if (strpos($key, 'quantity') !== false && is_numeric($value)) {
                $id = str_replace('quantity-', '', $key);
                $quantity = (int)$value;
                //validates the input.
                if (is_numeric($id) && isset($_SESSION['cart'][$id]) && $quantity > 0) {
                    $_SESSION['cart'][$id] = $quantity;
                }
            }
        }
        //prevents resubmission
        header('Location: cart.php');
        exit;
    }
    if (isset($_POST['checkout']) && isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        header('Location: checkout.php');
        exit;
    }

    $products_in_cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
    $products = array();
    $subtotal = 0.00;

    //if there are products in the cart.
if ($products_in_cart) {
    //This creates an array for loading the items from the database.
    $array_to_question_marks = implode(',', array_fill(0, count($products_in_cart), '?'));
    $connection = OpenConn();
    $query = $connection->prepare('SELECT * FROM inventory WHERE ID IN (' .$array_to_question_marks . ')');

    $query->execute(array_keys($products_in_cart));
    $result = $query->get_result();
    $products = $result->fetch_all(MYSQLI_ASSOC);

    foreach ($products as $product) {
        $subtotal += (float)$product['Price'] * (int)$products_in_cart[$product['ID']];
    }
}
?>
<?php front_header('Cart')?>

<div class="cart content-wrapper">
    <h1>Shopping Cart</h1>
    <form action="cart.php" method="post">
        <table>
            <thead>
                <tr>
                    <td colspan="2">Product</td>
                    <td>Price</td>
                    <td>Quantity</td>
                    <td>Total</td>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($products)): ?>
                <tr>
                    <td colspan="5" style="text-align:center;">You have no products added in your cart</td>
                </tr>
                <?php else: ?>
                <?php foreach ($products as $product): ?>
                <tr>
                    <td class="img">
                        <a href="Product.php?Name=<?php echo $product['Name'] ?>">
                            <img src="<?php echo $product['ImagePath'] ?>" width="50" height="50" alt="<?php echo $product['Name'] ?>">
                        </a>
                    </td>
                    <td>
                        <a href="Product.php?Name=<?php echo $product['Name'] ?>"><?php echo $product['Name'] ?></a>
                        <br>
                        <a href="cart.php?remove=<?php echo $product['ID'] ?>" class="remove">Remove</a>
                    </td>
                    <td class="price">&dollar;<?php echo $product['Price']?></td>
                    <td class="quantity">
                        <input type="number" name="quantity-<?php echo $product['ID'] ?>" value="<?php echo $products_in_cart[$product['ID']] ?>" min="1" max="<?php echo $product['QtyOnHand'] ?>" placeholder="Quantity" required>
                    </td>
                    <td class="price">&dollar;<?php echo $product['Price'] * $products_in_cart[$product['ID']]?></td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
        <div class="subtotal">
            <span class="text">Subtotal</span>
            <span class="price">&dollar;<?php echo $subtotal?></span>
        </div>
        <div class="buttons">
            <input type="submit" value="Update" name="update">
            <input type="submit" value="Checkout" name="checkout">
        </div>
    </form>
</div>
<?php front_footer()?>