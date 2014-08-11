<?php
/*
Template Name: db-settings-18.php
*/
?>
<?php 
global $wpdb; 
$ostemail = $wpdb->prefix . "ost_emailtemp"; 
$adminreply=$wpdb->get_row("SELECT id,name,subject,$ostemail.text,created,updated FROM $ostemail where name = 'Admin-Response'"); 
$adminreply=$adminreply->text;
$arname='Admin-Response';

$postsubmail=$wpdb->get_row("SELECT id,name,$ostemail.subject,text,created,updated FROM $ostemail where name = 'Admin-Response'"); 
$postsubmail=$postsubmail->subject;

$newticket=$wpdb->get_row("SELECT id,name,$ostemail.subject,$ostemail.text,created,updated FROM $ostemail where name = 'New-Ticket'"); 
$newticket=$newticket->text; 
$ntname='New-Ticket';

$user_name=$current_user->user_login; 
$e_address=$current_user->user_email;
/*Add user id of ticket instead of wordpress start here */
$user_id = $ost_wpdb->get_var("SELECT user_id FROM ".$keyost_prefix."user_email WHERE `address` = '".$e_address."'");
/*Add user id of ticket instead of wordpress end here*/


$getNumOpenTickets=$ost_wpdb->get_var("SELECT COUNT(*) FROM $ticket_table WHERE user_id='$user_id' and status='open'"); 

$ticket_count=$ost_wpdb->get_var("SELECT COUNT(*) FROM $ticket_table WHERE user_id='$user_id'"); 
$ticket_count_open=$ost_wpdb->get_var("SELECT COUNT(*) FROM $ticket_table WHERE user_id='$user_id' and status='open'"); 
$ticket_count_closed=$ost_wpdb->get_var("SELECT COUNT(*) FROM $ticket_table WHERE user_id='$user_id' and status='closed'"); 

//////Ticket Info
$ticketinfo=$ost_wpdb->get_row("SELECT $ticket_table.user_id,$ticket_table.number,$ticket_table.created,$ticket_table.ticket_id,$ticket_table.status,$ticket_table.isanswered,$ost_user.name,$dept_table.dept_name,$ticket_cdata.priority,$ticket_cdata.priority_id,$ticket_cdata.subject,$ost_useremail.address FROM $ticket_table INNER JOIN $dept_table ON $dept_table.dept_id=$ticket_table.dept_id INNER JOIN $ost_user ON $ost_user.id=$ticket_table.user_id INNER JOIN $ost_useremail ON $ost_useremail.user_id=$ticket_table.user_id LEFT JOIN $ticket_cdata on $ticket_cdata.ticket_id = $ticket_table.ticket_id WHERE `number` ='$ticket'");
//////Thread Info
$threadinfo=$ost_wpdb->get_results("SELECT $ost_useremail.address,$thread_table.created,$thread_table.id,$thread_table.ticket_id,$thread_table.thread_type,$thread_table.body,$thread_table.poster 
	FROM $thread_table 
	inner join $ticket_table on $thread_table.ticket_id = $ticket_table.ticket_id 
	inner join ".$keyost_prefix."user_email on ".$keyost_prefix."user_email.user_id = $ticket_table.user_id
	where number = '$ticket' 
	ORDER BY  $thread_table.id ASC"); 
$search="";
if(isset($_REQUEST['search']))
{
$search=@$_REQUEST['tq'];
}
if(isset($_POST['action']))
$arr = explode('.', $_POST['action']);
if(!$status_opt && ($status_opt!="all")) {
	if($ticket_count_open > 0)
		$status_opt='open';
	else
		$status_opt='closed';
    }
if(!$status_opt && ($status_opt=="all")) 
	$status_opt='';
if($status_opt=="open") {
	$status_opt='open';
    }
elseif($status_opt=="closed") {
	$status_opt='closed';
	}
if($user_id!="")        
{
$sql="";
$sql="SELECT $ticket_table.user_id,$ticket_table.number,$ticket_table.created, $ticket_table.updated, $ticket_table.ticket_id, $ticket_table.status,$ticket_table.isanswered,$ticket_cdata.subject,$ticket_cdata.priority_id, $dept_table.dept_name
      FROM $ticket_table
      LEFT JOIN $ticket_cdata ON $ticket_cdata.ticket_id = $ticket_table.ticket_id
      INNER JOIN $dept_table ON $dept_table.dept_id = $ticket_table.dept_id WHERE $ticket_table.user_id =$user_id";
if($category && ($category!="all"))
$sql.=" and $topic_table.topic_id = '".$category."'";
if($status_opt && ($status_opt!="all") && $search=="")
$sql.=" and $ticket_table.status = '".$status_opt."'";
if(@$search && ($search!=""))
$sql.=" and ($ticket_table.number like '%".$search."%' or $ticket_table.status like '%".$search."%' or $ticket_cdata.subject like '%".$search."%' or $dept_table.dept_name like '%".$search."%')";
$sql.=" GROUP BY $ticket_table.ticket_id";  
if(isset($_POST['action']) && $arr[0]=='ascen')
$sql.=" ORDER BY $arr[1] ASC, $ticket_table.updated ASC";
else if(isset($_POST['action']) && $arr[0]=='desc')
$sql.=" ORDER BY $arr[1] DESC, $ticket_table.updated DESC";
else
$sql.=" ORDER BY $ticket_table.ticket_id DESC";
@$numrows=mysql_num_rows(mysql_query($sql)); 
$rowsperpage = 7; 
$totalpages = ceil($numrows / $rowsperpage); 
if (isset($_REQUEST['currentpage']) && is_numeric($_REQUEST['currentpage'])) { 
$currentpage = (int) $_GET['currentpage']; 
} else { 
$currentpage = 1; 
} 
if ($currentpage > $totalpages) { 
$currentpage = $totalpages; 
} 
if ($currentpage < 1) { 
$currentpage = 1; 
} 
$offset = ($currentpage - 1) * $rowsperpage; 
$sql.=" LIMIT $offset, $rowsperpage";  
$list_opt = $ost_wpdb->get_results($sql); 
}
?>