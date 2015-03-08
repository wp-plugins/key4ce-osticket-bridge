<?php
/*
Template Name: ost-config
*/
?>
<?php require_once( WP_PLUGIN_DIR . '/key4ce-osticket-bridge/includes/udscript.php' ); ?>
<div class="key4ce_wrap">
<div class="key4ce_headtitle"><?php echo __("osTicket Data Configuration", 'key4ce-osticket-bridge'); ?></div>
<div style="clear: both"></div>
<?php require_once( WP_PLUGIN_DIR . '/key4ce-osticket-bridge/admin/header_nav.php' ); ?>
<div id="key4ce_tboxwh" class="key4ce_pg1"><?php echo __("View or edit your OSTicket database information, you should already have osTicket installed to your server, view the osticket-folder/include/ost-config.php file. Look for DBHOST, DBNAME & DBUSER for the info required below.", 'key4ce-osticket-bridge'); ?><div style="padding:4px;"></div><?php echo __("Landing Page Name: The welcome page can be any name you want: Support, Helpdesk, Contact-Us, ext...the plugin will create this page. Note: If this page exists it will be over written, also this cannot be the same name as your osTicket folder.", 'key4ce-osticket-bridge'); ?></div>
<div style="clear: both"></div>
<?php
	if(isset($_REQUEST['submit'])) {
	@$host=$_REQUEST['host'];
	@$database=$_REQUEST['database'];
	@$username=$_REQUEST['username'];
	@$password=$_REQUEST['password'];
    @$keyost_prefix=$_REQUEST['keyost_prefix'];
	@$keyost_version=$_REQUEST['keyost_version'];
	@$keyost_usercloseticket = ($_REQUEST['keyost_usercloseticket']=="on") ? '1' : '0';
	@$supportpage=$_REQUEST['supportpage'];
	@$contactticketpage=$_REQUEST['contactticketpage'];
	@$thankyoupage=$_REQUEST['thankyoupage'];
	$config=array('host'=>$host, 'database'=>$database, 'username'=>$username,'password'=>$password,'keyost_prefix'=>$keyost_prefix,'keyost_version'=>$keyost_version,'keyost_usercloseticket'=>$keyost_usercloseticket,'supportpage'=>$supportpage,'contactticketpage'=>$contactticketpage,'thankyoupage'=>$thankyoupage);          
	if (($_REQUEST['host']=="") || ($_REQUEST['database']=="") || ($_REQUEST['username']=="") || ($_REQUEST['supportpage']=="") )
	{
	echo '<div id="failed"><b>'.__("Error:", 'key4ce-osticket-bridge').'</b>'.__("All fields are required below for the database...", 'key4ce-osticket-bridge').'</div><div style="clear: both"></div>';
	}
	else
	{
	$current_user = wp_get_current_user();	
		global $wpdb;
		$osticketpagecheck = $wpdb->get_var("SELECT count(*) as no FROM $wpdb->posts WHERE post_content='[addosticket]' AND post_status='publish'");		
		if ($osticketpagecheck == 0)
		{ 
		wp_insert_post(array('comment_status'		=>'closed',
						'ping_status'		=>'closed',
						'post_author'		=>$current_user->ID,
						'post_name'		=>$supportpage,
						'post_title'		=>$supportpage,
						'post_content' 		=> '[addosticket]', 
						'post_status'		=>'publish',
						'post_type'		=>'page'
					));
		}
		$contactticketpagecheck = $wpdb->get_var("SELECT count(*) as no FROM $wpdb->posts WHERE `post_content` LIKE '%[addoscontact]%' AND post_status='publish'");			
		if ($contactticketpagecheck <= 0)
		{ 
		wp_insert_post(array('comment_status'		=>'closed',
						'ping_status'		=>'closed',
						'post_author'		=>$current_user->ID,
						'post_name'		=>get_the_title($contactticketpage),
						'post_title'		=>get_the_title($contactticketpage),
						'post_content' 		=> '[addoscontact]', 
						'post_status'		=>'publish',
						'post_type'		=>'page'
					));
		}	
	update_option('os_ticket_config', $config);
	$config = get_option('os_ticket_config');
	extract($config);
	$config = get_option('os_ticket_config');
	extract($config);
	$ost_wpdb = new wpdb($username, $password, $database, $host);
	$ticket_cdata=$keyost_prefix.'ticket__cdata';
	$crt_cdata="CREATE TABLE IF NOT EXISTS $ticket_cdata (
  `ticket_id` int(11) unsigned NOT NULL DEFAULT '0',
  `subject` mediumtext,
  `priority` mediumtext,
  PRIMARY KEY (`ticket_id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8";
	$ost_wpdb->query($crt_cdata);
	global $ost;
	$ticket_cdata=$keyost_prefix."ticket__cdata";
	$osinstall="osTicket Installed!";
	$osticid=1;
	$prior=2;
	$result1=$ost_wpdb->get_results("SELECT ticket_id FROM $ticket_cdata WHERE subject = '".$osinstall."'");
	if (count ($result1) > 0) { 
	$row = current ($result1);
	} else { 
	$ost_wpdb->query ("
	INSERT INTO $ticket_cdata (ticket_id,subject,priority) 
	VALUES ('".$osticid."', '".$osinstall."', '".$prior."')");
	} 

?>
<div id="key4ce_succes" class="key4ce_fade"><?php echo __("Your settings saved successfully...Thank you!", 'key4ce-osticket-bridge'); ?></div>
<div style="clear: both"></div>
<?php
}
}
$config = get_option('os_ticket_config');
extract($config);
?>
<form name="mbform" action="admin.php?page=ost-config" method="post">
<table class="key4ce_cofigtb">
<tr>
<td class="key4ce_config_td"><label class="key4ce_config_label"><?php echo __("Host Name:", 'key4ce-osticket-bridge'); ?></label></td>                
<td><input type="text" name="host" id="host" size="20" value="<?php echo @$host;?>"/>&nbsp;&nbsp;<?php echo __("( Normally this is localhost )", 'key4ce-osticket-bridge'); ?></td>
</tr>
<tr>
<td class="key4ce_config_td"><label class="key4ce_config_label"><?php echo __("Database Name:", 'key4ce-osticket-bridge'); ?></label></td>                
<td><input type="text" name="database" id="database" size="20" value="<?php echo @$database;?>"/>&nbsp;&nbsp;<?php echo __("( osTicket Database Name Goes Here )", 'key4ce-osticket-bridge'); ?></td>
</tr>
<tr>
<td class="key4ce_config_td"><label class="key4ce_config_label"><?php echo __("Database Username:", 'key4ce-osticket-bridge'); ?></label></td>                
<td><input type="text" name="username" id="username" size="20" value="<?php echo @$username;?>"/>&nbsp;&nbsp;<?php echo __("( osTicket Database Username Goes Here )", 'key4ce-osticket-bridge'); ?></td>
</tr>
<tr>
<td class="key4ce_config_td"><label class="key4ce_config_label"><?php echo __("Database Password:", 'key4ce-osticket-bridge'); ?></label></td>                
<td><input type="password" name="password" id="password" size="20" value="<?php echo @$password;?>"/>&nbsp;&nbsp;<?php echo __("( osTicket Database Password Goes Here )", 'key4ce-osticket-bridge'); ?></td>
</tr>
<tr>
<td class="key4ce_config_td"><label class="key4ce_config_label"><?php echo __("Database Prefix:", 'key4ce-osticket-bridge'); ?></label></td>                
<td><input type="text" name="keyost_prefix" id="keyost_prefix" size="20" value="<?php echo @$keyost_prefix;?>"/>&nbsp;&nbsp;<?php echo __("( osTicket Database Prefix Goes Here )", 'key4ce-osticket-bridge'); ?></td>
</tr>
<tr>
<td class="key4ce_config_td"><label class="key4ce_config_label"><?php echo __("Osticket Version:", 'key4ce-osticket-bridge'); ?></label></td>                
<td>
<?php 
if(@$keyost_version==194)
		@$keyost_version_194="selected='selected'";
	else
		@$keyost_version_19="selected='selected'";
?>
<select name="keyost_version" id="keyost_version">
<option value="19" <?php echo @$keyost_version_19; ?>>Ver. <=1.9.4</option>
<option value="194" <?php echo @$keyost_version_194; ?>>Ver. >=1.9.4</option>
</select>&nbsp;&nbsp;<?php echo __("(Select Osticket Version)", 'key4ce-osticket-bridge'); ?>
</td>
</tr>
<tr>
<td class="key4ce_config_td"><label class="key4ce_config_label"><?php echo __("Enable Closing Ticket By User:", 'key4ce-osticket-bridge'); ?></label></td>                
<td><input type="checkbox" name="keyost_usercloseticket" id="keyost_usercloseticket" <?php echo (@$keyost_usercloseticket=="1") ? 'checked' : ''; ?>/>&nbsp;&nbsp;</td>
</tr>
<tr>
<td class="key4ce_config_td"><label class="key4ce_config_label"><?php echo __("Landing Page Name:", 'key4ce-osticket-bridge'); ?></label></td>                
<td>
<input type="text" name="supportpage" id="supportpage" size="20" value="<?php echo $supportpage;?>"/>&nbsp;&nbsp;<?php echo __("Landing Page Name( Create this page...read Landing Page Note above! )", 'key4ce-osticket-bridge'); ?></td>
</tr>
<tr>
<td class="key4ce_config_td"><label class="key4ce_config_label"><?php echo __("Contact Ticket Page:", 'key4ce-osticket-bridge'); ?></label></td>                
<td>
<select name="contactticketpage" id="key4ce_contactticketpage">
<?php $args = array(
	'sort_order' => 'ASC',
	'sort_column' => 'post_title',
	'hierarchical' => 5,	
	'child_of' => 0,
	'parent' => -1,
	'offset' => 0,
	'post_type' => 'page',
	'post_status' => 'publish'
); 
$pages = get_pages($args); 
foreach($pages as $page)
{
	if($contactticketpage==$page->ID)
		$selectedpage="selected='selected'";
	else
		$selectedpage="";
?><option value="<?php echo $page->ID;?>" <?php echo $selectedpage;?>><?php echo $page->post_title; ?></option>
<?php	} ?>
</select>&nbsp;&nbsp;<?php echo __("(Select contact ticket page)", 'key4ce-osticket-bridge'); ?>
</td>
</tr>
<tr>
<td class="key4ce_config_td"><label class="key4ce_config_label"><?php echo __("Thank You Page:", 'key4ce-osticket-bridge'); ?></label></td>                
<td>
<select name="thankyoupage" id="key4ce_thankyoupage">
<?php $args = array(
	'sort_order' => 'ASC',
	'sort_column' => 'post_title',
	'hierarchical' => 5,	
	'child_of' => 0,
	'parent' => -1,
	'offset' => 0,
	'post_type' => 'page',
	'post_status' => 'publish'
); 
$pages = get_pages($args); 
foreach($pages as $page)
{
	if($thankyoupage==$page->ID)
		$selectedpage="selected='selected'";
	else
		$selectedpage="";
?><option value="<?php echo $page->ID;?>" <?php echo $selectedpage;?>><?php echo $page->post_title; ?></option>
<?php	} ?>
</select>&nbsp;&nbsp;<?php echo __("(Select thank you page)", 'key4ce-osticket-bridge'); ?>
</td>
</tr>
</table>
<div style="padding: 30px;">
<input type="submit" name="submit" class="key4ce_button-primary" value="<?php echo __('Save Changes', 'key4ce-osticket-bridge'); ?>" />
</div>
</form>
</div><!--End of wrap-->
<?php wp_enqueue_script('ost-bridge-fade',plugins_url('../js/fade.js',__FILE__));?>

