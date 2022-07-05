<?php
    $currDir = "/this/is/a/test/directory.php";
    $pageTitle = "Dir";
    include "../../header/breadcrumb.php";
    $bdcb = new Breadcrumb($currDir, $pageTitle);
    $bdcb->debugPrint();
?>