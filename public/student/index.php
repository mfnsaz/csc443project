<?php
    session_start();
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
                    <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"></use></svg>
                    <img src="https://api.alzhahir.com/static/images/logos/alzhahir/alz-logo-shadow-outline.png" class="img-fluid px-5" alt="alzhahir Logo">
                </a>

                <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
                    <li><a href="#" class="nav-link px-2 link-secondary">Home</a></li>
                    <li><a href="#" class="nav-link px-2 link-dark">Features</a></li>
                    <li><a href="#" class="nav-link px-2 link-dark">Pricing</a></li>
                    <li><a href="#" class="nav-link px-2 link-dark">FAQs</a></li>
                    <li><a href="#" class="nav-link px-2 link-dark">About</a></li>
                </ul>

                <div class="col-md-3 text-end">
                    <button type="button" class="btn btn-primary" onclick="location.href='/doSignOut.php';">Logout</button>
                </div>
            </header>
        </div>
        <?php
            if (isset($_SESSION["student_id"]) || $_SESSION["student_id"] == ""){
                header("refresh:5;url=login.html");
                die('<script>alert("STUDENT_ID NOT SET. INVALID SESSION.")</script>');
            }
        ?>
        <div class="px-5 text-center">
            <h1>Welcome, <?php echo $_SESSION["name"] ?> to the student portal</h1>
        </div>
        <div class="px-5">
            <h1>Available actions:</h1>
            <?php
                require_once "../inc/connect.php";

                $studentId = $_SESSION["student_id"];

                //check if clubid exists
                $clubidsql = "SELECT club_id FROM students WHERE student_id = (?)" ;
                if ($stmt=mysqli_prepare($conn, $emailsql)){
                    mysqli_stmt_bind_param($stmt, "i", $student_id);

                    $student_id = $studentId;

                    if(mysqli_stmt_execute($stmt)){
                        $clubIdArray = mysqli_fetch_array(mysqli_stmt_get_result($stmt));
                        $clubId= $clubIdArray["count(user_email)"];
                        if($clubId == NULL){
                            header("refresh:5;url=/login.html");
                            die( '<script>alert("clubid does not exist! please contact administrator!")</script>');
                        }//end if
                        echo "<button type=\"button\" class=\"btn btn-primary\" onclick=\"location.href='/student/formApplication.html';\">New Activity Application</button>";
                    } else {
                        echo "MYSQL ERROR QUERY USERS TABLE! ".mysqli_error($conn);
                        header("refresh:5;url=/login.html");
                        die('<script>alert("ERROR. Please contact the admin for further help.")</script>');
                    }

                    mysqli_stmt_close($stmt);
                }
            ?>
        </div>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    </body>
</html>