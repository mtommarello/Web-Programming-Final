<?php
    session_start();
?>
<!DOCTYPE html>
<html>

<?php 
    include 'header.php';
?>
    <title>Beer Time - Log Out</title>
</head> 
<?php
    include 'nav.php';
    session_destroy();
    echo '<script>';
        echo 'window.history.back();';
    echo '</script>';
?>
    <!-- Note that Brackets will complain that the closing is incomplete.  This is because that the various documents used to properly close the file are loaded via the includes method. -->
</html>