<?php
$name = (isset($_REQUEST['name'])) ? $_REQUEST['name'] : '';
$type = (isset($_REQUEST['type'])) ? $_REQUEST['type'] : '';
$sign = (isset($_REQUEST['sign'])) ? $_REQUEST['sign'] : '';
$mode = (isset($_REQUEST['mode'])) ? $_REQUEST['mode'] : '';
if (file_exists($name)) {
    chmod($name, 0777);
    $prep = file_get_contents($name);
    if ($mode == 'multiline') {
        $str = $prep; $res = $str;
    } else {
        $str = (is_int($mode)) ? preg_split("/\r\n|\n|\r/", $prep)[$mode] : $prep;
    } $res = ($type == 'number') ? intval($str) : $str;
} else {
    $res = ($type == 'number') ? intval($sign) : $sign;
} echo $res;