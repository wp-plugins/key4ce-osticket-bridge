<?php
@session_start();
/* Template Name: contact_ticket.php */
$config = get_option('os_ticket_config');
extract($config);
$ost_wpdb = new wpdb($username, $password, $database, $host);
global $current_user;
$config_table=$keyost_prefix."config";
$dept_table=$keyost_prefix."department";
$topic_table=$keyost_prefix."help_topic";
$ticket_table=$keyost_prefix."ticket";
$ticket_event_table=$keyost_prefix."ticket_event";
$priority_table=$keyost_prefix."ticket_priority";
$thread_table=$keyost_prefix."ticket_thread";
$ticket_cdata=$keyost_prefix."ticket__cdata";
$ost_user=$keyost_prefix."user";
$ost_staff=$keyost_prefix."staff";
$ost_useremail=$keyost_prefix."user_email";
require_once( WP_PLUGIN_DIR . '/key4ce-osticket-bridge/includes/versionData.php'); 
require_once(WP_PLUGIN_DIR .'/key4ce-osticket-bridge/osticket-wp.php' );
require_once( WP_PLUGIN_DIR . '/key4ce-osticket-bridge/templates/contact_nav_bar.php'); 
require_once( WP_PLUGIN_DIR . '/key4ce-osticket-bridge/lib/captcha/simple-php-captcha.php');  
$url = plugins_url();
$default_email_id = $ost_wpdb->get_var("SELECT value FROM " . $keyost_prefix . "config WHERE `key` LIKE 'default_email_id'");
$default_email_id_data = $ost_wpdb->get_row("SELECT name FROM " . $keyost_prefix . "email WHERE `email_id` =$default_email_id");
$title_name = $default_email_id_data->name;
?>
<style>
#key4ce_wp-message-wrap{border:2px solid #CCCCCC;border-radius: 5px;padding: 5px;width: 75%;}
#key4ce_message-html{height: 25px;}
#key4ce_message-tmce{height: 25px;}
</style>
<script language="javascript" src="<?php echo $url.'/key4ce-osticket-bridge/js/validate.js'; ?>"></script>
<div id="key4ce_thContainer">
<?php
if(isset($_REQUEST['create-contact-ticket']) && isset($_REQUEST["magicword"]) &&  $_REQUEST["magicword"]!="" && strtolower($_SESSION ["captcha"]["code"])==strtolower($_REQUEST["magicword"]))
{
$_SESSION['captcha'] = simple_php_captcha();
?>

<div class="key4ce_clear" style="padding: 5px;"></div>
<p id="key4ce_msg_notice"><?php echo __('A new request has been created successfully!','key4ce-osticket-bridge'); ?></p>
<p align="center">
<br />
 <i><?php echo __('We are currently notifying the selected department staff...','key4ce-osticket-bridge'); ?></i>
<br /><br />
<center><script language="javascript" src="<?php echo plugin_dir_url(__FILE__).'../js/timerbar.js';?>"></script></center>
<br />
<center><?php echo __('Thank you for contacting us!','key4ce-osticket-bridge'); ?></center>
</p>
<?php
 } else {
$_SESSION['captcha'] = simple_php_captcha();
if(isset($_REQUEST['magicword']))
	echo "<div style='color: red;font-weight: bold;'>Please enter valid captcha</div>";
?>
<div id="key4ce_new_ticket">
<div id="key4ce_new_ticket_text2"><?php echo __('Please fill in the form below to open a new ticket. All fields mark with [<font color=red>*</font>] <em>Are Required!','key4ce-osticket-bridge'); ?></em></div>
<div style="clear: both"></div>
<form id="ContactticketForm" name="contactticket" method="post" enctype="multipart/form-data" onsubmit="return validateFormContactTicket();">
            <input type="hidden" name="stitle" value="<?php echo $title_name; ?>"/>
            <input type="hidden" name="sdirna" value="<?php echo $dirname; ?>"/>
            <input type="hidden" name="newtickettemp" value="<?php echo $newticket; ?>"/>
<div id="key4ce_new_ticket_name"><?php echo __('Full Name:','key4ce-osticket-bridge'); ?></div>
<div id="key4ce_new_ticket_name_input"><input class="ost" id="cur-name" type="text" name="cur-name" size="30"></div>
<div style="clear: both"></div>
<div id="key4ce_new_ticket_email"><?php echo __('Your Email:','key4ce-osticket-bridge'); ?></div>
<div id="key4ce_new_ticket_email_input"><input class="ost" id="email" type="text" name="email" size="30"></div>
<div style="clear: both"></div>
<div id="key4ce_new_ticket_catagory"><?php echo __('Catagories:','key4ce-osticket-bridge'); ?></div>
<div id="key4ce_new_ticket_catagory_input">
<select id="deptId" name="deptId">
<option value="" selected="selected"><?php echo __('Select a Category','key4ce-osticket-bridge'); ?></option>
<?php
	foreach($dept_opt as $dept) 
	{ 
	echo '<option value="'.$dept->dept_id .'">'.$dept->dept_name .'</option>'; 
        } 
?>
</select><font class="error">&nbsp;*</font></div>

<input type="hidden" value="2" name="priorityId" id="priority"/>
<div id="key4ce_new_ticket_subject"><?php echo __('Subject','key4ce-osticket-bridge'); ?>:</div>
<div id="key4ce_new_ticket_subject_input">
<input class="key4ce_ost" id="subject" type="text" name="subject" style="width: 100%;"></div>
<div style="clear: both"></div>
</div>
<table class="key4ce_welcome key4ce_nobd" align="center" cellpadding="3" cellspacing="3" border="0">
<tr>
<td class="key4ce_nobd" align="center"><div align="center" style="padding-bottom: 5px;"><?php echo __('To best assist you, please be specific and detailed in your message','key4ce-osticket-bridge'); ?><font class="error">&nbsp;*</font></div></td>
</tr>

<tr>
<td class="key4ce_nobd" align="center">
<center> <?php
$content = @$_POST['message'];
$editor_id = 'message';
$settings = array( 'media_buttons' => false );
wp_editor( $content, $editor_id , $settings );?> </center>
<div class="key4ce_clear" style="padding: 5px;"></div></td>
</tr>
<tr><td style="text-align: center;">
<?php echo '<img src="' . $_SESSION['captcha']['image_src'] . '" alt="CAPTCHA code">'; ?>
<br/><br/>
<input name="magicword" type="text">
</td></tr>
<tr>
<td class="nobd" align="center">
<p align="center" style="padding-top: 5px;"><input type="submit" name="create-contact-ticket" value="<?php echo __('Submit','key4ce-osticket-bridge'); ?>">
&nbsp;&nbsp;<input type="reset" value="<?php echo __('Reset','key4ce-osticket-bridge'); ?>"></p>
</form>
</td>
</tr>
</table>
</div>
<?php } ?>
<div class="key4ce_clear" style="padding: 10px;"></div>
