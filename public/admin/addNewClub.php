<?php
    session_start();
    if (!isset($_SESSION["admin_id"]) || $_SESSION["admin_id"] == ""){
        $_SESSION["userErrCode"] = "ADMIN_ID_NOT_SET";
        $_SESSION["userErrMsg"] = "The session has expired or is invalid. Please login again. Do contact the administrator if you believe that this should not happen.";
        header("refresh:0;url=/login.php?error=true");
        die();
    }
    $_SESSION["backPage"] = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>UiTM Club Activities Approval System - Add New Club</title>

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
                        $pageTitle = "Add New Club";
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
            <h1 class="pb-4">Add New Club</h1>
            <p>Please fill in the form below.</p>
            <form id="contactForm" action="./doAddClub.php" method="post">
                <div class="form-floating mb-3">
                    <input class="form-control" name="clubName" type="text" placeholder="Application Name" required/>
                    <label for="applicationName">Club Name</label>
                </div>
                <div class="form-floating mb-3">
                    <select class="form-select" name="clubType" aria-label="clubtype" required>
                        <option value=""></option>
                        <option value="Communication">Communication</option>
                        <option value="Uniform">Uniform</option>
                        <option value="Leadership">Leadership</option>
                        <option value="Recreational">Recreational</option>
                        <option value="Faculty">Faculty</option>
                        <option value="Innovation">Innovation</option>
                        <option value="Social Service">Social Service</option>
                    </select>
                    <label for="clubType">Club Type</label>
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