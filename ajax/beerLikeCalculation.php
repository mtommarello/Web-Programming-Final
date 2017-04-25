<?php
    include '../dbConnection.php';

    $beerID = $_POST["beerID"];

    $overall = 0;

    $queryOverall = 'SELECT COUNT(*) FROM ratings WHERE beerID_fk = ' . $beerID . ';';

//Pulls number of overall ratings for specific beer
    if ($result = mysqli_query($dbConnection, $queryOverall)){
        $row = $result->fetch_row();
        $overall = $row[0];
    }

    $like = 0;

    $queryLike = 'SELECT COUNT(*) FROM ratings WHERE beerID_fk = ' . $beerID . ' AND rating = 1;';

//Pulls number of likes for specific beer
    if ($result = mysqli_query($dbConnection, $queryLike)){
        $row = $result->fetch_row();
        $like = $row[0];
    }

//Does calculation base on number of likes and number of overall ratings 
    if($like == 0 && $overall == 0) {
        $toReturnToBrowser = "No one has liked this beer yet.  Be the first to like this beer.";
    } else if($like == 0) {
        $toReturnToBrowser = "0 out of " . $overall . " people (0%) like this beer.";
    } else {
        $calculatedPercentage = round(($like / $overall) * 100);

        $toReturnToBrowser = $like . " out of " . $overall . " people (". $calculatedPercentage . "%) like this beer.";
    }

    echo $toReturnToBrowser;

?>