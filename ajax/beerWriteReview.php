<?php

    session_start();
    include '../dbConnection.php';
    echo '<script>';
        echo '$("beerReview").on("submit", function (e) {
            e.preventDefault();
            
            $.ajax({
                type: "post",
                url: "ajax/beerSubmitReview.php",
                data: $("beerReview").serialize(),
                success: function() {
                    $("beerWriteReview").empty();
                    $("beerWriteReview").hide();
                    beerviewReviews();
                }
            });
        });
    </script>';
    echo '<form id="beerReview">';
        echo '<div class="form-group">';
            echo '<label for="reviewText">Review</label>';
            echo '<input class="form-control input-lg" id="reviewText" type="text">';
            echo '<span class="help-block">Write your review here.</span>';
        echo '</div>';
        echo '<button type="submit" class="btn btn-primary">Submit Review</button>';
    echo '</form>';

?>