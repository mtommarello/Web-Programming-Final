<?php
    session_start();    
    include '../dbConnection.php';
    $userID = $_SESSION['userID'];
    $likeStatus = $_POST['likeStatus'];
    $beerID = $_POST['beerID'];

   // $query = "INSERT INTO ratings (beerID_fk, finalUsersID_fk, rating) VALUES(" . $beerID . ", " . $userID . ", " . $likeStatus . ") ON DUPLICATE KEY UPDATE rating = " .$likeStatus . ";";

    $insert = "INSERT INTO ratings (beerID_fk, finalUsersID_fk, rating) VALUES(" . $beerID . ", " . $userID . ", " . $likeStatus . ");";
    
     $update = "UPDATE ratings SET rating = " . $likeStatus . " WHERE beerID_fk = " . $beerID. " AND finalUsersID_fk = " . $userID . ";";

    $result = mysqli_query($dbConnection, $update);
    if(mysqli_affected_rows($dbConnection) == 0) {
        $result = mysqli_query($dbConnection, $insert);
    }
    
    //if(mysqli_query($dbConnection, $update)) {
    //} else {
        //mysqli_query($dbConnection, $query);
    //}

        
?>

$result = mysql_query("update test set col='test' where col_id='1';");		 
if (mysql_affected_rows()==0) {
	$result = mysql_query("insert into test (col_id, col) values ('1','test');");
}