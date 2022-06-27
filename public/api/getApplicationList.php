<?php
    require_once "../inc/connect.php";

    if($_SERVER["REQUEST_METHOD"] == "GET"){
        //get clublist
        if(isset($_GET["officer_id"])){
            $officerId = $_GET["officer_id"];
            $getAppSQL = "SELECT a.application_id, a.app_name, s.student_name, c.club_name, a.forwarded FROM applications AS a JOIN students AS s ON a.student_id = s.student_id JOIN clubs AS c ON s.club_id = c.club_id WHERE a.officer_id = $officerId";
        } else if(isset($_GET["student_id"])) {
            $studentId = $_GET["student_id"];
            $getAppSQL = "SELECT a.application_id, a.app_name, s.student_name, c.club_name, a.forwarded FROM applications AS a JOIN students AS s ON a.student_id = s.student_id JOIN clubs AS c ON s.club_id = c.club_id WHERE a.student_id = $studentId";
        } else {
            $getAppSQL = "SELECT a.application_id, a.app_name, s.student_name, c.club_name, a.forwarded FROM applications AS a JOIN students AS s ON a.student_id = s.student_id JOIN clubs AS c ON s.club_id = c.club_id";
        }
        $appRes = mysqli_query($conn, $getAppSQL);
        if(!is_bool($appRes)){
            $outputTableData = array();
            $outputAppArr = array();
            $appArr = mysqli_fetch_all($appRes);
            $appArr = array_values($appArr);
            foreach($appArr as $currApp){
                $outputRowData = array();
                array_push($outputRowData, $currApp[0]);
                array_push($outputRowData, $currApp[1]);
                array_push($outputRowData, $currApp[2]);
                array_push($outputRowData, $currApp[3]);
                if($currApp[4] == NULL){
                    array_push($outputRowData, "Not reviewed");
                    array_push($outputRowData, '<button class="d-grid mx-auto btn btn-primary" style="display: block;" id="viewAppButton">Review Application</button>');
                } else {
                    if($currApp[4] == 1){
                        array_push($outputRowData, "Reviewed, forwarded to Officer");
                    } else {
                        array_push($outputRowData, "Reviewed, returned to Student");
                    }
                    array_push($outputRowData, '<button class="d-grid mx-auto btn btn-primary" style="display: block;" id="viewAppButton" data-bs-toggle="tooltip" data-bs-placement="top" title="Already Reviewed" disabled>Application Reviewed</button>');
                }
                array_push($outputTableData, $outputRowData);
            }
            $outputAppArr = array(
                "data" => $outputTableData
            );
        } else {
            //echo mysqli_error($conn);
            header('X-PHP-Response-Code: 500', true, 500);
            die();
        }

        header("Content-Type: application/json");
        echo json_encode($outputAppArr, JSON_PRETTY_PRINT);
        die();
    }
    else {
        header('X-PHP-Response-Code: 500', true, 500);
        die();
    }
?>