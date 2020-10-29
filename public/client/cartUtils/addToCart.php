<?php
session_start();

if (isset($_SESSION["cart"][$_GET["id"]])) {
    $_SESSION["cart"][$_GET["id"]]["quantity"] += 1;
} else {
    $_SESSION["cart"][$_GET["id"]] = ["name" => $_GET["name"], "price" => $_GET["price"], "quantity" => 1];
}

header("Location: ../index.php");
?>