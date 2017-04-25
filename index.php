<?php
    session_start();  // Starts session if one exists.
?>
<!DOCTYPE html>
<html>

<?php 
    include 'header.php';  // Calls scripts and CSS
?>
    <title>Beer Time - Home</title>
</head>
    
    
<body>
    
    <script>
        $(document).ready(function() {
            $(".player").mb_YTPlayer();
        });
        // This loads the background video, which is pulled from YouTube and is royalty-free for personal and educational use.
    </script>

    <?php
        include 'nav.php';  // Places the header at the top of the page.
    ?>


    <!--Video Section-->
    <section class="content-section video-section">
        <div class="pattern-overlay">
            <!-- Container containing the background player along with the information used to play the video.  Also contains the homepage elements -->
            <div class="container">
                <div id="bgndVideo" class="player" data-property="{videoURL:'p1bpG5Aeux4',containment:'body',autoPlay:true, mute:true, startAt:0, opacity:.25, showControls: false}"></div>
                <div class="row">
                    <?php
                        if($_GET['accountCreated'] == 1 ){
                            // If the user just created an account, they will be redirected to the homepage and if a get element with accountCreated = 1 is in the URL, this confirmation message will be shown.
                            echo '<div class="alert alert-success">
                                <strong>Success!</strong> Your user account has been successfully created. Please login to access all features of Beer Time.</div>';
                        }
                    ?>
                </div>
                <!-- Row and columns containing the homepage elements. -->
                <div class="row hidden-xs">
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <h1>Beer Time</h1>
                        <h3>Your one stop shop for all of your favorite Pittsburgh Brewers</h3>
                    </div>
                </div>
                <div class="row animated fadeIn">
                    <div class="col-sm-12 cards"><a href="brewers.php">
                        <h2>Brewers</h2>
                        <p>View Brewers in the Pittsburgh Area</p>
                    </a></div>
                    <div class="col-sm-12 cards"><a href="beers.php">
                        <h2>Beers</h2>
                        <p>View beers in the Pittsburgh Area</p>
                    </a></div>
                    <div class="col-sm-12 cards"><a href="planNight.php">
                        <h2>Plan My Night</h2>
                        <p>Calculate Standard Drinks Based on Drinks You Like</p>
                    </a></div>
                </div>
            </div>
        </div>
    </section>
    <?php
        include 'footer.php'; // Footer
    ?>
</body>
    <!-- Note that Brackets will complain that the closing is incomplete.  This is because that the various documents used to properly close the file are loaded via the includes method. -->
</html>