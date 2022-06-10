<?php
    error_reporting(1);
    include_once $_SERVER["DOCUMENT_ROOT"]."/config.php";
    session_start();
    $USERNAME = $_SESSION['name'];
    $CART = $_SESSION['cart'];
    
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mainpage</title>

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
            
            <div>
            <h1 class="title"></h1>
            </div>
            
            <div class="container" style="margin-left:44px; margin-right:44px;" id="product-container">
            <div>
                <h4 class="title" style="margin-right: 13vw;">Most popular products</h4>
            </div>
                <div class="row" style="width: 50vw;
                                    margin-left: 22vw; height: 25vw;">
                    <div class="col" style="display: flex;
                                        align-items: center;">
                        <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel" style="width: 65vw;">
                            <div class="carousel-inner" style="height: 20vw;">
                            <?php
                                $stmt = $mysqli->prepare("SELECT * FROM product ORDER BY Clicks DESC LIMIT 3;");
                                $stmt->execute();
                                $data = $stmt->get_result();
                                $loop = 1;
                                while($row = $data->fetch_assoc()){
                                    $image = $row['Image Name'];
                                    $id = $row['Id'];
                                    if($loop == 1){
                                        echo "<div class='carousel-item active'>";
                                    }
                                    else{
                                        echo "<div class='carousel-item'>";
                                    }
                                        echo '<img src="images/'.$image.'.jpeg" class="d-block w-100" onclick="moredetails(\''.$id.'\',\''.$image.'\')" alt="...">
                                        </div>';
                                    $loop = $loop + 1;
                                }
                                $stmt->close();
                            ?>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                        
                    </div>
                </div>
                <div class="row" style="display: flex;
                                        justify-content: center;
                                        margin-left: 50px;
                                    }">
                    
                    <div class="col-md-9" id="products-container">
                        <!-- div container for products -->
                        <div class="product" >
                            <?php
                                $stmt = $mysqli->prepare("SELECT * FROM `product`");
                                
                                $stmt->execute();
                                $data = $stmt->get_result();
                                // RS with 15 rows and 6 columns

                                while($row = $data->fetch_assoc()){ // entire row stored as object in $row
                                    $image_name=$row["Image Name"];
                                    $image_path=$row["Image Folder"];
                                    $quantity = $row['Quantity'];
                                    
                                    
                                    $id = $row['Id'];
                                    if($quantity <= 0){ // why all 0?
                                        echo "<div class='display-div' style='opacity: .5;'>";
                                    }
                                    else{
                                        echo "<div class='display-div'>";
                                    }
                                    echo '<img class="display-product-image" height="250px" width="270px" id="pimage" src="'.$image_path.$image_name.'.jpeg" alt="userimage" onclick="moredetails(\''.$id.'\',\''.$image_name.'\')">';
                                    // echo '<img class="display-product-image" src="display-image.php?Id='.$id.'" alt="userimage">';
                                    echo "<br>";
                                    // echo "<div class='container'>";
                                    // echo "<div class='row' style='width: 100%;'>";
                                    
                                    echo "<div>";

                                    echo "<div style='display: flex; justify-content: space-between;'>";
                                    echo "<h4 class='display-product-price' id='pprice'>".$row['Price']."</h4>";
                                    if($quantity == 0){
                                        echo "<h4 style='margin-right: 5%;'>Out of Stock</h4>";
                                    }
                                    echo "</div>";

                                    echo "<h4 class='display-product-name' id='pname'>".$row['Product Name']."</h4>";
                                    echo "</div>";

                                    
                                    //if()
                                    // echo "<div class='col-md-6'>";
                                    // echo "<h3> </h3>";
                                    echo "</div>";
                                    
                                    // echo "</div>";
                                    // echo "</div>";
                                    
                                }
                                
                                

                                // $stmt = $mysqli->prepare("SELECT * FROM `product images` WHERE `Id` = ?");
                                // $stmt->bind_param("s", $row['Id']);
                                // $stmt->execute();
                                // $data2 = $stmt->get_result();
                                // $row2 = $data2->fetch_assoc();


                                
                            ?>
                            
                        
                        </div>
                        
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    

    <script>

    function moredetails(id,img){
        window.location=`product-details.php?id=${id}&img=${img}`;
    }

    </script>

    <script scr="assets/js/bootstrap.bundle.min.js"></script>
    
</body>
</html>