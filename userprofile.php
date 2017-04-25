<?php 
    session_start();
	//connects to database
	include 'dbConnection.php'; 

	// defining the variables and setting empty values 
	$fName = $lName = $userName = $password = $phoneNumber = $age = $email = " ";
	$fnameErr = $lnameErr = $userNameErr = $passwordErr = $phoneErr = $ageErr = $emailErr = " ";
    $counter = 0;
	
if ($_POST) {
	// first name
		if (empty($_POST["fName"])) {
			$fnameErr = "First name is required.<br>";
			$counter++;
		} else if (!preg_match('/^[a-zA-Z]*$/', $_POST['fName'])){
			$fnameErr = "First name must contain only letters.<br>";
			$counter++;
		}
		else {
            $fName = mysqli_real_escape_string($dbConnection,$_POST['fName']);
		}
		
	// last name 
		if (empty($_POST["lName"])) {
			$lnameErr = "Last name is required.<br>";
            $counter++;
		} else if (!preg_match('/^[a-zA-Z]*$/', $_POST['lName'])){ 
			$lnameErr = "Last name must contain only letters.<br>";
			$counter++;
		}
		else {
            $lName = mysqli_real_escape_string($dbConnection,$_POST['lName']);
		}
	
	// username  
		if (empty($_POST["userName"])) {
			$userNameErr = "User name is required.<br>";
            $counter++;
		} else if (!preg_match('/^[a-zA-Z]*$/', $_POST['userName'])){ 
			$userNameErr = "Username must contain only letters.<br>";
			$counter++;
		}
		else {
            $userName = mysqli_real_escape_string($dbConnection,$_POST['userName']);
		}
		
	// password
		if (empty($_POST["password"])) {
			$passwordErr = "You must provide a password.<br>";
            $counter++;
		} else if (!preg_match('/^[a-zA-Z]*$/', $_POST['password'])){
			$passwordErr = "Password must contain only letters and numbers.<br>";
			$counter++;
		}
		else {
            $password = mysqli_real_escape_string($dbConnection,$_POST['password']);
		}
		
	// phone number 	
		if (empty($_POST["phoneNumber"])) {
			$phoneErr = "Phone Number Required.<br>";
			$counter++;;
		} else {
            $phone = mysqli_real_escape_string($dbConnection,$_POST['phoneNumber']);
		}
		
	// age 
		if (empty($_POST["age"])) {
			$ageErr = "Age is required.<br>";
			$counter++;
		} else if (!preg_match('/^[0-9]{2}/', $_POST ['age'])){
		 	$ageErr = "Age can only be a number.<br>";
		 	$counter++;
		}	
		else {
            $age = mysqli_real_escape_string($dbConnection,$_POST['age']);
		}
	
	// email
		if (empty($_POST["email"])) {
			$emailErr = "Email is required.<br>";
			$counter++;
		} else if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
			$emailErr = "Invalid email format.<br>";
			$counter++;
		} 
		else {
            $email = mysqli_real_escape_string($dbConnection,$_POST['email']);
		}
    
        if($counter == 0) {
            $sql = "INSERT INTO finalUsers (fName, lName, password, phoneNumber, age, userName) 
            VALUES ('" . $fName . "', '" . $lName . "', '" . $password . "', '" . $phone . "', '" . $age . "', '" . $userName . "');";

            if (mysqli_query($dbConnection, $sql)){
                echo '<script>window.location.replace("index.php?accountCreated=1");</script>';
            }
        }
	}

?>
	
<!DOCTYPE html>
<html>

<?php 
    include 'header.php';
?>
    <title>Beer Time - Home</title>
</head>
<body>
    
    <?php
        include 'nav.php';
    ?>
    
    
   <form method="post" action="userprofile.php">
        <div class="container">
            <div class="row animated fadeIn">
                <div class="col-sm-12 cards">
                        <h2>Create Profile</h2>
                    <?php
                        if($_POST) {
                            if($counter == 0) {
                            } else {
                                echo '<div class="alert alert-warning">
                                    <strong>Warning!</strong><br>' . $fnameErr,  $lnameErr, $userNameErr, $passwordErr, $ageErr, $emailErr, $phoneErr .
                                    '</div>';
                            }
                        }
                    ?>
                    <div class="form-group">
                        <label for="fName" class="createProfile">First Name: </label>
                        <input type="text" id="fName" name = "fName" class="form-control createProfile" value = "<?php if    (isset($_POST['fName'])){echo htmlspecialchars($fName);}?>"/>
                    </div>
                    <div class="form-group">
                        <label for="lName" class="createProfile">Last Name: </label>
			             <input type="text" id= "lName" name = "lName" class="form-control createProfile" value = "<?php if (isset($_POST['lName'])){echo htmlspecialchars($lName);}?>"/>
                    </div>
                    <div class="form-group">
                        <label for="userName" class="createProfile">Username: </label>
			             <input type="text" id="userName" name = "userName" class="form-control createProfile" value = "<?php if (isset($_POST['userName'])){echo htmlspecialchars($userName);}?>"/>
                    </div>
                    <div class="form-group">
                        <label for="password" class="createProfile">Password: </label>
			             <input type="password" id="password" name = "password" class="form-control createProfile" value = "<?php if (isset($_POST['password'])){echo htmlspecialchars($password);}?>"/>
                    </div>
                    <div class="form-group">
                        <label for="age" class="createProfile">Age: </label>
                        <input type="number" id="age" name="age" class="form-control createProfile" value = "<?php if (isset($_POST['age'])){echo htmlspecialchars ($age);}?>"/>
                    </div>
                    <div class="form-group">
                        <label for="email" class="createProfile">Email: </label>
                        <input type="email" id="email" name="email" class="form-control createProfile" value = "<?php if(isset($_POST['email'])){echo htmlspecialchars ($email);}?>"/>
                    </div>
                    <div class="form-group">
                        <label for="phoneNumber" class="createProfile">Phone Number: </label>
                        <input type="tel" id="phoneNumber" name="phoneNumber" class="form-control createProfile" value = "<?php if(isset($_POST['phoneNumber'])){echo htmlspecialchars ($phone);}?>"/>
                    </div>
                    <button type="submit" class="btn btn-primary" id="createProfile">Create Account</button>
                    <br>
                    <br>
                    <p>Already have an account? <a href="login.php">Click here to login.</a></p>
                </div>
            </div>
        </div>       
    </form>
</body>
    <!-- Note that Brackets will complain that the closing is incomplete.  This is because that the various documents used to properly close the file are loaded via the includes method. -->
</html>