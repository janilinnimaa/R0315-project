<?php
    /*
    Config.php starts output buffer and the session start.
    Also, sets the timezone and opens the mysqli connection.
    */
    ob_start();
    session_start();
    
    $timezone = date_default_timeZone_set("Europe/Helsinki");
    
    $con = mysqli_connect("127.0.0.1:50945", "azure", "6#vWHD_$", "localdb", 3306);    
    if (mysqli_connect_errno()) {
        echo "Failed to connect: " . mysqli_connect_errno();
    }
?>