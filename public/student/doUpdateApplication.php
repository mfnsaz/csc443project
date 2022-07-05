<?php
    //STATUS GOES TO APPLICATIONS
    //REMARKS GOES TO TRACKING (COMBINE WITH STATUS AS WELL AS OFFICER IF APPLICABLE)
    //OFFICER GOES TO APPLICATIONS
    session_start();
    //echo $_SESSION["app_id"];
    if (!isset($_SESSION["student_id"])){
        $_SESSION["userErrCode"] = "STUDENT_ID_NOT_SET";
        $_SESSION["userErrMsg"] = "The session has expired or is invalid. Please login again. Do contact the administrator if you believe that this should not happen.";
        header("refresh:0;url=/login.php?error=true");
        die();
    }
    if (!isset($_SESSION["app_id"])){
        $_SESSION["userErrCode"] = "APP_ID_NOT_SET";
        $_SESSION["userErrMsg"] = "Required parameter APP_ID is not available. Please contact the administrator if you believe that this should not happen.";
        header("refresh:0;url=/student/applicationList.php?error=true");
        die();
    }

    $backPage = $_SESSION["backPage"];

    if(!isset($_SESSION["backPage"])){
        //backPage is not set, defaulting to applicationDetails.php
        $backPage = "applicationDetails.php";
    }

    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    // Include config file
    require_once "../inc/connect.php";

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        //get date and time
        date_default_timezone_set("Asia/Kuala_Lumpur");
        $dateNow = date('Y-m-d');
        $timeNow = date('H:i:s');

        //assign stuff to vars
        $appId = $_SESSION["app_id"];
        $appName = $_POST["appName"];
        $startDate = $_POST["startDate"];
        $endDate = $_POST["endDate"];
        $propUrl = $_POST["proposalUrl"];
        $adminId = $_SESSION["admin_id"];

        $updateApplicationsSQL = "UPDATE applications SET app_name = $appName, app_startDate = $startDate, app_endDate = $endDate, app_files_link = $propUrl WHERE application_id = $appId";
        $trackingSystemComment = "Application was updated by student.";

        //mysql code here
        //$updateApplicationsSQL = "UPDATE applications SET officer_id = $officerId, admin_id = $adminId, forwarded = $appStatus WHERE application_id = $appId";
        $appRes = mysqli_query($conn, $updateApplicationsSQL);
        if(is_bool($appRes)){
            if($appRes){
                //success update
            } else {
                $_SESSION["userErrCode"] = "MYSQL_ERROR";
                $_SESSION["userErrMsg"] = "MySQL error encountered: ".mysqli_error($conn).". Please contact the administrator if you believe that this should not happen.";
                header("refresh:0;url=$backPage?error=true");
                die();
            }
        } else {
            $_SESSION["userErrCode"] = "MYSQL_ERROR";
            $_SESSION["userErrMsg"] = "MySQL error encountered: ".mysqli_error($conn)." Please contact the administrator if you believe that this should not happen.";
            header("refresh:0;url=$backPage?error=true");
            die();
        }

        $addTrackingSQL = "INSERT INTO trackings (tracking_status, tracking_date, tracking_time, application_id) VALUES (?, ?, ?, ?)";
        if ($stmt=mysqli_prepare($conn, $addTrackingSQL)){
            mysqli_stmt_bind_param($stmt, "sssi", $tr_stat, $tr_date, $tr_time, $app_id);

            $tr_stat = $trackingSystemComment;
            $tr_date = $dateNow;
            $tr_time = $timeNow;
            $app_id = $appId;

            if(mysqli_stmt_execute($stmt)){
                //echo "SUCCESS ADD TO tracking TABLE!<br>";
            } else {
                $_SESSION["userErrCode"] = "MYSQL_ERROR";
                $_SESSION["userErrMsg"] = "MySQL error encountered: ".mysqli_error($conn)." Please contact the administrator if you believe that this should not happen.";
                header("refresh:0;url=$backPage?error=true");
                die();
            }

            mysqli_stmt_close($stmt);
        }
        $_SESSION["userErrCode"] = "UPDATE_APPLICATION_SUCCESS";
        $_SESSION["userErrMsg"] = "Application updated. Please wait for the officer to approve or reject the application.";
        header("refresh:0;url=$backPage?signup=success");
    }
?>