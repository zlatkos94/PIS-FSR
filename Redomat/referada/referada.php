<!doctype html>
<html>
<head>

	<meta charset="utf-8">
	<title>Referada</title>
    <meta name="viewport" content="width=device-width; maximum-scale=1; minimum-scale=1;" />
	<link href="../jquery/jquery-ui.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="referada.css">
	<script src="../jquery/external/jquery/jquery.js"></script>
	<script src="../jquery/jquery-ui.js"></script>
	<script src="../clock.js"></script>
    
   	<?php
    	session_start();
		if($_SESSION['login_user']){
    ?>
    
</head>

<body>

<div class="statusbar">
	<div class="left">
		<a href="settings.php"><img class="set" src="settingslogo.png" alt="Postavke"/></a>
		<a href="index.php?logout=1"><img class="set" src="exitlogo.png" alt="Logout"/></a>
        <a href=""><img class="set" src="questionlogo.png" alt="Question"/></a>
	</div>
	<div class="right">

	<?php
		include '../statusbaze.php';
		$stat=status();
		if($stat){
			echo '<img id="stat" " class="set" src="green_light.png" alt="Online" />';
			echo '<script> var st=true; </script>';
		}
		else {
			echo '<img id="stat" class="set" src="red_light.png" alt="Online" />';
			echo '<script> var st=false; </script>';
		}
?>

	</div>
</div>

<div  id="accordion2">
	<table align="center" id="table">
		<tr>
			<td id="tablebar" colspan="2">Trenutni Broj:</td>
		</tr><tr>
			<td id="tablecontentmain" colspan="2"><div id="txtlcd2">--</div></td>
		</tr><tr>
			<td id="tablebar" colspan="2">OIB:</td>
		</tr><tr>
			<td class="tablecontent" colspan="2"><div  id="txtlcdsmall"></div></td>
       	</tr><tr>
			<td id="tablebar" colspan="2">Aktivnost:</td>
		</tr><tr>
			<td class="tablecontent" colspan="2"><div  id="txtlcdsmall2"></div></td>
		</tr><tr>
			<td id="tablebar" colspan="2">Akcije:</td>
		</tr><tr id="buttons">
			<td class="tablecontent" colspan="2"><div id="txtlcdsmall3"><input type="button" id="butt" name="Preuzmi" value="Preuzmi" /></div></td>
        </tr><tr id="buttons2">
        	<td class="tablecontent" width="50%"><div id="txtlcdsmall3"><input type="button" id="butt3" name="Obavljeno" value="Obavljeno" /></div></td>
            <td class="tablecontent"><div id="txtlcdsmall3"><input type="button" id="butt2" name="Sljedeći" value="Sljedeći" /></div></td>
		</tr>
  </table>
</div>

<script>
    var currentNumber;
	var go=true;
	$(document).ready(function(e) {
        if(st){
			getCurrentNumber();
			startAJAXcalls();
		}
    });
	
	function getCurrentNumber(){
		$.ajax({url: "JSONgetResult.php",
				type:"POST",
				data:{id:"admin"},
				success: function(rez){
					var json=rez;
					
					$("#txtlcd2").empty();
					$("#txtlcdsmall").empty();
					$("#txtlcdsmall2").empty();
					$("#txtlcd2").append(json.broj);
					$("#txtlcdsmall").append(json.oib);
					$("#txtlcdsmall2").append(json.aktivnost);
					currentNumber=json.id;
        	   	
						
						
				}
		 });	
	}
	
	$( "#takebutt" ).button();
	$( "#nextbutt" ).button();
	
	function logout(){
		$( "#txtlcd2" ).animate({
          backgroundColor: "#aa0000",
          color: "#fff"
        }, 2000 );
		
	}
	
	function changestat(){
		st=false;
		$("#stat").attr("src","red_light.png");
	}
	
	$("#butt").button();
	$("#butt2").button();
	$("#butt3").button();

	$("#butt").click(function(){
		
		if(!st)
			alert("UPOZORENJE: \nRedomat nije postavlje u rad, pokretanje se izvršava u postavkama pokretanjem akcije 'Uključi'");
		else{
			go=false;
			$.ajax({
           	url: "controller.php",
			type:"POST",
			data:{"startTime":currentNumber},
			success: function(rez){
				if(rez==1){
					$("#buttons").css("display","none");
					$("#buttons2").toggle();
					$( "#txtlcd2" ).animate({
          				backgroundColor: "#aa0000",
          				color: "#fff"
        				}, 2000 );
				}
				else{
					alert("UPOZORENJE: \nKorisnik "+currentNumber+" je već preuzet na drugom šalteru!");
					go=true;
					getCurrentNumber();
					startAJAXcalls();
				}
			}
		});	
			
		}
	});
	
	$("#butt2").click(function(){
		$("#buttons2").css("display","none");
		$("#buttons").toggle();
		$( "#txtlcd2" ).css("color","#090");
		$( "#txtlcd2" ).css("background-color","#fff");	
		go=true;
		getCurrentNumber();
		startAJAXcalls();
	});
	
	$("#butt3").click(function(){
		$.ajax({
           	url: "controller.php",
			type:"POST",
			data:{"endTime":currentNumber},
			success: function(rez){
				$("#buttons2").css("display","none");
				$("#buttons").toggle();
				$( "#txtlcd2" ).css("color","#090");
				$( "#txtlcd2" ).css("background-color","#fff");	
				go=true;
				getCurrentNumber();
				startAJAXcalls();
			}
		});	
		
	});
	
	function startAJAXcalls(){
	setTimeout(function(){
		if(go){
		getCurrentNumber();
		startAJAXcalls();
		}
		
	},5000);
}
	
	
</script>

<?php
		}
		else
			echo "Neovlašten pristup, molimo prijavite se";

?>
</body>
</html>