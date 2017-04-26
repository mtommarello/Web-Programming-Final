<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display --> <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false"> <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="index.php"></a>
        <?php
            // If the user is logged in, the navbar will change to reflect their first name.
            if($_SESSION) {
                echo '<a class="navbar-brand" href="index.php">Beer Time for ' . $_SESSION['fName'] . '</a>';
            } else {
                echo '<a class="navbar-brand" href="index.php">Beer Time</a>';
            }
        ?>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="about.php">About</a></li>
                        <li><a href="beers.php">Beers</a></li>
                        <li><a href="brewers.php">Brewers</a></li>
                        <?php
                            if($_SESSION) {
                                // If the user is logged in, the Plan My Night, Profile, and log out options appear.
                                echo '<li><a href="planNight.php">Plan My Night</a></li>';
                                echo '<li><a href="profile.php">Profile</a></li>';
                                echo '<li><a href="logout.php">Log Out</a></li>';
                            } else {
                                // If the user is not logged in, the options to create an account or log in appear.
                                echo '<li><a href="userprofile.php">Create Account</a></li>';
                                echo '<li><a href="login.php">Login</a></li>';
                            }
                        ?>
                    </ul>
            </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>