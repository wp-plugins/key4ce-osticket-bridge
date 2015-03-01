<?php
/*
  Template Name: adminticketemail.php
 */
require_once( WP_PLUGIN_DIR . '/key4ce-osticket-bridge/includes/functions.php'); 
?>
<?php
$user_id=$ost_wpdb->get_var("SELECT user_id FROM " . $keyost_prefix . "user_email WHERE `address` = '" . $_REQUEST['email'] . "'");
$wp_user_email_id = $_REQUEST['email'];
$tic_ID = key4ce_generateID();
$checkUserID = $ost_wpdb->get_results("SELECT number from $ticket_table WHERE number = '$tic_ID'");
if (count($checkUserID) > 0) {
    $tic_ID = key4ce_generateID();
}
$dep_id = $_REQUEST['deptId'];
$sla_id = 1;
$pri_id = $_REQUEST['priorityId'];
@$top_id = $_REQUEST['topicId'];
$staff_id = 0;
$team_id = 0;
$usid = $user_id;
$em = $_REQUEST['email'];
$nam = $_REQUEST['username'];
$nam = preg_replace('/[^\p{L}\p{N}\s]/u', '', $nam);
$adem = $_REQUEST['ademail'];
$title = $_REQUEST['stitle'];
$dirname = $_REQUEST['sdirna'];
@$sub = Format::stripslashes($_REQUEST['subject']);
@$newtickettemp = Format::stripslashes($_REQUEST['newtickettemp']);
$ip_add = $_SERVER['REMOTE_ADDR'];
if($keyost_version==194)
{
$ticketstate = "1";
}
else{
$ticketstate = "open";
}

$sour = "Web";
$isoverdue = 0;
$isans = 0;
$las_msg = date("Y-m-d, g:i:s", strtotime("-5 hour"));
$cre = date("Y-m-d, g:i:s", strtotime("-5 hour"));
@$user_message = Format::stripslashes($_REQUEST['message']);
$prid = $ost_wpdb->get_row("SELECT priority_desc FROM $priority_table WHERE priority_id=$pri_id");
$priordesc = $prid->priority_desc;
// Added by Pratik Maniar on 29-04-2014 Start Here
$dept_details = $ost_wpdb->get_row("SELECT dept_id,dept_name FROM $dept_table WHERE dept_id=$dep_id");
$dept_name = $dept_details->dept_name;
// Added by Pratik Maniar on 29-04-2014 End Here
/////New user info > check if user exists or create a new user...
$result1 = $ost_wpdb->get_results("SELECT address FROM " . $keyost_prefix . "user_email WHERE address = '" . $wp_user_email_id . "'");
if (count($result1) > 0) {
    $row = current($result1);
} else {
    $ost_wpdb->query("INSERT INTO " . $keyost_prefix . "user_email (id, user_id, address) VALUES ('','" . $usid . "','" . $wp_user_email_id . "')");
    @$last_ost_user_email_id = $ost_wpdb->insert_id;
}

$result2 = $ost_wpdb->get_results("SELECT default_email_id,name FROM " . $keyost_prefix . "user WHERE default_email_id = '" . @$last_ost_user_email_id . "'");
if (count($result2) > 0) {
    //$row = current ($result2);
    @$name = $result2->name;
    if (@$name == "") {
        if (@$last_ost_user_email_id != "")
            $wpdb->query("UPDATE " . $keyost_prefix . "user SET name = " . $nam . " WHERE default_email_id = '" . @$last_ost_user_email_id . "'");
    }
} else {
    $ost_wpdb->query("INSERT INTO " . $keyost_prefix . "user (id, default_email_id, name, created, updated) VALUES ('','" . $last_ost_user_email_id . "', '" . $nam . "', '" . $cre . "', '" . $cre . "')
	");
    $last_ost_user_id = $ost_wpdb->insert_id;
    if ($last_ost_user_id != "")
        $ost_wpdb->query("UPDATE " . $keyost_prefix . "user_email SET user_id=$last_ost_user_id where id=$last_ost_user_email_id");
}

////End of new user info user_email_id email_id
if (count($result1) > 0) {
if($keyost_version==194)
{
 $ost_wpdb->insert($ticket_table, array('number' => $tic_ID, 'user_id' => $usid, 'user_email_id' => $usid, 'dept_id' => $dep_id, 'sla_id' => $sla_id, 'topic_id' => $top_id, 'staff_id' => $staff_id, 'team_id' => $team_id, 'email_id' => $usid, 'ip_address' => $ip_add, 'status_id' => $ticketstate, 'source' => $sour, 'isoverdue' => $isoverdue, 'isanswered' => $isans, 'lastmessage' => $las_msg, 'created' => $cre), array('%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%s', '%s', '%s', '%s', '%s', '%s', '%s'));
}
else
{
 $ost_wpdb->insert($ticket_table, array('number' => $tic_ID, 'user_id' => $usid, 'user_email_id' => $usid, 'dept_id' => $dep_id, 'sla_id' => $sla_id, 'topic_id' => $top_id, 'staff_id' => $staff_id, 'team_id' => $team_id, 'email_id' => $usid, 'ip_address' => $ip_add, 'status' => $ticketstate, 'source' => $sour, 'isoverdue' => $isoverdue, 'isanswered' => $isans, 'lastmessage' => $las_msg, 'created' => $cre), array('%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%s', '%s', '%s', '%s', '%s', '%s', '%s'));
}
   
} else {
if($keyost_version==194)
{
 $ost_wpdb->insert($ticket_table, array('number' => $tic_ID, 'user_id' => $last_ost_user_id, 'user_email_id' => $last_ost_user_email_id, 'dept_id' => $dep_id, 'sla_id' => $sla_id, 'topic_id' => $top_id, 'staff_id' => $staff_id, 'team_id' => $team_id, 'email_id' => $last_ost_user_email_id, 'ip_address' => $ip_add, 'status_id' => $ticketstate, 'source' => $sour, 'isoverdue' => $isoverdue, 'isanswered' => $isans, 'lastmessage' => $las_msg, 'created' => $cre), array('%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%s', '%s', '%s', '%s', '%s', '%s', '%s'));
}
else
{
 $ost_wpdb->insert($ticket_table, array('number' => $tic_ID, 'user_id' => $last_ost_user_id, 'user_email_id' => $last_ost_user_email_id, 'dept_id' => $dep_id, 'sla_id' => $sla_id, 'topic_id' => $top_id, 'staff_id' => $staff_id, 'team_id' => $team_id, 'email_id' => $last_ost_user_email_id, 'ip_address' => $ip_add, 'status' => $ticketstate, 'source' => $sour, 'isoverdue' => $isoverdue, 'isanswered' => $isans, 'lastmessage' => $las_msg, 'created' => $cre), array('%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%s', '%s', '%s', '%s', '%s', '%s', '%s'));
}
   
}
$lastid = $ost_wpdb->insert_id;
$stat = "created";
$staf = "SYSTEM";
$annulled = 0;
$ost_wpdb->insert($ticket_event_table, array('ticket_id' => $lastid, 'staff_id' => $staff_id, 'team_id' => $team_id, 'dept_id' => $dep_id, 'topic_id' => $top_id, 'state' => $stat, 'staff' => $staf, 'annulled' => $annulled, 'timestamp' => $cre), array('%d', '%d', '%d', '%d', '%d', '%s', '%s', '%s', '%s'));
// File Table Entry Code Start Here By Pratik Maniar on 29/08/2014
if (!empty($_FILES['file']['name'][0])) 
{   
   $fileids=array();
   for ($i = 0; $i < count($_FILES['file']['name']); $i++) 
    {    
    $allowed_filetypes = key4ce_getKeyValue('allowed_filetypes'); //Return allowed file types from Osticket configuration
    $max_file_size = key4ce_getKeyValue('max_file_size'); //Return max file size from Osticket configuration
    $fullfinalpath= key4ce_getKeyValue('uploadpath');
    $key4ce_generateHashKey = key4ce_generateHashKey(33);
    $key4ce_generateHashSignature = key4ce_generateHashSignature(33);
    $dir_name = substr($key4ce_generateHashKey, 0, 1);
    $structure = $fullfinalpath."/".$dir_name;
    if (!is_dir($structure)) {
        mkdir($structure, 0355);
    }
   $alowaray = explode(".",str_replace(' ', '',key4ce_getKeyValue('allowed_filetypes')));
    $strplc = str_replace(".", "",str_replace(' ', '',key4ce_getKeyValue('allowed_filetypes')));
    $allowedExts = explode(",", $strplc);
    $temp = explode(".", $_FILES['file']['name'][$i]);
    $extension = end($temp); //return uploaded file extension
    $newfilename = $key4ce_generateHashKey;
    $realfilename = $_FILES['file']['name'][$i];
    $filetype = $_FILES["file"]["type"][$i];
    $filesize = $_FILES["file"]["size"][$i];
    if (($_FILES["file"]["size"][$i] < $max_file_size) && in_array($extension, $allowedExts)) {
        if ($_FILES["file"]["error"][$i] > 0) {
            echo "Return Code: " . $_FILES["file"]["error"][$i] . "<br>";
        } else {
            move_uploaded_file($_FILES["file"]["tmp_name"][$i], $structure . "/" . $newfilename);
        }
    }
     $ost_wpdb->insert($keyost_prefix . "file", array('ft' => 'T', 'bk' => 'F', 'type' => $filetype, 
        'size' => $filesize, 'key' => $key4ce_generateHashKey, 'signature' => $key4ce_generateHashSignature,
        'name' => $realfilename, 'attrs' => '', 'created' => $cre), array('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s'));
    $file_id = $ost_wpdb->insert_id;
    array_push($fileids, $file_id);
    }       
}
// File Table Entry Code End Here By Pratik Maniar on 29/08/2014  
$pid = 0;
$thread_type = "M";
$ost_wpdb->insert($thread_table, array('pid' => $pid, 'ticket_id' => $lastid, 'staff_id' => $staff_id, 'thread_type' => $thread_type, 'poster' => $nam, 'source' => $sour, 'title' => "", 'body' => key4ce_wpetss_forum_text($user_message), 'ip_address' => $ip_add, 'created' => $cre), array('%d', '%d', '%d', '%s', '%s', '%s', '%s', '%s', '%s', '%s'));
$thread_id = $ost_wpdb->insert_id;
 if (!empty($_FILES['file']['name'][0]))
{   
    foreach($fileids as $file_id)
    {
// File Attachment Table Entry Code Start Here By Pratik Maniar on 29/08/2014
    $ost_wpdb->insert($keyost_prefix . "ticket_attachment", array('ticket_id' => $lastid, 'file_id' => $file_id, 'ref_id' => $thread_id, 'inline' => '0', 'created' => $cre), array('%d', '%d', '%d', '%d', '%s'));
// File Attachment Table Entry Code End Here By Pratik Maniar on 29/08/2014
    }
}
if($keyost_version==194)
{
$ost_wpdb->insert($ticket_cdata, array('ticket_id' => $lastid, 'subject' => $sub, 'priority' =>$pri_id), array('%d', '%s',	'%d'));
}
else
{
$ost_wpdb->insert($ticket_cdata, array('ticket_id' => $lastid, 'subject' => $sub, 'priority' => $priordesc, 'priority_id' => $pri_id), array('%d', '%s', '%s', '%d'));
}
@$topic_tab = $ost_wpdb->get_results("SELECT topic_id, topic FROM $topic_table WHERE topic_id=@$top_id");
foreach ($topic_tab as $topic_tab1) {
    @$top = $topic_tab1->topic;
}

$config_table = $keyost_prefix . "config";
$staff_table = $keyost_prefix . "staff";


///Variable's for email templates

$username = $nam;
$usermail = $em;
$ticketid = $tic_ID;
$user_message = $user_message; ///from post form - now becomes a variable & message
$ostitle = $title;
@$edate = $date;
$dname = $directory;
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
if (key4ce_getKeyValue('ticket_alert_admin') == 1 && key4ce_getKeyValue('ticket_alert_active') == 1) {
//Added By Pratik Maniar On 14-06-2014 Code Start Here To Avoid Auto generate by Department Emails
    $id_ademail = $ost_wpdb->get_var("SELECT id FROM $config_table WHERE $config_table.key like ('%admin_email%');");
    $os_admin_email = $ost_wpdb->get_row("SELECT id,namespace,$config_table.key,$config_table.value,updated FROM $config_table where id = $id_ademail");
    $os_admin_email_admin = $os_admin_email->value;
//Added By Pratik Maniar On 14-06-2014 Code End Here To Avoid Auto generate by Department Emails
    $subject = "New Support Ticket";
    $adminmessage = "Hello Admin,<br />A new ticket has been created.<br /><br />";
    $adminmessage.="Ticket ID #" . $ticketid . "";
    $adminmessage.="<br />----------------------<br />";
    $adminmessage.="Name: " . $username . "<br />";
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
    $headers = 'From: ' . $title . ' <' . $adem . ">\r\n";
    add_filter('wp_mail_content_type', create_function('', 'return "text/html"; '));
    wp_mail($os_admin_email_admin, $subject, key4ce_wpetss_forum_text('<div style="display: none;">-- do not reply below this line -- <br/><br/></div>' . $adminmessage), $headers);
}
//Email Notification to Department Of Staff Added by Pratik Maniar on 28-04-2014 Start Here
///Email osticket Department - a new ticket has been created
if (key4ce_getKeyValue('ticket_alert_dept_members') == 1 && key4ce_getKeyValue('ticket_alert_active') == 1) {
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
            $deptmessage.="Name: " . $username . "<br />";
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
            wp_mail($staff_email, $subject, key4ce_wpetss_forum_text('<div style="display: none;">-- do not reply below this line -- <br/><br/></div>' . $deptmessage), $headers);
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
                $deptmessage.="Name: " . $username . "<br />";
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
                wp_mail($staff_email, $subject, key4ce_wpetss_forum_text('<div style="display: none;">-- do not reply below this line -- <br/><br/></div>' . $deptmessage), $headers);
            }
        }
        //If Department User Not Found System Will Send Email To Group Members Of Related Department Added By Pratik Maniar on 16-06-2014 Code End Here
    }
}//Email Notification to Department Of Staff Added by Pratik Maniar on 28-04-2014 End Here
//Email Notification to Customer Added by Pratik Maniar on 10-09-2014 start Here

//Added By Pratik Maniar On 14-06-2014 Code End Here To Avoid Auto generate by Department Emails
    $subject = "New Support Ticket";
    $usermessage = "Hello $nam ,<br />Your ticket has been created.<br /><br />";
    $usermessage.="Ticket ID #" . $ticketid . "";
    $usermessage.="<br />----------------------<br />";
    $usermessage.="Email: " . $usermail . "<br />";
    $usermessage.="Priority: " . $priordesc . "<br />";
    $usermessage.="Department: " . $dept_name . "<br />";
    $usermessage.="Subject: " . $sub . "<br />";
    $usermessage.="<br />----------------------<br />";
    $usermessage.="Message: " . $user_message . "";
    $usermessage.="<br />----------------------<br /><br />";
    $usermessage.="To respond to the ticket, please login to the support ticket system.";
    $usermessage.="<br /><br />";
    $usermessage.="" . site_url() . "";
    $usermessage.="<br />";
    $usermessage.="Your friendly Customer Support System ";
//Email Notification to Customer Added by Pratik Maniar on 10-09-2014 end Here
$dept_user_details = $ost_wpdb->get_row("SELECT $ost_email.name,$ost_email.email FROM $dept_table INNER JOIN $ost_email ON $dept_table.email_id=$ost_email.email_id WHERE $dept_table.dept_id=$dep_id");
$dept_user_name = $dept_user_details->name;
$dept_user_email = $dept_user_details->email;
if($smtp_status=="enable")
	$SMTPAuth="true";
else
	$SMTPAuth="false";	
require_once ABSPATH . WPINC . '/class-phpmailer.php';
require_once ABSPATH . WPINC . '/class-smtp.php';
$phpmailer = new PHPMailer();
if($smtp_status=="enable")
{
$phpmailer = new PHPMailer();
$phpmailer->SMTPAuth =true;
$phpmailer->Username = $smtp_username;
$phpmailer->Password = $smtp_password;
$phpmailer->isHTML(true); 
$phpmailer->CharSet = 'UTF-8';
$phpmailer->IsSMTP(true); // telling the class to use SMTP
$phpmailer->Host  =$smtp_host; // SMTP server
$phpmailer->Port=$smtp_port;
$phpmailer->From =  "$dept_user_name";
$phpmailer->FromName = "$dept_user_email";
add_filter('wp_mail_content_type',create_function('', 'return "text/html"; '));
$phpmailer->Subject    =$subject;
$phpmailer->Body       = key4ce_wpetss_forum_text($usermessage);                      //HTML Body
$phpmailer->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
$phpmailer->MsgHTML('<div style="display: none;">-- do not reply below this line -- <br/><br/></div>' . $usermessage);
$phpmailer->AddAddress($to);
$phpmailer->Send();
}
else
{
$phpmailer->CharSet = 'UTF-8';
$phpmailer->setFrom($dept_user_email, $dept_user_name);
$phpmailer->addReplyTo($dept_user_email, $dept_user_name);
add_filter('wp_mail_content_type',create_function('', 'return "text/html"; '));
$phpmailer->Subject = $subject;
$phpmailer->Body       = key4ce_wpetss_forum_text($usermessage);   
$phpmailer->MsgHTML('<div style="display: none;">-- do not reply below this line -- <br/><br/></div>' . $usermessage);
$phpmailer->AltBody = 'This is a plain-text message body';
$phpmailer->AddAddress($wp_user_email_id);
$phpmailer->send();
}

?>
