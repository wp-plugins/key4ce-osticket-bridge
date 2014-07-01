<?php
/*
Template Name: header_nav
*/
?>
<?php 
echo '<link rel="stylesheet" type="text/css" media="all" href="'.plugin_dir_url(__FILE__).'../css/stylesheet.css">';
$parurl=$_SERVER['QUERY_STRING'];
if($parurl=="page=ost-config") { $active1="active"; } 
if($parurl=="page=ost-settings") { $active2="active"; }
if($parurl=="page=ost-emailtemp") { $active3="active"; }
if($parurl=="page=ost-tickets" || $parurl=="page=ost-tickets&service=list&status=open" || $parurl=="page=ost-tickets&service=list&status=closed") { $active4="active"; }
?>
<div style="padding-top:0px;"></div>
<ul class="adostmenu">
  <li><a href="admin.php?page=ost-config" class="<?php echo $active1; ?>"><span>Data Config</span></a></li>
  <li><a href="admin.php?page=ost-settings" class="<?php echo $active2; ?>"><span>osT-Settings</span></a></li>
  <li><a href="admin.php?page=ost-emailtemp" class="<?php echo $active3; ?>"><span>Email Templates</span></a></li>
  <li><a href="admin.php?page=ost-tickets" class="<?php echo $active4; ?>"><span>Support Tickets</span></a></li>
</ul>
<div style="padding-bottom:15px;"></div>
<?php 
if($parurl=="page=ost-tickets") { 
if (($newticket=="") || ($adminreply=="") || ($postconfirm==""))
    {
    echo '<div id="warning"><b>Warning:</b> 1 or more of your email templates is not setup&nbsp;&raquo;&nbsp;<a href="admin.php?page=ost-emailtemp">Click Here</a></div>';
    }
}
?>