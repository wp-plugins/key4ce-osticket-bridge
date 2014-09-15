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
