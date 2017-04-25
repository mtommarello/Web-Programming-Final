<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<?php
    include 'header.php';
?>
    <title>Beer Time - Brewers</title>
</head>
    
<body>
    <?php
    include 'nav.php';
    include 'dbConnection.php';
    ?>
    <script>$.backstretch("img/web-background.jpg")</script>
    <div class="container">
        <div class="row animated zoomIn">
            <?php
                // This column is printed using PHP.  A SQL query is used to fill in the information into each accordion element.
                $query = "SELECT brewersID, brewerName, brewerLocation, brewerLat, brewerLong, brewersHours, brewersDes, brewerAddress FROM brewers";
                $brewerCount = 1;
                if ($result = mysqli_query($dbConnection, $query)){
                    // This will create the column once the query is successfully run.
                    echo '<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">';
                        echo '<div class="panel-group" id="accordion">';
                        while ($row = $result->fetch_assoc()) {
                            // This will create the different panels used to show the brewer descriptions.  The map element inside of the panel is hidden when not on mobile because they are displayed in a separate column on the destop version.
                            echo '<div class="panel panel-default" data-lat="' . $row["brewerLat"] . '" data-long="' . $row["brewerLong"] . '" data-brewerName="' . $row["brewerName"] . '" data-brewerLocation= "' . $row["brewerLocation"] . '" data-brewerAddress="' . $row["brewerAddress"] .'" data-brewerHours="' . $row["brewersHours"] . '" data-brewersID="' . $row["brewersID"] . '">';
                                echo '<div class="panel-heading">';
                                    echo '<h4 class="panel-title">';
                                        echo '<a data-toggle="collapse" data-parent="#accordion" href="#brewer' . $brewerCount . '">' . $row["brewerName"] . '</a>';
                                    echo '</h4>';
                                echo '</div>';
                                echo '<div id="brewer' . $brewerCount . '" class="panel-collapse collapse">';
                                    echo '<div class="panel-body">';
                                        echo $row["brewersDes"] . '<br><br>';
                                        echo '<div class="hidden-md hidden-lg brewerInfo">';
                                            echo '<div class="hidden-md hidden-lg mapMobile" id="mapMobile' . $row["brewersID"] . '"></div>';
                                            echo 'Neighborhood: ' . $row["brewerLocation"] . '<br>';
                                            echo 'Address: ' . $row["brewerAddress"] . '<br>';
                                            echo 'Hours: ' . $row["brewersHours"];
                                        echo '</div>';
                                    echo '</div>';
                                echo '</div>';
                        echo '</div>';
                    $brewerCount++;
                }
                    echo '</div>';
                        echo '</div>';
                }
            ?>
            <!-- This section displays a description of the brewer whenever the user is using a desktop web browser. -->
            <div class="hidden-xs hidden-sm col-md-8 col-lg-8 brewerDesc">
                <h2 class="brewersClosed">Select a Brewer on the Left</h2>
                <h2 class="brewersOpen">JavaScript is disabled in your browser. Please enable JavaScript to enable full functionality.</h2>
                <div id="map"></div>
                <div class="location"></div>
                <div class="address"></div>
                <div class="hours"></div>
            </div>
        </div>
    </div>
<?php
    include 'footer.php';
?>
<script>
    // When the document is loaded, the brewer description information is hidden as there is no information to show.
    $().ready(function() {
        $('#map').hide();
        $('.brewersOpen').hide();
        $('.hours').hide();
        $('.address').hide();
        $('.location').hide();
    });
    // This is used with the Google Map API to pull map data and place it into the desktop version of the column.
    function initMap(lat, long) {
        var uluru = {lat: parseFloat(lat), lng: parseFloat(long)};
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 16,
            center: uluru
        });
        var marker = new google.maps.Marker({
            position: uluru,
            map: map
        });
    }
    // This is used with the Google Map API to pull map data and place it into the mobile version of the column.
        function initMapMobile(lat, long) {
        var uluru = {lat: parseFloat(lat), lng: parseFloat(long)};
        var brewersID = $('#accordion .in').parent().attr("data-brewersID");
        var mapVariable = 'mapMobile' + brewersID;
        var map = new google.maps.Map(document.getElementById(mapVariable), {
            zoom: 16,
            center: uluru
        });
        var marker = new google.maps.Marker({
            position: uluru,
            map: map
        });
    }
    // When a brewer is loaded in the accordion column, the brewer information is grabbed from the data tags placed onto the page via PHP, shows the brewer description information, calls the Google Map API and then places the map either on the desktop or mobile areas depending on the screen size. 
    $('#accordion').on('shown.bs.collapse', function () {
        var brewer = $('#accordion .in').parent().attr("data-brewerName");
        var brewersID = $('#accordion .in').parent().attr("data-brewersID");
        $(".brewersOpen").html(brewer);
        $(".brewersClosed").hide();
        $(".brewersOpen").show();
        var lat = $('#accordion .in').parent().attr("data-lat");
        var long = $('#accordion .in').parent().attr("data-long");
        var location = $('#accordion .in').parent().attr("data-brewerLocation");
        var address = $('#accordion .in').parent().attr("data-brewerAddress");
        var hours = $('#accordion .in').parent().attr("data-brewerHours");
        $(".location").html("Neighborhood: " + location);
        $(".address").html("Address: " + address);
        $(".hours").html("Hours: " + hours);
        $(".location").show();
        $(".address").show();
        $(".hours").show();
        console.log(lat);
        console.log(long);
        $('#map').show();
        initMap(lat, long);
        initMapMobile(lat, long);
    });
    // When a brewer's page is closed, all information in the brewer's description area is hidden and the user is prompted to select a brewer to view information.
    $('#accordion').on('hidden.bs.collapse', function () {
        $('#map').hide();
        $('.brewersOpen').hide();
        $('.brewersClosed').show();
        $('.hours').hide();
        $('.address').hide();
        $('.location').hide();
    });
</script>
<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCeRGYmDRGcx9vWRK9hyiPg9AWQJlw-J_4&callback=initMap">
    // Google Map API.  API key belongs to Sascha M. Rojtas
</script>
</body>
    <!-- Note that Brackets will complain that the closing is incomplete.  This is because that the various documents used to properly close the file are loaded via the includes method. -->
</html>