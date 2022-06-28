<?php
    require_once "../inc/connect.php";

    if($_SERVER["REQUEST_METHOD"] == "GET"){
        class Tracking {
            //init all tracking stuff
            public $conn;
            public $appId;
            function __construct($dbconnection, $applicationId) {
                $this->conn = $dbconnection;
                $this->appId = $applicationId;
            }
    
            function getTrackingJson() {
                if($this->appId != null){
                    $trackingSql = "SELECT t.tracking_id, a.app_name, t.tracking_date, t.tracking_time, t.tracking_status FROM trackings AS t JOIN applications AS a ON t.application_id = a.application_id WHERE t.application_id = ".$this->appId;
                } else {
                    $trackingSql = "SELECT t.tracking_id, a.app_name, t.tracking_date, t.tracking_time, t.tracking_status FROM trackings AS t JOIN applications AS a ON t.application_id = a.application_id";
                }

                $res = mysqli_query($this->conn, $trackingSql);
                if(!is_bool($res)){
                    $tableArray = array();
                    $rowArray = array();
                    $resArr = mysqli_fetch_all($res);
                    $resArr = array_values($resArr);
                    foreach($resArr as $currRowColumn){
                        $columnArray = array();
                        array_push($columnArray, $currRowColumn[0]);
                        array_push($columnArray, $currRowColumn[1]);
                        array_push($columnArray, $currRowColumn[2]);
                        array_push($columnArray, $currRowColumn[3]);
                        array_push($columnArray, $currRowColumn[4]);
                        array_push($rowArray, $columnArray);
                    }
                    array_push($tableArray, $rowArray);
                    $outputArray = array(
                        "data" => $tableArray
                    );
                } else {
                    return false;
                }

                return json_encode($outputArray, JSON_PRETTY_PRINT);
            }
        }
        if(isset($_GET["app_id"])){
            $appId = $_GET["app_id"];
        } else {
            $appId = null;
        }
        $appJson = new Tracking($conn, $appId);
        if(!$appJson->getTrackingJson()){
            header('X-PHP-Response-Code: 500', true, 500);
            die();
        }
        header("Content-Type: application/json");
        echo $appJson->getTrackingJson();
        die();
    } else {
        header('X-PHP-Response-Code: 500', true, 500);
        die();
    }
?>