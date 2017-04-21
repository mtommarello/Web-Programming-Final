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
</html>