<?php
    session_start();
    include 'dbConnection.php';
?>

<head>
	<meta charset ="utf-8">
		<title> Login </title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>	
</head>
	
<?php
    if($_POST){
        
        //if user submits with an empty field
        if(empty($_POST["userName"]) || empty($_POST["password"])){
            echo "The user name or password field is empty.";
            $userName ="";
            $password="";
            
        }
        else{
            //trims whitespace
            $userName = trim($_POST["userName"]);
            $password = trim($_POST["password"]);
            
            $userName = mysqli_real_escape_string($dbConnection, $userName);
            $password = mysqli_real_escape_string($dbConnection, $password);
            
			//validations only allow letters/numbers for input
            if(!preg_match('/^[a-zA-Z0-9\s]+$/', $userName)){
                 $errors["userName"] = "The user name or password is invalid.";
             }
            if(!preg_match('/^[a-zA-Z0-9\s]+$/', $password)){
                 $errors["userName"] = "The user name or password is invalid.";
             }
            
            
            //prints out errors in the array if we have any
            if($_POST && !empty($errors)){
                foreach($errors as $singleError){
                    echo "Error: " .$singleError . "<br />";
                }
            }
            
            //if valid entries and no more errors
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($errors))
            {

                //check username & password to the database
                $queryUser =  "SELECT idusers FROM users ";
                $queryUser .= "WHERE userName ='{$userName}' AND userPassword ='{$password}' ";

                $resultUser = mysqli_query($dbConnection, $queryUser);

                $returnedRows=mysqli_num_rows($resultUser);

                //if no matches found in database
                if($returnedRows == 0){
                    echo "Error: username, password, or both incorrect.";
                }
                
                else{
                    echo"Logging in!";

                    $_SESSION['userName'] = $userName;

                    while($row = mysqli_fetch_row($resultUser)){
                        foreach($row as $key=> $col){
                               $_SESSION['userID'] =$col;
                              }
                    }

                    mysqli_close($dbConnection);
                    echo '<script>$(location).attr("href", "index.php");</script>';
                }
            }
        }
    }

    else{
        $userName ="";
        $password="";
    }



?>


<!doctype html>
<html lang="en-us">
<head> 
	<meta charset ="utf-8">
	<title>Animal Forum!</title>
</head>
    
<body>
	<?php //include 'nav.php'; ?>
    <!--Form to get username/password-->
    <form method="post" action="login.php">
    	<div class="container">
    		 </div>
        <div class="container"><p>Please enter your login information below!</p>
        	</div>
        <div class="container"> <label><b>Username:</b></label><br/>
        	<input type= "test" input name ="userName" pacleholder= "Enter Username" value="<?php echo htmlspecialchars($userName); ?>"  maxlength="20" required> <br>
        	</div>
        <div class="container"> <label><b>Password:</b></label><br/>
        	<input type= "text" input name="password"  value="<?php echo htmlspecialchars($password); ?>" maxlength="15" required ><br>
			</div>        
        <div class="container"> <input type="submit" name="submit" value="submit">
    		</div>
    </form>
</body>
</html>