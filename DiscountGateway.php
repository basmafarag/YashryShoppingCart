<?php
require_once('DBController.php');

class DiscountGateway {

    public function __construct($db) {
        $this->db = $db;
    }

    public function getProductDiscount($product_id) {
        $statement = "SELECT * FROM discounts WHERE product_id='" . $product_id . "'";
        $statement = $this->db->query($statement);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    }

}