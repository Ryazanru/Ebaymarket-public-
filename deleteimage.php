<?php
    include_once $_SERVER["DOCUMENT_ROOT"]."/config.php";
    $image = $_GET['image'];

    $stmt = $mysqli->prepare("DELETE FROM `product images` WHERE Img = ?");
    $stmt->bind_param("s", $image);
    $result = $stmt->execute();

    if(!$result){
        $arr = array();
        $arr['status'] = 99;
        $arr['message'] = "error";
        echo json_encode($arr);
    }
    else{
       $arr = array();
       $arr['status'] = 200;
       $arr['message'] = "success";
       echo json_encode($arr);

    }

?>