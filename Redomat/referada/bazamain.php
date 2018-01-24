<?php
function on(){
	$connection=connect();
	$querry= mysql_query("update stat set st=0 where st=1;", $connection);
	if (!$querry){
		return "Došlo je do greške";
	}else{
		return "Status: ON \n Redomat je uspješno uključen!";
	}
}


function off(){
	$connection=connect();
	$querry= mysql_query("update stat set st=1 where st=0;", $connection);
	if (!$querry){
		return "Došlo je do greške";
	}else{
		return "Status: OFF \n Redomat je uspješno isključen!";
	}
}

function connect(){
	$connection= mysql_connect("localhost","root","");
	$db=mysql_select_db("redomat",$connection);
	return $connection;
}

function setStartTime($num,$username){
	
	$connection=connect();
	$querry= mysql_query("update obrada set vrijeme_pocetka=UTC_TIME(),status_obrade=true, korisnicko_ime='$username' where broj_korisnik=$num and status_obrade=0;", $connection);
	if (!$querry){
		return "err";
	}else{
		$i=mysql_affected_rows();
		return $i;
	}
}

function setEndTime($num){
	
	$connection=connect();
	$querry= mysql_query("update obrada set vrijeme_zavrsetka=UTC_TIME() where broj_korisnik=$num;", $connection);
	$querry= mysql_query("select calculate($num);", $connection);
	if (!$querry){
		return "err";
	}else{
		return "suc";
	}
}

function getCurrentNumber(){
	$connection=connect();
	$querry= mysql_query("select broj as trenutnibroj from obrada where status_obrade=1 order by broj_korisnik desc limit 1; ", $connection);
	$row=mysql_num_rows($querry);
	$row = mysql_fetch_assoc($querry);
	return $row;
	
}

function status(){
	$connection=connect();
	$querry= mysql_query("select * from stat", $connection);
	$row=mysql_num_rows($querry);
	if($row==1){
		$row = mysql_fetch_assoc($querry);
		if($row['st']==1)
			return false;
		else
			return true;
	}
}



?>