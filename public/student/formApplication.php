<?php
    session_start();
    if (!isset($_SESSION["student_id"]) || $_SESSION["student_id"] == ""){
        header("refresh:5;url=/login.html");
        die('<script>alert("STUDENT_ID NOT SET. INVALID SESSION.")</script>');
    }
    if (!isset($_SESSION["club_id"]) || $_SESSION["club_id"] == ""){
        header("refresh:5;url=/login.html");
        die('<script>alert("CLUB_ID NOT SET. CONTACT THE ADMINISTRATOR.")</script>');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Form</title>

    <!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
            <a href="/" class="d-flex align-items-center col-md-3 mb-2 mb-md-0 text-dark text-decoration-none">
                <!--svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"></use></svg-->
                <img src="https://korporat.uitm.edu.my/images/download/2019/LogoUiTM.png" class="" height="50px" alt="alzhahir Logo">
                <p class="h6 ps-3">Club Activities Approval System</p>
            </a>

            <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
                <li><a href="/" class="nav-link px-2 link-secondary">Home</a></li>
                <li><a href="/login.html" class="nav-link px-2 link-dark">Login</a></li>
                <li><a href="/contact.html" class="nav-link px-2 link-dark">Contact</a></li>
                <li><a href="/faq.html" class="nav-link px-2 link-dark">FAQs</a></li>
                <li><a href="/about.html" class="nav-link px-2 link-dark">About</a></li>
            </ul>

            <div class="col-md-3 text-end">
                <button type="button" class="btn btn-primary" onclick="location.href='/login.html';">Login</button>
            </div>
        </header>
    </div>
    <div class="container px-5 my-5">
        <h1 class="pb-4">New Activity Application</h1>
        <p>Please fill in the form below.</p>
        <form id="contactForm" action="./studentApplication.php" method="post">
            <div class="form-floating mb-3">
                <input class="form-control" id="applicationName" type="text" placeholder="Application Name" required/>
                <label for="applicationName">Application Name</label>
            </div>
            <div class="form-floating mb-3">
                <input class="form-control" id="startDate" type="date" placeholder="Start Date" required/>
                <label for="startDate">Start Date</label>
            </div>
            <div class="form-floating mb-3">
                <input class="form-control" id="endDate" type="date" placeholder="End Date" required/>
                <label for="endDate">End Date</label>
            </div>
            <div class="form-floating mb-3">
                <input class="form-control" id="time" type="time" placeholder="Time" required/>
                <label for="time">Time</label>
            </div>
            <div class="form-floating mb-3">
                <input class="form-control" id="proposalFilesLink" type="url" placeholder="Proposal Files Link" required/>
                <label for="proposalFilesLink">Proposal Files Link</label>
            </div>
            <div class="d-grid">
                <button class="btn btn-primary btn-lg disabled" id="submitButton" type="submit">Submit</button>
            </div>
        </form>
    </div>
<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>
</html>