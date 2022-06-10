<?php 
    error_reporting(1);
    session_start();
    if(!$_SESSION['isLoggedIn']){
        echo "<script>window.location = 'login.php'</script>";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>upload</title>

    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/fa-all.css">

    <!-- <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="stylesheet" href="assets/css/all.css"> -->
    <!-- <link rel="stylesheet" href="assets/css/fontawesome.css"> -->
    <!-- <script src="https://kit.fontawesome.com/d8b0b605e2.js" crossorigin="anonymous"></script> -->

    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <!-- <script src="assets/js/bootstrap.js"></script> -->
    

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <style>
        
        .divstyle{
            
    margin: 12%;
    border: black;
    border-style: solid;
    border-width: 1px;
    padding: 4%;
    background-color:beige;
        }

        .pricing{
            display:flex;
        }
    </style>
        
    
</head>
<body style="background-color:aqua;">
<?php include_once $_SERVER["DOCUMENT_ROOT"]."/navbar.php" ?>
<form action="upload-new.php" method="post" enctype="multipart/form-data">
    <div class="divstyle">
    <div class="container" id="product-container">
        <div class="row">
            <div class="col">
                <div class="mb-3">
                    <label for="name" class="form-label">Product Name<span style="color:red">*</span></label>
                    <input type="text" class="form-control" id="name" name="name" required style="width: 50%;">
                </div>
                <div class="mb-3">
                    <label for="category" class="form-label">Category<span style="color:red">*</span></label>
                    <select required name="categorymenu" class="form-select" onclick="otherchoice()" id="categorymenu" aria-label="Default select example">
                        
                        <?php   
                            include_once $_SERVER["DOCUMENT_ROOT"]."/models/CategoryDAO.php";
                            
                            $result = get_categories();
                            
                            
                            if($result['status'] == "error"){
                                echo "<script>alert('error occured')</script>";
                                echo "<script>window.location='mainpage.php'</script>";
                            }
                            else{
                                foreach($result['categories'] as $key=>$category){
                                    echo "<option value='{$category}'>{$category}</option>";
                                    
                                }
                            }
                        
                        
                        
                        ?>
                        <option value="Other">Other</option>
                        
                    </select>
                    
                    <div class="mb-3" hidden id="categorytext">
                        <label for="catchoice" class="form-label">Type category type below</label>
                        <input type="text" class="form-control" id="catchoice" name="catchoice" style="width: 50%;">
                    </div>
                </div>
                <div class="pricing">
                <div class="mb-3">
                    <label for="price" class="form-label">Price<span style="color:red">*</span></label>
                    <input type="number" step=0.01 class="form-control" id="price" name="price" required style="width: 95%;">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="shippingchecked" onchange="switchshipping()">
                        <label class="form-check-label" for="flexSwitchCheckChecked" id="shippinglabel" >Shipping included</label>
                    </div>
                </div>
                <div class="mb-3" hidden id="shippingdiv">
                    <label for="shipping" class="form-label">Shipping<span style="color:red">*</span></label>
                    <input type="number" step=0.01 class="form-control" id="shipping" name="shipping" required style="width: 95%;" value="0">
                </div>
                </div>
                <div class="mb-3">
                    <label for="quantity" class="form-label">Quantity<span style="color:red">*</span></label>
                    <input type="number" id="quantity" class="form-control" name="quantity" required style="width: 50%;">
                </div>
                
                
                <div class="form-floating">
                    <textarea class="form-control" id="description" name="description" style="height: 100px"></textarea>
                    <label for="description">Description</label>
                </div>
            </div>
            <div class="col">
                <div class="row">
                    <div class="col">
                        <div class="mb-3" style="margin-left: 30%;
                                                margin-top: 10%;">
                            <p style="color:red;">Choose image sizes less than 1 MB</p>
                            <label for="placeholder1"></label>
                            <input type="file" accept="image/*" class="placeholder1" name="imageupload1" id="imageinput1" onchange="replaceimage(this)">
                            <img src="images/placeholder.png" id="placeholder1" name="image1" alt="stockimage" style="width:200px; height:200px;">
                            
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    <div id="moreimages" style="display:flex;flex-wrap: wrap;">
        
    </div>
    <button type="button" style="margin-left: 12px;
    margin-top: 10px;" name="newimage" class="btn btn-primary" onclick="addimage()">Add New Image</button>
    <div style="display: flex;
    justify-content: center;">
    <button type="submit" name="upload" class="btn btn-primary">Upload</button>
    <input type="hidden" name="count" id="count" value="1">
    </div>
    
    </div>
  
</form>


<script>
    var next = 2;
    
    function addimage(){
        

        //var parentcol = document.createElement('col'); // Col_Div
        var parentdiv = document.createElement('div');
        

        parentdiv.classList.add("mb-3");
        parentdiv.style.cssText += 'margin-top: 3%;display: flex;flex-direction: column;';

        var label = document.createElement('label');
        label.setAttribute("for","placeholder"+next);
        parentdiv.appendChild(label);

        var input = document.createElement('input');
        input.type="file";
        input.classList.add("placeholder"+next);
        input.id="imageinput"+next;
        input.setAttribute('onchange', 'replaceimage(this)');
        input.setAttribute('accept', 'image/*');
        input.setAttribute('name', 'imageupload'+next);
        parentdiv.appendChild(input);
        
        

        var stockimage = document.createElement('img');
        stockimage.src="images/placeholder.png";
        stockimage.id="placeholder"+next;
        stockimage.alt="stockimage";
        stockimage.style.cssText += 'width:200px; height:200px;';
        parentdiv.appendChild(stockimage);

        document.getElementById('moreimages').appendChild(parentdiv);
        //parentcol.appendChild(parentdiv); // Div attached to Col
        //input.addEventListener('onchange', 'replaceimage(this)');
        //document.getElementById("imageinput"+next).addEventListener('onchange', 'replaceimage(this)');

        document.getElementById('count').value=next;
        next++;
    }

    function replaceimage(input){
        var id = input.getAttribute('class'); // store input class as id variable
        
        
        if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#'+id)
                        .attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]); // fetch image from this attribute passed.
            }
    }

    function switchshipping(){
        var checked = document.getElementById('shippingchecked').checked;
        console.log(checked);
        if(checked){
            document.getElementById('shippingdiv').hidden = false;
        }
        else{
            document.getElementById('shippingdiv').hidden = true;
        }
    }

    function otherchoice(){
        var selectchoice = document.getElementById("categorymenu").value;
        if(selectchoice == "Other"){
            document.getElementById("categorytext").hidden = false;
        }
        else{
            document.getElementById("categorytext").hidden = true;
        }
        
        
    }

    
</script>

</body>
</html>