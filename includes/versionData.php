<?php
$topic_opt = $ost_wpdb->get_results("SELECT topic_id,dept_id, topic FROM $topic_table");
$pri_opt = $ost_wpdb->get_results("SELECT priority_desc,priority_id FROM $priority_table");
$dept_opt = $ost_wpdb->get_results("SELECT dept_name,dept_id FROM $dept_table where ispublic=1");
require_once( WP_PLUGIN_DIR . '/key4ce-osticket-bridge/includes/database.php' ); 
?>
