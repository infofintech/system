<?php
$name=(isset($_REQUEST['name']))?$_REQUEST['name']:'';
$attr=(isset($_REQUEST['attr']))?$_REQUEST['attr']:'';
if ($attr!='') {
    if (preg_match('/admin|root|rw/i',$attr)) {
        if ((is_dir($name))&&(!is_link($name))) {
            exec('chmod -vR 777 "'.$name.'"');
            exec('rm -vr "'.$name.'"');
        } else { chmod($name,0777); unlink($name); }
    } else {
        if (file_exists($name)) {
            if (str_starts_with(basename($name),$attr.'_')) {
                chmod($name,0777); unlink($name);
            } elseif (str_starts_with(basename($name),$attr.'_files/')) {
                chmod($name,0777); unlink($name);
            }
        }
    }
}
