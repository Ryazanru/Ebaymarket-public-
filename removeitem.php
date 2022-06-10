<?php
    session_start();
    if(!$_SESSION['isLoggedIn']){
        echo "<script>window.location = 'login.php'</script>";
    }
    $id = $_GET['key'];
    $cart = $_SESSION['cart']; // 5
    $currquantity = $_GET['currquantity'];

    try{
        if($currquantity > 1){
            $quantity = $_SESSION['cartarray'][$id][4];
            $_SESSION['cartarray'][$id][4] = $quantity-1;   
        }
        else{
            unset($_SESSION['cartarray'][$id]);
        }
        $cart = ($cart -1); // 4
        $_SESSION['cart'] = $cart; // 4

        $arr = array(); // php array
             $arr['status'] = 200;
             $arr['message'] = "Success";
            echo json_encode($arr);
            
            http_response_code(200);
    }catch(Throwable $e){
        $arr = array();
             $arr['status'] = 99;
             $arr['message'] =  "Error";
            echo json_encode($arr);
            http_response_code(404);
    }
    

    



?>