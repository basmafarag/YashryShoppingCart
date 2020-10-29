<?php
session_start();

if(!isset($_SESSION["cart"])){
    $_SESSION["cart"]  = [];
}

if(!isset($_SESSION["currency"])){
    $_SESSION["currency"]  = ["USD","USD"];
    
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Yashry Shopping Cart</title>
        <meta charset="utf-8"><meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
        <script src="js/main.js"></script>
        <script> var currency = <?php echo json_encode($_SESSION["currency"]); ?>;
        applyCurrency(currency);
        
        </script>

    </head>
    
    <body>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">Yashry Shopping Cart</a>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav mr-auto"></ul>
                <span class="navbar-text">
                    <a href="cartUtils/changeCurrency.php?currency=EGP" style="margin-right: 10px;">EGP</a>
                    <a href="cartUtils/changeCurrency.php?currency=USD" style="margin-right: 10px;">USD</a>
                </span>
            </div>
        </nav>

        <div class="container" style="margin-top: 30px;">

            <!-- products goes here -->

            <div class="row" id="products-display">
            <script> loadProducts(); </script>
            </div><!-- row -->

            <!-- cart goes here -->
            <div class="row" style="margin-top: 40px;">
                <h2>Cart</h2>

                <table id="table-cart" class="table table-striped">
                <script>
                    var cartJson = <?php echo json_encode($_SESSION["cart"]); ?>;
                    loadCart(cartJson);
        </script>

                </table>
                <a style="margin-bottom: 20px;" href="cartutils/clearCart.php">clear cart</a>
            </div><!-- row -->
        
        </div><!-- container -->

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    </body>
</html>


