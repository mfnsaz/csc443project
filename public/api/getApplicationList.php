<?php
    require_once "../inc/connect.php";

    if($_SERVER["REQUEST_METHOD"] == "GET"){
        //get clublist
        if(isset($_GET["officer_id"])){
            $officerId = $_GET["officer_id"];
            $getAppSQL = "SELECT a.application_id, a.app_name, s.student_name, c.club_name, a.forwarded, a.approved FROM applications AS a JOIN students AS s ON a.student_id = s.student_id JOIN clubs AS c ON s.club_id = c.club_id WHERE a.officer_id = $officerId";
        } else if(isset($_GET["student_id"])){
            $studentId = $_GET["student_id"];
            $getAppSQL = "SELECT a.application_id, a.app_name, s.student_name, c.club_name, a.forwarded, a.approved FROM applications AS a JOIN students AS s ON a.student_id = s.student_id JOIN clubs AS c ON s.club_id = c.club_id WHERE a.student_id = $studentId";
        } else if(isset($_GET["admin_id"])){
            $adminId = $_GET["admin_id"];
            $getAppSQL = "SELECT a.application_id, a.app_name, s.student_name, c.club_name, a.forwarded FROM applications AS a JOIN students AS s ON a.student_id = s.student_id JOIN clubs AS c ON s.club_id = c.club_id WHERE a.admin_id = $adminId";
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
                    if(isset($_GET["student_id"])){
                        array_push($outputRowData, "Edit Application");
                        array_push($outputRowData, '<button class="d-grid mx-auto btn btn-primary" style="display: block;" id="viewAppButton">Edit Application</button>');
                    } else {
                        //
                        array_push($outputRowData, "Not reviewed");
                        array_push($outputRowData, '<button class="d-grid mx-auto btn btn-primary" style="display: block;" id="viewAppButton">Review Application</button>');
                    }
                } else {
                    if($currApp[4] == 1){
                        if(isset($_GET["officer_id"])){
                            if($currApp[5] == NULL){
                                array_push($outputRowData, "Reviewed, Pending Approval");
                                array_push($outputRowData, '<button class="d-grid mx-auto btn btn-primary" style="display: block;" id="viewAppButton" data-bs-toggle="tooltip" data-bs-placement="top" title="Already Reviewed">Approve Application</button>');
                            } else if($currApp[5] == 1){
                                array_push($outputRowData, "Reviewed, Approved");
                                array_push($outputRowData, '<button class="d-grid mx-auto btn btn-primary" style="display: block;" id="viewAppButton" data-bs-toggle="tooltip" data-bs-placement="top" title="Already Reviewed" disabled>Application Approved</button>');
                            } else if($currApp[5] == 0){
                                array_push($outputRowData, "Reviewed, Rejected");
                                array_push($outputRowData, '<button class="d-grid mx-auto btn btn-primary" style="display: block;" id="viewAppButton" data-bs-toggle="tooltip" data-bs-placement="top" title="Already Reviewed" disabled>Application Rejected</button>');
                            }
                        } else if(isset($_GET["student_id"])){
                            if($currApp[5] == NULL){
                                array_push($outputRowData, "Pending officer approval");
                                array_push($outputRowData, '<button class="d-grid mx-auto btn btn-primary" style="display: block;" id="viewAppButton" data-bs-toggle="tooltip" data-bs-placement="top" title="Already Reviewed" disabled>Approval Pending</button>');
                            } else if($currApp[5] == 1){
                                array_push($outputRowData, "Application rejected");
                                array_push($outputRowData, '<button class="d-grid mx-auto btn btn-primary" style="display: block;" id="viewAppButton" data-bs-toggle="tooltip" data-bs-placement="top" title="Already Reviewed" disabled>Application Rejected</button>');
                            } else if($currApp[5] == 0){
                                array_push($outputRowData, "Application approved");
                                array_push($outputRowData, '<button class="d-grid mx-auto btn btn-primary" style="display: block;" id="viewAppButton" data-bs-toggle="tooltip" data-bs-placement="top" title="Already Reviewed" disabled>Application Approved</button>');
                            }
                        } else {
                            array_push($outputRowData, "Reviewed, forwarded to Officer");
                            array_push($outputRowData, '<button class="d-grid mx-auto btn btn-primary" style="display: block;" id="viewAppButton" data-bs-toggle="tooltip" data-bs-placement="top" title="Already Reviewed" disabled>Application Reviewed</button>');
                        }
                    } else {
                        if(isset($_GET["student_id"])){
                            array_push($outputRowData, "Application rejected");
                            array_push($outputRowData, '<button class="d-grid mx-auto btn btn-primary" style="display: block;" id="viewAppButton" data-bs-toggle="tooltip" data-bs-placement="top" title="Already Reviewed" disabled>Application Rejected</button>');
                        } else {
                            array_push($outputRowData, "Reviewed, returned to Student");
                            array_push($outputRowData, '<button class="d-grid mx-auto btn btn-primary" style="display: block;" id="viewAppButton" data-bs-toggle="tooltip" data-bs-placement="top" title="Already Reviewed" disabled>Application Reviewed</button>');
                        }
                    }
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
    } else {
        //echo "did not use get method";
        header('X-PHP-Response-Code: 500', true, 500);
        die();
    }
?>