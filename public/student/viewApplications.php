<?php
    session_start();
    if (!isset($_SESSION["student_id"]) || $_SESSION["student_id"] == ""){
        $_SESSION["userErrCode"] = "STUDENT_ID_NOT_SET";
        $_SESSION["userErrMsg"] = "The session has expired or is invalid. Please login again. Do contact the administrator if you believe that this should not happen.";
        header("refresh:0;url=/login.php?error=true");
        die();
    }
    if (!isset($_SESSION["club_id"]) || $_SESSION["club_id"] == ""){
        $_SESSION["userErrCode"] = "CLUB_ID_NOT_SET";
        $_SESSION["userErrMsg"] = "The session has expired or is invalid. Please login again. Do contact the administrator if you believe that this should not happen.";
        header("refresh:0;url=/login.php?error=true");
        die();
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>UiTM Club Activities Approval System - View Applications</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
        <link rel="icon" type="image/x-icon" href="https://saringc19.uitm.edu.my/statics/icons/favicon.ico">
    </head>
    <body>
        <?php
            include("../../header/header.php");
        ?>
        <div class="px-5 text-center">
            <h3>View Activities Applications</h3>
        </div>
        <div class="px-5">
            <?php
                require_once "../inc/connect.php";

                $studentId = $_SESSION["student_id"];

                //get trackinglist
                $getAppSQL = "SELECT application_id FROM applications WHERE student_id = (?)";
                if ($stmt=mysqli_prepare($conn, $getAppSQL)){
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
                } else {
                    echo "ERROR";
                }

                if(is_array($appId)){
                    //appid is array
                    foreach($appId as $currAppId){
                        //for each appid
                    }
                }
            ?>
        </div>
        <?php
            include("../../header/footer.php");
        ?>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    </body>
</html>