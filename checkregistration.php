<?php
session_start();
require_once('db.php');
if (isset($_POST['ssubmit'])) {
    
    $FName = $_POST['FName'];
    $LName = $_POST['LName'];
    $Email = $_POST['Email'];
    $username = $_POST['username'];
    $user_pwd = $_POST['user_pwd'];
    $CPassword = $_POST['CPassword'];

    // Check for empty fields
    if (empty($FName) || empty($LName) || empty($Email) || empty($username) || empty($user_pwd) || empty($CPassword)) {
        header("Location: users.php?signup=empty_fields");
        exit();
    } else if (!preg_match("/^[a-zA-Z]*$/", $FName) || !preg_match("/^[a-zA-Z]*$/", $LName)) {
        header("Location: users.php?signup=invalidnames");
        exit();
    } elseif ($user_pwd != $CPassword) {
        header("Location: users.php?error=passwords_dont_match");
        exit();
    } else if (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
        header("Location: users.php?signup=invalid_email");
        exit();
    // Validate password strength
    } else if (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{7,}$/', $user_pwd)) {
        // Password must be a minimum of 7 characters long and include at least one letter and one number
        header("Location: users.php?signup=password_not_strong");
        exit();
    } else {
        $check_user_existence = "SELECT * FROM users WHERE username = '{$username}'";
        $check_user_result = mysqli_query($conn, $check_user_existence);
        if (mysqli_num_rows($check_user_result) > 0) {
            header("Location: users.php?signup=user_taken");
            exit();
        } else {
            $hashed_pwd = password_hash($CPassword, PASSWORD_DEFAULT);
            
            $sql = "INSERT INTO users(FName, LName, Email, username, password) VALUES('$FName', '$LName', '$Email', '$username', '$hashed_pwd')";
            $datacheck = mysqli_query($conn, $sql);          
            header('Location: users.php?status=user_added_successfully');
        }
    }
}
?>
