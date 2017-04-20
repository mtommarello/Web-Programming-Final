<?php
    session_start();
?>
<!DOCTYPE html>
<html>
    
<head>
    <title>Beer Time - Log Out</title>
</head>

<?php 
    include 'header.php';
    include 'nav.php';
    session_destroy();
    echo '<script>';
        echo 'window.history.back();';
    echo '</script>';
?>
</html>