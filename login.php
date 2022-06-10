<?php include_once $_SERVER["DOCUMENT_ROOT"]."/config.php"; 

//session_destroy();
session_start();
unset($_SESSION);
if(session_status() == 2){
  $_SESSION = array();
  session_destroy();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link rel="stylesheet" href="assets/css/bootstrap.css">

    <script src="assets/js/bootstrap.js"></script>

    <style>
      .formstyle{
        display: flex;
    flex-direction: column;
    margin: 20%;
    border: black;
    border: solid;
    border-width: 1px;
    padding: 2%;
    background-color: bisque;
      }
    </style>

<script>
   function registration(){
      window.location="registration.php";
    }

    // location.href='registration.php'
</script>

</head>
<body style="background-color: aqua;">
  <form action="login-check.php" method="post" class="formstyle">
    <div class="mb-3">
      <label for="email" class="form-label">Email address<span style="color:red;">*</span></label>
      <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp" required>
      
    </div>
    <div class="mb-3">
      <label for="password" class="form-label">Password<span style="color:red;">*</span></label>
      <input type="password" class="form-control" name="password" id="password" required>
    </div>
    
    <button type="submit" name="submit" class="btn btn-primary">Login</button>
    <div>
      <button type="button" name="register" class="btn btn-success" onclick="registration()">Register</button>
    </div>
  </form>


    
</body>
</html>