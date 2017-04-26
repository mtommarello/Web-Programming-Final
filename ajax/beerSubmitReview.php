<?php 
    session_start();
    include '../dbConnection.php';
    $beerName = $_POST["beerName"];
    $beerID = 0;
    $userID = $_SESSION["userID"];
    $beerReviewType = $_POST["beerReviewType"];
    
//Checking if text is set and sanitizing text if not will show empty
    if(isset($_POST["reviewText"])) {
        $reviewText = mysqli_real_escape_string($dbConnection, $_POST["reviewText"]);
    } else {
        $reviewText = "";
    }

    $beerIDQuery = 'SELECT beerID FROM beers WHERE beerName = "' . $beerName . '";';

//Pulling which beer user is reviewing 
    if ($resultID = mysqli_query($dbConnection, $beerIDQuery)){
        while ($row = $resultID->fetch_assoc()) {
            $beerID = $row["beerID"];
        }
    }

//Used in beerEditReview.php & beerWriteReview.php to signify to create New, Edit or Delete reviews by user and beer
    if($beerReviewType == 0) {
        $insertStatement = "INSERT INTO reviews (finalUserID_fk, beerID_fk, review) VALUES (" . $userID . ", " . $beerID . ", '" . $reviewText . "');";
        mysqli_query($dbConnection, $insertStatement);
    } else if ($beerReviewType == 1) {
        $updateStatement = "UPDATE reviews SET review='" . $reviewText . "' WHERE finalUserID_fk= " . $userID . " AND beerID_fk= " . $beerID . ";";
        mysqli_query($dbConnection, $updateStatement);
    } else if ($beerReviewType == 2) {
        $deleteStatement = "DELETE FROM reviews WHERE finalUserID_fk= " . $userID . " AND beerID_fk= " . $beerID . ";";
        mysqli_query($dbConnection, $deleteStatement);
    }

?>