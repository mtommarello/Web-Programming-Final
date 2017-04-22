<?php
    session_start();    
    include '../dbConnection.php';
    $userID = $_SESSION['userID'];
    $likeStatus = $_POST['likeStatus'];
    $beerID = $_POST['beerID'];
    $insert = "INSERT INTO ratings (beerID_fk, finalUsersID_fk, rating) VALUES(" . $beerID . ", " . $userID . ", " . $likeStatus . ");";
    
     $update = " UPDATE ratings SET rating = " . $likeStatus . " WHERE beerID_fk =" . $beerID. ", finalUsersID_fk = " . $userID . ";";
    
    if(mysqli_query($dbConnection, $insert)) {
        mysqli_close($dbConnection);
        return true;
    } else {
        return false;
    }

        
?>