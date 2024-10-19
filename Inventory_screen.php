<!--Aaron Gockley
9/27/2024
SDEV-435-81
Argonath Inventory Management Systems
This page displays all the inventory items in the database-->


<?php

    include "utilities.php";
    rear_header("Inventory");
    $Link = OpenConn(); ?>
    <div class = "container">
        <?php
    $Query = "SELECT * FROM inventory";

    if ($result = mysqli_query($Link, $Query)) {
        while ($row = mysqli_fetch_assoc($result)) {
            $Name = $row['Name'];
            $Price = $row['Price'];
            $QtyOnHand = $row['QtyOnHand'];
            $QtyCommitted = $row['QtyCommitted'];
            $Image = $row['ImagePath'];

            /**
             * I used this type of container to display the information so that I could make it look better. This was also a test for the actual store page layout.
             */

            ?>
            <div class = "inventory-container">
                <div class="image">
                    <img src="<?php echo $Image; ?>">
                </div>
                <div class="Information">
                    <h5><?php echo "<a href='Update.php?Name=$Name'>" .$Name. '</a>'?></h5> <!--This lets the name be a link, which will transfer the name information to the Update.php page -->
                    <h5><?php echo "$".$Price ?></h5>
                    <h5><?php echo "On Hand: " .$QtyOnHand?></h5>
                    <h5><?php echo "Committed: " .$QtyCommitted ?></h5>
                </div>
            </div>
            <?php
        }
    }
    mysqli_close($Link);?>
</div>

<?php rear_footer(); ?>
