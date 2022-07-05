<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>UiTM Club Activities Approval System</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
        <link rel="icon" type="image/x-icon" href="https://saringc19.uitm.edu.my/statics/icons/favicon.ico">
    </head>
    <body>
        <?php
            include("../../header/header.php");
        ?>
        <div class="px-5 text-center">
            <h1>Club Listing</h1>
        </div>
        <nav class="px-5 py-4" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <?php
                    $currDir = $_SERVER['PHP_SELF'];
                    $currUrl = $_SERVER['PHP_HOST'];
                    $pageTitle = "Club Lists";
                    include('../../header/breadcrumb.php');
                ?>
            </ol>
        </nav>
        <div class="px-5">
            <p>Here, you can find the list of clubs available.</p>
            <?php
                require_once "../inc/connect.php";

                //get clublist
                $getClubSQL = "SELECT * FROM clubs";
                $clubRes = mysqli_query($conn, $getClubSQL);
                if(!is_bool($clubRes)){
                    $clubArr = mysqli_fetch_all($clubRes);
                    $clubArr = array_values($clubArr);
                    echo "<table class=\"table\"><tr><th scope=\"col\">#</th><th scope=\"col\">Club ID</th><th scope=\"col\">Club Name</th><th scope=\"col\">Club Type</th></tr>";
                    $tableIndex = 1;
                    foreach($clubArr as $currClub){
                        echo "<tr><th scope=\"row\">$tableIndex</th>";
                        $tableIndex++;
                        foreach($currClub as $currField){
                            echo "<td>$currField</td>";
                        }
                        echo "</tr>";
                    }
                    echo "</table>";
                } else {
                    echo "ERROR";
                }
            ?>
        </div>
        <?php
            include("../../header/footer.php");
        ?>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    </body>
</html>