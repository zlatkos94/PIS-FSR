function startTime() {
    var today=new Date();
    var h=today.getHours();
    var m=today.getMinutes();
    var s=today.getSeconds();
	var d=today.getDate();
	var mm=today.getMonth();
	var y=today.getFullYear()
    m = checkTime(m);
    s = checkTime(s);
    document.getElementById('txt').innerHTML = "<b>Vrijeme:</b> "+h+":"+m+":"+s+ " <b>Datum:</b> "+d+"/"+mm+"/"+y+"    Za prijavu posjetite <b>'fsr.sve-mo.ba'</b> <b>Vrijeme:</b> "+h+":"+m+":"+s+ " <b>Datum:</b> "+d+"/"+mm+"/"+y+"    </b>";
    var t = setTimeout(function(){startTime()},1000);
}

function checkTime(i) {
    if (i<10) {i = "0" + i};  // add zero in front of numbers < 10
    return i;
}