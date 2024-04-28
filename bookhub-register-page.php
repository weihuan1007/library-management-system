<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/log-in-page-style.css">
    <title>Register Page</title>
</head>
<body>
    <form class="form" method="post">
    <div style="display: flex; justify-content: center;">
        <img src="img/bookhub.jpg" alt="Book Hub Logo" width="105px" height="100px">
    </div>
        <h1 style="text-align: center;">Registration</h1>
        <p class="form-title">Enter your details</p>
        <div class="input-container">
            User ID:
            <input placeholder="Enter User ID (must be unique)" type="text" name="UserName" id="UserName" required>
        </div>
        <div class="input-container">
            Username:
            <input placeholder="Enter Your Name" type="text" name="Name" id="Name" required>
        </div>
        <div class="input-container">
            Email:
            <input placeholder="Enter email" type="email" name="Email" id="Email"required>
        </div>
        <div class="input-container">
            Password:
            <input placeholder="Enter password" type="password" name="Pass" required>
        </div>
        <div class="input-container">
            Confirm Password:
            <input placeholder="Re-enter password" type="password" name="Re-Pass" required>
        </div>
        <button class="submit" type="submit" name="submit">
            Register
        </button>
        <button class="submit" type="submit" name="back" onclick="backtoLogin()">
            Back To Login
        </button>
    </form>
</body>
</html>

<script>
    function backtoLogin() {
        window.location.href ="bookhub_log-in-page.php";
    }
    <?php
        include("connection.php");

        if(isset($_POST['submit'])){

            $UserName = isset($_POST['UserName']) ? $_POST['UserName'] : '';
            $Name = isset($_POST['Name']) ? $_POST['Name'] : '';
            $Email = isset($_POST['Email']) ? $_POST['Email'] : '';
            $Pass = $_POST['Pass'];
            $Date = date('Y-m-d');
            
            //for checking same user ID
            $sql = "SELECT * FROM bookhub_users WHERE user_ID = '$UserName'";
            $result = mysqli_query($con, $sql);

            if(mysqli_num_rows($result) > 0){
                ?>
                alert('User name "<?php echo $UserName?>" has been used by another user!');
                document.getElementById('UserName').value = '<?php echo $UserName?>';
                document.getElementById('Name').value = '<?php echo $Name?>';
                document.getElementById('Email').value = '<?php echo $Email?>';
                <?php
            } else {
                //for checking same user email
                $sql = "SELECT * FROM bookhub_users WHERE user_email = '$Email'";
                $result = mysqli_query($con, $sql);

                if(mysqli_num_rows($result) > 0){
                    ?>
                    alert('Email is already registered!');
                    document.getElementById('UserName').value = '<?php echo $UserName?>';
                    document.getElementById('Name').value = '<?php echo $Name?>';
                    document.getElementById('Email').value = '<?php echo $Email?>';
                    <?php
                }

                //for checking password
                else if((isset($_POST['Pass']) && !empty($_POST['Pass']))&&($_POST['Pass'] == $_POST['Re-Pass'])){
                    $hashedPass = password_hash($_POST['Pass'],CRYPT_SHA512);
                    
                    $sql = "INSERT INTO bookhub_users VALUES('$UserName', '$Name', '$Email', '$hashedPass', '$Date')";
                    $result = mysqli_query($con, $sql);

                    if($result){
                        ?>
                        alert('Successfully Registered as our User!');
                        document.location.href = 'bookhub_log-in-page.php';
                        <?php
                    }
                    else{
                        echo "Error:". mysqli_error($con);
                    }

                } else {
                    ?>
                    alert('Please ensure passwords entered are same');
                    document.getElementById('UserName').value = '<?php echo $UserName?>';
                    document.getElementById('Name').value = '<?php echo $Name?>';
                    document.getElementById('Email').value = '<?php echo $Email?>';
                    <?php
                }
            }
        }

        mysqli_close($con);
    ?>
</script>