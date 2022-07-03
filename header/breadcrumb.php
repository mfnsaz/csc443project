<?php
    class Breadcrumb {
        private string $currdir;
        private string $currtitle;
        private array $dirarray;
        private string $crumbhtml;
        function __construct(string $currentDirectory, string $pageTitle) {
            $this->currdir = $currentDirectory;
            if($pageTitle == null){
                $this->currtitle = "";
            } else {
                $this->currtitle = $pageTitle;
            }
            $this->dirarray = explode("/",$this->currdir);
            array_unshift($this->dirarray, "Home");
            array_push($this->disarray, $this->currtitle);
            foreach($this->dirarray as $crumb){
                $this->crumbhtml = ucfirst(str_replace(array(".php","_"),array(""," "),$crumb) . ' ');
            }
        }

        function getFullCrumb(){
            return $this->crumbhtml;
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
    if(isset($currDir) && isset($pageTitle)){
        $bcmb = new Breadcrumb($currDir, $pageTitle);
        $breadOut = $bcmb->getFullCrumb();
        echo $breadOut;
    } else {
        $bcmb = new Breadcrumb(__DIR__, "test");
        print_r($bcmb->debugVariables());
        echo "Failed to get breadcrumb";
    }
?>