<!--Aaron Gockley
9/28/2024
SDEV-435-81
Argonath Inventory Management Systems
This is a Product Page-->


<?php
session_start();
include "utilities.php";
$title = $_GET['Name'];
front_header($title);
/**
 * This will load all the information of the item that is clicked on from the Inventory_Screen. A very similar method will be used in the storefront page
 */


$name = $_GET['Name'];
$connection = OpenConn();

$result = $connection->execute_query("SELECT * FROM inventory WHERE Name = '$name'");

while ($row = mysqli_fetch_assoc($result)) {
        $ID = $row['ID'];
        $name = $row['Name'];
        $description = $row['Description'];
        $qtyonhand = $row['QtyOnHand'];
        $price = $row['Price'];
        $Image = $row['ImagePath'];
    }
 ?>
            <div class="product content-wrapper">
                <div class="image">
                    <img src="<?php echo $Image; ?>" alt="<?php echo $name ?>">
                </div>
                <div>
                    <h1 class="name"><?php echo $name?></h1>
                    <span class="price">
                       <?php echo "$".$price ?>
                    </span>
                    <span class="qtyonhand">
                        <?php echo "On Hand: " .$qtyonhand?>
                    </span>
                </div>
                <form action="F_cart.php" method="POST">
                    <input type="number" name="quantity" value="1" min="1" max="<?php echo $qtyonhand?>" placeholder="Quantity" required>
                    <input type="hidden" name="ID" value="<?php echo $ID ?>">
                    <input type="submit" value="Add to Cart">
                </form>
                <div class="description">
                    <?php echo $description ?>
                </div>
            </div>

</form>
<?php front_footer();