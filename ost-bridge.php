<?php
/*
Plugin Name: Key4ce osTicket Bridge
Plugin URI: http://key4ce.com/osticket-bridge
Description: Integrate osTicket (v1.8) or (v1.9) into wordpress. including user integration and scp
Version: 1.1.2
Author: Key4ce
Author URI: http://key4ce.eu
License: GPLv3
*/
?>
<?php
/*
Copyright (C) 2014  Key4ce

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

function mb_settings_link($actions, $file) {
if(false !== strpos($file, 'ost-bridge'))
    $actions['settings'] = '<a href="admin.php?page=ost-config">Config</a>';
return $actions; 
}
add_filter('plugin_action_links', 'mb_settings_link', 2, 2);

function addtemplate()
{

	require_once( WP_PLUGIN_DIR . '/key4ce-osticket-bridge/osticket-wp.php');
}
add_shortcode('addosticket', 'addtemplate');	
function custom_toolbar_openticket() {
	global $wp_admin_bar;	
	$wp_admin_bar->add_menu(array(
		'id'     => 'opensupport',
	        'title' => sprintf(__('Open Tickets')),			
		'href' => get_admin_url(null,'admin.php?page=ost-tickets&service=list&status=open'),
	));
   
}
// Hook into the 'wp_before_admin_bar_render' action
function custom_toolbar_supportticket() {
	global $wp_admin_bar;	
	$wp_admin_bar->add_menu(array(
		'id'     => 'supportsupport',
	        'title' => sprintf(__('Support Tickets')),			
		'href' => get_admin_url(null,'admin.php?page=ost-tickets&service=list&status=all'),
	));
   
}

function mb_admin_menu() { 

$config = get_option('os_ticket_config');
extract($config);
if (($database=="") || ($username=="") || ($password=="")) {
    $page_title = 'Support/Request List';
    $menu_title = 'Tickets';
} else {
$con = mysql_connect($host, $username, $password, true, 65536);
mysql_select_db($database, $con);
$result = mysql_query("SELECT number FROM ost_ticket WHERE status='open' AND isanswered='0'");
$num_rows = mysql_num_rows($result);
    $page_title = 'Support/Request List';
	if ($num_rows > 0) {
    $menu_title = 'Tickets <span class="awaiting-mod"><span class="pending-count">' . $num_rows . '</span></span>';
	} else {
	$menu_title = 'Tickets'; } }
	$capability = 'manage_options';
    $menu_slug = 'ost-tickets';
    $function = 'ost_tickets_page';
    $position = '51';
	$icon_url = plugin_dir_url( __FILE__ ) . 'images/status.png';

    add_menu_page($page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position);

    $sub_menu_title = 'Email Tickets';
    add_submenu_page($menu_slug, $page_title, $sub_menu_title, $capability, $menu_slug, $function);

    $submenu_page_title = 'Settings';
    $submenu_title = 'Settings';
    $submenu_slug = 'ost-settings';
    $submenu_function = 'ost_settings_page';
    add_submenu_page($menu_slug, $submenu_page_title, $submenu_title, $capability, $submenu_slug, $submenu_function);
	
	$submenu_page_title = 'osT-Config';
    $submenu_title = 'osT-Config';
    $submenu_slug = 'ost-config';
    $submenu_function = 'ost_config_page';
    add_submenu_page($menu_slug, $submenu_page_title, $submenu_title, $capability, $submenu_slug, $submenu_function); 
	
	$submenu_page_title = 'Email Templates';
    $submenu_title = 'Email Templates';
    $submenu_slug = 'ost-emailtemp';
    $submenu_function = 'ost_emailtemp_page';
    add_submenu_page($menu_slug, $submenu_page_title, $submenu_title, $capability, $submenu_slug, $submenu_function);
	
	// Hook into the 'wp_before_admin_bar_render' action
if (($database=="") || ($username=="") || ($password=="")) {
    add_action( 'wp_before_admin_bar_render', 'custom_toolbar_supportticket', 999 );
    } else {
if($num_rows > 0)
add_action( 'wp_before_admin_bar_render', 'custom_toolbar_openticket', 998 );
else
add_action( 'wp_before_admin_bar_render', 'custom_toolbar_supportticket', 999 );
} }

function mb_admin_css() {
echo '<link rel="stylesheet" type="text/css" media="all" href="'.plugin_dir_url(__FILE__).'css/admin-style.css">';
}

function mb_install()
{
$host='localhost';
$database='';
$username='';
$password='';
$supportpage='Support';
$version='18';

$config=array('host'=>$host,'database'=>$database,'username'=>$username,'password'=>$password,'supportpage'=>$supportpage,'version'=>$version);
update_option( 'os_ticket_config', $config);
}

function mb_table_install() {
global $wpdb;
$table_name = $wpdb->prefix . "ost_emailtemp"; 
   
$sql = "CREATE TABLE $table_name (
id mediumint(9) NOT NULL AUTO_INCREMENT,
name varchar(32) NOT NULL,
subject varchar(255) NOT NULL DEFAULT '',
text text NOT NULL,
created datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
updated datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
UNIQUE KEY id (id)
)ENGINE=InnoDB  DEFAULT CHARSET=utf8";

require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
dbDelta( $sql );
}

function mb_database_install() {
   global $wpdb;
   $table_name = $wpdb->prefix . "ost_emailtemp";
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

 $table_name_config = "ost_config";
//SMTP Username record insert Start Here Added By Pratik Maniar
   $id = '';
   $namespace = "core";
   $key = "smtp_username";  
   $rows_affected = $wpdb->insert( 
   $table_name_config, 
   array( 
   'id' => $id,
   'namespace' => $namespace,
   'key' => $key,
   'value' => '', 
   'updated' => current_time('mysql') 
   ) );
//SMTP Username record insert End Here Added By Pratik Maniar
//SMTP Username record insert Start Here Added By Pratik Maniar
   $id = '';
   $namespace = "core";
   $key = "smtp_password";  
   $rows_affected = $wpdb->insert( 
   $table_name_config, 
   array( 
   'id' => $id,
   'namespace' => $namespace,
   'key' => $key,
   'value' => '', 
   'updated' => current_time('mysql') 
   ) );
//SMTP Username record insert End Here Added By Pratik Maniar
//SMTP Username record insert Start Here Added By Pratik Maniar
   $id = '';
   $namespace = "core";
   $key = "smtp_host";  
   $rows_affected = $wpdb->insert( 
   $table_name_config, 
   array( 
   'id' => $id,
   'namespace' => $namespace,
   'key' => $key,
   'value' => '', 
   'updated' => current_time('mysql') 
   ) );
//SMTP Username record insert End Here Added By Pratik Maniar
//SMTP Username record insert Start Here Added By Pratik Maniar
   $id = '';
   $namespace = "core";
   $key = "smtp_port";  
   $rows_affected = $wpdb->insert( 
   $table_name_config, 
   array( 
   'id' => $id,
   'namespace' => $namespace,
   'key' => $key,
   'value' => '', 
   'updated' => current_time('mysql') 
   ) );
//SMTP Username record insert End Here Added By Pratik Maniar
//SMTP Username record insert Start Here Added By Pratik Maniar
   $id = '';
   $namespace = "core";
   $key = "smtp_status";  
   $rows_affected = $wpdb->insert( 
   $table_name_config, 
   array( 
   'id' => $id,
   'namespace' => $namespace,
   'key' => $key,
   'value' => '', 
   'updated' => current_time('mysql') 
   ) );
//SMTP Username record insert End Here Added By Pratik Maniar
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
    echo "<div class='headtitleerror'>osTicket Settings</div><div id='message' class='error'>" . __( '<p><b>Error:</b> You must complete "osTicket Data Configure" before this page will display... <a href="admin.php?page=ost-config">click here</a></p>', 'ost-menu' ) . "</div>";
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
    echo "<div class='headtitleerror'>osTicket Email Templates</div><div id='message' class='error'>" . __( '<p><b>Error:</b> You must complete "osTicket Data Configure" before this page will display... <a href="admin.php?page=ost-config">click here</a></p>', 'ost-menu' ) . "</div>";
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
    } else { 
    require_once( WP_PLUGIN_DIR . '/key4ce-osticket-bridge/admin/ost-tickets.php' );
    }
  }
}

?>