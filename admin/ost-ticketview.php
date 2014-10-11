<?php
require_once( WP_PLUGIN_DIR . '/key4ce-osticket-bridge/includes/functions.php' );
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
        var MaxFileInputs = <?php echo getKeyValue('max_staff_file_uploads'); ?>;
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
<div class="wrap">
    <div class="headtitle">Reply to Support Request</div>
    <div style="clear: both"></div>
    <?php
    require_once( WP_PLUGIN_DIR . '/key4ce-osticket-bridge/admin/db-settings.php');
    require_once( WP_PLUGIN_DIR . '/key4ce-osticket-bridge/admin/header_nav_ticket.php');
    ?>
    <div id="ticket_view">
        <div id="tic_number">Ticket ID #<?php echo $ticketinfo->number; ?></div>
        <div id="tic_icon"><a href="admin.php?page=ost-tickets&service=view&ticket=<?php echo $ticketinfo->number; ?>" title="Reload"><span class="Icon refresh"></span></a><span class="preply">&darr; <a href="#post">Post Reply</a></span></div>
        <div style="clear: both"></div>
    </div>
    <div id="tic_info_box">
        <table>
            <tr> 
                <td><b>Ticket Status:</b></td>
                <td><div>
                        <?php
                        if ($ticketinfo->status == 'closed') {
                            echo '<font color=red>Closed</font>';
                        } elseif ($ticketinfo->status == 'open' && $ticketinfo->isanswered == '0') {
                            echo '<font color=green>Open</font>';
                        } elseif ($ticketinfo->status == 'open' && $ticketinfo->isanswered == '1') {
                            echo '<font color=orange>Answered</font>';
                        }
                        ?>
                    </div></td>
                <td><b>Username:</b></td>
                <td><div><?php echo $ticketinfo->name; ?></div></td>
            </tr>
            <tr> 
                <td><b>Department:</b></td>
                <td><div><?php echo $ticketinfo->dept_name; ?></div></td>
                <td><b>User Email:</b></td>
                <td><div><?php echo $ticketinfo->address; ?></div></td>
            </tr>
            <tr> 
                <td><b>Date Create:</b></td>
                <td><div><?php echo $ticketinfo->created; ?></div></td>
                <td><b>Priority:</b></td>
                <td> 
                    <div><?php
                        if ($ticketinfo->priority_id == '4') {
                            echo '<div style="color: Red;"><strong>Emergency</strong></div>';
                        } elseif ($ticketinfo->priority_id == '3') {
                            echo '<div style="color: Orange;"><strong>High</strong></div>';
                        } elseif ($ticketinfo->priority_id == '2') {
                            echo '<div style="color: Green;"><strong>Normal</strong></div>';
                        } elseif ($ticketinfo->priority_id == '1') {
                            echo '<div style="color: Black;">Low</div>';
                        } elseif ($ticketinfo->priority_id == '') {
                            echo '<div style="color: Black;">Normal</div>';
                        }
                        ?>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    <div style="clear: both"></div>
    <div id="tic_sub">
        <div id="tic_subject">Subject:</div>
        <div id="tic_subject_info"><?php echo $ticketinfo->subject; ?></div>
        <div style="clear: both"></div>
    </div>
    <div id="tic_thread_img_box">
        <div><span class="Icon thread">Ticket Thread</span></div>
        <div style="clear: both"></div>
    </div>
    <div id="ticketThread">
<?php
foreach ($threadinfo as $thread_info) {
   $file_ids=$ost_wpdb->get_results("SELECT file_id from $ost_ticket_attachment WHERE `ref_id` ='$thread_info->id'");
    ?>
            <table width="100%" style="width: 95%; margin: 10px 20px 10px 20px; border: 1px solid #aaa; border-bottom: 2px solid #aaa;" class="<?php echo $thread_info->thread_type; ?>">
                <tbody>
                    <tr>
                        <th><?php echo $thread_info->created; ?><span><?php echo $thread_info->poster; //if($hidename==1) { echo $thread_info->poster; } ?></span></th>
                    </tr>
                    <tr>
                        <td><?php echo $thread_info->body; ?></td>
                    </tr>
    <tr>
<td>
<?php if(count($file_ids)>0)
{
	foreach($file_ids as $file_id)
	{		
		$filedetails=$ost_wpdb->get_row("SELECT * FROM `$ost_file` WHERE `id` =".$file_id->file_id);		
 ?>
<form action="<?php echo WP_PLUGIN_URL ; ?>/key4ce-osticket-bridge/lib/attachment/download.php" method="post" style="float: left;">
<input type="hidden" name="service" value="download"/>
<input type="hidden" name="ticket" value="<?php echo $ticketinfo->number; ?>"/>
<input type="hidden" name="key" value="<?php echo $filedetails->key; ?>"/>
<input type="hidden" name="id" value="<?php echo $filedetails->id; ?>"/>
<input type="hidden" name="type" value="<?php echo $filedetails->type; ?>"/>
<input type="hidden" name="name" value="<?php echo $filedetails->name; ?>"/>
<input type="hidden" name="h" value="<?php echo session_id(); ?>"/>
<input type="hidden" name="filepath" value="<?php echo getKeyValue('uploadpath'); ?>"/>
<span class="Icon attachment"></span><input type="submit" name="download" value="<?php echo $filedetails->name; ?>">
</form>
<?php 
	}
 } ?>
</td>
</tr>
                </tbody>
            </table>
                <?php } ?>
        <div style="clear: both"></div>
    </div>
    <div id="tic_post">
        <div id="tic_post_reply">Post a Reply</div>
        <div style="clear: both"></div>
    </div>
    <form name="ost-post-reply" id="ost-reply" action="admin.php?page=ost-tickets&service=view&ticket=<?php echo $ticketinfo->number; ?>" method="post" enctype="multipart/form-data">
    <table align="center" width="95%" cellspacing="0" cellpadding="3" border="0">
        <tr>
            <td align="center">       
                    <input type="hidden" value="<?php echo $thread_info->ticket_id; ?>" name="tic_id">
                    <input type="hidden" value="reply" name="a">
                    <input type="hidden" name="usticketid" value="<?php echo $ticketinfo->number; ?>"/>
                    <input type="hidden" name="usname" value="<?php echo $ticketinfo->name; ?>"/>
                    <input type="hidden" name="usemail" value="<?php echo $ticketinfo->address; ?>"/>
                    <input type="hidden" name="usdepartment" value="<?php echo $ticketinfo->dept_name; ?>"/>
                    <input type="hidden" name="uscategories" value="<?php echo $ticketinfo->topic; ?>"/>
                    <input type="hidden" name="ussubject" value="<?php echo $ticketinfo->subject; ?>"/>
                    <input type="hidden" name="ustopicid" value="<?php //echo $ticketinfo->topic_id; ?>"/>
                    <input type="hidden" name="ademail" value="<?php echo $os_admin_email; ?>"/>
                    <input type="hidden" name="adname" value="<?php echo $admin_fname; ?> <?php echo $admin_lname; ?>"/>
                    <input type="hidden" name="stitle" value="<?php echo $title_name; ?>"/>
                    <input type="hidden" name="sdirna" value="<?php echo $dirname; ?>"/>
                    <input type="hidden" name="adreply" value="<?php echo $adminreply; ?>"/>
                  
            </td>
        </tr>
                 <?php
                $content = '';
                $editor_id = 'message';
                $settings = array('media_buttons' => false);
                wp_editor($content, $editor_id, $settings);
                ?>
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
            <td align="center">
        <?php
        if ($ticketinfo->status == 'closed') {
            echo '<center><label><input type="checkbox" name="open_ticket_status" id="open_ticket_status" value="open" checked>&nbsp;&nbsp;<font color=green>Reopen</font> Ticket On Reply</label></center>';
        } elseif ($ticketinfo->status == 'open') {
            echo '<center><label><input type="checkbox" name="close_ticket_status" id="close_ticket_status" value="closed">&nbsp;&nbsp;<font color=red>Close</font> Ticket On Reply</label></center>';
        }
        ?>
            </td>
        </tr>
        <tr>
            <td align="center">
       <label><input type="radio" name="signature" value="mine" checked>&nbsp;&nbsp; My signature</label>
            <label><input type="radio" name="signature" value="dept">&nbsp;&nbsp; Dept. Signature (<?php echo $ticketinfo->dept_name; ?>)</label>
        </td>
        </tr>
        <tr>
            <td align="center">        
            <input type="submit" name="ost-post-reply" value="Post Reply" class="button-primary" />&nbsp;&nbsp;
            <input type="button" value="Cancel - Go Back" class="button-primary" onClick="history.go(-1)"/>               
        </td>
        </tr>
    </table>
        </form>
</div><!--End wrap-->
<?php wp_enqueue_script('ost-bridge-fade', plugins_url('../js/fade.js', __FILE__)); ?>
