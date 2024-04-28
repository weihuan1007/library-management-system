<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/user-profile-page-style.css">
    <title>BookHub</title>
</head>
    <body>
        <header>
            <div class="title">
                <div><img src="img/bookhub2.jpg" alt="BookHub Image" class="logo" width="270px" height="60px"></div>
            </div>
            <ul class="nav_link">
                <li><a href="main-page.php"><button class="btn">Home</button></a></li>
                <li><a href="return-book-page.php"><button class="btn">Return Book</button></a></li>
                <li><a href="user-profile-page.php"><button class="btn">User Profile</a></button></li>
                <li><a href="bookhub_log-in-page.php"><button class="btn">Logout</button></a></li>
            </ul>
        </header>
        <hr>

<form method="post">
    <table>
        <tr>
            <td>Current Password:</td>
            <td><input type="password" name="current_password" required></td>
        </tr>
        <tr>
            <td>New Password:</td>
            <td><input type="password" name="new_password" required></td>
        </tr>
        <tr>
            <td>Confirm Password:</td>
            <td><input type="password" name="confirm_password" required></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" value="Change Password" name="change-pass"></td>
        </tr>
    </table>
</form>

<?php
    include("connection.php");

    session_start();
    $userid = $_SESSION['userID'];

    if (isset($_POST['change-pass'])) {
        $currentPassword = $_POST['current_password'];
        $newPassword = $_POST['new_password'];
        $confirmPassword = $_POST['confirm_password'];

        $res=mysqli_query($con,"SELECT * FROM bookhub_users WHERE user_ID = '$userid'");
        if(mysqli_num_rows($res)>0){
            $row=mysqli_fetch_assoc($res);
            $verify = password_verify($currentPassword,$row['user_pass']);

            if($verify == 1){
                if ($newPassword !== $confirmPassword) {
                    echo "Both passwords do not match.";
                    exit;
                }

                $hashedPassword = password_hash($newPassword, CRYPT_SHA512);
                $sql = "UPDATE bookhub_users SET user_pass = '$hashedPassword' WHERE user_ID = '$userid'";
                $result = mysqli_query($con, $sql);

                if($result) {
                    echo "<script>
                            alert('Password changed successfully.');
                            window.location.href = 'user-profile-page.php';
                        </script>";
                }
                else {
                    echo "Error updating password.";
                }
            }
            else{
                echo "Please enter the correct current password.";
            }
        }
    }

    mysqli_close($con);
?>
    </body>
</html>