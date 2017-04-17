<!DOCTYPE html>
<html>

<?php 
    include 'header.php';
    include 'nav.php';
    ?>
<script src="http://pupunzi.com/mb.components/mb.YTPlayer/demo/inc/jquery.mb.YTPlayer.js"></script>
<script>
    $(document).ready(function() {
        $(".player").mb_YTPlayer();
    });

</script>

<body>


    <!--Video Section-->
    <section class="content-section video-section">
        <div class="pattern-overlay">

            <div class="container ">
                <!-- this is the background video, inside container div, and height set to 100% in CSS  -->
                <a id="bgndVideo" class="player" data-property="{videoURL:'https://www.youtube.com/watch?v=p1bpG5Aeux4',
    containment:'body',
    quality:'hd720',
    autoPlay:true,
    mute:true,
    startAt: 6, 

    opacity: 1}">bg</a>

                <!--more VIDO  options at https://github.com/pupunzi/jquery.mb.YTPlayer/wiki -->

                <div class="row">
                    <div class="col-lg-12">

                        <h1>Beer Time</h1>
                        <h3>Your one stop shop for all of your favorite Pittsburgh Brewers</h3>

                        <!-- Begin Mr. M.'s Rows -->


                        <div class="row">


                            <div class="col-md-4">
                                <h2>Brewers</h2>
                                <p>View Brewers in the Pittsburgh Area</p>
                            </div>
                            <!--/span-->



                            <div class="col-md-4">
                                <h2>Beers</h2>
                                <p>View beers in the Pittsburgh Area</p>
                            </div>
                            <!--/span-->



                            <div class="col-md-4">
                                <h2>About</h2>
                                <p>More About Us</p>
                            </div>
                            <!--/span-->
                        </div>
                        <!--/row-->
                        <!-- END Mr. M.'s Rows -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Video Section Ends Here-->

</body>

</html>
