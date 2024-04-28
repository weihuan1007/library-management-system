<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/log-in-page-style.css">
    <title>Login Page</title>
    <script>
        function backtoLogin() {
            window.location.href = "bookhub_log-in-page.php";
        }
    </script>
</head>

<body>
    <form class="form" method="post">
        <div style="display: flex; justify-content: center;">
            <img src="img/bookhub.jpg" alt="Book Hub Logo" width="105px" height="100px">
        </div>
        <h1 style="text-align: center;">Welcome to Book Hub !</h1>
        <p class="form-title">Login to your account</p>
        <div class="input-container">
            <p>The Verification Code was sent to your email</p>
            Verification Code:
            <input placeholder="Enter Verification Code" type="text" name="code" maxlength="4" required>
        </div>
        <div class="input-container">
            New Password:
            <input placeholder="Enter New Password" type="password" name="new-pass" required>
        </div>
        <div class="input-container">
            Confirm Password:
            <input placeholder="Enter Confirm Password" type="password" name="confirm-pass" required>
        </div>
        <?php
        include("connection.php");
        session_start();
        $userid = $_SESSION['user-session'];

        if (isset($_POST['submit'])) {
            if (isset($_POST['code']) && !empty($_POST['code'])) {
                $verification = $_POST['code'];
                $newPassword = $_POST['new-pass'];
                $confirmPassword = $_POST['confirm-pass'];

                if ($verification == "AB12") {
                    $res = mysqli_query($con, "SELECT * FROM bookhub_users WHERE user_ID = '$userid'");
                    if (mysqli_num_rows($res) > 0) {
                        $row = mysqli_fetch_assoc($res);

                        if ($newPassword !== $confirmPassword) {
                            echo "<p style='color:red';>Both passwords do not match.";
                        }
                        else{
                            $hashedPassword = password_hash($newPassword, CRYPT_SHA512);
                            $sql = "UPDATE bookhub_users SET user_pass = '$hashedPassword' WHERE user_ID = '$userid'";
                            $result = mysqli_query($con, $sql);
    
                            if ($result) {
                                echo "<script>
                                alert('Password changed successfully.');
                                window.location.href = 'bookhub_log-in-page.php';
                            </script>";
                                exit;
                            } else {
                                echo "Error updating password: " . mysqli_error($con);
                            }
                        }
                    }
                } else {
                    echo "<script>
                    alert('Wrong Verification Code.');
                    window.location.href = 'bookhub_log-in-page.php';
                </script>";
                }
            }
        }
        ?>
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