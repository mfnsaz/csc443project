<?php
    require_once "../inc/connect.php";

    if($_SERVER["REQUEST_METHOD"] == "GET"){
        //get clublist
        $getClubSQL = "SELECT * FROM clubs";
        $clubRes = mysqli_query($conn, $getClubSQL);
        if(!is_bool($clubRes)){
            $clubArr = mysqli_fetch_all($clubRes);
            $clubArr = array_values($clubArr);
        } else {
            $clubArr = array("0" => "Error");
            header('X-PHP-Response-Code: 500', true, 500);
            die();
        }

        header("Content-Type: application/json");
        echo json_encode($clubArr);
        die();
    } else {
        header('X-PHP-Response-Code: 500', true, 500);
        die();
    }
?>