<?php
$name = $_REQUEST['name'];
if ((file_exists('./.trash')) && (is_dir('./.trash'))) {
    $hex = bin2hex(file_get_contents($name));
    $arr = [ 'name' => $name, 'hex' => $hex ];
    file_put_contents('./.trash/'.date('YmdHis').'_fragment.json', json_encode($arr)); chmod('./.trash/'.date('YmdHis').'_fragment.json', 0777);
    chmod($name, 0777); unlink($name);
}