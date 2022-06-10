<?php
    include_once $_SERVER["DOCUMENT_ROOT"]."/config.php";
    include $_SERVER["DOCUMENT_ROOT"]."/transaction.php";
    session_start();
    if(!$_SESSION['isLoggedIn']){
        echo "<script>window.location = 'login.php'</script>";
    }
    $USERNAME = $_SESSION['name'];

    if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['upload'])){ // controller logic
        $PRODUCTNAME = $_POST['name'];
        if($_POST['price'] <= 0 || !is_numeric($_POST['price'])){
            echo "<script>alert('invalid price')</script>";
            exit();
        }
        else{
            $PRICE = $_POST['price'];
        }
        $DESCRIPTION = $_POST['description'];
        $COUNT = $_POST['count'];
        $FOLDER = "images/";
        $QUANTITY = $_POST['quantity'];
        $PRODUCTID = $_POST['productid'];
        $OLDIMAGENAME = $_POST['oldimagename'];
        if($_POST['categorymenu'] == "Other"){
            $CATEGORY = $_POST['catchoice'];
        }
        else{
            $CATEGORY = $_POST['categorymenu'];
        }
        // echo $PRODUCTNAME;
        // echo $PRICE;
        // echo $DESCRIPTION;
        // echo $QUANTITY;
        // echo "<br>";
        // echo $PRODUCTID;
        // echo $CATEGORY;
        


        // primary
        //$IMAGE1NAME = $_FILES['imageupload1']['name']; // name/type
        echo "IMAGESIZE"; // = 0
        $IMAGE1SIZE = $_FILES['imageupload1']['size'];
        echo $IMAGE1SIZE;
        $IMAGE1TYPE = $_FILES['imageupload1']['type'];
        echo "IMAGETYPE"; // empty
        echo $IMAGE1TYPE;

        $bytes2 = random_bytes(20);
        $IMAGE1NAME = bin2hex($bytes2);

        if(preg_match("/^image/i", $IMAGE1TYPE)){
            // $PRICE = ($PRICE + $SHIPPING);
            if(file_exists($FOLDER.$OLDIMAGENAME.".jpeg")){
                unlink($FOLDER.$OLDIMAGENAME.".jpeg");
            }
             move_uploaded_file($_FILES["imageupload1"]["tmp_name"], $FOLDER.$IMAGE1NAME.".jpeg"); // move_uploaded_file(Actual uploaded file, what name we want to assign)
             //$image1blob = base64_encode(addslashes (file_get_contents($_FILES['imageupload1']['tmp_name'])));

             // model
             begin();
             $stmt = $mysqli->prepare("UPDATE `product` SET `Product Name` = ?, `Price` = ?, `Description` = ?, `Quantity` = ?, `Image Name` = ?, `Category` = ? WHERE `Id` = ?");
             //$imageProperties = getimageSize($_FILES['imageupload1']['tmp_name']);
             //echo $imageProperties['mime'];
 
             $bytes = random_bytes(20);
             $ID = bin2hex($bytes);
             $stmt->bind_param("sdsisss", $PRODUCTNAME, $PRICE, $DESCRIPTION, $QUANTITY, $IMAGE1NAME, $CATEGORY, $PRODUCTID);
             echo $PRODUCTID;
             // stores same id 
             
             
             //$stmt->send_long_data(4, $image1blob);
             $result = $stmt->execute();
             echo $result;
             echo "<br>";
             echo $stmt->affected_rows;
             if(!$result){
                 rollback();
                 echo "<script> alert('Error occured') </script>";
                 echo "$mysqli->error";
                 exit();
             }
             
         
         }
         else{
            begin();

            $stmt = $mysqli->prepare("UPDATE `product` SET `Product Name` = ?, `Price` = ?, `Description` = ?, `Quantity` = ?, `Category` = ? WHERE `Id` = ?");
            
            $stmt->bind_param("sdsiss", $PRODUCTNAME, $PRICE, $DESCRIPTION, $QUANTITY, $CATEGORY, $PRODUCTID);
            echo $PRODUCTID;
             
            $result = $stmt->execute();
            
            if(!$result){
                rollback();
                echo "<script> alert('Error occured') </script>";
                echo "$mysqli->error";
                exit();
            }  
         }
         if($COUNT > 1){
            $index = 2;
            for($i = 2; $i <= $COUNT; $i++){
               try{
                $IMAGENAME = $_FILES['imageupload'.$i]['name']; // name/type
                $IMAGESIZE = $_FILES['imageupload'.$i]['size'];
                $IMAGETYPE = $_FILES['imageupload'.$i]['type'];
               }
               catch(\Throwable $e){
                   echo "error {$e->getMessage()}";
               }

              

               $bytes3 = random_bytes(20);
               $IMAGENAME = bin2hex($bytes3);
               
               
               
               if(preg_match("/^image/i", $IMAGETYPE)){ // true only if image changed or is new image
                   $cimg = $_POST['oldimagename'.$i];
                   if(file_exists($FOLDER.$cimg.".jpeg")){
                      unlink($FOLDER.$cimg.".jpeg");
                      // update product images set img = $imagename where id = $productid and img = cimg
                      $stmt = $mysqli->prepare("DELETE FROM `product images` WHERE Id = ? and Img = ?");
                      $stmt->bind_param("ss", $PRODUCTID, $cimg);
                      if(!$stmt->execute()){
                        rollback();
                        exit();
                      }
                      
                   }
                   move_uploaded_file($_FILES["imageupload".$i]["tmp_name"], $FOLDER.$IMAGENAME.".jpeg");
                   
                   $stmt = $mysqli->prepare("INSERT INTO `product images` (`Id`, `Img`, `Img Folder`, `Img Index`) VALUES (?,?,?,?)");
                   $stmt->bind_param("sssi", $PRODUCTID, $IMAGENAME, $FOLDER, $index);
                   // 2 3 4
                   // delete index, insert new copy of index if replaced

                   // 2 3 4
                   // delete 3, replace 4: (1 2 4)
                   // on reload, (1 2 3) 
                   $newresult = $stmt->execute();
                   if(!$newresult){
                       echo "<script> alert('Error occured') </script>";
                       echo "$mysqli->error";
                       rollback();
                       exit();
                  }
                   
              }
              if($IMAGESIZE >= 0){  // imagesize is greater than 0 when image is replaced.
                                    // imagesize is equal to 0 when image is not replaced.
                                    // if image deleted, it would not have any size [null].
                $index++;
                } // only increment index when image is replaced or not replaced, dont increment if image deleted.
          }
           
       }
       commit();
       echo "<script> alert('product uploaded successfully')</script>";
       echo "<script> window.location='myuploads.php' </script>";
    }     
?>