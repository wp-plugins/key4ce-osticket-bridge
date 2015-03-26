<?php
/* Template Name: new_ticket.php */

if($keyost_version==193)
{
$attachement_status=key4ce_getKeyValue('allow_attachments');
$max_user_file_uploads=key4ce_getKeyValue('max_user_file_uploads');
$max_file_size=key4ce_getKeyValue('max_file_size');
$fileextesnions=key4ce_getKeyValue('allowed_filetypes');
}
else
{
$fileconfig=key4ce_FileConfigValue();
$filedata=json_decode($fileconfig);
$attachement_status=$filedata->attachments;
$max_user_file_uploads=$filedata->max;
$max_file_size=$filedata->size;
$fileextesnions=$filedata->extensions;
}
$alowaray = explode(".",str_replace(' ', '',$fileextesnions));
$strplc = str_replace(".", "",str_replace(' ', '',$fileextesnions));
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
        var MaxFileInputs = <?php echo $max_user_file_uploads; ?>;
        $('#addNew').live('click', function() {
            if (i <= MaxFileInputs)
            {
                $('<p><span style="color:#000;"><?php echo __("Attachment", 'key4ce-osticket-bridge'); ?> ' + i + ':</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="file" id="p_new_' + i + '" name="file[]" onchange="return checkFile(this);"/>&nbsp;&nbsp;&nbsp;<a href="#" id="remNew"><?php echo __("Remove", 'key4ce-osticket-bridge'); ?></a>&nbsp;&nbsp;&nbsp;<span style="color: red;font-size: 11px;"><?php echo __("Max file upload size", 'key4ce-osticket-bridge'); ?> : <?php echo ($max_file_size * .0009765625) * .0009765625; ?>MB</span></p>').appendTo(addDiv);
                i++;
            }
            else
            {
                alert("<?php echo __("You have exceeds your file upload limit", 'key4ce-osticket-bridge'); ?>");
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
		
        if ((FileSize > <?php echo $max_file_size; ?>) || )
        {
            alert("<?php echo __("Please make sure your file is less than", 'key4ce-osticket-bridge'); ?> <?php echo ($max_file_size* .0009765625) * .0009765625; ?>MB.");
            document.getElementById(FileId).value = "";
            return false;
        }
		if(FileExts!="")
		{
			if (FileExts.indexOf(FileExt) < 0)
			{
				error = "<?php echo __("Please make sure your file extension should be :", 'key4ce-osticket-bridge'); ?> \n";
				error += FileExts;
				alert(error);
				document.getElementById(FileId).value = "";
				return false;
			}
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
        <p id="key4ce_msg_notice"><?php echo __('A new request has been created successfully!','key4ce-osticket-bridge'); ?></p>
        <p align="center">
            <br />
            <i><?php echo __('We are currently notifying the selected department staff...','key4ce-osticket-bridge'); ?></i>
        </p><br /><br />
        <center><script language="javascript" src="<?php echo plugin_dir_url(__FILE__) . '../js/timerbar.js'; ?>"></script></center>
        <br />
        <center><?php echo __('Thank you for contacting us!','key4ce-osticket-bridge'); ?></center>
    </p>
<?php
} else {
$user_id=$ost_wpdb->get_var("SELECT user_id FROM " . $keyost_prefix . "user_email WHERE `address` = '" . $current_user->user_email . "'");
    ?>
    <div id="key4ce_new_ticket">
        <div id="key4ce_new_ticket_text1"><?php echo __('Open a New Ticket','key4ce-osticket-bridge'); ?></div>
        <div style="clear: both"></div>
        <div id="key4ce_new_ticket_text2"><?php echo __('Please fill in the form below to open a new ticket. All fields mark with [<font color=red>*</font>] <em>Are Required!','key4ce-osticket-bridge'); ?></div>
        <div style="clear: both"></div>
        <form id="ticketForm" name="newticket" method="post" enctype="multipart/form-data" onsubmit="return validateFormNewTicket();">
            <input type="hidden" name="usid" value="<?php echo $user_id;  ?>"/>
            <input type="hidden" name="ademail" value="<?php echo $os_admin_email; ?>"/>
            <input type="hidden" name="stitle" value="<?php echo $title_name; ?>"/>
            <input type="hidden" name="sdirna" value="<?php echo $dirname; ?>"/>
            <input type="hidden" name="newtickettemp" value="<?php echo $newticket; ?>"/>
            <div id="key4ce_new_ticket_name"><?php echo __('Username','key4ce-osticket-bridge'); ?>:</div>
            <div id="key4ce_new_ticket_name_input"><input class="ost" id="cur-name" type="text" name="cur-name" readonly="true" size="30" value="<?php echo $current_user->user_login; ?>"></div>
            <div style="clear: both"></div>
            <div id="key4ce_new_ticket_email"><?php echo __('Your Email','key4ce-osticket-bridge'); ?>:</div>
            <div id="key4ce_new_ticket_email_input"><input class="ost" id="email" type="text" name="email" readonly="true" size="30" value="<?php echo $current_user->user_email; ?>"></div>
            <div style="clear: both"></div>
            <div id="key4ce_new_ticket_subject"><?php echo __('Subject','key4ce-osticket-bridge'); ?>:</div>
            <div id="key4ce_new_ticket_subject_input"><input class="ost" id="subject" type="text" name="subject" size="35"/><font class="error">&nbsp;*</font></div>
            <div style="clear: both"></div>
            <div id="key4ce_new_ticket_catagory"><?php echo __('Catagories','key4ce-osticket-bridge'); ?>:</div>
            <div id="key4ce_new_ticket_catagory_input">
                <select id="deptId" name="deptId">
                    <option value="" selected="selected"><?php echo __('Select a Category','key4ce-osticket-bridge'); ?></option>
                    <?php
                    foreach ($dept_opt as $dept) {
                        echo '<option value="' . $dept->dept_id . '">' . $dept->dept_name . '</option>';
                    }
                    ?>
                </select><font class="key4ce_error">&nbsp;*</font></div>
            <div style="clear: both"></div>
            <div id="key4ce_new_ticket_priority"><?php echo __('Priority:','key4ce-osticket-bridge'); ?></div>
            <div id="key4ce_new_ticket_priority_input"><select id="priority" name="priorityId">
                    <option value="" selected="selected"><?php echo __('Select a Priority','key4ce-osticket-bridge'); ?></option>
                    <?php
                    foreach ($pri_opt as $priority) {
                        echo '<option value="' . $priority->priority_id . '">' . $priority->priority_desc . '</option>';
                    }
                    ?>
                </select><font class="key4ce_error">&nbsp;*</font></div>
            <div style="clear: both"></div>
    
    <table class="key4ce_welcome key4ce_nobd" align="center" width="95%" cellpadding="3" cellspacing="3" border="0">
        <tr>
            <td class="key4ce_nobd" align="center"><div align="center" style="padding-bottom: 5px;"><?php echo __('To best assist you, please be specific and detailed in your message','key4ce-osticket-bridge'); ?><font class="error">&nbsp;*</font></div></td>
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
if ($attachement_status==1 || $attachement_status==true) {
	if(key4ce_getPluginValue('Attachments on the filesystem')==1)
	{
        ?>
            <tr><td>
                    <div id="addinput">
                        <p>
                            <span style="color:#000;"><?php echo __('Attachment 1:','key4ce-osticket-bridge'); ?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="file" id="p_new" name="file[]" onchange="return checkFile(this);"/>&nbsp;&nbsp;&nbsp;<a href="#" id="addNew"><?php echo __('Add','key4ce-osticket-bridge'); ?></a>&nbsp;&nbsp;&nbsp;<span style="color: red;font-size: 11px;"><?php echo __('Max file upload size :','key4ce-osticket-bridge'); ?><?php echo ($max_file_size * .0009765625) * .0009765625; ?>MB</span>
                        </p>
                    </div>
                </td></tr>
    <?php } else
	{
	?>
	 <tr><td><?php echo __('Attachments on the Filesystem plugin can be downloaded here:','key4ce-osticket-bridge'); ?><a href="http://osticket.com/download/go?dl=plugin%2Fstorage-fs.phar" title="Attachement Filesystem Plugin" target="_blank"><?php echo __('Attachement Filesystem Plugin','key4ce-osticket-bridge'); ?></a></td></tr>
	<?php
	}
	}
	?>
        <tr>
            <td class="key4ce_nobd" align="center">
                <p align="center" style="padding-top: 5px;"><input type="submit" name="create-ticket" value="<?php echo __('Create Ticket','key4ce-osticket-bridge'); ?>">
                    &nbsp;&nbsp;<input type="reset" value="<?php echo __('Reset','key4ce-osticket-bridge'); ?>"></p>
            </td>
        </tr>
    </table></form>
    </div>
	
<?php } ?>
<div class="key4ce_clear" style="padding: 10px;"></div>
