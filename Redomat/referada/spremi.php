<?php
	include '../statusbaze.php';
	$name = $_REQUEST['name'];
	if(is_numeric($name)){
		deleteAktivnost($name);
	}else{
		addAktivnost($name);
	}
	
?>