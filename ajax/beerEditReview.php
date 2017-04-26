<?php
    //Start session and connects to database via dbConnection.php page
    session_start();
    include '../dbConnection.php';

    //If session is started will run the following
    if($_SESSION) {
        $userID = $_SESSION["userID"];
        $beerName = $_POST["beerName"];
        $reviewText = "";
    
    //Query to pull all beer information for reviews
        $query = 'SELECT * FROM reviews INNER JOIN beers ON beerID_fk = beerID WHERE beerName = "' . $beerName . '" AND finalUserID_fk = ' . $userID . ';';
        if ($resultReview = mysqli_query($dbConnection, $query)){
            while ($row = $resultReview->fetch_assoc()) {
                $reviewText = $row["review"];
            }
        }
    
    //Creates beer review form, text box and submit/review submit button
        echo '<form id="beerReview">';
            echo '<div class="form-group">';
                echo '<label for="reviewText">Review</label>';
                echo '<input class="form-control input-lg" id="reviewText" type="text" value="' . $reviewText . '">';
                echo '<span class="help-block">Edit your review here.</span>';
            echo '</div>';
            echo '<button type="submit" class="btn btn-primary" id="submitReviewButton">Submit Review</button>';
        echo '</form>';

    //On click of review button will show alert if empty text field
        echo
            '<script>
                $("#submitReviewButton").click(function(event) {
                    event.preventDefault();
                    var reviewText = $("#reviewText");
                    var beerName = $("#accordion .in").parent().attr("data-beerName");
                    if (reviewText.val().length <= 0) {
                        alert("Reviews cannot have blank text fields.");
                    } else {
                       $.ajax({
                            url: "ajax/beerSubmitReview.php",
                            type: "POST",
                            data: {"beerName": beerName, "reviewText": reviewText.val(),  "beerReviewType": 1},
                            success: function() {
                                $(".beerWriteReview").html("Your review has been successfully submitted.");
                                $.ajax({
                                    url: "ajax/beerViewReviews.php",
                                    type: "POST",
                                    data: {"beerName": beerName},
                                    success: function(data) {
                                        $(".beerViewReviews").html(data);
                                                //Pulls results from beerViewReviews and inserts them into beers.php html 
                                        if($(".viewReviewsSection").is(":empty")) {
                                                //Checks viewReviewsSection and runs if statement to see if empty
                                            $(".beerViewReviews").html("<h3>There are no reviews for this beer. Be the first to review this beer.</h3>");
                                                //If there are no reviews, this will let the user know that there are no reviews.
                                        }
                                    },
                                    error: function(e) {
                                        //called when there is an error
                                        //console.log(e.message);
                                    }
                                });
                            }
                        });
                    }
                });
            </script>';  
    }