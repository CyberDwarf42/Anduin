<!--Aaron Gockley
9/20/2024
SDEV-435-81
Argonath Inventory Management Systems
This page is for Adding a new entry to the system-->

<?php
include "utilities.php";
rear_header("Add Item")?>
    <form action="R_save_record.php" method="post" enctype="multipart/form-data" > <!--This form will collect information for creating a new item in the database-->
        <input type="hidden" name="ID" value=0> <!--This seems unnecessary, but is necessary for the save_record page.-->
        Name: <input type="text" name="Name" placeholder="name" maxlength="30" required><br>
        Description: <input type="text" name="Description" placeholder="Description" maxlength="100" required><br>
        QtyOnHand <input type="number" name="QtyOnHand" placeholder="Qty" required><br>
        Price <input type="number" name="Price" placeholder="1.00" step="0.01" required><br>
        Image: <input type="file" name="Image" required><br>
        <input type="submit" value="Submit">
    </form>
<?php rear_footer();