<?php
function moveFile($name,$dest) {
    if ((is_dir($name))&&(!is_link($name))) {
        exec('mv -v "'.$name.'" "'.$dest.'"');
        exec('chmod -vR 777 "'.$dest.'"');
    } else { rename($name,$dest); chmod($dest,0777); }
}
$name=(isset($_REQUEST['name']))?$_REQUEST['name']:'';
$dest=(isset($_REQUEST['dest']))?$_REQUEST['dest']:'';
$attr=(isset($_REQUEST['attr']))?$_REQUEST['attr']:'';
if ($attr!='') {
    if (preg_match('/admin|root|rw/i',$attr)) {
        moveFile($name,$dest);
    } else {
        if (file_exists($dest)) {
            if ((str_starts_with(basename($name),$attr.'_'))||(str_starts_with($name,$attr.'_files/'))||(str_starts_with($name,'./'.$attr.'_files/'))||(str_starts_with(basename($name),'_'))) {
                moveFile($name,$dest);
            }
        } else { moveFile($name,$dest); }
    }
}
