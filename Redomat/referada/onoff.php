<?php
include 'bazamain.php';

$task=$_REQUEST["name"];
if($task=="on"){
	echo on();
}else{
	echo off();
}

?>