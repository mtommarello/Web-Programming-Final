<!DOCTYPE html>
<html>

<?php
    session_start();
    include 'header.php';
?>
<body>
    <?php
    include 'nav.php';
    include 'dbConnection.php';
    ?>
    <script>$.backstretch("img/web-background.jpg")</script>
    <div class="container">
        <div class="row">
            <?php
                $query = "SELECT beerName, beerABV, beerStyle FROM beers";
                $beerCount = 1;
                if ($result = mysqli_query($dbConnection, $query)){
                    while ($row = $result->fetch_assoc()) {
                        echo "<div class='hidden-xs col-sm-4 col-md-4 col-lg-3 beerList' id='beer". $beerCount . "'>";
                            echo "<h2>" . $row["beerName"] . "</h2>";
                            echo "<h3>ABV: " . $row["beerABV"] . "</h3>";
                            echo "<h3>Style: " . $row["beerStyle"] . "</h3>";
                        echo "</div>";
                        echo "<div class='col-xs-12 hidden-sm hidden-md hidden-lg beerListXs' id='beer". $beerCount . "'>";
                            echo "<h2>" . $row["beerName"] . "</h2>";
                            echo "<h3>ABV: " . $row["beerABV"] . "</h3>";
                            echo "<h3>Style: " . $row["beerStyle"] . "</h3>";
                        echo "</div>";
                        $beerCount++;
                    }
                }
            ?>
        </div>
    </div>
<!--
//		echo "<tr><th>Beer Name</th><th>Beer ABV</th><th>Beer Style</th></tr>";
//			foreach($result as $row){
	//			echo '<tr id="' . $beerCount . '">';
	//			foreach($row as $key => $val){
	//				echo "<td>" . $val;
	//			}
	//			echo "</tr>";
	//			$beerCount++;
//			}
//	}
//	
	//if($_SESSION){
	//	for ($i = 0; i < $beerCount; $i++) {
	//	echo "<script>$('#" . $i . ").append('<button id = '" . $i . "Like'>Like</button></script>";
	//	}
//	}
//	
//
//?> -->



<?php
    include 'footer.php';
?>
</body>
</html>