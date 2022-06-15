<?php
    session_start();
    session_destroy();
    echo "Signing you out...";
    header("refresh:2;url=index.php");
?>