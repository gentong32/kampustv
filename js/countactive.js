var count = 0;
var myInterval;

// window.addEventListener('focus', startTimer);
// window.addEventListener('blur', stopTimer);

function timerHandler() {
	if (player.getPlayerState()==1) {
		count++;
	}
	if (count==10)
		alert("OKE KAMU SUDAH MENONTON MINIMAL 10 detik");
	document.getElementById("seconds").innerHTML = "Durasi menonton: "+count+" detik ";
}

function startTimer() {
	window.clearInterval(myInterval);
	myInterval = window.setInterval(timerHandler, 1000);
}

function stopTimer() {
	window.clearInterval(myInterval);
}

function onFocus(){ console.log('browser window activated'); startTimer()}
function onBlur(){ console.log('browser window deactivated'); stopTimer()}

var inter;
var iframeFocused;
window.focus();      // I needed this for events to fire afterwards initially
addEventListener('focus', function(e){
	console.log('global window focused');
	if(iframeFocused){
		console.log('iframe lost focus');
		iframeFocused = false;
		//clearInterval(inter);
	}
	else onFocus();
});

addEventListener('blur', function(e){
	console.log('global window lost focus');
	if(document.hasFocus()){
		console.log('iframe focused');
		iframeFocused = true;
		inter = setInterval(()=>{
			if(!document.hasFocus()){
				console.log('iframe lost focus');
				iframeFocused = false;
				onBlur();
				clearInterval(inter);
			}
		},100);
	}
	else onBlur();
});
