<?php
/* Template Name: new_ticket.php */
$alowaray = explode(".",str_replace(' ', '',getKeyValue('allowed_filetypes')));
$strplc = str_replace(".", "",str_replace(' ', '',getKeyValue('allowed_filetypes')));
$allowedExts = explode(",", $strplc);
function add_quotes($str) {
    return sprintf("'%s'", $str);
}

$extimp = implode(',', array_map('add_quotes', $allowedExts));
$finalary = "'" . $extimp . "'";
?>
<script language="javascript" src="<?php echo plugin_dir_url(__FILE__) . '../js/jquery_1_7_2.js'; ?>"></script>
<script type="text/javascript">
    $(function() {
        var addDiv = $('#addinput');
        var i = $('#addinput p').size() + 1;
        var MaxFileInputs = <?php echo getKeyValue('max_user_file_uploads'); ?>;
        $('#addNew').live('click', function() {
            if (i <= MaxFileInputs)
            {
                $('<p><span style="color:#000;">Attachment ' + i + ':</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="file" id="p_new_' + i + '" name="file[]" onchange="return checkFile(this);"/>&nbsp;&nbsp;&nbsp;<a href="#" id="remNew">Remove</a>&nbsp;&nbsp;&nbsp;<span style="color: red;font-size: 11px;">Max file upload size : <?php echo (getKeyValue('max_file_size') * .0009765625) * .0009765625; ?>MB</span></p>').appendTo(addDiv);
                i++;
            }
            else
            {
                alert("You have exceeds your file upload limit");
                return false;
            }
            return false;
        });

        $('#remNew').live('click', function() {
            if (i > 2) {
                $(this).parents('p').remove();
                i--;
            }
            return false;
        });
    });
</script>
<script type="text/javascript">
    function checkFile(fieldObj)
    {

        var FileName = fieldObj.value;
        var FileId = fieldObj.id;
        var FileExt = FileName.substr(FileName.lastIndexOf('.') + 1);
        var FileSize = fieldObj.files[0].size;
        var FileSizeMB = (FileSize / 10485760).toFixed(2);
        var FileExts = new Array(<?php echo $extimp; ?>);
        if ((FileSize > <?php echo getKeyValue('max_file_size'); ?>))
        {
            alert("Please make sure your file is less than <?php echo (getKeyValue('max_file_size') * .0009765625) * .0009765625; ?>MB.");
            document.getElementById(FileId).value = "";
            return false;
        }
        if (FileExts.indexOf(FileExt) < 0)
        {
            error = "Please make sure your file extension should be : \n";
            error += FileExts;
            alert(error);
            document.getElementById(FileId).value = "";
            return false;
        }
        return true;
    }
</script>
<style>
    #key4ce_wp-message-wrap{border:2px solid #CCCCCC;border-radius: 5px;padding: 5px;width: 75%;}
    #key4ce_message-html{height: 25px;}
    #key4ce_message-tmce{height: 25px;}
</style>
<div id="key4ce_thContainer">
    <?php
    if (isset($_REQUEST['create-ticket'])) {
        ?>

        <div class="key4ce_clear" style="padding: 5px;"></div>
        <p id="key4ce_msg_notice">A new request has been created successfully!</p>
        <p align="center">
            <br />
            <i>We are currently notifying the selected department staff...</i>
        </p><br /><br />
        <center><script language="javascript" src="<?php echo plugin_dir_url(__FILE__) . '../js/timerbar.js'; ?>"></script></center>
        <br />
        <center>Thank you for contacting us!</center>
    </p>
<?php
} else {
$user_id=$ost_wpdb->get_var("SELECT user_id FROM " . $keyost_prefix . "user_email WHERE `address` = '" . $current_user->user_email . "'");
    ?>
    <div id="key4ce_new_ticket">
        <div id="key4ce_new_ticket_text1">Open a New Ticket</div>
        <div style="clear: both"></div>
        <div id="key4ce_new_ticket_text2">Please fill in the form below to open a new ticket. All fields mark with [<font color=red>*</font>] <em>Are Required!</em></div>
        <div style="clear: both"></div>
        <form id="ticketForm" name="newticket" method="post" enctype="multipart/form-data" onsubmit="return validateFormNewTicket();">
            <input type="hidden" name="usid" value="<?php echo $user_id;  ?>"/>
            <input type="hidden" name="ademail" value="<?php echo $os_admin_email; ?>"/>
            <input type="hidden" name="stitle" value="<?php echo $title_name; ?>"/>
            <input type="hidden" name="sdirna" value="<?php echo $dirname; ?>"/>
            <input type="hidden" name="newtickettemp" value="<?php echo $newticket; ?>"/>
            <div id="key4ce_new_ticket_name">Username:</div>
            <div id="key4ce_new_ticket_name_input"><input class="ost" id="cur-name" type="text" name="cur-name" readonly="true" size="30" value="<?php echo $current_user->user_login; ?>"></div>
            <div style="clear: both"></div>
            <div id="key4ce_new_ticket_email">Your Email:</div>
            <div id="key4ce_new_ticket_email_input"><input class="ost" id="email" type="text" name="email" readonly="true" size="30" value="<?php echo $current_user->user_email; ?>"></div>
            <div style="clear: both"></div>
            <div id="key4ce_new_ticket_subject">Subject:</div>
            <div id="key4ce_new_ticket_subject_input"><input class="ost" id="subject" type="text" name="subject" size="35"/><font class="error">&nbsp;*</font></div>
            <div style="clear: both"></div>
            <div id="key4ce_new_ticket_catagory">Catagories:</div>
            <div id="key4ce_new_ticket_catagory_input">
                <select id="deptId" name="deptId">
                    <option value="" selected="selected"> Select a Category </option>
                    <?php
                    foreach ($dept_opt as $dept) {
                        echo '<option value="' . $dept->dept_id . '">' . $dept->dept_name . '</option>';
                    }
                    ?>
                </select><font class="key4ce_error">&nbsp;*</font></div>
            <div style="clear: both"></div>
            <div id="key4ce_new_ticket_priority">Priority:</div>
            <div id="key4ce_new_ticket_priority_input"><select id="priority" name="priorityId">
                    <option value="" selected="selected"> Select a Priority </option>
                    <?php
                    foreach ($pri_opt as $priority) {
                        echo '<option value="' . $priority->priority_id . '">' . $priority->priority_desc . '</option>';
                    }
                    ?>
                </select><font class="key4ce_error">&nbsp;*</font></div>
            <div style="clear: both"></div>
    
    <table class="key4ce_welcome key4ce_nobd" align="center" width="95%" cellpadding="3" cellspacing="3" border="0">
        <tr>
            <td class="key4ce_nobd" align="center"><div align="center" style="padding-bottom: 5px;">To best assist you, please be specific and detailed in your message<font class="error">&nbsp;*</font></div></td>
        </tr>

        <tr>
            <td class="key4ce_nobd" align="center">
        <center> <?php
            $content = '';
            $editor_id = 'message';
            $settings = array('media_buttons' => false);
            wp_editor($content, $editor_id, $settings);
            ?> </center>
        <div class="key4ce_clear" style="padding: 5px;"></div></td>
        </tr>
    <?php 
if (getKeyValue('allow_attachments') == 1) {
	if(getPluginValue('Attachments on the filesystem')==1)
	{
        ?>
            <tr><td>
                    <div id="addinput">
                        <p>
                            <span style="color:#000;">Attachment 1:</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="file" id="p_new" name="file[]" onchange="return checkFile(this);"/>&nbsp;&nbsp;&nbsp;<a href="#" id="addNew">Add</a>&nbsp;&nbsp;&nbsp;<span style="color: red;font-size: 11px;">Max file upload size : <?php echo (getKeyValue('max_file_size') * .0009765625) * .0009765625; ?>MB</span>
                        </p>
                    </div>
                </td></tr>
    <?php } else
	{
	?>
	 <tr><td>Attachments on the Filesystem plugin can be downloaded here: <a href="http://osticket.com/download/go?dl=plugin%2Fstorage-fs.phar" title="Attachement Filesystem Plugin" target="_blank">Attachement Filesystem Plugin</a></td></tr>
	<?php
	}
	}
	?>
        <tr>
            <td class="key4ce_nobd" align="center">
                <p align="center" style="padding-top: 5px;"><input type="submit" name="create-ticket" value="Create Ticket">
                    &nbsp;&nbsp;<input type="reset" value="Reset"></p>
            </td>
        </tr>
    </table></form>
    </div>
<?php } ?>
<div class="key4ce_clear" style="padding: 10px;"></div>