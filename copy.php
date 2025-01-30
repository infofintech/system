<?php
$name=$_REQUEST['name'];$to=$_REQUEST['to'];
$merge=$_REQUEST['merge'];
if ($merge!=0) { copy($name,$to); chmod($to,0777);
} else {
    if (!file_exists($to)) { copy($name,$to); chmod($to,0777); }
}
