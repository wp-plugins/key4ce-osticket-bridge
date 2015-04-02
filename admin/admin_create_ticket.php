<?php
/* Template Name: admin-create-ticket.php */
require_once( WP_PLUGIN_DIR . '/key4ce-osticket-bridge/admin/db-settings.php');
require_once( WP_PLUGIN_DIR . '/key4ce-osticket-bridge/includes/functions.php'); 
$dept_opt = $ost_wpdb->get_results("SELECT dept_name,dept_id FROM $dept_table where ispublic=1");
wp_enqueue_script('ost-bridge-validate',plugins_url('../js/validate.js', __FILE__));

// Start File system changes
$fileconfig=key4ce_FileConfigValue();
$filedata=json_decode($fileconfig);
if($keyost_version==193)
{
$attachement_status=key4ce_getKeyValue('allow_attachments');
$max_user_file_uploads=key4ce_getKeyValue('max_user_file_uploads');
$agent_max_file_size=key4ce_getKeyValue('max_staff_file_uploads');
$fileextesnions=key4ce_getKeyValue('allowed_filetypes');
}
else
{
$attachement_status=$filedata->attachments;
$max_user_file_uploads=$filedata->max;
$agent_max_file_size=key4ce_getKeyValue('max_file_size');
$fileextesnions=$filedata->extensions;
}	
// End file system changes

$alowaray = explode(".",str_replace(' ', '',$fileextesnions));
$strplc = str_replace(".", "",str_replace(' ', '',$fileextesnions));
$allowedExts = explode(",", $strplc);
function add_quotes($str) {
    return sprintf("'%s'", $str);
}
$extimp = implode(',', array_map('add_quotes', $allowedExts));
$finalary = "'" . $extimp . "'";
?>
<?php 
$args = array(
	'blog_id'      => $GLOBALS['blog_id'],
	'role'         => '',
	'meta_key'     => '',
	'meta_value'   => '',
	'meta_compare' => '',
	'meta_query'   => array(),
	'include'      => array(),
	'exclude'      => array(),
	'orderby'      => 'login',
	'order'        => 'ASC',
	'offset'       => '',
	'search'       => '',
	'number'       => '',
	'count_total'  => false,
	'fields'       => 'all',
	'who'          => ''
 );

global $wpdb;
$WPusersData=$wpdb->get_results("SELECT user_nicename,user_email FROM ".$wpdb->prefix."users",ARRAY_A);
$wpusers=json_encode($WPusersData);

$OsticketUsersData=$ost_wpdb->get_results("SELECT name,address FROM ".$keyost_prefix."user usr INNER JOIN " . $keyost_prefix . "user_email usremail ON usremail.id=usr.default_email_id",ARRAY_A);
$osticketusers=json_encode($OsticketUsersData);
?>
<script language="javascript" src="<?php echo plugin_dir_url(__FILE__) . '../js/jquery.js'; ?>"></script>
<script language="javascript" src="<?php echo plugin_dir_url(__FILE__) . '../js/jquery.autocomplete.js'; ?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo plugin_dir_url(__FILE__) . '../css/jquery.autocomplete.css'; ?>" />
<script>
$(document).ready(function(){
//WP Users Data
var wpusers = <?php echo $wpusers; ?>;
$("#wpusers").autocomplete(wpusers, {
  formatItem: function(item) {
    //return item.name;
    return item.user_nicename;	
  }
}).result(function(event, item) {
  //document.getElementById('email').value=item.address;
	document.getElementById('email').value=item.user_email;
});

//OSticket Users Data
var osticketusers = <?php echo $osticketusers; ?>;
$("#osticketusers").autocomplete(osticketusers, {
  formatItem: function(item) {
    return item.name;
    //return item.user_nicename;	
  }
}).result(function(event, item) {
  document.getElementById('email').value=item.address;
	//document.getElementById('email').value=item.user_email;
});
});
</script>
<script language="javascript" src="<?php echo plugin_dir_url(__FILE__) . '../js/jquery_1_7_2.js'; ?>"></script>
<script type="text/javascript">
var j=jQuery.noConflict();
    j(function() {
        var addDiv = j('#addinput');
        var i = j('#addinput p').size() + 1;
        var MaxFileInputs = <?php echo $agent_max_file_size; ?>;
        j('#addNew').live('click', function() {
            if (i <= MaxFileInputs)
            {
                j('<p><span style="color:#000;"><?php echo __("Attachment", 'key4ce-osticket-bridge'); ?>' + i + ':</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="file" id="p_new_' + i + '" name="file[]" onchange="return checkFile(this);"/>&nbsp;&nbsp;&nbsp;<a href="#" id="remNew"><?php echo __("Remove", 'key4ce-osticket-bridge'); ?></a>&nbsp;&nbsp;&nbsp;<span style="color: red;font-size: 11px;">Max file upload size : <?php echo ($agent_max_file_size * .0009765625) * .0009765625; ?>MB</span></p>').appendTo(addDiv);
                i++;
            }
            else
            {
                alert("<?php echo __("You have exceeds your file upload limit", 'key4ce-osticket-bridge'); ?>");
                return false;
            }
            return false;
        });

        j('#remNew').live('click', function() {
            if (i > 2) {
                j(this).parents('p').remove();
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
        if ((FileSize > <?php echo $agent_max_file_size; ?>))
        {
            alert("<?php echo __("Please make sure your file is less than", 'key4ce-osticket-bridge'); ?> <?php echo ($agent_max_file_size * .0009765625) * .0009765625; ?>MB.");
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
$(document).ready(function() {
   $('input[type="radio"]').click(function() {
       if($(this).attr('id') == 'radio1')
	   {
	      document.getElementById('email').value="";
		  $("#email").attr('readonly','readonly');
                  $('#new_ticket_name_wpuser').css("display", "block");
		  $('#new_ticket_name_osticketuser').css("display", "none");
		  $('#new_ticket_name_username').css("display", "none");
		  //$( "#addusername" ).empty();
		  //$( "#addusername" ).append("WP Username: <input name='username' type='text' id='wpusers' size='20' />");
	   }
	   else if($(this).attr('id') == 'radio2')
	   {
	    document.getElementById('email').value="";
		  $("#email").attr('readonly','readonly');
                  $('#new_ticket_name_wpuser').css("display", "none");
		  $('#new_ticket_name_osticketuser').css("display", "block");
		  $('#new_ticket_name_username').css("display", "none");
		  //$( "#addusername" ).empty();
		  //$('#addusername').append("Osticket Username: <input name='username' type='text' id='osticketusers' size='20' />");
	   }
	   else if($(this).attr('id') == 'radio3')
	   {
		   document.getElementById('email').value="";	
		    $("#email").removeAttr('readonly','readonly');
		  $('#new_ticket_name_wpuser').css("display", "none");
           $('#new_ticket_name_osticketuser').css("display", "none");	
		  $('#new_ticket_name_username').css("display", "block");
		  //$( "#addusername" ).empty();
		  //$('#addusername').append("Username: <input name='username' type='text' id='username' size='20' />");
	   }
   });
});
</script>

<style>
    #key4ce_wp-message-wrap{border:2px solid #CCCCCC;border-radius: 5px;padding: 5px;width: 75%;}
    #key4ce_message-html{height: 25px;}
    #key4ce_message-tmce{height: 25px;}
    #new_ticket_name_wpuser,#new_ticket_name_osticketuser,#new_ticket_name_username {display:none;}
    #element{float: left;margin-top: 10px;}
    .selectusertype{ float: left;margin-top: 10px;width: 175px;color:#000;font-weight:normal;}
    .usertype{color: #000;float: left;font-weight: normal;margin-top: 8px;width: 175px;}
</style>
<div id="key4ce_thContainer">
    <div id="key4ce_new_ticket">
        <div id="key4ce_new_ticket_text1" style="  margin-bottom: 10px;margin-top: 15px;"><?php echo __("Create A New Ticket", 'key4ce-osticket-bridge'); ?></div>
        <div style="clear: both"></div>
        <div id="new_ticket_text2"><?php echo __("Please fill in the form below to open a new ticket. All fields mark with [<font color=red>*</font>] <em>Are Required!", 'key4ce-osticket-bridge'); ?></em></div>
        <div style="clear: both"></div>
        <form id="key4ce_ticketForm" name="newticket" method="post" enctype="multipart/form-data" onsubmit="return validateFormNewTicket();">
            
			<input type="hidden" name="usid" value="<?php //echo $user_id;  ?>"/>
            <input type="hidden" name="ademail" value="<?php //echo $os_admin_email; ?>"/>
            <input type="hidden" name="stitle" value="<?php //echo $title_name; ?>"/>
            <input type="hidden" name="sdirna" value="<?php //echo $dirname; ?>"/>
            <input type="hidden" name="newtickettemp" value="<?php //echo $newticket; ?>"/>
			<div class="selectusertype"><?php echo __("Select User Type :", 'key4ce-osticket-bridge'); ?></div>
			<div id="element">
			<span style="font-weight: bold;"><?php echo __("WP Users", 'key4ce-osticket-bridge'); ?></span><input type="radio" name="radio" value="radio1" id="radio1">
			<span style="font-weight: bold;"><?php echo __("Osticket Users", 'key4ce-osticket-bridge'); ?></span><input type="radio" name="radio" value="radio2" id="radio2">
			<span style="font-weight: bold;"><?php echo __("Username", 'key4ce-osticket-bridge'); ?></span><input type="radio" name="radio" value="radio3" id="radio3">
			</div>
			<div style="clear: both"></div>
            <div id="new_ticket_name_wpuser" style="font-weight: bold;margin-top: 8px;"><span class="usertype"><?php echo __("WP Username", 'key4ce-osticket-bridge'); ?>:</span><input name="username" type="text" id="wpusers" size="20"/></div>
			<div id="new_ticket_name_osticketuser" style="font-weight: bold;margin-top: 8px;"><span class="usertype"><?php echo __("Osticket Username", 'key4ce-osticket-bridge'); ?>:</span><input name="username" type="text" id="osticketusers" size="20"/></div>
			<div id="new_ticket_name_username" style="font-weight: bold;margin-top: 8px;"><span class="usertype"><?php echo __("Username", 'key4ce-osticket-bridge'); ?>:</span><input name="username" type="text" id="username" size="20"/></div>
			
            <div style="clear: both"></div>
            <div id="key4ce_new_ticket_email"><?php echo __("Your Email", 'key4ce-osticket-bridge'); ?>:</div>
            <div id="key4ce_new_ticket_email_input"><input class="ost" id="email" type="text" name="email"></div>
            <div style="clear: both"></div>
            <div id="key4ce_new_ticket_subject"><?php echo __("Subject", 'key4ce-osticket-bridge'); ?>:</div>
            <div id="key4ce_new_ticket_subject_input"><input class="ost" id="subject" type="text" name="subject" size="35"/><font class="error">&nbsp;*</font></div>
            <div style="clear: both"></div>
            <div id="key4ce_new_ticket_catagory"><?php echo __("Catagories", 'key4ce-osticket-bridge'); ?>:</div>
            <div id="key4ce_new_ticket_catagory_input">
                <select id="deptId" name="deptId">
                    <option value="" selected="selected"><?php echo __("Select a Category", 'key4ce-osticket-bridge'); ?></option>
                    <?php
                    foreach ($dept_opt as $dept) {
                        echo '<option value="' . $dept->dept_id . '">' . $dept->dept_name . '</option>';
                    }
                    ?>
                </select><font class="error">&nbsp;*</font></div>
            <div style="clear: both"></div>
            <div id="key4ce_new_ticket_priority"><?php echo __("Priority", 'key4ce-osticket-bridge'); ?>:</div>
            <div id="key4ce_new_ticket_priority_input"><select id="key4ce_priority" name="priorityId">
                    <option value="" selected="selected"><?php echo __("Select a Priority", 'key4ce-osticket-bridge'); ?></option>
                    <?php
                    foreach ($pri_opt as $priority) {
                        echo '<option value="' . $priority->priority_id . '">' . $priority->priority_desc . '</option>';
                    }
                    ?>
                </select><font class="key4ce_error">&nbsp;*</font></div>
            <div style="clear: both"></div>
    
    <table class="key4ce_welcome key4ce_nobd" align="center" width="95%" cellpadding="3" cellspacing="3" border="0">
        <tr>
            <td class="key4ce_nobd" align="center"><div align="center" style="padding-bottom: 5px;"><?php echo __("To best assist you, please be specific and detailed in your message *", 'key4ce-osticket-bridge'); ?><font class="error">&nbsp;*</font></div></td>
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
                            <span style="color:#000;"><?php echo __("Attachment 1:", 'key4ce-osticket-bridge'); ?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="file" id="p_new" name="file[]" onchange="return checkFile(this);"/>&nbsp;&nbsp;&nbsp;<a href="#" id="addNew"><?php echo __("Add", 'key4ce-osticket-bridge'); ?></a>&nbsp;&nbsp;&nbsp;<span style="color: red;font-size: 11px;"><?php echo __("Max file upload size :", 'key4ce-osticket-bridge'); ?><?php echo ($agent_max_file_size * .0009765625) * .0009765625; ?>MB</span>
                        </p>
                    </div>
                </td></tr>
    <?php } else
	{
	?>
	 <tr><td><?php echo __("Attachments on the Filesystem plugin can be downloaded here:", 'key4ce-osticket-bridge'); ?><a href="http://osticket.com/download/go?dl=plugin%2Fstorage-fs.phar" title="Attachement Filesystem Plugin" target="_blank"><?php echo __("Attachement Filesystem Plugin", 'key4ce-osticket-bridge'); ?></a></td></tr>
	<?php
	}
	}
	?>
        <tr>
            <td class="key4ce_nobd" align="center">
                <p align="center" style="padding-top: 5px;"><input type="submit" name="create-admin-ticket" value="<?php echo __('Create Ticket', 'key4ce-osticket-bridge'); ?>">
                    &nbsp;&nbsp;<input type="reset" value="<?php echo __('Reset', 'key4ce-osticket-bridge'); ?>"></p>
            </td>
        </tr>
    </table></form>
    </div>
