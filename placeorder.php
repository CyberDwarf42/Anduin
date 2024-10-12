<?php
session_start();
include 'utilities.php';

front_header('placeorder');


$products_in_cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
$products = array();
foreach ($products_in_cart as $product) {
    echo $product;
}