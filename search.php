<?php
    include_once $_SERVER["DOCUMENT_ROOT"]."/config.php";

    $searchquery = $_GET['query'];
    // direct result
    $stmt = $mysqli->prepare("SELECT `Product Name`, Price, `Image Folder`, `Image Name`, Category, Id FROM product WHERE `Product Name` = ?");
    $stmt->bind_param("s", $searchquery);
    $stmt->execute();
    

    /*
        PRODUCT TABLE

        NAME    PRICE    IMAGE    CATEGORY
        A        5        FSFSFS    SMARTPHONE
        B        15       FSFSFS    SMARTPHONE
        C        25       FSFSFS    SMARTPHONE

        RESULTSET

        NAME    PRICE    IMAGE    CATEGORY
         A        5        FSFSFS    SMARTPHONE
         B        15       FSFSFS    SMARTPHONE
         C        25       FSFSFS    SMARTPHONE
    */

     $data = $stmt->get_result(); // GET RESULTSET(rows and columns part of result) AND STTORE IN DATA
     $arr = array();

    // $row = $data->fetch_assoc()//       { 'Name': A,  'Price'      5, 'Image':        FSFSFS, 'Category':    SMARTPHONE }
    // $row['Category']

    // $row = $data->fetch_assoc()//       { 'Name': A,  'Price'      5, 'Image':        FSFSFS, 'Category':    SMARTPHONE }
    // $row['Category']

    while($row = $data->fetch_assoc()){
        array_push($arr, $row);
        // {"status":"success", "products":[array of products]}
        // json_encode() will stop loop
    }
    $stmt->close();
    $simarr = array();
    $idarr = array();
    if(count($arr) > 0){ // checking if there was best result
        $product = $arr[0];
        $category = $product['Category'];
        $searchwords = explode(" ", $searchquery);
        foreach($searchwords as $word){
            if(is_numeric($word)){
                continue;
            }
            // run mysql query to find products with same word and same category as defined by $category
            // %ABC% = matches ABC, XYZABC, XABC, ABCD, ABCDEF, XABCD

            $stmt = $mysqli->prepare("SELECT `Product Name`, Price, `Image Folder`, `Image Name`, Category, Id FROM product WHERE `Product Name` LIKE '%{$word}%' AND Category = ? AND `Product Name` != ?");
            $stmt->bind_param("ss", $category, $searchquery);
            $stmt->execute();

            $data = $stmt->get_result();
            while($row = $data->fetch_assoc()){
                if(!(in_array($row['Id'], $idarr))){
                    array_push($simarr, $row);
                    array_push($idarr, $row['Id']);
                }
                
            }
            $stmt->close();
        }

    }
    else{
        $searchwords = explode(" ", $searchquery); // ["Iphone"]["7"]
        foreach($searchwords as $word){
            if(is_numeric($word)){ // [7]
                continue;
            }
            if(strlen($word) <= 2){ // [X]
                continue;
            }
            $stmt = $mysqli->prepare("SELECT `Product Name`, Price, `Image Folder`, `Image Name`, Category, Id FROM product WHERE `Product Name` LIKE '%{$word}%' AND `Product Name` != ?");
            $stmt->bind_param("s", $searchquery);
            $stmt->execute();

            $data = $stmt->get_result();
            while($row = $data->fetch_assoc()){
                if(!(in_array($row['Id'], $idarr))){
                    array_push($simarr, $row);
                    array_push($idarr, $row['Id']);
                }
            }
            $stmt->close();
            // only categories:
            // `product name` LIKE 'Iphone' returns Iphone X -> Smart Phones
            // take category and use with `product name` LIKE -> returns Iphone X
            // creates duplicate results from both queries
            // search by LIKE words
        }
    }
    // similar results
    //$searchquery['Iphone X']
    // $row['Iphone X']
    

    $json = new stdClass(); // empty json declaration.
    $json->status = "success";
    $json->search = $searchquery;
    $json->bestproducts = $arr;
    $json->similarproducts = $simarr;
    $json->ids = $idarr;
    echo json_encode($json);

    // ex: search is Apple Iphone 11. 
            // break into 3 separate words. Array.split
            // get category of exact search term "Iphone 11". query category from database
            // run query on each word with category.  use category to sort out words that do not return same category
            // this query condition would not be "= something" but "contains".

    
?>