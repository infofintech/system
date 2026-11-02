<?php
function copyFile($name,$dest) {
    if ((is_dir($name))&&(!is_link($name))) {
        exec('cp -vr "'.$name.'" "'.$dest.'"');
        exec('chmod -vR 777 "'.$dest.'"');
    } else { copy($name,$dest); chmod($dest,0777); }
}
$name=(isset($_REQUEST['name']))?$_REQUEST['name']:'';
$dest=(isset($_REQUEST['dest']))?$_REQUEST['dest']:'';
$attr=(isset($_REQUEST['attr']))?$_REQUEST['attr']:'';
if ($attr!='') {
    if (preg_match('/admin|root|rw/i',$attr)) {
	copyFile($name,$dest);
    } else {
        if (file_exists($dest)) {
            if ((str_starts_with(basename($name),$attr.'_'))||(str_starts_with($name,$attr.'_files/'))||(str_starts_with($name,'./'.$attr.'_files/'))||(str_starts_with(basename($name),'_'))) {
                copyFile($name,$dest);
            }
        } else { copyFile($name,$dest); }
    }
}
