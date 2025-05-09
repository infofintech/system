<?php
$name=$_REQUEST['name']; $oper=$_REQUEST['oper'];
$path=urldecode($_REQUEST['path']); $val=$_REQUEST['val'];
$gf=(file_exists($path))?file_get_contents($path):$val;
$jf=(@json_decode(file_get_contents($name),true)!=null)?json_decode(file_get_contents($name),true):[]; switch ($oper) {
    case 'create': case 'update': case 'alter': case 'touch': case 'make': case 'add':
        if ($jf==[""=>""]) { unset($jf[""]); }
        if (strpos($path,'/')!==false) {
            $nodes=explode('/',$path);
            $temp=&$jf; foreach ($nodes as $key) {
                $temp=&$temp[$key];
            } $temp=$val; $res=$jf;
        } else {
            if (!(isset($jf[$path]))) { $jf[$path]=$val; } $res=$jf;
        } $cont=($res==[])?[""=>""]:$res; break;
    case 'remove': case 'delete': case 'drop': case 'del': case 'rm':
        if ($jf==[""=>""]) { unset($jf[""]); }
        if (strpos($path,'/')!==false) {
            $nodes=explode('/',$path);
            $prevEl=NULL; $el=&$jf;
            foreach ($nodes as &$node) {
                $prevEl=&$el; $el=&$el[$node];
            } if ($prevEl!==NULL) { unset($prevEl[$node]); } $res=$jf;
        } else {
            if (isset($jf[$path])) { unset($jf[$path]); } $res=$jf;
        } $cont=($res==[])?[""=>""]:$res; break;
    case 'clear': case 'erase': case 'purge': $cont=[""=>""]; break;
    case 'extract': case 'unpack':
        if ($jf==[""=>""]) { unset($jf[""]); }
        if (strpos($path,'/')!==false) {
            $nodes=explode('/',$path);
            $prevEl=NULL; $el=&$jf; $nxEl; $iter=0;
            foreach ($nodes as &$node) {
                $prevEl=&$el; $el=&$el[$node];
                $nxEl.=($iter<(count($nodes)-1))?$node.'/':$node;
                if ($iter<(count($nodes)-1)) {
                    if (!file_exists($nxEl)) { mkdir($nxEl); chmod($nxEl,0777); }
                } else {
                    file_put_contents($nxEl,hex2bin($prevEl[$node])); chmod($nxEl,0777);
                } $iter++;
            } if ($prevEl!==NULL) { unset($prevEl[$node]); } $res=$jf;
        } else {
            if (isset($jf[$path])) {
                file_put_contents($path,hex2bin($jf[$path]));
                chmod($path,0777); unset($jf[$path]);
            } $res=$jf;
        } $cont=($res==[])?[""=>""]:$res; break;
    case 'archive': case 'pack':
        if ($jf==[""=>""]) { unset($jf[""]); }
        if (strpos($path,'/')!==false) {
            $nodes=explode('/',$path); $temp=&$jf;
            foreach ($nodes as $key) {
                $temp=&$temp[$key];
            } $temp=bin2hex($gf); $res=$jf;
        } else {
            if (!(isset($jf[$path]))) {
                $jf[$path]=bin2hex($gf);
            } $res=$jf;
        } $cont=($res==[])?[""=>""]:$res; break;
} file_put_contents($name,json_encode($cont)); chmod($name,0777);