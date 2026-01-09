<?php
$action=(isset($_REQUEST['action']))?$_REQUEST['action']:'i';
$attr=(isset($_REQUEST['attr']))?$_REQUEST['attr']:'';
$url=(isset($_REQUEST['url']))?$_REQUEST['url']:'';
$pkg=(isset($_REQUEST['pkg']))?$_REQUEST['pkg']:'';
$branch=(isset($_REQUEST['branch']))?$_REQUEST['branch']:'';
if (!file_exists('get.lock')) {
    if (($action=='i')||($action=='s')||($action=='o')) {
	    $urlPart=parse_url($url);
	    $urlEndPt=array_reverse(explode('/',$urlPart['path']))[0];
        file_put_contents('get.lock',''); chmod('get.lock',0777);
        $fsockopen=fsockopen($urlPart['host'],80,$errno,$errstr,10);
        if ($fsockopen!=false) {
            if (preg_match('/raw/i',$attr)) {
                exec('chmod -vR 777 .'); exec('rm -vr '.$urlEndPt);
                exec('git clone '.(($branch!='')?('-b '.$branch.' '):'').$url);
                chmod($urlEndPt,0777);
            } else {
                if (file_exists($urlEndPt.'.package.json')) {
                    $package=(@json_decode(file_get_contents($urlEndPt.'.package.json'),true)!=null)?json_decode(file_get_contents($urlEndPt.'.package.json'),true):['files'=>''];
                    $files=explode(';',$package['files']);
                    foreach ($files as $file) {
                        if (file_exists($file)) {
                            chmod($file,0777); unlink($file);
                        }
                    } chmod($urlEndPt.'.package.json',0777); unlink($urlEndPt.'.package.json');
                } if (file_exists($urlEndPt)) {
                    chmod($urlEndPt,0777); rename($urlEndPt,$urlEndPt.'-backup');
                } exec('git clone '.(($branch!='')?('-b '.$branch.' '):'').$url);
                chmod($urlEndPt,0777); exec('mv '.$urlEndPt.'/* $PWD');
                exec('chmod -vR 777 .'); exec('rm -vr '.$urlEndPt);
                if (file_exists($urlEndPt.'-backup')) {
                    chmod($urlEndPt.'-backup',0777); rename($urlEndPt.'-backup',$urlEndPt);
                }
            }
        } chmod('get.lock',0777); unlink('get.lock');
    } elseif (($action=='r')||($action=='p')||($action=='m')) {
        if (preg_match('/raw/i',$attr)) {
            exec('chmod -vR 777 .'); exec('rm -vr '.$pkg);
        } else {
            if (file_exists($pkg.'.package.json')) {
                $package=(@json_decode(file_get_contents($pkg.'.package.json'),true)!=null)?json_decode(file_get_contents($pkg.'.package.json'),true):['files'=>'']; $files=explode(';',$package['files']);
                foreach ($files as $file) {
                    if (file_exists($file)) {
                        chmod($file,0777); unlink($file);
                    }
                } chmod($pkg.'.package.json',0777); unlink($pkg.'.package.json');
            }
        }
        header('Location: get.php?action=i&attr='.$attr.'&url='.$url.'&pkg=&branch='.$branch.'&user='.$user);
    } elseif (($action=='d')||($action=='u')||($action=='x')) {
        if (preg_match('/raw/i',$attr)) {
             exec('chmod -vR 777 .'); exec('rm -vr '.$pkg);
        } else {
            if (file_exists($pkg.'.package.json')) {
                $package=(@json_decode(file_get_contents($pkg.'.package.json'),true)!=null)?json_decode(file_get_contents($pkg.'.package.json'),true):['files'=>'']; $files=explode(';',$package['files']);
                foreach ($files as $file) {
                    if (file_exists($file)) {
                        chmod($file,0777); unlink($file);
                    }
                } chmod($pkg.'.package.json',0777); unlink($pkg.'.package.json');
            }
        }
    }
}
