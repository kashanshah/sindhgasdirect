function localclock()
{
	var month = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
	var day = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
	thistime = new Date()
	date=day[thistime.getDay()]+" "+thistime.getDate()+" "+month[thistime.getMonth()]+" "+(thistime.getYear() - 100 + 2000);
	var hours=thistime.getHours()
	var minutes=thistime.getMinutes()
	var seconds=thistime.getSeconds()
	
	
	if (eval(hours) <10) {hours="0"+hours}
	if (eval(minutes) < 10) {minutes="0"+minutes}
	if (seconds < 10) {seconds="0"+seconds}
	
	thistime = hours+":"+minutes+":"+seconds
	
	clockdisp.innerHTML=date+" | "+thistime+"&nbsp;"
	var timer=setTimeout("localclock()",200)
}