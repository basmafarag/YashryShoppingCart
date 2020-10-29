<?php

require_once('CartController.php');
require_once("DBController.php");
class CartControllerTest extends \PHPUnit\Framework\TestCase
{
  public function setUp() {
    
    $request_data = '{"1":{"name":"T-shirt","price":"10.99","quantity":5},"3":{"name":"Jacket","price":"19.99","quantity":1},"4":{"name":"Shoes","price":"24.99","quantity":1}}';
    
    $this->cartController = new CartController(null, "POST", $request_data);
    $this->cart = json_decode($request_data, true);
    
    $discountGatewayMock = $this->getMockBuilder('DiscountGateway')
    ->setMethods(array('getProductDiscount'))
    ->disableOriginalConstructor()
    ->getMock();

    $discountGatewayMock->expects($this->any())
    ->method('getProductDiscount')
    ->will($this->returnValue([["product_id"=> 1, "percentage"=>50]]));
      
    $this->cartController->setDiscountGateway($discountGatewayMock);
  }

  public function tearDown() { }  

  public function testFormatCart() {
    $formattedCartMock = $this->cartController->formatCart($this->cart);
    $this->assertEquals($formattedCartMock,[
      "items" => [
        "1" => [
          "name" => "T-shirt",
          "price" => "10.99",
          "quantity" => 5
        ],
        "3" => [
          "name" => "Jacket",
          "price" => "19.99",
          "quantity" => 1,
        ],
        "4" => [
          "name" => "Shoes",
          "price" => "24.99",
          "quantity" => 1,
        ],
      ],
      "subtotal" => 99.92999999999999,
      "tax" => 13.9902,
      "discounts" => [
        ["percentage" => 50, "product_name" => "T-shirt", "value" => 27.475],
        ["percentage" => 50, "product_name" => "Jacket", "value" => 9.995],
      ],
      "total" => 76.4502,
    ]);

  }

  public function testCalculateSubtotal() {
    $subtotalMock = $this->cartController->calculateSubtotal($this->cart);
    $this->assertEquals($subtotalMock, 99.93);
  }

  public function testCalculateDiscounts() {

    $discountsMock = $this->cartController->calculateDiscounts($this->cart);
    
    $this->assertEquals($discountsMock, [
      [
        "percentage" => 50,
        "product_name" => "T-shirt",
        "value" => 27.475,
      ]
    ]);
  }

  public function testCalculateOffers() {
    $offersMock = $this->cartController->calculateOffers($this->cart);
    $this->assertEquals($offersMock,
      [
        [
          "percentage" => 50,
          "product_name" => "Jacket",
          "value" => 9.995,
        ]
      ]
    );
  }
    
  public function testCalculateTotal() {
    $discountsMock = [[
      "percentage" => 10,
      "product_name" => "T-shirt",
      "value" => 1,
    ]];

    $total = $this->cartController->calculateTotal(12,2,$discountsMock);
    $this->assertEquals($total,13);
  }

}

?>
