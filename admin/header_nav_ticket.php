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
<style>
	.key4ce_createticket{-webkit-border-radius: 4px;-moz-border-radius: 4px;border-radius: 4px;background:#1e8cbe;padding: 5px;text-align: center;width: 100px;}
</style>
<div style="padding-top:0px; width: 100%; display:table;">
    <div style="display:table-cell;float: left;margin-left: 10px;width: 70px;"><div class="key4ce_createticket"><a style="color: white; text-decoration: none;" href="admin.php?page=ost-create-ticket"><?php echo __("Create Ticket", 'key4ce-osticket-bridge'); ?></a></div></div>
<div style="display:table-cell;">
<ul class="key4ce_adostmenu" style="width: 100%; max-width: 500px">
 <li><a href="admin.php?page=ost-tickets&service=list&status=open" class="<?php echo $active1; ?>"><span><?php echo __("Open", 'key4ce-osticket-bridge'); ?> (<?php echo "$ticket_count_open"; ?>)</span></a></li>
  <li><a href="admin.php?page=ost-tickets&service=list&status=answered" class="<?php echo $active2; ?>"><span><?php echo __("Answered", 'key4ce-osticket-bridge'); ?> (<?php echo "$ticket_count_answered"; ?>)</span></a></li>
  <li><a href="admin.php?page=ost-tickets&service=list&status=closed" class="<?php echo $active3; ?>"><span><?php echo __("Closed", 'key4ce-osticket-bridge'); ?> (<?php echo "$ticket_count_closed"; ?>)</span></a></li>
  <li><a href="admin.php?page=ost-tickets&service=list&status=all" class="<?php echo $active4; ?>"><span><?php echo __("All", 'key4ce-osticket-bridge'); ?> (<?php echo "$ticket_count_all"; ?>)</span></a></li>
</ul>
</div>
<div style="vertical-align:middle; display:table-cell; width:400px;">
<div id='key4ce_search_box' style="float:right;">
	<form name='search' method='POST' enctype='multipart/form-data' onsubmit='return validateFormSearch()'>
	<?php echo __("Search", 'key4ce-osticket-bridge'); ?>&nbsp;
	<input type='hidden' name='service' value='list'> 
	<input type='text' name='tq' id='tq' value="<?php @$_REQUEST['tq'] ?>">&nbsp;&nbsp;
	<input type='submit' name='search' class='key4ce_button-primary' value="<?php echo __('Go >>', 'key4ce-osticket-bridge'); ?>">
	</form></div>
    
</div>
</div>
<?php
if($parurl=="page=ost-tickets") { 
if (($newticket=="") || ($adminreply=="") || ($postconfirm==""))
    {
    echo '<div id="warning"><b>'.__("Warning:", 'key4ce-osticket-bridge').'</b>'.__("1 or more of your email templates is not setup", 'key4ce-osticket-bridge').'&nbsp;&raquo;&nbsp;<a href="admin.php?page=ost-emailtemp">'.__("Click Here", 'key4ce-osticket-bridge').'</a></div>';
    }
}
?>
