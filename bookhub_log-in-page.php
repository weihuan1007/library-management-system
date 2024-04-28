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
        <div style="display: flex; justify-content: center;">
            <img src="img/bookhub.jpg" alt="Book Hub Logo" width="105px" height="100px">
        </div>
        <h1 style="text-align: center;">Welcome to Book Hub !</h1>
        <p class="form-title">Login to your account</p>
        <div class="input-container">
            User ID:
            <input placeholder="Enter User ID" type="text" name="user">
        </div>
        <div class="input-container">
            Password:
            <input placeholder="Enter Password" type="password" name="pass">
        </div>
            <div>
                <a href="forgot-username.php">Forgot UserID?</a>
                <a href="forgot-password.php">Forgot Password?</a> &nbsp;&nbsp;&nbsp;
            </div>
            <button class="submit" type="submit" name="submit">
                Login
            </button>
            <button class="submit" type="submit" name="register">
                First time user? Register
            </button>
            <div style="display: flex; justify-content: center;">
                <a href="log-in-page.php">Admin Login</a> 
            </div>
    </form>
</body>
</html>

<?php
    include("connection.php");
    session_start();


    if(isset($_POST['submit'])){
        if((isset($_POST['user']) && !empty($_POST['user']))&&(isset($_POST['pass']) && !empty($_POST['pass']))){
            $username = $_POST['user'];
            $password = $_POST['pass'];

            $res=mysqli_query($con,"SELECT * FROM bookhub_users WHERE user_ID = '$username'");
            if(mysqli_num_rows($res)>0){
                $row=mysqli_fetch_assoc($res);
                $verify = password_verify($password,$row['user_pass']);
                if($verify == 1) {
                    $_SESSION['username'] = $username; // Store the username in a session variable
                    header("Location: main-page.php");
                }
                else{
                    echo '<script>
                    window.location.href = "bookHub_log-in-page.php";
                    alert("Login Failed. Invalid Username or Password !!!")
                    </script>';
                }
            }
        } else if(empty($_POST['user']) || empty($_POST['pass'])){
            echo '<script>
                window.alert("Please fill in both Email and Password");
            </script>';
        }
    }

    

    if(isset($_POST['register'])){
        echo '<script>
            window.location.href="bookhub-register-page.php";
        </script>';
    }

    $_SESSION['userID'] = $username;

    mysqli_close($con);
?>