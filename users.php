<?php

$host = 'localhost';
$username = 'root'; //  db username
$password = ''; //  db password
$dbname = 'risk'; // database name

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);
session_start();
require_once('db.php');
if(!isset($_SESSION["loggedin"]) ){
  header("location:login.php");
}
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$fullUrl="http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
if(strpos($fullUrl,"signup=empty_fields")==true){
echo"<p style=background-color:red;>Fill in all fields!!<p>";

}


  elseif(strpos($fullUrl,"signup=invalidnames")==true){
    echo"<p style=background-color:red;>Invalid First Name and Last Name(only alphabets required)!!<p>";
 
    }

    elseif(strpos($fullUrl,"error=passwords_dont_match")==true){
      echo"<p style=background-color:red;>Passwords don't match!!<p>";
   
      }
      elseif(strpos($fullUrl,"signup=invalid_email")==true){
        echo"<p style=background-color:red;>Invalid Email!!<p>";
         }


         elseif(strpos($fullUrl,"signup=user_taken")==true){
          echo"<p style=background-color:red;>Username is taken!!<p>";
       
          }

          elseif(strpos($fullUrl,"signup=password_not_strong")==true){
            echo"<p style=background-color:red;>Password is not strong<p>";
         
            }
         
        

// SQL query to fetch users
$sql = "SELECT id,FName, LName, Email,username FROM users"; 
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <style>
      .body {
        margin: 0;
            padding: 0px;
            
             font-family: 'Lato', sans-serif;
        }   
        .table {
            padding: 15px;
            background-color: #e9ecef;
            border-radius: 10px;
            margin-bottom: 15px;
        }
        .scrollable-table {
            max-height: 300px;
            overflow-y: auto;
        }
        .custom-bg-color {
    background-color: #1c2230; 
}
     .nav-link {
    color: white;
   }
        .navbar-brand {
    color: white; 
}
    </style>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
<style>
    body {
        background-color: #c6d5f9;
    }
    </style>
<nav class="navbar navbar-expand-lg navbar-dark custom-bg-color sticky-top">
    <a class="navbar-brand" href="#">User Management</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
            <a class="nav-link btn btn-primary text-white" href="#" data-toggle="modal" data-target="#addUserModal">Add User</a>
            </li>
            <li class="nav-item ">
                    <a class="nav-link" href="index.php">Go back</a>
                </li>
       
        </ul>
    </div>
</nav>

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="checkregistration.php"  method="POST">
                <div class="mb-3">
    <label for="FName"
     class="form-label">First Name</label>
    <input type="text"
     class="form-control"
     name="FName"
      id="FName"  required>
     
     
    
  </div>
  <div class="mb-3">
    <label for="LName"
     class="form-label">Last Name</label>
    <input type="text"
     class="form-control"
     name="LName"
      id="LName"  required>
    
  </div>

  <div class="mb-3">
    <label for="Email"
     class="form-label">Email</label>
    <input type="text"
    name="Email"
     class="form-control"
      id="Email"  required>
    
  </div>

  <div class="mb-3">
    <label for="Username"
     class="form-label">Username</label>
    <input type="text"
    name="username"
     class="form-control"
      id="username"  required>
    
  </div>

   <div class="mb-3">
    <label for="PPassword"
     class="form-label">Password</label>
    <input type="Password"
    name="user_pwd"
     class="form-control"
      id="user_pwd"

    
      required
     >
    
  </div>
  <div class="mb-3">
    <label for="CPassword"
     class="form-label">Confirm Password</label>
    <input type="Password"
     class="form-control"
     name="CPassword"
      id="CPassword"  required>
    
  </div>

  
  
  <button type="submit" name="ssubmit" class="btn btn-primary">Create account</button>
 
</form>


</div>

                </form>
            </div>
           
        </div>
    </div>
</div>


<div class="container mt-4">
    <h2>Users</h2>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Username</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result && $result->num_rows > 0) {
                // Output data of each row
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . htmlspecialchars($row["id"]) . "</td>
                            <td>" . htmlspecialchars($row["FName"]) . "</td>
                            <td>" . htmlspecialchars($row["LName"]) . "</td>
                            <td>" . htmlspecialchars($row["Email"]) . "</td>
                            <td>" . htmlspecialchars($row["username"]) . "</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No users found</td></tr>";
            }
            $conn->close();
            ?>
        </tbody>
    </table>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
        