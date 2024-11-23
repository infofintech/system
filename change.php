<?php
function preventProfileRewrite($from, $to) {
    return (file_exists($from) && ((!file_exists($to)) || (json_decode(file_get_contents($to), true) == null) || (file_get_contents($to) == '{}') || (file_get_contents($to) == '{"":""}')));
} $id = $_REQUEST['id']; $to = $_REQUEST['to'];
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
        $ij = './.'.$val.'/'.$id.'_'.$val.'.json.bak';
        $tj = './.'.$val.'/'.$to.'_'.$val.'.json.bak';
        if (preventProfileRewrite($ij, $tj)) {
            chmod($ij, 0777); rename($ij, $tj); chmod($tj, 0777);
        } $ij = './.'.$val.'/'.$id.'_'.$val.'.json';
        $tj = './.'.$val.'/'.$to.'_'.$val.'.json';
        if (preventProfileRewrite($ij, $tj)) {
            chmod($ij, 0777); rename($ij, $tj); chmod($tj, 0777);
        }
    } foreach ($removal as $val) {
        $ij = $id.'_'.$val.'.json.bak'; $tj = $to.'_'.$val.'.json.bak';
        if (preventProfileRewrite($ij, $tj)) {
            chmod($ij, 0777); rename($ij, $tj); chmod($tj, 0777);
        } $ij = $id.'_'.$val.'.json'; $tj = $to.'_'.$val.'.json';
        if (preventProfileRewrite($ij, $tj)) {
            chmod($ij, 0777); rename($ij, $tj); chmod($tj, 0777);
        }
    }
}
