<?php
    include("connection.php");

    if(isset($_GET['book'])){
        $bID = $_GET['book'];

        $sql = "DELETE FROM books WHERE book_ID = '$bID'";
        $result = mysqli_query($con, $sql);

        if($result){
            echo "<script>alert('Book deleted successfully!')</script>";
            header("location: admin-page.php");
        }
    
    }


?>