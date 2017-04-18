<?php
    session_start();
?>
<html>
<?php
    include 'header.php';
?>
<script>

</script>
<body>
    <?php
    include 'nav.php';
    include 'dbConnection.php';
    ?>
    <script>$.backstretch("img/web-background.jpg")</script>
    <div class="container">
        <div class="row animated zoomIn">
            <?php
                $query = "SELECT brewerName FROM brewers";
                $brewerCount = 1;
                if ($result = mysqli_query($dbConnection, $query)){
                            echo '<div class="panel-group" id="accordion">';
                    while ($row = $result->fetch_assoc()) {
                                echo '<div class="panel panel-default">';
                                    echo '<div class="panel-heading">';
                                        echo '<h4 class="panel-title">';
                                            echo '<a data-toggle="collapse" data-parent="#accordion" href="#brewer' . $brewerCount . '">' . $row["brewerName"] . '</a>';
                                        echo '</h4>';
                                    echo '</div>';
                                    echo '<div id="brewer' . $brewerCount . '" class="panel-collapse collapse in">';
                                        echo '<div class="panel-body">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim adminim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</div>';
                                    echo '</div>';
                                echo '</div>';
                                echo '<script>$("#brewer' . $brewerCount . '").collapse("hide");</script>';
                        $brewerCount++;
                    }
                }
            ?>
    </div>
<?php
    include 'footer.php';
?>
</body>
</html>