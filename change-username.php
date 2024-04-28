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
            <td>New Username:</td>
            <td><input type="text" name="new_username" required></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" value="Change Username" name="change-username"></td>
        </tr>
    </table>
</form>

<?php
    include("connection.php");

    session_start();
    $userid = $_SESSION['userID'];

    if (isset($_POST['change-username'])) {
        $new_username = $_POST['new_username'];

        $res=mysqli_query($con,"SELECT * FROM bookhub_users WHERE user_ID = '$userid'");
        if(mysqli_num_rows($res)>0){
            $row=mysqli_fetch_assoc($res);

                    $sql = "UPDATE bookhub_users SET user_name = '$new_username' WHERE user_ID = '$userid'";
                    $result = mysqli_query($con, $sql);
    
                    if($result) {
                        echo "<script>
                                alert('Username changed successfully.');
                                window.location.href = 'user-profile-page.php';
                            </script>";
                    }
                    else {
                        echo "Error updating username.";
                    }
                }
            }
    mysqli_close($con);
?>
    </body>
</html>