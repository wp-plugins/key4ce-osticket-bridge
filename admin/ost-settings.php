<?php
/*
Template Name: ost-settings
*/
?>
<?php require_once( WP_PLUGIN_DIR . '/key4ce-osticket-bridge/includes/udscript.php' ); ?>
<div class="wrap">
<div class="headtitle">osTicket Settings</div>
<div style="clear: both"></div>
<?php require_once( WP_PLUGIN_DIR . '/key4ce-osticket-bridge/admin/header_nav.php' ); ?>
<div id="tboxwh" class="pg1">Some simple plugin settings for Wordpress.</div>
<div style="clear: both"></div>
<?php 

require_once( WP_PLUGIN_DIR . '/key4ce-osticket-bridge/admin/db-settings.php' );
$default_email_id=$ost_wpdb->get_var("SELECT value FROM ".$keyost_prefix."config WHERE `key` LIKE 'default_email_id'");
$default_email_id_data=$ost_wpdb->get_row("SELECT * FROM ".$keyost_prefix."email WHERE `email_id` =$default_email_id");
$default_email=$default_email_id_data->email;
$defalt_name=$default_email_id_data->name;
?>
<form name="ost-settings" action="admin.php?page=ost-settings" method="post">
<input type="hidden" name="adname" value="<?php echo $admin_fname; ?> <?php echo $admin_lname; ?>"/>
<table class="cofigtb">
<tr>
<td class="config_td"><label class="config_label">Support Center Status:</label></td>
<td>&nbsp;<input type="radio" name="online" id="enabled" class="enabled" value="1" <?php if($isactive=="1") echo "checked";?>/><font color="green">Online</font> (Active) &nbsp;&nbsp;<input type="radio" name="online" id="disabled" class="disabled" value="0" <?php if($isactive!="1") echo "checked";?>/><font color="red">Offline</font><span style="padding-left:20px;">( offline will display maintenance message on website )</span></td> 
</tr>
<tr>
<td class="config_td"><label class="config_label">Helpdesk Name/Title:</label></td>                
<td><input type="text" name="title_name" id="title_name" size="20" value="<?php echo $title_name; ?>"/>&nbsp;&nbsp;( displayed in emails & welcome/user pages )</td>
</tr>
<tr>
<td class="config_td"><label class="config_label">Maximum Open Tickets:</label></td>                
<td><input type="text" name="max_open_tickets" id="max_open_tickets" size="20" value="<?php echo $max_open_tickets; ?>"/>&nbsp;&nbsp;( per/user - enter 0 for unlimited )</td>
</tr>
<tr>
<td class="config_td"><label class="config_label">Reply Separator Tag:</label></td>                
<td><input type="text" name="reply_sep" id="reply_sep" size="20" value="<?php echo $reply_sep; ?>"/>&nbsp;&nbsp;( should be blank - if you are email polling...read &raquo; <a href="javascript:doMenu2('main2');" id="xmain2">[+]</a> )</td>
</tr>
<tr>
<td class="note" colspan="2">
<div id="main2" style="display: none;">
Note: If email polling, login to: osTicket->Emails->Templates->Response/Reply Template remove %{ticket.client_link}<br />Replace with &raquo; <?php echo site_url()."/$dirname/?service=view&ticket="; ?>%{ticket.number} &laquo;
</div>
</td>
</tr>
<tr>
<td class="config_td"><label class="config_label">SMTP Status</label></td>                
<td>
<?php 
if($smtp_status=="enable")
	$enable="selected";
else
	$disable="selected";
?>
<select name="smtp_status" id="smtp_status">
<option value="enable" <?php echo $enable;?>>Enable</option>
<option value="disable" <?php echo $disable;?>>Disable</option>
</select>&nbsp;&nbsp;(Please select smtp status.)</td>
</tr>
<tr>
<td class="config_td"><label class="config_label">SMTP Username</label></td>                
<td><input type="text" name="smtp_username" id="smtp_username"  value="<?php echo $smtp_username; ?>"/>&nbsp;&nbsp;(Please enter smtp username.)</td>
</tr>
<tr>
<td class="config_td"><label class="config_label">SMTP Password</label></td>                
<td><input type="password" name="smtp_password" id="smtp_password"  value="<?php echo $smtp_password; ?>"/>&nbsp;&nbsp;(Please enter smtp password.)</td>
</tr>
<tr>
<td class="config_td"><label class="config_label">SMTP Host</label></td>                
<td><input type="text" name="smtp_host" id="smtp_host"  value="<?php echo $smtp_host; ?>"/>&nbsp;&nbsp;(Please enter smtp host.)</td>
</tr>
<tr>
<td class="config_td"><label class="config_label">SMTP Port</label></td>                
<td><input type="text" name="smtp_port" id="smtp_port"  value="<?php echo $smtp_port; ?>"/>&nbsp;&nbsp;(Please enter smtp port.)</td>
</tr>
</table>
<div style="padding-left: 30px;">
<input type="submit" name="ost-settings" class="button-primary" value="Save Settings" />
</div>
</form>
</div><!--End wrap-->