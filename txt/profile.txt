<?php
    session_start();
    if($_SESSION) {
    } else {
        header("location:login.php"); // If the user is not logged in, they will be immediately redirected to the login page.
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
                    // This will show the user's full name at the top of the page using SQL.
                    $queryName = 'SELECT fName, lName FROM finalUsers WHERE finalUserID = ' . $_SESSION["userID"] . ';';
                
                    if ($result = mysqli_query($dbConnection, $queryName)){
                        $row = $result->fetch_row();
                        $firstName = $row[0];
                        $lastName = $row[1];
                        echo "<h2>" . $firstName . " " . $lastName . "</h2>";
                    }
                    // This will show the number of likes a user has made on beers overall using SQL.
                    $queryLike = 'SELECT COUNT(*) FROM ratings WHERE finalUsersID_fk = ' . $_SESSION["userID"] . ' AND rating = 1;';

                    if ($result = mysqli_query($dbConnection, $queryLike)){
                        $row = $result->fetch_row();
                        $userLikes = $row[0];
                        echo "<p>Beers Liked: " . $userLikes . "</p>";
                    }
                    // This will show the number of dislikes a user has made on beers overall using SQL.
                    $queryDislike = 'SELECT COUNT(*) FROM ratings WHERE finalUsersID_fk = ' . $_SESSION["userID"] . ' AND rating = 0;';

                    if ($result = mysqli_query($dbConnection, $queryDislike)){
                        $row = $result->fetch_row();
                        $userDislikes = $row[0];
                        echo "<p>Beers Disliked: " . $userDislikes . "</p>";
                    }
                ?>
            </div>
        <div class="row">
            <!-- This column shows the beers that the user rated and if they liked or disliked the beers. -->
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 cards profile">
                <h2>Beers Rated</h2>
                <?php
                    // SQL statement to get the ratings of each user.
                    $query = "SELECT ratings.rating, beers.beerName FROM ratings INNER JOIN beers on ratings.beerID_fk = beers.beerID WHERE ratings.finalUsersID_fk = " . $_SESSION['userID'] . ";";
                    if ($result = mysqli_query($dbConnection, $query)){
                        // Prints HTML to the page with the ratings.
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
            <!-- This column shows the beers that the user reviewed and shows the reviews that the user made. -->
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 cards profile">
                <h2>Beers Reviewed</h2>
                <?php
                    // SQL statement to get the reviews of each user.
                    $queryReviews = "SELECT * FROM reviews INNER JOIN beers on beerID_fk = beerID WHERE finalUserID_fk = " . $_SESSION["userID"] . ";";
                    if ($result = mysqli_query($dbConnection, $queryReviews)){
                        echo '<div class="viewReviewsSection">';
                        while ($row = $result->fetch_assoc()) {
                            // Prints HTML to the page with the reviews.
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
    <!-- Note that Brackets will complain that the closing is incomplete.  This is because that the various documents used to properly close the file are loaded via the includes method. -->
</html>