<?php
$name = $_REQUEST['name'];
$type = $_REQUEST['type'];
$sign = $_REQUEST['sign'];
$mode = $_REQUEST['mode'];
if (file_exists($name)) {
    chmod($name, 0777);
    $prep = file_get_contents($name);
    if ($mode == 'multiline') {
        $str = $prep; $res = $str;
    } else {
        $str = preg_split("/\r\n|\n|\r/", $prep)[0];
        $res = ($type == 'number') ? intval($str) : $str;
    }
} else {
    $res = ($type == 'number') ? intval($sign) : $sign;
} echo $res;