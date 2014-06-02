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
function wpetss_forum_text($text){
	//$text = htmlspecialchars($text);

	// convert links
    $text = " ".$text;
    $text = preg_replace('#(((f|ht){1}tps?://)[-a-zA-Z0-9@:;%_\+.~\#?&//=\[\]]+)#i', '<a href="\\1" target=_blank>\\1</a>', $text);
    $text = preg_replace('#([[:space:]()[{}])(www.[-a-zA-Z0-9@:;%_\+.~\#?&//=]+)#i', '\\1<a href="http://\\2" target=_blank>\\2</a>', $text);
    $text = preg_replace('#([_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,3})#i', '<a href="mailto:\\1" target=_blank>\\1</a>', $text);

    $text = ltrim($text);

	$print_text = '';
	foreach(explode("\n",$text) as $line){
		$line = rtrim($line);
		$line = preg_replace("/\t/","&nbsp;&nbsp;&nbsp;",$line);
		if(preg_match('/^(\s+)/',$line,$matches)){
			$line = str_repeat("&nbsp;",strlen($matches[1])) . ltrim($line);
		}
		$print_text .= $line . "<br/>\n";
	}
	return $print_text;
}
?>
