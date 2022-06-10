<?php
    error_reporting(0);
    include_once $_SERVER["DOCUMENT_ROOT"]."/config.php";
    session_start();
    $USERNAME = $_SESSION['name'];
    $CART = $_SESSION['cart'];

    $QUERY = $_GET['query'];
    
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>searchresult</title>

    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="assets/css/all.css">
    <link rel="stylesheet" href="assets/css/fontawesome.css"> -->
    <link rel="stylesheet" href="assets/css/fa-all.css">
    <!-- <script src="https://kit.fontawesome.com/d8b0b605e2.js" crossorigin="anonymous"></script> -->

    <script src="assets/js/bootstrap.js"></script>
    <script scr="assets/js/bootstrap.bundle.js"></script>
    

    <style>
        .title{
            display: flex;
            justify-content: center;
            text-decoration: underline;
        }

        .row{
            width: 100vw;
        }

        #products-container{
            display: flex;
            flex-wrap: wrap;
        }

        .display-product-image{
            width: 280px;
            height: 250px;
            padding: 5%;

        }

        .display-product-name{
            padding-left: 5%;
        }

        .display-product-price{
            padding-left: 5%;
        }

        .display-div{
            border-color: black;
            border-width: thin;
            border-style: solid;
            margin-right: 15px;
            margin-top: 15px;
        }

        .product{
            margin-left: 20px;
            margin-right: 20px;
            display: flex;
            flex-wrap: wrap;
        }

        nav{
            border-bottom-style: solid;
            border-color: black;
            border-width: thin;

        }

        .sticky{
            position: sticky;
            top: 0px;
            z-index: 999;
            background-color: #e7e7e7;

        }

        
        
    </style>

</head>

<body style="background-color: white;">
    <div>
        <div>
            <?php 
            include $_SERVER["DOCUMENT_ROOT"]."/navbar.php";
            ?>
            
            <div class="container" style="margin-left:44px; margin-right:44px;" id="product-container">
                
            </div>
        </div>
    </div>
    

    <script>

    function moredetails(id,img){
        window.location=`product-details.php?id=${id}&img=${img}`;
    }

    async function displaysearchresults() {
         var query = '<?php echo $QUERY ?>';
         
         var result = await fetch(`search.php?query=${query}`);
         var data = await result.json();
         console.log(data);
         if (data.status == "success") {
             document.getElementById("product-container").innerHTML = "";
             // cannot set properties of null: document.getElementById("container") did not return anything so cannot set value of element that does not exist.
             // show direct results
             
             var precontent = `<div class="row" style="display: flex;
                                        justify-content: center;
                                        margin-left: 50px;
                                    }">
                    <h3 style="text-decoration: underline; margin-top: 8px;">Best Results:</h3>`;

                    // MVC design
                    // Model - refers to database and scripts which are responsible for database interaction (mysqli connection)
                    // View - Files which are responsible for generation of front end: user interacts directly with these
                    // Controller - files which are responsible for business logic: all major conditions (image is valid, replaced or not ect.)
                    precontent = precontent + `<div class="col-md-12" id="products-container">`;
                    data.bestproducts.forEach(product => {
                        precontent = precontent +
                            `<div class="product">
                            <div class='display-div'>
                            <img class="display-product-image" height="250px" width="270px" id="pimage" src="${product['Image Folder']}${product['Image Name']}.jpeg" alt="userimage" onclick="moredetails('${product['Id']}', '${product['Image Name']}')">
                            <br>
                            <h4 class='display-product-price' id='pprice'>${product['Price']}</h4>
                            <h4 class='display-product-name' id='pname'>${product['Product Name']}</h4>
                            </div>`;    
                            precontent = precontent + "</div>";
                        
                        
                            
                    });
                    precontent = precontent + "</div>";

                    precontent = precontent + `<h3 style="text-decoration: underline; margin-top: 8px;">Similar Results:</h3>`;
                    precontent = precontent + `<div class="col-md-12" id="products-container">`;
                    data.similarproducts.forEach(product =>{
                         // display other results if condition not met
                            
                            precontent = precontent +
                            `<div class="product" >
                            <div class='display-div'>
                            <img class="display-product-image" height="250px" width="270px" id="pimage" src="${product['Image Folder']}${product['Image Name']}.jpeg" alt="userimage" onclick="moredetails('${product['Id']}', '${product['Image Name']}')">
                            <br>
                            <h4 class='display-product-price' id='pprice'>${product['Price']}</h4>
                            <h4 class='display-product-name' id='pname'>${product['Product Name']}</h4>
                            </div>`;    
                            precontent = precontent + "</div>";
                        
                    });
                    precontent = precontent + "</div></div>";
                    
             }
             
             <?php 
                // define and pass keyword to mysqil to display similar products.
             ?>
             document.getElementById("product-container").innerHTML = precontent;

         }
         displaysearchresults();
    </script>

    <script scr="assets/js/bootstrap.bundle.min.js"></script>

    
</body>
</html>