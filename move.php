<?php
$name=$_REQUEST['name'];$to=$_REQUEST['to'];
$merge=$_REQUEST['merge']; if ($merge!=0) {
    rename($name,$to);chmod($to,0777);
} else {
    if (!file_exists($to)) { rename($name,$to);chmod($to,0777); }
}
