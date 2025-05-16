<?php
$user=(isset($_REQUEST['user']))?$_REQUEST['user']:'';
$pass=(isset($_REQUEST['pass']))?$_REQUEST['pass']:'';
$attr=(isset($_REQUEST['attr']))?$_REQUEST['attr']:'';
if ($attr!='') {
    if (preg_match('/admin|root|rw/i',$attr)) {
        if (file_exists($user.'_password')) {
            $data=file_get_contents($user.'_password');
            if ($pass==$data) { $res='OK';
            } else { $res='' }
        } else { $res=''; }
    } else { $res=''; }
} else { $res=''; } echo $res;
