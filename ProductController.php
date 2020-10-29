<?php

require_once('ProductGateway.php');
require_once('DBController.php');

class ProductController {
    private $db;
    private $requestMethod;
    private $productGateway;

    public function __construct($db, $requestMethod) {
        $this->db = $db;
        $this->requestMethod = $requestMethod;
        $this->productGateway = new ProductGateway($db);
    }

    public function setProductGateway($productGateway) {
        $this->productGateway = $productGateway;
    }

    public function processRequest() {
        switch ($this->requestMethod) {
            case 'GET':
                $response = $this->getProducts();
        }

        header($response['status_code_header']);
        if($response['body']) {
            echo $response['body'];
        }
    }

    public function getProducts() {
        $result = $this->productGateway->getProducts();
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }
}