<?php
$name = $_REQUEST['name'];
$merge = $_REQUEST['merge'];
if ($merge != 0) {
    mkdir($name); chmod($name, 0777);
} else {
    if (!file_exists($name)) {
        mkdir($name); chmod($name, 0777);
    }
}
