<?php
function readAs($val,$type) {
    if ($type=='int') { $res=intval($val);
    } elseif ($type=='float') { $res=floatval($val);
    } elseif ($type=='bool') { $res=strval(boolval($val));
    } else { $res=$val; } return $res;
}
$name=(isset($_REQUEST['name']))?$_REQUEST['name']:'';
$type=(isset($_REQUEST['type']))?$_REQUEST['type']:'';
$blank=(isset($_REQUEST['blank']))?$_REQUEST['blank']:'';
$attr=(isset($_REQUEST['attr']))?$_REQUEST['attr']:'';
if (file_exists($name)) {
    chmod($name,0777); $prep=file_get_contents($name);
    if (preg_match('/multi|plur/i',$attr)) { $str=$prep;
    } else { $str=(is_int($attr))?preg_split("/\r\n|\n|\r/",$prep)[$attr]:$prep; } $res=readAs($str,$type);
} else { $res=readAs($blank,$type); } echo $res;
