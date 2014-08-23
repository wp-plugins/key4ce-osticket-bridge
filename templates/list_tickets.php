<?php
/* Template Name: list_tickets.php */
?>
<?php
if(@$list_opt) { 
?>
<form name="osticket" id="osticket" method="post">
<div class="cofigmenu">
<div id="ticket_menu">
<div id="ticket_menu1">Ticket #</div>
<div id="ticket_menu2">Subject</div>
<div id="ticket_menu3">Status</div>
<div id="ticket_menu4">Department</div>
<div id="ticket_menu5">Date</div>
</div>
<?php
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
	if(isset($_REQUEST['page_id']))
	{
		$ticket_view=get_permalink()."&service=view&ticket=".$list->number;
		$ticket_tr="&service=view&ticket=".$list->number;
	}
	else
	{
		$ticket_view=get_permalink()."?service=view&ticket=".$list->number;
		$ticket_tr="?service=view&ticket=".$list->number;
	}
	@$sub_str=Format::stripslashes($list->subject); 			
	echo "<div id='ticket_list' onclick=\"location.href='$ticket_view';\">"; 
	echo "<div id='ticket_list1'><a href=$ticket_view>".$list->number."</a></div>"; 
	echo "<div id='ticket_list2'>".truncate($sub_str,60,'...')."</div><div id='ticket_list3'>"; 
	if($list->status=='closed') { 
	echo '<font color=red>Closed</font>'; 
	} 
	elseif ($list->status=='open' && $list->isanswered=='0') { 
	echo '<font color=green>Open</font>'; 
    }
	elseif ($list->status=='open' && $list->isanswered=='1') { 
	echo '<font color=orange>Answered</font>'; 
	} 
	echo "</div><div id='ticket_list4'>".$list->dept_name."</div>"; 
    if ($list->updated=='0000-00-00 00:00:00') {
		$input_str  = "".$list->created.""; }
		else {
   	$input_str  = "".$list->updated.""; }
   	echo "<div id='ticket_list5'>"; 
   	echo substr($input_str,0,10); 
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