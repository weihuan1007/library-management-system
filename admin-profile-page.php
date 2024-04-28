<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main-page-style.css">
    <title>Admin Page</title>
</head>
<body>
    <header>
        <div class="title">
            <div><img src="img/bookhub2.jpg" alt="BookHub Image" class="logo" width="270px" height="60px"></div>
        </div>
        <ul class="nav_link">
            <li><a href="admin-page.php"><button class="btn">Home</button></a></li>
            <li><a href="admin-profile-page.php"><button class="btn">My Profile</button></a></li>
            <li>
                <form action="" method="post" style="display:inline;">
                    <input class="btn" type='submit' value='Logout' name="logout" style="background-color: red;">
                </form>
            </li>        
        </ul>
    </header>
    <hr>
</body>
</html>

<?php
    include("connection.php");

    session_start();
    
    $admin_ID = $_SESSION['admin_email'];
    $admin_pass = $_SESSION['admin_pass'];

    $sql = "SELECT * FROM users WHERE user_email = '$admin_ID' and user_pass = '$admin_pass'";
    $result = mysqli_query($con, $sql);

    echo "<form action='' method='post'><table>";
    while($row = mysqli_fetch_array($result)){
        echo '<table><tr><td>Admin ID : </td>';
        echo '<td>'. $row['user_ID'] .'</td></tr>';
        echo '<table><tr><td>Admin Name : </td>';
        echo '<td>'. $row['user_name'] .'</td></tr>';
        echo '<table><tr><td>Admin Email : </td>';
        echo '<td>'. $row['user_email'] .'</td></tr>';
        echo '<table><tr><td>Registration Date : </td>';
        echo '<td>'. $row['registration_date'] .'</td></tr>';
        echo "<td>
        <form action='' method='post'>
                            <input type='hidden' name='user_ID' value='" . $row['user_ID'] . "'>
                            <input class='submit' type='submit' value='Terminate Account' name='TerminateAccount'>
        </form>
        </td>";
    }
    echo "</form></table>";

    if(isset($_POST['terminate'])){
        echo "<script>
            window.location.href = 'bookhub_log-in-page.php';
        </script>";
    }

    if (isset($_POST['TerminateAccount'])) {
        
        $Sql = "SELECT COUNT(*) FROM users WHERE acc_status = TRUE";
        
        if(mysqli_query($con, $Sql)==1){
            echo "<script>
                alert('You are the last admin, unable to terminate your account!');
                window.location.href = 'admin-profile-page.php';
            </script>";
        }

        else{
            echo "<script>
                var confirmed = confirm('Are you sure you want to terminate your account?');
                if (confirmed) {
                    window.location.href = 'admin-profile-page.php?confirm=true&user_ID=" . $_POST['user_ID'] . "';
                } else {
                    window.location.href = 'admin-profile-page.php';
                }
            </script>";
        }
    }

    if (isset($_GET['confirm']) && $_GET['confirm'] == 'true') {
        $admin_ID = $_GET['user_ID'];
    
        $updateSql = "UPDATE users SET acc_status = 'false' WHERE user_ID = '$admin_ID'";
        mysqli_query($con, $updateSql);
    
        echo "<script>window.location.href = 'log-in-page.php';</script>";
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

    mysqli_close($con);
?>