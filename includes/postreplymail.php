<?php
/* Template Name: postreplymail.php */
require_once('functions.php');
global $current_user;
get_currentuserinfo();
$config_table=$keyost_prefix."config";
$staff_table=$keyost_prefix."staff";
$pid=0;
$staffid=0;
$source="Web";
$thread_type="M";
$poster=$current_user->user_login;
$usid=$_REQUEST['usid'];
$ticid=$_REQUEST['tic_id'];
$usticketid=$_REQUEST['usticketid'];
$usname=$_REQUEST['usname'];
$usemail=$_REQUEST['usemail'];
$adem=$_REQUEST['ademail'];
$title=$_REQUEST['stitle'];
$dirname=$_REQUEST['sdirna'];
$postconfirm=@Format::stripslashes($_REQUEST['postconfirmtemp']);
$usdepartment=$_REQUEST['usdepartment'];
$ussubject=$_REQUEST['ussubject'];
$uscategories=$_REQUEST['uscategories'];
$top_id=$_REQUEST['ustopicid'];
$user_message=@Format::stripslashes($_REQUEST['message']);
$ipaddress=$_SERVER['REMOTE_ADDR'];
$date=date("Y-m-d g:i:s");
$ticket_details=$ost_wpdb->get_row("SELECT * FROM $ticket_table WHERE number=$usticketid");
$dep_id=$ticket_details->dept_id;

$dept_details=$ost_wpdb->get_row("SELECT * FROM $dept_table WHERE dept_id=$dep_id");
$dept_name=$dept_details->dept_name;
// Start File system changes
$fileconfig=key4ce_FileConfigValue();
$filedata=json_decode($fileconfig);
if($keyost_version==193)
{
$attachement_status=key4ce_getKeyValue('allow_attachments');
$max_user_file_uploads=key4ce_getKeyValue('max_user_file_uploads');
$max_file_size=key4ce_getKeyValue('max_file_size');
$fileextesnions=key4ce_getKeyValue('allowed_filetypes');
}
else
{
$attachement_status=$filedata->attachments;
$max_user_file_uploads=$filedata->max;
$max_file_size=$filedata->size;
$fileextesnions=$filedata->extensions;
}	
// End file system changes
$ost_wpdb->insert($thread_table, array('pid' => $pid,'ticket_id' => $ticid,'staff_id' => $staffid,'user_id' => $usid,'thread_type' => $thread_type,'poster' => $poster,'source' => $source,'title' => "",'body' => key4ce_wpetss_forum_text($user_message),'ip_address' => $ipaddress,'created' => $date),	array('%d','%d','%d','%d','%s','%s','%s','%s','%s','%s','%s')); 
$thread_id = $ost_wpdb->insert_id;

// File Table Entry Code Start Here By Pratik Maniar on 02/09/2014
if (!empty($_FILES['file']['name'][0])) 
{   
   $fileids=array();
   for ($i = 0; $i < count($_FILES['file']['name']); $i++) 
    {     
    $fullfinalpath= key4ce_getKeyValue('uploadpath');
    $key4ce_generateHashKey = key4ce_generateHashKey(33);
    $key4ce_generateHashSignature = key4ce_generateHashSignature(33);
    $dir_name = substr($key4ce_generateHashKey, 0, 1);
    $structure = $fullfinalpath . "/" . $dir_name;
    if (!is_dir($structure)) {
        mkdir($structure, 0355);
    }
    $alowaray = explode(".",str_replace(' ', '',$fileextesnions));
    $strplc = str_replace(".", "",str_replace(' ', '',$fileextesnions));
    $allowedExts = explode(",", $strplc);
	$allowextscnt=count($allowedExts);
    $temp = explode(".", $_FILES['file']['name'][$i]);
    $extension = end($temp); //return uploaded file extension
    $newfilename = $key4ce_generateHashKey;
    $realfilename = $_FILES['file']['name'][$i];
    $filetype = $_FILES["file"]["type"][$i];
    $filesize = $_FILES["file"]["size"][$i];
     if (($_FILES["file"]["size"][$i] < $max_file_size) && (in_array($extension, $allowedExts) || $allowextscnt)) {
        if ($_FILES["file"]["error"][$i] > 0) {
            echo "Return Code: " . $_FILES["file"]["error"][$i] . "<br>";
			exit;
        } else {
            move_uploaded_file($_FILES["file"]["tmp_name"][$i], $structure . "/" . $newfilename);
        }
    }
     $ost_wpdb->insert($keyost_prefix . "file", array('ft' => 'T', 'bk' => 'F', 'type' => $filetype, 
        'size' => $filesize, 'key' => $key4ce_generateHashKey, 'signature' => $key4ce_generateHashSignature,
        'name' => $realfilename, 'attrs' => '', 'created' => $date), array('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s'));
    $file_id = $ost_wpdb->insert_id;
    array_push($fileids, $file_id);
    }       
}
// File Table Entry Code End Here By Pratik Maniar on 02/09/2014
 if (!empty($_FILES['file']['name'][0]))
{   
    foreach($fileids as $file_id)
    {
// File Attachment Table Entry Code Start Here By Pratik Maniar on 02/09/2014
    $ost_wpdb->insert($keyost_prefix . "ticket_attachment", array('ticket_id' => $ticid, 'file_id' => $file_id, 'ref_id' => $thread_id, 'inline' => '0', 'created' => $date), array('%d', '%d', '%d', '%d', '%s'));
// File Attachment Table Entry Code End Here By Pratik Maniar on 02/09/2014
    }
}
/* Added by Pratik Maniar Start Here On 28-04-2014*/
$ost_wpdb->query($ost_wpdb->prepare("UPDATE $ticket_table SET isanswered = 0 WHERE number = %d",$usticketid));
/* Added by Pratik Maniar End Here On 28-04-2014*/
if($keyost_version==194 || $keyost_version==195 || $keyost_version==1951)
{
if(isset($_REQUEST['reply_ticket_status'])) { 
$ost_wpdb->update($ticket_table, array('status_id' => '1'), array('ticket_id' => $ticid), array('%s')); } 

if(isset($_REQUEST['close_ticket_status'])) { 
$ost_wpdb->update($ticket_table, array('status_id' => '3'), array('ticket_id' => $ticid), array('%s')); } 

if(isset($_REQUEST['open_ticket_status'])) { 
$ost_wpdb->update($ticket_table, array('status_id' => '1'), array( 'ticket_id' => $ticid), array('%s')); } 
}
else
{
if(isset($_REQUEST['reply_ticket_status'])) { 
$ost_wpdb->update($ticket_table, array('status' => 'open'), array('ticket_id' => $ticid), array('%s')); } 

if(isset($_REQUEST['close_ticket_status'])) { 
$ost_wpdb->update($ticket_table, array('status' => 'closed'), array('ticket_id' => $ticid), array('%s')); } 

if(isset($_REQUEST['open_ticket_status'])) { 
$ost_wpdb->update($ticket_table, array('status' => 'open'), array( 'ticket_id' => $ticid), array('%s')); } 
}


///Variable's for email templates
$username=$usname;
$usermail=$usemail; 
$ticketid=$usticketid;
$os_admin_email=$adem;
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
if(key4ce_getKeyValue('ticket_alert_admin')==1 && key4ce_getKeyValue('ticket_alert_active')==1)
{	
//Added By Pratik Maniar on 11-12-2014 Start Here
        $default_email_id = $ost_wpdb->get_var("SELECT value FROM " . $keyost_prefix . "config WHERE `key` LIKE 'default_email_id'");
        $default_email_id_data = $ost_wpdb->get_row("SELECT * FROM " . $keyost_prefix . "email WHERE `email_id` =$default_email_id");
		$title_name = $default_email_id_data->name;
		$default_email = $default_email_id_data->email;
//Added By Pratik Maniar on 11-12-2014 End Here
///Email osticket admin for a new post reply
$adminmessage="Hello Admin,<br />";
$adminmessage.="User (".$usname.") has posted to a support ticket thread.";
$adminmessage.="<br /><br />";
$adminmessage.="Ticket ID :#".$ticketid."<br /><br />";
$adminmessage.="Email: ".$usemail."\n";
$adminmessage.="Department: ".$dept_name."<br />";
$adminmessage.="Subject: ".$ussubject."<br />";
$adminmessage.="<br />----------------------<br />";
$adminmessage.="Message: ".$user_message."";
$adminmessage.="<br />----------------------<br /><br />";
$adminmessage.="To respond to this ticket, please login to the ".$title." system.";
$adminmessage.="<br /><br />";
$adminmessage.="".site_url()."<br />";
$adminmessage.="Your friendly Customer Support System";
$headers = 'From: '.$title_name.' <' .$default_email. ">\r\n";
add_filter('wp_mail_content_type',create_function('', 'return "text/html"; '));
wp_mail($default_email, $ussubject, key4ce_wpetss_forum_text('<div style="display: none;">-- do not reply below this line -- <br/><br/></div>'.$adminmessage), $headers);
}
//Email Notification to Department Of Staff Added by Pratik Maniar on 28-04-2014 Start Here
///Email osticket Department - a new ticket has been created
if(key4ce_getKeyValue('ticket_alert_dept_members')==1 && key4ce_getKeyValue('ticket_alert_active')==1)
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
			$deptmessage="Hello $staff_firstname $staff_lastname,<br />A new ticket has been created.<br /><br />";
			$deptmessage.="Ticket ID #".$ticketid."";
			$deptmessage.="<br />----------------------<br />";
			$deptmessage.="Name: ".$username."<br />";
			$deptmessage.="Email: ".$usermail."<br />"; 
			$deptmessage.="Department: ".$dept_name."<br />";
			$deptmessage.="Subject: ".$ussubject."<br />";
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
			wp_mail($staff_email, $ussubject, key4ce_wpetss_forum_text('<div style="display: none;">-- do not reply below this line -- <br/><br/></div>'.$deptmessage), $headers);
		}
	}
	else
	{
		//If Department User Not Found System Will Send Email To Group Members Of Related Department Added By Pratik Maniar on 16-06-2014 Code Start Here
		$getGroups=$ost_wpdb->get_results("SELECT * FROM ".$keyost_prefix."group_dept_access WHERE `dept_id` =$dep_id");
		foreach($getGroups as $group)
		{
			$group_id=$group->group_id;
			$staff_details = $ost_wpdb->get_results("SELECT email,firstname,lastname FROM $ost_staff WHERE `group_id` =$group_id");
			foreach($staff_details as $staff)
			{
				$staff_firstname=$staff->firstname;
				$staff_lastname=$staff->lastname;
				$staff_email=$staff->email;
				$deptmessage="Hello $staff_firstname $staff_lastname,<br />A new ticket has been created.<br /><br />";
				$deptmessage.="Ticket ID #".$ticketid."";
				$deptmessage.="<br />----------------------<br />";
				$deptmessage.="Name: ".$username."<br />";
				$deptmessage.="Email: ".$usermail."<br />"; 
				$deptmessage.="Department: ".$dept_name."<br />";
				$deptmessage.="Subject: ".$ussubject."<br />";
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
				wp_mail($staff_email,$ussubject, key4ce_wpetss_forum_text('<div style="display: none;">-- do not reply below this line -- <br/><br/></div>'.$deptmessage), $headers);
			}
	
		}
		//If Department User Not Found System Will Send Email To Group Members Of Related Department Added By Pratik Maniar on 16-06-2014 Code End Here
	}	
} //Email Notification to Department Of Staff Added by Pratik Maniar on 28-04-2014 End Here
?>
