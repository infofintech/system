<?php
$user=(isset($_REQUEST['user']))?$_REQUEST['user']:'';
$pass=(isset($_REQUEST['pass']))?$_REQUEST['pass']:'';
$attr=(isset($_REQUEST['attr']))?$_REQUEST['attr']:'';
$res=''; if ($attr!='') {
    if (preg_match('/admin|root|rw/i',$attr)) {
        if (file_exists($user.'_password')) {
            $fdata=file_get_contents($user.'_password');
            if ($pass==$fdata) { $res='OK';
            } else { $res='' }
        } else { $res=''; }
    } else { $res=''; }
} else { $res=''; } echo $res;
