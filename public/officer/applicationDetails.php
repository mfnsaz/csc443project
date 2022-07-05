<?php
    session_start();
    if (!isset($_SESSION["officer_id"])){
        $_SESSION["userErrCode"] = "OFFICER_ID_NOT_SET";
        $_SESSION["userErrMsg"] = "The session has expired or is invalid. Please login again. Do contact the administrator if you believe that this should not happen.";
        header("refresh:0;url=/login.php?error=true");
        die();
    }
    if (!isset($_GET["app_id"])){
        $_SESSION["userErrCode"] = "APP_ID_NOT_SET";
        $_SESSION["userErrMsg"] = "Required parameter APP_ID is not received. Please contact the administrator if you believe that this should not happen.";
        header("refresh:0;url=/officer/applicationList.php?error=true");
        die();
    }
    $_SESSION["backPage"] = "applicationList.php";
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>UiTM Club Activities Approval System - Application Details</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
        <link rel="icon" type="image/x-icon" href="https://saringc19.uitm.edu.my/statics/icons/favicon.ico">
    </head>
    <body>
        <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
        <?php
            include("../../header/header.php");
        ?>
        <nav class="px-5 py-4" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <?php
                    $currDir = "/officer/applicationList.php/applicationDetails.php";
                    $currUrl = $_SERVER['PHP_HOST'];
                    $pageTitle = "Application Details";
                    include('../../header/breadcrumb.php');
                ?>
            </ol>
        </nav>
        <div class="container px-5">
            <h1 class="pb-4">Club Application Details</h1>
            <?php
                error_reporting(E_ALL);
                ini_set('display_errors', 1);
                require_once "../inc/connect.php";

                $appId = $_GET["app_id"];
                $_SESSION["app_id"] = $appId;

                //check if $_GET isset
                if(isset($_GET["error"])){
                    //error exists
                    echo "<div class=\"alert alert-danger my-4\" style=\"margin-left: 13%; margin-right: 13%;\">";
                    if(isset($_SESSION["userErrMsg"])){
                        //get err msg
                        $errMsg = $_SESSION["userErrMsg"];
                        $errCode = $_SESSION["userErrCode"];
                        echo "<h5 style=\"text-align: justify; text-justify: inter-word;\">$errMsg</h5>";
                        echo "<br><p>Error code: $errCode</p>";
                    }
                    echo "</div>";
                }
                if(isset($_GET["signup"])){
                    echo "<div class=\"alert alert-success my-4\" style=\"margin-left: 13%; margin-right: 13%;\">";
                    if(isset($_SESSION["userErrMsg"])){
                        //get err msg
                        $errMsg = $_SESSION["userErrMsg"];
                        $errCode = $_SESSION["userErrCode"];
                        echo "<h5 style=\"text-align: justify; text-justify: inter-word;\">$errMsg</h5>";
                    }
                    echo "</div>";
                }

                //get applist
                $getAppSQL = "SELECT app_name, app_startDate, app_endDate, app_time, app_files_link FROM applications WHERE application_id = $appId";
                $appRes = mysqli_query($conn, $getAppSQL);
                if(!is_bool($appRes)){
                    $appArr = mysqli_fetch_all($appRes);
                    //$appArr = array_values($appArr);
                    foreach($appArr as $currApp){
                        echo "<div class=\"\">";
                        echo "<p><b>Application Name: </b>".$currApp[0]."</p>";
                        echo "<p><b>Application Start Date: </b>".$currApp[1]."</p>";
                        echo "<p><b>Application End Date: </b>".$currApp[2]."</p>";
                        echo "<p><b>Application Time: </b>".$currApp[3]."</p>";
                        echo "<p><b>Application Proposal Files URL: </b><a href=\"".$currApp[4]."\">".$currApp[4]."</a></p>";
                        echo "</div>";
                    }
                } else {
                    echo "what";
                    header('X-PHP-Response-Code: 500', true, 500);
                    die();
                }
            ?>
            <form id="contactForm" action="doUpdateApplication.php" method="post">
                <div class="form-floating mb-3">
                    <select class="form-select" name="appApproval" id="status" aria-label="appStat" required>
                        <option value=""></option>
                        <option value="1">Approve Application</option>
                        <option value="0">Reject Application</option>
                    </select>
                    <label for="appStatus">Status</label>
                </div>
                <div class="form-floating mb-3">
                    <input class="form-control" name="remarks" type="comment" placeholder="remarks" required/>
                    <label for="remarks">Remarks</label>
                </div>
                <div class="d-grid">
                    <button class="btn btn-primary btn-lg" id="submitButton" type="submit">Submit</button>
                </div>
            </form>
        </div>
        <?php
            include("../../header/footer.php");
        ?>
    </body>
</html>