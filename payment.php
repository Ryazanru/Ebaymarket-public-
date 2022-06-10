<?php

include_once $_SERVER["DOCUMENT_ROOT"]."/config.php";
    session_start();
    $seller = $_POST['seller'];
    $mailbody = $_POST['msgbody'];
    $creds_json = file_get_contents("credentials.json");
    $creds = json_decode($creds_json, true);

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'vendor/autoload.php';

    $mail = new PHPMailer(true);
    
    
    
    $stmt = $mysqli->prepare("SELECT * FROM `credentials` WHERE `Name` = ?");
    $stmt->bind_param("s", $seller);
    $stmt->execute();

    $data = $stmt->get_result();
    if($row = $data->fetch_assoc()){
        $Email = $row['Email'];


        try{
            $mail->SMTPDebug = 0;									
            $mail->isSMTP();											
            $mail->Host	 = 'smtp.gmail.com;';					
            $mail->SMTPAuth = true;							
            $mail->Username = $creds['email'];				
            $mail->Password = $creds['password'];						
            $mail->SMTPSecure = 'tls';							
            $mail->Port	 = 587;
    
            $mail->setFrom($creds['email'], 'Ebay Market'); // sent from
            $mail->addaddress($Email); // sent to

            $mail->isHTML(true);								
            $mail->Subject = "Items purchased!";
            // $mail->msgHTML(file_get_contents('template.html'));
           // $mail->msgHTML(file_get_contents('purchasemail.php')); 
           
            $mail->Body = $mailbody;
            //$mail->AltBody = "{$user} has purchased {$product}. \r\n{$total} has been sent to you.";
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
            http_response_code(404);
        }
        
    }
    else{
        echo "<script> alert('error occured'); console.log($mysqli->error()) </script>";
    }

?>    