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
	$id=mt_rand(100000, 999999);	
	$config = get_option('os_ticket_config');
	extract($config);
	$ost_wpdb = new wpdb($username, $password, $database, $host);	
	$count_no=$ost_wpdb->get_var("SELECT count(*) as count from ".$keyost_prefix."ticket WHERE number = '$id'");
	if($count_no > 0)
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
	$config = get_option('os_ticket_config');
	extract($config);
	$ost_wpdb = new wpdb($username, $password, $database, $host);	
	$getKeyvalue=$ost_wpdb->get_var("SELECT value FROM ".$keyost_prefix."config WHERE `key` LIKE '$key'");
	return $getKeyvalue;
}
function getPluginValue($plugin)
{	
	$config = get_option('os_ticket_config');
	extract($config);
	$ost_wpdb = new wpdb($username, $password, $database, $host);	
	$getPluginValue=$ost_wpdb->get_var("SELECT isactive FROM ".$keyost_prefix."plugin WHERE `name` = '$plugin' AND isphar='1'");
	return $getPluginValue;
}
function wpetss_forum_text($text){
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
function generateHashKey($length = 10) {
    $characters = '-0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}
function generateHashSignature($length = 10) {
    $characters = '-0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}
function getUserEmail($id)
{	
	$config = get_option('os_ticket_config');
	extract($config);
	$ost_wpdb = new wpdb($username, $password, $database, $host);	
	$getUserEmail=$ost_wpdb->get_var("SELECT address FROM ".$keyost_prefix."user_email WHERE `id` = '$id'");
	return $getUserEmail;
}
?>
