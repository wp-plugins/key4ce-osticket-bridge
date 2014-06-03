<?php 
/*
Template Name: postreplymail.php
*/
?>
<?php 
$config_table="ost_config";
$staff_table="ost_staff";
$pid=0;
$staffid=0;
$source="Web";
$thread_type="M";
$poster=$_REQUEST['usname'];
$usid=$_REQUEST['usid'];
$ticid=$_REQUEST['tic_id'];
$usticketid=$_REQUEST['usticketid'];
$usname=$_REQUEST['usname'];
$usemail=$_REQUEST['usemail'];
$adem=$_REQUEST['ademail'];
$title=$_REQUEST['stitle'];
$dirname=$_REQUEST['sdirna'];
$postconfirm=($_REQUEST['postconfirmtemp']);
$usdepartment=$_REQUEST['usdepartment'];
$ussubject=$_REQUEST['ussubject'];
$uscategories=$_REQUEST['uscategories'];
$top_id=$_REQUEST['ustopicid'];
$user_message=($_REQUEST['message']);
$ipaddress=$_SERVER['REMOTE_ADDR'];
$date=date("Y-m-d, g:i:s", strtotime("-5 hour"));


$ost_wpdb->insert($thread_table, array('pid' => $pid,'ticket_id' => $ticid,'staff_id' => $staffid,'user_id' => $usid,'thread_type' => $thread_type,'poster' => $poster,'source' => $source,'title' => "",'body' => wpetss_forum_text($user_message),'ip_address' => $ipaddress,'created' => $date),	array('%d','%d','%d','%d','%s','%s','%s','%s','%s','%s','%s')); 
/* Added by Pratik Maniar Start Here On 28-04-2014*/
$ost_wpdb->query($ost_wpdb->prepare("UPDATE $ticket_table SET isanswered = 0 WHERE number = $usticketid" ));
/* Added by Pratik Maniar End Here On 28-04-2014*/

if(isset($_REQUEST['reply_ticket_status'])) { 
$ost_wpdb->update($ticket_table, array('status' => 'open'), array('ticket_id' => $ticid), array('%s')); } 

if(isset($_REQUEST['close_ticket_status'])) { 
$ost_wpdb->update($ticket_table, array('status' => 'closed'), array('ticket_id' => $ticid), array('%s')); } 

if(isset($_REQUEST['open_ticket_status'])) { 
$ost_wpdb->update($ticket_table, array('status' => 'open'), array( 'ticket_id' => $ticid), array('%s')); } 

$deptid = $ost_wpdb->get_row("SELECT dept_id FROM $topic_table WHERE topic_id=$top_id"); 
$departid=$deptid->dept_id;
$con_tab = $ost_wpdb->get_results("SELECT email FROM $staff_table Where dept_id= $departid"); 
foreach($con_tab as $con_tab1) 
///Variable's for email templates
$username=$usname;
$usermail=$usemail; 
$ticketid=$usticketid;
$admin_email=$adem;
$user_message=$user_message; ///from post form - now becomes a variable & message
$ostitle=$title;
$edate=$date;
$dname=$directory;
$siteurl=site_url()."/$dirname/";
$ticketurl=site_url()."/$dirname/?service=view&ticket=$ticketid";
$poconsubmail=$poconsubmail; /// subject in user email (todo's - add field input to WP Email Templates)

///Email user to confirm post reply
$to=$usermail;
eval("\$subject=\"$poconsubmail\";");
eval("\$message=\"$postconfirm\";");
//$headers = 'From: '.$title.' <' .$admin_email. ">\r\n";
//add_filter('wp_mail_content_type',create_function('', 'return "text/html"; '));
//wp_mail( $to, $subject, wpetss_forum_text($message), $headers);
if(getKeyValue('ticket_alert_admin')==1 && getKeyValue('ticket_alert_active')==1)
{	
///Email osticket admin for a new post reply
$to=$admin_email;
$subject="User Posted Reply";
$adminmessage="Hello Admin,<br />";
$adminmessage.="User (".$usname.") has posted to a support ticket thread.";
$adminmessage.="<br /><br />";
$adminmessage.="Ticket ID :#".$ticketid."<br /><br />";
$adminmessage.="Email: ".$usemail."\n";
$adminmessage.="Department: ".$uscategories."<br />";
$adminmessage.="Subject: ".$ussubject."<br />";
$adminmessage.="<br />----------------------<br />";
$adminmessage.="Message: ".$user_message."";
$adminmessage.="<br />----------------------<br /><br />";
$adminmessage.="To respond to this ticket, please login to the ".$title." system.";
$adminmessage.="<br /><br />";
$adminmessage.="".site_url()."<br />";
$adminmessage.="Your friendly Customer Support System";
$headers = 'From: '.$title.' <' .$adem. ">\r\n";
add_filter('wp_mail_content_type',create_function('', 'return "text/html"; '));
wp_mail( $to, $subject, wpetss_forum_text($adminmessage), $headers);
}
//Email Notification to Department Of Staff Added by Pratik Maniar on 28-04-2014 Start Here
///Email osticket admin - a new ticket has been created

if(getKeyValue('ticket_alert_dept_members')==1 && getKeyValue('ticket_alert_active')==1)
{
$ticket_details = $ost_wpdb->get_row("SELECT dept_id FROM $ticket_table WHERE `number` =$usticketid");
$finaldep_id=$ticket_details->dept_id;
$staff_details = $ost_wpdb->get_results("SELECT email,firstname,lastname FROM $ost_staff WHERE `dept_id` =$finaldep_id");
foreach($staff_details as $staff)
{
	$staff_firstname=$staff->firstname;
	$staff_lastname=$staff->lastname;
	$staff_email=$staff->email;		
	$subject="User Posted Reply";
	$deptmessage="Hello $staff_firstname $staff_lastname,<br />";
	$deptmessage.="User (".$usname.") has posted to a support ticket thread.";
	$deptmessage.="<br /><br />";
	$deptmessage.="Ticket ID :#".$ticketid."<br /><br />";
	$deptmessage.="Email: ".$usemail."\n";
	$deptmessage.="Department: ".$usdepartment."<br />";
	$deptmessage.="Subject: ".$ussubject."<br />";
	$deptmessage.="<br />----------------------<br />";
	$deptmessage.="Message: ".$user_message."";
	$deptmessage.="<br />----------------------<br /><br />";
	$deptmessage.="To respond to this ticket, please login to the ".$title." system.";
	$deptmessage.="<br /><br />";
	$deptmessage.="".site_url()."<br />";
	$deptmessage.="Your friendly Customer Support System";
	$deptmessage;
	$headers = 'From: '.$title.' <' .$adem. ">\r\n";
	add_filter('wp_mail_content_type',create_function('', 'return "text/html"; '));
	wp_mail($staff_email, $subject, wpetss_forum_text($deptmessage), $headers);
}
}
//Email Notification to Department Of Staff Added by Pratik Maniar on 28-04-2014 End Here
?>
