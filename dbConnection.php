<?php

    //Information to connect to the database.

        $hostDB = "sis-teach-01.sis.pitt.edu";
        $userDB = "mit57";
        $passwordDB = "";
        $dbname = "mit57";
            
        $dbConnection = mysqli_connect($hostDB, $userDB, $passwordDB, $dbname);
            // Performs the connection to the database
            if(mysqli_connect_errno()){
                die("Database connection failed: " .
                    mysqli_connect_error().
                   "()". mysqli_connect_errno(). ")"
                   );
            } 
            else{
            }

?>