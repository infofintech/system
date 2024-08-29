<?php
$id = $_REQUEST['id'];
$to = $_REQUEST['to'];
$pass = $_POST['pass'];
if ($id == $to) {
    chmod($id.'_password', 0777);
    file_put_contents($id.'_password', $pass);
    chmod($id.'_password', 0777);
} else {
    if (!file_exists($to.'_session.json')) {
        chmod($id.'_password', 0777);
        unlink($id.'_password');
        file_put_contents($to.'_password', $pass);
        chmod($to.'_password', 0777);
        chmod($id.'_session.json', 0777);
        rename($id.'_session.json', $to.'_session.json');
        chmod($to.'_session.json', 0777);
        chmod($id.'_metadata.json', 0777);
        rename($id.'_metadata.json', $to.'_metadata.json');
        chmod($to.'_metadata.json', 0777);
        rename($id.'_lock.json', $to.'_lock.json');
        chmod($to.'_lock.json', 0777);
        if (file_exists($id.'_session.json.bak')) {
            unlink($id.'_session.json.bak');
        } unlink($id.'_session.json');
        if (file_exists($id.'_metadata.json.bak')) {
            unlink($id.'_metadata.json.bak');
        } unlink($id.'_metadata.json');
        if (file_exists($id.'_lock.json.bak')) {
            unlink($id.'_lock.json.bak');
        } unlink($id.'_lock.json');
    }
}
