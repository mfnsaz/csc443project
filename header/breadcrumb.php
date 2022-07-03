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
            foreach($currDir as $currPage){
                if($currPage == ""){
                    continue;
                }
                array_push($crumbArr, ucfirst(preg_replace("/^.*\.(php)$/im", $this->currtitle, $currPage)));
            }
            return $crumbArr;
        }

        function getPageArray(){
            $currDir = $this->getDirectoryArray();
            $crumbArr = array();
            foreach($currDir as $currPage){
                if($currPage == ""){
                    continue;
                }
                array_push($crumbArr, $currPage);
            }
            return $crumbArr;
        }

        function getCurrentUrl(){
            $elementArr = $this->getPageArray();
            $i = 0;
            $urlArr = array();
            foreach($elementArr as $currPage){
                if($i > 2) {
                    array_push($urlArr, $urlArr[$i-1]."/".$currPage);
                    $i++;
                    continue;
                } else if($i == 2) {
                    array_push($urlArr, $currPage);
                    $i++;
                    continue;
                } else {
                    array_push($urlArr, "/");
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
            array_push($retArr, print_r($this->crumbhtml, true));
            return $retArr;
        }
    }
    if(isset($currDir) && isset($pageTitle) && isset($pageTitle)){
        $i = 0;
        $bcmb = new Breadcrumb($currDir, $pageTitle);
        $crumbStr = $bcmb->getCrumbArray();
        $crumbUrl = $bcmb->getCurrentUrl();
        $crumbStrC = count($crumbStr);
        foreach($crumbStr as $currPage){
            if(++$i != $crumbStrC){
                echo "<li class=\"breadcrumb-item\" aria-current=\"page\"><a href=\"".$crumbUrl[$i]."\">".$currPage."</a></li>";
            } else {
                echo "<li class=\"breadcrumb-item active\" aria-current=\"page\">".$currPage."</li>";
            }
        }
    } else {
        $bcmb = new Breadcrumb(__DIR__, "test");
        print_r($bcmb->debugVariables());
        echo "Failed to get breadcrumb";
    }
?>