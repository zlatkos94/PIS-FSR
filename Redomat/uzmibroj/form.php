<html>
<head>
<link href="../jquery/jquery-ui.css" rel="stylesheet">
<script src="../jquery/external/jquery/jquery.js"></script>
<script src="../jquery/jquery-ui.js"></script>
<style>
#selectmenu{
	width:100%;
	font-size:large;
}
input{
	width:185px;
}
</style>
</head>
<body>
<?php 
include '../statusbaze.php';
session_start();
?>
		 <table>
    <tr>
    <td align="right">OIB: </td><td><input id="oib" name="oib" type="text" /></td>
    </tr><tr>
    <td align="right">Aktivnost: </td><td><select id="selectmenu">
	<?php 
	$result = getAktivnost();
    while($row=mysql_fetch_array( $result )){
		echo '<option id=';
		echo $row["sifra_aktivnost"];
		echo '>';
		echo $row["naziv_aktivnost"] ;
		echo '</option>';
	}
	?>
	</select></td>
    </tr><tr>
    <td></td><td align="left"> <img src="../CaptchaSecurityImages.php?width=190&height=60&characters=5" /><br /></td>
    </tr><tr>
    <td align="right">Sifra: </td><td><input id="security_code" name="security_code" type="text" /></td>
    </tr><tr>
    <td></td><td><input type="button" id="butt" name="submit" value="Potvrdi" /></td>
    </tr>
    </table>
    	

    
    <script>
		$(document).ready(function(e) {
			$("#butt").click(function(){
				id=$("#selectmenu").children(":selected").attr("id");
				security= $("#security_code").val();
				oib= $("#oib").val();
				$.ajax({
           			url: "check.php",
					type: "POST",
					data: ({security_code: security, oibbroj: oib, idbroj: id, odabir: 1}),
					success: function(rez){
						var json=rez;
						if(json.greska=='err'){
							alert('greksa refresh');
							refresh();
						}
						else if(json.greska=='postoji'){
							$("#shownum").empty();
							$("#shownum").append('Greška! Broj koji je dodijeljen pod unesenim oib-om još je važeći, molimo odaberite opciju "Već imam broj" kako bi dobili više informacija.');
						}
						else{
							$("#alert").fadeOut("slow");
							$("#txtlcd2").empty();
							$("#txtlcd2").append(json.trenutnibroj);
							$("#txtlcd3").empty();
							$("#txtlcd3").append(json.broj);
							$("#txtlcd").empty();
							$("#txtlcd").append(json.prosjek);
							$("#shownum").empty();
							$("#shownum").append("Uspjeh! Vaš broj je dodijeljen. \n Vrijeme dolaska na red informativno je i kao takvo ne garantira 100% točnost, preporuča se dolazak najmanje 15 minuta ranije.");
						}
						
				}
	 		});	
			});
        });
		
	$( "#selectmenu" ).selectmenu();
	$( "#butt" ).button();
	</script>
</body>
</html>
