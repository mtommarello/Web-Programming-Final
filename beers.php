<?php
    session_start();
?>
<!DOCTYPE html>

<html lang="en">

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
        // Background of page
        $.backstretch("img/web-background.jpg");
        // Calls the function to calculate the totals of each beer on the page.
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
            <!-- Bootstrap column used to display the beer reviews for a beer that is selected in another Bootstrap column. -->
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 cards">
                <h2 class="beerClosed hidden-xs hidden-sm">Select a Beer on the Right</h2>
                <h2 class="beerClosed hidden-md hidden-lg">Select a Beer Below</h2>
                <h2 class="beerOpen">JavaScript is disabled in your browser. Please enable JavaScript to enable full functionality.</h2>
                <div class="beerWriteReviewButton">
                    <button type="submit" class="btn btn-primary" id="newReviewButton">Write Review</button>
                </div>
                <div class="beerEditDelReviewButtons">
                    <button type="submit" class="btn btn-primary" id="editReviewButton">Edit Review</button>
                    <button type="submit" class="btn btn-danger" id="deleteReviewButton">Delete Review</button>
                </div>
                <div class="beerWriteReview"></div>
                <div class="beerViewReviews"></div>
            </div>
            <!-- Bootstrap column with elements used to sort the beers in the beers column.  This column is only viewable on mobile. -->
            <div class="col-xs-12 col-sm-12 hidden-md hidden-lg sortBeers">
                <h3>Sort Beers</h3>
                <div class="radio">
                    <label class="beerSort"><input type="radio" name="beerSort" value="beerName">Name</label>
                </div>
                <div class="radio">
                    <label class="beerSort"><input type="radio" name="beerSort" value="beerABV">Beer ABV</label>
                </div>
                <div class="radio">
                    <label class="beerSort"><input type="radio" name="beerSort" value="style">Beer Style</label>
                </div>
                <div class="radio">
                    <label class="beerSort"><input type="radio" name="beerSort" value="brewer">Brewer</label>
                </div>
                <div class="radio">
                    <label class="beerSort"><input type="radio" name="beerSort" value="none" checked="checked">None</label>
                </div>
            </div>
            <!-- This div has the Bootstrap column for all the beers listed.  It is put in a div as the AJAX used in the sorting method replaces the entire column with one from the AJAX php. -->
            <div id="beerList">
            <?php
                // Initial SQL statement
                $query = "SELECT beerName, beerABV, beerStyle FROM beers";
                // Used to track beers.
                $beerCount = 1;
                // runs query
                if ($result = mysqli_query($dbConnection, $query)){
                    //Starts Bootstrap column
                        echo '<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            <div class="panel-group" id="accordion">';
                        // Once the Bootstrap column and accordion element is started, a while loop will run to place each data element into a panel element.  This panel element will have attributes of the beer via data tags, used later by JavaScript/JQuery.
                            while ($row = $result->fetch_assoc()) {
                                echo '<div class="panel panel-default" data-beerStyle="'. $row["beerStyle"] . '" data-beerName="' . $row["beerName"] . '">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#beer' . $beerCount . '">' . $row["beerName"] . '</a>
                                        </h4>
                                    </div>
                                    <div id="beer' . $beerCount . '" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        ' . $row["beerName"] . '<br>
                                        ABV: ' . $row["beerABV"] . '%<br>
                                        Style: ' . $row["beerStyle"] . '<br>
                                        <button class="ui-button ui-widget ui-corner-all" id="beer'. $beerCount . 'Dislike"><i class="fa fa-thumbs-o-down" aria-hidden="true"></i></button>
                                        <button class="ui-button ui-widget ui-corner-all" id="beer'. $beerCount . 'Like"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></button>';
                                        if($_SESSION) {
                                            // If a session exists, the user will be able to rate beers using AJAX calls to the beerLikeStatusUpdate.php file.  If a like status is set for the beer and the user switches it to the other like status, a SQL update statement will be performed via AJAX and the active class will be added to that tag.  If a like status is completely removed (E.g. If a beer is liked and the like button is clicked again), JQuery will see that the class was marked as active and then perform a delete query for SQL via AJAX.
                                            echo '<script>
                                                $("#beer' . $beerCount . 'Dislike").click(function() {
                                                    if($(this).hasClass("active")) {
                                                        $.ajax({
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
                                                        });
                                                    } else {
                                                        $.ajax({
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
                                                        });
                                                    }
                                                });
                                            
                                                $("#beer' . $beerCount . 'Like").click(function() {
                                                    if($(this).hasClass("active")) {
                                                        $.ajax({
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
                                                        });
                                                    } else {
                                                        $.ajax({
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
                                                        });
                                                    }
                                                });
                                            </script>';
                                        } else {
                                            // If the user is not logged in, pressing the like or dislike button will result in the user being redirected to the login page.
                                            echo '<script>
                                                $("#beer' . $beerCount . 'Dislike").click(function() {';
                                                    echo '$(location).attr("href", "login.php");
                                                });
                                                $("#beer' . $beerCount . 'Like").click(function() {';
                                                    echo '$(location).attr("href", "login.php");
                                                });
                                            </script>';
                                        }
                                        echo '<div class="likePercentage'. $beerCount . '" id="likePercentage' . $beerCount . '"></div>
                                        <script>calculateTotals(' . $beerCount . ');</script>
                                        </div>
                                    </div>
                                </div>';
                        $beerCount++;
                    }
                    
                    // This ends the beer list.  Afterwards, JavaScript is placed onto the page that calls the beer information and reviews into the review column via AJAX.  This information is called and then shown by using functions whenever the specific accordion item is opened.  The information is then hidden whenever the accordion is closed.
                    
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
            </div>
        </div>
            <!-- Bootstrap column with elements used to sort the beers in the beers column.  This column is only viewable on desktop browsers. -->
            <div class="hidden-xs hidden-sm col-md-2 col-lg-2 sortBeers">
                <h3>Sort Beers</h3>
                <div class="radio">
                    <label class="beerSort"><input type="radio" name="beerSort" value="beerName">Name</label>
                </div>
                <div class="radio">
                    <label class="beerSort"><input type="radio" name="beerSort" value="beerABV">Beer ABV</label>
                </div>
                <div class="radio">
                    <label class="beerSort"><input type="radio" name="beerSort" value="style">Beer Style</label>
                </div>
                <div class="radio">
                    <label class="beerSort"><input type="radio" name="beerSort" value="brewer">Brewer</label>
                </div>
                <div class="radio">
                    <label class="beerSort"><input type="radio" name="beerSort" value="none" checked="checked">None</label>
                </div>
            </div>
        </div>
    
    <script>
        // Whenever the page loads, the review buttons for writing, editing, and deleting reviews and hidden.  This is done because they are dynamically called to show and hide as each accordion is shown and hidden.
        $(function() {
            $('.beerOpen').hide();
            $('.beerViewReviews').hide();
            $('.beerWriteReviewButton').hide();
            $('.beerEditDelReviewButtons').hide();
        });
        // If a sorting radio button is selected, this function will be called.  It will check and see the value of the button selected, change the sorting method, and then perform an AJAX call with PHP to reload the beer list with the sorting applied.
        $('input[type=radio][name="beerSort"]').change(function() {
            var beerSortMethodValue = "none";
            if (this.value == "beerName") {
                beerSortMethodValue = "beerName";
            }
            if (this.value == "beerABV") {
                beerSortMethodValue = "beerABV";
            } else if (this.value == "style") {
                beerSortMethodValue = "style";
            } else if (this.value == "brewer") {
                beerSortMethodValue = "brewer";
            } else if (this.value == "none") {
                beerSortMethodValue = "none";
            }
            $.ajax({
                url: "ajax/beerGrouping.php",
                type: "POST",
                data: {"beerSortMethod": beerSortMethodValue},
                success: function(newList) {
                    //called when successful
                    $("#beerList").empty;
                    $("#beerList").html(newList);
                    $(".beerClosed").show();
                    $(".beerOpen").hide();
                    $(".beerWriteReviewButton").hide();
                    $('.beerViewReviews').hide();
                },
                error: function(e) {
                    //called when there is an error
                    //console.log(e.message);
                }
            });
        });
        // This will trigger the AJAX call to create a text field and submit review button on the beers page.
        $('#newReviewButton').click(function() {
            var beerName = $('#accordion .in').parent().attr('data-beerName');
            $.ajax({
                url: "ajax/beerWriteReview.php",
                type: "POST",
                success: function(writeReviewArea) {
                    $(".beerWriteReview").empty();
                    $(".beerWriteReview").html(writeReviewArea);
                    $(".beerWriteReviewButton").hide();
                }
            });
        });
        // This will trigger the AJAX call to create a text field and submit review button on the beers page.  Information from the review previously created by the user will be pre-populated into the text field.
        $('#editReviewButton').click(function() {
            var beerName = $('#accordion .in').parent().attr('data-beerName');
            $.ajax({
                url: "ajax/beerEditReview.php",
                type: "POST",
                data: {"beerName": beerName},
                success: function(editReviewArea) {
                    $(".beerWriteReview").empty();
                    $(".beerWriteReview").html(editReviewArea);
                    $(".beerEditDelReviewButtons").hide();
                }
            })
        });
        // Does a JavaScript confirmation to see if the user really wants to delete the review.  If they do, an AJAX call will be performed to delete the review via a SQL statement.
        $('#deleteReviewButton').click(function(){
            var confirmDelete = confirm("By clicking OK, your review of this beer will be deleted.");
            if (confirmDelete == true) {
                var beerName = $('#accordion .in').parent().attr('data-beerName');
                $.ajax({
                    url: "ajax/beerSubmitReview.php",
                    type: "POST",
                    data: {"beerName": beerName, "beerReviewType": 2},
                    success: function() {
                        $.ajax({
                            url: "ajax/beerViewReviews.php",
                            type: "POST",
                            data: {"beerName": beerName},
                            success: function(data) {
                                $(".beerViewReviews").html(data);
                                if($(".viewReviewsSection").is(":empty")) {
                                    $(".beerViewReviews").html("<h3>There are no reviews for this beer. Be the first to review this beer.</h3>");
                                }
                            },
                            error: function(e) {
                                //called when there is an error
                                //console.log(e.message);
                            }
                        });
                        $(".beerWriteReviewButton").show();
                        $(".beerEditDelReviewButtons").hide();
                        $(".beerWriteReview").html("Your review has been successfully deleted.");
                    }
                });
            }
        });
    </script>

    <?php
        if ($_SESSION) {
            // If the user is logged in, the user will be able to see which beers they liked and disliked based off of the color of the like and dislike buttons.  This is done with a combination of PHP and JQuery.
            $query2 = 'SELECT * from ratings WHERE finalUsersID_fk = ' . $_SESSION["userID"] . ';';
            $beerCount = 1;
            if ($result2 = mysqli_query($dbConnection, $query2)){
                while($row = $result2->fetch_assoc()) {
                    if ($beerCount = $row['beerID_fk']) {
                        echo '<script>';
                            if($row["rating"] == 0) {
                                echo '$("#beer'. $beerCount . 'Dislike").css("background-color","red");
                                $("#beer'. $beerCount . 'Dislike").addClass("active");';
                            } else if($row["rating"] == 1) {
                                echo '$("#beer'. $beerCount . 'Like").css("background-color","green");
                                $("#beer'. $beerCount . 'Like").addClass("active");';
                            }
                        echo '</script>';
                    }
                    $beerCount++;
                }
            }
        }
    ?>
    <!-- Note that Brackets will complain that the closing is incomplete.  This is because that the various documents used to properly close the file are loaded via the includes method. -->
    </div>
<?php
    include 'footer.php';
?>
</body>
</html>