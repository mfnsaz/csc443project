<?php
    session_start();
    if (!isset($_SESSION["student_id"]) || $_SESSION["student_id"] == ""){
        header("refresh:5;url=/login.php");
        die('<script>alert("STUDENT_ID NOT SET. INVALID SESSION.")</script>');
    }
    if (!isset($_SESSION["club_id"]) || $_SESSION["club_id"] == ""){
        header("refresh:5;url=/login.php");
        die('<script>alert("CLUB_ID NOT SET. CONTACT THE ADMINISTRATOR.")</script>');
    }
    echo "<p>Processing your sign in request...</p>";
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    require_once "../inc/connect.php";
    
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        //set post values to vars
        $appname = $_POST["appName"];
        $startDate = $_POST["startDate"];
        $endDate = $_POST["endDate"];
        $time = $_POST["time"];
        $proposalUrl = $_POST["proposalUrl"];

        //set session values to vars
        $studentId = $_SESSION["student_id"];

        //get date and time
        date_default_timezone_set("Asia/Kuala_Lumpur");
        $dateNow = date('Y-m-d');
        $timeNow = date('H:i:s');

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
                echo "SUCCESS ADD TO APPLICATIONS TABLE!<br>";
            } else {
                echo "MYSQL ERROR ADD TO USERS TABLE! PLEASE CHECK DATABASE! ".mysqli_error($conn);
                header("refresh:5;url=/student/formApplication.php");
                die('<script>alert("ERROR ADDING APPLICATIONS. Please contact the admin for further help.")</script>');
            }

            mysqli_stmt_close($stmt);
        }

        //get app_id from table
        $getUserCredsSQL = "SELECT application_id FROM applications WHERE student_id = (?)";
        if ($stmt=mysqli_prepare($conn, $getUserCredsSQL)){
            mysqli_stmt_bind_param($stmt, "s", $ap_studentid);

            $ap_studentid = $studentId;

            if(mysqli_stmt_execute($stmt)){
                $appArray = mysqli_fetch_array(mysqli_stmt_get_result($stmt));
                $appId = $appArray["application_id"];
                echo "SUCCESS QUERY USERS TABLE!\n";
            } else {
                echo "MYSQL ERROR QUERY USERS TABLE! ".mysqli_error($conn);
                header("refresh:5;url=/student/formApplication.php");
                die('<script>alert("ERROR GETTING APPID. Please contact the admin for further help.")</script>');
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
            $app_id = $appId;

            if(mysqli_stmt_execute($stmt)){
                echo "SUCCESS ADD TO APPLICATIONS TABLE!<br>";
            } else {
                echo "MYSQL ERROR ADD TO USERS TABLE! PLEASE CHECK DATABASE! ".mysqli_error($conn);
                header("refresh:5;url=/student/formApplication.php");
                die('<script>alert("ERROR ADDING TRACKING. Please contact the admin for further help.")</script>');
            }

            mysqli_stmt_close($stmt);
        }
        echo '<script>alert("Add application SUCCESS.")</script>';
        header("refresh:2;url=/student/index.php");
    } else {
        echo '<script>alert("INVALID METHOD. REDIRECTING TO STUDENT INDEX.")</script>';
        header("refresh:2;url=/student/index.php");
    }
?>