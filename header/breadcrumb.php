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
            array_push($this->disarray, $this->currtitle);
            foreach($this->dirarray as $crumb){
                $this->crumbhtml = ucfirst(str_replace(array(".php","_"),array(""," "),$crumb) . ' ');
            }
        }

        function getFullCrumb(){
            return $this->crumbhtml;
        }
    }
    if(isset($currDir) && isset($pageTitle)){
        $bcmb = new Breadcrumb($currDir, $pageTitle);
        $breadOut = $bcmb->getFullCrumb();
        echo $breadOut;
    } else {
        $bcmb = new Breadcrumb(__DIR__, "test");
        print_r($bcmb->getFullCrumb());
        echo "Failed to get breadcrumb";
    }
?>