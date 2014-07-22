<?php
/*
Template Name: header_nav
*/
?>
<?php 
echo '<link rel="stylesheet" type="text/css" media="all" href="'.plugin_dir_url(__FILE__).'../css/stylesheet.css">';
$parurl=$_SERVER['QUERY_STRING'];
if($parurl=="page=ost-tickets" || $parurl=="page=ost-tickets&service=list&status=open") { $active1="active"; }
if($parurl=="page=ost-tickets&service=list&status=answered") { $active2="active"; }
if($parurl=="page=ost-tickets&service=list&status=closed") { $active3="active"; } 
if($parurl=="page=ost-tickets&service=list&status=all") { $active4="active"; }
?>
<div style="padding-top:0px; width: 100%; display:table;">
<div style="display:table-cell;">
<ul class="adostmenu" style="width: 100%; max-width: 500px">
 <li><a href="admin.php?page=ost-tickets&service=list&status=open" class="<?php echo $active1; ?>"><span>Open (<?php echo "$ticket_count_open"; ?>)</span></a></li>
  <li><a href="admin.php?page=ost-tickets&service=list&status=answered" class="<?php echo $active2; ?>"><span>Answered (<?php echo "$ticket_count_answered"; ?>)</span></a></li>
  <li><a href="admin.php?page=ost-tickets&service=list&status=closed" class="<?php echo $active3; ?>"><span>Closed (<?php echo "$ticket_count_closed"; ?>)</span></a></li>
  <li><a href="admin.php?page=ost-tickets&service=list&status=all" class="<?php echo $active4; ?>"><span>All (<?php echo "$ticket_count_all"; ?>)</span></a></li>
</ul>
</div>
<div style="vertical-align:middle; display:table-cell; width:400px;">
<div id='search_box' style="float:right;">
	<form name='search' method='POST' enctype='multipart/form-data' onsubmit='return validateFormSearch()'>
	Search&nbsp;
	<input type='hidden' name='service' value='list'> 
	<input type='text' name='tq' id='tq' value="<?php @$_REQUEST['tq'] ?>">&nbsp;&nbsp;
	<input type='submit' name='search' class='button-primary' value='Go >>'>
	</form></div>
    
</div>
</div>
<?php 
if($parurl=="page=ost-tickets") { 
if (($newticket=="") || ($adminreply=="") || ($postconfirm==""))
    {
    echo '<div id="warning"><b>Warning:</b> 1 or more of your email templates is not setup&nbsp;&raquo;&nbsp;<a href="admin.php?page=ost-emailtemp">Click Here</a></div>';
    }
}
?>