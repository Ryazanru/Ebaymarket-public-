<?php
    include_once $_SERVER["DOCUMENT_ROOT"]."/config.php";

    $id = $_GET['Id'];
    if(!empty($id)){
        $stmt = $mysqli->prepare("SELECT `Image` FROM `product` WHERE `Id` = ?");
        $stmt->bind_param("s", $id);
        $stmt->execute();

        $data = $stmt->get_result();
        $row = $data->fetch_assoc();

        header("Content-type: image/jpg");
        echo $row['Image'];

    }

?>