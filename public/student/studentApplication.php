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


    if (strlen($_POST["filename"]) >0) {
        $_POST["filename"] = $_POST["filename"];
    }else{
        $_POST["filename"]= null;
        
        echo '<p><b> You Forgot to Upload Your File! </b></p>';
    }
    require_once 'google-api-php-client/src/Google_Client.php';
    require_once 'google-api-php-client/src/contrib/Google_DriveService.php';
    //create a Google OAuth client
    $client = new Google_Client();
    $client->setClientId('YOUR CLIENT ID');
    $client->setClientSecret('YOUR CLIENT SECRET');
    $redirect = filter_var('https://drive.google.com/drive/folders/1LRAebZGyTr2HwbzUrE-XDaRgqDoYQfv1?usp=sharing' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'],
        FILTER_SANITIZE_URL);
    $client->setRedirectUri($redirect);
    $client->setScopes(array('https://www.googleapis.com/auth/drive'));
    if(empty($_GET['code']))
    {
        $client->authenticate();
    }
    
    if(!empty($_FILES["filename"]["name"]))
    {
      $target_file=$_FILES["filename"]["name"];
      // Create the Drive service object
      $accessToken = $client->authenticate($_GET['code']);
      $client->setAccessToken($accessToken);
      $service = new Google_DriveService($client);
      // Create the file on your Google Drive
      $fileMetadata = new Google_Service_Drive_DriveFile(array(
        'name' => 'My file'));
      $content = file_get_contents($target_file);
      $mimeType=mime_content_type($target_file);
      $file = $driveService->files->create($fileMetadata, array(
        'data' => $content,
        'mimeType' => $mimeType,
        'fields' => 'id'));
      printf("File ID: %s\n", $file->id);
    }
?>