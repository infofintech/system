<?php
$red=(strlen(dechex(rand(0, 255)))<2)?'0'.dechex(rand(0, 255)):dechex(rand(0,255));
$green=(strlen(dechex(rand(0, 255)))<2)?'0'.dechex(rand(0,255)):dechex(rand(0,255));
$blue=(strlen(dechex(rand(0,255)))<2)?'0'.dechex(rand(0,255)):dechex(rand(0,255)); echo $red.$green.$blue;
