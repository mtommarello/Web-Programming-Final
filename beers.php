<html>
<head>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

		<!-- jQuery library -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

		<!-- Latest compiled JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>	
</head>
<body>
<?php 
	session_start();
	include 'nav.php';
	include 'dbConnection.php'; 

	$query = "SELECT beerName, beerABV, beerStyle FROM beers";
	$beerCount = 1;
	
	if ($result =mysqli_query($dbConnection, $query)){
		echo "<table>";
		echo "<tr><th>Beer Name</th><th>Beer ABV</th><th>Beer Style</th></tr>";
			foreach($result as $row){
				echo '<tr id="' . $beerCount . '">';
				foreach($row as $key => $val){
					echo "<td>" . $val;
				}
				echo "</tr>";
				$beerCount++;
			}
	}
	
	if($_SESSION){
		for ($i = 0; i < $beerCount; $i++) {
		echo "<script>$('#" . $i . ").append('<button id = '" . $i . "Like'>Like</button></script>";
		}
	}
	

?>



<p> list of beers pulled from database will go here</p>
</body>
</html>