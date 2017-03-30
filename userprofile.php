<?php 
	// defining the variables and setting empty values 
	$fName = $lName = $userName = $password = $phoneNumber = $age = $email = " ";
	$fnameErr = $lnameErr = $userNameErr = $passwordErr = $phonenumberErr = $ageErr = $emailErr = $counter = " ";
	$employed = array();
	$salary = array(); 
	
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	// first name
		if (empty($_POST["fName"])) {
			$fnameErr = "*First name is required";
			$counter++;
		} else if (!preg_match('/^[a-zA-Z]*$/', $_POST['fName'])){
			$fnameErr = "Must contain only letters";
			$counter++;
		}
		else {
			$fName = $_POST["fName"];
		}
		
	// last name 
		if (empty($_POST["lName"])) {
			$lnameErr = "*Last name is required";
		} else if (!preg_match('/^[a-zA-Z]*$/', $_POST['lName'])){ 
			$lnameErr = "Must contain only letters";
			$counter++;
		}
		else {
			$lName = $_POST["lName"];
		}
	
	// username  
		if (empty($_POST["userName"])) {
			$userNameErr = "*User name is required";
		} else if (!preg_match('/^[a-zA-Z]*$/', $_POST['userName'])){ 
			$userNameErr = "Must contain only letters";
			$counter++;
		}
		else {
			$userName = $_POST["userName"];
		}
		
	// password
		if (empty($_POST["password"])) {
			$passwordErr = "*Incorrect password";
		} else if (!preg_match('/^[a-zA-Z]*$/', $_POST['password'])){
			$passwordErr = "Must contain only letters and numbers";
			$counter++;
		}
		else {
			$password = $_POST["password"];
		}
		
	// phone number 	
		if (empty($_POST["phoneNumber"])) {
			$phoneErr = "*Required";
			$counter++;
		} else if(!preg_match('/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/', $_POST['phoneNumber'])){
			$phoneErr = "xxx-xxx-xxxx format Required";
			$counter++;
		}		
		else {
			$phone = $_POST["phoneNumber"];
		}
		
	// age 
		if (empty($_POST["age"])) {
			$ageErr = "*Age is required";
			$counter++;
		} else if (!preg_match('/^[0-9]{2}/', $_POST ['age'])){
		 	$ageErr = "Only integers 0-9";
		 	$counter++;
		}	
		else {
			$age = $_POST["age"];
		}
	
	// email
		if (empty($_POST["email"])) {
			$emailErr = "*Email is required";
			$counter++;
		} else if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
			$emailErr = "Invalid email format";
			$counter++;
		} 
		else {
			$email = $_POST["email"];
		}
	
	}
?>
	
<!doctype html>
<html lang="en-us">
	<head>
		<meta charset ="utf-8">
		<meta name="userprofile" content="user profile">
		<title> Profile </title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

		<!-- jQuery library -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

		<!-- Latest compiled JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	</head>
<body>
<style>
	#bg{
		background: url('caps.jpg') center;
	}
</style>
<?php include 'nav.php'; ?>
<div id='bg' class = 'container-fluid text-center'>
<div class = 'row' >
<div class='jumbotron'>
<h1 >Welcome to your profile!</h1>
<h3 > Please fill out the follow form to create a profile </h3>
</div>
	<p class="thanks">
		<?php 
	//should display message if the form is submited correctly
		if($_SERVER["REQUEST_METHOD"] == "POST"){
		if($counter == ""){
		echo "Your profile has been submited cheers!";
			}
		}
		?> </p>
</div>
<div class = 'row' >
<div class='col-md-6 col-md-offset-3'>
<div class='well'>

<form method = "POST" action="userprofile.php">

		<div>
			First Name: <input type="text" name = "fName" value = "<?php if (isset($_POST['fName'])){echo htmlspecialchars($fName);}?>"/><span class="error"><?php echo $fnameErr;?></span> 
			</div></br>
		<div>	
			Last Name: <input type="text" name = "lName" value = "<?php if (isset($_POST['lName'])){echo htmlspecialchars($lName);}?>"/><span class="error"><?php echo $lnameErr;?></span>
			</div></br>
		<div>	
			Username: <input type="text" name = "userName" value = "<?php if (isset($_POST['userName'])){echo htmlspecialchars($userName);}?>"/><span class="error"><?php echo $userNameErr;?></span>
			</div></br>
		<div>	
			Password: <input type="text" name = "password" value = "<?php if (isset($_POST['password'])){echo htmlspecialchars($password);}?>"/><span class="error"><?php echo $passwordErr;?></span>
			</div></br>
		<div>
			Age: <input type="text" name="age" value = "<?php if (isset($_POST['age'])){echo htmlspecialchars ($age);}?>"/><span class="error"><?php echo $ageErr;?></span>
			</div></br>
		<div>
			Email: <input type="text" name="email" value = "<?php if(isset($_POST['email'])){echo htmlspecialchars ($email);}?>"/><span class="error"><?php echo $emailErr;?></span>
			</div></br>
		<div>
			Telphone Number: <input type="text" name="phoneNumber" value = "<?php if(isset($_POST['phoneNumber'])){echo htmlspecialchars ($phoneNumber);}?>"/><span class="error"><?php echo $phonenumberErr;?></span>
			</div></br>
 
	
	<input class = 'btn btn-default' type="submit" value = "Submit"> 

</form>

<?php
//timestamps and dates when submited
date_default_timezone_set("America/New_York");
	$date = new DateTime();
		echo $date->format("Y-m-d H:i:s") . "\n";
?>
</div>
</div>
</div>
</div>
</body>
</html>