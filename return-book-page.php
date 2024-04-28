<?php
    include("connection.php");
    
    session_start();
    $username = isset($_SESSION['username']) ? $_SESSION['username'] : '';

    $sqlFine = "SELECT * FROM book_management WHERE user_ID='$username' AND ReturnDate!='0000-00-00' AND Fine > '0.00'";
    $resultFine = mysqli_query($con, $sqlFine);

    $sqlReturn = "SELECT * FROM book_management WHERE user_ID='$username' AND ReturnDate='0000-00-00'";
    $resultReturn = mysqli_query($con, $sqlReturn);

    echo "<link rel='stylesheet' href='css/return-book-page-style.css'>";

    if (mysqli_num_rows($resultFine) > 0 || mysqli_num_rows($resultReturn) > 0) {
        echo "<div style='table-layout:fixed; height:100%;'><table style='width: 80%; height: 80%; border-collapse: collapse; margin-left: auto; margin-right: auto; margin-top:10px;'>";

        if (mysqli_num_rows($resultFine) > 0) {

            echo "
                <tr>
                    <td colspan='6' style='background-color: #ffffff;'><h1>Fines</h1></td>
                </tr>
                <tr>
                    <th style='padding: 8px; border: 1px solid #ddd; background-color: #f2f2f2; width:100px'>Reference No</th>
                    <th style='padding: 8px; border: 1px solid #ddd; background-color: #f2f2f2; width:100px'>Book ID</th>
                    <th style='padding: 8px; border: 1px solid #ddd; background-color: #f2f2f2; width:150px'>Start Date</th>
                    <th style='padding: 8px; border: 1px solid #ddd; background-color: #f2f2f2; width:150px'>End Date</th>
                    <th style='padding: 8px; border: 1px solid #ddd; background-color: #f2f2f2; width:150px'>Return Date</th>
                    <th style='padding: 8px; border: 1px solid #ddd; background-color: #f2f2f2; width:100px'>Fine</th>

                </tr>";


            while($row = mysqli_fetch_assoc($resultFine)){
                echo "<tr>
                    <td style='padding: 8px; border: 1px solid #ddd;'>" . $row['Reference_No'] . "</td>
                    <td style='padding: 8px; border: 1px solid #ddd;'><a href='book-page.php?bID=" . $row['book_ID'] . "'>" . $row['book_ID'] . "</a></td>
                    <td style='padding: 8px; border: 1px solid #ddd;'>" . $row['StartDate'] . "</td>
                    <td style='padding: 8px; border: 1px solid #ddd;'>" . $row['EndDate'] . "</td>
                    <td style='padding: 8px; border: 1px solid #ddd;'>" . $row['ReturnDate'] . "</td>
                    <td style='padding: 8px; border: 1px solid #ddd;'>" . $row['Fine'] . "</td>
                </tr>";
            }
        }

        $sql = "SELECT * FROM book_management WHERE user_ID='$username' AND ReturnDate='0000-00-00'";
        $result = mysqli_query($con, $sql);

        echo "<link rel='stylesheet' href='css/return-book-page-style.css'>";

        if (mysqli_num_rows($resultReturn) > 0) {
            echo "
                <tr>
                    <td colspan='5' style='background-color: #ffffff;'><br><br></td>
                </tr>
                <tr>
                    <td colspan='5' style='background-color: #ffffff;'><h2>Books to Return</h2></td>
                </tr>
                <tr>
                    <th style='padding: 8px; border: 1px solid #ddd; background-color: #f2f2f2;'>Reference No</th>
                    <th style='padding: 8px; border: 1px solid #ddd; background-color: #f2f2f2;'>Book ID</th>
                    <th style='padding: 8px; border: 1px solid #ddd; background-color: #f2f2f2;'>Start Date</th>
                    <th style='padding: 8px; border: 1px solid #ddd; background-color: #f2f2f2;'>End Date</th>
                    <th style='padding: 8px; border: 1px solid #ddd; background-color: #f2f2f2;'>Action</th>
                </tr>";

            while($row = mysqli_fetch_assoc($resultReturn)){
                echo "<tr>
                    <td style='padding: 8px; border: 1px solid #ddd;'>" . $row['Reference_No'] . "</td>
                    <td style='padding: 8px; border: 1px solid #ddd;'><a href='book-page.php?bID=" . $row['book_ID'] . "'>" . $row['book_ID'] . "</a></td>
                    <td style='padding: 8px; border: 1px solid #ddd;'>" . $row['StartDate'] . "</td>
                    <td style='padding: 8px; border: 1px solid #ddd;'>" . $row['EndDate'] . "</td>
                    <td style='padding: 8px; border: 1px solid #ddd;'>
                        <form action='' method='post'>
                            <input type='hidden' name='referenceNo' value='" . $row['Reference_No'] . "'>
                            <input type='hidden' name='bookID' value='" . $row['book_ID'] . "'>
                            <input class='submit' type='submit' value='Return' name='return'>
                        </form>
                    </td>
                </tr>";
            }
            
            

            if(isset($_POST['return'])){
                $referenceNo = $_POST['referenceNo'];
                $bookID = $_POST['bookID'];
                $returnDate = date('Y-m-d');

                $sql = "SELECT * FROM book_management WHERE Reference_No = '$referenceNo'";
                $result = mysqli_query($con, $sql);
            
                if ($row = mysqli_fetch_assoc($result)) {
                    $endDate = new DateTime($row['EndDate']);
                    $returnDateObj = new DateTime($returnDate);
                    if ($returnDateObj > $endDate) {
                        $dateDifference = $endDate->diff($returnDateObj);
                        $fine = $dateDifference->days * 0.5;
                        echo "<script>alert('Your fine is RM $fine');</script>";

                        $updateSql = "UPDATE book_management SET Fine = '$fine' WHERE Reference_No = '$referenceNo'";
                        mysqli_query($con, $updateSql);
                        
                    } else {
                        echo "<script>alert('No fine is applicable.');</script>";
                    }
                }

                // Update ReturnDate in book_management table
                $updateSql = "UPDATE book_management SET ReturnDate = '$returnDate' WHERE Reference_No = '$referenceNo'";
                mysqli_query($con, $updateSql);

                // Update book_status to true in books table
                $updateSql = "UPDATE books SET book_status = TRUE WHERE book_ID = '$bookID'";
                mysqli_query($con, $updateSql);

                echo "<p>Book returned successfully.</p>";

                echo "<script>window.location.href = 'review-page.php?bID=$bookID';</script>";

            
            }

            
        }
        echo "
            <tr><td><br></td><tr>
            <tr>
                <td colspan='5' style='background-color: #ffffff;'></td>
                <td style='background-color: #ffffff;'><a href='main-page.php' class='btn'>Go Back</a></td>
            </tr>
        </table></div>";

    } else {
            echo "<p>No books to return.</p>";
            echo "<br><a href='main-page.php' class='btn'>Go Back</a>";
    }

    mysqli_close($con);
?>
