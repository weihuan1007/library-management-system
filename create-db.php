<?php
    //Create connection
    $con = mysqli_connect("localhost", "root", "");

    //Check connection
    if(!$con){
        die("Could not connect: " .mysqli_connect_error());
    }
    
    if(mysqli_query($con, "CREATE DATABASE bookhub")){
        echo "Database BookHub created";
    }
    else{
        echo "Error creating database: " .mysqli_connect_error();
    }

    mysqli_close($con);
    
?>