<?php
    session_start();
    if (!isset($_SESSION["admin_id"])){
        header("refresh:0;url=/login.php");
        die('<script>alert("ADMIN_ID NOT SET. INVALID SESSION.")</script>');
    }
    if (!isset($_GET["app_id"])){
        header("refresh:0;url=/admin/index.php");
        die('<script>alert("APP_ID NOT SET. INVALID SESSION.")</script>');
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
    </head>
    <body>
        <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
        <?php
            include("../../header/header.php");
        ?>
        <!--Nanti kena automatically tarik from database untuk application name, club name, date, time and proposal-->
          <div class="container px-5 my-5">
              <h1 class="pb-4">Club Application Details</h1>
              <?php
                error_reporting(E_ALL);
                ini_set('display_errors', 1);
                require_once "../inc/connect.php";

                $appId = $_GET["app_id"];

                //get applist
                $getAppSQL = "SELECT app_name, app_startDate, app_endDate, app_time, app_files_link FROM applications WHERE application_id = $appId";
                $appRes = mysqli_query($conn, $getAppSQL);
                echo "Listing application for application ID ".$appId;
                if(!is_bool($appRes)){
                    $appArr = mysqli_fetch_all($appRes);
                    //$appArr = array_values($appArr);
                    foreach($appArr as $currApp){
                        echo "<div class=\"\">";
                        echo "<p><b>Application Name</b>".$currApp[0]."</p>";
                        echo "<p><b>Application Start Date</b>".$currApp[1]."</p>";
                        echo "<p><b>Application End Date</b>".$currApp[2]."</p>";
                        echo "<p><b>Application Time</b>".$currApp[3]."</p>";
                        echo "<p><b>Application Proposals Link</b>".$currApp[4]."</p>";
                    }
                } else {
                    echo "what";
                    header('X-PHP-Response-Code: 500', true, 500);
                    die();
                }
              ?>
              <form id="contactForm" action="#" method="post">
                  <div class="form-floating mb-3">
                    <select class="form-select" name="appStatus" id="status" aria-label="appStat" required>
                        <option value=""></option>
                        <option value="0">Accepted</option>
                        <option value="1">Rejected</option>
                    </select>
                    <label for="appStatus">Status</label>
                </div>
                <div class="form-floating mb-3">
                  <input class="form-control" name="remarks" type="comment" placeholder="remarks" required/>
                  <label for="remarks">Remarks</label>
              </div>
                 <div class="form-floating mb-3" id="offSelect" style="display: none;">
                    <select class="form-select" name="assignOfficer" id="officerList" aria-label="assoff" required>
                        <option value="0">Officer 1-Encik Nuh Hakimi Mohd Yassin</option>
                        <option value="1">Officer 2- Puan Mariya Mohamad</option>
                        <option value="2">Officer 3- Encik Fuad Ibrahim</option>
                    </select>
                    <label for="assignOfficer">Assign Officer</label>
                </div>
              
                
                    <div class="d-grid">
                        <button class="btn btn-primary btn-lg" id="submitButton" type="submit">Submit</button>
                    </div>

                </form>
          </div>
          <script type="text/javascript">
            var xmlhttp = new XMLHttpRequest();
            var url = "/api/getOfficerList.php";
            xmlhttp.onreadystatechange = function(){
                if (this.readyState == 4 && this.status == 200) {
                    var data = JSON.parse(this.responseText);
                    var htmlData = "<option value=\"\"></option>";
                    for(let i = 0; i < data.officerId.length; i++){
                        htmlData = htmlData.concat("\n", "<option value=\""+data.officerId[i]+"\">"+data.officerName[i]+"</option>\n");
                    }
                    document.getElementById("officerList").innerHTML = htmlData;
                }
            }
            xmlhttp.open("GET", url, true);
            xmlhttp.send();

            var roleSelection = document.getElementById('status');
            roleSelection.onchange = function(){
                if(roleSelection.selectedIndex === 1) {
                    document.getElementById('offSelect').style.display = "block";
                    document.getElementById('officerList').required = true;
                } else {
                    document.getElementById('offSelect').style.display = "none";
                    document.getElementById('officerList').required = false;
                }
            }
        </script>
    </body>
</html>