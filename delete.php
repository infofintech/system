<?php
$name=(isset($_REQUEST['name']))?$_REQUEST['name']:'';
$attr=(isset($_REQUEST['attr']))?$_REQUEST['attr']:'';
$mode=(isset($_REQUEST['mode']))?$_REQUEST['mode']:'';
if ($attr!='') {
    if (preg_match('/admin|root|rw/i',$attr)) {
        if ((is_dir($name))&&(!is_link($name))) {
            exec('chmod -vR '.octdec($mode).' "'.$name.'"');
            exec('rm -vr "'.$name.'"');
        } else { chmod($name,octdec($mode)); unlink($name); }
    } else {
        if (file_exists($name)) {
            if (str_starts_with(basename($name),$attr.'_')) {
                chmod($name,octdec($mode)); unlink($name);
            } elseif (str_starts_with(basename($name),$attr.'_files/')) {
                chmod($name,octdec($mode)); unlink($name);
            } elseif (str_starts_with(basename($name),'_')) {
                chmod($name,octdec($mode)); unlink($name);
            }
        }
    }
}
