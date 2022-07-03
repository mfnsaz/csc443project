<?php
    class Breadcrumb {
        private $currdir;
        private $currtitle;
        private $dirarray;
        private $crumbhtml;
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
        echo $bcmb->getFullCrumb();
    }
?>