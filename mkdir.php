<?php
$name=(isset($_REQUEST['name']))?$_REQUEST['name']:'';
$attr=(isset($_REQUEST['attr']))?$_REQUEST['attr']:'';
$mode=(isset($_REQUEST['mode']))?$_REQUEST['mode']:'';
if ($attr!='') {
    if (preg_match('/admin|root|rw/i',$attr)) {
        mkdir($name); chmod($name,octdec($mode));
    } else {
        if (file_exists($name)) {
            if (str_starts_with(basename($name),$attr.'_')) {
                mkdir($name); chmod($name,octdec($mode));
            } elseif (str_starts_with(basename($name),$attr.'_files/')) {
                mkdir($name); chmod($name,octdec($mode));
            } elseif (str_starts_with(basename($name),'_')) {
                mkdir($name); chmod($name,octdec($mode));
            }
        } else {
            mkdir($name); chmod($name,octdec($mode));
        }
    }
}
