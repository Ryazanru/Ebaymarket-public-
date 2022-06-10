<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>registration</title>

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

</head>
<body>
    
<form action="registration-check.php" onsubmit="return formvalidation()" method="post" class="formstyle">
  <div class="mb-3">
    <label for="email" class="form-label">Email address<span style="color:red;">*</span></label>
    <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp" required>
    
  </div>
  <div class="mb-3">
      <label for="name" class="form-label">Name<span style="color:red">*</span></label>
      <input type="text" class="form-control" name="name" id="name" required>
  </div>
  <div class="mb-3">
    <label for="password" class="form-label">Password<span style="color:red;">*</span></label>
    <input type="password" class="form-control" name="password" id="password" required>
  </div>
  <div class="mb-3">
      <label for="con-password" class="form-label">Confirm Password<span style="color:red;">*</span></label>
      <input type="password" class="form-control" name="con-password" id="con-password" required>
  </div>
  
  <button type="submit" name="submit" class="btn btn-success">Register</button>

    </form>


    <script>
        function formvalidation(){
            var pass = document.getElementById('password').value;
            var conpass = document.getElementById('con-password').value;
            var i = 0;

            if(pass == conpass){
                while(i <= pass.length){
                    if(pass.CharAt(i)){
                        
                    }
                }
                return true;
            }
            else{
                alert('password is not the same');
                document.getElementById('password').value = "";
                document.getElementById('con-password').value = "";
                return false;
            }
        }
    </script>
    
</body>
</html>