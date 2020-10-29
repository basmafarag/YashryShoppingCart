<?php

require "../bootstrap.php";
require "../CartController.php";
require "../ProductController.php";

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);

$requestMethod = $_SERVER["REQUEST_METHOD"];
$requestData = json_decode(file_get_contents('php://input'));

if ($uri[1] == 'cart') {
    $cartController = new CartController($db, $requestMethod, $requestData);
    $cartController->processRequest();
} elseif ($uri[1] == 'products') {
    $productController = new ProductController($db, $requestMethod);
    $productController->processRequest();
}