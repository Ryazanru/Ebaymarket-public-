<?php
    include_once $_SERVER["DOCUMENT_ROOT"]."/config.php";

    if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['submit'])){
        $EMAIL = $_POST['email'];
        $NAME = $_POST['name'];
        $PASSWORD = md5($_POST['password']);

        $stmt = $mysqli->prepare("INSERT INTO credentials (`Name`, `Email`, `Password`) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $NAME, $EMAIL, $PASSWORD);
        
        $result = $stmt->execute(); // returns true or false if query ran or not. 1 row affected/ row not affected

        // $data = $stmt->get_result(); // if SELECT statement, getresult retrieves resultset[rows and columns]
        if($result){
            session_start();
            $_SESSION['name'] = $NAME;
            echo "<script>alert('Registration successful!')</script>";
            echo "<script>window.location='mainpage.php'</script>";
        }
        else{
            echo "<script>alert('Error occured')</script>";
            echo $stmt->error;
        }
    }
?>