<?php
    session_start();
    include '../dbConnection.php';
    $beerName = $_POST['beerName'];
    $query = 'SELECT * FROM reviews INNER JOIN finalUsers ON finalUserID_fk = finalUserID INNER JOIN beers ON beerID_fk = beerID WHERE beerName = "' . $beerName . '";';
    $userID = $_SESSION["userID"];
    $queryIfReviewExists = 'SELECT COUNT(*) FROM reviews INNER JOIN beers ON beerID_fk = beerID WHERE beerName = "' . $beerName . '" AND finalUserID_fk = ' . $userID . ';';
    $countOfReviewsByUser = 0;

    if($resultIfReviewExists = mysqli_query($dbConnection, $queryIfReviewExists)){
        while ($row = $resultIfReviewExists->fetch_assoc()) {
            $countOfReviewsByUser = $row["COUNT(*)"];
        }
    }

    if ($countOfReviewsByUser == 1) {
        echo
            '<script>
                $(".beerEditDelReviewButtons").show();
            </script>';
    } else {
        echo
            '<script>
                $(".beerWriteReviewButton").show();
            </script>';
    }

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

