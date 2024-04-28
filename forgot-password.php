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
        <p class="form-title">Password Recovery</p>
        <div class="input-container">
            User ID:
            <input placeholder="Enter User ID" type="text" name="user">
        </div>
        <div class="input-container">
            Email:
            <input placeholder="Enter Email" type="email" name="email">
        </div>
            <button class="submit" type="submit" name="submit">
                Submit
            </button>
            <button class="submit" type="button" name="back" onclick="backtoLogin()">
            Back To Login
            </button>
    </form>
</body>
</html>

<script>
    function backtoLogin() {
        window.location.href ="bookhub_log-in-page.php";
    }
</script>

<?php
    include("connection.php");
    session_start();

    if(isset($_POST['user'])){
        $_SESSION['user-session'] = $_POST['user'];
    }
    


    if(isset($_POST['submit'])){
        if((isset($_POST['user']) && !empty($_POST['user']))&&(isset($_POST['email']) && !empty($_POST['email']))){
            $username = $_POST['user'];
            $email = $_POST['email'];

            $res=mysqli_query($con,"SELECT * FROM bookhub_users WHERE user_ID = '$username'");
            if(mysqli_num_rows($res)>0){
                $row=mysqli_fetch_assoc($res);
                if (($row['user_email']) != $email){
                    echo "Your email is incorrect!";
                    exit;
                }
                else{
                    echo '<input type="hidden" name="user" value="<?php echo $_SESSION["userID]; ?>">';
                    echo '<script>
                    alert("Verification Code was sent to your email.");
                    window.location.href = "verification-page.php";
                    </script>';
                }
            }
        
        } else if(empty($_POST['user']) || empty($_POST['email'])){
            echo '<script>
                window.alert("Please fill in both User ID and Email");
            </script>';
        }
    }
    mysqli_close($con);
?>