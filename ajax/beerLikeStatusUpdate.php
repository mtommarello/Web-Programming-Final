<?php
    session_start();    
    include '../dbConnection.php';
    $userID = $_SESSION['userID'];
    $likeStatus = $_POST['likeStatus'];
    $beerID = $_POST['beerID'];

    if($likeStatus == -1) {
        $delete = "DELETE FROM ratings WHERE finalUsersID_fk = " . $userID . " AND beerID_fk = " . $beerID . ";";
        $result = mysqli_query($dbConnection, $delete);
    } else if($likeStatus == 0 || $likeStatus == 1) {
        $insert = "INSERT INTO ratings (beerID_fk, finalUsersID_fk, rating) VALUES(" . $beerID . ", " . $userID . ", " . $likeStatus . ");";

        $update = "UPDATE ratings SET rating = " . $likeStatus . " WHERE beerID_fk = " . $beerID. " AND finalUsersID_fk = " . $userID . ";";

        $result = mysqli_query($dbConnection, $update);
        if(mysqli_affected_rows($dbConnection) == 0) {
            $result = mysqli_query($dbConnection, $insert);
        }  
    }   
?>