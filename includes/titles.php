<?php 
function ost_wp_filter_wp_title( $title ) { 
	$parurl=$_SERVER['QUERY_STRING']; 
	if ( is_page_template( '' ) && ($parurl == 'service=new') ) { 
	echo bloginfo('name'); 
        return ' | Open A New Ticket'; } 
	
	if ( is_page_template( '' ) && ($parurl == 'service=list') ) { 
	echo bloginfo('name'); 
        return ' | Check Ticket Status'; } 
        
        if ( is_page_template( '' ) && ($parurl == 'service=list&status=open') ) { 
	echo bloginfo('name'); 
        return ' | Check Open Tickets'; } 
        
        if ( is_page_template( '' ) && ($parurl == 'service=list&status=closed') ) { 
	echo bloginfo('name'); 
        return ' | Check Closed Tickets'; } 
	
        else 
        { 
        return $title;
	} 
} 
add_filter( 'wp_title', 'ost_wp_filter_wp_title' );
?>