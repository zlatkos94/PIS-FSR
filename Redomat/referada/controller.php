<?php
include 'bazamain.php';

if(isset($_REQUEST["startTime"])){
	session_start();
	$username=$_SESSION['login_user'];
	$num=$_REQUEST["startTime"];
	echo setStartTime($num,$username);

}

else if(isset($_REQUEST["endTime"])){
	$num=$_REQUEST["endTime"];
	echo setEndTime($num);
}



?>