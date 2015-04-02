<?php
/*
Template Name: ticket_delete.php
*/
if(isset($_POST['delete']))
{
	$delete_ticket_list=$_POST['ticket_delete'];
	$i=0;
	foreach($delete_ticket_list as $delete_ticket)
	{				
		$ost_wpdb->query("DELETE FROM $ticket_table WHERE ticket_id =".$delete_ticket);
		$ost_wpdb->query("DELETE FROM $thread_table WHERE ticket_id =".$delete_ticket);	
		$ost_wpdb->query("DELETE FROM $ticket_cdata WHERE ticket_id =".$delete_ticket);
		$ost_wpdb->query("DELETE FROM $ost_ticket_attachment WHERE ticket_id =".$delete_ticket);				
		$i++;
	}		
	header("Location:admin.php?page=ost-tickets?records=" . $i);	
}
?>

