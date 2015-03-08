<?php
if($keyost_version=="194")
{
	$ticket_count_open=$ost_wpdb->get_var("SELECT COUNT(*) FROM $ticket_table INNER JOIN $ost_ticket_status ON $ost_ticket_status.id=$ticket_table.status_id WHERE user_id='$user_id' and $ost_ticket_status.state='open'"); 
    $ticket_count_closed=$ost_wpdb->get_var("SELECT COUNT(*) FROM $ticket_table INNER JOIN $ost_ticket_status ON $ost_ticket_status.id=$ticket_table.status_id WHERE user_id='$user_id' and $ost_ticket_status.state='closed'"); 
}
else	
{
	$ticket_count_open=$ost_wpdb->get_var("SELECT COUNT(*) FROM $ticket_table WHERE user_id='$user_id' and status='open'"); 
    $ticket_count_closed=$ost_wpdb->get_var("SELECT COUNT(*) FROM $ticket_table WHERE user_id='$user_id' and status='closed'");
}
$status="";
$open="";
$closed="";
$service="";
if(isset($_GET['service']))
	$service=$_GET['service'];
if(isset($_REQUEST['page_id']))
{
	$service_list=get_permalink()."&service=list";
	$service_new=get_permalink()."&service=new";
}
else
{
	$service_list=get_permalink()."?service=list";
	$service_new=get_permalink()."?service=new";
}
	
	if(isset($_REQUEST['status']))
		$status=$_REQUEST['status'];
	
	if($status=='closed')
		$closed='selected';
	else if($status=='open')
		$open='selected';
	else if($ticket_count_open > 0)
		$open='selected';
	else if($ticket_count_closed > 0)
		$closed='selected';
    echo "<div style=\"display: table; width: 100%;\">";
	echo "<div id='key4ce_search_ticket' style='display: table-row;'>"; 
	echo "<div id='key4ce_search_box' style='display: table-cell;'>";
    if(isset($service) && $service=='new' || $service=='view') { 
 	echo "<a class=\"key4ce_blue key4ce_but\" href=".$service_list.">". __("View Tickets", 'key4ce-osticket-bridge')."</a>";
    } else { 
   	echo "<a class=\"key4ce_blue key4ce_but\" href=".$service_new.">". __("Create Ticket", 'key4ce-osticket-bridge')."</a>"; 
    }
	echo "</div>"; 
    echo "<form name='search' method='POST' enctype='multipart/form-data' onsubmit='return validateFormSearch()'>";
	echo "<div id='key4ce_search_opcl' table-cell;>
	<select onchange='this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);'>	
	<option value=$service_list&status=open $open>".__('Open / Answered','key4ce-osticket-bridge')."({$ticket_count_open})</option>
	<option value=$service_list&status=closed $closed>".__('Closed','key4ce-osticket-bridge')."({$ticket_count_closed})</option>
	</select>&nbsp;&nbsp;
	<input type='hidden' name='service' value='list'>
	<input type='hidden' name='afterticket' id='afterticket' value='$service_list'>
	<input class='key4ce_ost' type='text' placeholder=".__('Search...','key4ce-osticket-bridge')." size='20' name='tq' id='tq' value=". @$_REQUEST['tq'].">&nbsp;&nbsp;
	<input type='submit' style='margin-left: -10px;' name='search' value=".__('Go', 'key4ce-osticket-bridge').">";
	echo "</form></div>"; 
	echo '<div style="clear: both"></div>'; 
	echo '</div>'; 
    echo '</div><hr style="border-color:#D5E5EE; border-width: 3px; height: 3px;">';
    wp_enqueue_script('ost-bridge-validate',plugins_url('../js/validate.js', __FILE__));

?>

