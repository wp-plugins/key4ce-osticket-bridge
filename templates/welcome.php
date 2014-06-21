<?php
/*
Template Name: welcome.php
*/
?>
<table class="welcome nobd">
<tr>
<td class="nobd" width="10%"><div align="center"><img src="<?php echo plugin_dir_url(__FILE__).'../images/new_ticket_icon.png'; ?>" width="64" height="64" alt="Open A New Ticket"></div></td>
<td class="nobd" width="40%"><div class="ticket">Open A New Ticket</div><span class="par1">All site inquiries, contact us.</span></td>
<td class="nobd" width="10%"><div align="center"><img src="<?php echo plugin_dir_url(__FILE__).'../images/check_status_icon.png'; ?>" width="64" height="64" alt="Check Ticket Status"></div></td>
<td class="nobd" width="40%"><div class="ticket">Check Ticket Status</div><span class="par1">All requests, open or closed.</span></td>
</tr>
</table>
<table class="welcome nobd">
<tr>
<td class="nobd" width="50%"><div class="par1">Please provide as much detail as possible so we can best assist you. To update a previously submitted ticket, use our Check Ticket Status.</div></td>
<td class="nobd" width="50%"><div class="par1">For your convenance, we provide archives and history of all your current and past submitted ticket requests, complete with all responses.</div></td>
</tr>
</table>
<table class="welcome nobd">
<tr>
<td class="nobd" width="50%"><div align="center"><a class="green but" href="?service=new">Open A New Ticket</a></div></td>
<td class="nobd" width="50%"><div align="center"><a class="blue but" href="?service=list">Check Ticket Status</a></div></td>
</tr>
</table>