<?php
class Format {
    function linkslash($str){
	global $ost_wpdb;
	$str = preg_replace("~[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]~", "", $str);
	//remove backslashes
	while(strchr($str,'\\')) {
        $str = stripslashes($str);
	}
	return $str;
	}
    function stripslashes($str){
	global $ost_wpdb;
	//remove backslashes
	while(strchr($str,'\\')) {
        $str = stripslashes($str);
	}
	return $str;
	} 
}

function generateID()
{
	global $ost_wpdb,$ticket_table;
	$id=mt_rand(100000, 999999);
	$checkUserID = $ost_wpdb->get_results("SELECT ticketID from $ticket_table WHERE ticketID = '$id'");
	if(count($checkUserID)>0)
	{
	return generateID();
	}
	return $id;
}
function truncate($string, $max = 50, $replacement = '')
{
    if (strlen($string) <= $max)
    {
        return $string;
    }
    $leave = $max - strlen ($replacement);
    return substr_replace($string, $replacement, $leave);
}
function getKeyValue($key)
{
	global $ost_wpdb;
	$getKeyvalue=$ost_wpdb->get_row("SELECT value FROM `ost_config` WHERE `key` LIKE '$key'");	
	return $getKeyvalue->value;
}
?>
