<?php
    include '../dbConnection.php';
    $beerName = $_POST['beerName'];
    $query = 'SELECT * FROM reviews INNER JOIN finalUsers ON finalUserID_fk = finalUserID INNER JOIN beers ON beerID_fk = beerID WHERE beerName = "' . $beerName . '";';

    if ($result = mysqli_query($dbConnection, $query)){
        echo '<div class="viewReviewsSection">';
        while ($row = $result->fetch_assoc()) {
            echo '<div class="reviewFor' . $row["beerName"] . '">';
                echo '<h3>' . $row["fName"] . ' wrote:</h3>';
                    echo '<p>' . $row["review"] . '</p>';
            echo '</div>';
        }
        echo '</div>';
    }
?>