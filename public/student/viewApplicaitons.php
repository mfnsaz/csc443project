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
?>

<!DOCTYPE html>
<html>
    <head>
        <title>UiTM Club Activities Approval System</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    </head>
    <body>
        <div class="container">
            <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
                <a href="/" class="d-flex align-items-center col-md-3 mb-2 mb-md-0 text-dark text-decoration-none">
                    <!--svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"></use></svg-->
                    <img src="https://korporat.uitm.edu.my/images/download/2019/LogoUiTM.png" class="" height="50px" alt="alzhahir Logo">
                    <p class="h6 ps-3">Club Activities Approval System</p>
                </a>

                <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
                    <li><a href="/" class="nav-link px-2 link-secondary">Home</a></li>
                    <li><a href="/login.php" class="nav-link px-2 link-dark">Login</a></li>
                    <li><a href="/contact.html" class="nav-link px-2 link-dark">Contact</a></li>
                    <li><a href="/faq.html" class="nav-link px-2 link-dark">FAQs</a></li>
                    <li><a href="/about.html" class="nav-link px-2 link-dark">About</a></li>
                </ul>

                <div class="col-md-3 text-end">
                    <button type="button" class="btn btn-primary" onclick="location.href='/doSignOut.php';">Logout</button>
                </div>
            </header>
        </div>
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
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    </body>
</html>