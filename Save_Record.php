<!--Aaron Gockley
9/20/2024
SDEV-435-81
Argonath Inventory Management Systems
This page is for processing both Add and Updates to inventory items, not for qty updating-->

<?php

include 'utilities.php';

function PositiveOnly($fieldName) { //This tells you which field needs to be positive.
    echo "The field \"$fieldName\" must be positive.";
}

function validateInput($data, $fieldName) {
    global $errorCount;
    if ($data <= 0) {
        PositiveOnly($fieldName);
        $errorCount++;
        $retval = "";
    } else {
        $retval = $data;
    }
    return ($retval);
}

function redisplayForm($Name, $Description, $QtyOnHand, $Price){
    ?>
    <form action="Save_Record.php" method="post" enctype="multipart/form-data" > <!--This form will collect information for creating a new item in the database-->
        <input type="hidden" name="ID" value=0> <!--This seems unnecessary, but is necessary for the save_record page.-->
        Name: <input type="text" name="Name" placeholder="name" maxlength="30" required
        value="<?php echo $Name; ?>"><br>
        Description: <input type="text" name="Description" placeholder="Description" maxlength="100" required
        value="<?php echo $Description; ?>"><br>
        QtyOnHand <input type="number" name="QtyOnHand" placeholder="Qty" required
        value="<?php echo $QtyOnHand; ?>"><br>
        Price <input type="number" name="Price" placeholder="1.00" step="0.01" required
        value="<?php echo $Price; ?>"><br>
        Image: <input type="file" name="Image" required><br>
        <input type="submit" value="Submit">
    </form>
    <?php
}

if (!function_exists('exif_imagetype')) {
    function exif_imagetype($filename) {
        if ((list($width, $height, $type, $attr) = getimagesize($filename)) !== false) {
            return $type;
        }
        return false;
    }
}

function checkDuplicate($data){
    global $errorCount;
    $Connection = OpenConn();

    $SQLquery = "SELECT * FROM inventory WHERE Name='$data' ";
    $count = mysqli_query( $Connection, $SQLquery );
    if (mysqli_num_rows($count) > 0) {
        echo "Record already exists.";
        $errorCount++;
        return ($errorCount);
    }
}
function CheckImage()
{
    global $errorCount;
    global $target_file;
    $target_directory = "F:/wamp64/www/Anduin/Images/";
    $path = "/Anduin/Images/" .basename($_FILES["Image"]["name"]);
    $target_file = $target_directory . basename($_FILES["Image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION)); //This gets the extension

    if (exif_imagetype($_FILES["Image"]["tmp_name"])) { //This checks to see if the uploaded file is an image. Throws a weird error if it is a blank txt document, but still works.
        echo "File is an image.";
        $uploadOk = 1;
    } else {
        echo(exif_imagetype($_FILES["Image"]["tmp_name"]));
        echo "File is not an image.";
        $uploadOk = 0;
    }
    //This checks if the file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    //checks the size of the file.
    if ($_FILES["Image"]["size"] > 1500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    //makes sure only jpg, png, or jpeg is uploaded.
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
        echo "Sorry, only JPG and JPEG files are allowed.";
        $uploadOk = 0;
    }
    //If it does not upload, it increases the errorcount.
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
        $errorCount++;
        return ($errorCount);
    } else {
        if (move_uploaded_file($_FILES["Image"]["tmp_name"], $target_file)) {
            echo "The file " . basename($_FILES["Image"]["name"]) . " has been uploaded.";
                return ($path);
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
    /**
     * Begins by Loading all the information from either Add or Updating an item. This is where the ID
     * value comes in. A new item ID is equal to 0, which allows the if..else statement to work properly
     */

    $ID = ($_POST['ID']);
    $Name = ($_POST['Name']);
    $Description = ($_POST['Description']);
    $QtyOnHand = ($_POST['QtyOnHand']);
    $Price = ($_POST['Price']);

    /**
     * An if statement checks to see if the ID is equal to 0, which then runs a number of checks on the input.
     */
    if ($ID == 0) {
        //This checks if a real image is uploaded
        global $errorCount;
        validateInput($QtyOnHand, "QtyOnHand");
        validateInput($Price, "Price");
        checkDuplicate($Name);
        $file = CheckImage();

        if ($errorCount == 0) {

            $Connection = OpenConn();
            $SQLstring = "INSERT INTO Inventory SET
             Name = '$Name',
             Description = '$Description',
             QtyOnHand = '$QtyOnHand',
             Price = '$Price',
             ImagePath = '$file'";
            if (!mysqli_query($Connection, $SQLstring)) {
                echo "There was an error inserting your record: " . mysqli_error($Connection);
                exit();
            }
            echo "New record created successfully<br>";
            mysqli_close($Connection);
        } else {

            redisplayForm($Name, $Description, $QtyOnHand, $Price);
        }
    } else {

        /**
         * If the ID is anything other than 0, it updates the record of that particular ID
         */

        $Connection = OpenConn();
        $SQLstring = "UPDATE Inventory SET
        Name = '$Name',
        Description = '$Description',
        QtyOnHand = '$QtyOnHand',
        Price = '$Price'
        WHERE ID = $ID";

        if (!mysqli_query($Connection, $SQLstring)) {
            echo "There was an error updating your record: " . mysqli_error($Connection);

            exit();
        }
        mysqli_close($Connection);
        header('Location: Inventory_screen.php');
        exit();

    }
