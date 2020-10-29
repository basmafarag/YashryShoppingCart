<?php
session_start();

$_SESSION["currency"] = [$_SESSION["currency"][1], $_GET["currency"]];

header("Location: ../index.php");
?>