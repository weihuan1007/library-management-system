<?php
    //Create connection
    $con = mysqli_connect("localhost", "root", "");

    //Check connection
    if(!$con){
        die("Could not connect: " . mysqli_connect_error());
    }
    
    //Table Books
    mysqli_select_db($con, "bookhub");
    $sql = "CREATE TABLE Books(book_ID varchar(5), 
        title varchar(30), 
        publication_date date,  
        ISBN varchar(17), 
        book_desc text,
        book_cover LONGBLOB,
        book_status bool,
        PRIMARY KEY (book_ID)
        )";

    if(mysqli_query($con, $sql)){
        echo "Table Books is created<br>";
    }
    else{
        die("Could not connect: " . mysqli_connect_error());
    }

    //Table Users for Admin
    mysqli_select_db($con, "bookhub");
    $sql = "CREATE TABLE Users(user_ID varchar(9),
        user_name varchar(30),
        user_email varchar(50),
        user_pass varchar(30),
        registration_date date,
        acc_status bool,
        PRIMARY KEY (user_ID)
        )";

    if(mysqli_query($con, $sql)){
        echo "Table Users is created<br>";
    }

    //Table BookHub_Users
    mysqli_select_db($con, "bookhub");
    $sql = "CREATE TABLE BookHub_Users(user_ID varchar(9),
        user_name varchar(30),
        user_email varchar(50),
        user_pass varchar(30),
        registration_date date,
        PRIMARY KEY (user_ID)
        )";

    if(mysqli_query($con, $sql)){
        echo "Table BookHub_Users is created<br>";
    }

    //Table Reviews
    mysqli_select_db($con, "bookhub");
    $sql = "CREATE TABLE Reviews(review_ID varchar(15),
        book_ID varchar(5),
        user_ID varchar(9),
        review text,
        time_stamp time,
        PRIMARY KEY (review_ID),
        FOREIGN KEY (book_ID) REFERENCES Books (book_ID),
        FOREIGN KEY (user_ID) REFERENCES bookhub_users (user_ID)
        )";

    if(mysqli_query($con, $sql)){
        echo "Table Reviews is created<br>";
    }

    //Table Book_Management
    mysqli_select_db($con, "bookhub");
    $sql = "CREATE TABLE Book_Management(
        Reference_No varchar(15), 
        book_ID varchar(5),
        user_ID varchar(9),
        StartDate date,
        EndDate date,
        ReturnDate date,
        Fine decimal(10,2),
        PRIMARY KEY (Reference_No),
        FOREIGN KEY (book_ID) REFERENCES Books(book_ID),
        FOREIGN KEY (user_ID) REFERENCES BookHub_Users(user_ID)
        )";

    if(mysqli_query($con, $sql)){
        echo "Table Book_Management is created<br>";
    }
    else{
        die("Could not connect: " . mysqli_connect_error());
    }

    mysqli_close($con);
?>