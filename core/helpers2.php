<?php

function dd($param)
{
	echo '<pre>';
	print_r($param);
	echo '</pre>';
	exit();
}

function reportLog($str){
    $file = ROOT."/var/log/debug.log";
    file_put_contents($file, "[". date('m/d/Y h:i:s a', time()) . "] ", FILE_APPEND | LOCK_EX);
    file_put_contents($file, json_encode($str)."\n", FILE_APPEND | LOCK_EX);
}