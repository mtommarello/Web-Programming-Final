<?php
    session_start();
    include '../dbConnection.php';
    if($_SESSION) {
        $userID = $_SESSION["userID"];
        $beerName = $_POST["beerName"];
        $reviewText = "";
        $query = 'SELECT * FROM reviews INNER JOIN beers ON beerID_fk = beerID WHERE beerName = "' . $beerName . '" AND finalUserID_fk = ' . $userID . ';';
        if ($resultReview = mysqli_query($dbConnection, $query)){
            while ($row = $resultReview->fetch_assoc()) {
                $reviewText = $row["review"];
            }
        }
        echo '<form id="beerReview">';
            echo '<div class="form-group">';
                echo '<label for="reviewText">Review</label>';
                echo '<input class="form-control input-lg" id="reviewText" type="text" value=' . $reviewText . '>';
                echo '<span class="help-block">Edit your review here.</span>';
            echo '</div>';
            echo '<button type="submit" class="btn btn-primary" id="submitReviewButton">Submit Review</button>';
        echo '</form>';

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
                                        if($(".viewReviewsSection").is(":empty")) {
                                            $(".beerViewReviews").html("<h3>There are no reviews for this beer. Be the first to review this beer.</h3>");
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