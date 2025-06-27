<?php
$name=(isset($_REQUEST['name']))?$_REQUEST['name']:'';
$attr=(isset($_REQUEST['attr']))?$_REQUEST['attr']:'';
if ($attr!='') {
    if (preg_match('/admin|root|rw/i',$attr)) {
        mkdir($name); chmod($name,0777);
    } else {
        if (file_exists($name)) {
            if (str_starts_with(basename($name),$attr.'_')) {
                mkdir($name); chmod($name,0777);
            }
        } else {
            mkdir($name); chmod($name,0777);
        }
    }
}
