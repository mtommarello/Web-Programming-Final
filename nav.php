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
                        <li><a href="brewers.php">Brewers</a></li>
                        <li><a href="beers.php">Beers</a></li>
                        <?php
                            if($_SESSION) {
                                //echo '<li><a href="profile.php">Profile</a></li>';
                                echo '<li><a href="logout.php">Log Out</a></li>';
                            } else {
                                echo '<li><a href="login.php">Login</a></li>';
                            }
                        ?>
                        <!-- <li><a href="userprofile.php">Create a Profile</a></li> -->
                        <li><a href="about.php">About</a></li>
                    </ul>
            </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>