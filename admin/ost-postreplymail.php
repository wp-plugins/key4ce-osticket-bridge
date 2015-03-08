<?php
global $current_user;
get_currentuserinfo();
$ticket_number=$_REQUEST['ticket'];
$signature_type=$_REQUEST['signature'];
$ticket_details=$ost_wpdb->get_row("SELECT $dept_table.dept_signature,$ost_email.name,$dept_table.dept_id,$dept_table.dept_name,$dept_table.email_id,$ost_email.email FROM $ticket_table 
INNER JOIN $dept_table ON $dept_table.dept_id=$ticket_table.dept_id
INNER JOIN $ost_email ON $ost_email.email_id=$dept_table.email_id
WHERE `number`=$ticket_number");
$ticket_detail_dept_name=$ticket_details->name;
$ticket_detail_dept_email=$ticket_details->email;
$signature=$ticket_details->dept_signature;
$department_id=$ticket_details->dept_id;
if($signature_type=="mine")
	$signature = $ost_wpdb->get_var("SELECT signature FROM $staff_table WHERE email='".$current_user->user_email."'");
else
	$signature=$ticket_details->dept_signature;
$pid=0;
$staffid=1; 
$ticid=$_REQUEST['tic_id'];
$thread_type="R";
$poster=$current_user->user_login;
$source="Web";
$admin_response=@Format::stripslashes($_REQUEST['message']); ///from post to thread-table to variable to email
$ipaddress=$_SERVER['REMOTE_ADDR'];
$date=date("Y-m-d g:i:s"); ///EST (todo's - add option to WP osT-Settings)

$ost_wpdb->insert($thread_table, array('pid'=>$pid,'ticket_id'=>$ticid,'staff_id'=>$staffid,'thread_type'=>$thread_type,'poster'=>$poster,'source'=>$source,'title'=>"",'body'=>key4ce_wpetss_forum_text($admin_response),'ip_address'=>$ipaddress,'created'=>$date), array('%d','%d','%d','%s','%s','%s','%s','%s','%s','%s'));
$thread_id = $ost_wpdb->insert_id;

// File Table Entry Code Start Here By Pratik Maniar on 02/08/2014 
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
        'name' => $realfilename, 'attrs' => '', 'created' => $date), array('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s'));
    $file_id = $ost_wpdb->insert_id;
    array_push($fileids, $file_id);
    }       
}
// File Table Entry Code End Here By Pratik Maniar on 02/08/2014 
 if (!empty($_FILES['file']['name'][0]))
{   
    foreach($fileids as $file_id)
    {
// File Attachment Table Entry Code Start Here By Pratik Maniar on 02/08/2014 
$ost_wpdb->insert($keyost_prefix."ticket_attachment", array('ticket_id' => $ticid,'file_id' => $file_id,'ref_id' => $thread_id,'inline' => '0','created'=>$date), 
array('%d','%d','%d','%d','%s'));
// File Attachment Table Entry Code End Here By Pratik Maniar on 02/08/2014 

    }
}
/* Added by Pratik Maniar Start Here On 28-04-2014*/
$ost_wpdb->query($ost_wpdb->prepare("UPDATE $ticket_table SET isanswered = 1 WHERE number = %s",$ticket_number));
/* Added by Pratik Maniar End Here On 28-04-2014*/
if($keyost_version==194)
{
if(isset($_REQUEST['reply_ticket_status'])) { 
$ost_wpdb->update($ticket_table, array('status_id'=>'1'), array('ticket_id'=>$ticid), array('%s')); } 
if(isset($_REQUEST['close_ticket_status'])) { 
$ost_wpdb->update($ticket_table, array('status_id'=>'3'), array('ticket_id'=>$ticid), array('%s')); } 
if(isset($_REQUEST['open_ticket_status'])) { 
$ost_wpdb->update($ticket_table, array('status_id'=>'1'), array('ticket_id'=>$ticid), array('%s')); }
}
else
{
if(isset($_REQUEST['reply_ticket_status'])) { 
$ost_wpdb->update($ticket_table, array('status'=>'open'), array('ticket_id'=>$ticid), array('%s')); } 
if(isset($_REQUEST['close_ticket_status'])) { 
$ost_wpdb->update($ticket_table, array('status'=>'closed'), array('ticket_id'=>$ticid), array('%s')); } 
if(isset($_REQUEST['open_ticket_status'])) { 
$ost_wpdb->update($ticket_table, array('status'=>'open'), array('ticket_id'=>$ticid), array('%s')); }
}

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
$admin_reply=@Format::stripslashes($_REQUEST['adreply']); /// clean template from form to user email

///Variable's for email templates
$os_admin_email=$adem;
$username=$usname;
$usermail=$usemail;
$ticketid=$usticketid;
$admin_response=$admin_response; ///from post form - now becomes a variable & message
$admin_response=nl2br($admin_response);
$ostitle=$title;
$edate=$date;
$dname=$directory;
$siteurl=site_url()."/$dirname/";
$ticketurl=site_url()."/$dirname/?service=view&ticket=$ticketid";
$postsubmail=$postsubmail; /// subject in user email (todo's - add field input to WP Email Templates)
///Send user the posted message (using aval() --> not sending login info so it's ok to use)
$to=$usemail;
eval("\$subject=\"$ussubject\";");
eval("\$message=\"$admin_reply\";");
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
$phpmailer->From =  "$ticket_detail_dept_email";
$phpmailer->FromName = "$ticket_detail_dept_name";
add_filter('wp_mail_content_type',create_function('', 'return "text/html"; '));
$phpmailer->Subject    =$subject;
$phpmailer->Body       = key4ce_wpetss_forum_text($message);                      //HTML Body
$phpmailer->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
$phpmailer->MsgHTML('<div style="display: none;">-- do not reply below this line -- <br/><br/></div>' . $message);
$phpmailer->AddAddress($to);
$phpmailer->Send();
}
else
{
$phpmailer->CharSet = 'UTF-8';
$phpmailer->setFrom("$ticket_detail_dept_email", "$ticket_detail_dept_name");
$phpmailer->addReplyTo("$ticket_detail_dept_email", "$ticket_detail_dept_name");
$phpmailer->addAddress($to);
add_filter('wp_mail_content_type',create_function('', 'return "text/html"; '));
$phpmailer->Subject = $subject;
$phpmailer->MsgHTML('<div style="display: none;">-- do not reply below this line -- <br/><br/></div>' . $message);
$phpmailer->AltBody = 'This is a plain-text message body';
$phpmailer->send();
}
?>
