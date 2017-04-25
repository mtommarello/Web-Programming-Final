<?php
    session_start();
    if($_SESSION) {
    } else {
        header("location:login.php");
    }
?>
<!DOCTYPE html>
<html>
    
<?php

    include 'header.php';
    include 'dbConnection.php';
?>
    <title>Beer Time - Profile</title>
</head>

<body>
	<?php
        include 'nav.php';
	?>

    <script>$.backstretch("img/web-background.jpg")</script>
	
    <div class="container animated fadeIn">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 cards profile">
                <?php
                    $queryName = 'SELECT fName, lName FROM finalUsers WHERE finalUserID = ' . $_SESSION["userID"] . ';';
                
                    if ($result = mysqli_query($dbConnection, $queryName)){
                        $row = $result->fetch_row();
                        $firstName = $row[0];
                        $lastName = $row[1];
                        echo "<h2>" . $firstName . " " . $lastName . "</h2>";
                    }

                    $queryLike = 'SELECT COUNT(*) FROM ratings WHERE finalUsersID_fk = ' . $_SESSION["userID"] . ' AND rating = 1;';

                    if ($result = mysqli_query($dbConnection, $queryLike)){
                        $row = $result->fetch_row();
                        $userLikes = $row[0];
                        echo "<p>Beers Liked: " . $userLikes . "</p>";
                    }
                
                    $queryDislike = 'SELECT COUNT(*) FROM ratings WHERE finalUsersID_fk = ' . $_SESSION["userID"] . ' AND rating = 0;';

                    if ($result = mysqli_query($dbConnection, $queryDislike)){
                        $row = $result->fetch_row();
                        $userDislikes = $row[0];
                        echo "<p>Beers Disliked: " . $userDislikes . "</p>";
                    }
                ?>
            </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 cards profile">
                <h2>Beers Rated</h2>
                <?php
                    $query = "SELECT ratings.rating, beers.beerName FROM ratings INNER JOIN beers on ratings.beerID_fk = beers.beerID WHERE ratings.finalUsersID_fk = " . $_SESSION['userID'] . ";";
                    if ($result = mysqli_query($dbConnection, $query)){
                        while ($row = $result->fetch_assoc()) {
                            $beerName = $row["beerName"];
                            $rating = $row["rating"];
                            if($rating == 0) {
                                echo "<h3>" . $beerName . ": Dislike</h3>";
                            } else if($rating == 1) {
                                echo "<h3>" . $beerName . ": Like</h3>";
                            }
                        }
                    }
                ?>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 cards profile">
                <h2>Beers Reviewed</h2>
                <?php
                    $queryReviews = "SELECT * FROM reviews INNER JOIN beers on beerID_fk = beerID WHERE finalUserID_fk = " . $_SESSION["userID"] . ";";
                    if ($result = mysqli_query($dbConnection, $queryReviews)){
                        echo '<div class="viewReviewsSection">';
                        while ($row = $result->fetch_assoc()) {
                            echo '<div class="reviewFor' . $row["beerName"] . '">';
                                echo '<h3>' . $row["beerName"] . '</h3>';
                                    echo '<p>' . $row["review"] . '</p>';
                            echo '</div>';
                        }
                        echo '</div>';
                    }
                ?>
            </div>
        </div>
        </div>
    </div>
    <?php
      include 'footer.php';  
    ?>
</body>
</html>