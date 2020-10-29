<?php

require_once('ProductController.php');
require_once("DBController.php");
class ProductControllerTest extends \PHPUnit\Framework\TestCase
{
  public function setUp() {
        
    $this->productController = new ProductController(null, "GET", $request_data);

    $productGatewayMock = $this->getMockBuilder('ProductGateway')
    ->setMethods(array('getProducts'))
    ->disableOriginalConstructor()
    ->getMock();
    
    $productGatewayMock->expects($this->any())
    ->method('getProducts')
    ->will($this->returnValue([["id" => 1, "name" => "T-shirt", "price" => 10.99]]));
      
    $this->productController->setProductGateway($productGatewayMock);
  }

  public function tearDown() { }

  public function testGetProduct() {
      $productsMock = $this->productController->getProducts();
      $this->assertEquals($productsMock, [
          "status_code_header" => "HTTP/1.1 200 OK",
          "body" => json_encode([["id" => 1,"name" => "T-shirt","price" => 10.99,]])
        ]
    );
  }
}