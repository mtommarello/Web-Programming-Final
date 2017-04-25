    function initMapMobile(lat, long) {
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

                                                echo '<div class="hidden-md hidden-lg" id="mapMobile"></div>';