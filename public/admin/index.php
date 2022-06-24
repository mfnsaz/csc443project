<?php
    session_start();
    if (!isset($_SESSION["admin_id"])){
        header("refresh:0;url=/login.php");
        die('<script>alert("ADMIN_ID NOT SET. INVALID SESSION.")</script>');
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>UiTM Club Activities Approval System</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    </head>
    <body>
        <?php
            include("../../header/header.php");
        ?>
        <div class="px-5 text-center">
            <h1>Welcome, <?php echo $_SESSION["name"] ?> to the admin panel</h1>
        </div>
        <div class="px-5">
            <h4 class="py-4">Available actions:</h4>
            <button type="button" class="btn btn-primary" onclick="location.href='/admin/addNewUser.php';">New User</button>
            <button type="button" class="btn btn-primary" onclick="location.href='/admin/applicationList.php';">View Applications</button>
        </div>
        <?php
            include("../header/footer.php");
        ?>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    </body>
</html>