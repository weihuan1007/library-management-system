<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/book-page-style.css">
    <title>Document</title>
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
</body>
</html>

<?php
    include("connection.php");

    $bookID = $_GET['bID'];
    $sql = "SELECT * FROM books WHERE book_ID = '$bookID'";
    $result = mysqli_query($con, $sql);

    echo "<form action='' method='post'><table>";
    while($row = mysqli_fetch_array($result)){
        $image = $row['book_cover'];
        echo '<div class="book-image"><tr><td><img src=img/'. $row['book_cover'] . ' alt="Book Cover" style="width: 150px; height: 200px;"></td></tr></table></div>';
        echo '<div class="book-details"><table><tr><td>Book ID : </td>';
        echo '<td>'. $bookID .'</td></tr>';
        echo '<tr><td>Book Title : </td>';
        echo '<td>'. $row['title'] .'</td></tr>';
        echo '<tr><td>Publication Date : </td>';
        echo '<td>'. $row['publication_date'] .'</td></tr>';
        echo '<tr><td>ISBN : </td>';
        echo '<td>'. $row['ISBN'] .'</td></tr>';
        echo '<tr><td>Desciption : </td>';
        echo '<td>'. $row['book_desc'] .'</td></tr></table></div>';
        
        $sql = "SELECT * FROM reviews WHERE book_ID = '$bookID'";
        $result = mysqli_query($con, $sql);

        echo "<form action='' method='post'><div class='reviews'><table>";
        echo '<br><tr><td><label for="">Reviews :</label></td></tr>';
        while($row = mysqli_fetch_array($result)){
            echo '<tr><td><u><label for="">'. $row['user_ID'] .'<br></label></u></td></tr>';
            echo '<tr><td><label for="">'. $row['review'] .'<br></label></td></tr>';
            echo '<tr><td><br></td></tr>';
        }
        echo "</form></table></div>";
    }
    
    echo "</form></table>";

    mysqli_close($con);
?>

