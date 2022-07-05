<?php
    session_start();
    if (!isset($_SESSION["admin_id"])){
        $_SESSION["userErrCode"] = "ADMIN_ID_NOT_SET";
        $_SESSION["userErrMsg"] = "The session has expired or is invalid. Please login again. Do contact the administrator if you believe that this should not happen.";
        header("refresh:0;url=/login.php?error=true");
        die();
    }
    $_SESSION["backPage"] = basename(__DIR__).'/'.basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>UiTM Club Activities Approval System - Create New User</title>
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
                    $pageTitle = "Add New User";
                    include('../../header/breadcrumb.php');
                ?>
            </ol>
        </nav>
        <?php 
            //check if $_GET isset
            if(isset($_GET["error"])){
                //error exists
                echo "<div class=\"alert alert-danger my-4\" style=\"margin-left: 150px; margin-right: 150px;\">";
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
                echo "<div class=\"alert alert-success my-4\" style=\"margin-left: 150px; margin-right: 150px;\">";
                if(isset($_SESSION["userErrMsg"])){
                    //get err msg
                    $errMsg = $_SESSION["userErrMsg"];
                    $errCode = $_SESSION["userErrCode"];
                    echo "<h5 style=\"text-align: justify; text-justify: inter-word;\">$errMsg</h5>";
                }
                echo "</div>";
            }
        ?>
        <div class="container px-5 my-4">
            <h1 class="pb-4">New User</h1>
            <p>Please fill in this form to continue.</p>
            <form id="signupForm" action="../doSignUp.php" method="post">
                <div class="form-floating mb-3">
                    <input class="form-control" name="email" type="email" placeholder="Email Address" required/>
                    <label for="emailAddress">Email Address</label>
                </div>
                <div class="form-floating mb-3">
                    <input class="form-control" name="password" type="password" placeholder="Password" required/>
                    <label for="password">Password</label>
                </div>
                <div class="form-floating mb-3">
                    <input class="form-control" name="confirmPassword" type="password" placeholder="Confirm Password" required/>
                    <label for="password">Confirm Password</label>
                </div>
                <div class="form-floating mb-3">
                    <input class="form-control" name="name" type="text" placeholder="Name" required/>
                    <label for="name">Name</label>
                </div>
                <div class="form-floating mb-3">
                    <input class="form-control number" name="telephone" type="text" placeholder="Telephone" onkeydown='{(evt) => ["e", "E", "-"].includes(evt.key) && evt.preventDefault()}' required/>
                    <label for="telephone">Telephone</label>
                </div>
                <!--The code below is left as is to enable the usage of doSignUp.php as a some sort of an API to allow other
                forms to reuse the same code. (cant leave the role POST as null)-->
                <div class="form-floating mb-3">
                    <select class="form-select" name="role" id="userRole" aria-label="Role" required>
                        <option value=""></option>
                        <option value="0">Student</option>
                        <option value="1">Admin</option>
                        <option value="2">Officer</option>
                    </select>
                    <label for="role">Role</label>
                </div>
                <div class="form-floating mb-3" id="clubField" style="display: none;">
                    <select class="form-select" name="clubid" id="clublist" aria-label="Club" required>
                        <option value=""></option>
                        <!--Code here-->
                    </select>
                    <label for="clubid">Club</label>
                </div>
                <div class="d-grid">
                    <button class="btn btn-primary btn-lg" id="signUpButton" type="submit">Sign Up</button>
                </div>
            </form>
        </div>
        <?php
            include("../../header/footer.php");
        ?>
        <style>
            /* Chrome, Safari, Edge, Opera */
            input::-webkit-outer-spin-button,
            input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
            }

            /* Firefox */
            input[type=number] {
            -moz-appearance: textfield;
            }
        </style>
        <!-- JavaScript Bundle with Popper -->
        <script type="application/javascript" src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script type="application/javascript" src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script type="application/javascript" src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
        <script type="application/javascript">
            var xmlhttp = new XMLHttpRequest();
            var url = "/clubs/getClubId.php";
            document.querySelector(".number").addEventListener("keypress", function (evt) {
                if (evt.which != 8 && evt.which != 0 && evt.which < 48 || evt.which > 57)
                {
                    evt.preventDefault();
                }
            });

            xmlhttp.onreadystatechange = function(){
                if (this.readyState == 4 && this.status == 200) {
                    var data = JSON.parse(this.responseText);
                    var htmlData = "<option value=\"\"></option>";
                    for(let i = 0; i < data.clubId.length; i++){
                        htmlData = htmlData.concat("\n", "<option value=\""+data.clubId[i]+"\">"+data.clubName[i]+"</option>\n");
                    }
                    document.getElementById("clublist").innerHTML = htmlData;
                }
            }
            xmlhttp.open("GET", url, true);
            xmlhttp.send();

            var roleSelection = document.getElementById('userRole');
            roleSelection.onchange = function(){
                if(roleSelection.selectedIndex === 1) {
                    document.getElementById('clubField').style.display = "block";
                    document.getElementById('clublist').required = true;
                } else {
                    document.getElementById('clubField').style.display = "none";
                    document.getElementById('clublist').required = false;
                }
            }
        </script>
    </body>
</html>