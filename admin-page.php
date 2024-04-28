<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main-page-style.css">
    <title>Admin Page</title>
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
            <li><a href="admin-show.php"><button class="btn">Admin</button></a></li>
            <li><a href="admin-insert-page.php"><button class="btn">Add New Book</button></a></li>
            <li><a href="fine-page.php"><button class="btn">Fine</button></a></li>
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
    

    $sql = "SELECT * FROM books";
    $result = mysqli_query($con, $sql);

    if(mysqli_num_rows($result) > 0){
        echo "<br><br><table style='width: 80%; border-collapse: collapse; margin-left: auto; margin-right: auto;'>
            <tr>
            <th style='padding: 5px; border: 1px solid #ddd; background-color: #f2f2f2;'>Book Cover</th>
            <th style='padding: 5px; border: 1px solid #ddd; background-color: #f2f2f2;'>Book ID</th>
            <th style='padding: 5px; border: 1px solid #ddd; background-color: #f2f2f2;'>Title</th>
            <th style='padding: 5px; border: 1px solid #ddd; background-color: #f2f2f2;'>Publication Date</th>
            <th style='padding: 5px; border: 1px solid #ddd; background-color: #f2f2f2;'>ISBN</th>
            <th style='padding: 5px; border: 1px solid #ddd; background-color: #f2f2f2;'>Description</th>
            <th style='padding: 5px; border: 1px solid #ddd; background-color: #f2f2f2;'>Status</th>
            </tr>";

        while($row = mysqli_fetch_array($result)){
            $image = $row['book_cover'];
            echo "<tr>
                <td style='padding: 5px; border: 1px solid #ddd; text-align: center;'>";?><img src="img/<?=$row['book_cover']?>" alt='Book Cover' style='width: 150px; height: 200px;'><?php echo "</td> <!--shorthand notation-->
                <td style='padding: 5px; border: 1px solid #ddd;'>" . $row['book_ID'] . "</td>
                <td style='padding: 5px; border: 1px solid #ddd;'>" . $row['title'] . "</td>
                <td style='padding: 5px; border: 1px solid #ddd;'>" . $row['publication_date']. "</td>
                <td style='padding: 5px; border: 1px solid #ddd;'>" . $row['ISBN']. "</td>
                <td style='padding: 5px; border: 1px solid #ddd;'>" . $row['book_desc'] . "</td>
                <td style='padding: 5px; border: 1px solid #ddd;'>";
                // Display "Available" if true, otherwise display "Not available"
                echo ($row['book_status'] == 1) ? "Available" : "Not available";
                echo "</td>
                <td style='padding: 10px;'>
                    <a href='admin-edit-page.php?bID=$row[book_ID]&title=$row[title]&pub_date=$row[publication_date]&isbn=$row[ISBN]&bdesc=$row[book_desc]' class='btn-edit'>Edit
                    <br><a href='#' class='btn-delete' onclick='confirmDelete(\"$row[book_ID]\")'>Delete</a></a>
                </td>
            </tr>";
        }
    }
    else{
        echo "Please add new book!";
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