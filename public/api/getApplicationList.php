<?php
    require_once "../inc/connect.php";

    if($_SERVER["REQUEST_METHOD"] == "GET"){
        //get clublist
        $getAppSQL = "SELECT a.application_id, a.app_namne, s.student_name, c.club_name FROM applications AS a JOIN students AS s ON a.student_id = s.student_id JOIN clubs AS c ON s.club_id = c.club_id";
        $appRes = mysqli_query($conn, $getAppSQL);
        if(!is_bool($appRes)){
            $outputAppId = array();
            $outputAppName = array();
            $outputStudName = array();
            $outputClubName = array();
            $outputAppArr = array();
            $appArr = mysqli_fetch_all($appRes);
            $appArr = array_values($appArr);
            foreach($appArr as $currApp){
                array_push($outputAppId, $currApp[0]);
                array_push($outputAppName, $currApp[1]);
                array_push($outputStudName, $currApp[2]);
                array_push($outputClubName, $currApp[3]);
            }
            $outputAppArr = array(
                "appId" => $outputAppId,
                "appName" => $outputAppName,
                "studName" => $outputStudName,
                "clubName" => $outputClubName,
            );
        } else {
            $appArr = array("0" => "Error");
            header('X-PHP-Response-Code: 500', true, 500);
            die();
        }

        header("Content-Type: application/json");
        echo json_encode($outputAppArr);
        die();
    }
    else {
        header('X-PHP-Response-Code: 500', true, 500);
        die();
    }
?>