<?php
function output_file($file, $name, $mime_type='')
{
 if(!is_readable($file)) die('File not found or inaccessible!');
 $size = filesize($file);
 $name = rawurldecode($name); 
 /* Figure out the MIME type | Check in array */
 $known_mime_types=array(
 	"htm" => "text/html",
	"exe" => "application/octet-stream",
	"zip" => "application/zip",
	"bz2"=>"application/x-bzip2",
	"doc" => "application/msword",
	"jpg" => "image/jpg",
	"php" => "text/plain",
	"xls" => "application/vnd.ms-excel",
	"ppt" => "application/vnd.ms-powerpoint",
	"gif" => "image/gif",
	"pdf" => "application/pdf",
 	"txt" => "text/plain",
 	"html"=> "text/html",
 	"png" => "image/png",
	"jpeg"=> "image/jpg",
	"css"=>"text/css",
	"docx"=>"application/vnd.openxmlformats-officedocument.wordprocessingml.document",
	"pptx"=>"application/vnd.openxmlformats-officedocument.presentationml.presentation",
	"xlsx"=>"application/vnd.openxmlformats-officedocument.spreadsheetml.sheet ",
	"xml"=>"application/xml",
	"rft"=>"application/rtf",
	"mp3"=>"audio/mpeg",
	"mpeg"=>"video/mpeg",
	"ogg"=>"application/ogg",
	"bmp"=>"image/bmp",
 );
 
 if($mime_type==''){
	 $file_extension = strtolower(substr(strrchr($file,"."),1));
	 if(array_key_exists($file_extension, $known_mime_types)){
		$mime_type=$known_mime_types[$file_extension];
	 } else {
		$mime_type="application/force-download";
	 };
 };
 
 //turn off output buffering to decrease cpu usage
 @ob_end_clean(); 
 
 // required for IE, otherwise Content-Disposition may be ignored
 if(ini_get('zlib.output_compression'))
 ini_set('zlib.output_compression', 'Off');
 header('Content-Type: ' . $mime_type);
 header('Content-Disposition: attachment; filename="'.$name.'"');
 header("Content-Transfer-Encoding: binary");
 header('Accept-Ranges: bytes');
 
 // multipart-download and download resuming support
 if(isset($_SERVER['HTTP_RANGE']))
 {
	list($a, $range) = explode("=",$_SERVER['HTTP_RANGE'],2);
	list($range) = explode(",",$range,2);
	list($range, $range_end) = explode("-", $range);
	$range=intval($range);
	if(!$range_end) {
		$range_end=$size-1;
	} else {
		$range_end=intval($range_end);
	}

	$new_length = $range_end-$range+1;
	header("HTTP/1.1 206 Partial Content");
	header("Content-Length: $new_length");
	header("Content-Range: bytes $range-$range_end/$size");
 } else {
	$new_length=$size;
	header("Content-Length: ".$size);
 }
 
 /* Will output the file itself */
 $chunksize = 1*(1024*1024); //you may want to change this
 $bytes_send = 0;
 if ($file = fopen($file, 'r'))
 {
	if(isset($_SERVER['HTTP_RANGE']))
	fseek($file, $range);
 
	while(!feof($file) && 
		(!connection_aborted()) && 
		($bytes_send<$new_length)
	      )
	{
		$buffer = fread($file, $chunksize);
		echo($buffer); 
		flush();
		$bytes_send += strlen($buffer);
	}
 fclose($file);
 } else
 //If no permissiion
 die('Error - can not open file.');
 //die
die();
}
if(isset($_POST['h']) && $_POST['id']!="" && $_POST['service']=="download")
{
$fullfinalpath = $_POST['filepath'];
$dir_name = substr($_POST['key'], 0, 1);
$finalpath = $fullfinalpath . "/" . $dir_name."/".$_POST['key'];
output_file($finalpath, ''.$_POST['name'].'',$_POST['type']);
exit;
}
else
{
   if(isset($_SERVER['HTTPS'])){
        $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
    }
    else{
        $protocol = 'http';
    }
    $finalprotocol=$protocol . "://" . parse_url($_SERVER['SERVER_NAME'], PHP_URL_HOST);
    $home=$finalprotocol.$_SERVER['SERVER_NAME'];
	echo "Your not authorised to access this page directly.<br>Click here to go <a href=".$home.">home page</a>";	
}

?>
