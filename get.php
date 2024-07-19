<?php
function parseArrayFile($name): array {
    $arr = explode('|[1]|', (file_get_contents($name)));
    $obj = []; foreach ($arr as $line) {
        $obj[explode('|[>]|', $line)[0]] = explode('|[>]|', $line)[1];
    } return $obj;
}
$action = (isset($_REQUEST['action'])) ? $_REQUEST['action'] : 'i';
$host = (isset($_REQUEST['host'])) ? $_REQUEST['host'] : 'https://github.com';
$pkg = (isset($_REQUEST['pkg'])) ? $_REQUEST['pkg'] : 'from';
$repo = (isset($_REQUEST['repo'])) ? $_REQUEST['repo'] : 'system';
$branch = (isset($_REQUEST['branch'])) ? $_REQUEST['branch'] : '';
$user = (isset($_REQUEST['user'])) ? $_REQUEST['user'] : 'infofintech';
if ($action == 'i' || $action == 's' || $action == 'o') {
    if ($pkg == "from" && $repo != "" && $user != "") {
        $hostArr = explode('://', $host);
        $fsockopen = fsockopen($hostArr[1], 80, $errno, $errstr, 10);
        if ($fsockopen != false) {
            $fileback = str_replace('./','',(glob('./*.txt')));
            foreach ($fileback as $key=>$file) {
                if (file_exists($file)) {
                    chmod($file, 0777);
                    rename($file, $file.'.bak');
                    chmod($file.'.bak', 0777);
                }
            }
            if (file_exists($repo.'.pkg')) {
                $package = parseArrayFile($repo.'.pkg');
                $files = explode(';', $package['files']);
                foreach ($files as $key=>$file) {
                    if (file_exists($file)) {
                        chmod($file, 0777); unlink($file);
                    }
                } chmod($repo.'.pkg', 0777); unlink($repo.'.pkg');
            }
            if (file_exists($repo)) {
                chmod($repo, 0777); rename($repo, $repo.'.d');
            }
            if ($branch != '') {
                exec('git clone -b '.$branch.' '.$host.'/'.$user.'/'.$repo);
            } else {
                exec('git clone '.$host.'/'.$user.'/'.$repo);
            } chmod($repo, 0777); exec('mv '.$repo.'/* $PWD');
            exec('chmod -R 777 .'); exec('rm -rf '.$repo);
            if (file_exists($repo.'.d')) {
                chmod($repo.'.d', 0777); rename($repo.'.d', $repo);
            }
            $filepass = str_replace('./','',(glob('./*.md')));
            foreach ($filepass as $key=>$file) {
                if (file_exists($file)) {
                    chmod($file, 0777); unlink($file);
                }
            }
            $filerest = str_replace('./','',(glob('./*.txt.bak')));
            foreach ($filerest as $key=>$file) {
                if (file_exists($file)) {
                    chmod($file, 0777);
                    rename($file, str_replace('.txt.bak', '.txt', $file));
                    chmod(str_replace('.txt.bak', '.txt', $file), 0777);
                }
            }
        }
    }
} elseif ($action == 'r' || $action == 'p' || $action == 'm') {
    if ($pkg != "" && $repo != "" && $user != "") {
        if (file_exists($pkg.'.pkg')) {
            $package = parseArrayFile($pkg.'.pkg');
            $list = $package['files'];
            $files = explode(";", $list);
            foreach ($files as $key=>$file) {
                if (file_exists($file)) {
                    chmod($file, 0777);
                    unlink($file);
                }
            }
            chmod($pkg.'.pkg', 0777);
            unlink($pkg.'.pkg');
        }
        header('Location: get.php?action=i&host='.$host.'&pkg=from&repo='.$repo.'&branch='.$branch.'&user='.$user);
    }
} elseif ($action == 'd' || $action == 'u' || $action == 'x') {
    if ($pkg != "" && $repo == 'from' && $user == 'here') {
        if (file_exists($pkg.'.pkg')) {
            $package = parseArrayFile($pkg.'.pkg');
            $list = $package['files'];
            $files = explode(";", $list);
            foreach ($files as $key=>$file) {
                if (file_exists($file)) {
                    chmod($file, 0777);
                    unlink($file);
                }
            }
            chmod($pkg.'.pkg', 0777);
            unlink($pkg.'.pkg');
        }
    }
}
