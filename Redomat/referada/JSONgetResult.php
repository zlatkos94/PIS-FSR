<?php
header('Content-type:application/json');

$connection= mysql_connect("localhost","root","");
$rows=array();
$db=mysql_select_db("redomat",$connection);
$querry= mysql_query("select broj_korisnik as id, broj, sifra_aktivnost as aktivnost, oib from obrada where status_obrade =0 order by broj_korisnik asc limit 1;", $connection);

$row = mysql_fetch_assoc($querry);
	if($row['id']!=''){
		$rows['id']= $row['id'];
		$rows['broj']= $row['broj'];
		$rows['oib']= $row['oib'];
		$rows['aktivnost']= $row['aktivnost'];
	}
	else{
		$rows['id']='--';
		$rows['broj']='--';
		$rows['oib']='';
		$rows['aktivnost']='';
	}
	
echo json_encode($rows);
?>