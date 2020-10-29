<?php
require_once('DBController.php');

class ProductGateway {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getProducts() {
        $statement = "SELECT * FROM products;";
        $statement = $this->db->query($statement);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    }

}