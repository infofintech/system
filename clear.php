<?php
exec('chmod -R 777 .');
$dir = ($_REQUEST['id'] != '') ? $_REQUEST['id'] : 'news';
$index = str_replace('./.'.$dir.'/','',(glob('./.'.$dir.'/*')));
foreach ($index as $key=>$value) {
    if (file_exists('./.'.$dir.'/'.$log)) {
        chmod('./.'.$dir.'/'.$log, 0777);
        unlink('./.'.$dir.'/'.$log);
    }
}
