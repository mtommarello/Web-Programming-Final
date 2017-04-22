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
    ?>
    <script>
        $.backstretch("img/web-background.jpg");
    
        function calculateTotals(beerID) {
            var elementID = "#likePercentage" + beerID;
            $.ajax({
                url: "ajax/beerLikeCalculation.php",
                type: "POST",
                data: {"beerID": beerID},
                success: function(data) {
                    //called when successful
                    $(elementID).html(data);
                },
                error: function(e) {
                    //called when there is an error
                    //console.log(e.message);
                }
            });
        }
    </script>
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
                                                    echo 'if($(this).hasClass("active")) {';
                                                        echo '$.ajax({
                                                            url: "ajax/beerLikeStatusUpdate.php",
                                                            type: "POST",
                                                            data: {"beerID": ' . $beerCount . ', "likeStatus": -1},
                                                            success: function(data) {
                                                                //called when successful
                                                                $("#beer' . $beerCount . 'Dislike").css("background-color","transparent");
                                                                $("#beer' . $beerCount . 'Like").css("background-color","transparent");
                                                                $("#beer' . $beerCount . 'Dislike").removeClass("active");
                                                                calculateTotals(' . $beerCount . ');
                                                            },
                                                            error: function(e) {
                                                                //called when there is an error
                                                                //console.log(e.message);
                                                            }
                                                        });';
                                                    echo '} else {';
                                                        echo '$.ajax({
                                                            url: "ajax/beerLikeStatusUpdate.php",
                                                            type: "POST",
                                                            data: {"beerID": ' . $beerCount . ', "likeStatus": 0},
                                                            success: function(data) {
                                                                //called when successful
                                                                $("#beer' . $beerCount . 'Dislike").css("background-color","red");
                                                                $("#beer' . $beerCount . 'Like").css("background-color","transparent");
                                                                $("#beer' . $beerCount . 'Dislike").addClass("active");
                                                                $("#beer' . $beerCount . 'Like").removeClass("active");
                                                                calculateTotals(' . $beerCount . ');
                                                            },
                                                            error: function(e) {
                                                                //called when there is an error
                                                                //console.log(e.message);
                                                            }
                                                        });';
                                                    echo '}';
                                                echo '});';
                                            
                                                echo '$("#beer' . $beerCount . 'Like").click(function() {';
                                                    echo 'if($(this).hasClass("active")) {';
                                                        echo '$.ajax({
                                                            url: "ajax/beerLikeStatusUpdate.php",
                                                            type: "POST",
                                                            data: {"beerID": ' . $beerCount . ', "likeStatus": -1},
                                                            success: function(data) {
                                                                //called when successful
                                                                $("#beer' . $beerCount . 'Dislike").css("background-color","transparent");
                                                                $("#beer' . $beerCount . 'Like").css("background-color","transparent");
                                                                $("#beer' . $beerCount . 'Like").removeClass("active");
                                                                calculateTotals(' . $beerCount . ');
                                                            },
                                                            error: function(e) {
                                                                //called when there is an error
                                                                //console.log(e.message);
                                                            }
                                                        });';
                                                    echo '} else {';
                                                        echo '$.ajax({
                                                            url: "ajax/beerLikeStatusUpdate.php",
                                                            type: "POST",
                                                            data: {"beerID": ' . $beerCount . ', "likeStatus": 1},
                                                            success: function() {
                                                                //called when successful
                                                                $("#beer' . $beerCount . 'Dislike").css("background-color","transparent");
                                                                $("#beer' . $beerCount . 'Like").css("background-color","green");
                                                                $("#beer' . $beerCount . 'Like").addClass("active");
                                                                $("#beer' . $beerCount . 'Dislike").removeClass("active");
                                                                calculateTotals(' . $beerCount . ');
                                                            },
                                                            error: function(e) {
                                                                //called when there is an error
                                                                //console.log(e.message);
                                                            }
                                                        });';
                                                    echo '}';
                                                echo '});';
                                            echo '</script>';
                                        } else {
                                            echo '<script>';
                                                echo '$("#beer' . $beerCount . 'Dislike").click(function() {';
                                                    echo '$(location).attr("href", "login.php");';
                                                echo '});';
                                                echo '$("#beer' . $beerCount . 'Like").click(function() {';
                                                    echo '$(location).attr("href", "login.php");';
                                                echo '});';
                                            echo '</script>';
                                        }
                                        echo '<div class="likePercentage'. $beerCount . '" id="likePercentage' . $beerCount . '"></div>';
                                        echo '<script>calculateTotals(' . $beerCount . ');</script>';
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
            $beerCount = 1;
            if ($result2 = mysqli_query($dbConnection, $query2)){
                while($row = $result2->fetch_assoc()) {
                    if ($beerCount = $row['beerID_fk']) {
                        echo '<script>';
                            if($row["rating"] == 0) {
                                echo '$("#beer'. $beerCount . 'Dislike").css("background-color","red");';
                                echo '$("#beer'. $beerCount . 'Dislike").addClass("active");';
                            } else if($row["rating"] == 1) {
                                echo '$("#beer'. $beerCount . 'Like").css("background-color","green");';
                                echo '$("#beer'. $beerCount . 'Like").addClass("active");';
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