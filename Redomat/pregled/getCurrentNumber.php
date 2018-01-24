<?php
include 'statusbaze.php';

if(isset($_POST['id']))
{
	$row= getCurrentNumber();
	echo $row['OIB'];
	echo '!';
	echo $row['broj'];
	echo '!';
	echo $row['naziv_aktivnost'];
}
else{
	$row= getCurrentNumber();
	echo $row['broj'];
}
?>