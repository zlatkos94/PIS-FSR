<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Referada</title>
</head>
	<meta name="viewport" content="width=device-width; maximum-scale=1; minimum-scale=1;" />
	<link href="../jquery/jquery-ui.css" rel="stylesheet">
    <link href="index.css" rel="stylesheet">
	<script src="../jquery/external/jquery/jquery.js"></script>
	<script src="../jquery/jquery-ui.js"></script>
    
    <?php
	include '../statusbaze.php';
if(isset($_REQUEST['logout'])){
	session_start();
	$v=logout($_SESSION['login_user']);
 	session_destroy();
	echo "<script> alert('Uspješno ste odjavljeni.'); </script>";
}
$error="";
if(isset($_POST['submit'])){
	if(!empty($_POST['username']) || !empty($_POST['password']))
{
	$username=$_POST['username'];
	//$password=md5($_POST['password']);
	$password=$_POST['password'];
	
	$username= stripslashes($username);
	$password= stripslashes($password);
	$username= mysql_real_escape_string($username);
	$password= mysql_real_escape_string($password);
	
	if(checkUser($username, $password)){
		session_start();
		$_SESSION['login_user']=$username;
		
		header("location: referada.php");
	}
	else{
		echo "<script> alert('Ne ispravna lozinka ili korisničko ime!'); </script>";
	}
	
	
	
	
	/*	session_start();
		$_SESSION['login_user']=$username;
		echo '<script>popup_prozor1()</script>';
		//header("location: aplikacija.php");*/
	
	
	
	}
	

}

?>
	
<body>

<div id=main>
<form action="index.php" method="post">
			<table id="table">
    	<tr>
        	<td id="tablebar" >Prijava:</td>
        </tr><tr>
        	<td>
            	<table cellspacing="0" cellpadding="0" id="table">
                	<tr class="tablecontent">
                    	<td id="left">Korisničko ime:</td><td id="right"> <input class="input" type="text" name="username"/><td rowspan="3" id="keyrow"><img src="key.png" id="key"/></td></td>
                    </tr><tr class="tablecontent">
                    	<td id="left">Zaporka:</td><td id="right"> <input  class="input" type="password" name="password"/></td>
                    </tr><tr class="tablecontent" id="submitrow">
                    	<td></td><td id="cen"><input type="submit" id="butt" name="submit" value="Potvrdi" /></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>
</form>
<div id=main2>
<form action="index.php" method="post">
			<table id="table">
    	<tr>
        	<td id="tablebar" >Prijava:</td>
        </tr><tr>
        	<td>
            	<table cellspacing="0" cellpadding="0" id="table">
                	<tr class="tablecontent">
                    	<td><div class="title">Korisničko ime:</div></td>
                    </tr><tr class="tablecontent">
                    	<td> <input class="input" type="text" name="username"/></td>
                    </tr><tr class="tablecontent">
                    	<td ><div class="title">Zaporka:</div></td>
                    </tr><tr class="tablecontent">
                    	<td> <input  class="input" type="password" name="password"/></td>
                    </tr><tr class="tablecontent" id="submitrow">
                    	<td><div id="cen"><input type="submit" id="butt2" name="submit" value="Potvrdi" /></div></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>

</form>
</div>


<div id="main3">
    <table id="table2">
    <tr>
    <td><font color="#FF0000"> Molimo za pristup aplikaciji unesite svoje <b>korisničko ime </b> i <b>zaporku</b>!</font></td>
    </tr><tr>
    <td>U slučaju poteškoća obratite se našem <b><u>Administratoru</u></b>.</td>
    </tr>
    </table>
   
</div>


<script>
	$("#butt").button();
	$("#butt2").button();
</script>
</body>
</html>