<?php
function makeDirectory($name) {
    if ((is_dir($name))&&(!is_link($name))) {
        exec('mkdir -p "'.$name.'"');
        exec('chmod -vR 777 "'.$name.'"');
    } else { mkdir($name); chmod($name,0777); }
}
$name=(isset($_REQUEST['name']))?$_REQUEST['name']:'';
$attr=(isset($_REQUEST['attr']))?$_REQUEST['attr']:'';
if ($attr!='') {
    if (preg_match('/admin|root|rw/i',$attr)) {
        makeDirectory($name);
    } else {
        if (file_exists($name)) {
            if ((str_starts_with(basename($name),$attr.'_'))||(str_starts_with($name,$attr.'_files/'))||(str_starts_with($name,'./'.$attr.'_files/'))||(str_starts_with(basename($name),'_'))) {
                makeDirectory($name);
            }
        } else { makeDirectory($name); }
    }
}
