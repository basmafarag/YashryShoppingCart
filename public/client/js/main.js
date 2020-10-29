console.log("main.js loaded");

 var exchange_rate = 1;
 var currency_symbol = "$";

function loadProducts() {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "http://127.0.0.1:8000/products", true);
    
    xhr.onload = function(e) {
        var products = JSON.parse(xhr.responseText);
        for (var i = 0; i < products.length; i++) {
            document.getElementById("products-display").innerHTML+= "<div style='margin-top:12px;' class='col-md-4'><div class='card' style='width: 18rem;'><div class='card-body'><h5 class='card-title'>" + products[i]["name"] + "</h5><p class='card-text'>"+ Number(((products[i]["price"]*exchange_rate)).toFixed(3)) +" "+currency_symbol+"</p><a href='cartutils/addToCart.php?id="+products[i]["id"]+"&name="+ products[i]["name"] +"&price="+ products[i]["price"] +"' class='btn btn-primary'>Add to Cart</a></div></div></div>";
        }
    }

    xhr.onerror = function(e) {
        console.error(xhr.statusText);
    }
    
    xhr.send(null);
}

function loadCart(cart) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "http://127.0.0.1:8000/cart", true);
    
    xhr.onload = function(e) {
        var formattedCart = JSON.parse(xhr.responseText);
        var tableCart = document.getElementById("table-cart");
        for (const [key, value] of Object.entries(formattedCart.items)) {
            tableCart.innerHTML+="<tr><td>"+ value["name"] +"</td><td>"+ value["quantity"] +"</td><td>"+ Number((value["price"]*value["quantity"]*exchange_rate).toFixed(3)) +" "+currency_symbol +"</td></tr>";
        }

        var discounts = "";
        for (const [key, value] of Object.entries(formattedCart.discounts)) {
            discounts+="<p>"+ value.percentage +"% off "+ value.product_name +": -"+ Number((value.value*exchange_rate).toFixed(3)) +" "+currency_symbol +"</p>";
        }

        tableCart.innerHTML+="<tr><td></td><td><b>Subtotal: </b></td><td>" + Number((formattedCart.subtotal*exchange_rate).toFixed(3)) +" "+currency_symbol + "</td></tr>";
        tableCart.innerHTML+="<tr><td></td><td><b>Tax: </b></td><td>" +Number((formattedCart.tax*exchange_rate).toFixed(3))  +" "+currency_symbol + "</td></tr>";
        tableCart.innerHTML+="<tr><td></td><td><b>Discounts: </b></td><td>"+ discounts +"</td>";
        
        tableCart.innerHTML+="</td><tr><td></td><td><b>Total: </b></td><td>" +Number((formattedCart.total*exchange_rate).toFixed(3))  +" "+currency_symbol + "</td></tr>";
    }

    xhr.onerror = function(e) {
        console.error(xhr.statusText);
    }

    xhr.send(JSON.stringify(cart));
}

function applyCurrency(currency){
    console.log(currency[0]);

    if(currency[0]== currency[1]){
        return;
    }
    if(currency[1]=="USD"){
        exchange_rate = 1;
        currency_symbol = "$";
    }
    if(currency[1]== "EGP"){
        exchange_rate = 15.7;
        currency_symbol = "e£";
    }
}
