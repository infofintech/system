<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(E_ALL);
$name=(isset($_REQUEST['name']))?$_REQUEST['name']:'';
$oper=(isset($_REQUEST['oper']))?$_REQUEST['oper']:'';
$path=(isset($_REQUEST['path']))?urldecode($_REQUEST['path']):'';
$val=(isset($_REQUEST['val']))?$_REQUEST['val']:'';
$attr=(isset($_REQUEST['attr']))?$_REQUEST['attr']:'';
$content=(file_exists($path))?file_get_contents($path):$val;
$jsonData=(@json_decode(file_get_contents($name),true)!=null)?json_decode(file_get_contents($name),true):[];
function handleAdd($jsonData,$path,$val) {
    if ($jsonData==[""=>""]) {
        unset($jsonData[""]);
    } if (strpos($path,'/')!==false) {
        $nodes=explode('/',$path);
        $temp=&$jsonData; foreach ($nodes as $key) {
            $temp=&$temp[$key];
        } $temp=$val; $res=$jsonData;
    } else {
        if (!isset($jsonData[$path])) {
            $jsonData[$path]=$val;
        } $res=$jsonData;
    } return ($res==[])?[""=>""]:$res;
}
function handleDrop($jsonData,$path) {
    if ($jsonData==[""=>""]) {
        unset($jsonData[""]);
    } if (strpos($path,'/')!==false) {
        $nodes=explode('/',$path);
        $prevEl=null; $el=&$jsonData;
        foreach ($nodes as &$node) {
            $prevEl=&$el;
            $el=&$el[$node];
        } if ($prevEl!==null) {
            unset($prevEl[$node]);
        } $res=$jsonData;
    } else {
        if (isset($jsonData[$path])) {
            unset($jsonData[$path]);
        } $res=$jsonData;
    } return ($res==[])?[""=>""]:$res;
}
function handleClear() { return [""=>""]; }
function handleUnpack($jsonData,$path,$oneWay=false) {
    if ($jsonData==[""=>""]) {
        unset($jsonData[""]);
    }
    function unpackRecursive($data,$targetPath) {
        if (!is_dir($targetPath)) {
            mkdir($targetPath,0777,true);
            chmod($targetPath,0777);
        } foreach ($data as $key=>$value) {
            $currentPath=$targetPath.'/'.$key;
            if (is_array($value)) {
                unpackRecursive($value,$currentPath);
            } else {
                if ($value!==null&&$value!=='') {
                    $decodedContent=gzinflate(base64_decode($value));
                    file_put_contents($currentPath,$decodedContent);
                    chmod($currentPath,0777);
                }
            }
        }
    } if (strpos($path,'/')!==false) {
        $nodes=explode('/',$path);
        $temp=&$jsonData; $currentDir='';
        for ($i=0; $i<count($nodes)-1; $i++) {
            $node=$nodes[$i];
            if (!isset($temp[$node])) {
                trigger_error("Путь '$path' не найден в JSON-данных",E_USER_WARNING);
                return ($jsonData==[])?[""=>""]:$jsonData;
            } $temp=&$temp[$node];
            $currentDir.=$node.'/';
            if (!is_dir($currentDir)) {
                mkdir($currentDir,0777,true);
                chmod($currentDir,0777);
            }
        } $lastNode=$nodes[count($nodes)-1];
        if (isset($temp[$lastNode])) {
            if (is_array($temp[$lastNode])) {
                unpackRecursive($temp[$lastNode],$path);
            } else {
                if ($temp[$lastNode]!==null&&$temp[$lastNode]!=='') {
                    $decodedContent=gzinflate(base64_decode($temp[$lastNode]));
                    file_put_contents($path,$decodedContent);
                    chmod($path,0777);
                }
            } if ($oneWay) {
                unset($temp[$lastNode]);
            }
        } else {
            trigger_error("Последний узел '$lastNode' не найден в JSON-данных",E_USER_WARNING);
        } $res=$jsonData;
    } else {
        if (isset($jsonData[$path])) {
            if (is_array($jsonData[$path])) {
                unpackRecursive($jsonData[$path],$path);
            } else {
                if ($jsonData[$path]!==null&&$jsonData[$path]!=='') {
                    $decodedContent=gzinflate(base64_decode($jsonData[$path]));
                    file_put_contents($path,$decodedContent);
                    chmod($path,0777);
                }
            } if ($oneWay) {
                unset($jsonData[$path]);
            }
        } else {
            trigger_error("Ключ '$path' не найден в JSON-данных",E_USER_WARNING);
        } $res=$jsonData;
    } return ($res==[])?[""=>""]:$res;
}
function handlePack($jsonData,$path,$content,$oneWay=false) {
    if ($jsonData==[""=>""]) {
        unset($jsonData[""]);
    } function packDirectory($directory) {
        $result=[]; if (!is_dir($directory)) {
            return false;
        } $iterator=new FilesystemIterator($directory,FilesystemIterator::SKIP_DOTS);
        foreach ($iterator as $fileInfo) {
            $fileName=$fileInfo->getFilename();
            $filePath=$fileInfo->getPathname();
            if ($fileInfo->isDir()) {
                $result[$fileName]=packDirectory($filePath);
            } else {
                $fileContent=file_get_contents($filePath);
                $result[$fileName]=base64_encode(gzdeflate($fileContent,9));
            }
        } return $result;
    } $packedData=((is_dir($path))&&(!is_link($path)))?packDirectory($path):base64_encode(gzdeflate($content,9));
    if (strpos($path,'/')!==false) {
        $nodes=explode('/',$path); $temp=&$jsonData;
        foreach ($nodes as $key) {
            if (!isset($temp[$key])||!is_array($temp[$key])) {
                $temp[$key]=[];
            } $temp=&$temp[$key];
        } $temp=$packedData; $res=$jsonData;
    } else {
        $jsonData[$path]=$packedData; $res=$jsonData;
    } if ($oneWay) {
         if ((is_dir($path))&&(!is_link($path))) {
            exec('chmod -vR 777 "'.$path.'"');
            exec('rm -vr "'.$path.'"');
        } else { chmod($path,0777); unlink($path); }
    } return ($res==[])?[""=>""]:$res;
}
if ($attr!='') {
    if (preg_match('/admin|root|rw/i',$attr)) {
        $cont=processOperation($oper,$jsonData,$path,$val,$content);
    } else {
        if ((str_starts_with(basename($name),$attr.'_'))||
            (str_starts_with($name,$attr.'_files/'))||
            (str_starts_with($name,'./'.$attr.'_files/'))||
            (str_starts_with(basename($path),$attr.'_'))||
            (str_starts_with($path,$attr.'_files/'))||
            (str_starts_with(basename($name),'_'))||
            (str_starts_with(basename($path),'_'))) {
            $cont=processOperation($oper,$jsonData,$path,$val,$content);
        } else { $cont=$jsonData; }
    } file_put_contents($name,json_encode($cont));
    chmod($name,0777);
}
function processOperation($oper,$jsonData,$path,$val,$content) {
    switch (strtolower($oper)) {
        case 'add':
            return handleAdd($jsonData,$path,$val);
        case 'drop':
            return handleDrop($jsonData,$path);
        case 'clear':
            return handleClear();
        case 'unpack':
            return handleUnpack($jsonData,$path);
        case 'unput':
            return handleUnpack($jsonData,$path,true);
        case 'pack':
            return handlePack($jsonData,$path,$content);
        case 'put':
            return handlePack($jsonData,$path,$content,true);
        default:
            return $jsonData;
    }
}