<?php
/*
Template Name: newticketemail.php
*/
require_once('functions.php');
?>
<?php 
global $current_user;
get_currentuserinfo();
$wp_user_email_id=$current_user->user_email;

$tic_ID=generateID();
$checkUserID = $ost_wpdb->get_results("SELECT number from $ticket_table WHERE number = '$tic_ID'");
if(count($checkUserID)>0){
$tic_ID=generateID();
}
$dep_id=$_REQUEST['deptId'];
$sla_id=1;
$pri_id=$_REQUEST['priorityId'];
@$top_id=$_REQUEST['topicId'];
$staff_id=0;
$team_id=0;
$usid=$_REQUEST['usid'];
$em=$_REQUEST['email'];
$nam=$current_user->user_login;
$nam=preg_replace('/[^\p{L}\p{N}\s]/u', '',$nam);
$adem=$_REQUEST['ademail'];
$title=$_REQUEST['stitle'];
$dirname=$_REQUEST['sdirna'];
@$sub=Format::stripslashes($_REQUEST['subject']);
@$newtickettemp=Format::stripslashes($_REQUEST['newtickettemp']);
$ip_add=$_SERVER['REMOTE_ADDR'];
$stat="open";
$sour="Web";
$isoverdue=0;
$isans=0;
$las_msg=date("Y-m-d, g:i:s", strtotime("-5 hour"));
$cre=date("Y-m-d, g:i:s", strtotime("-5 hour"));
@$user_message=Format::stripslashes($_REQUEST['message']);
$last_ost_user_id="";
$prid = $ost_wpdb->get_row("SELECT priority_desc FROM $priority_table WHERE priority_id=$pri_id");
$priordesc=$prid->priority_desc;
// Added by Pratik Maniar on 29-04-2014 Start Here
$dept_details = $ost_wpdb->get_row("SELECT dept_id,dept_name FROM $dept_table WHERE dept_id=$dep_id");
$dept_name=$dept_details->dept_name;
// Added by Pratik Maniar on 29-04-2014 End Here
/////New user info > check if user exists or create a new user...
$result1=$ost_wpdb->get_results("SELECT address FROM ost_user_email WHERE address = '".$wp_user_email_id."'");
if (count ($result1) > 0) {
	$row = current ($result1);	
} else {
	$ost_wpdb->query ("INSERT INTO ost_user_email (id, user_id, address) VALUES ('','".$usid."','".$wp_user_email_id."')");
	$last_ost_user_email_id = $ost_wpdb->insert_id;
}

$result2=$ost_wpdb->get_results("SELECT default_email_id,name FROM ost_user WHERE default_email_id = '".$last_ost_user_email_id."'");
if (count ($result2) > 0) {
	$row = current ($result2);
	$name=$result2->name;
	if($name=="")
	{
	$wpdb->query("UPDATE ost_user SET name = ".$nam." WHERE default_email_id = '".$last_ost_user_email_id."'");	
	}
	///$wpdb->query ("UPDATE ost_user SET id = ".($row->ost_user + 1)." WHERE id = '".$usid."'");
	///don't need to update user info, but keep here for later versions, if needed..
} else {
	$ost_wpdb->query ("INSERT INTO ost_user (id, default_email_id, name, created, updated) VALUES ('','".$last_ost_user_email_id."', '".$nam."', '".$cre."', '".$cre."')
	");
	$last_ost_user_id = $ost_wpdb->insert_id;
	$ost_wpdb->query ("UPDATE ost_user_email SET user_id=$last_ost_user_id where id=$last_ost_user_email_id");
}

////End of new user info user_email_id email_id
if (count ($result1) > 0) {
$ost_wpdb->insert($ticket_table, array('number' => $tic_ID,'user_id' => $usid,'user_email_id' => $usid,'dept_id' => $dep_id,'sla_id' => $sla_id,'topic_id' => $top_id,'staff_id' => $staff_id,'team_id' => $team_id,'email_id' => $usid,'ip_address' => $ip_add,'status' => $stat,'source' => $sour,'isoverdue' => $isoverdue,'isanswered' => $isans,'lastmessage' => $las_msg,'created' => $cre), array('%d','%d','%d','%d','%d','%d','%d','%d','%d','%s','%s','%s','%s','%s','%s','%s'));
}
else
{
$ost_wpdb->insert($ticket_table, array('number' => $tic_ID,'user_id' => $last_ost_user_id,'user_email_id' => $last_ost_user_email_id,'dept_id' => $dep_id,'sla_id' => $sla_id,'topic_id' => $top_id,'staff_id' => $staff_id,'team_id' => $team_id,'email_id' => $last_ost_user_email_id,'ip_address' => $ip_add,'status' => $stat,'source' => $sour,'isoverdue' => $isoverdue,'isanswered' => $isans,'lastmessage' => $las_msg,'created' => $cre), array('%d','%d','%d','%d','%d','%d','%d','%d','%d','%s','%s','%s','%s','%s','%s','%s'));
}
$lastid = $ost_wpdb->insert_id;
$stat="created";
$staf="SYSTEM";
$annulled=0;
$ost_wpdb->insert($ticket_event_table, array('ticket_id' => $lastid,'staff_id' => $staff_id,'team_id' => $team_id,'dept_id' => $dep_id,'topic_id' => $top_id,'state' => $stat,'staff' => $staf,'annulled' => $annulled,'timestamp' => $cre), array('%d','%d','%d','%d','%d','%s','%s','%s','%s'));

$pid=0;	    
$thread_type="M";

$ost_wpdb->insert($thread_table, array('pid' => $pid,'ticket_id' => $lastid,'staff_id' => $staff_id,'thread_type' => $thread_type,'poster' => $nam,'source' => $sour,'title' => "",'body' => wpetss_forum_text($user_message),'ip_address' => $ip_add,'created' => $cre), array('%d','%d','%d','%s','%s','%s','%s','%s','%s','%s'));

$ost_wpdb->insert($ticket_cdata, array('ticket_id' => $lastid,'subject' => $sub,'priority' => $priordesc,'priority_id' => $pri_id), array('%d','%s','%s','%d'));

@$topic_tab = $ost_wpdb->get_results("SELECT topic_id, topic FROM $topic_table WHERE topic_id=@$top_id");

foreach($topic_tab as $topic_tab1) { @$top=$topic_tab1->topic; }

$config_table="ost_config";
$staff_table="ost_staff";
//$os_admin_email=$adem;

//Commented By Pratik Maniar on 14-06-2014 Start Here

/*
@$deptid = $ost_wpdb->get_row("SELECT dept_id FROM $topic_table WHERE topic_id=$top_id");
@$departid=$deptid->dept_id;
$con_tab = $ost_wpdb->get_results("SELECT email FROM $staff_table Where dept_id=$departid");
foreach($con_tab as $con_tab1)
*/

//Commented By Pratik Maniar on 14-06-2014 End Here

///Variable's for email templates
//$os_admin_email=$adem;
$username=$nam;
$usermail=$em;
$ticketid=$tic_ID;
$user_message=$user_message; ///from post form - now becomes a variable & message
$ostitle=$title;
@$edate=$date;
$dname=$directory;
$siteurl=get_permalink();
if(isset($_REQUEST['page_id']))
	$ticketurl=get_permalink()."?service=view&ticket=$ticketid";	
else
	$ticketurl=get_permalink()."&service=view&ticket=$ticketid";	

//echo the_permalink();
$postsubmail=$postsubmail; /// subject in user email (todo's - add field input to WP Email Templates)

///Email the user with template
$to=$usermail;
eval("\$subject=\"$postsubmail\";");
eval("\$message=\"$newtickettemp\";");
//$headers = 'From: '.$title.' <' .$adem. ">\r\n";
//add_filter('wp_mail_content_type',create_function('', 'return "text/html"; '));
//wp_mail( $to, $subject, wpetss_forum_text($message), $headers);

///Email osticket admin - a new ticket has been created
if(getKeyValue('ticket_alert_admin')==1 && getKeyValue('ticket_alert_active')==1)
{
//Added By Pratik Maniar On 14-06-2014 Code Start Here To Avoid Auto generate by Department Emails
$id_ademail=$ost_wpdb->get_var("SELECT id FROM $config_table WHERE $config_table.key like ('%admin_email%');");
$os_admin_email=$ost_wpdb->get_row("SELECT id,namespace,$config_table.key,$config_table.value,updated FROM $config_table where id = $id_ademail");
$os_admin_email_admin=$os_admin_email->value;
//Added By Pratik Maniar On 14-06-2014 Code End Here To Avoid Auto generate by Department Emails
$subject="New Support Ticket";
$adminmessage="Hello Admin,<br />A new ticket has been created.<br /><br />";
$adminmessage.="Ticket ID #".$ticketid."";
$adminmessage.="<br />----------------------<br />";
$adminmessage.="Name: ".$username."<br />";
$adminmessage.="Email: ".$usermail."<br />"; 
$adminmessage.="Priority: ".$priordesc."<br />";
$adminmessage.="Department: ".$dept_name."<br />";
$adminmessage.="Subject: ".$sub."<br />";
$adminmessage.="<br />----------------------<br />";
$adminmessage.="Message: ".$user_message."";
$adminmessage.="<br />----------------------<br /><br />";
$adminmessage.="To respond to the ticket, please login to the support ticket system.";
$adminmessage.="<br /><br />";
$adminmessage.="".site_url()."";
$adminmessage.="<br />";
$adminmessage.="Your friendly Customer Support System ";
$headers = 'From: '.$title.' <' .$adem. ">\r\n";
add_filter('wp_mail_content_type',create_function('', 'return "text/html"; '));
wp_mail($os_admin_email_admin, $subject, wpetss_forum_text('<div style="display: none;">-- do not reply below this line -- <br/><br/></div>'.$adminmessage), $headers);
}
//Email Notification to Department Of Staff Added by Pratik Maniar on 28-04-2014 Start Here
///Email osticket Department - a new ticket has been created
if(getKeyValue('ticket_alert_dept_members')==1 && getKeyValue('ticket_alert_active')==1)
{
	$staff_details = $ost_wpdb->get_results("SELECT email,firstname,lastname FROM $ost_staff WHERE `dept_id` =$dep_id");
	$department_staff=count($staff_details);	
	if($department_staff>0)
	{	
		foreach($staff_details as $staff)
		{
			$staff_firstname=$staff->firstname;
			$staff_lastname=$staff->lastname;
			$staff_email=$staff->email;
			$subject=$sub;
			$deptmessage="Hello $staff_firstname $staff_lastname,<br />A new ticket has been created.<br /><br />";
			$deptmessage.="Ticket ID #".$ticketid."";
			$deptmessage.="<br />----------------------<br />";
			$deptmessage.="Name: ".$username."<br />";
			$deptmessage.="Email: ".$usermail."<br />"; 
			$deptmessage.="Priority: ".$priordesc."<br />";
			$deptmessage.="Department: ".$dept_name."<br />";
			$deptmessage.="Subject: ".$subject."<br />";
			$deptmessage.="<br />----------------------<br />";
			$deptmessage.="Message: ".$user_message."";
			$deptmessage.="<br />----------------------<br /><br />";
			$deptmessage.="To respond to the ticket, please login to the support ticket system.";
			$deptmessage.="<br /><br />";
			$deptmessage.="".site_url()."";
			$deptmessage.="<br />";
			$deptmessage.="Your friendly Customer Support System ";
			$headers = 'From: '.$ostitle.' <' .$adem. ">\r\n";
			add_filter('wp_mail_content_type',create_function('', 'return "text/html"; '));
			wp_mail($staff_email, $subject, wpetss_forum_text('<div style="display: none;">-- do not reply below this line -- <br/><br/></div>'.$deptmessage), $headers);
		}
	}
	else
	{
		//If Department User Not Found System Will Send Email To Group Members Of Related Department Added By Pratik Maniar on 16-06-2014 Code Start Here
		$getGroups=$ost_wpdb->get_results("SELECT * FROM `ost_group_dept_access` WHERE `dept_id` =$dep_id");
		foreach($getGroups as $group)
		{
			$group_id=$group->group_id;
			$staff_details = $ost_wpdb->get_results("SELECT email,firstname,lastname FROM $ost_staff WHERE `group_id` =$group_id");
			foreach($staff_details as $staff)
			{
				$staff_firstname=$staff->firstname;
				$staff_lastname=$staff->lastname;
				$staff_email=$staff->email;
				$subject=$sub;
				$deptmessage="Hello $staff_firstname $staff_lastname,<br />A new ticket has been created.<br /><br />";
				$deptmessage.="Ticket ID #".$ticketid."";
				$deptmessage.="<br />----------------------<br />";
				$deptmessage.="Name: ".$username."<br />";
				$deptmessage.="Email: ".$usermail."<br />"; 
				$deptmessage.="Priority: ".$priordesc."<br />";
				$deptmessage.="Department: ".$dept_name."<br />";
				$deptmessage.="Subject: ".$subject."<br />";
				$deptmessage.="<br />----------------------<br />";
				$deptmessage.="Message: ".$user_message."";
				$deptmessage.="<br />----------------------<br /><br />";
				$deptmessage.="To respond to the ticket, please login to the support ticket system.";
				$deptmessage.="<br /><br />";
				$deptmessage.="".site_url()."";
				$deptmessage.="<br />";
				$deptmessage.="Your friendly Customer Support System ";
				$headers = 'From: '.$ostitle.' <' .$adem. ">\r\n";
				add_filter('wp_mail_content_type',create_function('', 'return "text/html"; '));
				wp_mail($staff_email, $subject, wpetss_forum_text('<div style="display: none;">-- do not reply below this line -- <br/><br/></div>'.$deptmessage), $headers);
			}
	
		}
		//If Department User Not Found System Will Send Email To Group Members Of Related Department Added By Pratik Maniar on 16-06-2014 Code End Here
	}	
}
//Email Notification to Department Of Staff Added by Pratik Maniar on 28-04-2014 End Here
?>
