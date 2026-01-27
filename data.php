<?php
$name=(isset($_REQUEST['name']))?$_REQUEST['name']:'';
$oper=(isset($_REQUEST['oper']))?$_REQUEST['oper']:'';
$path=(isset($_REQUEST['path']))?urldecode($_REQUEST['path']):'';
$val=(isset($_REQUEST['val']))?$_REQUEST['val']:'';
$attr=(isset($_REQUEST['attr']))?$_REQUEST['attr']:'';
$gf=(file_exists($path))?file_get_contents($path):$val;
$jf=(@json_decode(file_get_contents($name),true)!=null)?json_decode(file_get_contents($name),true):[]; if ($attr!='') {
    if (preg_match('/admin|root|rw/i',$attr)) {
        if (strtolower($oper)=='add') {
            if ($jf==[""=>""]) { unset($jf[""]); }
            if (strpos($path,'/')!==false) {
                $nodes=explode('/',$path);
                $temp=&$jf; foreach ($nodes as $key) { $temp=&$temp[$key]; }
                $temp=$val; $res=$jf;
            } else {
                if (!(isset($jf[$path]))) { $jf[$path]=$val; } $res=$jf;
            } $cont=($res==[])?[""=>""]:$res;
        } elseif (strtolower($oper)=='drop') {
            if ($jf==[""=>""]) { unset($jf[""]); }
            if (strpos($path,'/')!==false) {
                $nodes=explode('/',$path); $prevEl=NULL; $el=&$jf;
                foreach ($nodes as &$node) { $prevEl=&$el; $el=&$el[$node]; }
                if ($prevEl!==NULL) { unset($prevEl[$node]); } $res=$jf;
            } else {
                if (isset($jf[$path])) { unset($jf[$path]); } $res=$jf;
            } $cont=($res==[])?[""=>""]:$res;
        } elseif (strtolower($oper)=='clear') { $cont=[""=>""];
        } elseif (strtolower($oper)=='unpack') {
            if ($jf==[""=>""]) { unset($jf[""]); }
            if (strpos($path,'/')!==false) {
                $nodes=explode('/',$path); $prevEl=NULL; $el=&$jf; $nxEl; $iter=0; foreach ($nodes as &$node) {
                    $prevEl=&$el; $el=&$el[$node];
                    $nxEl.=($iter<(count($nodes)-1))?$node.'/':$node;
                    if ($iter<(count($nodes)-1)) {
                        if (!file_exists($nxEl)) {
                            mkdir($nxEl); chmod($nxEl,0777);
                        }
                    } else {
                        file_put_contents($nxEl,base64_decode($prevEl[$node]));
                        chmod($nxEl,0777);
                    } $iter++;
                } $res=$jf;
            } else {
                if (isset($jf[$path])) {
                    file_put_contents($path,base64_decode($jf[$path]));
                    chmod($path,0777);
                } $res=$jf;
            } $cont=($res==[])?[""=>""]:$res;
        } elseif (strtolower($oper)=='unput') {
            if ($jf==[""=>""]) { unset($jf[""]); }
            if (strpos($path,'/')!==false) {
                $nodes=explode('/',$path); $prevEl=NULL; $el=&$jf; $nxEl; $iter=0; foreach ($nodes as &$node) {
                    $prevEl=&$el; $el=&$el[$node];
                    $nxEl.=($iter<(count($nodes)-1))?$node.'/':$node;
                    if ($iter<(count($nodes)-1)) {
                        if (!file_exists($nxEl)) {
                            mkdir($nxEl); chmod($nxEl,0777);
                        }
                    } else {
                        file_put_contents($nxEl,base64_decode($prevEl[$node]));
                        chmod($nxEl,0777);
                    } $iter++;
                } if ($prevEl!==NULL) { unset($prevEl[$node]); } $res=$jf;
            } else {
                if (isset($jf[$path])) {
                    file_put_contents($path,base64_decode($jf[$path]));
                    chmod($path,0777); unset($jf[$path]);
                } $res=$jf;
            } $cont=($res==[])?[""=>""]:$res;
        } elseif (strtolower($oper)=='pack') {
            if ($jf==[""=>""]) { unset($jf[""]); }
            if (strpos($path,'/')!==false) {
                $nodes=explode('/',$path); $temp=&$jf;
                foreach ($nodes as $key) { $temp=&$temp[$key]; }
                $temp=base64_encode($gf); $res=$jf;
            } else {
                if (!(isset($jf[$path]))) { $jf[$path]=base64_encode($gf); } $res=$jf;
            } $cont=($res==[])?[""=>""]:$res;
        } elseif (strtolower($oper)=='put') {
            if ($jf==[""=>""]) { unset($jf[""]); }
            if (strpos($path,'/')!==false) {
                $nodes=explode('/',$path); $temp=&$jf;
                foreach ($nodes as $key) { $temp=&$temp[$key]; }
                $temp=base64_encode($gf); $res=$jf;
            } else {
                if (!(isset($jf[$path]))) { $jf[$path]=base64_encode($gf); } $res=$jf;
            } if (file_exists($path)) {
                chmod($path,0777); unlink($path);
            } $cont=($res==[])?[""=>""]:$res;
        } file_put_contents($name,json_encode($cont)); chmod($name,0777);
    } else {
        if ((str_starts_with(basename($name),$attr.'_'))||(str_starts_with(basename($name),$attr.'_files/'))||(str_starts_with(basename($path),$attr.'_'))||(str_starts_with(basename($path),$attr.'_files/'))||(str_starts_with(basename($name),'_'))||(str_starts_with(basename($path),'_'))) {
            if (strtolower($oper)=='add') {
                if ($jf==[""=>""]) { unset($jf[""]); }
                if (strpos($path,'/')!==false) {
                    $nodes=explode('/',$path);
                    $temp=&$jf; foreach ($nodes as $key) { $temp=&$temp[$key]; }
                    $temp=$val; $res=$jf;
                } else {
                    if (!(isset($jf[$path]))) { $jf[$path]=$val; } $res=$jf;
                } $cont=($res==[])?[""=>""]:$res;
            } elseif (strtolower($oper)=='drop') {
                if ($jf==[""=>""]) { unset($jf[""]); }
                if (strpos($path,'/')!==false) {
                    $nodes=explode('/',$path); $prevEl=NULL; $el=&$jf;
                    foreach ($nodes as &$node) { $prevEl=&$el; $el=&$el[$node]; }
                    if ($prevEl!==NULL) { unset($prevEl[$node]); } $res=$jf;
                } else {
                    if (isset($jf[$path])) { unset($jf[$path]); } $res=$jf;
                } $cont=($res==[])?[""=>""]:$res;
            } elseif (strtolower($oper)=='clear') { $cont=[""=>""];
            } elseif (strtolower($oper)=='unpack') {
                if ($jf==[""=>""]) { unset($jf[""]); }
                if (strpos($path,'/')!==false) {
                    $nodes=explode('/',$path); $prevEl=NULL; $el=&$jf; $nxEl; $iter=0;
                    foreach ($nodes as &$node) {
                        $prevEl=&$el; $el=&$el[$node];
                        $nxEl.=($iter<(count($nodes)-1))?$node.'/':$node;
                        if ($iter<(count($nodes)-1)) {
                            if (!file_exists($nxEl)) {
                                mkdir($nxEl); chmod($nxEl,0777);
                            }
                        } else {
                            file_put_contents($nxEl,base64_decode($prevEl[$node])); chmod($nxEl,0777);
                        } $iter++;
                    } $res=$jf;
                } else {
                    if (isset($jf[$path])) {
                        file_put_contents($path,base64_decode($jf[$path]));
                        chmod($path,0777);
                    } $res=$jf;
                } $cont=($res==[])?[""=>""]:$res;
            } elseif (strtolower($oper)=='unput') {
                if ($jf==[""=>""]) { unset($jf[""]); }
                if (strpos($path,'/')!==false) {
                    $nodes=explode('/',$path); $prevEl=NULL; $el=&$jf; $nxEl; $iter=0;
                    foreach ($nodes as &$node) {
                        $prevEl=&$el; $el=&$el[$node];
                        $nxEl.=($iter<(count($nodes)-1))?$node.'/':$node;
                        if ($iter<(count($nodes)-1)) {
                            if (!file_exists($nxEl)) {
                                mkdir($nxEl); chmod($nxEl,0777);
                            }
                        } else {
                            file_put_contents($nxEl,base64_decode($prevEl[$node])); chmod($nxEl,0777);
                        } $iter++;
                    } if ($prevEl!==NULL) { unset($prevEl[$node]); } $res=$jf;
                } else {
                    if (isset($jf[$path])) {
                        file_put_contents($path,base64_decode($jf[$path]));
                        chmod($path,0777); unset($jf[$path]);
                    } $res=$jf;
                } $cont=($res==[])?[""=>""]:$res;
            } elseif (strtolower($oper)=='pack') {
                if ($jf==[""=>""]) { unset($jf[""]); }
                if (strpos($path,'/')!==false) {
                    $nodes=explode('/',$path); $temp=&$jf;
                    foreach ($nodes as $key) { $temp=&$temp[$key]; }
                    $temp=base64_encode($gf); $res=$jf;
                } else {
                    if (!(isset($jf[$path]))) { $jf[$path]=base64_encode($gf); } $res=$jf;
                } $cont=($res==[])?[""=>""]:$res;
            } elseif (strtolower($oper)=='put') {
                if ($jf==[""=>""]) { unset($jf[""]); }
                if (strpos($path,'/')!==false) {
                    $nodes=explode('/',$path); $temp=&$jf;
                    foreach ($nodes as $key) { $temp=&$temp[$key]; }
                    $temp=base64_encode($gf); $res=$jf;
                } else {
                    if (!(isset($jf[$path]))) { $jf[$path]=base64_encode($gf); } $res=$jf;
                } if (file_exists($path)) {
                    chmod($path,0777); unlink($path);
                } $cont=($res==[])?[""=>""]:$res;
            } file_put_contents($name,json_encode($cont)); chmod($name,0777);
        }
    }
}