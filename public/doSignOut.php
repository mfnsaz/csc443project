<?php
    session_start();
    session_destroy();
    header("refresh:5;url=index.php");
?>