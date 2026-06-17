<?php
function deleteFile($name) {
    if ((is_dir($name))&&(!is_link($name))) {
        exec('chmod -vR 777 "'.$name.'"');
        exec('rm -vr "'.$name.'"');
    } else { chmod($name,0777); unlink($name); }
}
$name=(isset($_REQUEST['name']))?$_REQUEST['name']:'';
$attr=(isset($_REQUEST['attr']))?$_REQUEST['attr']:'';
if ($attr!='') {
    if (preg_match('/admin|root|rw/i',$attr)) {
        deleteFile($name);
    } else {
        if (file_exists($name)) {
            if ((str_starts_with(basename($name),$attr.'_'))||(str_starts_with($name,$attr.'_files/'))||(str_starts_with($name,'./'.$attr.'_files/'))||(str_starts_with(basename($name),'_'))) {
                deleteFile($name);
            }
        }
    }
}
