<?php
session_start();
include_once $_SERVER["DOCUMENT_ROOT"]."/transaction.php";
            $sellers = array();
            
            foreach($_SESSION['cartarray'] as $keys => $values){
                if($values[1]){ // if seller name exists.
                    $sellers[$values[1]] = null; // null value stored to $sellers array current element. $seller['Ryzan'] = null
                    // use for pushing one element to array.
                    // use array_push() for multiple elements.
                    echo "<script> console.log('true1'); </script>";
                }
            }
            foreach($sellers as $key => $seller){ // loop over $sellers array //trollboay
                $products = array();
                foreach($_SESSION['cartarray'] as $keys => $values){ // each $seller loop, loop over $_SESSION['cartarray'].
                    // echo "val16". $values[1];
                    // echo "val20". $key;
                    if($values[1] == $key){ // if $_SESSION['cartarray] seller name equals $seller[$key]. $seller['Ryzan'].
                        echo "<script> console.log('true2'); </script>";
                        array_push($products, $values); // push current array elements to $products array
                    }
                }
                $sellers[$key] = $products;  // $sellers inner array value equal to current array elements. $sellers['Ryzan'] = Ryzan (product name, Ryzan, image name, price, quantity); 
                //print_r($products);
            }
            // $sellers["newitem"] = "ABC";
            //print_r($sellers);
            foreach($sellers as $key => $values){
                echo "<script> console.log(".json_encode($values)."); </script>";
                // $_SESSION['products'] = $values;
                $mailbody = '<style>
                    th, td{
                        padding: 6px;
                    }
                </style>
                <h3> New order has been placed </h3>
           <br>
       
           <table border="1" cellspacing="2">
               <tr>
                   <th>
                       Product
                   </th>
                   <th>
                       User
                   </th>
                   <th>
                       Price
                   </th>
                   <th>
                       Quantity
                   </th>     
                   
               </tr>';
               
               
               $total = 0;
               begin();
                   foreach($values as $var){ // also decrement quantity from database as per quantity amount
                    
                    if($var[4] > 0){
                        $mailbody = $mailbody . "<tr> <td> $var[0] </td>
                       <td> $var[1] </td>
                       <td>$ $var[3] </td>
                       <td style='text-align: right;'> $var[4] </td>
                       </tr>";
                       $total = ($total + ($var[3]*$var[4]));
                       
                        $stmt = $mysqli->prepare("UPDATE `product` SET `Quantity` = `Quantity` - ? WHERE `Id` = ?");
                        $stmt->bind_param("is", $var[4], $var[5]);

                        $stmt2 = $mysqli->prepare("SELECT `Quantity` FROM `product` WHERE `Id` = ?");
                        $stmt2->bind_param("s", $var[5]);
                        $stmt2->execute();
                        $data = $stmt2->get_result();
                        $row = $data->fetch_assoc();
                        
                        if($row['Quantity'] == 0){ // if quantity is still 0.
                            rollback();
                            echo "<script> alert('{$var[0]} is no longer available, remove item from cart to continue.'); window.location='cart.php';</script>";
                            exit();
                        }
                        else if($row['Quantity'] < $var[4]){
                            rollback();
                            echo "<script> alert('Only {$row['Quantity']} amount of {$var[0]} remain. Please reduce amount in cart or remove item to continue.'); window.location='cart.php';</script>";
                            exit();
                            // display not enough product left to purchase and end execution.
                        }
                        else{
                            $stmt->execute();
                            commit();
                        }
                        
                    } 
                   }
                   $mailbody = $mailbody . "<tr> <th colspan = '2'> Total </th>
                   <th colspan='2'>$ $total </th> 
                   </tr>";
                   $mailbody = $mailbody . '</table>'; 

               // curl_request_async("http://localhost/ebaymarket/payment.php", array("products" => $values));
                
               $url = 'https://ebaymarket.ml/payment.php';
               $data = array('seller' => $key, 'msgbody' => $mailbody);

               // use key 'http' even if you send the request to https://...
               $options = array(
                   'http' => array(
                       'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                       'method'  => 'POST',
                       'content' => http_build_query($data)
                   )
               );
               $context  = stream_context_create($options);
               $result = file_get_contents($url, false, $context);
               if ($result === FALSE) { 
                   echo "<script> alert('Failed to connect'); console.log('Failed to connect to payment.php') </script>";
                /* Handle error */ }else{
                    // var_dump($result);
                    $pdata = json_decode($result, true);
                    
                    if($pdata['status'] == 200){
                        $_SESSION['cartarray'] = array();
                        $_SESSION['cart'] = 0;
                        echo "<script> alert('Order placed!'); window.location='mainpage.php'; </script>";
                        
                        
                    }
                    else{
                        echo "<script> alert('Error occured in payment.php')</script>";
                    }
                }

               
                
                  
               //echo "<script> window.location='payment.php'</script>";
            }

            //var_dump($sellers);
        ?>