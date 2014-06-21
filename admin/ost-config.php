<?php
/*
Template Name: ost-config
*/
?>
<?php require_once( WP_PLUGIN_DIR . '/key4ce-osticket-bridge/includes/udscript.php' ); ?>
<div class="wrap">
<div class="headtitle">osTicket Data Configuration</div>
<div style="clear: both"></div>
<?php require_once( WP_PLUGIN_DIR . '/key4ce-osticket-bridge/admin/header_nav.php' ); ?>
<div id="tboxwh" class="pg1">View or edit your OSTicket database information, you should already have osTicket installed to your server, view the osticket-folder/include/ost-config.php file. Look for DBHOST, DBNAME & DBUSER for the info required below.<div style="padding:4px;"></div><b>Landing Page Name:</b> The welcome page can be any name you want: Support, Helpdesk, Contact-Us, ext...the plugin will create this page. <b>Note:</b> If this page exists it will be over written, also this cannot be the same name as your osTicket folder.</div>
<div style="clear: both"></div>
<?php
	if(isset($_REQUEST['submit'])) {
	$host=$_REQUEST['host'];
	$database=$_REQUEST['database'];
	$username=$_REQUEST['username'];
	$password=$_REQUEST['password'];
	$supportpage=$_REQUEST['supportpage'];
	$version=$_REQUEST['version'];
                
	$config=array('host'=>$host, 'database'=>$database, 'username'=>$username,'password'=>$password,'supportpage'=>$supportpage,'version'=>$version);
              
	if (($_REQUEST['host']=="") || ($_REQUEST['database']=="") || ($_REQUEST['username']=="") || ($_REQUEST['supportpage']=="") )
	{
	echo '<div id="failed"><b>Error:</b> All fields are required below for the database...</div><div style="clear: both"></div>';
	}
	else
	{
	$current_user = wp_get_current_user();
	$new_page_title = $supportpage;
	$new_page_name = $supportpage;
	$new_page_content = '';
	$new_page_template = ''; 
	$page_check = get_page_by_title($new_page_title);
	$new_page = array(
	'post_status' => 'publish', 
	'post_type' => 'page', 
	'post_author' => $current_user->ID, 
	'ping_status' => 'closed', 
	'comment_status' => 'closed', 
	'post_parent' => 0, 
	'menu_order' => 0, 
	'to_ping' =>  '', 
	'pinged' => '', 
	'post_password' => '', 
	'post_content' => "[addosticket]", 
	'guid' => '', 
	'post_content_filtered' => '', 
	'post_excerpt' => '', 
	'import_id' => 0, 
	'post_title' => $supportpage, 
	'page_template' => 'default');
	require_once(ABSPATH.'wp-admin/includes/theme.php');
	
	if(!isset($page_check->ID)){
	$new_page_id = wp_insert_post($new_page);
	if(!empty($new_page_template)){
	update_post_meta($new_page_id, "_wp_page_template", $new_page_template);
	}
	}
	update_option('os_ticket_config', $config);
	$config = get_option('os_ticket_config');
	extract($config);
	$con = mysql_connect($host, $username, $password, true, 65536) or die("cannot connect");
	mysql_select_db($database, $con) or die("cannot use database");
	mysql_query("
	CREATE TABLE IF NOT EXISTS ost_ticket__cdata (
  	ticket_id int(11) unsigned NOT NULL DEFAULT '0',
  	subject mediumtext,
  	priority mediumtext,
  	priority_id bigint(20) DEFAULT NULL,
  	PRIMARY KEY (ticket_id)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
	$config = get_option('os_ticket_config');
	extract($config);
	$ost_wpdb = new wpdb($username, $password, $database, $host);
	global $ost;
	$ticket_cdata="ost_ticket__cdata";
	$osinstall="osTicket Installed!";
	$osticid=1;
	$prior="Normal";
	$priorid=2;
	$result1=$ost_wpdb->get_results("SELECT ticket_id FROM $ticket_cdata WHERE subject = '".$osinstall."'");
	if (count ($result1) > 0) { 
	$row = current ($result1);
	} else { 
	$ost_wpdb->query ("
	INSERT INTO $ticket_cdata (ticket_id,subject,priority,priority_id) 
	VALUES ('".$osticid."', '".$osinstall."', '".$prior."', '".$priorid."')");
	} 

?>
<div id="succes" class="fade"><?php echo "Your settings saved successfully...Thank you!";?></div>
<div style="clear: both"></div>
<?php
}
}
$config = get_option('os_ticket_config');
extract($config);
?>
<form name="mbform" action="admin.php?page=ost-config" method="post">
<table class="cofigtb">
<tr>
<td class="config_td"><label class="config_label">Host Name:</label></td>                
<td><input type="text" name="host" id="host" size="20" value="<?php echo $host;?>"/>&nbsp;&nbsp;( Normally this is localhost )</td>
</tr>
<tr>
<td class="config_td"><label class="config_label">Database Name:</label></td>                
<td><input type="text" name="database" id="database" size="20" value="<?php echo $database;?>"/>&nbsp;&nbsp;( osTicket Database Name Goes Here )</td>
</tr>
<tr>
<td class="config_td"><label class="config_label">Database Username:</label></td>                
<td><input type="text" name="username" id="username" size="20" value="<?php echo $username;?>"/>&nbsp;&nbsp;( osTicket Database Username Goes Here )</td>
</tr>
<tr>
<td class="config_td"><label class="config_label">Database Password:</label></td>                
<td><input type="text" name="password" id="password" size="20" value="<?php echo $password;?>"/>&nbsp;&nbsp;( osTicket Database Password Goes Here )</td>
</tr>
<tr>
<td class="config_td"><label class="config_label">Landing Page Name:</label></td>                
<td><input type="text" name="supportpage" id="supportpage" size="20" value="<?php echo $supportpage;?>"/>&nbsp;&nbsp;( Create this page...read <b>Landing Page Note</b> above! )</td>
</tr>
</table>
<div style="padding: 30px;">
<input type="submit" name="submit" class="button-primary" value="Save Changes" />
</div>
</form>
</div><!--End of wrap-->
<script language="javascript" src="<?php echo plugin_dir_url(__FILE__).'../js/fade.js';?>"></script>
