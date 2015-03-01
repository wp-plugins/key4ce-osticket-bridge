<?php
/*
Plugin Name: Key4ce osTicket Bridge
Plugin URI: https://key4ce.com/projects/key4ce-osticket-bridge
Description: Integrate osTicket (v1.9.3 - 1.9.5) into wordpress. including user integration and scp
Version: 1.2.7
Author: Key4ce
Author URI: https://key4ce.com
License: GPLv3
Text Domain: key4ce-osticket-bridge
Domain Path: /languages/
Copyright (C) 2015  Key4ce

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see http://www.gnu.org/licenses/
*/
?>
<?php
add_action('admin_menu', 'mb_admin_menu');
add_action('admin_head', 'mb_admin_css');

register_activation_hook(__FILE__,'mb_install');
register_uninstall_hook(__FILE__,'mb_uninstall');

register_activation_hook(__FILE__,'mb_table_install');
register_activation_hook(__FILE__,'mb_database_install');

load_plugin_textdomain( 'key4ce-osticket-bridge', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
function mb_settings_link($actions, $file) {
if(false !== strpos($file, 'ost-bridge'))
    $actions['settings'] = '<a href="admin.php?page=ost-config">Config</a>';
return $actions; 
}
add_filter('plugin_action_links', 'mb_settings_link', 2, 2);
function addtemplate()
{
	 ob_start();
      require_once( WP_PLUGIN_DIR . '/key4ce-osticket-bridge/osticket-wp.php');
	$ticketpage = ob_get_clean();
	 return $ticketpage;
	
}
define('OST_SHORTCODE_ADDOSTICKET', 'addosticket');
add_shortcode(OST_SHORTCODE_ADDOSTICKET, 'addtemplate');
 function custom_toolbar_openticket() {
 	global $wp_admin_bar;	
 	$wp_admin_bar->add_menu(array('id' => 'opensupport',
	        'title' => sprintf(__('Open Tickets')),			
		'href' => get_admin_url(null,'admin.php?page=ost-tickets&service=list&status=open'),
	));
 } 
function addcontact()
{
	 ob_start();
       	require_once(WP_PLUGIN_DIR . '/key4ce-osticket-bridge/templates/contact_ticket.php');
	$contact_ticket = ob_get_clean();
	 return $contact_ticket;
}
add_shortcode('addoscontact', 'addcontact');
// Hook into the 'wp_before_admin_bar_render' action
function custom_toolbar_supportticket() {
	global $wp_admin_bar;	
	$wp_admin_bar->add_menu(array(
		'id'     => 'supportsupport',
	        'title' => sprintf(__('Support Tickets')),			
		'href' => get_admin_url(null,'admin.php?page=ost-tickets&service=list&status=all'),
	));
   
}
	// Ticket Count Short Code Start Here Added By Pratik Maniar
function addopenticketcount()
{
	$config = get_option('os_ticket_config');
	extract($config);
	$ost_wpdb = new wpdb($username, $password, $database, $host);	
	$num_rows=0;
	$dept_table=$keyost_prefix."department";
	$ticket_table=$keyost_prefix."ticket";
	$ticket_cdata=$keyost_prefix."ticket__cdata";
	$ost_ticket_status=$keyost_prefix."ticket_status";
	$current_user = wp_get_current_user();
	$e_address=$current_user->user_email;
	$user_id = $ost_wpdb->get_var("SELECT user_id FROM ".$keyost_prefix."user_email WHERE `address` = '".$e_address."'");
	if($keyost_version>="194")
	{
	$num_rows=$ost_wpdb->get_var("SELECT COUNT(*) FROM $ticket_table
	LEFT JOIN $ticket_cdata ON $ticket_cdata.ticket_id = $ticket_table.ticket_id
	INNER JOIN $dept_table ON $dept_table.dept_id=$ticket_table.dept_id 
	INNER JOIN $ost_ticket_status ON $ost_ticket_status.id=$ticket_table.status_id
	WHERE $ost_ticket_status.state='open' AND ost_ticket.user_id='$user_id'");
	}
	else
	{
	$num_rows=$ost_wpdb->get_var("SELECT COUNT(*) FROM $ticket_table
	LEFT JOIN $ticket_cdata ON $ticket_cdata.ticket_id = $ticket_table.ticket_id
	INNER JOIN $dept_table ON $dept_table.dept_id=$ticket_table.dept_id WHERE $ticket_table.status='open' AND ost_ticket.user_id='$user_id'");
	}	if($num_rows > 0)
		return $num_rows;
	else
		return 0;
}
add_shortcode('addosopenticketcount', 'addopenticketcount');
// Ticket Count Short Code End Here Added By Pratik Maniar
function mb_admin_menu() { 
$config = get_option('os_ticket_config');
extract($config);
if (($database=="") || ($username=="") || ($password=="") || ($keyost_prefix=="")) {
    $page_title = 'Support/Request List';
    $menu_title = 'Tickets';
} else {
$ost_wpdb = new wpdb($username, $password, $database, $host);	
if (isset($ost_wpdb->error) ){
    $page_title = 'Support/Request List';
    $menu_title = 'Tickets';
} else {
$dept_table=$keyost_prefix."department";
$ticket_table=$keyost_prefix."ticket";
$ticket_cdata=$keyost_prefix."ticket__cdata";
$ost_ticket_status=$keyost_prefix."ticket_status";
$num_rows=$ost_wpdb->get_var("SELECT COUNT(*) FROM $ticket_table
LEFT JOIN $ticket_cdata ON $ticket_cdata.ticket_id = $ticket_table.ticket_id
INNER JOIN $dept_table ON $dept_table.dept_id=$ticket_table.dept_id 
INNER JOIN $ost_ticket_status ON $ost_ticket_status.id=$ticket_table.status_id
WHERE $ost_ticket_status.state='open' AND $ticket_table.isanswered='0'");
    $page_title = 'Support/Request List';
	if ($num_rows > 0) {
    $menu_title = __("Tickets", 'key4ce-osticket-bridge').'<span class="awaiting-mod"><span class="pending-count">' . $num_rows . '</span></span>';
	} else {
	$menu_title = __("Tickets", 'key4ce-osticket-bridge'); } } }
	$capability = 'manage_options';
    $menu_slug = 'ost-tickets';
    $function = 'ost_tickets_page';
    $position = '51';
	$icon_url = plugin_dir_url( __FILE__ ) . 'images/status.png';
    add_menu_page(__("Support/Request List", 'key4ce-osticket-bridge'),$menu_title, $capability, $menu_slug, $function, $icon_url, $position);
    $sub_menu_title = 'Email Tickets';
    add_submenu_page($menu_slug,__("Support/Request List", 'key4ce-osticket-bridge'),__("Email Tickets", 'key4ce-osticket-bridge'), $capability, $menu_slug, $function);
    // Added By Pratik Maniar on 21/09/2014 code start here
    $submenu_page_title = 'Create Ticket';
    $submenu_title = 'Create Ticket';
    $submenu_slug = 'ost-create-ticket';
    $submenu_function = 'ost_create_ticket';
    add_submenu_page($menu_slug,__("Create Ticket", 'key4ce-osticket-bridge'),__("Create Ticket", 'key4ce-osticket-bridge'), $capability, $submenu_slug, $submenu_function);
	// Added By Pratik Maniar on 21/09/2014 code end here
    $submenu_page_title = 'Settings';
    $submenu_title = 'Settings';
    $submenu_slug = 'ost-settings';
    $submenu_function = 'ost_settings_page';
    add_submenu_page($menu_slug, __("Settings", 'key4ce-osticket-bridge'),__("Settings", 'key4ce-osticket-bridge'), $capability, $submenu_slug, $submenu_function);
	$submenu_page_title = 'osT-Config';
    $submenu_title = 'osT-Config';
    $submenu_slug = 'ost-config';
    $submenu_function = 'ost_config_page';
    add_submenu_page($menu_slug,__("osT-Config", 'key4ce-osticket-bridge'), __("osT-Config", 'key4ce-osticket-bridge'), $capability, $submenu_slug, $submenu_function); 
	$submenu_page_title = 'Email Templates';
    $submenu_title = 'Email Templates';
    $submenu_slug = 'ost-emailtemp';
    $submenu_function = 'ost_emailtemp_page';
    add_submenu_page($menu_slug,__("Email Templates", 'key4ce-osticket-bridge'), __("Email Templates", 'key4ce-osticket-bridge'), $capability, $submenu_slug, $submenu_function);
	
	// Hook into the 'wp_before_admin_bar_render' action
if (($database=="") || ($username=="") || ($password=="")) {
    add_action( 'wp_before_admin_bar_render', 'custom_toolbar_supportticket', 999 );
    } else {
if(@$num_rows > 0)
add_action( 'wp_before_admin_bar_render', 'custom_toolbar_openticket', 998 );
else
add_action( 'wp_before_admin_bar_render', 'custom_toolbar_supportticket', 999 );
} }
function mb_admin_css() {
wp_enqueue_style('ost-bridge-admin', plugin_dir_url(__FILE__).'css/admin-style.css">');
}
function mb_install()
{
$host='localhost';
$database='';
$username='';
$password='';
$keyost_prefix='ost_';
$supportpage='Support';
$config=array('host'=>$host,'database'=>$database,'username'=>$username,'password'=>$password,'keyost_prefix'=>$keyost_prefix,'supportpage'=>$supportpage);
update_option( 'os_ticket_config', $config);
}
// Looks for a shortcode within the current post's content.
// Optimized for shortcodes that don't have parameters.
function ost_has_shortcode_without_params($shortcode = '') {
  global $post;

  if (!$shortcode || $post == null) {  
    return false;  
  }

  if (stripos($post->post_content, '[' . $shortcode . ']') === false) {
    return false;
  }

  return true;
}
// User must be logged in to view pages that use the shortcode
function ost_enforce_login_action() {
  if(ost_has_shortcode_without_params(OST_SHORTCODE_ADDOSTICKET) && !is_user_logged_in()) {
    auth_redirect();
  }
}
add_action('wp', 'ost_enforce_login_action');
function mb_table_install() {
global $wpdb;
$sql="";
$table_name = $wpdb->prefix . "ost_emailtemp"; 
 if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
    //table is not created. you may create the table here.
    $sql ="DROP TABLE IF EXISTS ".$table_name.";\n";
     $sql .= "CREATE TABLE $table_name (
id mediumint(9) NOT NULL AUTO_INCREMENT,
name varchar(32) NOT NULL,
subject varchar(255) NOT NULL DEFAULT '',
text text NOT NULL,
created datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
updated datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
UNIQUE KEY id (id)
)ENGINE=InnoDB  DEFAULT CHARSET=utf8";
}   
require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
dbDelta($sql);
}

function mb_database_install() {
   global $wpdb;
  
   $table_name = $wpdb->prefix . "ost_emailtemp";
   // if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name)
   // {
        $id = '1';
   $name = "Admin-Response";
   $subject = "Ticket ID [#\$ticketid]";
   $text = "";
   $rows_affected = $wpdb->insert( 
   $table_name, 
   array(
   'id' => $id, 
   'name' => $name,
   'subject' => $subject,
   'text' => $text,
   'created' => current_time('mysql'), 
   'updated' => current_time('mysql') 
   ) );
   $id = '2';
   $name = "New-Ticket";
   $subject = "Ticket ID [#\$ticketid]";
   $text = "";
   $rows_affected = $wpdb->insert( 
   $table_name, 
   array( 
   'id' => $id,
   'name' => $name,
   'subject' => $subject,
   'text' => $text,
   'created' => current_time('mysql'), 
   'updated' => current_time('mysql') 
   ) ); 
   $id = '3';
   $name = "Post-Confirmation";
   $subject = "Ticket ID [#\$ticketid]";
   $text = "";
   $rows_affected = $wpdb->insert( 
   $table_name, 
   array( 
   'id' => $id,
   'name' => $name,
   'subject' => $subject,
   'text' => $text,
   'created' => current_time('mysql'), 
   'updated' => current_time('mysql') 
   ) ); 
   // }  
}
function mb_uninstall() 
{
    delete_option('os_ticket_config');
    global $wpdb;
    $table = $wpdb->prefix."ost_emailtemp";
    $wpdb->query("DROP TABLE IF EXISTS $table");
    $table_config = "ost_config";
    $wpdb->query("DELETE FROM $table_config WHERE `namespace`='core' and `key`='smtp_username'");
    $wpdb->query("DELETE FROM $table_config WHERE `namespace`='core' and `key`='smtp_password'"); 	
    $wpdb->query("DELETE FROM $table_config WHERE `namespace`='core' and `key`='smtp_host'"); 		
    $wpdb->query("DELETE FROM $table_config WHERE `namespace`='core' and `key`='smtp_port'"); 
    $wpdb->query("DELETE FROM $table_config WHERE `namespace`='core' and `key`='smtp_status'"); 	
}
function ost_create_ticket() {
    if (!current_user_can('manage_options'))
    {
      wp_die( __('You do not have sufficient permissions to access this page.') );
    }
    require_once( WP_PLUGIN_DIR . '/key4ce-osticket-bridge/admin/admin_create_ticket.php' );
}
function ost_config_page() {
    if (!current_user_can('manage_options'))
    {
      wp_die( __('You do not have sufficient permissions to access this page.') );
    }
    require_once( WP_PLUGIN_DIR . '/key4ce-osticket-bridge/admin/ost-config.php' );
}

function ost_settings_page() {
$config = get_option('os_ticket_config');
extract($config);
    if (!current_user_can('manage_options'))
    {
      wp_die( __('You do not have sufficient permissions to access this page.') );
    }
    if (($database=="") || ($username=="") || ($password==""))
    {
    echo "<div class='headtitleerror'>".__("osTicket Settings", 'key4ce-osticket-bridge')."</div><div id='message' class='error'>" . __( '<p><b>Error:</b> You must complete "osTicket Data Configure" before this page will display... <a href="admin.php?page=ost-config">click here</a></p>', 'ost-menu' ) . "</div>";
    } else {
    require_once( WP_PLUGIN_DIR . '/key4ce-osticket-bridge/admin/ost-settings.php' );
    }
}
function ost_emailtemp_page() {
$config = get_option('os_ticket_config');
extract($config);
    if (!current_user_can('manage_options'))
    {
      wp_die( __('You do not have sufficient permissions to access this page.') );
    }
    if (($database=="") || ($username=="") || ($password==""))
    {
    echo "<div class='headtitleerror'>".__("osTicket Settings", 'key4ce-osticket-bridge')."</div><div id='message' class='error'>" . __( '<p><b>Error:</b> You must complete "osTicket Data Configure" before this page will display... <a href="admin.php?page=ost-config">click here</a></p>', 'ost-menu' ) . "</div>";
    } else {
    require_once( WP_PLUGIN_DIR . '/key4ce-osticket-bridge/admin/ost-emailtemp.php' );
    }
}
function ost_tickets_page() {
$config = get_option('os_ticket_config');
extract($config);
    if (!current_user_can('manage_options'))
    {
      wp_die( __('You do not have sufficient permissions to access this page.') );
    }
    if (($database=="") || ($username=="") || ($password==""))
    {
    echo "<div class='headtitleerror'>osTicket - Support/Request List</div><div id='message' class='error'>" . __( '<p><b>Error:</b> You must complete "osTicket Data Configure" before this page will display... <a href="admin.php?page=ost-config">click here</a></p>', 'ost-menu' ) . "</div>";
    } else { 
    if(isset($_REQUEST['service']) && $_REQUEST['service']=='view') 
    { 
    require_once( WP_PLUGIN_DIR . '/key4ce-osticket-bridge/admin/ost-ticketview.php' );
    }
else  if(isset($_REQUEST['service']) && $_REQUEST['service']=='admin-create-ticket') { 
    require_once( WP_PLUGIN_DIR . '/key4ce-osticket-bridge/admin/admin_create_ticket.php' );
    }	
	else { 
    require_once( WP_PLUGIN_DIR . '/key4ce-osticket-bridge/admin/ost-tickets.php' );
    }
  }
}
?>
