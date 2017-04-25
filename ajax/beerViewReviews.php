<?php
    session_start();
    include '../dbConnection.php';
    $beerName = $_POST['beerName'];
    $query = 'SELECT * FROM reviews INNER JOIN finalUsers ON finalUserID_fk = finalUserID INNER JOIN beers ON beerID_fk = beerID WHERE beerName = "' . $beerName . '";';

    if($_SESSION) {
        $userID = $_SESSION["userID"];
        $queryIfReviewExists = 'SELECT COUNT(*) FROM reviews INNER JOIN beers ON beerID_fk = beerID WHERE beerName = "' . $beerName . '" AND finalUserID_fk = ' . $userID . ';';
        $countOfReviewsByUser = 0;

//Checking to see if the user reviewed any beers
        if($resultIfReviewExists = mysqli_query($dbConnection, $queryIfReviewExists)){
            while ($row = $resultIfReviewExists->fetch_assoc()) {
                $countOfReviewsByUser = $row["COUNT(*)"];
            }
        }

//If user reviewed beer will show review or delete button
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

//Shows users name in heading and review for specific beer selected
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
    } else {
            echo
                '<script>
                    $(".beerWriteReviewButton").show();
                </script>';
        }

//If users not logged in will pull and show the beer name to be reviewed 
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