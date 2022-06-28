<?php
    session_start();
    if (!isset($_SESSION["student_id"]) || $_SESSION["student_id"] == ""){
        header("refresh:0;url=/login.php");
        die('<script>alert("STUDENT_ID NOT SET. INVALID SESSION.")</script>');
    }
    if (!isset($_SESSION["club_id"]) || $_SESSION["club_id"] == ""){
        header("refresh:0;url=/login.php");
        die('<script>alert("CLUB_ID NOT SET. CONTACT THE ADMINISTRATOR.")</script>');
    }
    //echo "<p>Processing your sign in request...</p>";
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    require_once "../inc/connect.php";

    $backPage = $_SESSION["backPage"];

    if(!isset($_SESSION["backPage"])){
        //backPage is not set, defaulting to index.php
        $backPage = "index.php";
    }
    
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        //set post values to vars
        $appname = $_POST["appName"];
        $startDate = $_POST["startDate"];
        $endDate = $_POST["endDate"];
        $time = $_POST["time"];
        $proposalUrl = $_POST["proposalUrl"];
        $appId = null;

        //set session values to vars
        $studentId = $_SESSION["student_id"];

        //get date and time
        date_default_timezone_set("Asia/Kuala_Lumpur");
        $dateNow = date('Y-m-d');
        $timeNow = date('H:i:s');

        //get next id
        $getIdSQL = "SELECT `AUTO_INCREMENT`FROM  INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '$database' AND TABLE_NAME = 'applications'";
        $getIdRes = mysqli_fetch_array(mysqli_query($conn, $getIdSQL));
        if(is_array($getIdRes)){
            $nextId = $getIdRes[0];
            if(!is_numeric($nextId)){
                $_SESSION["userErrCode"] = "NOT_A_NUMBER";
                $_SESSION["userErrMsg"] = "Auto Increment value not a number. Please contact the administrator for more details. Value received: ".print_r($nextId, true);
                header("refresh:0;url=$backPage?error=true");
                die();
            }
        } else {
            $_SESSION["userErrCode"] = "MYSQL_ERROR";
            $_SESSION["userErrMsg"] = "MySQL error encountered: ".mysqli_error($conn)." Please contact the administrator if you believe that this should not happen.";
            header("refresh:0;url=$backPage?error=true");
            die();
        }

        //add into applications table
        $addApplicationSQL = "INSERT INTO applications (app_name, app_startDate, app_endDate, app_time, app_files_link, student_id) VALUES (?, ?, ?, ?, ?, ?)";
        if ($stmt=mysqli_prepare($conn, $addApplicationSQL)){
            mysqli_stmt_bind_param($stmt, "sssssi", $db_appname, $db_startdate, $db_enddate, $db_time, $db_filesurl, $db_studentid);

            $db_appname = $appname;
            $db_startdate = $startDate;
            $db_enddate = $endDate;
            $db_time = $time;
            $db_filesurl = $proposalUrl;
            $db_studentid = $studentId;

            if(mysqli_stmt_execute($stmt)){
                //echo "SUCCESS ADD TO APPLICATIONS TABLE!<br>";
            } else {
                $_SESSION["userErrCode"] = "MYSQL_ERROR";
                $_SESSION["userErrMsg"] = "MySQL error encountered: ".mysqli_error($conn)." Please contact the administrator if you believe that this should not happen.";
                header("refresh:0;url=$backPage?error=true");
                die();
            }

            mysqli_stmt_close($stmt);
        }

        //get app_id from table
        $getUserCredsSQL = "SELECT application_id FROM applications WHERE student_id = (?) AND app_startDate = (?) AND app_endDate = (?) AND app_time = (?)";
        if ($stmt=mysqli_prepare($conn, $getUserCredsSQL)){
            mysqli_stmt_bind_param($stmt, "isss", $app_studId, $app_startdate, $app_endDate, $app_time);

            $app_stuId = $studentId;
            $app_startdate = $startDate;
            $app_enddate = $endDate;
            $app_time = $time;

            if(mysqli_stmt_execute($stmt)){
                $appArray = mysqli_fetch_array(mysqli_stmt_get_result($stmt));
                $appId = $appArray["application_id"];
                //echo "SUCCESS QUERY USERS TABLE!\n";
            } else {
                $_SESSION["userErrCode"] = "MYSQL_ERROR";
                $_SESSION["userErrMsg"] = "MySQL error encountered: ".mysqli_error($conn)." Please contact the administrator if you believe that this should not happen.";
                header("refresh:0;url=$backPage?error=true");
                die();
            }

            mysqli_stmt_close($stmt);
        }

        //add into trackings table
        $addTrackingSQL = "INSERT INTO trackings (tracking_status, tracking_date, tracking_time, application_id) VALUES (?, ?, ?, ?)";
        if ($stmt=mysqli_prepare($conn, $addTrackingSQL)){
            mysqli_stmt_bind_param($stmt, "sssi", $tr_stat, $tr_date, $tr_time, $app_id);

            $tr_stat = "Application received by System";
            $tr_date = $dateNow;
            $tr_time = $timeNow;
            $app_id = $nextId;

            if(mysqli_stmt_execute($stmt)){
                //echo "SUCCESS ADD TO APPLICATIONS TABLE!<br>";
            } else {
                $_SESSION["userErrCode"] = "MYSQL_ERROR";
                $_SESSION["userErrMsg"] = "MySQL error encountered: ".mysqli_error($conn)." Please contact the administrator if you believe that this should not happen.";
                header("refresh:0;url=$backPage?error=true");
                die();
            }

            mysqli_stmt_close($stmt);
        }
        $_SESSION["userErrCode"] = "ADD_APPLICATION_SUCCESS";
        $_SESSION["userErrMsg"] = "Application submitted. Please wait for the officer to approve or reject the application.";
        header("refresh:0;url=$backPage?signup=success");
    } else {
        echo '<script>alert("INVALID METHOD. REDIRECTING TO STUDENT INDEX.")</script>';
        header("refresh:2;url=/student/index.php");
    }
?>