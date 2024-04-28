<?php
    include("connection.php");
    

    $sqlFine = "SELECT * FROM book_management WHERE ReturnDate!='0000-00-00' AND Fine > '0.00'";
    $resultFine = mysqli_query($con, $sqlFine);

    echo "<link rel='stylesheet' href='css/return-book-page-style.css'>";


        if (mysqli_num_rows($resultFine) > 0) {
            echo "<div style='table-layout:fixed; height:100%;'><table style='width: 80%; border-collapse: collapse; margin-left: auto; margin-right: auto; margin-top:10px;'>

                <tr>
                    <td colspan='6' style='background-color: #ffffff;'><h2>Fines</h2></td>
                </tr>
                <tr>
                    <th style='padding: 8px; border: 1px solid #ddd; background-color: #f2f2f2;'>Reference No</th>
                    <th style='padding: 8px; border: 1px solid #ddd; background-color: #f2f2f2;'>Book ID</th>
                    <th style='padding: 8px; border: 1px solid #ddd; background-color: #f2f2f2;'>User ID</th>
                    <th style='padding: 8px; border: 1px solid #ddd; background-color: #f2f2f2;'>Start Date</th>
                    <th style='padding: 8px; border: 1px solid #ddd; background-color: #f2f2f2;'>End Date</th>
                    <th style='padding: 8px; border: 1px solid #ddd; background-color: #f2f2f2;'>Return Date</th>
                    <th style='padding: 8px; border: 1px solid #ddd; background-color: #f2f2f2;'>Fine</th>
                    <th style='padding: 8px; border: 1px solid #ddd; background-color: #f2f2f2;'>Action</th>

                </tr>";

            while($row = mysqli_fetch_assoc($resultFine)){
                echo "<tr>
                    <td style='padding: 8px; border: 1px solid #ddd;'>" . $row['Reference_No'] . "</td>
                    <td style='padding: 8px; border: 1px solid #ddd;'>" . $row['book_ID'] . "</td>
                    <td style='padding: 8px; border: 1px solid #ddd;'>" . $row['user_ID'] . "</td>
                    <td style='padding: 8px; border: 1px solid #ddd;'>" . $row['StartDate'] . "</td>
                    <td style='padding: 8px; border: 1px solid #ddd;'>" . $row['EndDate'] . "</td>
                    <td style='padding: 8px; border: 1px solid #ddd;'>" . $row['ReturnDate'] . "</td>
                    <td style='padding: 8px; border: 1px solid #ddd;'>" . $row['Fine'] . "</td>
                    <td style='padding: 8px; border: 1px solid #ddd;'>
                        <form action='' method='post'>
                            <input type='hidden' name='referenceNo' value='" . $row['Reference_No'] . "'>
                            <input class='submit' type='submit' value='Paid' name='paid'>
                        </form>
                    </td>
                </tr>";
            }
            echo "
            <tr><td><br></td><tr>
            <tr>
                <td colspan='7' style='background-color: #ffffff;'></td>
                <td style='background-color: #ffffff;'><a href='admin-page.php' class='btn'>Go Back</a></td>
            </tr>
        </table></div>";

            if (isset($_POST['paid'])) {
                echo "<script>
                    var confirmed = confirm('Are you sure this fine is paid?');
                    if (confirmed) {
                        window.location.href = 'fine-page.php?confirm=true&refNo=" . $_POST['referenceNo'] . "';
                    } else {
                        window.location.href = 'fine-page.php';
                    }
                </script>";
            }

        }else {
            echo "<p>No any fine.</p>";
            echo "<br><a href='admin-page.php' class='btn'>Go Back</a>";
        }

        if (isset($_GET['confirm']) && $_GET['confirm'] == 'true') {
            $referenceNo = $_GET['refNo'];
        
            $updateSql = "UPDATE book_management SET Fine = '0.00' WHERE Reference_No = '$referenceNo'";
            mysqli_query($con, $updateSql);
        
            echo "<script>window.location.href = 'fine-page.php';</script>";
        }

    mysqli_close($con);
?>
