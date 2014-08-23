
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
/*
var x=document.forms["newticket"]["message"].value;
if (x==null || x=="")
  {
  alert("Please enter your message!");
  return false;
  }
*/
}
/*
function validateFormReply()
{
var x=document.forms["reply"]["message"].value;
if (x==null || x=="")
  {
  alert("Message field cannot be empty!");
  return false;
  }
}
*/
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
