<?php
/*
  Template Name: contactticketemail.php
 */
$config = get_option('os_ticket_config');
extract($config);
$ost_wpdb = new wpdb($username, $password, $database, $host);
require_once('functions.php');
require_once( WP_PLUGIN_DIR . '/key4ce-osticket-bridge/includes/versionData.php');
?>
<?php
global $current_user;
get_currentuserinfo();
$wp_user_email_id = @$_REQUEST['email'];
//$wp_user_email_id="pratik.emiprotech@gmail.com";
$tic_ID = generateID();
$checkUserID = $ost_wpdb->get_results("SELECT number from $ticket_table WHERE number = '$tic_ID'");
if (count($checkUserID) > 0) {
    $tic_ID = generateID();
}
$id_ademail = $ost_wpdb->get_var("SELECT id FROM $config_table WHERE $config_table.key like ('%default_email_id%');");
$os_admin_email = $ost_wpdb->get_row("SELECT id,namespace,$config_table.key,$config_table.value,updated FROM $config_table where id =$id_ademail");
$os_admin_email_id = $os_admin_email->value;
$os_admin_email_address = $ost_wpdb->get_row("SELECT email,name FROM " . $keyost_prefix . "email where email_id=" . $os_admin_email_id . "");
$dep_id = @$_REQUEST['deptId'];
$sla_id = 1;
$pri_id = 2;
@$top_id = $_REQUEST['topicId'];
$staff_id = 0;
$team_id = 0;
$usid = @$_REQUEST['usid'];
$em = @$_REQUEST['email'];
$fullname = @$_REQUEST['cur-name'];
$username_arr = explode('@', $em);
$nam = preg_replace('/[^\p{L}\p{N}\s]/u', '', $username_arr[0]);
$adem = $os_admin_email_address->email;
$title = $os_admin_email_address->name;
$dirname = @$_REQUEST['sdirna'];
@$sub = Format::stripslashes($_REQUEST['subject']);
@$newtickettemp = Format::stripslashes($_REQUEST['newtickettemp']);
$ip_add = $_SERVER['REMOTE_ADDR'];
$stat = "open";
$sour = "Web";
$isoverdue = 0;
$isans = 0;
$las_msg = date("Y-m-d, g:i:s", strtotime("-5 hour"));
$cre = date("Y-m-d, g:i:s", strtotime("-5 hour"));
@$user_message = Format::stripslashes($_REQUEST['message']);
$prid = $ost_wpdb->get_row("SELECT priority_desc FROM $priority_table WHERE priority_id=$pri_id");
$priordesc = "Normal";
if (isset($_REQUEST['create-contact-ticket']) && isset($_REQUEST["magicword"]) && $_REQUEST["magicword"] != "" && strtolower($_SESSION ["captcha"]["code"])==strtolower($_REQUEST["magicword"])) {
// Added by Pratik Maniar on 29-04-2014 Start Here
    $dept_details = $ost_wpdb->get_row("SELECT dept_id,dept_name FROM $dept_table WHERE dept_id=$dep_id");
    $dept_name = $dept_details->dept_name;
// Added by Pratik Maniar on 29-04-2014 End Here
/////New user info > check if user exists or create a new user...
    $result1 = $ost_wpdb->get_results("SELECT address FROM " . $keyost_prefix . "user_email WHERE address = '" . $wp_user_email_id . "'");
    if (count($result1) > 0) {
        $last_ost_user_email_id = $ost_wpdb->get_var("SELECT id, user_id, address FROM " . $keyost_prefix . "user_email WHERE address = '" . $wp_user_email_id . "'");
    } else {
        $ost_wpdb->query("INSERT INTO " . $keyost_prefix . "user_email (id, user_id, address) VALUES ('','" . $usid . "','" . $wp_user_email_id . "')");
        @$last_ost_user_email_id = $ost_wpdb->insert_id;
    }

    $result2 = $ost_wpdb->get_results("SELECT default_email_id,name FROM " . $keyost_prefix . "user WHERE default_email_id = '" . @$last_ost_user_email_id . "'");
    if (count($result2) > 0) {
        $last_ost_user_id = $ost_wpdb->get_var("SELECT id FROM " . $keyost_prefix . "user WHERE default_email_id = '" . @$last_ost_user_email_id . "'");
    } else {
        $ost_wpdb->query("INSERT INTO " . $keyost_prefix . "user (id, default_email_id, name, created, updated) VALUES ('','" . $last_ost_user_email_id . "', '" . $nam . "', '" . $cre . "', '" . $cre . "')
	");
        $last_ost_user_id = $ost_wpdb->insert_id;
    if ($usid == "")
        $ost_wpdb->query("UPDATE " . $keyost_prefix . "user_email SET user_id=$last_ost_user_id where id=$last_ost_user_email_id");
		
		
		
    }
////End of new user info user_email_id email_id
    $ost_wpdb->insert($ticket_table, array('number' => $tic_ID, 'user_id' => $last_ost_user_id, 'user_email_id' => $last_ost_user_email_id, 'dept_id' => $dep_id, 'sla_id' => $sla_id, 'topic_id' => $top_id, 'staff_id' => $staff_id, 'team_id' => $team_id, 'email_id' => $last_ost_user_email_id, 'ip_address' => $ip_add, 'status' => $stat, 'source' => $sour, 'isoverdue' => $isoverdue, 'isanswered' => $isans, 'lastmessage' => $las_msg, 'created' => $cre), array('%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%s', '%s', '%s', '%s', '%s', '%s', '%s'));

    $lastid = $ost_wpdb->insert_id;
    $stat = "created";
    $staf = "SYSTEM";
    $annulled = 0;
    $ost_wpdb->insert($ticket_event_table, array('ticket_id' => $lastid, 'staff_id' => $staff_id, 'team_id' => $team_id, 'dept_id' => $dep_id, 'topic_id' => $top_id, 'state' => $stat, 'staff' => $staf, 'annulled' => $annulled, 'timestamp' => $cre), array('%d', '%d', '%d', '%d', '%d', '%s', '%s', '%s', '%s'));

    $pid = 0;
    $thread_type = "M";

    $ost_wpdb->insert($thread_table, array('pid' => $pid, 'ticket_id' => $lastid, 'staff_id' => $staff_id, 'thread_type' => $thread_type, 'poster' => $nam, 'source' => $sour, 'title' => "", 'body' => wpetss_forum_text($user_message), 'ip_address' => $ip_add, 'created' => $cre), array('%d', '%d', '%d', '%s', '%s', '%s', '%s', '%s', '%s', '%s'));

    $ost_wpdb->insert($ticket_cdata, array('ticket_id' => $lastid, 'subject' => $sub, 'priority' => $priordesc, 'priority_id' => $pri_id), array('%d', '%s', '%s', '%d'));
    @$topic_tab = $ost_wpdb->get_results("SELECT topic_id, topic FROM $topic_table WHERE topic_id=@$top_id");
    foreach ($topic_tab as $topic_tab1) {
        @$top = $topic_tab1->topic;
    }
    $config_table = $keyost_prefix . "config";
    $staff_table = $keyost_prefix . "staff";
///Variable's for email templates
    $username_arr = explode('@', $em);
    $username = $username_arr[0];
    $usermail = $em;
    $ticketid = $tic_ID;
    $user_message = $user_message; ///from post form - now becomes a variable & message
    $ostitle = $title;
    @$edate = $date;
    $dname = @$directory;
    $siteurl = get_permalink();
    if (isset($_REQUEST['page_id']))
        $ticketurl = get_permalink() . "?service=view&ticket=$ticketid";
    else
        $ticketurl = get_permalink() . "&service=view&ticket=$ticketid";

//echo the_permalink();
    $postsubmail = $postsubmail; /// subject in user email (todo's - add field input to WP Email Templates)
///Email the user with template
    $to = $usermail;
    eval("\$subject=\"$postsubmail\";");
    eval("\$message=\"$newtickettemp\";");

///Email osticket admin - a new ticket has been created
    if (getKeyValue('ticket_alert_admin') == 1 && getKeyValue('ticket_alert_active') == 1) {
//Added By Pratik Maniar On 14-06-2014 Code Start Here To Avoid Auto generate by Department Emails
        $id_ademail = $ost_wpdb->get_var("SELECT id FROM $config_table WHERE $config_table.key like ('%admin_email%');");
        $os_admin_email = $ost_wpdb->get_row("SELECT id,namespace,$config_table.key,$config_table.value,updated FROM $config_table where id = $id_ademail");
        $os_admin_email_admin = $os_admin_email->value;
		//$os_admin_email_admin = "maniarpratik@gmail.com";
//Added By Pratik Maniar On 14-06-2014 Code End Here To Avoid Auto generate by Department Emails
        $subject = "New Support Ticket";
        $adminmessage = "Hello Admin,<br />A new ticket has been created.<br /><br />";
        $adminmessage.="Ticket ID #" . $ticketid . "";
        $adminmessage.="<br />----------------------<br />";
        $adminmessage.="Full Name: " . $fullname . "<br />";
        $adminmessage.="Email: " . $usermail . "<br />";
        $adminmessage.="Priority: " . $priordesc . "<br />";
        $adminmessage.="Department: " . $dept_name . "<br />";
        $adminmessage.="Subject: " . $sub . "<br />";
        $adminmessage.="<br />----------------------<br />";
        $adminmessage.="Message: " . $user_message . "";
        $adminmessage.="<br />----------------------<br /><br />";
        $adminmessage.="To respond to the ticket, please login to the support ticket system.";
        $adminmessage.="<br /><br />";
        $adminmessage.="" . site_url() . "";
        $adminmessage.="<br />";
        $adminmessage.="Your friendly Customer Support System ";
        $headers = "From: " . $title . "<" . $adem . ">\r\n";
        add_filter('wp_mail_content_type', create_function('', 'return "text/html"; '));
        wp_mail($os_admin_email_admin, $subject, wpetss_forum_text('<div style="display: none;">-- do not reply below this line -- <br/><br/></div>' . $adminmessage), $headers);
    }
//Email Notification to Department Of Staff Added by Pratik Maniar on 28-04-2014 Start Here
///Email osticket Department - a new ticket has been created
    if (getKeyValue('ticket_alert_dept_members') == 1 && getKeyValue('ticket_alert_active') == 1) {
        $staff_details = $ost_wpdb->get_results("SELECT email,firstname,lastname FROM $ost_staff WHERE `dept_id` =$dep_id");
        $department_staff = count($staff_details);
        if ($department_staff > 0) {
            foreach ($staff_details as $staff) {
                $staff_firstname = $staff->firstname;
                $staff_lastname = $staff->lastname;
                $staff_email = $staff->email;
                $subject = $sub;
                $deptmessage = "Hello $staff_firstname $staff_lastname,<br />A new ticket has been created.<br /><br />";
                $deptmessage.="Ticket ID #" . $ticketid . "";
                $deptmessage.="<br />----------------------<br />";
                $deptmessage.="Full Name: " . $fullname . "<br />";
                $deptmessage.="Email: " . $usermail . "<br />";
                $deptmessage.="Priority: " . $priordesc . "<br />";
                $deptmessage.="Department: " . $dept_name . "<br />";
                $deptmessage.="Subject: " . $subject . "<br />";
                $deptmessage.="<br />----------------------<br />";
                $deptmessage.="Message: " . $user_message . "";
                $deptmessage.="<br />----------------------<br /><br />";
                $deptmessage.="To respond to the ticket, please login to the support ticket system.";
                $deptmessage.="<br /><br />";
                $deptmessage.="" . site_url() . "";
                $deptmessage.="<br />";
                $deptmessage.="Your friendly Customer Support System ";
                $headers = 'From: ' . $ostitle . ' <' . $adem . ">\r\n";
                add_filter('wp_mail_content_type', create_function('', 'return "text/html"; '));
                wp_mail($staff_email, $subject, wpetss_forum_text('<div style="display: none;">-- do not reply below this line -- <br/><br/></div>' . $deptmessage), $headers);
            }
        } else {
            //If Department User Not Found System Will Send Email To Group Members Of Related Department Added By Pratik Maniar on 16-06-2014 Code Start Here
            $getGroups = $ost_wpdb->get_results("SELECT * FROM " . $keyost_prefix . "group_dept_access WHERE `dept_id` =$dep_id");
            foreach ($getGroups as $group) {
                $group_id = $group->group_id;
                $staff_details = $ost_wpdb->get_results("SELECT email,firstname,lastname FROM $ost_staff WHERE `group_id` =$group_id");
                foreach ($staff_details as $staff) {
                    $staff_firstname = $staff->firstname;
                    $staff_lastname = $staff->lastname;
                    $staff_email = $staff->email;
                    $subject = $sub;
                    $deptmessage = "Hello $staff_firstname $staff_lastname,<br />A new ticket has been created.<br /><br />";
                    $deptmessage.="Ticket ID #" . $ticketid . "";
                    $deptmessage.="<br />----------------------<br />";
                    $deptmessage.="Full Name: " . $fullname . "<br />";
                    $deptmessage.="Email: " . $usermail . "<br />";
                    $deptmessage.="Priority: " . $priordesc . "<br />";
                    $deptmessage.="Department: " . $dept_name . "<br />";
                    $deptmessage.="Subject: " . $subject . "<br />";
                    $deptmessage.="<br />----------------------<br />";
                    $deptmessage.="Message: " . $user_message . "";
                    $deptmessage.="<br />----------------------<br /><br />";
                    $deptmessage.="To respond to the ticket, please login to the support ticket system.";
                    $deptmessage.="<br /><br />";
                    $deptmessage.="" . site_url() . "";
                    $deptmessage.="<br />";
                    $deptmessage.="Your friendly Customer Support System ";
                    $headers = 'From: ' . $ostitle . ' <' . $adem . ">\r\n";
                    add_filter('wp_mail_content_type', create_function('', 'return "text/html"; '));
                    wp_mail($staff_email, $subject, wpetss_forum_text('<div style="display: none;">-- do not reply below this line -- <br/><br/></div>' . $deptmessage), $headers);
                }
            }
            //If Department User Not Found System Will Send Email To Group Members Of Related Department Added By Pratik Maniar on 16-06-2014 Code End Here
        }
    }//Email Notification to Department Of Staff Added by Pratik Maniar on 28-04-2014 End Here
}
?>

