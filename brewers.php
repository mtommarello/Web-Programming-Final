<?php
    session_start();
?>
<html>
<?php
    include 'header.php';
?>
<body>
    <?php
    include 'nav.php';
    include 'dbConnection.php';
    ?>
    <script>$.backstretch("img/web-background.jpg")</script>
    <div class="container">
        <div class="row animated zoomIn">
            <?php
                $query = "SELECT brewerName FROM brewers";
                $brewerCount = 1;
                if ($result = mysqli_query($dbConnection, $query)){
                    while ($row = $result->fetch_assoc()) {
                        echo "<div class='hidden-xs col-sm-6 col-md-4 col-lg-3 beerList' id='brewer". $brewerCount . ">";
                            echo "<h2>" . $row["brewerName"] . "</h2>";
                            echo '<button class="ui-button ui-widget ui-corner-all" id=brewer'. $brewerCount . 'Like"><i class="fa fa-thumbs-o-down" aria-hidden="true"></i></button>';
                            echo '<button class="ui-button ui-widget ui-corner-all" id=brewer'. $brewerCount . 'Like"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></button>';
                        echo "</div>";
                        echo "<div class='col-xs-12 hidden-sm hidden-md hidden-lg beerListXs' id='brewer". $brewerCount . "'>";
                            echo "<h2>" . $row["brewerName"] . "</h2>";
                            echo '<button class="ui-button ui-widget ui-corner-all" id=brewer'. $brewerCount . 'Like"><i class="fa fa-thumbs-o-down" aria-hidden="true"></i></button>';
                            echo '<button class="ui-button ui-widget ui-corner-all" id=brewer'. $brewerCount . 'Like"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></button>';
                        echo "</div>";
                        $brewerCount++;
                    }
                }
            ?>
        </div>
    </div>
<?php
    include 'footer.php';
?>
</body>
</html>