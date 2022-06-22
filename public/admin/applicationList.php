<?php
    session_start();
    if (!isset($_SESSION["admin_id"])){
        header("refresh:5;url=/login.php");
        die('<script>alert("ADMIN_ID NOT SET. INVALID SESSION.")</script>');
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>UiTM Club Activities Approval System - Welcome</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
    </head>
    <body>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
        <script type="text/javascript">
            $(document).ready( function () {
                $('#appTable').DataTable({
                    ajax: {
                        url: '/api/getApplicationList.php',
                        dataSrc: 'data'
                    }
                });
            } );
        </script>
        <?php
            include("../../header/header.php");
        ?>
        <div class="px-5">
            <h4>View Applications</h4>
        </div>
        <br>
        <div class="px-5">
            <table id="appTable" class="table table-bordered table-hover dt-responsive">
                <thead>
                    <tr>
                        <th>Application ID</th>
                        <th>Application Name</th>
                        <th>Student Name</th>
                        <th>Club Name</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Application ID</th>
                        <th>Application Name</th>
                        <th>Student Name</th>
                        <th>Club Name</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </body>
</html>