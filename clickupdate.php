<?php
    include_once $_SERVER["DOCUMENT_ROOT"]."/config.php";
    $Id = $_GET['id'];
    $stmt = $mysqli->prepare("UPDATE product SET Clicks = Clicks + 1 WHERE Id = ?");
    $stmt->bind_param("s", $Id);                            
    $result = $stmt->execute();

    if($result > 0){
        $arr = array();
        $arr['status'] = 200;
        echo json_encode($arr);
    }

?>