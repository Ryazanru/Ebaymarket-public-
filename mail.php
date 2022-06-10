<?php
    include_once $_SERVER["DOCUMENT_ROOT"]."/config.php";
    session_start();
    $USEREMAIL = $_SESSION['email'];
    $creds_json = file_get_contents("credentials.json");
    $creds = json_decode($creds_json, true);

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'vendor/autoload.php';

    $mail = new PHPMailer(true);
    $ID = $_GET['id'];
    $NAME = $_GET['name']; // owner user
    if($_GET['offeramount'] <= 0 || !is_numeric($_GET['offeramount'])){
        $arr = array();
        $arr['status'] = 1;
        $arr['message'] = "invalid offer amount";
        echo json_encode($arr);
        exit();
    }
    else{
        $OFFER = $_GET['offeramount'];
    }
    $PRODUCT = $_GET['product']; // %Iphone% error
    try{
        $stmt = $mysqli->prepare("SELECT * FROM `credentials` WHERE `Name` = ?");
    $stmt->bind_param("s", $NAME);
    $stmt->execute();
    $data = $stmt->get_result();
    $stmt->close();

    $stmt = $mysqli->prepare("SELECT `Quantity` FROM `product` WHERE `Id` = ?");
    $stmt->bind_param("s", $ID);
    $stmt->execute();
    $data2 = $stmt->get_result();
    $row2 = $data2->fetch_assoc();
    if($row2['Quantity'] <= 0){
        $arr = array();
            $arr['status'] = 0;
            $arr['message'] = "Product is out of stock!";
        echo json_encode($arr);
        exit();    
    }

    if($row = $data->fetch_assoc()){
        $Email = $row['Email']; // owner user email

        try{
            $mail->SMTPDebug = 0;									
            $mail->isSMTP();											
            $mail->Host	 = 'smtp.gmail.com;';					
            $mail->SMTPAuth = true;							
            $mail->Username = $creds['email'];				
            $mail->Password = $creds['password'];						
            $mail->SMTPSecure = 'tls';							
            $mail->Port	 = 587;
    
            $mail->setFrom($creds['email'], 'Ebay Market');
            $mail->addaddress($Email);
    
            $mail->isHTML(true);								
            $mail->Subject = "User {$NAME} has made an offer!";
            $mail->Body = "User {$NAME} has made an offer of {$OFFER} for {$PRODUCT}. <br> You can contact them at {$USEREMAIL}.";
            $mail->AltBody = "User {$NAME} has made an offer of {$OFFER} for {$PRODUCT}. \r\nYou can contact them at {$USEREMAIL}.";
            $mail->send();
    
            $arr = array(); // php array
             $arr['status'] = 200;
             $arr['message'] = "success";
            echo json_encode($arr);
            
            http_response_code(200);
    
    
        }catch(Exception $e){
            $arr = array();
             $arr['status'] = 99;
             $arr['message'] =  "Mailer Error: {$mail->ErrorInfo}";
            echo json_encode($arr);
            http_response_code(503);
        }
    }
    else{
        echo "<script> alert('error occured'); console.log($mysqli->error()) </script>";
    }
    }catch(Exception $e){
        $arr = array();
        $arr['status'] = 99;
        $arr['message'] = "error occured: {$e->getMessage()}";
        echo json_encode($arr);
        http_response_code(503);
        
    }finally{
        $mysqli->close();
        $stmt->close();
    }
    


    

?>