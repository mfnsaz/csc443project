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
                echo "<p>Processing your sign in request...</p>";
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
                    $password_err = "Password must have atleast 8 characters.";
                    die($password_err);
                } else{
                    $password = trim($_POST["password"]);
                }
            } else {
                die("Invalid method.");
            }
        ?>
    </body>
</html>