<!DOCTYPE html>
<html>
    <head>
        <title>UiTM Club Activities Approval System - Processing request...</title>
    </head>
    <body>
        <!--h1>Authenticating...</h1-->
        <?php
            session_start();
            //echo "<p>Processing your sign up request...</p>";
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
            // Include config file
            require_once "inc/connect.php";

            if(!isset($_SESSION["backPage"])){
                //backPage is not set, defaulting to login.php
                $backPage = "/login.php";
            }

            $backPage = $_SESSION["backPage"];

            if(isset($_SESSION["uid"]) && strpos($backPage, 'addNewUser.php') === false){
                //user is logged in already
                $_SESSION["userErrCode"] = "SESSION_EXISTS";
                $_SESSION["userErrMsg"] = "You are already logged in. Please log out to sign up as another user.";
                header("refresh:0;url=$backPage?error=true");
                die();
            }

            // Define variables and initialize with empty values
            //$username = $password = $confirm_password = "";
            //$username_err = $password_err = $confirm_password_err = "";
        
            // Processing form data when form is submitted
            if($_SERVER["REQUEST_METHOD"] == "POST"){
                $clubid = $_POST["clubid"];
                $role = $_POST["role"];

                if($role != 0 && !($clubid == null || $clubid == "")){
                    $_SESSION["userErrCode"] = "CLUBID_ROLE_MISMATCH";
                    $_SESSION["userErrMsg"] = "Club ID should only be present if role is student. Please contact the administrator if you believe that this should not happen.";
                    header("refresh:0;url=$backPage?error=true");
                    die();
                }

                if($role == 0){
                    //get clublist
                    //check if clublist exists
                    $clublistsql = "SELECT club_id FROM clubs WHERE club_id = (?)" ;
                    if ($stmt=mysqli_prepare($conn, $clublistsql)){
                        mysqli_stmt_bind_param($stmt, "i", $club_id);

                        $club_id = $clubid;

                        if(mysqli_stmt_execute($stmt)){
                            $clubidArray = mysqli_fetch_array(mysqli_stmt_get_result($stmt));
                            $clubIdRes = $clubidArray["club_id"];
                            if($clubIdRes == 0 || $clubIdRes == NULL){
                                $_SESSION["userErrCode"] = "INVALID_CLUB_ID";
                                $_SESSION["userErrMsg"] = "Club ID is invalid. Please view the club list or contact the administrator if you believe that this should not happen.";
                                header("refresh:0;url=$backPage?error=true");
                                die() ;
                            }//end if
                            //echo "SUCCESS QUERY USERS TABLE FOR CLUB_ID!<br>";
                        } else {
                            //echo "MYSQL ERROR QUERY USERS TABLE! ".mysqli_error($conn);
                            $_SESSION["userErrCode"] = "MYSQL_ERROR";
                            $_SESSION["userErrMsg"] = "MySQL error encountered: ".mysqli_error($conn)." Please contact the administrator if you believe that this should not happen.";
                            header("refresh:0;url=$backPage?error=true");
                            die();
                        }

                        mysqli_stmt_close($stmt);
                    }
                }

                //echo "<p>Please wait for a few seconds.</p>";
                $email = $_POST["email"];
                if(empty(trim($_POST["email"]))){
                    $_SESSION["userErrCode"] = "INVALID_EMAIL";
                    $_SESSION["userErrMsg"] = "Email is invalid. Please make sure that your email is valid.";
                    header("refresh:0;url=$backPage?error=true");
                    die();
                }
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $_SESSION["userErrCode"] = "INVALID_EMAIL";
                    $_SESSION["userErrMsg"] = "Email is invalid. Please make sure that your email is valid.";
                    header("refresh:0;url=$backPage?error=true");
                    die();
                }

                // Validate password
                if(empty(trim($_POST["password"]))){
                    $password_err = "Please enter a password.";
                    die($password_err);
                } elseif(strlen(trim($_POST["password"])) < 8){
                    $_SESSION["userErrCode"] = "INVALID_PASSWORD";
                    $_SESSION["userErrMsg"] = "Password is invalid. Password must have at least 8 characters.";
                    header("refresh:0;url=$backPage?error=true");
                    die();
                } else{
                    $password = trim($_POST["password"]);
                }

                // Validate confirm password
                if(empty(trim($_POST["confirmPassword"]))){
                    $_SESSION["userErrCode"] = "CONFIRM_PASSWORD_NONEXISTANT";
                    $_SESSION["userErrMsg"] = "Please enter the password confirmation.";
                    header("refresh:0;url=$backPage?error=true");
                    die();
                } else{
                    $confirm_password = trim($_POST["confirmPassword"]);
                    if(empty($password_err) && ($password != $confirm_password)){
                        $_SESSION["userErrCode"] = "CONFIRM_PASSWORD_MISMATCH";
                        $_SESSION["userErrMsg"] = "Confirmation password does not match with the password.";
                        header("refresh:0;url=$backPage?error=true");
                        die();
                    }
                }

                $password = password_hash($password, PASSWORD_DEFAULT);
                $name = $_POST["name"];
                $tel = $_POST["telephone"];

                if ($role < 0 || $role > 2){
                    $_SESSION["userErrCode"] = "INVALID_ROLE";
                    $_SESSION["userErrMsg"] = "User role is invalid. Please contact the administrator for further assistance.";
                    header("refresh:0;url=$backPage?error=true");
                    die();
                }

                //MYSQL STATEMENTS BELOW

                //check for duplicate email
                $emailsql = "SELECT count(user_email) FROM users WHERE user_email = (?)" ;
                if ($stmt=mysqli_prepare($conn, $emailsql)){
                    mysqli_stmt_bind_param($stmt, "s", $user_email);

                    $user_email = $email;

                    if(mysqli_stmt_execute($stmt)){
                        $emailArray = mysqli_fetch_array(mysqli_stmt_get_result($stmt));
                        $userEmail = $emailArray["count(user_email)"];
                        if($userEmail > 0 || $userEmail != NULL){
                            $_SESSION["userErrCode"] = "EMAIL_EXISTS";
                            $_SESSION["userErrMsg"] = "The account for this email already exists. Please log in instead.";
                            header("refresh:0;url=$backPage?error=true");
                            die();
                        }//end if
                        //echo "SUCCESS QUERY USERS TABLE FOR EMAIL!<br>";
                    } else {
                        $_SESSION["userErrCode"] = "MYSQL_ERROR";
                        $_SESSION["userErrMsg"] = "MySQL error encountered: ".mysqli_error($conn)." Please contact the administrator if you believe that this should not happen.";
                        header("refresh:0;url=$backPage?error=true");
                        die();
                    }

                    mysqli_stmt_close($stmt);
                }

                //prepare mysql statements for user
                $signUpSQL = "INSERT INTO users (user_email, user_pass, user_type) VALUES (?, ?, ?)";
                if ($stmt=mysqli_prepare($conn, $signUpSQL)){
                    mysqli_stmt_bind_param($stmt, "ssi", $db_email, $db_password, $db_type);

                    $db_email = $email;
                    $db_password = $password;
                    $db_type = $role;

                    if(mysqli_stmt_execute($stmt)){
                        //echo "SUCCESS ADD TO USERS TABLE!<br>";
                    } else {
                        $_SESSION["userErrCode"] = "MYSQL_ERROR";
                        $_SESSION["userErrMsg"] = "MySQL error encountered: ".mysqli_error($conn)." Please contact the administrator if you believe that this should not happen.";
                        header("refresh:0;url=$backPage?error=true");
                        die();
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
                        //echo "SUCCESS QUERY USERS TABLE!<br>";
                    } else {
                        $_SESSION["userErrCode"] = "MYSQL_ERROR";
                        $_SESSION["userErrMsg"] = "MySQL error encountered: ".mysqli_error($conn)." Please contact the administrator if you believe that this should not happen.";
                        header("refresh:0;url=$backPage?error=true");
                        die();
                    }

                    mysqli_stmt_close($stmt);
                }

                //prepare mysql statements for role-specific stuff
                if ($role == 0){
                    //students
                    $studentSignUpSQL = "INSERT INTO students (student_name, student_telno, club_id, user_id) VALUES (?, ?, ?, ?)";
                    if ($stmt=mysqli_prepare($conn, $studentSignUpSQL)){
                        mysqli_stmt_bind_param($stmt, "ssii", $stu_name, $stu_telno, $club_id, $u_id);

                        $stu_name = $name;
                        $stu_telno = $tel;
                        $club_id = $clubid;
                        $u_id = $userId;

                        if(mysqli_stmt_execute($stmt)){
                            //echo "SUCCESS ADD TO STUDENTS TABLE!<br>";
                        } else {
                            $_SESSION["userErrCode"] = "MYSQL_ERROR";
                            $_SESSION["userErrMsg"] = "MySQL error encountered: ".mysqli_error($conn)." Please contact the administrator if you believe that this should not happen.";
                            header("refresh:0;url=$backPage?error=true");
                            die();
                        }

                        mysqli_stmt_close($stmt);
                    }
                } else if ($role == 1){
                    //admin
                    $adminSignUpSQL = "INSERT INTO admins (admin_name, admin_telno, user_id) VALUES (?, ?, ?)";
                    if ($stmt=mysqli_prepare($conn, $adminSignUpSQL)){
                        mysqli_stmt_bind_param($stmt, "ssi", $adm_name, $adm_telno, $u_id);

                        $adm_name = $name;
                        $adm_telno = $tel;
                        $u_id = $userId;

                        if(mysqli_stmt_execute($stmt)){
                            //echo "SUCCESS ADD TO ADMINS TABLE!<br>";
                        } else {
                            $_SESSION["userErrCode"] = "MYSQL_ERROR";
                            $_SESSION["userErrMsg"] = "MySQL error encountered: ".mysqli_error($conn)." Please contact the administrator if you believe that this should not happen.";
                            header("refresh:0;url=$backPage?error=true");
                            die();
                        }

                        mysqli_stmt_close($stmt);
                    }
                } else if ($role == 2){
                    //officer
                    $officerSignUpSQL = "INSERT INTO officers (officer_name, officer_telno, user_id) VALUES (?, ?, ?)";
                    if ($stmt=mysqli_prepare($conn, $officerSignUpSQL)){
                        mysqli_stmt_bind_param($stmt, "ssi", $off_name, $off_telno, $u_id);

                        $off_name = $name;
                        $off_telno = $tel;
                        $u_id = $userId;

                        if(mysqli_stmt_execute($stmt)){
                            //echo "SUCCESS ADD TO OFFICERS TABLE!<br>";
                        } else {
                            $_SESSION["userErrCode"] = "MYSQL_ERROR";
                            $_SESSION["userErrMsg"] = "MySQL error encountered: ".mysqli_error($conn)." Please contact the administrator if you believe that this should not happen.";
                            header("refresh:0;url=$backPage?error=true");
                            die();
                        }

                        mysqli_stmt_close($stmt);
                    }
                } else {
                    $_SESSION["userErrCode"] = "INVALID_ROLE_DB";
                    $_SESSION["userErrMsg"] = "Role is invalid when adding to database. CONTACT THE ADMINSTRATOR.";
                    header("refresh:0;url=$backPage?error=true");
                    die();
                }
                
            } else {
                mysqli_close($conn);
                die("<p>Invalid method.</p>");
            }
            mysqli_close($conn);
            $_SESSION["userErrCode"] = "SIGNUP_SUCCESS";
            $_SESSION["userErrMsg"] = "Sign up success. You may login now.";
            header("refresh:0;url=$backPage?signup=success");
        ?>
    </body>
</html>