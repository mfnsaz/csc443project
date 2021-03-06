<?php
    require_once "../inc/connect.php";

    if($_SERVER["REQUEST_METHOD"] == "GET"){
        //get clublist
        $getClubSQL = "SELECT club_id, club_name FROM clubs";
        $clubRes = mysqli_query($conn, $getClubSQL);
        if(!is_bool($clubRes)){
            $outputClubId = array();
            $outputClubName = array();
            $outputClubArr = array();
            $clubArr = mysqli_fetch_all($clubRes);
            $clubArr = array_values($clubArr);
            foreach($clubArr as $currClub){
                array_push($outputClubId, $currClub[0]);
                array_push($outputClubName, $currClub[1]);
            }
            $outputClubArr = array(
                "clubId" => $outputClubId,
                "clubName" => $outputClubName,
            );
        } else {
            $clubArr = array("0" => "Error");
            header('X-PHP-Response-Code: 500', true, 500);
            die();
        }

        header("Content-Type: application/json");
        echo json_encode($outputClubArr);
        die();
    }
    else {
        header('X-PHP-Response-Code: 500', true, 500);
        die();
    }
?>