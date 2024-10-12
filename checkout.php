<?php
session_start();
include 'utilities.php';

front_header('Checkout') ?>


<div class="checkout content-wrapper">
    <h1>Checkout</h1>
    <form action="placeorder.php" method="post">
        First Name: <input type="text" name="first" placeholder="first name" maxlength="25" required><br>
        Last Name: <input type="text" name="last" placeholder="last name" maxlength="24" required><br>
        Email Address: <input type="email" name="email" placeholder="email" required><br>
        Street Address: <input type="text" name="address" placeholder="street address" required><br>
        State: <input type="text" name="state" placeholder="st" maxlength="2" required><br>
        Zip Code: <input type="text" name="zip" placeholder="zip code" maxlength="5" required><br>
        Phone Number: <input type="tel" name="phone" required><br>
        <input type="submit" value="Submit">
    </form>
</div>