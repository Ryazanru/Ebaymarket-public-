<?php
    include_once $_SERVER["DOCUMENT_ROOT"]."/config.php";
    session_start();
    if(!$_SESSION['isLoggedIn']){
        echo "<script>window.location = 'login.php'</script>";
    }
    $productid = $_GET['product'];

        $stmt = $mysqli->prepare("SELECT * FROM product WHERE Id = ?");
        $stmt->bind_param("s", $productid);
        $stmt->execute();

        $data = $stmt->get_result();
        if($row = $data->fetch_assoc()){
            $product = $row['Product Name'];
            $price = $row['Price'];
            $quantity = $row['Quantity'];
            $description = $row['Description'];
            $image = $row['Image Name'];
            $category = $row['Category'];
            

        }

        $stmt2 = $mysqli->prepare("SELECT * FROM `product images` WHERE Id = ?");
        $stmt2->bind_param("s", $productid);
        $stmt2->execute();

        $data2 = $stmt2->get_result();
        

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>editproduct</title>

    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

    <link rel="stylesheet" href="assets/css/fa-all.css">

    <script src="assets/js/bootstrap.js"></script>
    <script scr="assets/js/bootstrap.bundle.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <style>
    .divstyle {

        margin: 12%;
        border: black;
        border-style: solid;
        border-width: 1px;
        padding: 4%;
        background-color: beige;
    }

    .pricing {
        display: flex;
    }

    .img-wraps {
    position: relative;
    display: inline-block;
    width: 0px;
    font-size: 0;
    }
    .img-wraps .closes {
    position: absolute;
    top: 5px;
    right: -195px;
    z-index: 100;
    background-color: #FFF;
    padding: 4px 3px;
    color: #000;
    font-weight: bold;
    cursor: pointer;
    text-align: center;
    font-size: 22px;
    line-height: 10px;
    border-radius: 50%;
    border:1px solid red;
    opacity: 0.5;
    }
    .img-wraps:hover .closes {
        opacity: 1;
    }
    </style>


</head>

<body style="background-color:aqua;">
    <?php include_once $_SERVER["DOCUMENT_ROOT"]."/navbar.php" ?>
    <form action="update.php" method="post" enctype="multipart/form-data">
        <div class="divstyle" style="padding-top: 25px;">
            <div style="margin-bottom: 40px;">
            <button type="button" name="deleteproduct-btn" class="btn btn-danger" style="margin: 5px; float: right;" onclick='deleteproduct("<?php echo $productid ?>")'>Delete Product</button>
            </div>
        
            <div class="container" id="product-container">
                <div class="row">
                    <div class="col">
                        <div class="mb-3">
                            <label for="name" class="form-label">Product Name<span style="color:red">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" value="<?php echo $product ?>"
                                required style="width: 50%;">
                        </div>
                        <div class="mb-3">
                    <label for="category" class="form-label">Category<span style="color:red">*</span></label>
                    <select required name="categorymenu" class="form-select" onclick="otherchoice()" id="categorymenu" aria-label="Default select example">
                        <option value="<?php echo $category ?>"><?php echo $category ?></option>
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
                                <input type="number" step=0.01 class="form-control" id="price" name="price"
                                    value="<?php echo $price ?>" required style="width: 95%;">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="quantity" class="form-label">Quantity<span style="color:red">*</span></label>
                            <input type="number" id="quantity" class="form-control" name="quantity"
                                value="<?php echo $quantity ?>" required style="width: 50%;">
                        </div>

                        <div class='mb-3'>
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description"
                                style="height: 100px"><?php echo $description ?> </textarea>
                        </div>

                    </div>
                    <div class="col">
                        <div class="row">
                            <div class="col">
                                <div class="mb-3" style="margin-left: 30%;
                                                margin-top: 10%;display: flex;
                                                flex-wrap: wrap;
                                                flex-direction: column;">
                                    <label for="placeholder1"></label>
                                    <input type="file" accept="image/*" class="placeholder1" name="imageupload1"
                                        id="imageinput1" onchange="replaceimage(this)">
                                    <img src="images/<?php echo $image ?>.jpeg" id="placeholder1" name="image1"
                                        alt="stockimage" style="width:200px; height:200px;">
                                    <input type="hidden" name="oldimagename" value="<?php echo $image ?>">
                                    

                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <input type="hidden" name="count" id="count" value="1">
            <div id="moreimages" style="display:flex;flex-wrap: wrap;">
                <?php 
        $next = 2;
        while($row2 = $data2->fetch_assoc()){
                $img = $row2['Img'];
                echo "<div class='mb-3' id='product-div-{$next}' style='margin-top: 3%;display: flex;flex-direction: column;'>
                    <label for='placeholder{$next}'></label>
                    <input type='file' class='placeholder{$next}' id='imageinput{$next}' onchange='replaceimage(this)' accept='image/*' name='imageupload{$next}'>
                    <input type='hidden' name='oldimagename{$next}' value='{$img}'>
                    <div class='img-wraps'>
                    <img src='images/{$img}.jpeg' id='placeholder{$next}' alt='stockimage' style='width:200px; height:200px;'>
                    <span class='closes' onclick='deleteimage(this, {$next})' title='Delete'><i class='fa fa-trash' aria-hidden='true'></i></span>
                    </div>
                    
                
                </div>";
                echo "<script>document.getElementById('count').value={$next};</script>";
                $next++;
            }   
            echo "<script>var nextIndex = {$next}</script>";
            
        ?>

            </div>
            <button type="button" style="margin-left: 12px; margin-top: 10px;" name="newimage" class="btn btn-primary" onclick="addimage()">Add New Image</button>
            <div style="display: flex;justify-content: center;">
                <button type="submit" name="upload" class="btn btn-primary">Update</button>
                
                <input type="hidden" name="productid" id="productid" value="<?php echo $productid ?>">
            </div>

        </div>

    </form>

    <script>
    function addimage() {


        //var parentcol = document.createElement('col'); // Col_Div
        var parentdiv = document.createElement('div');


        parentdiv.classList.add("mb-3");
        parentdiv.style.cssText += 'margin-top: 3%;display: flex;flex-direction: column;';

        var label = document.createElement('label');
        label.setAttribute("for", "placeholder" + nextIndex);
        parentdiv.appendChild(label);

        var input = document.createElement('input');
        input.type = "file";
        input.classList.add("placeholder" + nextIndex);
        input.id = "imageinput" + nextIndex;
        input.setAttribute('onchange', 'replaceimage(this)');
        input.setAttribute('accept', 'image/*');
        input.setAttribute('name', 'imageupload' + nextIndex);
        parentdiv.appendChild(input);

        var buttonparentdiv = document.createElement('div');
        buttonparentdiv.classList.add("img-wraps");
        parentdiv.appendChild(buttonparentdiv);

        var stockimage = document.createElement('img');
        stockimage.src = "images/placeholder.png";
        stockimage.id = "placeholder" + nextIndex;
        stockimage.alt = "stockimage";
        stockimage.style.cssText += 'width:200px; height:200px;';
        buttonparentdiv.appendChild(stockimage);

        var Xbutton = document.createElement('span');
        Xbutton.setAttribute('onclick', `deleteimage(this, ${nextIndex})`);
        Xbutton.classList.add("closes");
        Xbutton.innerText = "x";
        buttonparentdiv.appendChild(Xbutton);

        document.getElementById('moreimages').appendChild(parentdiv);
        //parentcol.appendChild(parentdiv); // Div attached to Col
        //input.addEventListener('onchange', 'replaceimage(this)');
        //document.getElementById("imageinput"+nextIndex).addEventListener('onchange', 'replaceimage(this)');

        document.getElementById('count').value = nextIndex;
        nextIndex++;
    }

    function replaceimage(input) {
        var id = input.getAttribute('class'); // store input class as id variable


        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#' + id)
                    .attr('src', e.target.result);
            };

            reader.readAsDataURL(input.files[0]); // fetch image from this attribute passed.
        }
    }


    async function deleteimage(image, next){ // secondary images
        var text = "Are you sure to want to delete this image?";
        if(confirm(text) == true){
            var original = document.getElementById(`placeholder${next}`).getAttribute("src");
            if(original == "images/placeholder.png"){
                image.parentElement.parentElement.remove();
                // handle scenario when user adds image, removes image, than adds new image
                // retains placeholder assignment
                // find corner case where placeholder image must be deleted directly.
                // adds product image then deletes before uploading. (returns jpeg;base64).
            }
            else{
                var arr1 = original.split("/"); // [images][img.jpeg]
                var img = arr1[1]; // img = "img.jpeg";
                var arr2 = img.split("."); // [img][jpeg];
                var imgname = arr2[0]; 
                console.log(imgname);
                if(image.parentElement.previousElementSibling.getAttribute("type") == "file"){ // if previous sibling tag is image and not hidden input tag, break out of function, reset next variable
                    nextIndex = nextIndex - 1;
                    console.log(nextIndex);
                    image.parentElement.parentElement.remove();
                    return;
                }
                else{
                    var result = await fetch(`deleteimage.php?image=${imgname}`);
                    var data = await result.json();
                    if(data.status == 200){
                        image.parentElement.parentElement.remove();
                        
                        // test
                    }
                    else{
                        alert("Error occured during deletion");
                    }
                }
                
            }
        }
        
        //console.log(image);
        
        
    }

    

    async function deleteproduct(){ // delete product from edit page
        var product = "<?php echo $productid ?>";
        console.log(product);
        var result = await fetch (`deleteproduct.php?product=${product}`);
        var data = await result.json();
        if(data.status == 200){
            alert("product deleted");
            window.location="myuploads.php";
        }
        else{
            alert("error occured");
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