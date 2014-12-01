<?php
/*
Template Name: ost-emailtemp
*/
?>
<?php require_once( WP_PLUGIN_DIR . '/key4ce-osticket-bridge/includes/udscript.php' ); ?>
<div class="key4ce_wrap">
<div class="key4ce_key4ce_headtitle">osTicket Email Templates</div>
<div style="clear: both"></div>
<?php require_once( WP_PLUGIN_DIR . '/key4ce-osticket-bridge/admin/header_nav.php' ); ?>
<div id="key4ce_tboxwh" class="key4ce_pg1">The "Email Templates" sent from site to client: new tickets confirmations, user post confirmations & admin post replies.<br />Note: Each input field will have a suggested default template, you can place any text & use the variables listed below.</div>
<div style="clear: both"></div>
<div style="padding-left:15px;padding-bottom:5px;padding-top:6px;"><b>$Variables You can use In Email &darr;</b></div>
<div id="key4ce_tboxyl" class="key4ce_pg1">
$username="User Name"&nbsp;|&nbsp;
$usermail="User Email"&nbsp;|&nbsp;
$ticketid="Ticket #"&nbsp;|&nbsp;
$ticketurl="Ticket Url"&nbsp;|&nbsp;
$ostitle="Support Title"<br>
$siteurl="Support Url"&nbsp;|&nbsp;
$dname="Landing Page"&nbsp;|&nbsp;
$user_message="Users Message"&nbsp;|&nbsp;
$admin_response="Staff Message"&nbsp;|&nbsp;
$signature="Staff/ Department Signature"&nbsp;|&nbsp;
$ussubject="Ticket subject"
</div>
<div style="clear: both"></div>
<?php 
require_once( WP_PLUGIN_DIR . '/key4ce-osticket-bridge/admin/db-settings.php' ); 
?>
<!--New Ticket Email Template-->
<div style="padding-left:15px;padding-bottom:5px;padding-top:10px;"><b>*New Ticket Email Template</b>&nbsp;&raquo;&nbsp;<a href="javascript:doMenu('main2');" id="xmain2">[Open]</a>&nbsp;&nbsp;We suggest using this template in the user confirmation email below.</div>
<div style="clear: both"></div>
<div id="main2" style="display: none;">
<div id="key4ce_tboxgr" class="key4ce_pg1">Hello $username,<br /><br />Your Ticket ID #$ticketid has been created successfully.<br />A representative will follow-up with you as soon as possible.<br /><br />&raquo;&raquo; $user_message<br /><br />You can view this ticket's progress online here:<br />$ticketurl<br /><br />If you wish to send additional comments or information regarding this issue, please don't open a new ticket. Simply login using the link above and update this ticket.<br /><br />Best Regards,<br /><?php echo $title_name; ?> - <?php bloginfo( 'name' ); ?></div>
</div>
<div style="clear: both"></div>
<div style="padding-left:15px;padding-bottom:2px;padding-top:10px;"><b>*New Ticket Email</b>&nbsp;&raquo;&nbsp;<a href="javascript:doMenu('main3');" id="xmain3">[Close]</a></div>
<div style="clear: both"></div>
<div id="main3" style="display: block;">
<form name="ost-new-ticket" action="admin.php?page=ost-emailtemp" method="post">
<textarea name="form_newticket" rows="18" id="emailtemp" value=""><?php echo $newticket; ?></textarea>
<div style="clear: both"></div>
<div align="center">
<input type="submit" name="ost-new-ticket" class="key4ce_button-primary" value="Save - New Ticket Email" />
</div>
</form>
</div>
<!--Admin Ticket Reply Email Template-->
<div style="padding-left:15px;padding-bottom:5px;padding-top:40px;"><b>*Admin Response Email Template</b>&nbsp;&raquo;&nbsp;<a href="javascript:doMenu('main4');" id="xmain4">[Open]</a>&nbsp;&nbsp;We suggest using this template in your post reply to user below.</div>
<div style="clear: both"></div>
<div id="main4" style="display: none;">
    <div id="key4ce_tboxgr" class="pg1">Hello $username,<br />A staff member has updated your Ticket ID #$ticketid with the following response:<br /><br />&raquo;&raquo; $admin_response<br /><br />We hope this response has sufficiently answered your questions. If you wish to send additional comments or information regarding this issue, please don't open a new ticket. Simply login to your account and update this ticket.<br /><br />View Ticket: $ticketurl<br /><br />Best Regards,<br /><?php echo $title_name; ?> - <?php bloginfo( 'name' ); ?><br /><br />$signature</div>
</div>
<div style="clear: both"></div>
<div style="padding-left:15px;padding-bottom:2px;padding-top:10px;"><b>*Admin Response Email</b>&nbsp;&raquo;&nbsp;<a href="javascript:doMenu('main5');" id="xmain5">[Close]</a></div>
<div style="clear: both"></div>
<div id="main5" style="display: block;">
<form name="ost-admin-reply" action="admin.php?page=ost-emailtemp" method="post">
<textarea name="form_admintreply" rows="16" id="emailtemp" value=""><?php echo $adminreply; ?></textarea>
<div style="clear: both"></div>
<div align="center">
<input type="submit" name="ost-admin-reply" class="key4ce_button-primary" value="Save - Admin Response Email" />
</div>
</form>
</div>

<!--Post Confirmation Email Template-->
<div style="padding-left:15px;padding-bottom:5px;padding-top:40px;"><b>*User Post Confirmation Email Template</b>&nbsp;&raquo;&nbsp;<a href="javascript:doMenu('main6');" id="xmain6">[Open]</a>&nbsp;&nbsp;We suggest using this template in the user confirmation email below.</div>
<div style="clear: both"></div>
<div id="main6" style="display: none;">
    <div id="key4ce_tboxgr" class="key4ce_pg1">Hello $username,<br /><br />We have received your post reply for: Ticket ID #$ticketid<br />A representative will follow-up with you as soon as possible, if needed.<br /><br />&raquo;&raquo; $user_message<br /><br />You can view this ticket's progress online here:<br />$ticketurl<br /><br />If you wish to send additional comments or information regarding this issue, please don't open a new ticket. Simply login using the link above and update this ticket.<br /><br />Best Regards,<br /><?php echo $title_name; ?> - <?php bloginfo( 'name' ); ?><br /><br />$signature</div>
</div>
<div style="clear: both"></div>
<div style="padding-left:15px;padding-bottom:2px;padding-top:10px;"><b>*User Post Confirmation Email</b>&nbsp;&raquo;&nbsp;<a href="javascript:doMenu('main7');" id="xmain7">[Close]</a></div>
<div style="clear: both"></div>
<div id="main7" style="display: block;">
<form name="ost-post-confirmed" action="admin.php?page=ost-emailtemp" method="post">
<textarea name="form_postconfirmed" rows="18" id="emailtemp" value=""><?php echo $postconfirm; ?></textarea>
<div style="clear: both"></div>
<div align="center">
<input type="submit" name="ost-post-confirmed" class="key4ce_button-primary" value="Save - User Post Confirmation Email" />
</div>
</form>
</div>
<div style="padding-top:40px;"></div>
<div style="clear: both"></div>
</div><!--End wrap-->