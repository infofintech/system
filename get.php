<?php
$action=(isset($_REQUEST['action']))?$_REQUEST['action']:'i';
$attr=(isset($_REQUEST['attr']))?$_REQUEST['attr']:'';
$host=(isset($_REQUEST['host']))?$_REQUEST['host']:'https://github.com'; $pkg=(isset($_REQUEST['pkg']))?$_REQUEST['pkg']:'from';
$repo=(isset($_REQUEST['repo']))?$_REQUEST['repo']:'system';
$branch=(isset($_REQUEST['branch']))?$_REQUEST['branch']:'';
$user=(isset($_REQUEST['user']))?$_REQUEST['user']:'infofintech';
if (!file_exists('get.lock')) {
    if (($action=='i')||($action=='s')||($action=='o')) {
        $hostArr=explode('://',$host);
        file_put_contents('get.lock',''); chmod('get.lock',0777);
        $fsockopen=fsockopen($hostArr[1],80,$errno,$errstr,10);
        if ($fsockopen!=false) {
            if (preg_match('/raw/i',$attr)) {
                exec('chmod -vR 777 .'); exec('rm -vr '.$repo);
                if ($branch!='') {
                    exec('git clone -b '.$branch.' '.$host.'/'.$user.'/'.$repo);
                } else {
                    exec('git clone '.$host.'/'.$user.'/'.$repo);
                } chmod($repo,0777);
            } else {
                $fileback=str_replace('./','',(glob('./*.txt')));
                foreach ($fileback as $file) {
                    if (file_exists($file)) {
                        chmod($file,0777);
                        rename($file,$file.'.bak');
                        chmod($file.'.bak',0777);
                    }
                } if (file_exists($repo.'.pkg')) {
                    $package=(@json_decode(file_get_contents($repo.'.pkg'),true)!=null)?json_decode(file_get_contents($repo.'.pkg'),true):['files'=>''];
                    $files=explode(';',$package['files']);
                    foreach ($files as $file) {
                        if (file_exists($file)) {
                            chmod($file,0777); unlink($file);
                        }
                    } chmod($repo.'.pkg',0777); unlink($repo.'.pkg');
                } if (file_exists($repo)) {
                    chmod($repo,0777); rename($repo,$repo.'.d');
                } if ($branch!='') {
                    exec('git clone -b '.$branch.' '.$host.'/'.$user.'/'.$repo);
                } else {
                    exec('git clone '.$host.'/'.$user.'/'.$repo);
                } chmod($repo,0777); exec('mv '.$repo.'/* $PWD');
                exec('chmod -vR 777 .'); exec('rm -vr '.$repo);
                if (file_exists($repo.'.d')) {
                    chmod($repo.'.d',0777); rename($repo.'.d',$repo);
                } $filepass=str_replace('./','',(glob('./*.md')));
                foreach ($filepass as $file) {
                    if (file_exists($file)) {
                        chmod($file,0777); rename($file,$repo.'.md');
                        chmod($repo.'.md',0777);
                    }
                } $filerest=str_replace('./','',(glob('./*.txt.bak'))); foreach ($filerest as $file) {
                    if (file_exists($file)) {
                        chmod($file,0777);
                        $newfile=str_replace('.txt.bak','.txt',$file);
                        rename($file,$newfile); chmod($newfile,0777);
                    }
                }
            }
        } chmod('get.lock',0777); unlink('get.lock');
    } elseif (($action=='r')||($action=='p')||($action=='m')) {
        if (preg_match('/raw/i',$attr)) {
            exec('chmod -vR 777 .'); exec('rm -vr '.$pkg);
        } else {
            if (file_exists($pkg.'.pkg')) {
                $package=(@json_decode(file_get_contents($pkg.'.pkg'),true)!=null)?json_decode(file_get_contents($pkg.'.pkg'),true):['files'=>'']; $files=explode(';',$package['files']);
                foreach ($files as $file) {
                    if (file_exists($file)) {
                        chmod($file,0777); unlink($file);
                    }
                } chmod($pkg.'.pkg',0777); unlink($pkg.'.pkg');
            }
        }
        header('Location: get.php?action=i&raw='.$raw.'&host='.$host.'&pkg=from&repo='.$repo.'&branch='.$branch.'&user='.$user);
    } elseif (($action=='d')||($action=='u')||($action=='x')) {
        if (preg_match('/raw/i',$attr)) {
             exec('chmod -vR 777 .'); exec('rm -vr '.$pkg);
        } else {
            if (file_exists($pkg.'.pkg')) {
                $package=(@json_decode(file_get_contents($pkg.'.pkg'),true)!=null)?json_decode(file_get_contents($pkg.'.pkg'),true):['files'=>'']; $files=explode(';',$package['files']);
                foreach ($files as $file) {
                    if (file_exists($file)) {
                        chmod($file,0777); unlink($file);
                    }
                } chmod($pkg.'.pkg',0777); unlink($pkg.'.pkg');
            }
        }
    }
}
