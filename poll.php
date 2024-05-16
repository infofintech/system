<?php
$name = $_REQUEST['name'];
$select = $_REQUEST['select'];
$pollFile = json_decode(file_get_contents($name), true);
$pollRange = $pollFile['range'];
$pollOptions = $pollFile['options'];
switch ($pollFile['type']) {
    case 'start_duel': case 'init_duel':
        $max = max($pollOptions); $min = min($pollOptions);
        $diff = $max - $min; if (isset($pollOptions[$select])) {
            if ($diff < $pollRange) {
                $pollOptions[$select] += 1;
            }
        } break;
    default:
        if (isset($pollOptions[$select])) {
            $pollOptions[$select] += 1;
        } arsort($pollOptions, SORT_NUMERIC);
        $max = max($pollOptions); $min = min($pollOptions);
        $diff = $max - $min; if ($diff >= $pollRange) {
            unset($pollOptions[array_search($min, $pollOptions)]);
        }
}
$pollFile['options'] = $pollOptions;
file_put_contents($name, json_encode($pollFile));
chmod($name, 0777);
