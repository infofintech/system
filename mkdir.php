<?php
$name=(isset($_REQUEST['name']))?$_REQUEST['name']:'foo';
$attr=(isset($_REQUEST['attr']))?$_REQUEST['attr']:'';
if (preg_match('/admin|root|rw/i',$attr)) {
    mkdir($name); chmod($name,0777);
} else {
    if (!file_exists($name)) {
        mkdir($name); chmod($name,0777);
    }
}
