<?php
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
            if (file_exists($repo)) {
                exec('chmod -R 777 .'); exec('rm -rf '.$repo);
            } if ($branch != '') {
                exec('git clone -b '.$branch.' '.$host.'/'.$user.'/'.$repo);
            } else {
                exec('git clone '.$host.'/'.$user.'/'.$repo);
            } chmod($repo, 0777); exec('chmod -R 777 .');
        }
    }
} elseif ($action == 'r' || $action == 'p' || $action == 'm') {
    if ($pkg != "" && $repo != "" && $user != "") {
        if (file_exists($pkg)) { exec('chmod -R 777 .'); exec('rm -rf '.$pkg); }
        header('Location: getdir.php?key=i&host='.$host.'&pkg=from&repo='.$repo.'&branch='.$branch.'&user='.$user);
    }
} elseif ($action == 'd' || $action == 'u' || $action == 'x') {
    if ($pkg != "" && $repo == 'from' && $user == 'here') {
        if (file_exists($pkg)) { exec('chmod -R 777 .'); exec('rm -rf '.$pkg); }
    }
}
