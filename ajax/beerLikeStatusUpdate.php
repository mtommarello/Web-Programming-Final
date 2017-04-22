<?php
session_start();    
include 'dbConnection.php';    
    $insert = "INSERT INTO ratings (beerID_fk, finalUsersID_fk, rating)
            VALUES($beerCount, " . $_SESSION['userID']", " . $_POST["likeStatus"] . ");";
    
     $update = " UPDATE ratings
            SET rating = " . $_POST["likeStatus"] . ", 
            WHERE beerID_fk = $beerCount, finalUsersID_fk = " . $_SESSION['userID']";";
    
    if(mysqli_query($dbConnection, $insert)) {
        mysqli_close($dbConnection);
        return true;
    } else {
        return false;
    }

        
?>