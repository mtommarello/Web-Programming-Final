<?php
    session_start();
?>
<!DOCTYPE html>

<html>

<?php
    include 'header.php';
?>
    
<head>
    <title>Beer Time - Beers</title>
</head>

<body>
    <?php
    include 'nav.php';
    include 'dbConnection.php';
    ?>
    <script>$.backstretch("img/web-background.jpg")</script>
    <div class="container">
        <div class="row animated zoomIn">
            <?php
                $query = "SELECT beerName, beerABV, beerStyle FROM beers";
                $beerCount = 1;
                if ($result = mysqli_query($dbConnection, $query)){

                        echo '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12>';
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
                                        echo '<button class="ui-button ui-widget ui-corner-all" id=beer'. $beerCount . 'Like"><i class="fa fa-thumbs-o-down" aria-hidden="true"></i></button>';
                                        echo '<button class="ui-button ui-widget ui-corner-all" id=beer'. $beerCount . 'Like"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></button>';
                                        echo '<div class="likeStatus"></div>';
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

<script>
    
    
    
    </script>


<?php
    include 'footer.php';
?>
</body>
</html>