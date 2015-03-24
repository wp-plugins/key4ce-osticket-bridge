<?php
$config = get_option('os_ticket_config');
extract($config);
    echo "<div style=\"display: table; width: 100%;\">";
	echo "<div id='key4ce_search_ticket' style='display: table-row;'>"; 
	echo "<div id='key4ce_search_box' style='display: table-cell;'>";	       	  
	echo "</div>";     
	echo "<input type='hidden' name='afterticket' id='afterticket' value='".get_permalink($thankyoupage)."'>";	
	echo '</div>'; 
    echo '</div><hr style="border-color:#D5E5EE; border-width: 3px; height: 3px;">';
?>
<?php wp_enqueue_script('ost-bridge-fade',plugins_url('../js/validate.js',__FILE__));?>
