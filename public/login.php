<?php session_start() ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>UiTM Club Activities Approval System - Sign In/Sign Up</title>
        <!-- CSS only -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    </head>
    <body>
        <?php
            include("../header/header.php");
        ?>
        <div class="bg-warning p-3">
            <p class="text-center fw-bolder h5">Authenticate to access UiTM Club Activities Approval System</p>
        </div>
        <ul class="container px-4 nav nav-pills mt-4" id="pills-tab" role="tablist">
            <li class="nav-item px-2" role="presentation">
                <button class="nav-link active" id="pills-signin-tab" data-bs-toggle="pill" data-bs-target="#pills-signin" type="button" role="tab" aria-controls="pills-signin" aria-selected="true">Sign In</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-signup-tab" data-bs-toggle="pill" data-bs-target="#pills-signup" type="button" role="tab" aria-controls="pills-signup" aria-selected="false">Sign Up</button>
            </li>
        </ul>
        <div class="tab-content" id="pills-tabContent">
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
            ?>
            <div class="tab-pane fade show active" id="pills-signin" role="tabpanel" aria-labelledby="pills-signin-tab" tabindex="0">
                <div class="container px-5 my-4">
                    <h3>Sign In</h3>
                    <p>Please enter the email and password to continue.</p>
                    <form id="loginForm" action="doSignIn.php" method="post">
                        <div class="form-floating mb-3">
                            <input class="form-control" name="signInEmail" type="email" placeholder="Email Address" required/>
                            <label for="emailAddress">Email Address</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control" name="signInPassword" type="password" placeholder="Password" required/>
                            <label for="password">Password</label>
                        </div>
                        <div class="d-grid">
                            <button class="btn btn-primary btn-lg" id="signInButton" type="submit">Sign In</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="tab-pane fade" id="pills-signup" role="tabpanel" aria-labelledby="pills-signup-tab" tabindex="0">
                <div class="container px-5 my-4">
                    <h3>Sign Up (Students Only)</h3>
                    <p>This form is for students only. Officers and Admins can contact the faculty for help. Please fill in this form to continue.</p>
                    <form id="signupForm" action="doSignUp.php" method="post">
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
                        <div class="form-floating mb-3">
                            <select class="form-select" name="clubid" id="clublist" aria-label="Club" required>
                                <option value=""></option>
                                <!--Code here-->
                            </select>
                            <label for="clubid">Club</label>
                        </div>
                        <!--The code below is left as is to enable the usage of doSignUp.php as a some sort of an API to allow other
                        forms to reuse the same code. (cant leave the role POST as null)-->
                        <div class="form-floating mb-3" hidden>
                            <select class="form-select" name="role" aria-label="Role">
                                <option value="0">Student</option>
                                <option value="1">Admin</option>
                                <option value="2">Officer</option>
                            </select>
                            <label for="role">Role</label>
                        </div>
                        <div class="d-grid">
                            <button class="btn btn-primary btn-lg" id="signUpButton" type="submit">Sign Up</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
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
        </script>
    </body>
</html>