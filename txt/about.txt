<?php
    //Statement starts session and used throughout the remaining documents
    session_start();
?>
<!DOCTYPE html>
<html>

<?php 
    //Statement includes header page information and used throughout the remaining documents
    include 'header.php';
?>
    <title>Beer Time - About Us</title>
</head>

<body>

    <?php
    //Statement includes navigation panel information and used throughout the remaining documents
        include 'nav.php';
    ?>

    <script>$.backstretch("img/web-background.jpg")</script>
    
    <!--Creates the about box and includes about information-->
            <div class="container">
                <div class="row animated fadeIn">
                    <div class="col-sm-12 cards">
                        <h2>About Beer Time</h2>
                        <p>We are a website that provides beer information in the Pittsburgh area and shows you the locations of breweries that the beers are made in.</p>
                    </div>
                </div>
            </div>
    <?php
    //Statement includes footer page information and used throughout the remaining documents
        include 'footer.php';
    ?>
</body>
    <!-- Note that Brackets will complain that the closing is incomplete.  This is because that the various documents used to properly close the file are loaded via the includes method. -->
</html>