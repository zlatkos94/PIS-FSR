<?php
   header('Content-type:application/json');
   include 'provjeraOib.php';
   session_start();
   $rows=array();
  //provjeravanje uspiješnosti unjetog koda i broj odabira (1-UZMI BROJ)
  //if( $_SESSION['security_code'] == $_POST['security_code'] && !empty($_SESSION['security_code']) && !empty($_REQUEST['oibbroj']) && $_REQUEST['odabir']==1 && oib($_REQUEST['oibbroj'])) {
		
 if( $_SESSION['security_code'] == $_POST['security_code'] && !empty($_SESSION['security_code']) && !empty($_REQUEST['oibbroj']) && $_REQUEST['odabir']==1) {
		
		$oib=$_REQUEST['oibbroj'];
		$id=$_REQUEST['idbroj'];
		
		
		
	    $connection= mysql_connect("localhost","root","");
		$db=mysql_select_db("redomat",$connection);
		
		//uzimanje vremena početka i broja
		$querry= mysql_query("select status_obrade,  broj from obrada where oib='$oib'  order by broj_korisnik desc limit 1; ", $connection);
		$row = mysql_fetch_assoc($querry);
		$status= $row['status_obrade'];
		$broj= $row['broj'];
		//provjera oib statusa
		if($status==0&$broj==0||$status==1){
			
		
		//racunanje pocinje
		
		//uzimanje trenutnog broja
		$querry= mysql_query(" select broj as trenutnibroj from obrada where status_obrade=1 order by broj_korisnik desc limit 1; ", $connection);
		$row = mysql_fetch_assoc($querry);
		$rows['trenutnibroj']= $row['trenutnibroj'];
		
		//odabir trenutnog vremena
		$querry= mysql_query("	select TIME_TO_SEC((SELECT DATE_FORMAT((select now()), '%H:%i:%s'))) as vrijeme;", $connection);
		$row = mysql_fetch_assoc($querry);
		$vrijeme= $row['vrijeme'];
		
		$querry= mysql_query("select min(broj_korisnik) as startBroj from obrada where status_obrade=0; ", $connection);
		$row = mysql_fetch_assoc($querry);
		$startBroj= $row['startBroj'];
		$rows['prosjek']=0;
		$querry= mysql_query("select * from aktivnost; ", $connection);
			while($row=mysql_fetch_array( $querry )){
				$sifra= $row["sifra_aktivnost"];
				$prosjek= $row["prosjek_aktivnost"];
				
				$querry2= mysql_query("select count(sifra_aktivnost) as zbroj from obrada where broj_korisnik>=$startBroj and sifra_aktivnost=$sifra;", $connection);
				$row2 = mysql_fetch_assoc($querry2);
				$zbroj= $row2['zbroj'];
				$rows['prosjek']+=$zbroj*$prosjek;
			}
			
		$rows['prosjek']=gmdate("H:i:s", $rows['prosjek']+$vrijeme);
		
		$querry= mysql_query(" insert into Obrada (oib,sifra_aktivnost,datum,status_obrade) values ('$oib',$id,UTC_DATE(),0);", $connection);
		
		$querry= mysql_query(" SELECT broj as broj FROM Obrada where oib='$oib' order by  broj_korisnik desc;", $connection);
		$row = mysql_fetch_assoc($querry);
		$rows['broj']= $row['broj'];
		
			
		}
		else{
			$rows['greska']='postoji';//Greška 1 unesen oib koji je postojeći i važeći
			
		}
			
		
			
   }
   
   else if($_SESSION['security_code'] == $_POST['security_code'] && !empty($_SESSION['security_code']) && !empty($_REQUEST['oibbroj']) && $_REQUEST['odabir']==2){
	   
	  	$oib=$_REQUEST['oibbroj'];
		
	    $connection= mysql_connect("localhost","root","");
		$db=mysql_select_db("redomat",$connection);
		
		//uzimanje vremena početka i broja
		$querry= mysql_query("select status_obrade,  broj from obrada where oib='$oib'  order by broj_korisnik desc limit 1; ", $connection);
		$row = mysql_fetch_assoc($querry);
		$status= $row['status_obrade'];
		$broj= $row['broj'];
		//provjera oib statusa
		if($status==0&$broj!=0){
			$rows['broj']=$broj;
		
		//racunanje pocinje
		
		//uzimanje trenutnog broja
		$querry= mysql_query(" select broj as trenutnibroj from obrada where status_obrade=1 order by broj_korisnik desc limit 1; ", $connection);
		$row = mysql_fetch_assoc($querry);
		$rows['trenutnibroj']= $row['trenutnibroj'];
		
		//odabir trenutnog vremena
		$querry= mysql_query("	select TIME_TO_SEC((SELECT DATE_FORMAT((select now()), '%H:%i:%s'))) as vrijeme;", $connection);
		$row = mysql_fetch_assoc($querry);
		$vrijeme= $row['vrijeme'];
		
		$querry= mysql_query("select min(broj_korisnik) as startBroj from obrada where status_obrade=0; ", $connection);
		$row = mysql_fetch_assoc($querry);
		$startBroj= $row['startBroj'];
		$rows['prosjek']=0;
		$querry= mysql_query("select * from aktivnost; ", $connection);
			while($row=mysql_fetch_array( $querry )){
				$sifra= $row["sifra_aktivnost"];
				$prosjek= $row["prosjek_aktivnost"];
				
				$querry2= mysql_query("select count(sifra_aktivnost) as zbroj from obrada where broj_korisnik>=$startBroj and sifra_aktivnost=$sifra;", $connection);
				$row2 = mysql_fetch_assoc($querry2);
				$zbroj= $row2['zbroj'];
				$rows['prosjek']+=$zbroj*$prosjek;
			}
			
		$querry= mysql_query("select prosjek_aktivnost from aktivnost where sifra_aktivnost=(select sifra_aktivnost from obrada where oib='$oib' order by broj_korisnik desc limit 1); ", $connection);
		$row = mysql_fetch_assoc($querry);
		$ova= $row['prosjek_aktivnost'];
		
		$rows['prosjek']=gmdate("H:i:s", $rows['prosjek']+$vrijeme-$ova);
		
		
			
			
		}
		else{
			$rows['greska']='postoji';// greška 2: unesen oib koji je istekao ili ne postoji
		
		}
		
   }
   else{
	   $rows['greska']= 'err';
   }
	unset($_SESSION['security_code']);
	echo json_encode($rows);
	
?>