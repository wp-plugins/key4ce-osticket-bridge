<?php
require_once( WP_PLUGIN_DIR . '/key4ce-osticket-bridge/admin/db-settings.php' );
require_once( WP_PLUGIN_DIR . '/key4ce-osticket-bridge/includes/functions.php' ); 
if(isset($_POST['delete']))
{	
	$delete_ticket_list=$_POST['tickets'];	
	$i=0;
	foreach($delete_ticket_list as $delete_ticket)
	{				
		$ost_wpdb->query("DELETE FROM $ticket_table WHERE ticket_id =".$delete_ticket);
		$ost_wpdb->query("DELETE FROM $thread_table WHERE ticket_id =".$delete_ticket);	
		$ost_wpdb->query("DELETE FROM $ticket_cdata WHERE ticket_id =".$delete_ticket);
		$file_id = $ost_wpdb->get_var("SELECT file_id from $ost_ticket_attachment WHERE ticket_id = '$delete_ticket'");	
		$ost_wpdb->query("DELETE FROM $ost_file WHERE id =".$file_id);
		$ost_wpdb->query("DELETE FROM $ost_ticket_attachment WHERE ticket_id =".$delete_ticket);				
		$i++;
	}
	echo "<div style=' color: red;font-size: 15px;font-weight: bold;margin-top: 20px;text-align: center;'>$i record(s) has been deleted successfully</div>";
	echo "<script>window.location.href=location.href;</script>";	
}
if(isset($_POST['close']))
{		
	$close_ticket_list=$_POST['tickets'];
	$i=0;
	foreach($close_ticket_list as $close_ticket)
	{				
		if($keyost_version==194)
			$ost_wpdb->update($ticket_table, array('status_id'=>'3'), array('ticket_id'=>$close_ticket), array('%s'));
		else
			$ost_wpdb->update($ticket_table, array('status'=>'closed'), array('ticket_id'=>$close_ticket), array('%s'));
		$i++;
	}
	echo "<div style=' color: red;font-size: 15px;font-weight: bold;margin-top: 20px;text-align: center;'>$i record(s) has been closed successfully</div>";
	echo "<script>window.location.href=location.href;</script>";	
}
if(isset($_POST['reopen']))
{			
	$reopen_ticket_list=$_POST['tickets'];
	$i=0;
	foreach($reopen_ticket_list as $reopen_ticket)
	{				
		if($keyost_version==194)
			$ost_wpdb->update($ticket_table, array('status_id'=>'1'), array('ticket_id'=>$reopen_ticket), array('%s'));
		else	
			$ost_wpdb->update($ticket_table, array('status'=>'open'), array('ticket_id'=>$reopen_ticket), array('%s'));
		$i++;
	}
	echo "<div style=' color: red;font-size: 15px;font-weight: bold;margin-top: 20px;text-align: center;'>$i record(s) has been re-opened successfully</div>";
	echo "<script>window.location.href=location.href;</script>";	
}	
?>
<script type="text/javascript">
function checkAll(ele) {
     var checkboxes = document.getElementsByTagName('input');
     if (ele.checked) {
         for (var i = 0; i < checkboxes.length; i++) {
             if (checkboxes[i].type == 'checkbox') {
                 checkboxes[i].checked = true;
             }
         }
     } else {
         for (var i = 0; i < checkboxes.length; i++) {
             console.log(i)
             if (checkboxes[i].type == 'checkbox') {
                 checkboxes[i].checked = false;
             }
         }
     }
 }
</script>
<form name="ticketview" id="ticketview" method="post" onSubmit="if(!confirm('Are you sure you want to continue?')){return false;}">
<div class="key4ce_wrap">
<div class="key4ce_headtitle">Support/Request List</div>
<div style="clear: both"></div>
<?php require_once( WP_PLUGIN_DIR . '/key4ce-osticket-bridge/admin/header_nav_ticket.php' ); ?>
	<div style="clear: both"></div>
<div align="center" style="padding-top:20px;"></div>
<div style="clear: both"></div>
<div class="key4ce_cofigmenu">
<div id="key4ce_ticket_menu">
<div id="key4ce_ticket_menu0" style="width: 16px;"><input type="checkbox"  onchange="checkAll(this)" name="chk[]"></div>
<div id="key4ce_ticket_menu1">Ticket #</div>
<div id="key4ce_ticket_menu2">Subject</div>
<div id="key4ce_ticket_menu3">Priority</div>
<div id="key4ce_ticket_menu4">Department</div>
<div id="key4ce_ticket_menu5">Date</div>
</div>
<?php
if($list_opt)
{
	function ezDate($d) { 
        $ts = time() - strtotime(str_replace("-","/",$d));
        if($ts>31536000) $val = round($ts/31536000,0).' year'; 
        else if($ts>2419200) $val = round($ts/2419200,0).' month'; 
        else if($ts>604800) $val = round($ts/604800,0).' week'; 
        else if($ts>86400) $val = round($ts/86400,0).' day'; 
        else if($ts>3600) $val = round($ts/3600,0).' hour'; 
        else if($ts>60) $val = round($ts/60,0).' minute'; 
        else $val = $ts.' second';
        if($val>1) $val .= 's'; 
        return $val; 
	}
	foreach($list_opt as $list)
	{
	if($list->updated=="0000-00-00 00:00:00")
	{
	$list_updated="-";
	}
	else{
	$list_updated=ucwords(ezDate($list->updated)).' Ago';
	}
    if ($list->subject=="") {
        @$sub_str=Format::stripslashes('Ticket subject not found');	
    } else {
 	@$sub_str=Format::stripslashes($list->subject); }			
	echo "<div id='key4ce_ticket_list0'><input type='checkbox' name='tickets[]' value='".$list->ticket_id."'></div>";
	echo "<div id='key4ce_ticket_list' onclick=\"location.href='admin.php?page=ost-tickets&service=view&ticket=".$list->number."';\">";
	echo "<div id='key4ce_ticket_list1'><a href='admin.php?page=ost-tickets&service=view&ticket=".$list->number."'>".$list->number."</a></div>";
	echo "<div id='key4ce_ticket_list2'>".truncate($sub_str,60,'...')."</div>
	<div id='key4ce_ticket_list3'>";
	if($list->priority_id=='4') {
	echo '<div class="key4ce_ticketPriority" style="background-color: Red;"><font color=white>Emergency</font></div>';
	} 
	elseif ($list->priority_id=='3') {
	echo '<div class="key4ce_ticketPriority" style="background-color: Orange;"><font color=white>High</font></div>';
	}
	elseif ($list->priority_id=='2') {
	echo '<div class="key4ce_ticketPriority" style="background-color: Green;"><font color=white>Normal</font></div>';
	}
    elseif ($list->priority_id=='') {
	echo '<div class="key4ce_ticketPriority" style="background-color: Green;"><font color=white>Normal</font></div>';
	}
	elseif ($list->priority_id=='1') {
	echo '<div class="key4ce_ticketPriority" style="background-color: Black;"><font color=white>Low</font></div>';
	}
	echo "</div><div id='key4ce_ticket_list4'>".$list->dept_name."</div>";

	if ($list->updated=='0000-00-00 00:00:00') {
		$date_str  = "".$list->created.""; }
		else {
   	$date_str  = "".$list->updated.""; }
   	echo "<div id='key4ce_ticket_list5'>";
   	echo truncate($date_str,10,'');
   	echo "</div>";
	echo "<div style='clear: both; display: table-cell;'></div></div>";
	} }
	else
	{
	echo '</div><div style="display: table; width: 100%;"><div align="center" id="key4ce_no_tics" style="margin-top: 25px; text-align: center; font-size: 12pt; width: 100%; display:table-cell; float: left;"> <strong> No Records Found. </strong></div>';
	}
?>
</div>
<div align="center" style="padding-top:15px;"></div>
<div style="clear: both"></div>
<?php if(count($list_opt) > 0) { ?>
<div><input type="submit" name="delete" value="Delete">
<?php if(@$_REQUEST['status']=="open" || @$_REQUEST['status']=="answered") { ?>
<input type="submit" name="close" value="Close">
<?php } else if (@$_REQUEST['status']=="all") {?>
<input type="submit" name="close" value="Close">
<input type="submit" name="reopen" value="Reopen">
<?php } else if (@$_REQUEST['status']=="closed") { ?>
<input type="submit" name="reopen" value="Reopen">
<?php  } else {?>
<input type="submit" name="close" value="Close">
<?php } ?>
</div>
<?php } ?>
<?php require_once( WP_PLUGIN_DIR . '/key4ce-osticket-bridge/includes/pagination.php' ); ?>
</div><!--End wrap-->
</form>
