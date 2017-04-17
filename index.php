<!DOCTYPE html>
<html>

<?php 
    include 'header.php';
?>
<script>
    $(document).ready(function() {
        $(".player").mb_YTPlayer();
    });

</script>

<body>

    <?php
        include 'nav.php';
    ?>


    <!--Video Section-->
    <section class="content-section video-section">
        <div class="pattern-overlay">

            <div class="container">
                <div id="bgndVideo" class="player" data-property="{videoURL:'p1bpG5Aeux4',containment:'body',autoPlay:true, mute:true, startAt:0, opacity:.25, showControls: false}"></div>

                <div class="row hidden-xs">
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <h1>Beer Time</h1>
                        <h3>Your one stop shop for all of your favorite Pittsburgh Brewers</h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 cards">
                        <h2>Brewers</h2>
                        <p>View Brewers in the Pittsburgh Area</p>
                    </div>
                    <div class="col-sm-12 cards">
                        <h2>Beers</h2>
                        <p>View beers in the Pittsburgh Area</p>
                    </div>
                    <div class="col-sm-12 cards">
                        <h2>About</h2>
                        <p>More About Us</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php
        include 'footer.php';
    ?>
</body>

</html>
