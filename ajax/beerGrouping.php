<?php
    session_start();
    include '../dbConnection.php';
    if($_POST["beerSortMethod"] == "beerName") {
        $query = "SELECT * FROM beers ORDER BY beerName";
    } else if($_POST["beerSortMethod"] == "beerABV") {
        $query = "SELECT * FROM beers ORDER BY beerABV;";
    } else if($_POST["beerSortMethod"] == "style") {
        $query = "SELECT * FROM beers ORDER BY beerStyle;";
    } else if($_POST["beerSortMethod"] == "brewer") {
        $query = "SELECT * FROM beers INNER JOIN brewers on brewerID_fk = brewersID ORDER BY brewerName;";
    } else if($_POST["beerSortMethod"] == "none") {
        $query = "SELECT * FROM beers;";
    } else {
        $query = "SELECT * FROM beers;";
    }

    if ($result = mysqli_query($dbConnection, $query)){
            echo '<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4>';
                echo '<div class="panel-group" id="accordion">';
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="panel panel-default" data-beerStyle="'. $row["beerStyle"] . '">';
                            echo '<div class="panel-heading">';
                                echo '<h4 class="panel-title">';
                                echo '<a data-toggle="collapse" data-parent="#accordion" href="#beer' . $row["beerID"] . '">' . $row["beerName"] . '</a>';
                                echo '</h4>';
                            echo '</div>';
                            echo '<div id="beer' . $row["beerID"] . '" class="panel-collapse collapse">';
                                echo '<div class="panel-body">';
                                    echo $row["beerName"] . "<br>";
                                    echo "ABV: " . $row["beerABV"] . "%<br>";
                                    echo "Style: " . $row["beerStyle"] . "<br>";
                                    echo '<button class="ui-button ui-widget ui-corner-all" id="beer'. $row["beerID"] . 'Dislike"><i class="fa fa-thumbs-o-down" aria-hidden="true"></i></button>';
                                    echo '<button class="ui-button ui-widget ui-corner-all" id="beer'. $row["beerID"] . 'Like"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></button>';
                                    if($_SESSION) {
                                        echo '<script>';
                                            echo '$("#beer' . $row["beerID"] . 'Dislike").click(function() {';
                                                echo 'if($(this).hasClass("active")) {';
                                                    echo '$.ajax({
                                                        url: "ajax/beerLikeStatusUpdate.php",
                                                        type: "POST",
                                                        data: {"beerID": ' . $row["beerID"] . ', "likeStatus": -1},
                                                        success: function(data) {
                                                            //called when successful
                                                            $("#beer' . $row["beerID"] . 'Dislike").css("background-color","transparent");
                                                            $("#beer' . $row["beerID"] . 'Like").css("background-color","transparent");
                                                            $("#beer' . $row["beerID"] . 'Dislike").removeClass("active");
                                                                calculateTotals(' . $row["beerID"] . ');
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
                                                        data: {"beerID": ' . $row["beerID"] . ', "likeStatus": 0},
                                                        success: function(data) {
                                                            //called when successful
                                                            $("#beer' . $row["beerID"] . 'Dislike").css("background-color","red");
                                                            $("#beer' . $row["beerID"] . 'Like").css("background-color","transparent");
                                                            $("#beer' . $row["beerID"] . 'Dislike").addClass("active");
                                                            $("#beer' . $row["beerID"] . 'Like").removeClass("active");
                                                            calculateTotals(' . $row["beerID"] . ');
                                                        },
                                                        error: function(e) {
                                                            //called when there is an error
                                                            //console.log(e.message);
                                                        }
                                                    });';
                                                echo '}';
                                            echo '});';
                                            
                                            echo '$("#beer' . $row["beerID"] . 'Like").click(function() {';
                                                echo 'if($(this).hasClass("active")) {';
                                                    echo '$.ajax({
                                                        url: "ajax/beerLikeStatusUpdate.php",
                                                        type: "POST",
                                                        data: {"beerID": ' . $row["beerID"] . ', "likeStatus": -1},
                                                        success: function(data) {
                                                            //called when successful
                                                            $("#beer' . $row["beerID"] . 'Dislike").css("background-color","transparent");
                                                            $("#beer' . $row["beerID"] . 'Like").css("background-color","transparent");
                                                            $("#beer' . $row["beerID"] . 'Like").removeClass("active");
                                                            calculateTotals(' . $row["beerID"] . ');
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
                                                        data: {"beerID": ' . $row["beerID"] . ', "likeStatus": 1},
                                                        success: function() {
                                                            //called when successful
                                                            $("#beer' . $row["beerID"] . 'Dislike").css("background-color","transparent");
                                                            $("#beer' . $row["beerID"] . 'Like").css("background-color","green");
                                                            $("#beer' . $row["beerID"] . 'Like").addClass("active");
                                                            $("#beer' . $row["beerID"] . 'Dislike").removeClass("active");
                                                                calculateTotals(' . $row["beerID"] . ');
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
                                            echo '$("#beer' . $row["beerID"] . 'Dislike").click(function() {';
                                                echo '$(location).attr("href", "login.php");';
                                            echo '});';
                                            echo '$("#beer' . $row["beerID"] . 'Like").click(function() {';
                                                echo '$(location).attr("href", "login.php");';
                                            echo '});';
                                        echo '</script>';
                                    }
                                    echo '<div class="likePercentage'. $row["beerID"] . '" id="likePercentage' . $row["beerID"] . '"></div>';
                                    echo '<script>calculateTotals(' . $row["beerID"] . ');</script>';
                                    echo '</div>';
                                echo '</div>';
                            echo '</div>';
                    $row["beerID"]++;
                }
                echo '</div>';
    } else {
        echo "failure";
    }
?>