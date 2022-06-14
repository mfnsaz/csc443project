<!DOCTYPE html>
<html>
    <head>
        <title>Processing request...</title>
    </head>
    <body>
        <h1>Authenticating...</h1>
        <?php
            // Include config file
            require_once "/db/auth/connect.php";

            // Define variables and initialize with empty values
            //$username = $password = $confirm_password = "";
            //$username_err = $password_err = $confirm_password_err = "";
        
            // Processing form data when form is submitted
            if($_SERVER["REQUEST_METHOD"] == "POST"){
                echo "<p>Processing your sign up request...</p>";
                echo "<p>Please wait for a few seconds.</p>";
                $email = $_POST["email"];
                if(empty(trim($_POST["email"]))){
                    $email_err = "Please enter an email.";
                }
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $emailErr = "Invalid email format";
                }

                // Validate password
                if(empty(trim($_POST["password"]))){
                    $password_err = "Please enter a password.";     
                } elseif(strlen(trim($_POST["password"])) < 6){
                    $password_err = "Password must have atleast 6 characters.";
                } else{
                    $password = trim($_POST["password"]);
                }

                // Validate confirm password
                if(empty(trim($_POST["confirm_password"]))){
                    $confirm_password_err = "Please confirm password.";     
                } else{
                    $confirm_password = trim($_POST["confirm_password"]);
                    if(empty($password_err) && ($password != $confirm_password)){
                        $confirm_password_err = "Password did not match.";
                    }
                }
                echo $_POST["name"];
                echo $_POST["telephone"];
                echo $_POST["role"];
                
            } else {
                echo "Invalid method.";
            }
        ?>
    </body>
</html>