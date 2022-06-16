<?php
    //error_reporting(E_ALL);
    //ini_set('display_errors', 1);
    $rootDir = dirname(__DIR__, 2);
    $creds = parse_ini_file($rootDir."/.ini");
    $server = $creds["server"];
    $username = $creds["username"];
    $password = $creds["password"];
    $database = $creds["database"];

    /* Database credentials. Assuming you are running MySQL
    server with imported settings */
    define('DB_SERVER', $server);
    define('DB_USERNAME', $username);
    define('DB_PASSWORD', $password);
    define('DB_NAME', $database);

    $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    if (mysqli_connect_errno())
    {
        echo "Failed to connect to MySQL: ".mysqli_connect_error();
    } else {
        //echo "Connection established!";
    }
?>