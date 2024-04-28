<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main-page-style.css">
    <title>Show Admin Page</title>
    <script>
        function confirmDelete(bookID) {
            var result = confirm('Are you sure you want to delete this book?');
            if (result) {
                window.location.href = 'admin-delete-page.php?book=' + bookID;
            }
        }
    </script>
</head>
<body>
    <header>
        <div class="title">
            <div><img src="img/bookhub2.jpg" alt="BookHub Image" class="logo" width="270px" height="60px"></div>
        </div>
        <ul class="nav_link">
            <li><a href="admin-page.php"><button class="btn">Home</button></a></li>
            <li><a href="admin-add-admin-page.php"><button class="btn">Add New Admin</button></a></li>
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

    $sql = "SELECT * FROM users";
    $result = mysqli_query($con, $sql);

    if(mysqli_num_rows($result) > 0){
        echo "<br><br><table style='width: 80%; border-collapse: collapse; margin-left: auto; margin-right: auto;'>
            <tr>
            <th style='padding: 5px; border: 1px solid #ddd; background-color: #f2f2f2;'>Admin ID</th>
            <th style='padding: 5px; border: 1px solid #ddd; background-color: #f2f2f2;'>Admin Username</th>
            <th style='padding: 5px; border: 1px solid #ddd; background-color: #f2f2f2;'>Admin Email</th>
            <th style='padding: 5px; border: 1px solid #ddd; background-color: #f2f2f2;'>Registration Date</th>
            </tr>";

        while($row = mysqli_fetch_array($result)){
            echo "<tr>
                <td style='padding: 5px; border: 1px solid #ddd;'>" . $row['user_ID'] . "</td>
                <td style='padding: 5px; border: 1px solid #ddd;'>" . $row['user_name'] . "</td>
                <td style='padding: 5px; border: 1px solid #ddd;'>" . $row['user_email']. "</td>
                <td style='padding: 5px; border: 1px solid #ddd;'>" . $row['registration_date']. "</td>
            </tr>";
        }
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
?>
