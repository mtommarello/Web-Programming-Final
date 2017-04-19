<?php
    session_start();
?>
<html>
<?php
    include 'header.php';
?>
<body>
    <?php
    include 'nav.php';
    include 'dbConnection.php';
    ?>
    <script>$.backstretch("img/web-background.jpg")</script>
    <div class="container">
        <div class="row animated zoomIn">
            <?php
                $query = "SELECT brewerName, brewerLocation, brewerLat, brewerLong FROM brewers";
                $brewerCount = 1;
                if ($result = mysqli_query($dbConnection, $query)){
                        echo '<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4>';
                            echo '<div class="panel-group" id="accordion">';
                    while ($row = $result->fetch_assoc()) {
                                echo '<div class="panel panel-default" data-lat="' . $row["brewerLat"] . '" data-long="' . $row["brewerLong"] . '" data-brewerName="' . $row["brewerName"] . '">';
                                    echo '<div class="panel-heading">';
                                        echo '<h4 class="panel-title">';
                                            echo '<a data-toggle="collapse" data-parent="#accordion" href="#brewer' . $brewerCount . '">' . $row["brewerName"] . '</a>';
                                        echo '</h4>';
                                    echo '</div>';
                                    echo '<div id="brewer' . $brewerCount . '" class="panel-collapse collapse">';
                                        echo '<div class="panel-body">';
                                        echo 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim adminim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</div>';
                                    echo '</div>';
                                echo '</div>';
                        $brewerCount++;
                    }
                        echo '</div>';
                }
            ?>
            <div class="hidden-xs hidden-sm col-md-8 col-lg-8 brewerDesc">
                <h2 class="brewersClosed">Select a Brewer on the Left</h2>
                <h2 class="brewersOpen"></h2>
                <div id="map"></div>
            </div>
        </div>
    </div>
<?php
    include 'footer.php';
?>
</body>
<script>
    $().ready(function() {
        $('#map').hide();
        $('.brewersOpen').hide();
    });
    function initMap(lat, long) {
        var uluru = {lat: parseFloat(lat), lng: parseFloat(long)};
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 16,
            center: uluru
        });
        console.log(uluru);
        var marker = new google.maps.Marker({
            position: uluru,
            map: map
        });
    }
    $('#accordion').on('shown.bs.collapse', function () {
        var brewer = $('#accordion .in').parent().attr("data-brewerName");
        $(".brewersOpen").html(brewer);
        $(".brewersClosed").hide();
        $(".brewersOpen").show();
        var lat = $('#accordion .in').parent().attr("data-lat");
        var long = $('#accordion .in').parent().attr("data-long");
        console.log(lat);
        console.log(long);
        $('#map').show();
        initMap(lat, long);
    });

    $('#accordion').on('hidden.bs.collapse', function () {
        $('#map').hide();
        $('.brewersOpen').hide();
        $('.brewersClosed').show();
    });
</script>
<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCeRGYmDRGcx9vWRK9hyiPg9AWQJlw-J_4&callback=initMap">
</script>
</html>