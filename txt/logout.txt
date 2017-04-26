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
    // Destroys the session and logs the user out.  Goes back to the page that the user was on before.  If the page requires the user to be logged in, that page will redirect them to the login page.
    include 'nav.php';
    session_destroy();
    echo '<script>';
        echo 'window.history.back();';
    echo '</script>';
?>
    <!-- Note that Brackets will complain that the closing is incomplete.  This is because that the various documents used to properly close the file are loaded via the includes method. -->
</html>