<?php
    
    function get_categories(){
        include $_SERVER["DOCUMENT_ROOT"]."/config.php";
        
        try{
            $stmt = $mysqli->prepare("SELECT * FROM categories");
            $stmt->execute();

            $data = $stmt->get_result();
            // {Catagory => array of categories}
            $resultjson = array(); // json which has key and value
            $categories = array(); // arrray which has internal keys of 0,1,2 but we dont need it necessarily
            
            while($row = $data->fetch_assoc()){
                array_push($categories, $row['Name']); // categories[smart phones], categories[smart watches]
                //echo "<script>console.log({$row['Name']})</script>";
            }
            // $categories = {[0]=> 'Smartphones', [1]=> 'Smart watches'}

            //array_push($resultjson, $categories); // $resultjson = {[0] =>  {[0]=> 'Smartphones', [1]=> 'Smart watches'}, [1] => 'USA'}
            //array_push($country, "USA");
            $resultjson['categories'] = $categories; // $resultjson = {"Categories" =>  {[0]=> 'Smartphones', [1]=> 'Smart watches'}}
            //$resultjson['country'] = "USA";
            $resultjson['status'] = "success";
            return $resultjson;
        }
        catch(Throwable $e){
            $resultjson = array();
            $resultjson['status'] = "error";
            $resultjson['error'] = $mysqli->error; 
            return $resultjson;
        }
        finally{
            $stmt->close();
            $mysqli->close();
        }
    }


?>