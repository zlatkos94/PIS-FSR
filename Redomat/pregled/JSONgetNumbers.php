<?php
header('Content-type:application/json');

$connection= mysql_connect("localhost","root","");
	$rows=array();
	$db=mysql_select_db("redomat",$connection);
	$querry= mysql_query("select status_rada as st from Zaposlenik where korisnicko_ime='salter1';", $connection);
	$row = mysql_fetch_assoc($querry);
	if($row['st']==1){
		$querry= mysql_query("select broj from obrada where broj_korisnik=(select MAX(broj_korisnik) from obrada where korisnicko_ime='salter1');", $connection);
		$row = mysql_fetch_assoc($querry);
		$rows['salter1']= $row['broj'];
	}
	
	
		$querry= mysql_query("select status_rada as st from Zaposlenik where korisnicko_ime='salter2';", $connection);
	$row = mysql_fetch_assoc($querry);
	if($row['st']==1){
		$querry= mysql_query("select broj from obrada where broj_korisnik=(select MAX(broj_korisnik) from obrada where korisnicko_ime='salter2');", $connection);
		$row = mysql_fetch_assoc($querry);
		$rows['salter2']= $row['broj'];
	}
	
		$querry= mysql_query("select status_rada as st from Zaposlenik where korisnicko_ime='salter3';", $connection);
	$row = mysql_fetch_assoc($querry);
	if($row['st']==1){
		$querry= mysql_query("select broj from obrada where broj_korisnik=(select MAX(broj_korisnik) from obrada where korisnicko_ime='salter3');", $connection);
		$row = mysql_fetch_assoc($querry);
		$rows['salter3']= $row['broj'];
	}
	
		$querry= mysql_query("select status_rada as st from Zaposlenik where korisnicko_ime='salter4';", $connection);
	$row = mysql_fetch_assoc($querry);
	if($row['st']==1){
		$querry= mysql_query("select broj from obrada where broj_korisnik=(select MAX(broj_korisnik) from obrada where korisnicko_ime='salter4');", $connection);
		$row = mysql_fetch_assoc($querry);
		$rows['salter4']= $row['broj'];
	}
	
	echo json_encode($rows);
?>