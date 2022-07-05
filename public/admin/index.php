<?php
    session_start();
    if (!isset($_SESSION["admin_id"])){
        $_SESSION["userErrCode"] = "ADMIN_ID_NOT_SET";
        $_SESSION["userErrMsg"] = "The session has expired or is invalid. Please login again. Do contact the administrator if you believe that this should not happen.";
        header("refresh:0;url=/login.php?error=true");
        die();
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>UiTM Club Activities Approval System - Admin</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
        <link rel="icon" type="image/x-icon" href="https://saringc19.uitm.edu.my/statics/icons/favicon.ico">
    </head>
    <body>
        <?php
            include("../../header/header.php");
        ?>
        <div class="px-5">
            <div class="row text-center">
                <h1>Admin Portal</h1>
            </div>
            <div class="row py-3">
                <h4>Welcome, <?php echo $_SESSION["name"] ?> to the admin portal</h4>
            </div>
            <div class="row">
                <h5 class="pb-4">Available actions:</h5>
                <div class="col p-2">
                    <b class="pb-2">Add new user: </b>
                    <button type="button" class="btn btn-primary" onclick="location.href='/admin/addNewUser.php';">New User</button>
                </div>
                <div class="col p-2">
                    <b class="pb-2">Add new club: </b>
                    <button type="button" class="btn btn-primary" onclick="location.href='/admin/addNewClub.php';">New Club</button>
                </div>
                <div class="col p-2">
                    <b class="pb-2">View Application: </b>
                    <button type="button" class="btn btn-primary" onclick="location.href='/admin/applicationList.php';">View Applications</button>
                </div>
            </div>
        </div>
        <?php
            include("../../header/footer.php");
        ?>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    </body>
</html>