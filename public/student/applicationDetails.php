<?php
    session_start();
    if (!isset($_SESSION["student_id"])){
        header("refresh:0;url=/login.php");
        die('<script>alert("OFFICER_ID NOT SET. INVALID SESSION.")</script>');
    }
    if (!isset($_GET["app_id"])){
        header("refresh:0;url=/officer/index.php");
        die('<script>alert("APP_ID NOT SET. INVALID SESSION.")</script>');
    }
    $_SESSION["backPage"] = basename($_SERVER['PHP_SELF']);
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
        <!--Nanti kena automatically tarik from database untuk application name, club name, date, time and proposal-->
        <div class="container px-5 my-5">
            <h1 class="pb-4">Edit Application</h1>
            <?php
                error_reporting(E_ALL);
                ini_set('display_errors', 1);
                require_once "../inc/connect.php";

                $appId = $_GET["app_id"];
                $_SESSION["app_id"] = $appId;

                $thisApp = array();

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
                        for($i = 0; $i < sizeof($currApp); $i++){
                            array_push($thisApp, $currApp[$i]);
                        }
                    }
                } else {
                    echo "what";
                    header('X-PHP-Response-Code: 500', true, 500);
                    die();
                }
            ?>
            <form id="updateForm" action="./doUpdateApplication.php" method="post">
                <div class="form-floating mb-3">
                    <input class="form-control" name="appName" type="text" value="<?php echo $thisApp[0] ?>" placeholder="Application Name" required/>
                    <label for="applicationName">Application Name</label>
                </div>
                <div class="form-floating mb-3">
                    <input class="form-control" name="startDate" type="date" value="<?php echo $thisApp[1] ?>"  placeholder="Start Date" required/>
                    <label for="startDate">Start Date</label>
                </div>
                <div class="form-floating mb-3">
                    <input class="form-control" name="endDate" type="date" value="<?php echo $thisApp[2] ?>"  placeholder="End Date" required/>
                    <label for="endDate">End Date</label>
                </div>
                <div class="form-floating mb-3">
                    <input class="form-control" name="time" type="time" value="<?php echo $thisApp[3] ?>"  placeholder="Time" required/>
                    <label for="time">Time</label>
                </div>
                <div class="form-floating mb-3">
                    <input class="form-control" name="proposalUrl" type="url" value="<?php echo $thisApp[4] ?>"  placeholder="Proposal Files Link" required/>
                    <label for="proposalFilesLink">Proposal Files Link</label>
                </div>
                <div class="d-grid">
                    <button class="btn btn-primary btn-lg" id="submitButton" type="submit" disabled>Submit</button>
                </div>
            </form>
        </div>
        <?php
            include("../../header/footer.php");
        ?>
        <script type="text/javascript">
            $(document).ready(function() {
                $('#updateForm').on('input change', function() {
                    $('#submitButton').attr('disabled', false);
                });
            })
        </script>
    </body>
</html>