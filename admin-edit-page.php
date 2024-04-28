<?php
    include("connection.php");

    if(isset($_GET['bID'])){
        $bookID=$_GET['bID'];
        $title=$_GET['title'];
        $pub_date=$_GET['pub_date'];
        $isbn=$_GET['isbn'];
        $bdesc=$_GET['bdesc'];
        unset($_GET['bID']);
    }
    

    if(isset($_POST["submit"])){
        $bookID=$_POST['bID'];
   
        $newTitle = $_POST["title"];
        $newPubDate = $_POST["pub_date"];
        $newISBN = $_POST["isbn"];
        $newBdesc = $_POST["bdesc"];

        if(isset($_FILES['bookCover'])){
            
            $img_name = $_FILES['bookCover']['name'];
            $img_size = $_FILES['bookCover']['size'];
            $img_tmp_name = $_FILES['bookCover']['tmp_name'];

        if($_FILES["bookCover"]["error"] === 0){
            $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
            $img_ex_lc = strtolower($img_ex);
            $validImageExtension = ['jpg', 'jpeg', 'png'];
            if(in_array($img_ex_lc, $validImageExtension)){
                $new_img_name = uniqid("IMG-", true).'.'.$img_ex_lc;
                $img_upload_path = 'img/'.$new_img_name;
                move_uploaded_file($img_tmp_name, $img_upload_path);

                $sql = "UPDATE books SET title='$newTitle', publication_date='$newPubDate', ISBN='$newISBN', book_desc='$newBdesc', book_cover='$new_img_name' WHERE book_ID = '$bookID'";

                if(mysqli_query($con, $sql)){
                    header("location: admin-page.php");
                }else{
                    echo "Error updating record: " .mysqli_error($con);
                }
            }
            else{
                echo "<script>alert('Invalid Image Extension');</script>";
            }
        }
        else{
                $sql = "UPDATE books SET title='$newTitle', publication_date='$newPubDate', ISBN='$newISBN', book_desc='$newBdesc' WHERE book_ID = '$bookID'";
                if(mysqli_query($con, $sql)){
                    header("location: admin-page.php");
                }else{
                    echo "Error updating record: " .mysqli_error($con);
                }
            }
        }
    }

    $sql = "SELECT * FROM books WHERE book_ID='$bookID'";
    $result = mysqli_query($con, $sql);

    echo "<link rel='stylesheet' href='css/admin-edit-page-style.css'>";

    echo "<form class='form' method='post' action='admin-edit-page.php' enctype='multipart/form-data'>";
    while($row = mysqli_fetch_array($result)){
        echo "<h1 style='text-align: center;'>Enter details of new book</h1>";
        echo "<p class='form-title'></p>";
        echo "<div class='input-container' style='font-weight: bold; font-size: 20px; color: #333; margin-bottom: 20px;'><input type='hidden' name='bID' value='$row[book_ID]'>Book ID : $row[book_ID]</div>";
        echo "Book Image: <div class='input-container'><input type='file' name='bookCover'></div>";
        echo "Book Title: <div class='input-container'><input type='text' name='title' value='$row[title]' required></div>";
        echo "Publication Date: <div class='input-container'><input type='date' name='pub_date' value='$row[publication_date]' required></div>";
        echo "ISBN: <div class='input-container'><input type='text' name='isbn' value='$row[ISBN]' required></div>";
        echo "Book Description: <div class='input-container'><input type='text' name='bdesc' value='$row[book_desc]' required></div>";
    }

    echo "<input class='submit' type='submit' value='Update' name='submit'>";
    echo "</form>";



    mysqli_close($con);
?>

<!--<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/admin-edit-page-style.css">
    <title>Login Page</title>
</head>
<body>
    <form class="form" method="post">
        <h1 style="text-align: center;">Enter details of new book</h1>
        <p class="form-title"></p>
        <div class="input-container">
            <input type="file" required>
        </div>
        <div class="input-container">
            <input type="text" value="<?php echo "$bookID"?>" required>
        </div>
        <div class="input-container">
            <input type="text" value="<?php echo "$title"?>" required>
        </div>
        <div class="input-container">
            <input type="text" value="<?php echo "$pub_date"?>" required>
        </div>
        <div class="input-container">
            <input type="text" value="<?php echo "$isbn"?>" required>
        </div>
        <div class="input-container">
            <input type="text" value="<?php echo "$bdesc"?>" required>
        </div>
        <input class="submit" type="submit" value="Update">
    </form>
</body>
</html>-->

