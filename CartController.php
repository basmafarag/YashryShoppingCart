<?php

require_once('DiscountGateway.php');
require_once('DBController.php');

class CartController {

    const TAX_RATE = 0.14;

    private $db;
    private $requestMethod;
    private $requestData;
    private $discountGateway;

    public function __construct($db, $requestMethod, $requestData) {
        $this->db = $db;
        $this->requestMethod = $requestMethod;
        $this->requestData = $requestData;
        $this->discountGateway = new DiscountGateway($db);
    }

    public function setDiscountGateway($discountGateway) {
        $this->discountGateway = $discountGateway;
    }

    public function processRequest() {
        switch ($this->requestMethod) {
            case 'POST':
                $response = $this->getCart();
        }

        header($response['status_code_header']);
        if($response['body']) {
            echo $response['body'];
        }
    }

    /* TODO: add items to cart database for anonymous metrics */

    private function getCart() {
        $cart = $this->requestData;
        $result = $this->formatCart($cart);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    public function formatCart($cart) {
        $cartArray = json_decode(json_encode($cart), true);
        
        $subtotal = $this->calculateSubtotal($cartArray);
        $tax = $subtotal * self::TAX_RATE;
        $discounts = $this->calculateDiscounts($cartArray);
        $offers = $this->calculateOffers($cartArray);
        $discountsAndOffers = array_merge($discounts, $offers);
        $total = $this->calculateTotal($subtotal, $tax, $discountsAndOffers);

        $formattedCart = [
            "items" => $cartArray,
            "subtotal" => $subtotal,
            "tax" => $tax,
            "discounts" => $discountsAndOffers,
            "total" => $total,
        ];

        return $formattedCart;
    }

    public function calculateSubtotal($cart) {
        $subtotal = 0;
        foreach ($cart as $cartItem) {
            $subtotal += ($cartItem["price"] * $cartItem["quantity"]);
        }
        return $subtotal;
    }

    public function calculateDiscounts($cart) {
        $discounts = [];
        foreach ($cart as $key => $cartItem) {
            /* CONSTRAINT: product can have only one discount */
            
            $discount = $this->discountGateway->getProductDiscount($key);
            if ($discount) {
                if ($discount[0]["product_id"] == $key) {    
                    $discountArray = [
                        "percentage" => $discount[0]["percentage"],
                        "product_name" => $cartItem["name"],
                        "value" => ($discount[0]["percentage"] * 0.01) * $cartItem["quantity"] * $cartItem["price"],
                    ];
                    array_push($discounts, $discountArray);
                }
            }
        }
        return $discounts;
    }

    public function calculateOffers($cart) {
        $available_offers = [
            [
                "buy" => [
                    "product_id" => 1, #T-shirt
                    "quantity"   => 2,
                ],
                "get" => [
                    "product_id" => 3, #Jacket 
                    "percentage" => 50
                ],
            ]
        ];

        $discounts = [];

        /* CONSTRAINT: An offer can only be applied once */
        foreach ($available_offers as $offer) {
            if (isset($cart[$offer["buy"]["product_id"]])) {
                if ($offer["buy"]["quantity"] <= $cart[$offer["buy"]["product_id"]]["quantity"]) {
                    if (isset($cart[$offer["get"]["product_id"]])) {
                        $percentage = $offer["get"]["percentage"];
                        $product = $cart[$offer["get"]["product_id"]];
                        $discountArray = [
                            "percentage" => $percentage,
                            "product_name" => $product["name"],
                            "value" => ($percentage * 0.01) * $product["price"],
                        ];
                        array_push($discounts, $discountArray);
                    }
                }
            }
        }

        return $discounts;
    }

    public function calculateTotal($subtotal, $tax, $discounts) {
        $total_discounts = 0;
        foreach ($discounts as $discount) {
            $total_discounts += $discount["value"];
        }

        return $subtotal + $tax - $total_discounts;
    }
}