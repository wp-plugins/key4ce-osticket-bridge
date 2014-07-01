<?php
/*
Template Name: message.php
*/
?>
<?php 
$warning1 = "<div id='msg_warning'>You currently have the maximum amount allowed open: ($max_open_tickets)</div><div id='msg_warning_err'>Visit your open tickets and see if any has been resolved, if so you can close any ticket(s) and submit a new one.<br /><br /><a href='?service=list&status=open'>View open tickets</a></div>"; 

$warning2 = "<div id='msg_warning'>You are currently over the maximum amount allowed open: ($max_open_tickets)</div><div id='msg_warning_err'>Visit your open tickets and see if any has been resolved, if so you can close any ticket(s) and submit a new one.<br /><br /><a href='?service=list&status=open'>View open tickets</a></div>"; 

$offline = "<div class='clear' style='padding: 15px;'></div><div align='center'><p>Thank you for your interest in contacting us.</p><p><em>Our system is currently offline for maintenance, please check back later.</em></p></div>"; 

?>