<?php 
error_reporting(0);
    include_once $_SERVER["DOCUMENT_ROOT"]."/config.php";
    session_start();
    if(!$_SESSION['isLoggedIn']){
        echo "<script>window.location = 'login.php'</script>";
    }
    $Username = $_SESSION['name'];
    
    
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>myuploads</title>

    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
<!-- <link rel="stylesheet" href="assets/css/all.css"> -->
<!-- <link rel="stylesheet" href="assets/css/fontawesome.css"> -->
<!-- <script src="https://kit.fontawesome.com/d8b0b605e2.js" crossorigin="anonymous"></script> -->
    <link rel="stylesheet" href="assets/css/fa-all.css">

<script src="assets/js/bootstrap.js"></script>
<script scr="assets/js/bootstrap.bundle.js"></script>

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

.divstyle {

    margin: 12%;
    border: black;
    border-style: solid;
    border-width: 1px;
    padding: 4%;
    background-color: beige;
}

.display-product-image{
    width: 100%;
    height: 250px;
    padding: 5%;
}

.display-product-name{
    padding-left: 5%;
}

.display-product-price{
    padding-left: 5%;
}

.buttonstyle{
    margin-bottom: 5%;
    width: 25%; 
    margin-left: 5%;
}


</style>
</head>



<body style="background-color:aqua;">
    <?php
            include_once $_SERVER["DOCUMENT_ROOT"]."/navbar.php";
        ?>
        <div class="divstyle">
            <div class="container" id="product-container">
                <div class="row">
                    
                        
                        <?php
                        
                            $stmt = $mysqli->prepare("SELECT * FROM product WHERE Username = ?");
                            $stmt->bind_param("s", $Username);
                            $stmt->execute();

                            $data = $stmt->get_result();
                            while($row = $data->fetch_assoc()){
                                $image_path = $row['Image Folder'];
                                $image_name = $row['Image Name'];
                                $product = $row['Product Name'];
                                $price = $row['Price'];
                                $description = $row['Description'];
                                $quantity = $row['Quantity'];
                                $prodid = $row['Id'];
                                
                                
                                echo "<div class='col-md-6' id='".$prodid."'>";

                                    echo "<div class='container' style='border: solid 1px'>";

                                        echo "<div class='row'>";

                                            echo "<div class='col-md-7'>";
                                            echo '<img class="display-product-image" id="pimage" src="'.$image_path.$image_name.'.jpeg" alt="userimage">';
                                            echo "</div>";

                                            echo "<div class='col-md-5' style='margin-top: 5%;'>";
                                            echo "<h4 class='display-product-price' id='pprice'>".$price."</h4>";
                                            echo "<h4 class='display-product-name' id='pname'>".$product."</h4>";
                                            echo "<br>";
                                            echo "<br>";
                                            echo "<br>";
                                            
                                            echo "<button class='btn btn-danger' onclick='deleteproduct(`$prodid`)'>Delete</button>";
                                            echo "<button class='btn btn-primary' style='margin-left:5px;' onclick='editproduct(`$prodid`)'>Edit</button>";
                                            
                                            
                                            echo "</div>";
                                
                                        echo "</div>";
                                    echo "</div>";
                                    echo "<br>";
                                echo "</div>";
                                
                                

                                
                            }

                        ?>
                        
                        
                    
                </div>
            </div>
        </div>
    





</body>
<script>
    async function deleteproduct(product){

        
        var result = await fetch(`deleteproduct.php?product=${product}`);
        var data = await result.json();
        
        if(data['status'] == 200){
            alert("product deleted!");
            document.getElementById(product).hidden = true;
        }
        else{
           alert("error occured");
        }

    }

    function editproduct(product){
        window.location=`editproduct.php?product=${product}`;
    }

</script>

</html>