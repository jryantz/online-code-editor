<?php
class recurse {
    function r_copy($source, $destination) {
        $dir = opendir($source);
        mkdir($destination);
        while(($file = readdir($dir)) !== false) {
            if(($file != '.') && ($file != '..')) {
                if(is_dir($source . '/' . $file)) {
                    $this->r_copy($source . '/' . $file, $destination . '/' . $file);
                } else {
                    copy($source . '/' . $file, $destination . '/' . $file);
                }
            }
        }
        closedir($dir);
    }
    
    function r_delete($dir) {
        if(is_dir($dir)) {
            $objects = scandir($dir);
                foreach($objects as $object) {
                    if($object != '.' && $object != '..') {
                        if(filetype($dir . '/' . $object) == "dir") {
                            $this->r_delete($dir . '/' . $object);
                        } else {
                            unlink($dir . '/' . $object);
                        }
                    }
                }
            reset($objects);
            rmdir($dir);
        } else {
            unlink($dir);
        }
    }
}