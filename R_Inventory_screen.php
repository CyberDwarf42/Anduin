<!--Aaron Gockley
9/27/2024
SDEV-435-81
Argonath Inventory Management Systems
This page displays all the inventory items in the database-->


<?php

    include "utilities.php";
    rear_header("Inventory");
    $connection = OpenConn(); ?>
    <div class = "container">
        <?php

        $result = $connection->execute_query("SELECT * FROM inventory");
        $inventory = mysqli_fetch_all($result, MYSQLI_ASSOC);
        foreach ($inventory as $inventory_item):

            /**
             * This layout looks great, and this loop is simple and easy to follow.
             */
            ?>
            <div class = "inventory-container">
                <div class="image">
                    <img src="<?php echo $inventory_item['ImagePath']; ?>">
                </div>
                <div class="Information">
                    <h5><a href="R_update.php?Name=<?php echo $inventory_item['Name'];?>"><?php echo $inventory_item['Name'] ?></a></h5> <!--This lets the name be a link, which will transfer the name information to the Update.php page -->
                    <h5><?php echo "$".$inventory_item['Price'] ?></h5>
                    <h5><?php echo "Committed: " .$inventory_item['QtyCommitted']?></h5>
                    <h5><?php echo "On Hand: " .$inventory_item['QtyOnHand']?></h5>
                </div>
            </div>
        <?php endforeach;

    mysqli_close($connection);?>
</div>

<?php rear_footer(); ?>
