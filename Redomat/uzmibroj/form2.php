<html>
<head>
<link href="../jquery/jquery-ui.css" rel="stylesheet">
<script src="../jquery/external/jquery/jquery.js"></script>
<script src="../jquery/jquery-ui.js"></script>
</head>
<body>
<style>
input{
	width:185px;
}
</style>
<?php 
include '../statusbaze.php';
session_start();
?>
		 <table>
    <tr>
    <td align="right">OIB: </td><td><input id="oib2" name="oib" type="text" /></td>
    
    </tr><tr>
    <tr><td>
    </tr><tr>
    <td></td><td align="left"> <img src="../CaptchaSecurityImages.php?width=190&height=60&characters=5" /><br /></td>
    </tr><tr>
    <td align="right">Sifra: </td><td><input id="security_code2" name="security_code" type="text" /></td>
    </tr><tr>
    <td></td><td><input type="button" id="butt2" name="submit" value="Potvrdi" /></td>
    </tr>
    </table>
    	

    
    <script>
		$(document).ready(function(e) {
			$("#butt2").click(function(){
				security= $("#security_code2").val();
				oib= $("#oib2").val();
				$.ajax({
           			url: "check.php",
					type: "POST",
					data: ({security_code: security, oibbroj: oib, odabir: 2}),
					success: function(rez){
						var json=rez;
						if(json.greska=='err'){
							alert('greksa refresh');
							$("#alert").fadeIn("slow");
							refresh2();
						}
						else if(json.greska=='postoji'){
							$("#showhavenum").empty();
							$("#showhavenum").append('Greška! Vaš broj je istekao ili ste unijeli <b>oib</b> koji se ne nalazi u bazi, molimo preuzmite novi broj klikom na izbornik "Novi Broj".');
						}
						else{
							$("#alert").fadeOut("slow");
							$("#txtlcd2").empty();
							$("#txtlcd2").append(json.trenutnibroj);
							$("#txtlcd3").empty();
							$("#txtlcd3").append(json.broj);
							$("#txtlcd").empty();
							$("#txtlcd").append(json.prosjek);
							$("#showhavenum").empty();
							$("#showhavenum").append("Uspjeh! Vaš broj je pronađen. \n Vrijeme dolaska na red informativno je i kao takvo ne garantira 100% točnost, preporuča se dolazak najmanje 15 minuta ranije.");
						}
						
				}
	 		});	
			});
        });
		
	$( "#butt2" ).button();
	</script>
</body>
</html>
