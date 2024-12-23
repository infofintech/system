<?php
$action = (isset($_REQUEST['action'])) ? $_REQUEST['action'] : 'i';
$raw = (isset($_REQUEST['raw'])) ? $_REQUEST['raw'] : 0;
$host = (isset($_REQUEST['host'])) ? $_REQUEST['host'] : 'https://github.com';
$pkg = (isset($_REQUEST['pkg'])) ? $_REQUEST['pkg'] : 'from';
$repo = (isset($_REQUEST['repo'])) ? $_REQUEST['repo'] : 'system';
$branch = (isset($_REQUEST['branch'])) ? $_REQUEST['branch'] : '';
$user = (isset($_REQUEST['user'])) ? $_REQUEST['user'] : 'infofintech';
if (!file_exists('get.lock')) {
    if (($action == 'i') || ($action == 's') || ($action == 'o')) {
        $hostArr = explode('://', $host);
        file_put_contents('get.lock', ''); chmod('get.lock', 0777);
        $fsockopen = fsockopen($hostArr[1], 80, $errno, $errstr, 10);
        if ($fsockopen != false) {
            if ($raw != 0) {
                if ((file_exists($pkg)) && (is_dir($pkg)) && ($pkg != '')) {
                    exec('chmod -R 777 .'); exec('rm -rf '.$repo);
                } if ($branch != '') {
                    exec('git clone -b '.$branch.' '.$host.'/'.$user.'/'.$repo);
                } else {
                    exec('git clone '.$host.'/'.$user.'/'.$repo);
                } chmod($repo, 0777); exec('chmod -R 777 .');
            } else {
                $fileback = str_replace('./','',(glob('./*.txt')));
                foreach ($fileback as $key=>$file) {
                    if (file_exists($file)) {
                        chmod($file, 0777); rename($file, $file.'.bak');
                        chmod($file.'.bak', 0777);
                    }
                }
                if ((file_exists($repo.'.pkg')) && (@json_decode(file_get_contents($repo.'.pkg'), true) != null)) {
                    $package = json_decode(file_get_contents($repo.'.pkg'), true);
                    $files = explode(';', $package['files']);
                    foreach ($files as $key=>$file) {
                        if (file_exists($file)) { chmod($file, 0777); unlink($file); }
                    } chmod($repo.'.pkg', 0777); unlink($repo.'.pkg');
                } if (file_exists($repo)) {
                    chmod($repo, 0777); rename($repo, $repo.'.d');
                } if ($branch != '') {
                    exec('git clone -b '.$branch.' '.$host.'/'.$user.'/'.$repo);
                } else {
                    exec('git clone '.$host.'/'.$user.'/'.$repo);
                } chmod($repo, 0777); exec('mv '.$repo.'/* $PWD');
                exec('chmod -R 777 .'); exec('rm -rf '.$repo);
                if (file_exists($repo.'.d')) {
                    chmod($repo.'.d', 0777); rename($repo.'.d', $repo);
                } $filepass = str_replace('./','',(glob('./*.md')));
                foreach ($filepass as $key=>$file) {
                    if (file_exists($file)) { chmod($file, 0777); unlink($file); }
                } $filerest = str_replace('./','',(glob('./*.txt.bak')));
                foreach ($filerest as $key=>$file) {
                    if (file_exists($file)) {
                        chmod($file, 0777);
                        rename($file, str_replace('.txt.bak', '.txt', $file));
                        chmod(str_replace('.txt.bak', '.txt', $file), 0777);
                    }
                }
            }
        } chmod('get.lock', 0777); unlink('get.lock');
    } elseif (($action == 'r') || ($action == 'p') || ($action == 'm')) {
        if ($raw != 0) {
            if ((file_exists($pkg)) && (is_dir($pkg)) && ($pkg != '')) {
                exec('chmod -R 777 .'); exec('rm -rf '.$pkg);
            }
        } else {
            if ((file_exists($pkg.'.pkg')) && (@json_decode(file_get_contents($pkg.'.pkg'), true) != null)) {
                $package = json_decode(file_get_contents($pkg.'.pkg'), true);
                $list = $package['files']; $files = explode(";", $list);
                foreach ($files as $key=>$file) {
                    if (file_exists($file)) { chmod($file, 0777); unlink($file); }
                } chmod($pkg.'.pkg', 0777); unlink($pkg.'.pkg');
            }
        } header('Location: get.php?action=i&raw='.$raw.'&host='.$host.'&pkg=from&repo='.$repo.'&branch='.$branch.'&user='.$user);
    } elseif (($action == 'd') || ($action == 'u') || ($action == 'x')) {
        if ($raw != 0) {
            if ((file_exists($pkg)) && (is_dir($pkg)) && ($pkg != '')) {
                exec('chmod -R 777 .'); exec('rm -rf '.$pkg);
            }
        } else {
            if ((file_exists($pkg.'.pkg')) && (@json_decode(file_get_contents($pkg.'.pkg'), true) != null)) {
                $package = json_decode(file_get_contents($pkg.'.pkg'), true);
                $list = $package['files']; $files = explode(";", $list);
                foreach ($files as $key=>$file) {
                    if (file_exists($file)) { chmod($file, 0777); unlink($file); }
                } chmod($pkg.'.pkg', 0777); unlink($pkg.'.pkg');
            }
        }
    }
}