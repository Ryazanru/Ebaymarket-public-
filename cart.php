<?php
    error_reporting(0);
    include_once $_SERVER["DOCUMENT_ROOT"]."/config.php";
    session_start();
    if(!$_SESSION['isLoggedIn']){
        echo "<script>window.location = 'login.php'</script>";
    }
    $cart = $_SESSION['cart'];
    
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>cart</title>

    <!-- <link rel="stylesheet" href = "http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="assets/css/all.css"> -->
    
    <link rel="stylesheet" href="assets/css/fa-all.css">
    <!-- <script src="https://kit.fontawesome.com/d8b0b605e2.js" crossorigin="anonymous"></script> -->

    <script src="assets/js/bootstrap.js"></script>
    <script scr="assets/js/bootstrap.bundle.js"></script>
    <script scr="assets/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>



    <style>
    nav {
        border-bottom-style: solid;
        border-color: black;
        border-width: thin;

    }

    .sticky {
        position: sticky;
        top: 0px;
        z-index: 999;
        background-color: #e7e7e7;

    }

    .cart-div {
        border-color: black;
        border-style: solid;
        border-width: thin;
        margin-top: 5px;

    }

    .img-borders {
        border-width: thin;
        border-color: black;
        border-style: solid;
    }

    .checkoutbutton {
        width: 25%;
        margin-left: 75%;
    }

    .totaldetails {

        width: 25%;
        border-top: none;
        font-size: x-large;
    }

    .removebutton {
        margin-bottom: 2px;
        margin: 5px;
        float: right;
    }
    </style>
</head>



<body>
    <?php
        include_once $_SERVER["DOCUMENT_ROOT"]."/navbar.php";
    ?>

    <div class="container">
        <div class="row">
            <h2 style="text-decoration: underline;"> Current Items: </h2>



            <!-- count() or sizeof() for MD array length -->





            <?php
                    // array_key_exists() checks for Key in array
                    // in_array() checks for value in array 
                    
                   $length = count($_SESSION['cartarray']);
                   $i = 0;
                   $cost = 0;
                    
                    
                    // test7 (3), test8 (2)
                    // $_SESSION['cartarray'] = {
                        // test7 id->[prodname, username, imagename, 2.00, 3]
                        // test8 id->[prodname, username, imagename, 4.00, 2]
                    
                   foreach($_SESSION['cartarray'] as $id => $values){
                        $stmt = $mysqli->prepare("SELECT `Quantity` FROM `product` WHERE `Id` = ?");
                        $stmt->bind_param("s", $id);
                        $stmt->execute();
                        $data = $stmt->get_result();
                        $row = $data->fetch_assoc();
                        $quantity = $row['Quantity'];
                        if($i %2 == 0){ // if even
                            echo '<div class="col-md-6 cart-div" id="'.$i.'">';
                           }
                           else{
                            echo '<div class="col-md-6 cart-div" id="'.$i.'" style="margin-left: -5px;">';
                           }
    
                           echo '
                           <div class="row">
                               <div class="col-md-6" style="padding: 12px;">';
                               echo '<img src="images/'.$values[2].'.jpeg" alt="placeholder" class="img-borders"
                               style="width:100%" onclick="redirect(`'.$values[2].'`,`'.$id.'`)"> </img>';
                               echo '</div>
                               <div class="col-md-6">
                                   <p style="margin-top: 19px; text-decoration:underline;"> '.$values[0].' </p>
                                   <p><span style="text-decoration:underline;">Sold by:</span> '.$values[1].'</p>
                                   <p><span>$</span>'.$values[3].'</p>
                                   
                                <div class="center">
                                    <div class="input-group">
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-danger btn-number" id="minus-btn" data-type="minus" data-field="quant['.$i.']"><i class="fa-solid fa-minus"></i>
                                            </button>
                                        </span>
                                        <input type="text" name="quant['.$i.']" readonly class="form-control input-number" aria-loop="'.$i.'" aria-id="'.$id.'" aria-cost="'.$values[3].'" aria-prodname="'.$values[0].'" aria-user"'.$values[1].'" aria-image"'.$values[2].'" value="'.$values[4].'" min="0" max="'.$quantity.'">
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-success btn-number" id="plus-btn" data-type="plus" data-field="quant['.$i.']"> <i class="fa-solid fa-plus"></i>
                                            </button>
                                        </span>
                                    </div>
                                </div>

                                   
                                   
                                   
                               </div>
                           </div>
                       </div>';


                       $cost = ($cost+($values[3]*$values[4])); 
                           
                         $i++;
                       }
                       // $cartarray(ABCD, 123a, ABCD, xyz, 123a);
                       //$idarr();
                       // 
                       
                          
                   

                ?>

            <br>
            <br>


        </div>
        <h3 style="text-decoration: underline;">Payment Details:</h3>
        <p class="totaldetails">Total: <span>$<span id="totalcost"><?php echo $cost ?></span></span></p>
        <button class='btn btn-primary checkoutbutton' onclick="checkoutitems()">Checkout</button>

    </div>

    <script>
    async function checkoutitems() {
        window.location = "processorder.php";



        //window.location="payment.php";


        // var result = await fetch(`payment.php?total=${total}`);
        // var data = await result.json();

        // if (data.status == 200) {
        //     alert("Item purchased!");
        //     console.log(data);
        //     // window.location = "mainpage.php";
        // } else {
        //     alert("error occured, please try again later");
        // }
    }

    async function remove(loop, id, cost) {
        //  document.cookie = `remove_id = ${loop}`; // cookie creation

        var currquantity = document.querySelector(`[aria-id="${id}"]`).value; // 1
        console.log(cost);
        console.log(currquantity);


        var data = await fetch(`removeitem.php?key=${id}&currquantity=${currquantity}`); // 1
        var result = await data.json();
        // if status = 200, quantity = 0 in session array
        if (result.status == 200) {
            if (currquantity == 1) { // 1, true(checks var currquantity)
                document.getElementById(loop).hidden = true;
            }
            document.getElementById("totalcost").innerText = (parseFloat(document.getElementById("totalcost")
                .innerText) - cost).toFixed(2);
            document.getElementById("lblCartCount").innerText = (parseInt(document.getElementById("lblCartCount")
                .innerText) - 1);
                return 0;
        } else {
            alert("error occured, could not remove item.");
            return 1;
        }



    }

    function redirect(img, id){
        window.location=`product-details.php?img=${img}&id=${id}`;
    }




    
    $('.btn-number').click(async function(e) {
        e.preventDefault();

        fieldName = $(this).attr('data-field');
        type = $(this).attr('data-type');
        var input = $("input[name='" + fieldName + "']");
        var currentVal = parseInt(input.val());
        if (!isNaN(currentVal)) {
            if (type == 'minus') {
                var removestatus = await remove(input.attr('aria-loop'),input.attr('aria-id'),input.attr('aria-cost'));
                if(removestatus == 0){
                    if (currentVal > input.attr('min')) {
                    input.val(currentVal - 1).change();
                }
                    if (parseInt(input.val()) == input.attr('min')) {
                        $('#minus-btn').attr('disabled', true);
                    }
                }
                
            } else if (type == 'plus') {
                    // if(parseInt(input.val()) == input.attr('max')){
                    //     input.val(currentVal + 1).change(); // pass to change for alert
                    // }
                    // else{
                        var product = input.attr("aria-prodname");
                        var username = input.attr("aria-user");
                        var image = input.attr("aria-image");
                        var productid = input.attr("aria-id");
                        var price = input.attr("aria-cost");
                        $.ajax({
                            url: `addtocart.php?product=${product}&username=${username}&image_name=${image}&id=${productid}&price=${price}`,
                            type: 'GET',
                            dataType: 'json', // added data type
                            success: function(data) {
                                console.log(data);
                                if(data.error){
                                    alert("error occured");
                                }
                                else{
                                    console.log("Here");
                                    console.log(parseInt(input.val()));
                                    console.log(parseInt(input.attr('max')));
                                    if (parseInt(input.val()) < parseInt(input.attr('max'))) { // if less than max val + 1
                                        input.val(parseInt(input.val()) + 1).change(); // change(attempt to increase by 1)
                                        console.log("changed by 1" + parseInt(input.val()));
                                    }
                                    if (parseInt(input.val()) == parseInt(input.attr('max'))) { // if equal to max val, disable button
                                        console.log("reached max");
                                        $('#plus-btn').attr('disabled', true);
                                        
                                    }

                                //     document.getElementById("totalcost").innerText = (parseFloat(document.getElementById("totalcost")
                                //     .innerText) - cost).toFixed(2);
                                // document.getElementById("lblCartCount").innerText = (parseInt(document.getElementById("lblCartCount")
                                //     .innerText) - 1);
                                $('#totalcost').text( ( parseFloat($('#totalcost').text()) + parseFloat(price) ).toFixed(2) );
                                $("#lblCartCount").text((parseInt($('#lblCartCount').text()) + 1));
                                }
                            }
                        });
                        // $.get("demo_test.asp", function(data, status){
                        //     alert("Data: " + data + "\nStatus: " + status);
                        // });
                    //}
                       
            }
        } else {
            input.val(1);
        }
    });
    $('.input-number').focusin(function() {
        $(this).data('oldValue', $(this).val());
    });
    $('.input-number').change(function() {

        minValue = parseInt($(this).attr('min'));
        maxValue = parseInt($(this).attr('max'));
        valueCurrent = parseInt($(this).val());

        name = $(this).attr('name');
        // if (valueCurrent >= minValue) { // if currentvalue greater or equal to minvalue, remove disable attribute
        //     $(".btn-number[data-type='minus'][data-field='" + name + "']").removeAttr('disabled');
        // } else {
        //     alert('Sorry, the minimum value was reached');
        //     // $(this).val(parseInt($(this).attr('min')));
        //     $(this).val($(this).data('oldvalue'));
        // }
        if (valueCurrent <= maxValue) { // if currentvalue less or equal to maxvalue, remove disable attribute
            $(".btn-number[data-type='plus'][data-field='" + name + "']").removeAttr('disabled');
        } else {
            alert('Sorry, the maximum value was reached');
            // $(this).val(parseInt($(this).attr('max'))); // change to max value
            $(this).val($(this).data('oldValue'));
        }


    });
    $(".input-number").keydown(function(e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
            // Allow: Ctrl+A
            (e.keyCode == 65 && e.ctrlKey === true) ||
            // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
            // let it happen, don't do anything
            return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
    </script>

</body>


</html>