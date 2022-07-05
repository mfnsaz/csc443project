<?php
    include "../../header/breadcrumb.php";

    $bdcb = new Breadcrumb("/this/is/a/test/directory.php", "Dir");
    $bdcb->debugPrint();
?>