<?php
    session_start();
?>
<!DOCTYPE html>

<html>

<?php
    include 'header.php';
?>
    <title>Beer Time - Plan My Night</title>

</head>
<body>
    <?php
        include 'nav.php';
        include 'dbConnection.php';
    ?>
    <script>
        $.backstretch("img/web-background.jpg");
    </script>
        
    <div class="container">
        <div class="row animated zoomIn">
            <?php
                // Only lets the user view this page if they are logged in, otherwise they are redirected to the login page.
                if($_SESSION) {
                    // This will run a query to get all beers that the user liked.  Once the query is run, a loop will run to print all the beers liked into checkbox variables with data tags used by JQuery.
                    $query = "SELECT * FROM ratings INNER JOIN beers ON beerID_fk = beerID WHERE rating = 1 AND finalUsersID_fk = " . $_SESSION['userID'] . ";";
                    if ($result = mysqli_query($dbConnection, $query)){
                        echo '<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 cards">';
                            echo '<h2>Select Your Drinks</h2>';
                            echo '<div class="radio" id="selectDrinks">';
                                while ($row = $result->fetch_assoc()) {
                                    echo '<div class="checkbox">';
                                        echo '<label><input type="checkbox" value="' . $row["beerID"] . '" data-standardDrink = ' . $row["standardDrink"] . ' data-beerName = "' . $row["beerName"] . '">' . $row["beerName"] . '</label>';
                                    echo '</div>';
                                }
                            // Submit button used by JQuery to go to the quantity step.
                            echo '<button type="submit" class="btn btn-primary" id="drinksSelected">Submit Drinks</button>';
                            echo '</div>';
                        echo '</div>';
                    }
                } else {
                    // Goes to the login page if the user is not logged in.
                    echo '<script>';
                        echo '$(location).attr("href", "login.php");';
                    echo '</script>';
                }

            ?>
            <!-- Column used to select quantity.  Populated with JQuery. -->
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 cards">
                <h2>Select Your Quantity</h2>
                <div class="radio">
                    <form id="addedToQuantity">
                    </form>
                </div>
                <div id="calculateStandardDrinkButton">
                    <button type="submit" class="btn btn-primary" id="quantitySelected">Calculate Standard Drink</button>
                </div>
            </div>
            <!-- Final calculation performed with JQuery. -->
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 cards">
                <h2>Total</h2>
                <div id="finalTotal"></div>
                <div id="newCalculationButton">
                    <button type="submit" class="btn btn-primary" id="newCalculation">New Calculation</button>
                </div>
            </div>
        </div>
    </div>
   
    <script>
        $(function() {
            // When the document is loaded, the buttons to calculate the drinks and to create a new calculation are hidden because the user did not get to those steps yet.
            $('#calculateStandardDrinkButton').hide();
            $('#newCalculationButton').hide();
        });
        
        $('#drinksSelected').click(function() {
            // When the user selects the submit button to go to the quantity selection, this function is called.  This will check the checked elements and append them to the quantity column through JQuery and HTML.  All elements in the first column are then disabled.
            var beerID = 0;
            $('#selectDrinks :checked').each(function() {
                $('#drinksSelected').prop("disabled", true);
                var standardDrink = $(this).attr('data-standardDrink');
                var beerName = $(this).attr('data-beerName');
                $(this).prop("disabled", true);
                $('#addedToQuantity').append('<div class="form-group"><label for="beer' + parseInt(beerID) + '"</label>' + beerName + '<input type="number" class="form-control" id="beer' + parseInt(beerID) + '" data-standardDrink="' + parseFloat(standardDrink) + '"></div>');
                beerID++;
            });
            $('#calculateStandardDrinkButton').show();
        });
        
        $('#quantitySelected').click(function() {
            // Once the user types in a quantity for all drinks and submits it to be calculated, this will get the drinks checked and pull the tags for the standard drinks.  If no drinks were typed in or a user typed in a negative number, the user will be alerted and they can type in the number and submit it again.  After that, JQuery will then disable the quantity column, calculate the number of standard drinks by adding it to the standardDrinkTotal variable, then print it in the third Bootstrap column.  The new calculation button will then be shown in the third column.
            var standardDrinkTotal = 0;
            var calculationButtonShowValue = 0;
            var numberOfDrinks = 0;
            var beerID = 0;
            $('#addedToQuantity input[type=number]').each(function() {
                numberOfDrinks = $('#beer' + parseInt(beerID)).val();
                var standardDrinkTemp = $('#beer' + parseInt(beerID)).attr('data-standardDrink');
                console.log(standardDrinkTemp);
                if (parseInt(numberOfDrinks) <= 0 || numberOfDrinks == "") {
                    alert("Please enter a positive whole number.");
                    return false;
                } else {
                    $('#beer' + parseInt(beerID)).prop("disabled", true);
                    standardDrinkTotal += (numberOfDrinks * standardDrinkTemp);
                    calculationButtonShowValue = 1;
                }
                beerID++;
            });
            if(parseInt(calculationButtonShowValue) == 1) {
                $('#finalTotal').append('<p>The selection you made will result in you drinking ' + parseFloat(standardDrinkTotal) + ' standard drinks.');
                $('#newCalculationButton').show();
                $('#quantitySelected').prop("disabled", true);
            }
        });
        $('#newCalculation').click(function() {
            // Once the calculation is completed, the user can click this to reload the page for a new calculation.
            location.reload();
        });
    </script>

    <?php
            include 'footer.php';
    ?>
</body>
    <!-- Note that Brackets will complain that the closing is incomplete.  This is because that the various documents used to properly close the file are loaded via the includes method. -->
</html>