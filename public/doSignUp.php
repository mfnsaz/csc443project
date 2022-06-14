<?php
    // Include config file
    require_once "/db/auth/connect.php";
 
    // Define variables and initialize with empty values
    $username = $password = $confirm_password = "";
    $username_err = $password_err = $confirm_password_err = "";

    echo $_POST["email"];
    echo $_POST["password"];
    echo $_POST["confirmPassword"];
    echo $_POST["name"];
    echo $_POST["telephone"];
    echo $_POST["role"];
 
    // Processing form data when form is submitted
    if($_SERVER["REQUEST_METHOD"] == "POST"){
 
        echo "test";
        
    }
?>