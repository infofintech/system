<?php
function setEnvVar($key,$value,$envPath) {
    $key=trim($key); $value=$value??'';
    if ($key==='') { return false; }
    if (!file_exists($envPath)) {
        if ($value==='') { return true; }
        file_put_contents($envPath,'');
    } $content=file_get_contents($envPath);
    $lines=preg_split('/\r\n|\r|\n/',$content,-1,PREG_SPLIT_NO_EMPTY);
    $found=false; foreach ($lines as &$line) {
        $trimmed=trim($line);
        if ($trimmed!==''&&strpos($trimmed,'#')===0) {
            continue;
        } if (strpos($line,'=')!==false) {
            list($existingKey,$_)=explode('=',$line,2);
            if (trim($existingKey)===$key) {
                $line=($value==='')?null:"$key=$value"; 
                $found=true; break;
            }
        }
    } unset($line); if (!$found&&$value!=='') {
        $lines[]="$key=$value";
    } $filteredLines=array_filter($lines,function ($l) {
        return $l!==null;
    }); $newContent=implode("\n",$filteredLines);
    return file_put_contents($envPath,$newContent)!==false;
} $name=(isset($_REQUEST['name']))?$_REQUEST['name']:'';
$key=(isset($_REQUEST['key']))?$_REQUEST['key']:'';
$value=(isset($_REQUEST['value']))?$_REQUEST['value']:'';
$attr=(isset($_REQUEST['attr']))?$_REQUEST['attr']:'';
if ($attr!='') {
    if (preg_match('/admin|root|rw/i',$attr)) {
        setEnvVar($key,$value,$name);
    } else {
        if (file_exists($name)) {
            if ((str_starts_with(basename($name),$attr.'_'))||(str_starts_with($name,$attr.'_files/'))||(str_starts_with($name,'./'.$attr.'_files/'))||(str_starts_with(basename($name),'_'))) {
                setEnvVar($key,$value,$name);
            }
        } else {
            setEnvVar($key,$value,$name);
        }
    }
}
