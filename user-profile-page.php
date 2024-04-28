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
                <li>
                <form action="" method="post" style="display:inline;">
                    <input class="btn" type='submit' value='Logout' name="logout" style="background-color: red;">
                </form>
                </li>
                </ul>
        </header>
        <hr>



<?php
    include("connection.php");

    session_start();
    $userid = $_SESSION['userID'];

    $sql = "SELECT * FROM bookhub_users WHERE user_ID = '$userid'";
    $result = mysqli_query($con, $sql);

    echo "<form action='' method='post'><table>";
    while($row = mysqli_fetch_array($result)){
        echo '<table><tr><td>User ID : </td>';
        echo '<td>'. $userid .'</td></tr>';
        echo '<tr><td>Username : </td>';
        echo '<td>'. $row['user_name'] .'</td></tr>';
        echo '<tr><td>User Email: </td>';
        echo '<td>'. $row['user_email'] .'</td></tr>';
        echo '<tr><td>Registration Date : </td>';
        echo '<td>'. $row['registration_date'] .'</td></tr></table>';
    }

    if (isset($_POST['logout'])) {
        echo "<script>
            var confirmed = confirm('Are you sure you want to logout?');
            if (confirmed) {
                $username = '';
                window.location.href = 'bookhub_log-in-page.php';
            }
        </script>";
    }

    echo "</form></table>";
?>

<form method="post">
    <table>
        <tr>
            <td>Change Username:</td>
            <td><button type="button" onclick="changeUsername()">Change Username</button></td>
        </tr>
        <tr>
            <td>Change Email:</td>
            <td><button type="button" onclick="changeEmail()">Change Email</button></td>
        </tr>
        <tr>
            <td>Change Password:</td>
            <td><button type="button" onclick="changePassword()">Change Password</button></td>
        </tr>
    </table>
</form>

<script>
    function changeUsername() {
        window.location.href ="change-username.php"
    }

    function changeEmail() {
        window.location.href = "change-email.php";
    }

    function changePassword() {
        window.location.href = "change-password.php";
    }
</script>
</html>