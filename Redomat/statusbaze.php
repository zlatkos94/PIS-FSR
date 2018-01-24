<?php
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

function checkUser($username, $password){
	$connection=connect();
	$querry= mysql_query("select * from zaposlenik where lozinka='$password' AND korisnicko_ime='$username'", 								$connection);
	//mysql_close($connection);
	$rows=mysql_num_rows($querry);
	if($rows==1){
		$querry= mysql_query("update zaposlenik set status_rada=true where korisnicko_ime='$username';",$connection);
		return true;
	}
	else
		return false;	
}

function logout($username){
	$connection=connect();
	$querry= mysql_query("update zaposlenik set status_rada=false where korisnicko_ime='$username';",$connection);
	if (!$querry){
		return "ne";
	}else{
		return "da";
	}
}

function getAktivnost(){
	$connection=connect();
	$querry= mysql_query("select * from Aktivnost", $connection);
	return $querry;
	/*while( $row = mysql_fetch_array( $querry ) ){
		echo $row["naziv"];
	}*/
}

function deleteAktivnost($name){
	$connection=connect();
	$querry= mysql_query("delete from Aktivnost where sifra_aktivnost=$name", $connection);
}

function addAktivnost($name){
	$connection=connect();
	$querry= mysql_query("insert into Aktivnost(naziv_aktivnost,prosjek_aktivnost) values ('$name',0)", $connection);
}

function connect(){
	$connection= mysql_connect("localhost","root","");
	$db=mysql_select_db("redomat",$connection);
	return $connection;
}


function getCurrentNumber(){
	$connection=connect();
	$querry= mysql_query("select broj as trenutnibroj from obrada where status_obrade=1 order by broj_korisnik desc limit 1", $connection);
	
	$row=mysql_num_rows($querry);
	$row = mysql_fetch_assoc($querry);
	return $row;
}

function generateCode() {
		/* list all possible characters, similar looking characters and vowels have been removed */
		$possible = '23456789ABCDEFGHJIKLMNOPQRSTVWXYZ';
		$code = '';
		$i = 0;
		while ($i < 6) { 
			$code .= substr($possible, mt_rand(0, strlen($possible)-1), 1);
			$i++;
		}
		return $code;
}


function sljedeci(){
	$connection= mysql_connect("localhost","root","");
	$db=mysql_select_db("redomat",$connection);
	$querry= mysql_query("select * from stat", $connection);
	$row=mysql_num_rows($querry);
	if($row==1){
		$row = mysql_fetch_assoc($querry);
		if($row['st']==1)
			return true;
		else
			return false;
	}
}

function getNumberOfUser(){
	$connection=connect();
	$querry= mysql_query("select count(status_rada) as zbroj from zaposlenik where status_rada=1;", $connection);
	$row = mysql_fetch_assoc($querry);
	echo $row['zbroj'];
	
}



?>