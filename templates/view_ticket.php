<?php
/* Template Name: view_ticket.php */
global $current_user;
get_currentuserinfo();
if ($ticketinfo->address == $current_user->user_email) {
    $alowaray = explode(".",str_replace(' ', '',key4ce_getKeyValue('allowed_filetypes')));
$strplc = str_replace(".", "",str_replace(' ', '',key4ce_getKeyValue('allowed_filetypes')));
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
            var MaxFileInputs = <?php echo key4ce_getKeyValue('max_user_file_uploads'); ?>;
            $('#addNew').live('click', function() {
                if (i <= MaxFileInputs)
                {
                    $('<p><span style="color:#000;"><?php echo  __("Attachment", 'key4ce-osticket-bridge'); ?> ' + i + ':</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="file" id="p_new_' + i + '" name="file[]" onchange="return checkFile(this);"/>&nbsp;&nbsp;&nbsp;<a href="#" id="remNew"><?php echo  __("Remove", 'key4ce-osticket-bridge'); ?></a>&nbsp;&nbsp;&nbsp;<span style="color: red;font-size: 11px;"><?php echo  __("Max file upload size :", 'key4ce-osticket-bridge'); ?><?php echo (key4ce_getKeyValue('max_file_size') * .0009765625) * .0009765625; ?>MB</span></p>').appendTo(addDiv);
                    i++;
                }
                else
                {
                    alert("<?php echo  __("You have exceeds your file upload limit", 'key4ce-osticket-bridge'); ?>");
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
            if ((FileSize > <?php echo key4ce_getKeyValue('max_file_size'); ?>))
            {
                alert("<?php echo  __("Please make sure your file is less than", 'key4ce-osticket-bridge'); ?><?php echo (key4ce_getKeyValue('max_file_size') * .0009765625) * .0009765625; ?>MB.");
                document.getElementById(FileId).value = "";
                return false;
            }
            if (FileExts.indexOf(FileExt) < 0)
            {
                error = "<?php echo  __("Please make sure your file extension should be :", 'key4ce-osticket-bridge'); ?> \n";
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
    <div id="key4ce_ticket_view">
        <div id="key4ce_tic_number"><?php echo  __("Ticket ID #", 'key4ce-osticket-bridge'); ?><?php echo $ticketinfo->number; ?></div>
        <div id="key4ce_tic_icon"><a href="?service=view&ticket=<?php echo $ticketinfo->number; ?>" title="Reload"><span class="Icon refresh"></span></a></div>
        <div style="clear: both"></div>
    </div>
    <div id="key4ce_tic_info_box">
        <div id="key4ce_tic_stat"><?php echo __("Ticket Status", 'key4ce-osticket-bridge'); ?>:</div>
        <div id="key4ce_tic_stat_info"><?php
            if ($ticketinfo->status == 'closed') {
                echo '<font color=red>'.__("Closed", 'key4ce-osticket-bridge').'</font>';
            } elseif ($ticketinfo->status == 'open' && $ticketinfo->isanswered == '0') {
                echo '<font color=green>'.__("Open", 'key4ce-osticket-bridge').'</font>';
            } elseif ($ticketinfo->status == 'open' && $ticketinfo->isanswered == '1') {
                echo '<font color=orange>'.__("Answered", 'key4ce-osticket-bridge').'</font>';
            }
            ?>
        </div>
        <div id="key4ce_tic_name"><?php echo __("Name", 'key4ce-osticket-bridge'); ?>:</div>
        <div id="key4ce_tic_name_user"><?php echo $ticketinfo->name; ?></div>
        <div style="clear: both"></div>
        <div id="key4ce_tic_dept"><?php echo __("Department", 'key4ce-osticket-bridge'); ?>:</div>
        <div id="key4ce_tic_dept_info"><?php echo $ticketinfo->dept_name; ?></div>
        <div id="key4ce_tic_email"><?php echo __("Email", 'key4ce-osticket-bridge'); ?>:</div>
        <div id="key4ce_tic_email_user">
            <?php echo $ticketinfo->address; ?>
        </div>
        <div style="clear: both">
        </div>
        <div id="key4ce_tic_created"><?php echo __("Create Date", 'key4ce-osticket-bridge'); ?>:</div>
        <div id="key4ce_tic_created_date"><?php echo $ticketinfo->created; ?></div>
        <div id="key4ce_tic_phone"><?php echo __("Priority", 'key4ce-osticket-bridge'); ?>:</div>
        <div id="key4ce_tic_phone_info"><?php
			if($keyost_version==194)
			{
			if ($ticketinfo->priority == '4') {
                echo '<div style="color: Red;"><strong>'.__("Emergency", 'key4ce-osticket-bridge').'</strong></div>';
            } elseif ($ticketinfo->priority == '3') {
                echo '<div style="color: Orange;"><strong>'.__("High", 'key4ce-osticket-bridge').'</strong></div>';
            } elseif ($ticketinfo->priority == '2') {
                echo '<div style="color: Green;"><strong>'.__("Normal", 'key4ce-osticket-bridge').'</strong></div>';
            } elseif ($ticketinfo->priority == '1') {
                echo '<div style="color: Black;">'.__("Low", 'key4ce-osticket-bridge').'</div>';
            } elseif ($ticketinfo->priority == '') {
                echo '<div style="color: Black;">'.__("Normal", 'key4ce-osticket-bridge').'</div>';
            }
			}
			else
			{
			if ($ticketinfo->priority_id == '4') {
                echo '<div style="color: Red;"><strong>'.__("Emergency", 'key4ce-osticket-bridge').'</strong></div>';
            } elseif ($ticketinfo->priority_id == '3') {
                echo '<div style="color: Orange;"><strong>'.__("High", 'key4ce-osticket-bridge').'</strong></div>';
            } elseif ($ticketinfo->priority_id == '2') {
                echo '<div style="color: Green;"><strong>'.__("Normal", 'key4ce-osticket-bridge').'</strong></div>';
            } elseif ($ticketinfo->priority_id == '1') {
                echo '<div style="color: Black;">'.__("Low", 'key4ce-osticket-bridge').'</div>';
            } elseif ($ticketinfo->priority_id == '') {
                echo '<div style="color: Black;">'.__("Normal", 'key4ce-osticket-bridge').'</div>';
            }
			}
            
            ?>
        </div>
        <div style="clear: both"></div>
    </div>
    <div id="key4ce_tic_sub">
        <div id="key4ce_tic_subject"><?php echo __("Subject", 'key4ce-osticket-bridge'); ?>:</div>
        <div id="key4ce_tic_subject_info"><strong><?php echo @Format::stripslashes($ticketinfo->subject); ?></strong></div>
        <div style="clear: both"></div>
    </div>
    <div id="key4ce_tic_thread_img_box">
        <div><span class="key4ce_Icon key4ce_thread"><?php echo __("Ticket Thread", 'key4ce-osticket-bridge'); ?></span></div>
        <div style="clear: both"></div>
    </div>
    <div id="key4ce_thContainer">
        <div id="key4ce_ticketThread">
    <?php
    foreach ($threadinfo as $thread_info) {
        $file_ids = $ost_wpdb->get_results("SELECT file_id from $ost_ticket_attachment WHERE `ref_id` ='$thread_info->id'");
        ?>
                <table style="width:100%; border: 1px solid #aaa; border-bottom: 2px solid #aaa;" cellspacing="0" cellpadding="1" border="0" class="<?php echo $thread_info->thread_type; ?>">
                    <tbody>
                        <tr>
                            <th><?php echo $thread_info->created; ?><span id="key4ce_ticketThread"><?php if ($hidename == 1 && $thread_info->thread_type <> "M") {
            echo $ticketinfo->dept_name;
        } else {
            echo $thread_info->poster;
        } ?></span></th>
                        </tr>
                        <tr>
                            <td><?php echo $thread_info->body; ?></td>
                        </tr>
                        <tr>
                            <td>
                                <?php
                                if (count($file_ids) > 0) {
                                    foreach ($file_ids as $file_id) {
                                        $filedetails = $ost_wpdb->get_row("SELECT * FROM `$ost_file` WHERE `id` =" . $file_id->file_id);
                                        ?>
                                        <form action="<?php echo WP_PLUGIN_URL; ?>/key4ce-osticket-bridge/lib/attachment/download.php" method="post" style="float: left;">
                                            <input type="hidden" name="service" value="download"/>
                                            <input type="hidden" name="ticket" value="<?php echo $ticketinfo->number; ?>"/>
                                            <input type="hidden" name="key" value="<?php echo $filedetails->key; ?>"/>
                                            <input type="hidden" name="id" value="<?php echo $filedetails->id; ?>"/>
                                            <input type="hidden" name="type" value="<?php echo $filedetails->type; ?>"/>
                                            <input type="hidden" name="name" value="<?php echo $filedetails->name; ?>"/>
                                            <input type="hidden" name="h" value="<?php echo session_id(); ?>"/>
<input type="hidden" name="filepath" value="<?php echo key4ce_getKeyValue('uploadpath'); ?>"/>
                                            <span class="key4ce_Icon key4ce_attachment"></span><input type="submit" name="download" value="<?php echo $filedetails->name; ?>">
                                        </form>
                                        <?php
                                    }
                                }
                                ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
    <?php } ?>
            <div style="clear: both"></div>
        </div>
        <div id="key4ce_tic_post">
            <div id="key4ce_tic_post_reply"><?php echo __("Post a Reply", 'key4ce-osticket-bridge'); ?></div>
            <div id="key4ce_tic_post_detail"><?php echo __("To best assist you, please be specific and detailed in your reply.", 'key4ce-osticket-bridge'); ?></div>
            <div style="clear: both"></div>
        </div>
        <?php
        $id_ademail = $ost_wpdb->get_var("SELECT id FROM $config_table WHERE $config_table.key like ('%admin_email%');");
        $os_admin_email = $ost_wpdb->get_row("SELECT id,namespace,$config_table.key,$config_table.value,updated FROM $config_table where id = $id_ademail");
        $os_admin_email_admin = $os_admin_email->value;
        ?><form id="reply" action="" name="reply" method="post" enctype="multipart/form-data" onsubmit="return validateFormReply()">
        <table class="key4ce_welcome key4ce_nobd" align="left" width="95%" cellspacing="0" cellpadding="3">            
                <tr>
                    <td class="key4ce_nobd" align="center">
                        <input type="hidden" value="<?php echo $thread_info->ticket_id; ?>" name="tic_id">
                        <input type="hidden" value="reply" name="a">
                        <input type="hidden" name="usticketid" value="<?php echo $ticketinfo->number; ?>"/>
                        <input type="hidden" name="usid" value="<?php echo $current_user->ID; ?>"/>
                        <input type="hidden" name="usname" value="<?php echo $ticketinfo->name; ?>"/>
                        <input type="hidden" name="usemail" value="<?php echo $ticketinfo->address; ?>"/>
                        <input type="hidden" name="usdepartment" value="<?php echo $ticketinfo->dept_name; ?>"/>
                        <input type="hidden" name="uscategories" value="<?php echo $ticketinfo->topic; ?>"/>
                        <input type="hidden" name="ussubject" value="<?php echo $ticketinfo->subject; ?>"/>
                        <input type="hidden" name="ustopicid" value="<?php echo $ticketinfo->topic_id; ?>"/>
                        <input type="hidden" name="ademail" value="<?php echo $os_admin_email_admin; ?>"/>
                        <input type="hidden" name="stitle" value="<?php echo $title_name; ?>"/>
                        <input type="hidden" name="sdirna" value="<?php echo $dirname; ?>"/>
                        <input type="hidden" name="postconfirmtemp" value="<?php echo $postconfirm; ?>"/>
                <center>
                    <?php
                    $content = '';
                    $editor_id = 'message';
                    $settings = array('media_buttons' => false);
                    wp_editor($content, $editor_id, $settings);
                    ?></center>
                </td>
                </tr>
    <?php 
if (key4ce_getKeyValue('allow_attachments') == 1) {
	if(key4ce_getPluginValue('Attachments on the filesystem')==1)
	{
        ?>
            <tr><td>
                    <div id="addinput">
                        <p>
                            <span style="color:#000;"><?php echo __("Attachment", 'key4ce-osticket-bridge'); ?> 1:</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="file" id="p_new" name="file[]" onchange="return checkFile(this);"/>&nbsp;&nbsp;&nbsp;<a href="#" id="addNew"><?php echo __("Add", 'key4ce-osticket-bridge'); ?></a>&nbsp;&nbsp;&nbsp;<span style="color: red;font-size: 11px;"><?php echo __("Max file upload size :", 'key4ce-osticket-bridge'); ?><?php echo (key4ce_getKeyValue('max_file_size') * .0009765625) * .0009765625; ?>MB</span>
                        </p>
                    </div>
                </td></tr>
    <?php } else
	{
	?>
	 <tr><td><?php echo __("Attachments on the Filesystem plugin can be downloaded here :", 'key4ce-osticket-bridge'); ?><a href="http://osticket.com/download/go?dl=plugin%2Fstorage-fs.phar" title="Attachement Filesystem Plugin" target="_blank"><?php echo __("Attachement Filesystem Plugin", 'key4ce-osticket-bridge'); ?></a></td></tr>
	<?php
	}
	}
	?>
                <tr>
                    <td class="key4ce_nobd" align="center"><div class="key4ce_clear" style="padding: 5px;"></div>
                        <?php
                        if ($ticketinfo->status == 'closed') {
                            echo '<center><label><input type="checkbox" name="open_ticket_status" id="open_ticket_status" value="open" checked>&nbsp;&nbsp;<font color=green>'.__("Reopen", 'key4ce-osticket-bridge').'</font>'.__("Ticket On Reply", 'key4ce-osticket-bridge').'</label></center>';
                        } elseif ($ticketinfo->status == 'open') {
							if($keyost_usercloseticket==1)
                            echo '<center><label><input type="checkbox" name="close_ticket_status" id="close_ticket_status" value="closed">&nbsp;&nbsp;<font color=red>'.__("Close", 'key4ce-osticket-bridge').'</font>'.__("Ticket On Reply", 'key4ce-osticket-bridge').'</label></center>';
                        }
                        ?>
                        <div class="key4ce_clear" style="padding: 5px;"></div></td>
                </tr>
                <tr>
                    <td class="key4ce_nobd" align="center">
                <center><input type="submit" value="<?php echo __("Post Reply", 'key4ce-osticket-bridge'); ?>" name="post-reply"/>
                    &nbsp;&nbsp;<input type="reset" value="<?php echo __("Reset", 'key4ce-osticket-bridge'); ?>"/>&nbsp;&nbsp;
                    <input type="button" value="<?php echo __("Cancel", 'key4ce-osticket-bridge'); ?>" onClick="history.go(-1)"/></center>
                </td>
                </tr>            
        </table>
            </form>
        <div style="clear: both"></div>
    </div>
    <div class="clear" style="padding: 10px;"></div>
<?php } else { ?>
    <div style="width: 100%; margin: 20px; font-size: 20px;" align="center"><?php echo __("No such ticket available.", 'key4ce-osticket-bridge'); ?></div> <?php } ?>