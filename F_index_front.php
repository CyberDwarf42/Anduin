<!--Aaron Gockley
9/27/2024
SDEV-435-81
Argonath Inventory Management Systems
This page displays all the inventory items on the storefront-->




<?php
session_start();
include 'utilities.php';
$connection = OpenConn();
front_header("Storefront")?>
<div class = "container">
    <?php



    $result = $connection->execute_query("SELECT * FROM inventory");

    $inventory = mysqli_fetch_all($result, MYSQLI_ASSOC);
    foreach ($inventory as $inventory_item):

            /**
             * This is using as similar layout to the inventory in the rear of the project.
             */
            ?>
            <div class = "inventory-container">
                <div class="image">
                    <img src="<?php echo $inventory_item['ImagePath']; ?>">
                </div>
                <div class="Information">
                    <h5><a href="F_product.php?Name=<?php echo $inventory_item['Name'];?>"><?php echo $inventory_item['Name'] ?></a></h5> <!--This lets the name be a link, which will transfer the name information to the Update.php page -->
                    <h5><?php echo "$".$inventory_item['Price'] ?></h5>
                    <h5><?php echo "On Hand: " .$inventory_item['QtyOnHand']?></h5>
                </div>
            </div>
            <?php endforeach;
    mysqli_close($connection);
    ?>
</div>
<?php front_footer()?>
