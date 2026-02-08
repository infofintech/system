<?php
$name=(isset($_REQUEST['name']))?$_REQUEST['name']:'';
$mode=(isset($_REQUEST['mode']))?$_REQUEST['mode']:'';
$attr=(isset($_REQUEST['attr']))?$_REQUEST['attr']:'';
if (attr!='') {
    if (preg_match('/admin|root|rw/i',$attr)) {
        if ((is_dir($name))&&(!is_link($name))) {
            exec('chmod -vR "'.octdec($mode).'" "'.$name.'"');
        } else {
            chmod($name,octdec($mode));
        }
    } else {
        if ((is_dir($name))&&(!is_link($name))) {
            if (str_starts_with($name,'./'.$attr.'_files/')) {
                exec('chmod -vR "'.octdec($mode).'" "'.$name.'"');
            }
        } else {
            if (str_starts_with($name,'./'.$attr.'_files/')) {
                chmod($name,octdec($mode));
            }
        }
    }
}
