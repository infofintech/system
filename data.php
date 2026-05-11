<?php
$name=(isset($_REQUEST['name']))?$_REQUEST['name']:'';
$oper=(isset($_REQUEST['oper']))?$_REQUEST['oper']:'';
$path=(isset($_REQUEST['path']))?urldecode($_REQUEST['path']):'';
$val=(isset($_REQUEST['val']))?$_REQUEST['val']:'';
$attr=(isset($_REQUEST['attr']))?$_REQUEST['attr']:'';
$gf=(file_exists($path))?file_get_contents($path):$val;
$jf=(@json_decode(file_get_contents($name),true)!=null)?json_decode(file_get_contents($name),true):[];
function handleAdd($jf,$path,$val) {
    if ($jf==[""=>""]) {
        unset($jf[""]);
    } if (strpos($path,'/')!==false) {
        $nodes=explode('/',$path);
        $temp=&$jf; foreach ($nodes as $key) {
            $temp=&$temp[$key];
        } $temp=$val; $res=$jf;
    } else {
        if (!isset($jf[$path])) {
            $jf[$path]=$val;
        } $res=$jf;
    } return ($res==[])?[""=>""]:$res;
}
function handleDrop($jf,$path) {
    if ($jf==[""=>""]) {
        unset($jf[""]);
    } if (strpos($path,'/')!==false) {
        $nodes=explode('/',$path);
        $prevEl=null; $el=&$jf;
        foreach ($nodes as &$node) {
            $prevEl=&$el;
            $el=&$el[$node];
        } if ($prevEl!==null) {
            unset($prevEl[$node]);
        } $res=$jf;
    } else {
        if (isset($jf[$path])) {
            unset($jf[$path]);
        } $res=$jf;
    } return ($res==[])?[""=>""]:$res;
}
function handleClear() { return [""=>""]; }
function handleUnpack($jf,$path,$oneWay=false) {
    if ($jf==[""=>""]) {
        unset($jf[""]);
    } if (strpos($path,'/')!==false) {
        $nodes=explode('/',$path);
        $prevEl=null; $el=&$jf; $nxEl=''; $iter=0;
        foreach ($nodes as &$node) {
            $prevEl=&$el; $el=&$el[$node];
            $nxEl.=($iter<(count($nodes)-1))?$node.'/':$node;
            if ($iter<(count($nodes)-1)) {
                if (!file_exists($nxEl)) {
                    mkdir($nxEl,0777,true); chmod($nxEl,0777);
                }
            } else {
                file_put_contents($nxEl,gzinflate(base64_decode($prevEl[$node])));
                chmod($nxEl,0777);
            } $iter++; if ($oneWay) {
                if ($prevEl!==NULL) { unset($prevEl[$node]); }
            }
        } $res=$jf;
    } else {
        if (isset($jf[$path])) {
            file_put_contents($path,gzinflate(base64_decode($jf[$path])));
            chmod($path,0777); if ($oneWay) { unset($jf[$path]); }
        } $res=$jf;
    } return ($res==[])?[""=>""]:$res;
}
function handlePack($jf,$path,$gf,$oneWay=false) {
    if ($jf==[""=>""]) { unset($jf[""]); }
    if (strpos($path,'/')!==false) {
        $nodes=explode('/',$path); $temp=&$jf;
        foreach ($nodes as $key) {
            $temp=&$temp[$key];
        } $temp=base64_encode(gzdeflate($gf,9));
        $res=$jf;
    } else {
        if (!(isset($jf[$path]))) {
            $jf[$path]=base64_encode(gzdeflate($gf,9));
        } $res=$jf;
    } if ($oneWay) {
        if (file_exists($path)) {
            chmod($path,0777); unlink($path);
        }
    } return ($res==[])?[""=>""]:$res;
}
if ($attr!='') {
    if (preg_match('/admin|root|rw/i',$attr)) {
        $cont=processOperation($oper,$jf,$path,$val,$gf);
    } else {
        if ((str_starts_with(basename($name),$attr.'_'))||
            (str_starts_with($name,$attr.'_files/'))||
            (str_starts_with($name,'./'.$attr.'_files/'))||
            (str_starts_with(basename($path),$attr.'_'))||
            (str_starts_with($path,$attr.'_files/'))||
            (str_starts_with(basename($name),'_'))||
            (str_starts_with(basename($path),'_'))) {
            $cont=processOperation($oper,$jf,$path,$val,$gf);
        } else { $cont=$jf; }
    } file_put_contents($name,json_encode($cont));
    chmod($name,0777);
}
function processOperation($oper,$jf,$path,$val,$gf) {
    switch (strtolower($oper)) {
        case 'add':
            return handleAdd($jf,$path,$val);
        case 'drop':
            return handleDrop($jf,$path);
        case 'clear':
            return handleClear();
        case 'unpack':
            return handleUnpack($jf,$path);
        case 'unput':
            return handleUnpack($jf,$path,true);
        case 'pack':
            return handlePack($jf,$path,$gf);
        case 'put':
            return handlePack($jf,$path,$gf,true);
        default:
            return $jf;
    }
}