<?php
require_once( WP_PLUGIN_DIR . '/key4ce-osticket-bridge/includes/functions.php' ); ?>
<div class="wrap">
<div class="headtitle">Reply to Support Request</div>
<div style="clear: both"></div>
<?php
require_once( WP_PLUGIN_DIR . '/key4ce-osticket-bridge/admin/db-settings.php'); 
require_once( WP_PLUGIN_DIR . '/key4ce-osticket-bridge/admin/header_nav_ticket.php'); 
?>
<div id="ticket_view">
<div id="tic_number">Ticket ID #<?php echo $ticketinfo->number; ?></div>
<div id="tic_icon"><a href="admin.php?page=ost-tickets&service=view&ticket=<?php echo $ticketinfo->number; ?>" title="Reload"><span class="Icon refresh"></span></a><span class="preply">&darr; <a href="#post">Post Reply</a></span></div>
<div style="clear: both"></div>
</div>
<div id="tic_info_box">
<table>
<tr> 
<td><b>Ticket Status:</b></td>
<td><div>
<?php
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
</div></td>
<td><b>Username:</b></td>
<td><div><?php echo $ticketinfo->name; ?></div></td>
</tr>
<tr> 
<td><b>Department:</b></td>
<td><div><?php echo $ticketinfo->dept_name; ?></div></td>
<td><b>User Email:</b></td>
<td><div><?php echo $ticketinfo->address; ?></div></td>
</tr>
<tr> 
<td><b>Date Create:</b></td>
<td><div><?php echo $ticketinfo->created; ?></div></td>
<td><b>Priority:</b></td>
<td> 
<div><?php
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
</td>
</tr>
</table>
</div>
<div style="clear: both"></div>
<div id="tic_sub">
<div id="tic_subject">Subject:</div>
<div id="tic_subject_info"><?php echo $ticketinfo->subject; ?></div>
<div style="clear: both"></div>
</div>
<div id="tic_thread_img_box">
<div><span class="Icon thread">Ticket Thread</span></div>
<div style="clear: both"></div>
</div>
<div id="ticketThread">
<?php foreach($threadinfo as $thread_info) { ?>
<table width="100%" style="width: 95%; margin: 10px 20px 10px 20px; border: 1px solid #aaa; border-bottom: 2px solid #aaa;" class="<?php echo $thread_info->thread_type; ?>">
<tbody>
<tr>
<th><?php echo $thread_info->created; ?><span><?php echo $thread_info->poster; //if($hidename==1) { echo $thread_info->poster; } ?></span></th>
</tr>
<tr>
<td><?php echo $thread_info->body;?></td>
</tr>
</tbody>
</table>
<?php } ?>
<div style="clear: both"></div>
</div>
<div id="tic_post">
<div id="tic_post_reply">Post a Reply</div>
<div style="clear: both"></div>
</div>
<table align="center" width="95%" cellspacing="0" cellpadding="3" border="0">
<tr>
<td align="center"><a name="post"></a>
<form name="ost-post-reply" id="ost-reply" action="admin.php?page=ost-tickets&service=view&ticket=<?php echo $ticketinfo->number; ?>" method="post" enctype="multipart/form-data">
<input type="hidden" value="<?php echo $thread_info->ticket_id; ?>" name="tic_id">
<input type="hidden" value="reply" name="a">
<input type="hidden" name="usticketid" value="<?php echo $ticketinfo->number; ?>"/>
<input type="hidden" name="usname" value="<?php echo $ticketinfo->name; ?>"/>
<input type="hidden" name="usemail" value="<?php echo $ticketinfo->address; ?>"/>
<input type="hidden" name="usdepartment" value="<?php echo $ticketinfo->dept_name; ?>"/>
<input type="hidden" name="uscategories" value="<?php echo $ticketinfo->topic; ?>"/>
<input type="hidden" name="ussubject" value="<?php echo $ticketinfo->subject; ?>"/>
<input type="hidden" name="ustopicid" value="<?php echo $ticketinfo->topic_id; ?>"/>
<input type="hidden" name="ademail" value="<?php echo $os_admin_email; ?>"/>
<input type="hidden" name="adname" value="<?php echo $admin_fname; ?> <?php echo $admin_lname; ?>"/>
<input type="hidden" name="stitle" value="<?php echo $title_name; ?>"/>
<input type="hidden" name="sdirna" value="<?php echo $dirname; ?>"/>
<input type="hidden" name="adreply" value="<?php echo $adminreply; ?>"/>
<center><?php
$content = '';
$editor_id = 'message';
$settings = array( 'media_buttons' => false );
wp_editor( $content, $editor_id , $settings );?></center>
</td>
</tr>
<tr>
<td align="center">
<?php
	if($ticketinfo->status=='closed') {
	echo '<center><label><input type="checkbox" name="open_ticket_status" id="open_ticket_status" value="open">&nbsp;&nbsp;<font color=green>Reopen</font> Ticket On Reply</label></center>';
	} elseif ($ticketinfo->status=='open') {
	echo '<center><label><input type="checkbox" name="close_ticket_status" id="close_ticket_status" value="closed">&nbsp;&nbsp;<font color=red>Close</font> Ticket On Reply</label></center>';
	}
?>
</td>
</tr>
<tr>
<td align="center">
<center>
<input type="submit" name="ost-post-reply" value="Post Reply" class="button-primary" />&nbsp;&nbsp;
<input type="button" value="Cancel - Go Back" class="button-primary" onClick="history.go(-1)"/>
</center>
</form>
</td>
</tr>
</table>
</div><!--End wrap-->
<script language="javascript" src="<?php echo plugin_dir_url(__FILE__).'../js/fade.js';?>"></script>