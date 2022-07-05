<?php
    session_start();
    if (!isset($_SESSION["student_id"])){
        $_SESSION["userErrCode"] = "STUDENT_ID_NOT_SET";
        $_SESSION["userErrMsg"] = "The session has expired or is invalid. Please login again. Do contact the administrator if you believe that this should not happen.";
        header("refresh:0;url=/login.php?error=true");
        die();
    }
    if (!isset($_GET["app_id"])){
        $_SESSION["userErrCode"] = "APP_ID_NOT_SET";
        $_SESSION["userErrMsg"] = "Required parameter APP_ID is not received. Please contact the administrator if you believe that this should not happen.";
        header("refresh:0;url=/student/applicationList.php?error=true");
        die();
    }
    $appId = $_GET["app_id"];
    $_SESSION["backPage"] = "applicationList.php";
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>UiTM Club Activities Approval System - Application List</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.bootstrap.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/fixedheader/3.2.4/css/fixedHeader.bootstrap.css">
        <link rel="icon" type="image/x-icon" href="https://saringc19.uitm.edu.my/statics/icons/favicon.ico">
    </head>
    <body>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/fixedheader/3.2.4/js/fixedHeader.bootstrap.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/responsive/2.3.0/js/responsive.bootstrap.min.js"></script>
        <script type="text/javascript">
            const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
            const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
            $(document).ready( function () {
                var mainTable = $('#appTable').DataTable({
                                    ajax: {
                                        url: '/api/getTrackingList.php?app_id=<?php echo $appId ?>',
                                        responsive: true,
                                        dataSrc: 'data'
                                    },
                                    fixedHeader: true
                                });
            });
        </script>
        <?php
            include("../../header/header.php");
        ?>
        <nav class="px-5 py-4" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <?php
                    $currDir = "/student/applicationList.php/viewTracking.php";
                    $currUrl = $_SERVER['PHP_HOST'];
                    $pageTitle = "View Tracking";
                    include('../../header/breadcrumb.php');
                ?>
            </ol>
        </nav>
        <div class="px-5">
            <h4>View Tracking</h4>
        </div>
        <br>
        <?php
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
        ?>
        <div class="px-5">
            <table id="appTable" class="table table-bordered table-hover dt-responsive">
                <thead>
                    <tr>
                        <th>Tracking ID</th>
                        <th>Application Name</th>
                        <th>Tracking Date</th>
                        <th>Tracking Time</th>
                        <th>Tracking Status</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Tracking ID</th>
                        <th>Application Name</th>
                        <th>Tracking Date</th>
                        <th>Tracking Time</th>
                        <th>Tracking Status</th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <?php
            include("../../header/footer.php");
        ?>
    </body>
</html>