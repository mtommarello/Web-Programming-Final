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
            //$query= "SELECT COUNT(beerID)
            //FROM beers";
            //$beerCount = 0;
            //if ($result = mysqli_query($dbConnection, $query)){
              //  while ($row = $result->fetch_assoc()){
                //    $beerCount = $row["COUNT(beerID)"];
                //}
            //}
    
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
                                        echo '<button class="ui-button ui-widget ui-corner-all" id="beer'. $beerCount . 'Like"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></button>';
                                        if($_SESSION) {
                                            echo '<script>';
                                                echo '$("#beer' . $beerCount . 'Dislike").click(function() {';
                                                    echo '$.ajax({
                                                        url: "ajax/beerLikeStatusUpdate.php",
                                                        type: "POST",
                                                        data: {"beerID": ' . $beerCount . ', "likeStatus": 0},
                                                        success: function(data) {
                                                            //called when successful
                                                            $("#beer' . $beerCount . 'Dislike").css("background-color","red");
                                                            $("#beer' . $beerCount . 'Like").css("background-color","transparent");
                                                        },
                                                        error: function(e) {
                                                            //called when there is an error
                                                            //console.log(e.message);
                                                        }
                                                    });';
                                                echo '});';
                                            
                                                echo '$("#beer' . $beerCount . 'Like").click(function() {';
                                                    echo '$.ajax({
                                                        url: "ajax/beerLikeStatusUpdate.php",
                                                        type: "POST",
                                                        data: {"beerID": ' . $beerCount . ', "likeStatus": 1},
                                                        success: function() {
                                                            //called when successful
                                                            $("#beer' . $beerCount . 'Dislike").css("background-color","transparent");
                                                            $("#beer' . $beerCount . 'Like").css("background-color","green");
                                                        },
                                                        error: function(e) {
                                                            //called when there is an error
                                                            //console.log(e.message);
                                                        }
                                                    });';
                                                echo '});';
                                            echo '</script>';
                                        }
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
            $query2 = 'SELECT * from ratings WHERE finalUsersID_fk = ' . $_SESSION["userID"] . ';';
            //$query = 'SELECT ratings.ratingsID, ratings.rating, ratings.finalUsersID_fk, beers.beerName, beers.beerABV, beers.beerStyle, finalUsers.userName FROM beers INNER JOIN ratings ON ratings.beerID_fk= beers.beerID INNER JOIN finalUsers ON finalUsers.finalUserID=ratings.finalUsersID_fk WHERE ratings.finalUserID_fk = "' . $_SESSION["userID"] . '";';
            $beerCount = 1;
            if ($result2 = mysqli_query($dbConnection, $query2)){
                while($row = $result2->fetch_assoc()) {
                    if ($beerCount = $row['beerID_fk']) {
                        echo '<script>';
                            if($row["rating"] == 0) {
                                echo '$("#beer'. $beerCount . 'Dislike").css("background-color","red");';
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