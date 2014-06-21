<?php
/*
Template Name: pagination.php
*/
?>
<div id="list_pagination">
<?php 
$params = array_merge($_GET, array("currentpage" => "1")); 
$new_query_string = http_build_query($params); 
if ($currentpage > 1) { 
echo " <a href='?".$new_query_string."'><<</a> "; 
$prevpage = $currentpage - 1; 
$params = array_merge($_GET, array("currentpage" => $prevpage )); 
$new_query_string = http_build_query($params); 
echo " <a href='?".$new_query_string."'><</a> "; 
} 
$range = 3; 
for ($x = ($currentpage - $range); $x < (($currentpage + $range)  + 1); $x++) { 
if (($x > 0) && ($x <= $totalpages)) { 
if ($x == $currentpage) { 
echo "($x)"; } else { 
$params = array_merge($_GET, array("currentpage" => $x)); 
$new_query_string = http_build_query($params); 
echo " <a href='?".$new_query_string."'>$x</a> ";} 
} } 
if($totalpages>0){ 
if ($currentpage != $totalpages) { 
$nextpage = $currentpage + 1; 
$params = array_merge($_GET, array("currentpage" => $nextpage)); 
$new_query_string = http_build_query($params); 
echo " <a href='?".$new_query_string."'>></a> "; 
$params = array_merge($_GET, array("currentpage" => $totalpages)); 
$new_query_string = http_build_query($params); 
echo " <a href='?".$new_query_string."'>>></a> "; 
} 
} 
?>
</div>