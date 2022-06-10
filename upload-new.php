<?php
    include_once $_SERVER["DOCUMENT_ROOT"]."/config.php";
    include $_SERVER["DOCUMENT_ROOT"]."/transaction.php";
    session_start();
    if(!$_SESSION['isLoggedIn']){
        echo "<script>window.location = 'login.php'</script>";
    }
    $USERNAME = $_SESSION['name'];

    if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['upload'])){
        $PRODUCTNAME = $_POST['name'];
        if($_POST['price'] <= 0 || !is_numeric($_POST['price'])){
            echo "<script>alert('invalid price')</script>";
            exit();
        }
        else{
            $PRICE = $_POST['price'];
        }
        $SHIPPING = $_POST['shipping'];
        $DESCRIPTION = $_POST['description'];
        $COUNT = $_POST['count'];
        $FOLDER = "images/";
        $QUANTITY = $_POST['quantity'];
        if($_POST['categorymenu'] == "Other"){
            $CATEGORY = $_POST['catchoice'];
        }
        else{
            $CATEGORY = $_POST['categorymenu'];
        }
        
        


        // primary
        //$IMAGE1NAME = $_FILES['imageupload1']['name']; // name/type
        $IMAGE1SIZE = $_FILES['imageupload1']['size'];
        if($IMAGESIZE > 1048576){
            echo "<script>alert ('Please choose a image size lower than 1 MB')</script>";
            rollback();
            echo "<script>window.location='upload.php'</script>";
            exit();
        }
        $IMAGE1TYPE = $_FILES['imageupload1']['type'];

        $bytes2 = random_bytes(20);
        $IMAGE1NAME = bin2hex($bytes2);

        echo "<script> console.log($IMAGE1TYPE) </script>";
        
        if(preg_match("/^image/i", $IMAGE1TYPE)){
           // $PRICE = ($PRICE + $SHIPPING);
            move_uploaded_file($_FILES["imageupload1"]["tmp_name"], $FOLDER.$IMAGE1NAME.".jpeg"); // move_uploaded_file(Actual uploaded file, what name we want to assign)
            //$image1blob = base64_encode(addslashes (file_get_contents($_FILES['imageupload1']['tmp_name'])));
            begin();
            $stmt = $mysqli->prepare("INSERT INTO `product` (`Product Name`, `Price`, `Description`, `Username`, `Image Folder`, `Id`, `Shipping`, `Image Name`, `Quantity`, `Category`) VALUES (?,?,?,?,?,?,?,?,?,?)");
            //$imageProperties = getimageSize($_FILES['imageupload1']['tmp_name']);
            //echo $imageProperties['mime'];

            $bytes = random_bytes(20);
            $ID = bin2hex($bytes);
            $stmt->bind_param("sdssssdsis", $PRODUCTNAME, $PRICE, $DESCRIPTION, $USERNAME, $FOLDER, $ID, $SHIPPING, $IMAGE1NAME, $QUANTITY, $CATEGORY);
            // stores same id 
            
            
            //$stmt->send_long_data(4, $image1blob);
            $result = $stmt->execute();
            if(!$result){
                rollback();
                echo "<script> alert('Error occured') </script>";
                echo "$mysqli->error";
            }else{
                echo $COUNT;
                if($COUNT > 1){
                    for($i = 2; $i <= $COUNT; $i++){
                        

                        $IMAGENAME = $_FILES['imageupload'.$i]['name']; // name/type
                        $IMAGESIZE = $_FILES['imageupload'.$i]['size'];
                        if($IMAGESIZE > 1048576){
                            echo "<script>alert ('Please choose a image size lower than 1 MB')</script>";
                            rollback();
                            echo "<script>window.location='upload.php'</script>";
                            exit();
                        }
                        $IMAGETYPE = $_FILES['imageupload'.$i]['type'];

                        $bytes3 = random_bytes(20);
                        $IMAGENAME = bin2hex($bytes3);
                        

                        if(preg_match("/^image/i", $IMAGETYPE)){
                            echo $i;
                            move_uploaded_file($_FILES["imageupload".$i]["tmp_name"], $FOLDER.$IMAGENAME.".jpeg");
                            
                            $stmt = $mysqli->prepare("INSERT INTO `product images` (`Id`, `Img`, `Img Folder`, `Img Index`) VALUES (?,?,?,?)");
                            $stmt->bind_param("sssi", $ID, $IMAGENAME, $FOLDER, $i);
                            $newresult = $stmt->execute();
                            if(!$newresult){
                                echo "<script> alert('Error occured') </script>";
                                echo "$mysqli->error";
                                rollback();
                            }
                            
                        }
                    }
                    
                }
                commit();
                echo "<script> alert('product uploaded successfully')</script>";
                echo "<script> window.location='mainpage.php'</script>";
                
            }   
            
        
        }

        

        
            
            
            
            // echo "$PRODUCTNAME";
            // echo "$PRICE";
            // echo "$DESCRIPTION";
            // echo "$USERNAME";
            // echo "$image1blob";

            

            

            

        

        


        


    }

?>