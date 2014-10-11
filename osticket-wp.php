<?php
/*
  Template Name: osticket-wp.php
 */
if (is_user_logged_in()) {
    $config = get_option('os_ticket_config');
    extract($config);
    wp_enqueue_style('ost-bridge', plugins_url('css/style.css', __FILE__));
    ?>
    <div id="ost_container"><!--ost_container Start-->
        <?php require_once( WP_PLUGIN_DIR . '/key4ce-osticket-bridge/includes/functions.php' ); ?>
        <?php
        global $wpdb;
        $ostemail = $wpdb->prefix . "ost_emailtemp";
        $newticket = $wpdb->get_row("SELECT id,name,$ostemail.subject,$ostemail.text,created,updated FROM $ostemail where name = 'New-Ticket'");
        $newticket = $newticket->text;

        $postsubmail = $wpdb->get_row("SELECT id,name,$ostemail.subject,text,created,updated FROM $ostemail where name = 'New-Ticket'");
        $postsubmail = $postsubmail->subject;

        $postconfirm = $wpdb->get_row("SELECT id,name,$ostemail.subject,$ostemail.text,created,updated FROM $ostemail where name = 'Post-Confirmation'");
        $postconfirm = $postconfirm->text;
        $pcname = 'Post-Confirmation';

        $poconsubmail = $wpdb->get_row("SELECT id,name,$ostemail.subject,text,created,updated FROM $ostemail where name = 'Post-Confirmation'");
        $poconsubmail = $poconsubmail->subject;

        $ost_wpdb = new wpdb($username, $password, $database, $host);
        global $current_user;
        $config_table = $keyost_prefix . "config";
        $dept_table = $keyost_prefix . "department";
        $topic_table = $keyost_prefix . "help_topic";
        $ticket_table = $keyost_prefix . "ticket";
        $ticket_event_table = $keyost_prefix . "ticket_event";
        $priority_table = $keyost_prefix . "ticket_priority";
        $thread_table = $keyost_prefix . "ticket_thread";
        $ticket_cdata = $keyost_prefix . "ticket__cdata";
        $ost_user = $keyost_prefix . "user";
	$ost_email = $keyost_prefix . "email";
        $ost_staff = $keyost_prefix . "staff";
        $ost_useremail = $keyost_prefix . "user_email";
        $ost_ticket_attachment = $keyost_prefix . "ticket_attachment";
        $ost_file = $keyost_prefix . "file";
        $directory = $config['supportpage'];
        $dirname = strtolower($directory);
        $category = @$_GET['cat'];
        $status_opt = @$_GET['status'];
        $ticket = @$_GET['ticket'];
        $parurl = $_SERVER['QUERY_STRING'];
        $page_id_chk = @$_REQUEST['page_id'];
        get_currentuserinfo();
        $user_email = $current_user->user_email;

        $id_isonline = $ost_wpdb->get_var("SELECT id FROM $config_table WHERE $config_table.key like ('%isonline%');");
        $isactive = $ost_wpdb->get_row("SELECT id,namespace,$config_table.key,$config_table.value,updated FROM $config_table where id = $id_isonline");
        $isactive = $isactive->value;
//Added By Pratik Maniar on 01-05-2014 Start Here
        $default_email_id = $ost_wpdb->get_var("SELECT value FROM " . $keyost_prefix . "config WHERE `key` LIKE 'default_email_id'");
        $default_email_id_data = $ost_wpdb->get_row("SELECT * FROM " . $keyost_prefix . "email WHERE `email_id` =$default_email_id");
//Added By Pratik Maniar on 01-05-2014 End Here
        $title_name = $default_email_id_data->name;
        $id_maxopen = $ost_wpdb->get_var("SELECT id FROM $config_table WHERE $config_table.key like ('%max_open_tickets%');");
        $max_open_tickets = $ost_wpdb->get_row("SELECT id,namespace,$config_table.key,$config_table.value,updated FROM $config_table where id = $id_maxopen");
        $max_open_tickets = $max_open_tickets->value;

        $os_admin_email = $default_email_id_data->email;

        $id_hidename = $ost_wpdb->get_var("SELECT id FROM $config_table WHERE $config_table.key like ('%hide_staff_name%');");
        $hidename = $ost_wpdb->get_row("SELECT id,namespace,$config_table.key,$config_table.value,updated FROM $config_table where id = $id_hidename");
        $hidename = $hidename->value;

        if ($isactive != 1) {
            include WP_PLUGIN_DIR . '/key4ce-osticket-bridge/templates/message.php';
            echo $offline;
        } else {
            if (isset($_REQUEST['post-reply'])) {
                require_once( WP_PLUGIN_DIR . '/key4ce-osticket-bridge/includes/postreplymail.php');
            }
            if (isset($_REQUEST['create-ticket'])) {
                require_once( WP_PLUGIN_DIR . '/key4ce-osticket-bridge/includes/newticketmail.php');
            }
            if (isset($_REQUEST['create-contact-ticket'])) {
                require_once( WP_PLUGIN_DIR . '/key4ce-osticket-bridge/includes/contactticketmail.php');
            }
            require_once( WP_PLUGIN_DIR . '/key4ce-osticket-bridge/includes/versionData.php');
            if (get_the_ID() != $contactticketpage) {
                require_once( WP_PLUGIN_DIR . '/key4ce-osticket-bridge/templates/nav_bar.php');
            }
        }
        if (isset($_GET['service']) && $_GET['service'] == 'new') 
		{
            if ($max_open_tickets == 0 or $getNumOpenTickets < $max_open_tickets) {
                require_once( WP_PLUGIN_DIR . '/key4ce-osticket-bridge/templates/new_ticket.php');
            } elseif ($getNumOpenTickets == $max_open_tickets) {
                include WP_PLUGIN_DIR . '/key4ce-osticket-bridge/templates/message.php';
                echo $warning1;
            } elseif ($getNumOpenTickets > $max_open_tickets) {
                include WP_PLUGIN_DIR . '/key4ce-osticket-bridge/templates/message.php';
                echo $warning2;
            }
        }
        if (isset($_GET['service']) && $_GET['service'] == 'download') {
            require_once( WP_PLUGIN_DIR . '/key4ce-osticket-bridge/includes/download.php');
        }
		 
        if (isset($_GET['service']) && $_GET['service'] == 'view') {
            require_once( WP_PLUGIN_DIR . '/key4ce-osticket-bridge/templates/view_ticket.php');
        } elseif (isset($_REQUEST['service']) && $_REQUEST['service'] == 'list') {
            require_once( WP_PLUGIN_DIR . '/key4ce-osticket-bridge/templates/list_tickets.php');
            require_once( WP_PLUGIN_DIR . '/key4ce-osticket-bridge/templates/pagination.php');
        } elseif ($parurl == "" || $page_id_chk) {
            if (@$_REQUEST['service'] != 'new' && $isactive == 1) {
                if (get_the_ID() != $contactticketpage) {
                    require_once( WP_PLUGIN_DIR . '/key4ce-osticket-bridge/templates/list_tickets.php');
                    require_once( WP_PLUGIN_DIR . '/key4ce-osticket-bridge/templates/pagination.php');
                }
            }
        }
		 else if(@$_REQUEST['currentpage']){
                require_once( WP_PLUGIN_DIR . '/key4ce-osticket-bridge/templates/list_tickets.php');
                require_once( WP_PLUGIN_DIR . '/key4ce-osticket-bridge/templates/pagination.php');
            }
        ?>
    </div><!--ost_container End-->
        <?php
    } else {
        if (get_the_ID() == $contactticketpage) {
            wp_enqueue_style('ost-bridge', plugins_url('css/style.css', __FILE__));
            require_once( WP_PLUGIN_DIR . '/key4ce-osticket-bridge/includes/contactticketmail.php');
        } else {
            throw new Exception('Should not happen: User is not logged in');
        }
    }

