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
                if($_SESSION) {
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
                            echo '<button type="submit" class="btn btn-primary" id="drinksSelected">Submit Drinks</button>';
                            echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo '<script>';
                        echo '$(location).attr("href", "login.php");';
                    echo '</script>';
                }

            ?>
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
            $('#calculateStandardDrinkButton').hide();
            $('#newCalculationButton').hide();
        });
        
        $('#drinksSelected').click(function() {
            var beerID = 0;
            console.log("Initial beer ID is " + beerID);
            $('#selectDrinks :checked').each(function() {
                $('#drinksSelected').prop("disabled", true);
                var standardDrink = $(this).attr('data-standardDrink');
                var beerName = $(this).attr('data-beerName');
                $(this).prop("disabled", true);
                $('#addedToQuantity').append('<div class="form-group"><label for="beer' + parseInt(beerID) + '"</label>' + beerName + '<input type="number" class="form-control" id="beer' + parseInt(beerID) + '" data-standardDrink="' + parseFloat(standardDrink) + '"></div>');
                beerID++;
                console.log("Subsequent beer ID is " + beerID);
            });
            $('#calculateStandardDrinkButton').show();
        });
        
        $('#quantitySelected').click(function() {
            var standardDrinkTotal = 0;
            var calculationButtonShowValue = 0;
            var numberOfDrinks = 0;
            var beerID = 0;
            $('#addedToQuantity input[type=number]').each(function() {
                numberOfDrinks = $('#beer' + parseInt(beerID)).val();
                var standardDrinkTemp = $('#beer' + parseInt(beerID)).attr('data-standardDrink');
                console.log(standardDrinkTemp);
                if (parseInt(numberOfDrinks) <= 0) {
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
            location.reload();
        });
    </script>

    <?php
            include 'footer.php';
    ?>
</body>
</html>