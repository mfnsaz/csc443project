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
    $_SESSION["backPage"] = "/student/applicationList.php";
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>UiTM Club Activities Approval System - Application Form</title>

        <!-- CSS only -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
        <link rel="icon" type="image/x-icon" href="https://saringc19.uitm.edu.my/statics/icons/favicon.ico">
    </head>
    <body>
        <?php
            include("../../header/header.php");
        ?>
        <nav class="px-5 py-4" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <?php
                        $currDir = $_SERVER['PHP_SELF'];
                        $currUrl = $_SERVER['PHP_HOST'];
                        $pageTitle = "Application Form";
                        include('../../header/breadcrumb.php');
                    ?>
                </ol>
            </nav>
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
        <div class="container px-5 my-5">
            <h1 class="pb-4">New Activity Application</h1>
            <p>Please fill in the form below.</p>
            <form id="contactForm" action="./doStudentApplication.php" method="post">
                <div class="form-floating mb-3">
                    <input class="form-control" name="appName" type="text" placeholder="Application Name" required/>
                    <label for="applicationName">Application Name</label>
                </div>
                <div class="form-floating mb-3">
                    <input class="form-control" name="startDate" type="date" placeholder="Start Date" required/>
                    <label for="startDate">Start Date</label>
                </div>
                <div class="form-floating mb-3">
                    <input class="form-control" name="endDate" type="date" placeholder="End Date" required/>
                    <label for="endDate">End Date</label>
                </div>
                <div class="form-floating mb-3">
                    <input class="form-control" name="time" type="time" placeholder="Time" required/>
                    <label for="time">Time</label>
                </div>
                <div class="form-floating mb-3">
                    <input class="form-control" name="proposalUrl" type="url" placeholder="Proposal Files Link" required/>
                    <label for="proposalFilesLink">Proposal Files Link</label>
                </div>
                <div class="d-grid">
                    <button class="btn btn-primary btn-lg" id="submitButton" type="submit">Submit</button>
                </div>
            </form>
        </div>
        <?php
            include("../../header/footer.php");
        ?>
        <!-- JavaScript Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    </body>
</html>