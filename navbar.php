 <?php
    include_once $_SERVER["DOCUMENT_ROOT"]."/config.php";
    session_start();
    $cart = $_SESSION['cart'];
 ?>

 <style>
.header {
    background: rgb(0, 178, 255);
    color: #fff;
}

#lblCartCount {
    font-size: 15px;
    background: #ff0000;
    color: #fff;
    padding: 0 5px;
    vertical-align: top;
    margin-left: -10px;
}

.badge {
    padding-left: 9px;
    padding-right: 9px;
    -webkit-border-radius: 9px;
    -moz-border-radius: 9px;
    border-radius: 9px;
}

.label-warning[href],
.badge-warning[href] {
    background-color: #c67605;
}

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
 </style>

 <nav class="navbar navbar-expand-lg navbar-light sticky">
     <div class="container-fluid">
         <a class="navbar-brand" href="#">Ebay</a>
         <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
             aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
             <span class="navbar-toggler-icon"></span>
         </button>
         <div class="collapse navbar-collapse" id="navbarSupportedContent">
             <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                 <li class="nav-item">
                     <a class="nav-link active" aria-current="page" href="mainpage.php">Home</a>
                 </li>
                 <?php if($_SESSION['isLoggedIn']){
                     echo '<li class="nav-item">
                     <a class="nav-link" href="upload.php">Upload</a>
                 </li>
                 <li class="nav-item">
                     <a class="nav-link" href="myuploads.php">My Uploads</a>
                 </li>';
                 }?>
                 



             </ul>

             <a href="cart.php"><i class="fa-solid fa-cart-shopping fa-2x" style="margin-right: 10px;"></i><span
                     class='badge badge-warning' id='lblCartCount' style="margin-right:5px;">
                     <?php echo $cart ?></span></a>
             <form class="d-flex" action="" method="get">
                 <input class="form-control me-2" type="search" placeholder="Search" id="searchtext"
                     aria-label="Search">
                 <button class="btn btn-outline-success" type="button" onclick="searchquery()">Search</button>
                 <?php if($_SESSION['isLoggedIn']){
                     echo '<button class="btn btn-danger" type="button" style="margin-left: 5px;"
                     onclick="logout()">Logout</button>';
                 }else{
                    echo '<button class="btn btn-primary" type="button" style="margin-left: 5px;"
                     onclick="logout()">Login</button>';
                 }  ?>
                 
                 <!-- fetch search results by product name -->
             </form>
         </div>

     </div>
     <script>
     function logout() {
         window.location = "login.php";
     }

     async function searchquery() {
         var query = document.getElementById("searchtext").value;
         var url = window.location.href;
         
         if((!url.includes("mainpage.php")) && (!url.includes("searchresult.php"))){
            window.location=`searchresult.php?query=${query}`;
         }
         
         var result = await fetch(`search.php?query=${query}`);
         var data = await result.json();
         console.log(data);
         if (data.status == "success") {
             document.getElementById("product-container").innerHTML = ""; // potential cause of undefined
             // cannot set properties of null: document.getElementById("container") did not return anything so cannot set value of element that does not exist.
             // show direct results
             
             var precontent = `<div class="row" style="display: flex;
                                        justify-content: center;
                                        margin-left: 50px;">`;
                                    if(data.bestproducts.length > 0 ){
                                        precontent = precontent + `<h3 style="text-decoration: underline; margin-top: 8px;">Best Results:</h3>`;
                                    }
                                    else{
                                        precontent = precontent + `<h3 style="text-decoration: underline;">No results match your search query</h3><br>`;
                                    }
                    
                    // MVC design
                    // Model - refers to database and scripts which are responsible for database interaction (mysqli connection)
                    // View - Files which are responsible for generation of front end: user interacts directly with these
                    // Controller - files which are responsible for business logic: all major conditions (image is valid, replaced or not ect.)
                    precontent = precontent + `<div class="col-md-12" id="products-container">`;
                    data.bestproducts.forEach(product => {
                        precontent = precontent +
                            `<div class="product" >
                            <div class='display-div'>
                            <img class="display-product-image" height="250px" width="270px" id="pimage" src="${product['Image Folder']}${product['Image Name']}.jpeg" alt="userimage" onclick="moredetails('${product['Id']}', '${product['Image Name']}')">
                            <br>
                            <h4 class='display-product-price' id='pprice'>${product['Price']}</h4>
                            <h4 class='display-product-name' id='pname'>${product['Product Name']}</h4>
                            </div>`;    
                            precontent = precontent + "</div>";
                        
                        
                            
                    });
                    precontent = precontent + "</div>";
                    precontent = precontent + `<h3 style="text-decoration: underline; margin-top: 8px;">Similar Results:</h3>`;
                    precontent = precontent + `<div class="col-md-12" id="products-container">`;
                    data.similarproducts.forEach(product =>{
                         // display other results if condition not met
                            precontent = precontent +
                            `<div class="product" >
                            <div class='display-div'>
                            <img class="display-product-image" height="250px" width="270px" id="pimage" src="${product['Image Folder']}${product['Image Name']}.jpeg" alt="userimage" onclick="moredetails('${product['Id']}', '${product['Image Name']}')">
                            <br>
                            <h4 class='display-product-price' id='pprice'>${product['Price']}</h4>
                            <h4 class='display-product-name' id='pname'>${product['Product Name']}</h4>
                            </div>`;    
                            precontent = precontent + "</div>";
                        
                    });
                    precontent = precontent + "</div></div>";
                    
             }
             
             <?php 
                // define and pass keyword to mysqil to display similar products.
             ?>
             document.getElementById("product-container").innerHTML = precontent;

         }



     
     </script>
 </nav>