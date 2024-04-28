<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main-page-style.css">
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
        <div class="image-container">
            <img src="img/bookhub.jpg" alt="BookHub Image" width="210px" height="200px">
        </div>
        <div class="search-container">
            <form action="" method="post">
                <table>
                    <tr>
                        <td>
                            <select name="searchBy">
                                <option value="BookTitle">Book Title</option>
                                <option value="BookID">Book ID</option>
                                <option value="ISBN">ISBN</option>
                            </select>
                        </td>
                        <td><input type="text" placeholder="Search any book name" class="search" name="search" id="search" style="margin-left: 30px;"></td>
                        <td><input type="submit" value="Search" class="btn-enter" name="submit"></td>
                        <td><input type="submit" value="All Books" class="btn-enter" name="all"></td>
                    </tr>
                </table>
            </form>
        </div>
    </body>
</html>

<?php
    include("connection.php");
   
    session_start();
    $username = isset($_SESSION['username']) ? $_SESSION['username'] : '';

    $sql = "SELECT * FROM books";
    $result = mysqli_query($con, $sql);

    if(isset($_POST['all'])){
        $search = '';
        ?> <script> document.getElementById('search').value = '<?php echo $search?>'; </script> <?php
    }

    if(isset($_POST['submit'])){
        $search = $_POST['search'];
        $searchBy = $_POST['searchBy'];

        ?> <script> document.getElementById('search').value = '<?php echo $search?>'; </script> <?php

        if(!empty($search)){
            if($searchBy == "BookTitle"){
            $sql = "SELECT * FROM books WHERE title LIKE '%$search%'";
            }else if($searchBy == "BookID"){
            $sql = "SELECT * FROM books WHERE book_ID LIKE '%$search%'";
            }else if($searchBy == "ISBN"){
            $sql = "SELECT * FROM books WHERE ISBN LIKE '%$search%'";
            }

            $result = mysqli_query($con, $sql);
        }
    }


    if(mysqli_num_rows($result) > 0){
        echo "<br><br><table style='width: 80%; border-collapse: collapse; margin-left: auto; margin-right: auto;'>
            <tr>
            <th style='padding: 8px; border: 1px solid #ddd; background-color: #f2f2f2;'>Book Cover</th>
            <th style='padding: 8px; border: 1px solid #ddd; background-color: #f2f2f2;'>Book ID</th>
            <th style='padding: 8px; border: 1px solid #ddd; background-color: #f2f2f2;'>Title</th>
            <th style='padding: 8px; border: 1px solid #ddd; background-color: #f2f2f2;'>Publication Date</th>
            <th style='padding: 8px; border: 1px solid #ddd; background-color: #f2f2f2;'>ISBN</th>
            <th style='padding: 8px; border: 1px solid #ddd; background-color: #f2f2f2;'>Description</th>
            <th style='padding: 5px; border: 1px solid #ddd; background-color: #f2f2f2;'>Status</th>
            </tr>";

        while($row = mysqli_fetch_assoc($result)){
            echo "<tr>
                <td style='padding: 8px; border: 1px solid #ddd; text-align: center;'><img src=img/". $row['book_cover'] . " alt='Book Cover' style='width: 150px; height: 200px;'></td>
                <td style='padding: 8px; border: 1px solid #ddd;'><a href='book-page.php?bID=". $row['book_ID'] ."'>" . $row['book_ID'] . "</a></td>
                <td style='padding: 8px; border: 1px solid #ddd;'>" . $row['title'] . "</td>
                <td style='padding: 8px; border: 1px solid #ddd;'>" . $row['publication_date']. "</td>
                <td style='padding: 8px; border: 1px solid #ddd;'>" . $row['ISBN']. "</td>
                <td style='padding: 8px; border: 1px solid #ddd;'>" . $row['book_desc'] . "</td>
                <td style='padding: px; border: 1px solid #ddd;'>";
                // Display "Available" if true, otherwise display "Not available"
                echo ($row['book_status'] == 1) ? "Available" : "Not available";
                "</td>";

                // Display "Available" if true, otherwise display "Not available"
                echo ($row['book_status'] == 1) ? 
                "<td style='padding: 10px;'>
                <a href='borrow-book-page.php?bID=" . $row['book_ID'] . "' class='btn-borrow'>Borrow</a>
                </td>": "";

            "</tr>";
        }
    }
    else{
        echo "<div style='text-align: center;'><p class='no-books'>No books found!</p></div>";
        $sql = "SELECT * FROM books";
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





    echo "</table>";

    mysqli_close($con);
?>