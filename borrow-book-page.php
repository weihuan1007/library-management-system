<?php
    include("connection.php");
    
    session_start();
    $username = isset($_SESSION['username']) ? $_SESSION['username'] : 'no name';

    if(isset($_GET['bID'])){
        $bookID=$_GET['bID'];
        unset($_GET['bID']);
    }

    $sql = "SELECT * FROM books WHERE book_ID='$bookID'";
    $result = mysqli_query($con, $sql);

    echo "<link rel='stylesheet' href='css/admin-edit-page-style.css'>";

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        echo "<table style='width: 80%; border-collapse: collapse; margin-left: auto; margin-right: auto;'>
            <tr>
            <td style='padding: 8px; border: 0px solid #ddd; text-align: left;'>Book Cover:</td>
                <td style='padding: 8px; border: 1px solid #ddd; text-align: center;'><img src='img/" . $row['book_cover'] . "' alt='Book Cover' style='width: 150px; height: 200px;'></td>
            </tr>
            <tr>
                <td style='padding: 8px; border: 0px solid #ddd; text-align: left;'>Book ID:</td>
                <td style='padding: 8px; border: 1px solid #ddd;'><a href='book-page.php?bID=" . $row['book_ID'] . "'>" . $row['book_ID'] . "</a></td>
            </tr>
            <tr>
                <td style='padding: 8px; border: 0px solid #ddd; text-align: left;'>Book Title:</td>
                <td style='padding: 8px; border: 1px solid #ddd;'>" . $row['title'] . "</td>
            </tr>
            <tr>
                <td style='padding: 8px; border: 0px solid #ddd; text-align: left;'>Publication Date:</td>
                <td style='padding: 8px; border: 1px solid #ddd;'>" . $row['publication_date'] . "</td>
            </tr>
            <tr>
                <td style='padding: 8px; border: 0px solid #ddd; text-align: left;'>ISBN:</td>
                <td style='padding: 8px; border: 1px solid #ddd;'>" . $row['ISBN'] . "</td>
            </tr>
            <tr>
                <td style='padding: 8px; border: 0px solid #ddd; text-align: left;'>Book Description:</td>
                <td style='padding: 8px; border: 1px solid #ddd;'>" . $row['book_desc'] . "</td>
            </tr>
        </table>";
        
        echo "<form action='' method='post'>
            <input class='submit' type='submit' value='Borrow' name='submit'>
        </form>";

        echo "<form action='main-page.php' method='post'>
        <input class='submit' type='submit' value='Go Back'>
        </form>";

        if(isset($_POST['submit'])){
            $referenceNo = 'B' . date('YmdHis');
            $startDate = date('Y-m-d');
            $endDate = date('Y-m-d', strtotime('+7 days'));
            $returnDate = '0000-00-00';
            $fine = 0;

            // Update book_status to false
            $updateSql = "UPDATE books SET book_status = 0 WHERE book_ID = '$bookID'";
            mysqli_query($con, $updateSql);

            // Insert into book_management table
            $insertSql = "INSERT INTO book_management (Reference_No, book_ID, user_ID, StartDate, EndDate, ReturnDate, Fine) 
                          VALUES ('$referenceNo', '$bookID', '$username', '$startDate', '$endDate', '$returnDate', $fine)";
            
            if(mysqli_query($con, $insertSql)){
                echo "<script>alert('Borrow submitted successfully.');</script>";
                echo "<script>window.location.href = 'main-page.php';</script>";
                exit();
            } else {
                echo "<p>Error: " . mysqli_error($con) . "</p>";
            }
        }
    }



    mysqli_close($con);
?>