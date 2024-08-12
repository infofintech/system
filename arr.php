<?php
$name = $_REQUEST['name']; $oper = $_REQUEST['oper'];
$path = $_REQUEST['path']; $val = $_REQUEST['val'];
$jf = (@json_decode(file_get_contents($name), true) != null) ? json_decode(file_get_contents($name), true) : [];
if (($oper == 'create') || ($oper == 'update') || ($oper == 'alter') || ($oper == 'touch') || ($oper == 'make') || ($oper == 'add') || ($oper == '+')) {
    if (strpos($path, '/') !== false) {
        $nodes = explode('/', $path);
        $temp = &$jf;
        foreach ($nodes as $key) {
            $temp = &$temp[$key];
        } $temp = $val; $res = $jf;
    } elseif (strpos($path, '\\') !== false) {
        $nodes = explode('\\', $path);
        $temp = &$jf;
        foreach ($nodes as $key) {
            $temp = &$temp[$key];
        } $temp = $val; $res = $jf;
    } else {
        if (!(isset($jf[$path]))) {
            $jf[$path] = $val;
        } $res = $jf;
    }
} elseif (($oper == 'remove') || ($oper == 'delete') || ($oper == 'drop') || ($oper == 'del') || ($oper == 'rm') || ($oper == '-')) {
    if (strpos($path, '/') !== false) {
        $nodes = explode('/', $path);
        $prevEl = NULL; $el = &$jf;
        foreach ($nodes as &$node) {
            $prevEl = &$el; $el = &$el[$node];
        } if ($prevEl !== NULL) {
            unset($prevEl[$node]);
        } $res = $jf;
    } elseif (strpos($path, '\\') !== false) {
        $nodes = explode('\\', $path);
        $prevEl = NULL; $el = &$jf;
        foreach ($nodes as &$node) {
            $prevEl = &$el; $el = &$el[$node];
        } if ($prevEl !== NULL) {
            unset($prevEl[$node]);
        } $res = $jf;
    } else {
        if (isset($jf[$path])) {
            unset($jf[$path]);
        } $res = $jf;
    }
} else if (($oper == 'clear') || ($oper == 'erase') || ($oper == 'purge') || ($oper == '~')) {
    $res = [ "" => "" ];
} file_put_contents($name, json_encode($res));
chmod($name, 0777);