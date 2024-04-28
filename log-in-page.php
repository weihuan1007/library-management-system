<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/log-in-page-style.css">
    <title>Login Page</title>
</head>
<body>
    <form class="form" method="post">
        <h1 style="text-align: center;">Welcome to Book Hub !</h1>
        <p class="form-title">Login as admin</p>
            <div class="input-container">
            <input placeholder="Enter email" type="email" name="user" required>
        </div>
        <div class="input-container">
            <input placeholder="Enter password" type="password" name="pass" required>   
        </div>
        <button class="submit" type="submit" name="submit">
            Login
        </button>
        <div style="display: flex; justify-content: center;">
                <a href="bookhub_log-in-page.php">User Login</a> 
        </div>
    </form>
</body>
</html>

<?php
    include("connection.php");

    session_start();
    
    if(isset($_POST['submit'])){
        $username = $_POST['user'];
        $password = $_POST['pass'];

        $sql = "SELECT * FROM users WHERE user_email = '$username' and user_pass = '$password' and acc_status = TRUE";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_array($result);
        $count = mysqli_num_rows($result);

        if($count == 1){
            header("Location: admin-page.php");
        }
        else{
            echo '<script>
                window.location.href = "log-in-page.php";
                alert("Login Failed. Invalid Username or Password !!!")
            </script>';
        }
    }

    $_SESSION['admin_email'] = $username;
    $_SESSION['admin_pass'] = $password;
?>