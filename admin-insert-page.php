<?php
    include("connection.php");

    if(isset($_POST['submit'])){

        $bID = $_POST['bID'];
        $bTitle = $_POST['bTitle'];
        $pubDate = $_POST['pubDate'];
        $isbn = $_POST['isbn'];
        $bdesc = $_POST['bdesc'];

        if($_FILES["image"]["error"] === 4){
            echo "<script>alert('Image Does Not Exist');</script>";
        }
        else{
            $fileName = $_FILES["image"]["name"];
            $fileSize = $_FILES["image"]["size"];
            $tmpName = $_FILES["image"]["tmp_name"];

            $img_ex = pathinfo($fileName, PATHINFO_EXTENSION);
            $img_ex_lc = strtolower($img_ex);

            $validImageExtension = ['jpg', 'jpeg', 'png'];
            if(in_array($img_ex_lc, $validImageExtension)){
                $new_img_name = uniqid("IMG-", true).'.'.$img_ex_lc;
                $img_upload_path = 'img/'.$new_img_name;
                move_uploaded_file($tmpName, $img_upload_path);
                $query = "INSERT INTO books VALUES('$bID', '$bTitle', '$pubDate', '$isbn', '$bdesc', '$new_img_name', 1)";
                if(mysqli_query($con, $query)){
                    echo "<script>
                        alert('Successfully Added');
                        document.location.href = 'admin-page.php';
                    </script>";
                }
                else{
                    echo "Error:". mysqli_error($con);
                }
            }else{
                echo "<script>alert('Invalid Image Extension');</script>";

            }
        }

        /*var_dump($_POST);
        $image = addslashes(file_get_contents($_FILES["bookCover"]['tmp_name']));
        $sql = "INSERT INTO books VALUES('$bID', '$bTitle', '$pubDate', '$isbn', '$bdesc', '$image')";
        $result = mysqli_query($con, $sql);
        if(!$con){
            die("Error: " . mysqli_connect_error());
        }

        if($result) {
            // Book added successfully
            echo "<script>alert('Book added successfully!')</script>";
            header("Location: admin-page.php");
            exit();
        } else {
            echo "hi";
            // Error occurred while adding the book
            echo "Error: " . mysqli_error($con);
        }*/

    }

    echo "<link rel='stylesheet' href='css/admin-insert-page-style.css'>";

    echo "<form class='form' method='post' action='admin-insert-page.php' enctype='multipart/form-data'>";
        echo "<h1 style='text-align: center;'>Insert details of new book</h1>";
        echo "<p class='form-title'></p>";
        echo "<div class='input-container'>Book Cover:<br><input type='file' name='image'></div>";
        echo "<div class='input-container'>Book ID:<br><input placeholder='Enter Book ID' name='bID' type='text' maxlength = '10' required></div>";
        echo "<div class='input-container'>Book Title:<br><input placeholder='Enter Book Title' name='bTitle' type='text' required></div>";
        echo "<div class='input-container'>Publication Date:<br><input name='pubDate' type='date' required></div>";
        echo "<div class='input-container'>ISBN:<br><input placeholder='Enter ISBN' type='text' name='isbn' required></div>";
        echo "<div class='input-container'>Book Description:<br><input placeholder='Enter Book Description' name='bdesc' type='text' required></div>";
    echo "<input class='submit' type='submit' value='Add New Book' name='submit'>";
    echo "<br><a href='admin-page.php' class='btn'>Go Back</a>";
    echo "</form>";

    mysqli_close($con);
?>