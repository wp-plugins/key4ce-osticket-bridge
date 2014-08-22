<?php
$config = get_option('os_ticket_config');
extract($config);  
	echo "<input type='hidden' name='afterticket' id='afterticket' value='".get_permalink($thankyoupage)."'>";	
?>
<?php wp_enqueue_script('ost-bridge-fade',plugins_url('../js/validate.js',__FILE__));?>
