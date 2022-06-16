<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>UiTM Club Activities Approval System</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    </head>
    <body>
        <div class="container">
            <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
                <a href="/" class="d-flex align-items-center col-md-3 mb-2 mb-md-0 text-dark text-decoration-none">
                    <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"></use></svg>
                    <img src="https://api.alzhahir.com/static/images/logos/alzhahir/alz-logo-shadow-outline.png" class="img-fluid px-5" alt="alzhahir Logo">
                </a>

                <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
                    <li><a href="/" class="nav-link px-2 link-secondary">Home</a></li>
                    <li><a href="/login.php" class="nav-link px-2 link-dark">Login</a></li>
                    <li><a href="/contact.html" class="nav-link px-2 link-dark">Contact</a></li>
                    <li><a href="/faq.html" class="nav-link px-2 link-dark">FAQs</a></li>
                    <li><a href="/about.html" class="nav-link px-2 link-dark">About</a></li>
                </ul>

                <div class="col-md-3 text-end">
                    <button type="button" class="btn btn-primary" onclick="location.href='/login.php';">Login</button>
                </div>
            </header>
        </div>
        <div class="px-5 text-center">
            <h1>Club Listing</h1>
        </div>
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
                    echo "<table><tr><th>No</th><th>Club ID</th><th>Club Name</th><th>Club Type</th></tr>";
                    $tableIndex = 1;
                    foreach($clubArr as $currClub){
                        echo "<tr><td>$tableIndex</td>";
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
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    </body>
</html>