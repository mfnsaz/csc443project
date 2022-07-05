<?php
    session_start();
    $_SESSION = "";
    session_destroy();
    header("refresh:0;url=/");
?>