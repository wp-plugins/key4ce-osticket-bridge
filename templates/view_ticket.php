<?php
/*
Template Name: view_ticket.php
*/
global $current_user;
get_currentuserinfo();
if ($ticketinfo->address==$current_user->user_email) {
?>

<style>
#wp-message-wrap{border:2px solid #CCCCCC;border-radius: 5px;padding: 5px;width: 75%;}
#message-html{height: 25px;}
#message-tmce{height: 25px;}

</style>
<div id="ticket_view">
<div id="tic_number">Ticket ID #<?php echo $ticketinfo->number; ?></div>
<div id="tic_icon"><a href="?service=view&ticket=<?php echo $ticketinfo->number; ?>" title="Reload"><span class="Icon refresh"></span></a></div>
<div style="clear: both"></div>
</div>
<div id="tic_info_box">
<div id="tic_stat">Ticket Status:</div>
<div id="tic_stat_info"><?php 
	if($ticketinfo->status=='closed') {
	echo '<font color=red>Closed</font>';
	} 
	elseif ($ticketinfo->status=='open' && $ticketinfo->isanswered=='0') {
	echo '<font color=green>Open</font>';
	}
	elseif ($ticketinfo->status=='open' && $ticketinfo->isanswered=='1') {
	echo '<font color=orange>Answered</font>';
	}
?>
</div>
<div id="tic_name">Name:</div>
<div id="tic_name_user"><?php echo $ticketinfo->name; ?></div>
<div style="clear: both"></div>
<div id="tic_dept">Department:</div>
<div id="tic_dept_info"><?php echo $ticketinfo->dept_name; ?></div>
<div id="tic_email">Email:</div>
<div id="tic_email_user">
<?php echo $ticketinfo->address; ?>
</div>
<div style="clear: both">
</div>
<div id="tic_created">Create Date:</div>
<div id="tic_created_date"><?php echo $ticketinfo->created; ?></div>
<div id="tic_phone">Priority:</div>
<div id="tic_phone_info"><?php
if($ticketinfo->priority_id=='4') {
	echo '<div style="color: Red;"><strong>Emergency</strong></div>';
	} 
	elseif ($ticketinfo->priority_id=='3') {
	echo '<div style="color: Orange;"><strong>High</strong></div>';
	}
	elseif ($ticketinfo->priority_id=='2') {
	echo '<div style="color: Green;"><strong>Normal</strong></div>';
	}
	elseif ($ticketinfo->priority_id=='1') {
	echo '<div style="color: Black;">Low</div>';
	}
    elseif ($ticketinfo->priority_id=='') {
	echo '<div style="color: Black;">Normal</div>';
	}
 ?>
 </div>
<div style="clear: both"></div>
</div>
<div id="tic_sub">
<div id="tic_subject">Subject:</div>
<div id="tic_subject_info"><strong><?php echo @Format::stripslashes($ticketinfo->subject); ?></strong></div>
<div style="clear: both"></div>
</div>
<div id="tic_thread_img_box">
<div><span class="Icon thread">Ticket Thread</span></div>
<div style="clear: both"></div>
</div>
<div id="thContainer">
<div id="ticketThread">
<?php foreach($threadinfo as $thread_info) { ?>
<table style="width:100%; border: 1px solid #aaa; border-bottom: 2px solid #aaa;" cellspacing="0" cellpadding="1" border="0" class="<?php echo $thread_info->thread_type; ?>">
<tbody>
<tr>
<th><?php echo $thread_info->created; ?><span id="ticketThread"><?php if($hidename==1) { echo $thread_info->poster; } ?></span></th>
</tr>
<tr>
<td><?php echo $thread_info->body; ?></td>
</tr>
</tbody>
</table>
<?php } ?>
<div style="clear: both"></div>
</div>
<div id="tic_post">
<div id="tic_post_reply">Post a Reply</div>
<div id="tic_post_detail">To best assist you, please be specific and detailed in your reply.</div>
<div style="clear: both"></div>
</div>
<?php
$id_ademail=$ost_wpdb->get_var("SELECT id FROM $config_table WHERE $config_table.key like ('%admin_email%');");
$os_admin_email=$ost_wpdb->get_row("SELECT id,namespace,$config_table.key,$config_table.value,updated FROM $config_table where id = $id_ademail");
$os_admin_email_admin=$os_admin_email->value;
?>
<table class="welcome nobd" align="center" width="95%" cellspacing="0" cellpadding="3">
<tr>
<td class="nobd" align="center">
<form id="reply" action="" name="reply" method="post" enctype="multipart/form-data" onsubmit="return validateFormReply()">
<input type="hidden" value="<?php echo $thread_info->ticket_id;?>" name="tic_id">
<input type="hidden" value="reply" name="a">
<input type="hidden" name="usticketid" value="<?php echo $ticketinfo->number; ?>"/>
<input type="hidden" name="usid" value="<?php echo $current_user->ID; ?>"/>
<input type="hidden" name="usname" value="<?php echo $ticketinfo->name; ?>"/>
<input type="hidden" name="usemail" value="<?php echo $ticketinfo->address; ?>"/>
<input type="hidden" name="usdepartment" value="<?php echo $ticketinfo->dept_name; ?>"/>
<input type="hidden" name="uscategories" value="<?php echo $ticketinfo->topic; ?>"/>
<input type="hidden" name="ussubject" value="<?php echo $ticketinfo->subject; ?>"/>
<input type="hidden" name="ustopicid" value="<?php echo $ticketinfo->topic_id; ?>"/>
<input type="hidden" name="ademail" value="<?php echo $os_admin_email_admin; ?>"/>
<input type="hidden" name="stitle" value="<?php echo $title_name; ?>"/>
<input type="hidden" name="sdirna" value="<?php echo $dirname; ?>"/>
<input type="hidden" name="postconfirmtemp" value="<?php echo $postconfirm; ?>"/>
<center>
<?php $content = '';
$editor_id = 'message';
$settings = array( 'media_buttons' => false );
wp_editor( $content, $editor_id , $settings );?></center>
</td>
</tr>
<tr>
<td class="nobd" align="center"><div class="clear" style="padding: 5px;"></div>
<?php
	if($ticketinfo->status=='closed') { 
	echo '<center><label><input type="checkbox" name="open_ticket_status" id="open_ticket_status" value="open">&nbsp;&nbsp;<font color=green>Reopen</font> Ticket On Reply</label></center>'; 
	} elseif ($ticketinfo->status=='open') { 
	echo '<center><label><input type="checkbox" name="close_ticket_status" id="close_ticket_status" value="closed">&nbsp;&nbsp;<font color=red>Close</font> Ticket On Reply</label></center>'; 
	} 
?>
<div class="clear" style="padding: 5px;"></div></td>
</tr>
<tr>
<td class="nobd" align="center">
<center><input type="submit" value="Post Reply" name="post-reply"/>
&nbsp;&nbsp;<input type="reset" value="Reset"/>&nbsp;&nbsp;
<input type="button" value="Cancel" onClick="history.go(-1)"/></center>
</form>
</td>
</tr>
</table>
<div style="clear: both"></div>
</div>
<div class="clear" style="padding: 10px;"></div>
<?php } else { ?>
    <div style="width: 100%; margin: 20px; font-size: 20px;" align="center">No such ticket available. </div> <?php } ?>
