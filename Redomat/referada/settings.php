<html>
<head>
<meta charset="utf-8">
<title>Postavke</title>
<link href="../jquery/jquery-ui.css" rel="stylesheet">
<link href="settings.css" rel="stylesheet">
<script src="../jquery/external/jquery/jquery.js"></script>
<script src="../jquery/jquery-ui.js"></script>
</head>
<body>
 	<?php
    	session_start();
		if($_SESSION['login_user']){
    ?>
<div class="statusbar">
<div class="left">
<a href="referada.php"><img class="set" src="backlogo.png" alt="Postavke"/></a>
<a href="index.php?logout=1"><img class="set" src="exitlogo.png" alt="Logout"/></a>

</div>
<div class="right">
<?php
	include '../statusbaze.php';
	$stat=status();
	if($stat)
		echo '<img id="stat" " class="set" src="green_light.png" alt="Online" />';
	else
		echo '<img id="stat" class="set" src="red_light.png" alt="Online" />';

?>
</div>
</div>


<div id="main">
<table>
	<tr>
    	<td id="tablebar">
			Status rada redomata:
        </td>
    </tr><tr>
    	<td class="tablecontent">
			<div id="radioset">
			<input type="radio" id="radio1" name="radio"><label for="radio1">Uključi</label>
			<input type="radio" id="radio2" name="radio" checked="checked"><label for="radio2">Isključi</label>
			</div>
		</td>
    </tr><tr>
   		 <td id="tablebar">Status aktivnih šaltera:</td>
    </tr><tr>
    	<td class="tablecontent"><?php getNumberOfUser(); ?></td>
    </tr><tr>
    	<td id="tablebar">Popis aktivnost:</td>
    </tr><tr>
    	<td class="tablecontent">
		
<ul id="menu">
<?php
    $result = getAktivnost();
    while($row=mysql_fetch_array( $result )){
		echo '<li id="li"> ';
		echo $row["sifra_aktivnost"] ;
		echo '. ';
		echo $row["naziv_aktivnost"] ;
		echo '</li>';
	}
?>
</ul>
		</td>
     </tr><tr>
     	<td id="tablebar">Dodaj aktivnost:</td>
     </tr><tr>
		<td class="tablecontent">
			<input type="text" id="naziv"/>
    		<button id="save">+</button>
        </td>
     </tr>			
</table>
<br>
<br>
<br>



</div>

<script>


$(document).ready(function(e) {
	$("#radio1").click(function(){
			onoff("on");
	});
	$("#radio2").click(function(){
			onoff("off");
	});
	
    
	$( "#save" ).click(function(){
		$name=$( "#naziv").val();
		obradi($name);
	});
	
	$("#menu li").click(function(){
		 var v=$(this).text();
		 if (confirm('Jeste li sigurni da želite pobrisati aktivnost "'+v+'" ?')) {
			 v=v.match(/\d/g);
			 v=v.join("");
			 obradi(v);
		} else {
		}
	})
	
	function obradi($name){
		$.ajax({
           	url: "spremi.php",
			type:"POST",
			data:{"name":$name},
			success: function(rez){
				window.location.reload();
				
			}
		});	
	}
	
	function onoff($name){
		$.ajax({
           	url: "onoff.php",
			type:"POST",
			data:{"name":$name},
			success: function(rez){
				alert(rez);
				if(rez.startsWith("Status: OFF"))
					$("#stat").attr("src","red_light.png");
				else if(rez.startsWith("Status: ON"))
					$("#stat").attr("src","green_light.png");
			}
		});	
	}
	
});

$( "#add").button();
$( "#delete").button();
$( "#remove" ).button();
$( "#save" ).button();

$( "#radioset" ).buttonset();
$( "#menu" ).menu();


</script>
<?php
		}
		else
			echo "Neovlašten pristup, molimo prijavite se";

?>
</body>
</html>
