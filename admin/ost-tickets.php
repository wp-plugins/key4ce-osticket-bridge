<?php
require_once( WP_PLUGIN_DIR . '/key4ce-osticket-bridge/admin/db-settings.php' );
require_once( WP_PLUGIN_DIR . '/key4ce-osticket-bridge/includes/functions.php' ); 
?>
<div class="wrap">
<div class="headtitle">Support/Request List</div>
<div style="clear: both"></div>
<?php require_once( WP_PLUGIN_DIR . '/key4ce-osticket-bridge/admin/header_nav_ticket.php' ); ?>
	<div style="clear: both"></div>
<div align="center" style="padding-top:20px;"></div>
<div style="clear: both"></div>
<form name="ticketview" id="ticketview" method="post">
<div class="cofigmenu">
<div id="ticket_menu">
<div id="ticket_menu1">Ticket #</div>
<div id="ticket_menu2">Subject</div>
<div id="ticket_menu3">Priority</div>
<div id="ticket_menu4">Department</div>
<div id="ticket_menu5">Date</div>
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
	echo "<div id='ticket_list' onclick=\"location.href='admin.php?page=ost-tickets&service=view&ticket=".$list->number."';\">";
	echo "<div id='ticket_list1'><a href='admin.php?page=ost-tickets&service=view&ticket=".$list->number."'>".$list->number."</a></div>";
	echo "<div id='ticket_list2'>".truncate($sub_str,60,'...')."</div>
	<div id='ticket_list3'>";
	if($list->priority_id=='4') {
	echo '<div class="ticketPriority" style="background-color: Red;"><font color=white>Emergency</font></div>';
	} 
	elseif ($list->priority_id=='3') {
	echo '<div class="ticketPriority" style="background-color: Orange;"><font color=white>High</font></div>';
	}
	elseif ($list->priority_id=='2') {
	echo '<div class="ticketPriority" style="background-color: Green;"><font color=white>Normal</font></div>';
	}
    elseif ($list->priority_id=='') {
	echo '<div class="ticketPriority" style="background-color: Green;"><font color=white>Normal</font></div>';
	}
	elseif ($list->priority_id=='1') {
	echo '<div class="ticketPriority" style="background-color: Black;"><font color=white>Low</font></div>';
	}
	echo "</div><div id='ticket_list4'>".$list->dept_name."</div>";

	if ($list->updated=='0000-00-00 00:00:00') {
		$date_str  = "".$list->created.""; }
		else {
   	$date_str  = "".$list->updated.""; }
   	echo "<div id='ticket_list5'>";
   	echo truncate($date_str,10,'');
   	echo "</div>";
	echo "<div style='clear: both; display: table-cell;'></div></div>";
	} }
	else
	{
	echo '</div><div style="display: table; width: 100%;"><div align="center" id="no_tics" style="margin-top: 25px; text-align: center; font-size: 12pt; width: 100%; display:table-cell; float: left;"> <strong> No Records Found. </strong></div>';
	}
?>
</div>
</form>
<div align="center" style="padding-top:15px;"></div>
<div style="clear: both"></div>
<?php require_once( WP_PLUGIN_DIR . '/key4ce-osticket-bridge/includes/pagination.php' ); ?>
</div><!--End wrap-->
