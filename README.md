# yashry
# Descripition
Implementing shopping cart using php and Javascript. The user can add items to the cart and the view the detailed bill which will contain the prices, taxes, and discounts if any. There can be more than one discount being applied on the cart. The user don't have to sign in to be able to add items to the cart.

Our solution for the cart focus mainly on the backend and implementing APIs for the products, discounts, and the cart with simple user interface using javascript.

one of the tradeoffs I didn't create database for the different kinds of discounts to be able to add for the database easily as it will be more complex than just implementing APIs on the availiable discounts.

If I had more time, I would handled the exceptions, and work on more use cases. And saved the cart in the database to keep matrix of the cart. And also add authentication to the backend so no other clients can communicate to the backend

# How to run the project
* Clone the repo "git clone //JJKB  
* Add the project folder in xaamp/htdocs folder
* Run xaamp on your PC
* Make sure in the DBController the username and password match your username and password in phpmyadmin
* Create a database in phpmyadmin and name it "yashry"
* Import from folder SQL the two files in your database (discounts.sql,products.sql)
* Run the following line in the terminal of the project "php -S 127.0.0.1:8000 -t public"
* Redierct to the following link to open the application "http://localhost/yashry/public/client/index.php"

# How to run tests
* you can run the CartControllerTest by using this command "./vendor/bin/phpunit tests/CartControllerTest.php;"
* you can run the ProductControllerTest by using this command "./vendor/bin/phpunit tests/ProductControllerTest.php;"


# Demo

![alt text](https://github.com/basmafarag/YashryShoppingCart/blob/master/README_Images/1.png?raw=true)

This is a new cart with new session


![alt text](https://github.com/basmafarag/YashryShoppingCart/blob/master/README_Images/2.png?raw=true)

Cart total price after adding 2 T-shirts, 1 Jacket, and 1 Shoes and applying the offers.

![alt text](https://github.com/basmafarag/YashryShoppingCart/blob/master/README_Images/3.png?raw=true)

Cart total after changing the currency from USD to EGP.