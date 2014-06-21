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


$default_email_id=$ost_wpdb->get_var("SELECT value FROM `ost_config` WHERE `key` LIKE 'default_email_id'");
$default_email_id_data=$ost_wpdb->get_row("SELECT * FROM `ost_email` WHERE `email_id` =$default_email_id");
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
<td class="config_td"><label class="config_label">Email per OSTicket dep.:</label></td>                
<td><textarea name="reply_mailOver" id="reply_mailOver" ROWS="10" value="<?php echo $reply_mailOver; ?>"></textarea>&nbsp;&nbsp;(To be fixed based up on OSTicket settings in the future)</td>
</tr>
</table>
<div style="padding-left: 30px;">
<input type="submit" name="ost-settings" class="button-primary" value="Save Settings" />
</div>
</form>
</div><!--End wrap-->
