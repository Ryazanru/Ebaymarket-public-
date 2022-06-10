<?php
include_once $_SERVER["DOCUMENT_ROOT"]."/config.php";

    if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['submit'])){
        $EMAIL = $_POST['email'];
        $PASSWORD = md5($_POST['password']);
        
        // $stmt = $mysqli->prepare("INSERT INTO test(id, label) VALUES (?, ?)");

/* Prepared statement, stage 2: bind and execute */
// $id = 1;
// $label = 'PHP';
// $stmt->bind_param("is", $id, $label); // "is" means that $id is bound as an integer and $label as a string

// $stmt->execute(); 

        $stmt = $mysqli->prepare("SELECT * FROM credentials WHERE Email = ? and Password = ?");
        $stmt->bind_param("ss", $EMAIL, $PASSWORD);
        $stmt->execute();

        $data = $stmt->get_result();
        if($row = $data->fetch_assoc()) {
            session_start();
            $_SESSION['email'] = $row['Email'];
            $_SESSION['name'] = $row['Name'];
            $_SESSION['cart'] = 0;
            $_SESSION['cartarray'] = array();
            $_SESSION['isLoggedIn'] = true;
            echo "<script> alert('Login successful') </script>";
            echo "<script> window.location='mainpage.php' </script>";
        }
        else{
            echo "<script> alert('Error occured') </script>";
        }

    }



?>