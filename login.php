<?php
// Initialize the session
session_start();
$fullUrl="http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
if(strpos($fullUrl,"login=empty")==true){
echo"<p style=background-color:red;>Fill in all fields!!<p>";

}

elseif(strpos($fullUrl,"login=wrong_email")==true){
  echo"<p style=background-color:red;>user does not exist!!<p>";

  }
  elseif(strpos($fullUrl,"login=wrong_pwd")==true){
    echo"<p style=background-color:red;>You have entered the wrong password!!<p>";
 
    }
?>
<html>
<head>
  <title>Login</title>
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
  <style>
       
        body {
            background-image: url('backg.jpg');
            background-size: cover; /* Cover the entire page */
            background-repeat: no-repeat; /* Do not repeat the image */
            font-family: 'Lato', sans-serif;
        }
        .custom-form-style {
        background-color: rgba(255, 255, 255, 0.8); 
        padding: 20px;
        border-radius: 100px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    </style>
</head>
<body>
<div class="container d-flex justify-content-center align-items-center"

style="min-height:100vh; "
>
  
<form class="border shadow p-3 rounded custom-form-style"action="checklogin.php"method="post"  style="width:450px; ">
<h1 class="text-center p-3">Login</h1>


  
  <div class="mb-3">
    <label for="Email"
     class="form-label">Email</label>
    <input type="email"
     class="form-control"
     name="email" 
     
     >
     
  
  </div>
  <div class="mb-3">
    <label for="Password"
     class="form-label">Password</label>
    <input type="Password"
     class="form-control"
     name="user_pwd" 
     >
     
    
  </div>

  
  
  <button type="submit" name="lsubmit" class="btn btn-primary">Login</button>
  

 
</form>


</div>

</body>
</html>