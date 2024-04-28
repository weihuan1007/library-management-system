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
        <h1 style="text-align: center;">Add New Admin</h1>
        <p class="form-title">Enter details for new admin</p>
        <div class="input-container">
            <input placeholder="Enter Admin ID" type="text" name="adminID" required>
        </div>
        <div class="input-container">
            <input placeholder="Enter Admin Name" type="text" name="adminName" required>
        </div>
        <div class="input-container">
            <input placeholder="Enter email" type="email" name="adminEmail" required>
        </div>
        <div class="input-container">
            <input placeholder="Enter password" type="password" name="adminPass" required>
        </div>
        <button class="submit" type="submit" name="submit">
            Add New Admin
        </button>
    </form>
</body>
</html>

<?php
    include("connection.php");

    if(isset($_POST['submit'])){
        unset($adminID);

        $adminID = $_POST['adminID'];
        $adminName = $_POST['adminName'];
        $adminEmail = $_POST['adminEmail'];
        $adminPass = $_POST['adminPass'];
        $adminDate = date('Y-m-d');

        $sql = "SELECT * FROM users WHERE user_email = '$adminEmail'";
        $result = mysqli_query($con, $sql);

        if(mysqli_num_rows($result) > 0){
            echo "<script>
                alert('Email is already registered!');
                document.location.href = 'admin-add-admin-page.php';
            </script>";
        }
        else{
            $sql = "INSERT INTO users VALUES('$adminID', '$adminName', '$adminEmail', '$adminPass', '$adminDate', 1)";
            $result = mysqli_query($con, $sql);

            if($result){
                echo "<script>
                    alert('Successfully Added A New Admin');
                    document.location.href = 'admin-page.php';
                </script>";
            }
            else{
                echo "Error:". mysqli_error($con);
            }
        }
    }

    mysqli_close($con);
?>