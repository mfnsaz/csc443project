<?php
    include("formApplication.html"); #Script handle form 
    if (strlen($_POST["name"]) >0) {
        $_POST["name"] = $_POST["name"];
    }else{
        $_POST["name"]= null;
        echo '<p><b> You Forgot to Enter Your Name! </b></p>';
    }

    if (isset($_POST["gender"])) {
        if($_POST["gender"] == 'M'){
            $message ='<b><p>Good Day, Boy </b></p>';
        }
        if($_POST["gender"] == 'F'){
            $message ='<b><p>Good Day, Girl </b></p>';
        }
    }else{
        $_POST["gender"]= null;
        echo '<p><b> You Forgot to Choose Your Gender! </b></p>';
    }

    if (!(strlen($_POST["email"]) >0)) {
        $_POST["email"]= null; 
        echo '<p><b> You Forgot to Enter Your Emails! </b></p>';
    }

    if (strlen($_POST["numphone"]) >0) {
        $_POST["numphone"] = $_POST["numphone"];
    }else{
        $_POST["numphone"]= null;
        
        echo '<p><b> You Forgot to Enter Your Number Phone! </b></p>';
    }

    if (strlen($_POST["clubname"]) >0) {
        $_POST["clubname"] = $_POST["clubname"];
    }else{
        $_POST["clubname"]= null;
        
        echo '<p><b> You Forgot to Enter Your Club Name! </b></p>';
    }

    if (strlen($_POST["proptitle"]) >0) {
        $_POST["proptitle"] = $_POST["proptitle"];
    }else{
        $_POST["proptitle"]= null;
        
        echo '<p><b> You Forgot to Enter Your Proposal Title! </b></p>';
    }

    if (strlen($_POST["proptitle"]) >0) {
        $_POST["proptitle"] = $_POST["proptitle"];
    }else{
        $_POST["proptitle"]= null;
        
        echo '<p><b> You Forgot to Enter Your Proposal Title! </b></p>';
    }

    if (strlen($_POST["filename"]) >0) {
        $_POST["filename"] = $_POST["filename"];
    }else{
        $_POST["filename"]= null;
        
        echo '<p><b> You Forgot to Upload Your File! </b></p>';
    }

?>