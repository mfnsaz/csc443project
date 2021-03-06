<?php
    require_once "../inc/connect.php";

    if($_SERVER["REQUEST_METHOD"] == "GET"){
        //get clublist
        $getOfficerSQL = "SELECT officer_id, officer_name FROM officers";
        $officerRes = mysqli_query($conn, $getOfficerSQL);
        if(!is_bool($officerRes)){
            $outputOfficerId = array();
            $outputOfficerName = array();
            $outputOfficerArr = array();
            $officerArr = mysqli_fetch_all($officerRes);
            $officerArr = array_values($officerArr);
            //array_push($outputOfficerId, NULL);
            //array_push($outputOfficerName, "");
            foreach($officerArr as $currOfficer){
                array_push($outputOfficerId, $currOfficer[0]);
                array_push($outputOfficerName, $currOfficer[1]);
            }
            $outputOfficerArr = array(
                "officerId" => $outputOfficerId,
                "officerName" => $outputOfficerName,
            );
        } else {
            $officerArr = array("0" => "Error");
            header('X-PHP-Response-Code: 500', true, 500);
            die();
        }

        header("Content-Type: application/json");
        echo json_encode($outputOfficerArr, JSON_PRETTY_PRINT);
        die();
    }
    else {
        header('X-PHP-Response-Code: 500', true, 500);
        die();
    }
?>