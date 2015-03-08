<?php
/*
Template Name: ost-settings
*/
?>
<?php require_once( WP_PLUGIN_DIR . '/key4ce-osticket-bridge/includes/udscript.php' ); ?>
<div class="key4ce_wrap">
<div class="key4ce_headtitle"><?php echo __("osTicket Settings", 'key4ce-osticket-bridge'); ?></div>
<div style="clear: both"></div>
<?php require_once( WP_PLUGIN_DIR . '/key4ce-osticket-bridge/admin/header_nav.php' ); ?>
<div id="key4ce_tboxwh" class="key4ce_pg1"><?php echo __("Some simple plugin settings for Wordpress.", 'key4ce-osticket-bridge'); ?></div>
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
<table class="key4ce_cofigtb">
<tr>
<td class="key4ce_config_td"><label class="key4ce_config_label"><?php echo __("Support Center Status:", 'key4ce-osticket-bridge'); ?></label></td>
<td>&nbsp;<input type="radio" name="online" id="enabled" class="enabled" value="1" <?php if($isactive=="1") echo "checked";?>/><font color="green"><?php echo __("Online", 'key4ce-osticket-bridge'); ?></font><?php echo __("(Active)", 'key4ce-osticket-bridge'); ?> &nbsp;&nbsp;<input type="radio" name="online" id="disabled" class="disabled" value="0" <?php if($isactive!="1") echo "checked";?>/><font color="red"><?php echo __("Offline", 'key4ce-osticket-bridge'); ?></font><span style="padding-left:20px;"><?php echo __("( offline will display maintenance message on website )", 'key4ce-osticket-bridge'); ?></span></td> 
</tr>
<tr>
<td class="key4ce_config_td"><label class="key4ce_config_label"><?php echo __("Helpdesk Name/Title:", 'key4ce-osticket-bridge'); ?></label></td>                
<td><input type="text" name="title_name" id="title_name" size="20" value="<?php echo $title_name; ?>"/>&nbsp;&nbsp;<?php echo __("( displayed in emails & welcome/user pages )", 'key4ce-osticket-bridge'); ?></td>
</tr>
<tr>
<td class="key4ce_config_td"><label class="key4ce_config_label"><?php echo __("Maximum Open Tickets:", 'key4ce-osticket-bridge'); ?></label></td>                
<td><input type="text" name="max_open_tickets" id="max_open_tickets" size="20" value="<?php echo $max_open_tickets; ?>"/>&nbsp;&nbsp;<?php echo __("( per/user - enter 0 for unlimited )", 'key4ce-osticket-bridge'); ?></td>
</tr>
<tr>
<td class="key4ce_config_td"><label class="key4ce_config_label"><?php echo __("Reply Separator Tag:", 'key4ce-osticket-bridge'); ?></label></td>                
<td><input type="text" name="reply_sep" id="reply_sep" size="20" value="<?php echo $reply_sep; ?>"/>&nbsp;&nbsp;<?php echo __("( should be blank - if you are email polling...read", 'key4ce-osticket-bridge'); ?> &raquo; <a href="javascript:doMenu2('main2');" id="xmain2"><?php echo __("[+]", 'key4ce-osticket-bridge'); ?></a><?php echo __(" )", 'key4ce-osticket-bridge'); ?></td>
</tr>
<tr>
<td class="key4ce_note" colspan="2">
<div id="main2" style="display: none;">
<?php echo __("Note: If email polling, login to: osTicket->Emails->Templates->Response/Reply Template remove %{ticket.client_link}", 'key4ce-osticket-bridge'); ?>
<br /><?php echo __("Replace with", 'key4ce-osticket-bridge'); ?> &raquo; <?php echo site_url()."/$dirname/?service=view&ticket="; ?><?php echo __("%{ticket.number}", 'key4ce-osticket-bridge'); ?> &laquo;
</div>
</td>
</tr>
<tr>
<td class="key4ce_config_td"><label class="key4ce_config_label"><?php echo __("SMTP Status", 'key4ce-osticket-bridge'); ?></label></td>                
<td>
<?php 
if($smtp_status=="enable")
	$enable="selected";
else
	$disable="selected";
?>
<select name="smtp_status" id="smtp_status">
<option value="enable" <?php echo @$enable;?>><?php echo __("Enable", 'key4ce-osticket-bridge'); ?></option>
<option value="disable" <?php echo @$disable;?>><?php echo __("Disable", 'key4ce-osticket-bridge'); ?></option>
</select>&nbsp;&nbsp;<?php echo __("(Please select smtp status.)", 'key4ce-osticket-bridge'); ?></td>
</tr>
<tr>
<td class="key4ce_config_td"><label class="key4ce_config_label"><?php echo __("SMTP Username", 'key4ce-osticket-bridge'); ?></label></td>                
<td><input type="text" name="smtp_username" id="smtp_username"  value="<?php echo $smtp_username; ?>"/>&nbsp;&nbsp;(<?php echo __("Please enter smtp username.", 'key4ce-osticket-bridge'); ?>)</td>
</tr>
<tr>
<td class="key4ce_config_td"><label class="key4ce_config_label"><?php echo __("SMTP Password", 'key4ce-osticket-bridge'); ?></label></td>                
<td><input type="password" name="smtp_password" id="smtp_password"  value="<?php echo $smtp_password; ?>"/>&nbsp;&nbsp;(<?php echo __("Please enter smtp password.", 'key4ce-osticket-bridge'); ?>)</td>
</tr>
<tr>
<td class="key4ce_config_td"><label class="key4ce_config_label"><?php echo __("SMTP Host", 'key4ce-osticket-bridge'); ?></label></td>                
<td><input type="text" name="smtp_host" id="smtp_host"  value="<?php echo $smtp_host; ?>"/>&nbsp;&nbsp;(<?php echo __("Please enter smtp host.", 'key4ce-osticket-bridge'); ?>)</td>
</tr>
<tr>
<td class="key4ce_config_td"><label class="key4ce_config_label"><?php echo __("SMTP Port", 'key4ce-osticket-bridge'); ?></label></td>                
<td><input type="text" name="smtp_port" id="smtp_port"  value="<?php echo $smtp_port; ?>"/>&nbsp;&nbsp;(<?php echo __("Please enter smtp port.", 'key4ce-osticket-bridge'); ?>)</td>
</tr>
</table>
<div style="padding-left: 30px;">
<input type="submit" name="ost-settings" class="key4ce_button-primary" value="<?php echo __("Save Settings", 'key4ce-osticket-bridge'); ?>" />
</div>
</form>
</div><!--End wrap-->