<?php
/*
Template Name: osticket-wp.php
*/
if(is_user_logged_in()) {
$config = get_option('os_ticket_config');
extract($config);
?>
<link rel="stylesheet" type="text/css" media="all" href="<?php echo plugin_dir_url(__FILE__).'css/style.css'; ?>" />
<div id="ost_container"><!--ost_container Start-->
<?php require_once( WP_PLUGIN_DIR . '/key4ce-osticket-bridge/includes/functions.php' ); ?>
<?php
global $wpdb;
$ostemail = $wpdb->prefix . "ost_emailtemp"; 
$newticket=$wpdb->get_row("SELECT id,name,$ostemail.subject,$ostemail.text,created,updated FROM $ostemail where name = 'New-Ticket'"); 
$newticket=$newticket->text;

$postsubmail=$wpdb->get_row("SELECT id,name,$ostemail.subject,text,created,updated FROM $ostemail where name = 'New-Ticket'"); 
$postsubmail=$postsubmail->subject; 

$postconfirm=$wpdb->get_row("SELECT id,name,$ostemail.subject,$ostemail.text,created,updated FROM $ostemail where name = 'Post-Confirmation'"); 
$postconfirm=$postconfirm->text; 
$pcname='Post-Confirmation';

$poconsubmail=$wpdb->get_row("SELECT id,name,$ostemail.subject,text,created,updated FROM $ostemail where name = 'Post-Confirmation'"); 
$poconsubmail=$poconsubmail->subject;

$ost_wpdb = new wpdb($username, $password, $database, $host);
global $current_user;
$config_table="ost_config";
$dept_table="ost_department";
$topic_table="ost_help_topic";
$ticket_table="ost_ticket";
$ticket_event_table="ost_ticket_event";
$priority_table="ost_ticket_priority";
$thread_table="ost_ticket_thread";
$ticket_cdata="ost_ticket__cdata";
$ost_user="ost_user";
$ost_staff="ost_staff";
$ost_useremail="ost_user_email";
$directory=$config['supportpage'];
$dirname = strtolower($directory);
$version=$config['version'];
$category=@$_GET['cat'];
$status_opt=@$_GET['status'];
$ticket=@$_GET['ticket'];
$parurl=$_SERVER['QUERY_STRING'];
$page_id_chk=@$_REQUEST['page_id'];
get_currentuserinfo();
$user_email=$current_user->user_email;

$id_isonline=$ost_wpdb->get_var("SELECT id FROM $config_table WHERE $config_table.key like ('%isonline%');");
$isactive=$ost_wpdb->get_row("SELECT id,namespace,$config_table.key,$config_table.value,updated FROM $config_table where id = $id_isonline");
$isactive=$isactive->value;

//Added By Pratik Maniar on 01-05-2014 Start Here
$default_email_id=$ost_wpdb->get_var("SELECT value FROM `ost_config` WHERE `key` LIKE 'default_email_id'");
$default_email_id_data=$ost_wpdb->get_row("SELECT * FROM `ost_email` WHERE `email_id` =$default_email_id");
//Added By Pratik Maniar on 01-05-2014 End Here

//Commented By Pratik Maniar on 01-05-2014 Start Here
	//$id_helptitle=$ost_wpdb->get_var("SELECT id FROM $config_table WHERE $config_table.key like ('%helpdesk_title%');");
	//$title_name=$ost_wpdb->get_row("SELECT id,namespace,$config_table.key,$config_table.value,updated FROM $config_table where id = $id_helptitle");
	//$title_name=$default_email_id_data->name;
	//$title_name=$title_name->value;
//Commented By Pratik Maniar on 01-05-2014 End Here
$title_name=$default_email_id_data->name;
$id_maxopen=$ost_wpdb->get_var("SELECT id FROM $config_table WHERE $config_table.key like ('%max_open_tickets%');");
$max_open_tickets=$ost_wpdb->get_row("SELECT id,namespace,$config_table.key,$config_table.value,updated FROM $config_table where id = $id_maxopen");
$max_open_tickets=$max_open_tickets->value;

//Commented By Pratik Maniar on 01-05-2014 Start Here
	//$id_ademail=$ost_wpdb->get_var("SELECT id FROM $config_table WHERE $config_table.key like ('%admin_email%');");
	//$os_admin_email=$ost_wpdb->get_row("SELECT id,namespace,$config_table.key,$config_table.value,updated FROM $config_table where id = //$id_ademail");
	//$os_admin_email=$os_admin_email->value;
// Commented By Pratik Maniar on 01-05-2014 Start Here 
$os_admin_email=$default_email_id_data->email;

$id_hidename=$ost_wpdb->get_var("SELECT id FROM $config_table WHERE $config_table.key like ('%hide_staff_name%');");
$hidename=$ost_wpdb->get_row("SELECT id,namespace,$config_table.key,$config_table.value,updated FROM $config_table where id = $id_hidename");
$hidename=$hidename->value;

if($isactive!=1) { 
include WP_PLUGIN_DIR . '/key4ce-osticket-bridge/templates/message.php';
echo $offline; 
} else { 
if(isset($_REQUEST['post-reply'])) { 
require_once( WP_PLUGIN_DIR . '/key4ce-osticket-bridge/includes/postreplymail.php');
}
if(isset($_REQUEST['create-ticket'])) { 
require_once( WP_PLUGIN_DIR . '/key4ce-osticket-bridge/includes/newticketmail.php'); 
} 
require_once( WP_PLUGIN_DIR . '/key4ce-osticket-bridge/includes/versionData.php'); 
require_once( WP_PLUGIN_DIR . '/key4ce-osticket-bridge/templates/nav_bar.php'); 
}
if(isset($_GET['service']) && $_GET['service']=='new') { 
if($max_open_tickets==0 or $getNumOpenTickets<$max_open_tickets) { 
require_once( WP_PLUGIN_DIR . '/key4ce-osticket-bridge/templates/new_ticket.php'); 
} elseif ($getNumOpenTickets==$max_open_tickets) { 
include WP_PLUGIN_DIR . '/key4ce-osticket-bridge/templates/message.php'; 
echo $warning1; 
} elseif ($getNumOpenTickets>$max_open_tickets) { 
include WP_PLUGIN_DIR . '/key4ce-osticket-bridge/templates/message.php'; 
echo $warning2; 
} } 
if(isset($_GET['service']) && $_GET['service']=='view') { 
require_once( WP_PLUGIN_DIR . '/key4ce-osticket-bridge/templates/view_ticket.php'); 
} elseif (isset($_REQUEST['service']) && $_REQUEST['service']=='list') { 
require_once( WP_PLUGIN_DIR . '/key4ce-osticket-bridge/templates/list_tickets.php'); 
require_once( WP_PLUGIN_DIR . '/key4ce-osticket-bridge/templates/pagination.php'); 
 } 
 elseif ($parurl=="" || $page_id_chk) {
	if(@$_REQUEST['service']!='new')
		{
	 require_once( WP_PLUGIN_DIR . '/key4ce-osticket-bridge/templates/list_tickets.php'); 
	 require_once( WP_PLUGIN_DIR . '/key4ce-osticket-bridge/templates/pagination.php'); 
		}
 }
?>
</div><!--ost_container End-->
<?php
} else {
	$Login_args = array(
        'echo'           => true,
        'redirect'       => site_url( $_SERVER['REQUEST_URI'] ), 
        'form_id'        => 'loginform',
        'label_username' => __( 'Username' ),
        'label_password' => __( 'Password' ),
        'label_remember' => __( 'Remember Me' ),
        'label_log_in'   => __( 'Log In' ),
        'id_username'    => 'user_login',
        'id_password'    => 'user_pass',
        'id_remember'    => 'rememberme',
        'id_submit'      => 'wp-submit',
        'remember'       => true,
        'value_username' => NULL,
        'value_remember' => false
);
?><div><br /><br /> <h3>Sorry, you must first log in to view your tickets. If you do not have a account yet you can <a style="color: #2991D6;" href="<?php echo wp_registration_url(); ?>">register here</a>. </h3>
<br /><br />
<?php wp_login_form( $login_args ); ?> 
</div>
<?php } ?>
