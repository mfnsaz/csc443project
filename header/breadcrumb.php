<?php
    class Breadcrumb {
        private string $currdir;
        private string $currtitle;
        private array $dirarray;
        private string $crumbbuild;
        function __construct(string $currentDirectory, string $pageTitle) {
            $this->currdir = $currentDirectory;
            if($pageTitle != NULL){
                $this->currtitle = $pageTitle;
            } else {
                $this->currtitle = NULL;
            }
        }

        function getDirectoryArray(){
            $dirArr = explode("/", $this->currdir);
            array_shift($dirArr);
            array_unshift($dirArr, "home");
            return $dirArr;
        }

        function getFullCrumb(){
            $currDir = $this->getDirectoryArray();
            $arrSize = count($currDir);
            $i = 1;
            $buildList = "";
            foreach($currDir as $currPage){
                $currPage = ucfirst(str_replace(".php", "", $currPage));
                if($currPage == ""){
                    continue;
                } else if(++$i == $arrSize){
                    $valEnd = "";
                    $buildList =  $buildList . $currPage;
                } else {
                    $valEnd = " / ";
                    $buildList = $buildList . $currPage;
                }
                $buildList = $buildList . $valEnd;
            }
            return $this->crumbbuild;
        }

        function getCrumbArray(){
            $currDir = $this->getDirectoryArray();
            $crumbArr = array();
            $i = 1;
            $iLimit = count($currDir);
            foreach($currDir as $currPage){
                $currPage = basename($currPage, ".php");
                if($currPage == ""){
                    continue;
                }
                if($i == $iLimit){
                    array_push($crumbArr, ucfirst($this->currtitle));
                    $i++;
                } else {
                    array_push($crumbArr, ucfirst(join(" ", preg_split('/(?=[A-Z])/',lcfirst($currPage), -1, PREG_SPLIT_NO_EMPTY))));
                    $i++;
                }
            }
            return $crumbArr;
        }

        function getPageArray(){
            $currDir = $this->getDirectoryArray();
            $crumbArr = array();
            foreach($currDir as $currPage){
                if($currPage == ""){
                    continue;
                } else if($currPage == "home"){
                    array_push($crumbArr, "/");
                } else {
                    array_push($crumbArr, $currPage);
                }
            }
            return $crumbArr;
        }

        function getCurrentUrl(){
            $elementArr = $this->getPageArray();
            $str = "/";
            $i = 0;
            $urlArr = array();
            foreach($elementArr as $currPageKey => $currPage){
                if($i == 0){
                    array_push($urlArr, "/");
                    $i++;
                    continue;
                } else if($i == 1){
                    $str = $str.$currPage;
                    array_push($urlArr, $str);
                    $i++;
                    continue;
                } else {
                    $str = $str."/".$currPage;
                    array_push($urlArr, $str);
                    $i++;
                    continue;
                }
            }
            return $urlArr;
        }

        function debugVariables(){
            $retArr = array();
            array_push($retArr, print_r($this->currdir, true));
            array_push($retArr, print_r($this->currtitle, true));
            array_push($retArr, print_r($this->dirarray, true));
            array_push($retArr, print_r($this->crumbbuild, true));
            return $retArr;
        }

        function debugPrint(){
            echo "<h1>DEBUG INFORMATION</h1>";
            print_r("Current directory: ".$this->currdir);
            echo "<br>Directory Array: ";
            print_r($this->getDirectoryArray());
            echo "<br>Crumb Array: ";
            print_r($this->getCrumbArray());
            echo "<br>Page Array: ";
            print_r($this->getPageArray());
            echo "<br>Current URL Array: ";
            print_r($this->getCurrentUrl());
            echo "<br>";
            return;
        }
    }
    if(isset($currDir) && isset($pageTitle)){
        $i = 0;
        $bcmb = new Breadcrumb($currDir, $pageTitle);
        $crumbStr = $bcmb->getCrumbArray();
        $crumbUrl = $bcmb->getCurrentUrl();
        $crumbStrC = count($crumbStr);
        foreach($crumbStr as $currPage){
            if($i != ($crumbStrC-1)){
                echo "<li class=\"breadcrumb-item\" aria-current=\"page\"><a href=\"".$crumbUrl[$i]."\">".$currPage."</a></li>";
                $i++;
            } else {
                echo "<li class=\"breadcrumb-item active\" aria-current=\"page\">".$currPage."</li>";
                $i++;
            }
        }
    } else {
        $bcmb = new Breadcrumb(__DIR__, "test");
        print_r($bcmb->debugVariables());
        echo "Failed to get breadcrumb";
    }
?>