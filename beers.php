<?php
    session_start();
?>
<!DOCTYPE html>

<html>

<?php
    include 'header.php';
?>
    <title>Beer Time - Beers</title>

</head>
<body>
    <?php
    include 'nav.php';
    include 'dbConnection.php';
            $query= "SELECT COUNT(beerID)
            FROM beers";
            $beerCount = 0;
            if ($result = mysqli_query($dbConnection, $query)){
                while ($row = $result->fetch_assoc()){
                    $beerCount = $row["COUNT(beerID)"];
                }
            }
    
        //for ($x = 0; $x <= $beerCount; $beerCount++){
            //if(isset($_GET['beer' . $x . 'Like'])) {
                
           // } else if(isset($_GET['beer' . $x . $'Dislike'])) {
                
           // }
       // }
    ?>
    <script>$.backstretch("img/web-background.jpg")</script>
    <div class="container">
        <div class="row animated zoomIn">
            <?php
                $query = "SELECT beerName, beerABV, beerStyle FROM beers";
                $beerCount = 1;
                if ($result = mysqli_query($dbConnection, $query)){

                        echo '<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4>';
                            echo '<div class="panel-group" id="accordion">';
                    while ($row = $result->fetch_assoc()) {
                                echo '<div class="panel panel-default" data-beerStyle="'. $row["beerStyle"] . '">';
                                    echo '<div class="panel-heading">';
                                        echo '<h4 class="panel-title">';
                                            echo '<a data-toggle="collapse" data-parent="#accordion" href="#beer' . $beerCount . '">' . $row["beerName"] . '</a>';
                                        echo '</h4>';
                                    echo '</div>';
                                    echo '<div id="beer' . $beerCount . '" class="panel-collapse collapse">';
                                    echo '<div class="panel-body">';
                                        echo $row["beerName"] . "<br>";
                                        echo "ABV: " . $row["beerABV"] . "<br>";
                                        echo "Style: " . $row["beerStyle"] . "<br>";
                                        echo '<button class="ui-button ui-widget ui-corner-all" id="beer'. $beerCount . 'Dislike"><i class="fa fa-thumbs-o-down" aria-hidden="true"></i></button>';
                                        echo '<script>';
                                            echo '$.ajax({
                                                url: "getTwitterFollowers.php",
                                                type: "GET",
                                                data: "twitterUsername=jquery4u",
                                                success: function(data) {
                                                    //called when successful
                                                    $("#ajaxphp-results").html(data);
                                                },
                                                error: function(e) {
                                                    //called when there is an error
                                                    //console.log(e.message);
                                                }
                                            });';
                                        echo '<button class="ui-button ui-widget ui-corner-all" id="beer'. $beerCount . 'Like"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></button>';
                                        echo '<div class="likeStatus'. $beerCount . '" id="likeStatus' . $beerCount . '"></div>';
                                        echo '</div>';
                                    echo '</div>';
                                echo '</div>';
                        $beerCount++;
                    }
   
                        echo '</div>';
                    
 
                }
            ?>
        </div>
    </div>

    <?php
        if ($_SESSION) {
            $query = 'SELECT ratings.ratingsID, ratings.rating, beers.beerName, beers.beerABV, beers.beerStyle, finalUsers.userName
            FROM beers
            INNER JOIN ratings ON ratings.beerID_fk= beers.beerID
            INNER JOIN finalUsers ON finalUsers.finalUserID=ratings.finalUsersID_fk
            WHERE finalUsers.userName = "' . $_SESSION["userName"] . '";';
            $beerCount = 1;
            if ($result = mysqli_query($dbConnection, $query)){
                while($row = $result->fetch_assoc()) {
                    if ($_SESSION["userName"] == $row['userName']) {
                        echo '<script>';
                            if($row["rating"] == 0) {
                                echo '$("#beer'. $beerCount . 'Disike").css("background-color","red");';
                            } else if($row["rating"] == 1) {
                                echo '$("#beer'. $beerCount . 'Like").css("background-color","green");';
                            }
                        echo '</script>';
                    }
                    $beerCount++;
                }
            }
        }

    include 'footer.php';
?>
</body>
</html>