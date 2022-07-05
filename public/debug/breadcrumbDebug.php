<?php
    $currDir = "/this/is/a/testingSites.php/directory.php";
    $pageTitle = "Dir";
    include "../../header/breadcrumb.php";
    $bdcb = new Breadcrumb($currDir, $pageTitle);
    $bdcb->debugPrint();
?>