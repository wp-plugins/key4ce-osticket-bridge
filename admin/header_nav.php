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
<ul class="key4ce_adostmenu">
  <li><a href="admin.php?page=ost-config" class="<?php echo $active1; ?>"><span><?php echo __("Data Config", 'key4ce-osticket-bridge'); ?></span></a></li>
  <li><a href="admin.php?page=ost-settings" class="<?php echo $active2; ?>"><span><?php echo __("osT-Settings", 'key4ce-osticket-bridge'); ?></span></a></li>
  <li><a href="admin.php?page=ost-emailtemp" class="<?php echo $active3; ?>"><span><?php echo __("Email Templates", 'key4ce-osticket-bridge'); ?></span></a></li>
  <li><a href="admin.php?page=ost-tickets" class="<?php echo $active4; ?>"><span><?php echo __("Support Tickets", 'key4ce-osticket-bridge'); ?></span></a></li>
</ul>
<div style="padding-bottom:15px;"></div>
<?php
if($parurl=="page=ost-tickets") { 
if (($newticket=="") || ($adminreply=="") || ($postconfirm==""))
    {
    echo '<div id="warning"><b>Warning:</b>'.__('1 or more of your email templates is not setup', 'key4ce-osticket-bridge').'&nbsp;&raquo;&nbsp;<a href="admin.php?page=ost-emailtemp">'.__('Click Here', 'key4ce-osticket-bridge').'</a></div>';
    }
}
?>
