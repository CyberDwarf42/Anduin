<!--Aaron Gockley
9/28/2024
SDEV-435-81
Argonath Inventory Management Systems
This loads the clicked items info into a form-->


    <?php
    /**
     * This will load all the information of the item that is clicked on from the Inventory_Screen. A very similar method will be used in the storefront page
     */
    include "utilities.php";
    $name = $_GET['Name'];
    rear_header($name);
    $connection = OpenConn();
    $result = $connection->execute_query("SELECT * FROM inventory WHERE Name = '$name'");

    while ($row = mysqli_fetch_assoc($result)) {
            $ID = $row['ID'];
            $name = $row['Name'];
            $description = $row['Description'];
            $qtyonhand = $row['QtyOnHand'];
            $price = $row['Price'];
    }

    mysqli_close($connection);

    ?>
    <!--This loads a form which will allow the user to update the item's information.-->
    <form action="Save_Record.php" method="post">
        <input type="hidden" value="<?php echo $ID; ?>" name="ID"> <!--This is necessary for the save_record if..else to work.-->
        Name: <input type="text" name="Name" placeholder="name" maxlength="30" required
        value="<?php echo $name; ?>"><br>
        Description: <input type="text" name="Description" placeholder="Description" maxlength="100" required
        value="<?php echo $description; ?>"><br>
        QtyOnHand <input type="number" name="QtyOnHand" placeholder="Qty" required
        value="<?php echo $qtyonhand; ?>"><br>
        Price <input type="number" name="Price" placeholder="1.00" step="0.01" required
        value ="<?php echo $price; ?>"><br>
        <input type="submit" value="Submit">
    </form>

<?php rear_footer(); ?>