<?php
/*
Template Name: message.php
*/
?>
<?php
$warning1 = "<div id='key4ce_msg_warning'>".__('You currently have the maximum amount allowed open:','key4ce-osticket-bridge')."($max_open_tickets)</div><div id='msg_warning_err'>".__('Visit your open tickets and see if any has been resolved, if so you can close any ticket(s) and submit a new one.','key4ce-osticket-bridge')."<br /><br /><a href='?service=list&status=open'>".__('View open tickets','key4ce-osticket-bridge')."</a></div>"; 
$warning2 = "<div id='key4ce_msg_warning'>".__('You are currently over the maximum amount allowed open:','key4ce-osticket-bridge')."($max_open_tickets)</div><div id='msg_warning_err'>".__('Visit your open tickets and see if any has been resolved, if so you can close any ticket(s) and submit a new one.','key4ce-osticket-bridge')."<br /><br /><a href='?service=list&status=open'>".__('View open tickets','key4ce-osticket-bridge')."</a></div>"; 
$offline = "<div class='clear' style='padding: 15px;'></div><div align='center'><p>".__('Thank you for your interest in contacting us.','key4ce-osticket-bridge')."</p><p><em>".__('Our system is currently offline for maintenance, please check back later.','key4ce-osticket-bridge')."</em></p></div>"; 
?>