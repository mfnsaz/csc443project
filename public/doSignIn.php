<!DOCTYPE html>
<html>
    <head>
        <title>Processing request...</title>
    </head>
    <body>
        <h1>Authenticating...</h1>
        <?php
            echo "<p>Processing your sign in request...</p>";
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
                $email = $_POST["signInEmail"];
                if(empty(trim($_POST["signInEmail"]))){
                    $email_err = "Please enter an email.";
                    die($email_err);
                }
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $emailErr = "Invalid email format";
                    die($emailErr);
                }

                // Validate password
                if(empty(trim($_POST["signInPassword"]))){
                    $password_err = "Please enter a password.";
                    die($password_err);
                } elseif(strlen(trim($_POST["signInPassword"])) < 8){
                    $password_err = "ERROR: Password must have atleast 8 characters. Redirecting back to the login page.";
                    header("refresh:5;url=login.html");
                    die($password_err);
                } else{
                    $password = trim($_POST["signInPassword"]);
                }
                
                //get usercreds
                $getUserCredsSQL = "SELECT user_id, user_pass, user_type FROM users WHERE user_email = (?)";
                if ($stmt=mysqli_prepare($conn, $getUserCredsSQL)){
                    mysqli_stmt_bind_param($stmt, "s", $user_email);

                    $user_email = $email;

                    if(mysqli_stmt_execute($stmt)){
                        $usersArray = mysqli_fetch_array(mysqli_stmt_get_result($stmt));
                        $userId = $usersArray["user_id"];
                        $userPass = $usersArray["user_pass"];
                        $userType = $usersArray["user_type"];
                        echo "SUCCESS QUERY USERS TABLE!\n";
                    } else {
                        echo "MYSQL ERROR QUERY USERS TABLE! ".mysqli_error($conn);
                    }

                    mysqli_stmt_close($stmt);
                }

                if(password_verify($password, $userPass)){
                    //correct password
                    session_start();
                    if($userType == 0){
                        //student
                        $getStudentInfoSQL = "SELECT student_id, student_name, student_telno FROM students WHERE user_id = (?)";
                        if ($stmt=mysqli_prepare($conn, $geStudentInfoSQL)){
                            mysqli_stmt_bind_param($stmt, "i", $u_id);

                            $u_id = $userId;

                            if(mysqli_stmt_execute($stmt)){
                                $studentArray = mysqli_fetch_array(mysqli_stmt_get_result($stmt));
                                $studentId = $studentArray["student_id"];
                                $studentName = $studentArray["student_name"];
                                $studentTel = $studentArray["student_telno"];
                                echo "SUCCESS QUERY USERS TABLE!\n";
                            } else {
                                echo "MYSQL ERROR QUERY USERS TABLE! ".mysqli_error($conn);
                            }

                            mysqli_stmt_close($stmt);
                        }
                        $_SESSION["email"] = $email;
                        $_SESSION["uid"] = $userId;
                        $_SESSION["name"] = $studentName;
                        $_SESSION["tel"] = $studentTel;
                        $_SESSION["student_id"] = $studentId;
                        header("refresh:5;url=/student/index.php");
                    } else if ($userType == 1){
                        //admin
                        $getAdminInfoSQL = "SELECT admin_id, admin_name, admin_telno FROM admins WHERE user_id = (?)";
                        if ($stmt=mysqli_prepare($conn, $getAdminInfoSQL)){
                            mysqli_stmt_bind_param($stmt, "i", $u_id);

                            $u_id = $userId;

                            if(mysqli_stmt_execute($stmt)){
                                $adminArray = mysqli_fetch_array(mysqli_stmt_get_result($stmt));
                                $adminId = $adminArray["admin_id"];
                                $adminName = $adminArray["admin_name"];
                                $adminTel = $adminArray["admin_telno"];
                                echo "SUCCESS QUERY USERS TABLE!\n";
                            } else {
                                echo "MYSQL ERROR QUERY USERS TABLE! ".mysqli_error($conn);
                            }

                            mysqli_stmt_close($stmt);
                        }
                        $_SESSION["email"] = $email;
                        $_SESSION["uid"] = $userId;
                        $_SESSION["name"] = $adminName;
                        $_SESSION["tel"] = $adminTel;
                        $_SESSION["admin_id"] = $adminId;
                        header("refresh:5;url=/admin/index.php");
                    } else if ($userType == 2){
                        //officer
                        $getOfficerInfoSQL = "SELECT officer_id, officer_name, officer_telno FROM officers WHERE user_id = (?)";
                        if ($stmt=mysqli_prepare($conn, $getUserInfoSQL)){
                            mysqli_stmt_bind_param($stmt, "i", $u_id);

                            $u_id = $userId;

                            if(mysqli_stmt_execute($stmt)){
                                $officerArray = mysqli_fetch_array(mysqli_stmt_get_result($stmt));
                                $officertId = $officerArray["officer_id"];
                                $officerName = $officerArray["officer_name"];
                                $officerTel = $officerArray["officer_telno"];
                                echo "SUCCESS QUERY USERS TABLE!\n";
                            } else {
                                echo "MYSQL ERROR QUERY USERS TABLE! ".mysqli_error($conn);
                            }

                            mysqli_stmt_close($stmt);
                        }
                        $_SESSION["email"] = $email;
                        $_SESSION["uid"] = $userId;
                        $_SESSION["name"] = $officerName;
                        $_SESSION["tel"] = $officerTel;
                        $_SESSION["officer_id"] = $officerId;
                        header("refresh:5;url=/officer/index.php");
                    }
                } else {
                    echo '<script>alert("Wrong password. Returning to login page...")</script>';
                    header("refresh:5;url=login.html");
                }
            } else {
                die("<p>Invalid method.</p>");
            }
        ?>
    </body>
</html>