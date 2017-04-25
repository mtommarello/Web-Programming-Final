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
                $query = "SELECT brewersID, brewerName, brewerLocation, brewerLat, brewerLong, brewersHours, brewersDes, brewerAddress FROM brewers";
                $brewerCount = 1;
                if ($result = mysqli_query($dbConnection, $query)){
                        echo '<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">';
                            echo '<div class="panel-group" id="accordion">';
                            while ($row = $result->fetch_assoc()) {
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
    $().ready(function() {
        $('#map').hide();
        $('.brewersOpen').hide();
        $('.hours').hide();
        $('.address').hide();
        $('.location').hide();
    });
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
</script>
</body>
</html>