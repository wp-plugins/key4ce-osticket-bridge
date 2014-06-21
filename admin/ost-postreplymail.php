<?php 
$ticket_number=$_REQUEST['ticket'];
$ticket_details=$ost_wpdb->get_row("SELECT $dept_table.dept_id,$dept_table.dept_name,$dept_table.email_id,$ost_email.email FROM $ticket_table 
INNER JOIN $dept_table ON $dept_table.dept_id=$ticket_table.dept_id
INNER JOIN $ost_email ON $ost_email.dept_id=$dept_table.dept_id
WHERE `number`=$ticket_number");
//$getDeptemail=getDeptemail($ticket_number);
$ticket_detail_dept_name=$ticket_details->dept_name;
$ticket_detail_dept_email=$ticket_details->email;
$department_id=$ticket_details->dept_id;
$pid=0;
$staffid=1; 
$ticid=$_REQUEST['tic_id'];
$thread_type="R";
$poster=$_REQUEST['adname'];
$source="Web";
$admin_response=Format::stripslashes($_REQUEST['message']); ///from post to thread-table to variable to email
$ipaddress=$_SERVER['REMOTE_ADDR'];
$date=date("Y-m-d, g:i:s", strtotime("-5 hour")); ///EST (todo's - add option to WP osT-Settings)

$ost_wpdb->insert($thread_table, array('pid'=>$pid,'ticket_id'=>$ticid,'staff_id'=>$staffid,'thread_type'=>$thread_type,'poster'=>$poster,'source'=>$source,'title'=>"",'body'=>wpetss_forum_text($admin_response),'ip_address'=>$ipaddress,'created'=>$date), array('%d','%d','%d','%s','%s','%s','%s','%s','%s','%s'));
/* Added by Pratik Maniar Start Here On 28-04-2014*/
$ost_wpdb->query($ost_wpdb->prepare("UPDATE $ticket_table SET isanswered = 1 WHERE number = $ticket_number" ));
/* Added by Pratik Maniar End Here On 28-04-2014*/
if(isset($_REQUEST['reply_ticket_status'])) { 
$ost_wpdb->update($ticket_table, array('status'=>'open'), array('ticket_id'=>$ticid), array('%s')); } 
if(isset($_REQUEST['close_ticket_status'])) { 
$ost_wpdb->update($ticket_table, array('status'=>'closed'), array('ticket_id'=>$ticid), array('%s')); } 
if(isset($_REQUEST['open_ticket_status'])) { 
$ost_wpdb->update($ticket_table, array('status'=>'open'), array('ticket_id'=>$ticid), array('%s')); }

///post from form
$usticketid=$_REQUEST['usticketid'];
$usname=$_REQUEST['usname'];
$usemail=$_REQUEST['usemail'];
$adem=$_REQUEST['ademail'];
$title=$_REQUEST['stitle'];
$usdepartment=$_REQUEST['usdepartment'];
$ussubject=$_REQUEST['ussubject'];
$uscategories=$_REQUEST['uscategories'];
$top_id=$_REQUEST['ustopicid'];
$dirname=$_REQUEST['sdirna'];
$admin_reply=Format::stripslashes($_REQUEST['adreply']); /// clean template from form to user email

///Getting department info
$deptid=$ost_wpdb->get_row("SELECT * FROM $dept_table WHERE dept_id=$ticket_detail_dept_id");
$departid=$deptid->dept_id;
$dept_name=$deptid->dept_name;
$con_tab=$ost_wpdb->get_results("SELECT email FROM $dept_table Where dept_id= $departid");
foreach($con_tab as $con_tab1)

///Variable's for email templates
$admin_email=$adem;
$username=$usname;
$usermail=$usemail;
$ticketid=$usticketid;
$admin_response=$admin_response; ///from post form - now becomes a variable & message
$ostitle=$title;
$edate=$date;
$dname=$directory;
$siteurl=site_url()."/$dirname/";
$ticketurl=site_url()."/$dirname/?service=view&ticket=$ticketid";
$postsubmail=$postsubmail; /// subject in user email (todo's - add field input to WP Email Templates)

///Send user the posted message (using aval() --> not sending login info so it's ok to use)
$to=$usemail;
eval("\$subject=\"$postsubmail\";");
eval("\$message=\"$admin_reply\";");
if($department_id==1)
{
	add_filter('wp_mail_from', 'new_mail_from');
	add_filter('wp_mail_from_name', 'new_mail_from_name');	 
	function new_mail_from($old) {
	 return 'support@key4ce.eu';
	}
	function new_mail_from_name($old) {
	 return 'Support - Key4ce';
	}
}
else if($department_id==2)
{ 	
	add_filter('wp_mail_from', 'new_mail_from');
	add_filter('wp_mail_from_name', 'new_mail_from_name');	 
	function new_mail_from($old) {
	 return 'sales@key4ce.eu';
	}
	function new_mail_from_name($old) {
	 return 'Key4ce - Sales';
	}
}
else if($department_id==4)
{ 	 	
	add_filter('wp_mail_from', 'new_mail_from');
	add_filter('wp_mail_from_name', 'new_mail_from_name');	 
	function new_mail_from($old) {
	 return 'billing@key4ce.eu';
	}
	function new_mail_from_name($old) {
	 return 'Key4ce - Billing';
	}
}
else if($department_id==5)
{
	add_filter('wp_mail_from', 'new_mail_from');
	add_filter('wp_mail_from_name', 'new_mail_from_name');	 
	function new_mail_from($old) {
	 return 'abuse@key4ce.eu';
	}
	function new_mail_from_name($old) {
	 return 'Key4ce - Abuse';
	}
}
else if($department_id==6)
{
	add_filter('wp_mail_from', 'new_mail_from');
	add_filter('wp_mail_from_name', 'new_mail_from_name');	 
	function new_mail_from($old) {
	 return 'system@key4ce.eu';
	}
	function new_mail_from_name($old) {
	 return 'Key4ce - Info';
	}
}
$headers = 'From: '.$title.' <' .$adem. ">\r\n";
add_filter('wp_mail_content_type',create_function('', 'return "text/html"; '));
wp_mail($to, $subject,wpetss_forum_text($message), $headers);
?>
