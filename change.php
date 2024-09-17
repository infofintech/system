<?php
$id = $_REQUEST['id']; $to = $_REQUEST['to'];
$pass = $_POST['pass']; if ($id == $to) {
    chmod($id.'_password', 0777);
    file_put_contents($id.'_password', $pass);
    chmod($id.'_password', 0777);
} else {
    chmod($id.'_password', 0777);
    unlink($id.'_password');
    file_put_contents($to.'_password', $pass);
    chmod($to.'_password', 0777);
    $removal = ['lock','metadata','session'];
    $sublevels = ['store','book','msgbox'];
    foreach ($sublevels as $val) {
        if (file_exists('./.'.$val.'/'.$id.'_'.$val.'.json') && (!file_exists('./.'.$val.'/'.$to.'_'.$val.'.json'))) {
            chmod('./.'.$val.'/'.$id.'_'.$val.'.json', 0777);
            rename('./.'.$val.'/'.$id.'_'.$val.'.json', './.'.$val.'/'.$to.'_'.$val.'.json');
            chmod('./.'.$val.'/'.$to.'_'.$val.'.json', 0777);
        } if (file_exists('./.'.$val.'/'.$id.'_'.$val.'.json.bak')) {
            chmod('./.'.$val.'/'.$id.'_'.$val.'.json.bak', 0777);
            unlink('./.'.$val.'/'.$id.'_'.$val.'.json.bak');
        }
    } foreach ($removal as $val) {
        if (file_exists($id.'_'.$val.'.json') && (!file_exists($to.'_'.$val.'.json'))) {
            chmod($id.'_'.$val.'.json', 0777);
            rename($id.'_'.$val.'.json', $to.'_'.$val.'.json');
            chmod($to.'_'.$val.'.json', 0777);
        } if (file_exists($id.'_'.$val.'.json.bak')) {
            chmod($id.'_'.$val.'.json.bak', 0777);
            unlink($id.'_'.$val.'.json.bak');
        }
    }
}
