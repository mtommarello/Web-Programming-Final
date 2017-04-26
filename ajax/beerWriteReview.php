<?php
    session_start();
    include '../dbConnection.php';
    if($_SESSION) {
    
    //Created text box and buttom for review
        echo '<form id="beerReview">';
            echo '<div class="form-group">';
                echo '<label for="reviewText">Review</label>';
                echo '<input class="form-control input-lg" id="reviewText" type="text">';
                echo '<span class="help-block">Write your review here.</span>';
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
                            data: {"beerName": beerName, "reviewText": reviewText.val(), "beerReviewType": 0},
                            success: function() {
                                $(".beerWriteReview").html("Your review has been successfully submitted.");
                                $.ajax({
                                    url: "ajax/beerViewReviews.php",
                                    type: "POST",
                                    data: {"beerName": beerName},
                                    success: function(data) {
                                        $(".beerViewReviews").html(data);
                                            //Pulls results from beerViewReviews and inserts them into beerViewRevies.php html 
                                        if($(".viewReviewsSection").is(":empty")) {
                                            $(".beerViewReviews").html("<h3>There are no reviews for this beer. Be the first to review this beer.</h3>");
                                            //If there are no reviews, this will let the user know that there are no reviews.
                                        }
                                    },
                                    error: function(e) {
                                        //called when there is an error
                                    }
                                });
                            }
                        });
                    }
                });
            </script>';
    } else {
        
    //If user is not logged in with forward them to login page
        echo
            '<script>
                $(location).attr("href", "login.php")
            </script>';
    }

?>