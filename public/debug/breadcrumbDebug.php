<?php
    include "../../header/breadcrumb.php";

    $bdcb = new Breadcrumb("/this/is/a/test/directory", "Dir");
    $bdcb->debugPrint();
?>