<?php
    error_reporting(0);
    include_once $_SERVER["DOCUMENT_ROOT"]."/config.php";
    session_start();
    $USERNAME = $_SESSION['name'];
    $id = $_GET['id'];
    $img = $_GET['img'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>product-details</title>
</head>

<link rel="stylesheet" href="assets/css/bootstrap.min.css">
<!-- <link rel="stylesheet" href="assets/css/all.css">
<link rel="stylesheet" href="assets/css/fontawesome.css"> -->
<link rel="stylesheet" href="assets/css/fa-all.css">

<script src="assets/js/bootstrap.js"></script>
<script scr="assets/js/bootstrap.bundle.js"></script>

<!-- <script src="https://kit.fontawesome.com/d8b0b605e2.js" crossorigin="anonymous"></script> -->


<style>
nav {
    border-bottom-style: solid;
    border-color: black;
    border-width: thin;

}

.sticky {
    position: sticky;
    top: 0px;
    z-index: 999;
    background-color: #e7e7e7;

}

.row {
    width: 100vw;
}

.productdesc {
    overflow-wrap: break-word;
}

.productdiv1 {
    border-color: black;
    border-style: solid;
    border-width: 1px;
    margin-top: 30px;


    padding: 10px;
}

.productdiv2 {
    border-color: black;
    border-style: solid;
    border-width: 1px;
    margin-top: 30px;


    padding: 10px;
}
</style>




<body style="background-color: white;" >
    <div>
        <div>


            <?php
        include $_SERVER["DOCUMENT_ROOT"]."/navbar.php";
        ?>
            <br>
            <div>
                <div class="container" style="width: 65vw; margin-left: 0%;" id="product-container">

                    <div class="row">
                        <div class="col" style="display: flex; justify-content: center;">
                            <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel"
                                style="width: 65vw;">
                                <div class="carousel-inner" style="height: 50vh;">
                                    <div class='carousel-item active'>
                                        <img src="images/<?php echo $img ?>.jpeg" class='d-block w-100' alt="">;
                                    </div>

                                    <?php
                             $stmt = $mysqli->prepare("SELECT * FROM `product images` WHERE `Id` = ?");
                             $stmt->bind_param("s", $id);
                             $result = $stmt->execute();

                             $data = $stmt->get_result();
                             $count = 1;
                                
                                
                             while($row = $data->fetch_assoc()){ // 6f-> 
                                
                                echo "<div class='carousel-item'>";
                                echo "<img src=images/{$row['Img']}.jpeg class='d-block w-100' alt={$count}>";
                                echo "</div>";
                                $count = $count+1; // 3
                             }
                        ?>
                                    <!-- <div class="carousel-item active">
                                <img src="images/placeholder2.jpeg" class="d-block w-100" alt="...">
                            </div>
                            <div class="carousel-item">
                                <img src="images/placeholder2.jpeg" class="d-block w-100" alt="...">
                            </div>
                            <div class="carousel-item">
                                <img src="images/placeholder2.jpeg" class="d-block w-100" alt="...">
                            </div> -->
                                </div>
                                <button class="carousel-control-prev" type="button"
                                    data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button"
                                    data-bs-target="#carouselExampleControls" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>


                        </div>
                    </div>




                </div>
                <div class="container" style="width:65vw;" >
                    <div class="row" style="width:65vw;">
                        <div class="col-md-8 productdiv1">

                            <?php
                        $stmt2 = $mysqli->prepare("SELECT * FROM `product` WHERE `Id` = ?");
                        $stmt2->bind_param("s", $id);
                        $result2 = $stmt2->execute();

                        $data2 = $stmt2->get_result();
                        $row2 = $data2->fetch_assoc();

                        $productname = $row2['Product Name'];
                        $productdetails = $row2['Description'];
                        $quantity = $row2['Quantity'];
                        
                        
                        echo "<h3 style='text-decoration: underline;'> {$productname} </h3>";
                        echo "<br>";
                        if($quantity < 5 && $quantity > 0){
                            echo "<h5 style='color:red'> Only {$quantity} left </h5>";
                        }
                        
                        echo "<p class='productdesc'> Description: {$productdetails} </h3>";


                    ?>




                        </div>
                        <div class="col-md-4 productdiv2">

                            <?php
                                
                                $ID = $id;
                                
                                

                                $price = $row2['Price'];
                                $user = $row2['Username'];
                                $product = $row2['Product Name'];
                                $image = $row2['Image Name'];
                                

                                

                                echo "<h2 style='text-decoration: underline'> {$price} </h2>";
                                echo "<br>";
                                echo "<h5> Sold By: {$user} </h5>";
                                echo "<br>";
                                if($quantity > 0 && $_SESSION['isLoggedIn']){
                                    echo '<button class ="btn btn-outline-success" id="addtocart" style="margin-bottom: 5px;width: 100%;" onclick="addto(\''.$product.'\', \''.$user.'\', \''.$image.'\', \''.$ID.'\', \''.$price.'\')"> Add to Cart</button>';
                                echo "<button class='btn btn-outline-primary' id='offerbtn' style='width: 100%' onclick='offer()'> Make Offer</button>";
                                echo "<div style='display: none;' id='offerdiv'>";
                                echo "<label for='offerfield'> Your offer: </label>";
                                echo "<input type='number' id='offerfield' style='margin-left: 5px; margin-bottom: 5px;'>";
                                echo "<button class='btn btn-outline-success' style='width: 100%' onclick='submit()'> Submit</button>";
                                echo "</div>";
                                }
                                else if($quantity < 0){
                                    echo "<h5 style='color:red'>Out of Stock! </h5>";
                                }
                                else{
                                    echo "<p>Please <a href='https://ebaymarket.ml/login.php'>log in</a> to purchase item </p>";
                                }
                                

                            ?>




                        </div>
                    </div>

                </div>
            </div>

        </div>



        <script>
        function offer() {
            document.getElementById("offerbtn").style.display = "none";
            document.getElementById("offerdiv").style.display = "unset";

        }

        async function submit() {
            var offeramount = document.getElementById("offerfield").value;
            var id = "<?php echo $ID; ?>";
            var name = "<?php echo $user; ?>";
            var product = "<?php echo $product; ?>";
            
            // window.location=`mail.php?id=${id}&name=${name}&offeramount=${offeramount}&product=${product}`;
            var result = await fetch(
            `mail.php?id=${id}&name=${name}&offeramount=${offeramount}&product=${product}`);
            var data = await result.json();

            if (data.status == 200) {
                alert("offer uploaded successfully");
                window.location = "mainpage.php";
            } else if(data.status == 0){
                alert("Product out of stock");
            } else if(data.status == 1){
                alert("Invalid offer amount");
            } 
            else{
                alert("error occured, please try again later");
            }
            



        }

        async function addto(product, username, image_name, id, price) {
            var result = await fetch(
                `addtocart.php?product=${product}&username=${username}&image_name=${image_name}&id=${id}&price=${price}`
                );
            var data = await result.json();
            console.log(data);

            if (data.error) {
                alert("error occured");
                console.log(data.error);
            } else {
                alert("Item added successfully");
                var cartitems = document.getElementById("lblCartCount").innerText; // 0
                var cartitems = parseInt(cartitems) + 1;
                document.getElementById("lblCartCount").innerText = cartitems;
            }

            // cart = [['id'='1', 'name'='abc'], ['id'='2', 'name' = 'xyz']] multidimentinal array

        }
        </script>

        <script scr="assets/js/bootstrap.bundle.min.js"></script>

        <script>
            window.addEventListener('load', async (event) =>{
                var id = "<?php echo $id; ?>";
                var result = await fetch(`clickupdate.php?id=${id}`);
                var data = result.json();
                console.log(data);
            });
            // window.addEventListener('load', incrementclick());
            // function incrementclick(){
            //     var id = "";
            //     var result = await fetch(`clickupdate.php?id=${id}`);
            //     var data = result.json();
            //     console.log(data);
            // }
            </script>
</body>

</html>