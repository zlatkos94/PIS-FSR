<?php
function connect(){
	$connection= mysql_connect("localhost","root","");
	$db=mysql_select_db("redomat",$connection);
	return $connection;
}

function getNumbers(){
	$connection=connect();
	$querry= mysql_query("select status_rada from zaposlenik where salter=1;", $connection);
	$row=mysql_num_rows($querry);
	if($row==1){
		$row = mysql_fetch_assoc($querry);
		if($row['status_rada']==1)
			return false;
		{
}

?>