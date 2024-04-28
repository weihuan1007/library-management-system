<?php
    include("connection.php");

    // Check if the user is logged in
    session_start();
    $userID = isset($_SESSION['username']) ? $_SESSION['username'] : '';

    // Get the book ID
    $bookID = $_GET['bID'];

    // Check if the user has already reviewed the book
    $sql = "SELECT * FROM reviews WHERE user_ID = '$userID' AND book_ID = '$bookID'";
    $result = mysqli_query($con, $sql);

    echo "<link rel='stylesheet' href='css/review-page-style.css'>";

    if (mysqli_num_rows($result) > 0) {
        // User has already reviewed the book, display the existing review
        $row = mysqli_fetch_assoc($result);
        echo "<h2>Your Review</h2>";
        echo "<div class='review'>
            <div class='review-info'>
                <p><span>Review ID:</span> " . $row['review_ID'] . "</p>
                <p><span>Book ID:</span> " . $row['book_ID'] . "</p>
                <p><span>User ID:</span> " . $row['user_ID'] . "</p>
                <p><span>Review:</span> " . $row['review'] . "</p>
                <p><span>Timestamp:</span> " . $row['time_stamp'] . "</p>
            </div>
        </div>";
    }
    // Display the review form
    echo "<h2>Review this book</h2>";
    echo "<p>Would you like to review this book?</p>";

    // Review form
    echo "<div class='review-form'>
        <form action='' method='post'>
            <input type='hidden' name='bookID' value='$bookID'>
            <textarea name='review' placeholder='Write your review here'></textarea>
            <button class='submit' type='submit' name='submitReview'>Submit Review</button>
        </form>
    </div>";

    if (isset($_POST['submitReview'])) {
        $reviewID = 'R' . date('YmdHis'); // Generate review ID
        $review = $_POST['review'];
        $timestamp = date('Y-m-d H:i:s');

        // Save the review to the database
        $insertSql = "INSERT INTO reviews (review_ID, book_ID, user_ID, review, time_stamp)
                        VALUES ('$reviewID', '$bookID', '$userID', '$review', '$timestamp')";
        mysqli_query($con, $insertSql);

        echo "<script>alert('Your review has been submitted.');
              window.location.href = 'main-page.php'</script>";
    } else {
        echo "<a href='main-page.php' class='btn'>No, thanks. Go Back</a>";
    }

    mysqli_close($con);
?>
