<?php
class populate {
    private $output = array();
    
    /*
     * The files function takes care of testing 
     * and returning all available files.
     */
    public function files() {
        $file = '../project';
        
        $this->output = array();
        $this->addFile($file);
        
        return $this->output;
    }
    
    /*
     * Recursively add files to output.
     */
    private function addFile($source) {
        $dir = opendir($source);
        while(($file = readdir($dir)) !== false) {
            if(($file != '.') && ($file != '..')) {
                if(is_dir($source . '/' . $file)) {
                    $this->addFile($source . '/' . $file);
                } else {
                    array_push($this->output, substr($source . '/' . $file, 10));
                }
            }
        }
        closedir($dir);
    }
    
    /*
     * The folders function takes care of testing 
     * and returning all available folders.
     */
    public function folders() {
        $file = '../project';
        
        $this->output = array();
        $this->addFolder($file);
        
        return $this->output;
    }
    
    /*
     * Recursively add folders to output.
     */
    private function addFolder($source) {
        $dir = opendir($source);
        while(($file = readdir($dir)) !== false) {
            if(($file != '.') && ($file != '..')) {
                if(is_dir($source . '/' . $file)) {
                    array_push($this->output, substr($source . '/' . $file . '/', 10));
                    $this->addFolder($source . '/' . $file);
                } else {
                    
                }
            }
        }
        closedir($dir);
    }
    
    /*
     * The bad function checks for certain files / directories
     * and removes themo from the list.
     */
    public function bad($loc) {
        if(is_dir($loc)) {
            $contents = scandir($loc);
            $bad = array('.', '..');
            return array_diff($contents, $bad);
        }
    }
}