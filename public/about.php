<?php session_start() ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>UiTM Club Activities Approval System - About</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
        <link rel="icon" type="image/x-icon" href="https://saringc19.uitm.edu.my/statics/icons/favicon.ico">
    </head>
    <body>
        <?php
            include("../header/header.php");
        ?>
        <div class="px-5 text-center">
            <h1>About the UiTM Club Activities Approval System</h1>
        </div>
        <nav class="px-5 py-4" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <?php
                    $currDir = $_SERVER['PHP_SELF'];
                    $currUrl = $_SERVER['PHP_HOST'];
                    $pageTitle = "About Us";
                    include('../header/breadcrumb.php');
                ?>
            </ol>
        </nav>
        <div class="px-5 py-4">
            <h4 style="text-align: justify; text-justify: inter-word;">The UiTM Club Activities Approval System aims to help streamline club activities application process.
            This system was created to ease the process of club activity proposal. The system features tracking, which would enable the users to learn about the
            current status of the applications.</h4>
        </div>
        <div class="px-5 py-4">
            <h5>This system was created by: </h5>
            <p>MEGAT AL ZHAHIR DANIEL BIN MEGAT NOR MAZLAN (2020878518)</p>
            <p>FARAH NATASHA BINTI MUHAMAD HAZRIN (2020898386)</p>
            <p>NUR NABILAH BINTI SHAARI (2020489836)</p>
            <p>SITI SYAHIRAH BINTI AHMADLKUSHAIRY (2020819788)</p>
            <p>NUR ASNA BINTI FADZIL (2021857372)</p>
            <p>AZIZAH BINTI AZAHAR (2021620258)</p>

            <h5>and is licensed under the:</h5>
            <p>GNU General Public License v3.0</p>

            <p>The source code for this project can be found <a href="https://github.com/mfnsaz/csc443project">here</a>.</p>
        </div>
        <?php
            include("../header/footer.php");
        ?>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    </body>
</html>