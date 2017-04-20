<?php
    session_start();
?>
<!doctype html>
<html lang="en-us">
<?php   
    include 'dbConnection.php';
    include 'header.php';
?>
    <title>Beer Time - Login</title>
</head>
<body>
<?php
    include 'nav.php';
        if($_SESSION) {
            echo '<script>';
                echo 'window.history.back();';
            echo '</script>';
        }
        if($_POST){

            //if user submits with an empty field
            if(empty($_POST["userName"]) || empty($_POST["password"])){
                echo '<div class="container">';
                    echo '<div class="row">';
                        echo '<div class="col-sm-12">';
                            echo '<div class="alert alert-danger alert-dismissable">';
                                echo '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
                                echo '<strong id="#loginPage">The user name or password field is empty.</strong>';
                            echo '</div>';
                        echo '</div>';
                    echo '</div>';
                echo '</div>';
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
                        echo '<div class="container">';
                            echo '<div class="row">';
                                echo '<div class="col-sm-12">';
                                    echo '<div class="alert alert-danger alert-dismissable">';
                                        echo '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
                                        echo '<strong>Error: ' .$singleError . '</strong>';
                                    echo '</div>';
                                echo '</div>';
                            echo '</div>';
                        echo '</div>';
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
                        echo '<div class="container">';
                            echo '<div class="row">';
                                echo '<div class="col-sm-12">';
                                    echo '<div class="alert alert-danger alert-dismissable">';
                                        echo '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
                                        echo '<strong>Error: username, password, or both incorrect.</strong>';
                                    echo '</div>';
                                echo '</div>';
                            echo '</div>';
                        echo '</div>';
                    }

                    else{
                        $_SESSION['userName'] = $userName;

                        while($row = mysqli_fetch_row($resultUser)){
                            foreach($row as $key=> $col){
                                   $_SESSION['userID'] =$col;
                                  }
                        }
                        mysqli_close($dbConnection);
                        echo '<script>';
                            echo 'window.history.back();';
                        echo '</script>';
                    }
                }
            }
        }

        else{
            $userName ="";
            $password="";
        }



    ?>
    

    <!--Form to get username/password-->
    <form method="post" action="login.php">
        <div class="container">
            <div class="row animated fadeIn">
                <div class="col-sm-12 cards">
                    <div class="form-group">
                        <h2>Please login</h2>
                        <label for="userName" class="loginPage">Username: </label>
                        <input name ="userName" type="text" id="userName" class="form-control loginPage" placeholder= "Enter Username" value="<?php echo htmlspecialchars($userName); ?>"  maxlength="20" required>
                        <br>
                        <label for="password" class="loginPage">Password: </label>
                        <input name="password"  type="password" id="password" class="form-control loginPage" placeholder= "Enter Password" value="<?php echo htmlspecialchars($password); ?>" maxlength="15" required >
                        <br>
                        <button type="submit" class="btn btn-primary" id="loginPage">Login</button>
                    </div>
                </div>
            </div>
        </div>       
    </form>
</body>
</html>