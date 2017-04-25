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
                        echo '<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            <div class="panel-group" id="accordion">';
                            while ($row = $result->fetch_assoc()) {
                                echo '<div class="panel panel-default" data-beerStyle="'. $row["beerStyle"] . '" data-beerName="' . $row["beerName"] . '">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#beer' . $row["beerID"] . '">' . $row["beerName"] . '</a>
                                        </h4>
                                    </div>
                                    <div id="beer' . $row["beerID"] . '" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        ' . $row["beerName"] . '<br>
                                        ABV: ' . $row["beerABV"] . '%<br>
                                        Style: ' . $row["beerStyle"] . '<br>
                                        <button class="ui-button ui-widget ui-corner-all" id="beer'. $row["beerID"] . 'Dislike"><i class="fa fa-thumbs-o-down" aria-hidden="true"></i></button>
                                        <button class="ui-button ui-widget ui-corner-all" id="beer'. $row["beerID"] . 'Like"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></button>';
                                        if($_SESSION) {
                                            echo '<script>
                                                $("#beer' . $row["beerID"] . 'Dislike").click(function() {
                                                    if($(this).hasClass("active")) {
                                                        $.ajax({
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
                                                        });
                                                    } else {
                                                        $.ajax({
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
                                                        });
                                                    }
                                                });
                                            
                                                $("#beer' . $row["beerID"] . 'Like").click(function() {
                                                    if($(this).hasClass("active")) {
                                                        $.ajax({
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
                                                        });
                                                    } else {
                                                        $.ajax({
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
                                                        });
                                                    }
                                                });
                                            </script>';
                                        } else {
                                            echo '<script>
                                                $("#beer' . $row["beerID"] . 'Dislike").click(function() {';
                                                    echo '$(location).attr("href", "login.php");
                                                });
                                                $("#beer' . $row["beerID"] . 'Like").click(function() {';
                                                    echo '$(location).attr("href", "login.php");
                                                });
                                            </script>';
                                        }
                                        echo '<div class="likePercentage'. $row["beerID"] . '" id="likePercentage' . $row["beerID"] . '"></div>
                                        <script>calculateTotals(' . $row["beerID"] . ');</script>
                                        </div>
                                    </div>
                                </div>';
                    }
                        echo "</div>
                            <script>    
                                $('#accordion').on('shown.bs.collapse', function () {
                                    var beerName = $('#accordion .in').parent().attr('data-beerName');
                                    $('.beerOpen').html(beerName);
                                    $('.beerClosed').hide();
                                    $('.beerOpen').show();
                                    var beerID = 
                                    $.ajax({
                                        url: 'ajax/beerViewReviews.php',
                                        type: 'POST',
                                        data: {'beerName': beerName},
                                        success: function(data) {
                                            $('.beerViewReviews').show();
                                            $('.beerViewReviews').html(data);
                                            if($('.viewReviewsSection').is(':empty')) {
                                                $('.beerViewReviews').html('<h3>There are no reviews for this beer. Be the first to review this beer.</h3>');
                                            }
                                        },
                                        error: function(e) {
                                            //called when there is an error
                                            //console.log(e.message);
                                        }
                                    });
                                });

                                $('#accordion').on('hidden.bs.collapse', function () {
                                    $('.beerClosed').show();
                                    $('.beerOpen').hide();
                                    $('.beerViewReviews').hide();
                                    $('.beerWriteReviewButton').hide();
                                    $('.beerEditDelReviewButtons').hide();
                                });
                            </script>
                        ";
                }
?>