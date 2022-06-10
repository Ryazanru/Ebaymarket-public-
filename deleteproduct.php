<?php
    require_once $_SERVER["DOCUMENT_ROOT"]."/config.php";
    include_once $_SERVER["DOCUMENT_ROOT"]."/transaction.php"; // include_once will show warning but run, require_once will throw error and stop code execution
    $product = $_GET['product'];
    session_start();
    if(!$_SESSION['isLoggedIn']){
        echo "<script>window.location = 'login.php'</script>";
    }
    $Username = $_SESSION['name'];

    try{
        // unlinkage of images from pc storage

        $stmt3 = $mysqli->prepare("SELECT `Image Name` FROM product WHERE Id = ?");
        $stmt3->bind_param("s", $product);
        $stmt3->execute();
        $data = $stmt3->get_result();
        if($row = $data->fetch_assoc()) {
            $image = $row['Image Name'];
            if(file_exists("images/".$image.".jpeg")){ // always check if file exists
                unlink("images/".$image.".jpeg");
            }
        }
        $stmt3->close();

        $stmt4 = $mysqli->prepare("SELECT Img FROM `product images` WHERE Id = ?");
        $stmt4->bind_param("s", $product);
        $stmt4->execute();
        $data2 = $stmt4->get_result();
        while($row2 = $data2->fetch_assoc()){
            $image2 = $row2['Img'];
            if(file_exists("images/".$image2.".jpeg")){
                unlink("images/".$image2.".jpeg");
            } 
        }
        $stmt4->close();
        
        
        // Deletion of product and images

        $stmt2 = $mysqli->prepare("DELETE FROM `product images` WHERE Id = ?");
        $stmt2->bind_param("s", $product);
        $result2 = $stmt2->execute();
        $stmt2->close();

        $stmt = $mysqli->prepare("DELETE FROM product WHERE Id = ? and Username = ?");
        $stmt->bind_param("ss", $product, $Username);
        $result = $stmt->execute(); // runs immediatly
        $stmt->close();

        
        if($result > 0 && $result2 > 0){ // if both statements return something greater than 0
            $arr = array();
            $arr['status'] = 200;
            echo json_encode($arr);
        }
        else{
            $arr = array();
            $arr['status'] = 401;
            echo json_encode($arr);
        } 
        
    }
    catch(Throwable $e){
        $arr = array();
        $arr['error'] = $e -> getMessage();
        echo json_encode($arr);
    }
    finally{
        $mysqli->close();
    }
    



?>