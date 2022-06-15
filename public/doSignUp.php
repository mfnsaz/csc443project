<!DOCTYPE html>
<html>
    <head>
        <title>Processing request...</title>
    </head>
    <body>
        <h1>Authenticating...</h1>
        <?php
            echo "<p>Processing your sign up request...</p>";
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
            // Include config file
            require_once "inc/connect.php";

            // Define variables and initialize with empty values
            //$username = $password = $confirm_password = "";
            //$username_err = $password_err = $confirm_password_err = "";
        
            // Processing form data when form is submitted
            if($_SERVER["REQUEST_METHOD"] == "POST"){
                echo "<p>Please wait for a few seconds.</p>";
                $email = $_POST["email"];
                if(empty(trim($_POST["email"]))){
                    $email_err = "Please enter an email.";
                    die($email_err);
                }
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $emailErr = "Invalid email format";
                    die($emailErr);
                }

                // Validate password
                if(empty(trim($_POST["password"]))){
                    $password_err = "Please enter a password.";
                    die($password_err);
                } elseif(strlen(trim($_POST["password"])) < 8){
                    $password_err = "ERROR: Password must have atleast 8 characters. Redirecting back to the signup page.";
                    header("refresh:5;url=login.html");
                    die($password_err);
                } else{
                    $password = trim($_POST["password"]);
                }

                // Validate confirm password
                if(empty(trim($_POST["confirmPassword"]))){
                    $confirm_password_err = "Please confirm password.";
                    die($confirm_password_err);
                } else{
                    $confirm_password = trim($_POST["confirmPassword"]);
                    if(empty($password_err) && ($password != $confirm_password)){
                        $confirm_password_err = "ERROR: Password did not match. Redirecting back to the signup page.";
                        header("refresh:5;url=login.html");
                        die($confirm_password_err);
                    }
                }

                $password = password_hash($password, PASSWORD_DEFAULT);
                $name = $_POST["name"];
                $tel = $_POST["telephone"];
                $role = $_POST["role"];

                if ($role < 0 || $role > 2){
                    header("refresh:5;url=login.html");
                    die("ERROR: Invalid role. Redirecting back to the signup page.");
                }

                //MYSQL STATEMENTS BELOW

                //prepare mysql statements for user
                $signUpSQL = "INSERT INTO users (user_email, user_pass, user_type) VALUES (?, ?, ?)";
                if ($stmt=mysqli_prepare($conn, $signUpSQL)){
                    mysqli_stmt_bind_param($stmt, "ssi", $db_email, $db_password, $db_type);

                    $db_email = $email;
                    $db_password = $password;
                    $db_type = $role;

                    if(mysqli_stmt_execute($stmt)){
                        echo "SUCCESS ADD TO USERS TABLE!";
                    } else {
                        echo "MYSQL ERROR ADD TO USERS TABLE! PLEASE CHECK DATABASE! ".mysqli_error($conn);
                    }

                    mysqli_stmt_close($stmt);
                }

                //get userid
                $getUserIDSQL = "SELECT user_id FROM users WHERE user_email = (?)";
                if ($stmt=mysqli_prepare($conn, $getUserIDSQL)){
                    mysqli_stmt_bind_param($stmt, "s", $user_email);

                    $user_email = $email;

                    if(mysqli_stmt_execute($stmt)){
                        $usersArray = mysqli_fetch_array(mysqli_stmt_get_result($stmt));
                        $userId = $usersArray["user_id"];
                        echo "SUCCESS QUERY USERS TABLE!";
                    } else {
                        echo "MYSQL ERROR QUERY USERS TABLE! ".mysqli_error($conn);
                    }

                    mysqli_stmt_close($stmt);
                }

                //prepare mysql statements for role-specific stuff
                if ($role == 0){
                    //students
                    $studentSignUpSQL = "INSERT INTO students (student_name, student_telno, user_id) VALUES (?, ?, ?)";
                    if ($stmt=mysqli_prepare($conn, $studentSignUpSQL)){
                        mysqli_stmt_bind_param($stmt, "ssi", $stu_name, $stu_telno, $u_id);

                        $stu_name = $name;
                        $stu_telno = $tel;
                        $u_id = $userId;

                        if(mysqli_stmt_execute($stmt)){
                            echo "SUCCESS ADD TO STUDENTS TABLE!";
                        } else {
                            echo "MYSQL ERROR ADD TO STUDENTS TABLE! PLEASE CHECK DATABASE! ".mysqli_error($conn);
                        }

                        mysqli_stmt_close($stmt);
                    }
                } else if ($role == 1){
                    //admin
                    $adminSignUpSQL = "INSERT INTO students (admin_name, admin_telno, user_id) VALUES (?, ?, ?)";
                    if ($stmt=mysqli_prepare($conn, $adminSignUpSQL)){
                        mysqli_stmt_bind_param($stmt, "ssi", $adm_name, $adm_telno, $u_id);

                        $adm_name = $name;
                        $adm_telno = $tel;
                        $u_id = $userId;

                        if(mysqli_stmt_execute($stmt)){
                            echo "SUCCESS ADD TO ADMINS TABLE!";
                        } else {
                            echo "MYSQL ERROR ADD TO ADMINS TABLE! PLEASE CHECK DATABASE! ".mysqli_error($conn);
                        }

                        mysqli_stmt_close($stmt);
                    }
                } else if ($role == 2){
                    //officer
                    $officerSignUpSQL = "INSERT INTO students (student_name, student_telno, user_id) VALUES (?, ?, ?)";
                    if ($stmt=mysqli_prepare($conn, $officerSignUpSQL)){
                        mysqli_stmt_bind_param($stmt, "ssi", $off_name, $off_telno, $u_id);

                        $off_name = $name;
                        $off_telno = $tel;
                        $u_id = $userId;

                        if(mysqli_stmt_execute($stmt)){
                            echo "SUCCESS ADD TO OFFICERS TABLE!";
                        } else {
                            echo "MYSQL ERROR ADD TO OFFICERS TABLE! PLEASE CHECK DATABASE! ".mysqli_error($conn);
                        }

                        mysqli_stmt_close($stmt);
                    }
                } else {
                    die("Invalid Role when adding to database! DATABASE MIGHT BE CORRUPT. PLEASE CONTACT ADMINISTRATOR.");
                }
                
            } else {
                mysqli_close($conn);
                die("<p>Invalid method.</p>");
            }
            mysqli_close($conn);
        ?>
    </body>
</html>