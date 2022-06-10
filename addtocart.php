<?php
    include_once $_SERVER["DOCUMENT_ROOT"]."/config.php";
    $product = $_GET['product'];
    $username = $_GET['username'];
    $imagename = $_GET['image_name'];
    $id = $_GET['id'];
    $price = $_GET['price'];
    session_start();
    $cart = $_SESSION['cart']; // in cart variable

    /*
        $_SESSION['cartarray'] = {
            "IDABCD" => [prodname, username, imagename, id, price,quantity],
            "IDXYZ" => [prodname, username, imagename, id, price,quantity],
            "IDPKLS" => [prodname, username, imagename, id, price,quantity]
        }
    */

    try{
        
        if(isset($_SESSION['cartarray']) && isset($_SESSION['cartarray'][$id])){ // if cartarray already exists and current item id is within cartarray
            $currquantity = $_SESSION['cartarray'][$id][4];
            $_SESSION['cartarray'][$id][4] = $currquantity+1;
        }
        else{
            $new = array($product, $username, $imagename, $price, 1, $id); // item
            $_SESSION['cartarray'][$id] = $new;
        }
        

        $_SESSION['cart'] = $cart+1; // update with new cart item

        echo json_encode($_SESSION['cartarray']); // return as json for checking
    }
    catch(throwable $e){
        $arr = array();
        $arr['error'] = $e -> getMessage();
        echo json_encode($arr);
    }
    
    
    
    

?>